<?php

App::uses('Component', 'Controller');

include_once ROOT . '/app/Lib/phpmailer/class.phpmailer.php';

class EmailComponent extends Component {

	public $name = 'Email';

	public $phpMailer = false;

	public function initialize(Controller $controller){
		parent::initialize($controller);

		$this->phpMailer = new PHPMailer();
	}

	public function athleteRegisterEmail($data,$address,$newSchool){
		App::import("Model","HsAauTeam");
		$this->HsAauTeam = new HsAauTeam();

		App::import("Model","Sport");
		$this->Sport = new Sport();

		$subject = "College Prospect Network - Athlete Welcome";
		$body = "Thanks for registering";

		if($newSchool) {
			$subjectStre = "[CPN] - New Athlete Registration + New School";
			$body = "New Athlete Registration + New School:<br />";
		}
		else{
			$subjectStre = "[CPN] - New Athlete Registration";
			$body = "New Athlete Registration:<br />";
		}

		$body .= "<br /><b>Status:</b> Waiting Approval by HS Coach";
		$body .= "<br /><b>Username:</b> " . $data['username'];
		$body .= "<br /><b>Password:</b> " . $data['password'];
		$body .= "<br /><b>Name:</b> " . $data['firstname'] . " " . $data['lastname'];
		$body .= "<br /><b>Email:</b> " .$data['email'];
		$body .= "<br />";
		$body .= "<br /><b>State:</b> " . $address['state'];

		$HsAauTeam = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '".$data['hs_aau_team_id']."'","fields"=>"HsAauTeam.school_name"));
		$HighSchoolName = $HsAauTeam['HsAauTeam']['school_name'];

		//HS/AAU Name
		$body .= "<br /><b>HS/AAU:</b> " . $HighSchoolName;
		$body .= "<br />" . $address['address'];
		$body .= "<br />" . $address['city']. ", ". $address['state'] . " " . $address['zip'];

		//Get Sport Name
		$Sport = $this->Sport->find("first",array("conditions"=>"Sport.id = '".$data['sport_id']."'","fields"=>"Sport.name"));
		$sport_name = $Sport['Sport']['name'];

		$body .= "<br /><br /><b>Sport:</b> " . $sport_name;
		$body .= "<br /><b>Jersey Number:</b> " . $data['jersey_number'];
		$body .= "<br /><b>Graduating Class:</b> " . $data['class'];
		$body .= "<br /><b>Intended Major:</b> " . $data['intended_major'];
		$body .= "<br /><br />" . $_SERVER['HTTP_USER_AGENT'];

		$this->phpMailer->ClearAddresses();
		$this->phpMailer->SetFrom("no-reply@collegeprospectnetwork.com","College Prospect Network");
		$this->phpMailer->AddAddress($data['email'],$data['firstname']);
		$this->phpMailer->Subject = $subject;
		$this->phpMailer->MsgHTML($body);

		$this->phpMailer->Send();
		return 1;
	}

