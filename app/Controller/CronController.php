<?php

App::uses('CakeEmail', 'Network/Email');

require_once ROOT.'/app/Lib/sdk-php-master/autoload.php';

class CronController extends AppController{

	public $name = "Cron";

	public $uses = array("CollegeSubscription","Subscription","CollegeCoach");

	public function beforeFilter(){
		parent::beforeFilter();

		$this->autoLayout = false;
		$this->autoRender = false;
	}

	public function index(){
		exit;
	}
	
	public function mondayCron(){
		$this->statsNeededAlert();
		
		$this->athleteNotification();
		
		$this->pendingApprovalAlert();
		
		$this->sendNeedAlert();
		
		echo "success";
		exit;
	}

	public function renewSubscription(){
		$today = date('Y-m-d H:i:s');
		$subscriptions = $this->CollegeSubscription->find("all",array("conditions"=>"CollegeSubscription.status = 1 AND CollegeSubscription.next_billdate <= '$today'"));

		foreach($subscriptions as $subscription){
			// attempts to charge the user for the subscription
			$transaction = new AuthorizeNetTransaction;
			$transaction->amount = $subscription['Subscription']['cost'];
			$transaction->customerProfileId = $subscription['CollegeSubscription']['transaction_id'];
			$transaction->customerPaymentProfileId = $subscription['CollegeSubscription']['payment_profile_id'];

			$request = new AuthorizeNetCIM;
			$response = $request->createCustomerProfileTransaction("AuthCapture",$transaction);

			$subscription_id = $subscription['CollegeSubscription']['subscription_id'];
			$user_id = $subscription['CollegeSubscription']['college_coach_id'];

			// if the transaction fails, cancel the subscription
			if($response->xml->messages->resultCode == 'Error') {
				$errorMessage = "Automatic renewal failed.".$response->xml->messages->message->code . ': ' .$response->xml->messages->message->text;

				$this->CollegeSubscription->updateAll(array("status"=>0,"cancel_date"=>date('Y-m-d'),"cancel_reason"=>"'".$errorMessage."'"),array("college_coach_id"=>$user_id,"CollegeSubscription.subscription_id"=>$subscription_id));
			}
			else{
				// gets the transaction ID to save in the subscription table
				$transactionResponse = $response->getTransactionResponse();
				$transactionId = $transactionResponse->transaction_id;

				//insert payment history
				$paymentHistory = array();
				$paymentHistory['college_coach_id'] = $user_id;
				$paymentHistory['transaction_id'] = $transactionId;
				$paymentHistory['profile_id'] = $transactionId;
				$paymentHistory['amount'] = $subscription['Subscription']['cost'];
				$paymentHistory['date_added'] = date('Y-m-d H:i:s');

				$this->loadModel('PaymentHistory');
				$this->PaymentHistory->save(array("PaymentHistory"=>$paymentHistory));

				$this->renewSubscriptionEmail($subscription['CollegeCoach']['first_name'],$subscription['CollegeCoach']['last_name'],$subscription['CollegeCoach']['email'],$transactionId);

				switch($subscription['Subscription']['period']){
					case '3-Year':
						$next_billdate = date('Y-m-d H:i:s',time()+(3*12*30*24*60*60));
						break;
					case 'Yearly':
						$next_billdate = date('Y-m-d H:i:s',time()+(12*30*24*60*60));
						break;
					default:
						$next_billdate = date('Y-m-d H:i:s',time()+(30*24*60*60));
						break;
				}

				$this->CollegeSubscription->id = $subscription['CollegeSubscription']['id'];
				$this->CollegeSubscription->saveField("next_billdate",$next_billdate);
			}
		}

		echo "success";
		exit;
	}

