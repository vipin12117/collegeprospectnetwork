<?php

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

	public function renewSubscription(){
		$today = date('Y-m-d H:i:s');
		$subscriptions = $this->CollegeSubscription->find("all",array("conditions"=>"CollegeSubscription.status = 1 AND CollegeSubscription.nextbill_date <= '$today'"));

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
			$this->Session->setFlash('Error while sending email');
		}
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
				$user_id = $athleteInfo['Athlete']['id'];
				$athleteStats = $this->AthleteStat->find("first",array("conditions"=>"Athlete.event_id = '$event_id' AND athlete_id = '$user_id'"));

				if(!$athleteStats){
					$email = $athleteInfo['Athlete']['email'];
					$this->statsNeededAlertEmail($username , $event['Event']['event_name'],$email);
				}
			}
		}
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
			$this->Session->setFlash('Error while sending email');
		}
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
				$firstname = $athlete['Athlete']['first_name'];
				$lastname  = $athlete['Athlete']['last_name'];
					
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

				$gameStats = $this->Event->field("video_path","Event.user_type = 'athlete' AND Event.username = '".$data['username']."'");
				if(!$gameStats){
					$pending_tasks[] = 'UPLOADING_GAME_SHEDULE';
				}

				if($pending_tasks){
					$this->pendingProfileAlertEmail($username, $password , $firstname , $lastname,$athlete['Athlete']['email']);
				}
			}
		}
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
			$this->Session->setFlash('Error while sending email');
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
			$this->Session->setFlash('Error while sending email');
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
			$this->Session->setFlash('Error while sending email');
		}
	}

	/**
	 * send alerts to hsAAucoaches to approve the athlete profiles
	 */
	public function pendingApprovalAlert(){
		$this->loadModel("Athlete");
		$athletes = $this->Athlete->find("all",array("conditions"=>"Athlete.status = 0"));

		if($athletes){
			foreach($athletes as $athlete){
				$hs_aau_team_id = $athlete['Athlete']['hs_aau_team_id'];
				$hsAauCoaches = $this->HsAauCoach->find('all',array('conditions'=>array('HsAauCoach.hs_aau_team_id' => $hs_aau_team_id)));
				if(!$hsAauCoaches){
					continue;
				}

				$first_name = $athlete['Athlete']['firstname'];
				$last_name  = $athlete['Athlete']['last_name'];

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
	}
}