	public function athleteCoachApproval($hs_aau_team_id , $first_name , $last_name){
		App::import("Model","HsAauCoach");
		$this->HsAauCoach = new HsAauCoach();

		$HsAauCoaches = $this->HsAauCoach->find("all",array("conditions"=>"hs_aau_team_id = '$hs_aau_team_id'"));
		if(!$HsAauCoaches){
			return false;
		}

		foreach($HsAauCoaches as $HsAauCoach){
			$subject = "College Prospect Network - Athlete Pending Approval";

			$body = "Hi Coach " . ucfirst($HsAauCoach['HsAauCoach']['firstname']) . '&nbsp;' . ucfirst($HsAauCoach['HsAauCoach']['lastname']) . ",<br /><br />";

			$body .= "You are receiving this email because " . ucfirst($first_name) . "&nbsp;" . ucfirst($last_name) . " has applied to join <a href=http://www.collegeProspectNetwork.com>www.collegeProspectNetwork.com.</a> <br />";
			$body .= "<br />";
			$body .= "Our website is dedicated to helping athletes get recruited by colleges and it is 100 percent free for you and your athletes. ";
			$body .= "Please take a couple of minutes to login and review " . ucfirst($first_name) . "&nbsp;" . ucfirst($last_name) . "s application to confirm that he/she is a legitimate prospect in their sport. <br />";
			$body .= "<br />";
			$body .=  "We also ask that you project the top level of competition at which you can contribute and look over the information he/she has entered to confirm accuracy. It is a simple process and will only take a couple of minutes.<br />";
			$body .= "<br />";
			$body .= "If " . ucfirst($first_name) . "&nbsp;" . ucfirst($last_name) . " lacks the talent necessary or is not one of your athletes, please deny the application. " . ucfirst($first_name) . "&nbsp;" . ucfirst($last_name) . " will be notified that the application has been denied but there will be no mention that you have had any part in the process.<br />";
			$body .= "<br />";
			$body .= "Please do not reply to this email. If you have any questions or concerns, please use the Contact Us page on the website or email us at contact@collegeprospectnetwork.com.<br />";
			$body .= "<br />";

			#Login Info & Directions
			$body .= "-------------------------------------------------------- <br />";
			$body .= "Login: <a href=http://www.collegeprospectnetwork.com/login.php>http://www.collegeprospectnetwork.com/login.php</a><br />";
			$body .= "Username: " . $HsAauCoach['HsAauCoach']['username'] . "<br />";
			$body .= "Password: " . $HsAauCoach['HsAauCoach']['password'] ."<br />";
			$body .= "User Type: HS/AAU Coach<br />";
			$body .= "<br />";
			$body .= "You can view all pending approval requests at My Account > Athlete Approval section<br />";

			$body .= "-------------------------------------------------------- <br />";
			$body .= "<br />";

			#Footer
			$body .= "Thank you in advance Coach " . ucfirst($HsAauCoach['HsAauCoach']['firstname']) . "&nbsp;" . ucfirst($HsAauCoach['HsAauCoach']['lastname']) . ",<br />";
			$body .= "<br />";
			$body .= "College Prospect Network<br />";
			$body .= "<a href=http://www.collegeprospectnetwork.com>www.collegeprospectnetwork.com</a>";

			$this->phpMailer->ClearAddresses();
			$this->phpMailer->SetFrom("no-reply@collegeprospectnetwork.com","College Prospect Network");
			$this->phpMailer->AddAddress($HsAauCoach['HsAauCoach']['email'],$HsAauCoach['HsAauCoach']['firstname']);
			$this->phpMailer->Subject = $subject;
			$this->phpMailer->MsgHTML($body);
			$this->phpMailer->Send();
		}

		return 1;
	}

	public function HSCoachAdminNotifiction($data , $address , $sportPositions, $newSchool){
		App::import("Model","HsAauTeam");
		$this->HsAauTeam = new HsAauTeam();

		if($newSchool) {
			$subject = "[CPN] - New HS Coach Registration + New School";
			$body = "New HS Coach Registration + New School:<br />";
		}
		else{
			$subject = "[CPN] - New HS Coach Registration";
			$body = "New HS Coach Registration:<br />";
		}
			
		$body .= "<br /><b>Status:</b> Active";
		$body .= "<br /><b>Username:</b> " .$data['username'];
		$body .= "<br /><b>Password:</b> " .$data['password'];
		$body .= "<br /><b>Name:</b> " . $data['firstname'] . " " . $data['lastname'];
		$body .= "<br /><b>Email:</b> " .$data['email'];
		$body .= "<br /><b>Alt Email:</b> " .$data['email2'];
		$body .= "<br /><b>Phone:</b> " .$data['phone'];
		$body .= "<br /><b>Alt Phone:</b> " . $data['phone2'];
		$body .= "<br />";
		$body .= "<br /><b>State:</b> " .$address['state'];

		$HsAauTeam = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '".$data['hs_aau_team_id']."'","fields"=>"HsAauTeam.school_name"));
		$HighSchoolName = $HsAauTeam['HsAauTeam']['school_name'];

		//HS/AAU Name
		$body .= "<br /><b>HS/AAU:</b> " . $HighSchoolName;
		$body .= "<br />" . $address['address'];
		$body .= "<br />" . $address['city']. ", ". $address['state'] . " " . $address['zip'];

		//Sports Loop
		$body .= "<br /><br /><b>Sport(s):</b> ";
		foreach($sportPositions as $sportPosition){
			$sports_name = $sportPosition['sport_id'];
			$body .=  $sports_name . ": " . $sportPosition['position'] . "<br />";
		}

		$body .= "<br /><br />" . $_SERVER['HTTP_USER_AGENT'];

		$this->phpMailer->ClearAddresses();
		$this->phpMailer->SetFrom("no-reply@collegeprospectnetwork.com","College Prospect Network");
		$this->phpMailer->AddAddress("admin@collegeprospectnetwork.com","Admin");
		$this->phpMailer->Subject = $subject;
		$this->phpMailer->MsgHTML($body);
		$this->phpMailer->Send();
	}