	private function renewSubscriptionEmail($first_name , $last_name , $email , $transaction_id){
		$subject = "College Prospect Network - Subscription Renewal";
		$template = 'renew_subscription_email';
		$cakeEmail = new CakeEmail('default');
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to($email);
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('first_name' => $first_name, 'last_name' => $last_name, 'transaction_id' => $transaction_id));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			//$this->Session->setFlash('Error while sending email');
		}
	}
	
	public function setAthletePoints(){
		$this->loadModel('Event');
		$this->loadModel('Mail');
		$this->loadModel('Network');
		$this->loadModel('Athlete');
		$this->loadModel('OpponentComment');
		$this->loadModel('ManagePoint');
	
		//adding_game_stat
		$conditions = "( (Event.start_date < now() AND Event.start_date >= DATE_SUB(now() , Interval 8 day)) OR (Event.end_date >= DATE_SUB(now() , Interval 8 day)) ) AND user_type = 'athlete'";
		$results = $this->Event->find("all",array("conditions"=>$conditions,"fields"=>"Event.username"));
		if($results){
			foreach($results as $result){
				$athleteInfo = $this->Athlete->getByUsername($result['Event']['username']);
				if($athleteInfo){
					$user_id = $athleteInfo['Athlete']['id'];
					$this->ManagePoint->setAtheleteRating($user_id , 'adding_game_stat' , 1 , 1);
				}
			}
		}
		
		//responding_to_emails
		$conditions = "(date(Mail.sent_date) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(Mail.sent_date)< (now())) AND usertype_to = 'athlete'";
		$results = $this->Mail->find("all",array("conditions"=>$conditions,"fields"=>"Mail.receiver"));
		if($results){
			foreach($results as $result){
				$athleteInfo = $this->Athlete->getByUsername($result['Mail']['receiver']);
				if($athleteInfo){
					$user_id = $athleteInfo['Athlete']['id'];
					$this->ManagePoint->setAtheleteRating($user_id , 'responding_to_emails' , 1 , 1);
				}
			}
		}
		
		//send_network_request
		$conditions = "(date(Network.date_added) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(Network.date_added)< (now())) and  sender_type ='athlete' and receiver_type ='college'";
		$results = $this->Network->find("all",array("conditions"=>$conditions,"fields"=>"Network.sender_id"));
		if($results){
			foreach($results as $result){
				if($result['Network']['sender_id']){
					$this->ManagePoint->setAtheleteRating($result['Network']['sender_id'] , 'send_network_request' , 1 , 1);
				}
			}
		}
		
		//responding_network_request
		$conditions = "(date(Network.modify_date) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(Network.modify_date)< (now())) AND receiver_type ='athlete' AND status ='Active'";
		$results = $this->Network->find("all",array("conditions"=>$conditions,"fields"=>"Network.receiver_id"));
		if($results){
			foreach($results as $result){
				if($result['Network']['receiver_id']){
					$this->ManagePoint->setAtheleteRating($result['Network']['receiver_id'] , 'responding_network_request' , 1 , 1);
				}
			}
		}
		
		//adding_links_to_highlight_film_on_youtube
		$conditions = "(date(youtube_modifydate) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(youtube_modifydate)< (now())) AND Athlete.status=1";
		$results = $this->Athlete->find("all",array("conditions"=>$conditions,"fields"=>"Athlete.id"));
		if($results){
			foreach($results as $result){
				$user_id = $result['Athlete']['id'];
				if($user_id){
					$this->ManagePoint->setAtheleteRating($user_id , 'adding_links_to_highlight_film_on_youtube' , 1 , 1);
				}
			}
		}
		
		//feedback_from_opposing_coach
		$conditions = "(date(added_date) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(added_date)< (now()))";
		$results = $this->OpponentComment->find("all",array("conditions"=>$conditions,"group"=>"athlete_id,college_coach_id","fields"=>"OpponentComment.athlete_id"));
		if($results){
			foreach($results as $result){
				$user_id = $result['OpponentComment']['athlete_id'];
				if($user_id){
					$this->ManagePoint->setAtheleteRating($user_id , 'feedback_from_opposing_coach' , 1 , 1);
				}
			}
		}
		
		//most_profile_view
		$results = $this->Athlete->find("all",array("order"=>"weekly_counter DESC","fields"=>"Athlete.id"));
		if($results){
			foreach($results as $result){
				$user_id = $result['Athlete']['id'];
				if($user_id > 0){
					$this->ManagePoint->setAtheleteRating($user_id , 'most_profile_view' , 1 , 1);
				}
			}
		}
		
		echo "success";
		exit;
	}

	public function statsNeededAlert(){
		$this->loadModel('Event');
		$this->loadModel('Athlete');
		$this->loadModel('AthleteStat');

		$events = $this->Event->find("all",array("conditions"=>"Event.start_date <= now() AND Event.end_date <= now() AND user_type = 'athlete'"));
		if($events){
			foreach($events as $event){
				$event_id = $event['Event']['id'];
				$username = $event['Event']['username'];

				$athleteInfo = $this->Athlete->find("first",array("conditions"=>"Athlete.username = '$username'"));
				if($athleteInfo){
					$user_id = $athleteInfo['Athlete']['id'];
					$athleteStats = $this->AthleteStat->find("first",array("conditions"=>"AthleteStat.event_id = '$event_id' AND athlete_id = '$user_id'"));

					if(!$athleteStats){
						$email = $athleteInfo['Athlete']['email'];
						$this->statsNeededAlertEmail($username , $event['Event']['event_name'],$email);
					}
				}
			}
		}

		echo "success";
		exit;
	}

	private function statsNeededAlertEmail($username , $event_title , $email){
		$subject = "College Prospect Network  - Request for post Game Stats";
		$template = 'stats_needed_alert_email';
		$cakeEmail = new CakeEmail('default');
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to($email);
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('username' => $username, 'event_title' => $event_title));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			//$this->Session->setFlash('Error while sending email');
		}

		return 1;
	}


	/**
	 * send notification email to athlees if request pending, unread email OR profile is not completed
	 */
	public function athleteNotification(){
		$this->loadModel("Athlete");
		$this->loadModel("Mail");
		$this->loadModel("Network");
		$this->loadModel("AthleteVideo");
		$this->loadModel("Event");

		$athletes = $this->Athlete->find("all",array("conditions"=>"Athlete.status = 1"));

		if($athletes){
			foreach($athletes as $athlete){
				$athlete_id  = $athlete['Athlete']['id'];
				$username  = $athlete['Athlete']['username'];
				$password  = $athlete['Athlete']['password'];
				$firstname = $athlete['Athlete']['firstname'];
				$lastname  = $athlete['Athlete']['lastname'];
					
				$unreadMails = $this->Mail->find("count",array("conditions"=>"usertype_to = 'athlete' AND receiver = '$username' AND status = 'unread'"));
				if($unreadMails > 0){
					$this->unreadMailAlertEmail($username, $password , $firstname , $lastname,$athlete['Athlete']['email']);
				}

				$requests = $this->Network->find("all",array("conditions"=>"Network.status = 'Pending' AND  receiver_id = '$athlete_id' AND receiver_type = 'athlete'"));
				if($requests){
					$this->pendingRequestAlertEmail($username, $password , $firstname , $lastname,$athlete['Athlete']['email']);
				}

				$pending_tasks = array();
				if($athlete['Athlete']['image']){
					$pending_tasks[] = 'ADDING_PROFILE_PICTURE';
				}

				$data = $athlete['Athlete'];
				$checkData = array('gpa','sat_score','act_score','class_rank','clearing_house_eligible','intended_major');
				foreach($checkData as $check){
					if(!$data[$check]){
						$pending_tasks[] = 'COMPLETING_ACADEMIC_STATE';
						break;
					}
				}

				$checkData = array('class','height','weight','sport_id','primary_position','secondary_position','vertical','yarddash_40','shuttle_run','bench_press_max','squat_max');
				foreach($checkData as $check){
					if(!$data[$check]){
						$pending_tasks[] = 'COMPLETING_PHYSICAL_SECTION';
						break;
					}
				}

				$videoExist = $this->AthleteVideo->field("video_path","AthleteVideo.athlete_id = '$athlete_id'");
				if(!$videoExist){
					$pending_tasks[] = 'UPLOADING_GAME_TAPE';
				}

				$gameStats = $this->Event->field("id","Event.user_type = 'athlete' AND Event.username = '".$data['username']."'");
				if(!$gameStats){
					$pending_tasks[] = 'UPLOADING_GAME_SHEDULE';
				}

				if($pending_tasks){
					$this->pendingProfileAlertEmail($username, $password , $firstname , $lastname,$athlete['Athlete']['email']);
				}
			}
		}

		echo "success";
		exit;
	}

	private function unreadMailAlertEmail($username, $password , $firstname , $lastname,$email){
		$subject = "College Prospect Network - Athlete Unreaded Email";
		$template = 'unread_mail_alert_email';
		$cakeEmail = new CakeEmail('default');
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to($email);
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('username' => $username, 'password' => $password , 'firstname' => $firstname , 'lastname' => $lastname));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			//$this->Session->setFlash('Error while sending email');
		}
	}

	private function pendingRequestAlertEmail($username, $password , $firstname , $lastname,$email){
		$subject = "College Prospect Network - Athlete Pending Network Request";
		$template = 'pending_request_alert_email';
		$cakeEmail = new CakeEmail('default');
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to($email);
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('username' => $username, 'password' => $password , 'firstname' => $firstname , 'lastname' => $lastname));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			//$this->Session->setFlash('Error while sending email');
		}
	}

	private function pendingProfileAlertEmail($username, $password , $firstname , $lastname,$email){
		$subject = "College Prospect Network - Athlete Pending Task";
		$template = 'pending_profile_alert_email';
		$cakeEmail = new CakeEmail('default');
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to($email);
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('username' => $username, 'password' => $password , 'firstname' => $firstname , 'lastname' => $lastname));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			//$this->Session->setFlash('Error while sending email');
		}
	}

	/**
	 * send alerts to hsAAucoaches to approve the athlete profiles
	 */
	public function pendingApprovalAlert(){
		$this->loadModel("Athlete");
		$this->loadModel("HsAauCoach");

		$athletes = $this->Athlete->find("all",array("conditions"=>"Athlete.status = 0"));

		if($athletes){
			foreach($athletes as $athlete){
				$hs_aau_team_id = $athlete['Athlete']['hs_aau_team_id'];
				$hsAauCoaches = $this->HsAauCoach->find('all',array('conditions'=>array('HsAauCoach.hs_aau_team_id' => $hs_aau_team_id)));
				if(!$hsAauCoaches){
					continue;
				}

				$first_name = $athlete['Athlete']['firstname'];
				$last_name  = $athlete['Athlete']['lastname'];

				$cakeEmail = new CakeEmail();
				$subject = "College Prospect Network - Athlete Pending Approval";
				$template = 'athlete_coach_approval';
				foreach($hsAauCoaches as $hsAauCoach){
					try {
						$cakeEmail->template($template);
						$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
						$cakeEmail->to(array($hsAauCoach['HsAauCoach']['email'] => $hsAauCoach['HsAauCoach']['firstname']));
						$cakeEmail->subject($subject);
						$cakeEmail->emailFormat('html');
						$cakeEmail->viewVars(array('hsAauCoach' => $hsAauCoach, 'first_name' => $first_name, 'last_name' => $last_name));
						// Send email
						$cakeEmail->send();
					}
					catch (Exception $e){
						//$this->Session->setFlash('Error while sending email');
					}
				}
			}
		}

		echo "success";
		exit;
	}

	public function sendNeedAlert($college_need_id = false){
		$this->loadModel("Athlete");

		$college_need_id = (int)$college_need_id;
		if(!$college_need_id){
			$needsMatchs = $this->Athlete->query("select college_id ,firstname , lastname from athletes as Athlete inner join college_needs as CollegeNeed
							 on (Athlete.sport_id = CollegeNeed.sport_id AND Athlete.class = CollegeNeed.grade_class)");
		}
		else{
			$needsMatchs = $this->Athlete->query("select college_id ,firstname , lastname from athletes as Athlete inner join college_needs as CollegeNeed
							 on (Athlete.sport_id = CollegeNeed.sport_id AND Athlete.class = CollegeNeed.grade_class) where CollegeNeed.id = '$college_need_id'");	
		}

		if($needsMatchs){
			$cakeEmail = new CakeEmail();
			$subject  = "College Prospect Network - We've found an athlete who matches your needs!";
			$template = 'college_need_alert_mail';

			foreach($needsMatchs as $needsMatch){
				$first_name  = $needsMatch['Athlete']['firstname'];
				$last_name   = $needsMatch['Athlete']['lastname'];
				$college_id  = $needsMatch['Athlete']['college_id'];

				$collegeCoach = $this->CollegCoach->find("first",array("conditions"=>"CollegCoach.college_id = '$college_id'"));
				$coach_name  = $collegeCoach['CollegCoach']['firstname']." ".$collegeCoach['CollegCoach']['lastname'];
				$coach_email = $collegeCoach['CollegCoach']['email'];
					
				try {
					$cakeEmail->template($template);
					$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
					$cakeEmail->to(array($coach_email => $coach_name));
					$cakeEmail->to(array("admin@collegeprospectnetwork.com" => "Admin"));
					$cakeEmail->subject($subject);
					$cakeEmail->emailFormat('html');
					$cakeEmail->viewVars(array('first_name' => $first_name, 'last_name' => $last_name, 'coach_name' => $coach_name));
					// Send email
					$cakeEmail->send();
				}
				catch (Exception $e){
					//$this->Session->setFlash('Error while sending email');
				}
			}
		}
	}
}