	public function CollegeCoachAdminNotifiction($data , $address , $newCollege){
		App::import("Model","College");
		$this->College = new College();

		App::import("Model","Sport");
		$this->Sport = new Sport();

		if ($newCollege) {
			$subject = "[CPN] - New College Coach Registration + New College";
			$body = "New College Coach Registration + New College<br />";
		}
		else{
			$subject = "[CPN] - New College Coach Registration";
			$body = "New College Coach Registration:<br />";
		}
			
		$body .= "<br /><b>Status:</b> Active - 5 Day Trial Period";
		$body .= "<br /><b>Status:</b> Active";
		$body .= "<br /><b>Username:</b> " .$data['username'];
		$body .= "<br /><b>Password:</b> " .$data['password'];
		$body .= "<br /><b>Name:</b> " . $data['firstname'] . " " . $data['lastname'];
		$body .= "<br /><b>Email:</b> " .$data['email'];
		$body .= "<br /><b>Alt Email:</b> " .$data['email2'];
		$body .= "<br /><b>Phone:</b> " .$data['phone'];
		$body .= "<br /><b>Alt Phone:</b> " . $data['phone2'];
		$body .= "<br />";
		$body .= "<br /><b>State:</b> " .$address['state'];

		$College = $this->College->find("first",array("conditions"=>"College.id = '".$data['college_id']."'","fields"=>"College.name"));
		$CollegeName = $College['College']['name'];

		//College Name
		$body .= "<br /><b>College:</b> " . $CollegeName;
		$body .= "<br />" . $address['address'];
		$body .= "<br />" . $address['city']. ", ". $address['state'] . " " . $address['zip'];

		//Get Sport Name
		$Sport = $this->Sport->find("first",array("conditions"=>"Sport.id = '".$data['sport_id']."'","fields"=>"Sport.name"));
		$sport_name = $Sport['Sport']['name'];

		$body .= "<br /><br /><b>Sport:</b> " . $sport_name;
		$body .= "<br /><b>Division:</b> " .$data['division'];
		$body .= "<br /><b>Job Position:</b> " . $data['position'];
		$body .= "<br /><br />" . $_SERVER['HTTP_USER_AGENT'];

		$this->phpMailer->ClearAddresses();
		$this->phpMailer->SetFrom("no-reply@collegeprospectnetwork.com","College Prospect Network");
		$this->phpMailer->AddAddress("admin@collegeprospectnetwork.com","Admin");
		$this->phpMailer->Subject = $subject;
		$this->phpMailer->MsgHTML($body);
		$this->phpMailer->Send();
	}

	/**
	 * Send an email with unique code to admin to change thier password
	 * @param $name
	 * @param $email
	 * @param $code
	 */
	public function forgetPasswordEmail($name , $email , $code){
		$subject = "College Prospect Network - Forget Password Request";
		$message = "";

		$message.= "Hello $name, <br />
                         We have received a forget password request. If you did not send it then ignore this email. <br  /> <br  />
                         
                         Your forget password code is : $code <br  /><br  />
                         
                    Regards, <br />
                    College Prospect Network team";           

		$from = "no-reply@collegeprospectnetwork.com";

		$phpmailer = new PHPMailer();
		$phpmailer->From = $from;
		$phpmailer->FromName = "College Prospect Network";
		$phpmailer->Subject = $subject;
		$phpmailer->MsgHTML($message);
		$phpmailer->AddAddress($email);
		$phpmailer->Send();

		return 1;
	}
}
?>