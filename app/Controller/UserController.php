<?php

class UserController extends AppController{

	public $name = "User";

	public $components = array('Email','RequestHandler');

	public $helpers = array('Html','Form','Js' => array('Jquery'));

	public $uses = array("Athlete","HsAauTeam","HsAauCoach","CollegeCoach");

	public function beforeFilter(){
		parent::beforeFilter();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - Home | CPN");
	}

	public function register(){
		$this->set("title_for_layout","User Registration");

		if(isset($this->request->data['Athlete'])){
			$user_type = $this->request->data['Athlete']['user_type'];
			$action = "register$user_type";

			$this->redirect(array("controller"=>"User","action"=>$action));
			exit;
		}
	}

	public function getAddressInfo(){
		$this->autoLayout = false;
		$this->autoRender = false;

		$hs_aau_team_id = @$this->request->query['data']['Athlete']['hs_aau_team_id'];
		if($hs_aau_team_id != 'Other'){
			$hs_aau_team_id = (int)$hs_aau_team_id;
		}

		if(!$hs_aau_team_id){
			return false;
		}

		if(!$this->RequestHandler->isAjax()){
			$this->redirect(array("controller"=>"Home","action"=>"index"));
			exit;
		}

		if($hs_aau_team_id != 'Other'){
			App::import("Model","HsAauTeam");
			$this->HsAauTeam = new HsAauTeam();

			$hsAauTeamDetail = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '$hs_aau_team_id'"));
			$this->set("hsAauTeamDetail",$hsAauTeamDetail);
		}

		$this->render("/User/getAddressInfo","ajax");
	}

	public function getCollegeInfo(){
		$this->autoLayout = false;
		$this->autoRender = false;

		$college_id = @$this->request->query['data']['CollegeCoach']['college_id'];
		if($college_id != 'Other'){
			$college_id = (int)$college_id;
		}

		if(!$college_id){
			return false;
		}

		if(!$this->RequestHandler->isAjax()){
			$this->redirect(array("controller"=>"Home","action"=>"index"));
			exit;
		}

		if($college_id != 'Other'){
			App::import("Model","College");
			$this->College = new College();

			$CollegeDetail = $this->College->find("first",array("conditions"=>"College.id = '$college_id'"));
			$this->set("CollegeDetail",$CollegeDetail);
		}

		$this->render("/User/getCollegeInfo","ajax");
	}

	public function registerAthlete(){
		$this->set("title_for_layout","Athlete Registration");

		if(isset($this->request->data['Athlete'])){
			$username = strtolower($this->request->data['Athlete']['username']);
			$email = strtolower($this->request->data['Athlete']['email']);

			$checkUsernameExist = $this->Athlete->find("first",array("conditions"=>"Athlete.username = '$username'"));
			$checkEmailExist = $this->Athlete->find("first",array("conditions"=>"Athlete.email = '$email'"));

			if($checkUsernameExist){
				$this->Session->setFlash("This username is already exist, please try another one");
			}
			elseif($checkEmailExist){
				$this->Session->setFlash("This email is already assigned to another user");
			}
			else{
				$newSchool = false;
				if($this->request->data['Athlete']['hs_aau_team_id'] == 'Other'){
					$this->request->data['HsAauTeam']['athlete_username'] = $username;
					$this->request->data['HsAauTeam']['sport_id'] = $this->request->data['Athlete']['sport_id'];
					$this->request->data['HsAauTeam']['added_date'] = date('Y-m-d H:i:s');
					$this->request->data['HsAauTeam']['status'] = 0;

					$this->HsAauTeam->save($this->request->data);
					$hs_aau_team_id = $this->HsAauTeam->getLastInsertID();
					$this->request->data['Athlete']['hs_aau_team_id'] = $hs_aau_team_id;
					$newSchool = 1;
				}
				else{
					$hs_aau_team_id = $this->request->data['Athlete']['hs_aau_team_id'];
					$this->Email->athleteCoachApproval($hs_aau_team_id, $this->request->data['Athlete']['firstname'],$this->request->data['Athlete']['lastname']);
				}

				$this->Athlete->save($this->request->data);
				$message = "Thank you for submitting your application. Your profile will be reviewed by the College Prospect Network staff and you will be notified via email whether you are approved. Please allow 10 business days for us to process your request before contacting us.<br /><br />From, <br />College Prospect Network, LLC.";
				$this->Session->setFlash($message);

				$this->Email->athleteRegisterEmail($this->request->data['Athlete'],$this->request->data['HsAauTeam'],$newSchool);
				$this->redirect(array("controller"=>"Home","action"=>"index"));
				exit;
			}
		}

		$this->render("/User/registerAthlete");
	}

	public function registerHSCoach(){
		$this->set("title_for_layout","High School / AAU Coach Registration");

		if(isset($this->request->data['HsAauCoach'])){
			$username = strtolower($this->request->data['HsAauCoach']['username']);
			$email = strtolower($this->request->data['HsAauCoach']['email']);

			$checkUsernameExist = $this->HsAauCoach->find("first",array("conditions"=>"HsAauCoach.username = '$username'"));
			$checkEmailExist = $this->HsAauCoach->find("first",array("conditions"=>"HsAauCoach.email = '$email'"));

			if($checkUsernameExist){
				$this->Session->setFlash("This username is already exist, please try another one");
			}
			elseif($checkEmailExist){
				$this->Session->setFlash("This email is already assigned to another user");
			}
			else{
				$newSchool = false;
				if($this->request->data['HsAauCoach']['hs_aau_team_id'] == 'Other'){
					$this->request->data['HsAauTeam']['coach_name'] = $username;
					$this->request->data['HsAauTeam']['sport_id'] = $this->request->data['HsAauCoach']['sport_id'];
					$this->request->data['HsAauTeam']['added_date'] = date('Y-m-d H:i:s');
					$this->request->data['HsAauTeam']['status'] = 0;

					$this->HsAauTeam->save($this->request->data);
					$hs_aau_team_id = $this->HsAauTeam->getLastInsertID();
					$this->request->data['HsAauCoach']['hs_aau_team_id'] = $hs_aau_team_id;
					$newSchool = 1;
				}
				else{
					$hs_aau_team_id = $this->request->data['HsAauCoach']['hs_aau_team_id'];
				}

				$this->HsAauCoach->save($this->request->data);
				$hs_aau_coach_id = $this->HsAauCoach->getLastInsertID();

				$sportPositions = array();
				//insert all sports
				foreach($this->request->data['HsAauCoach']['sport_id'] as $i => $value){
					$sportPosition = array();
					$sportPosition['sport_id'] = $value;
					$sportPosition['position'] = $this->request->data['HsAauCoach']['position'][$i];
					$sportPosition['hs_aau_coach_id'] = $hs_aau_coach_id;
					
					$this->HsAauCoachSportposition->create();
					$this->HsAauCoachSportposition->save(array("HsAauCoachSportposition"=>$sportPosition));
					
					$sportPositions[] = $sportPosition;
				}

				$message = "Thank you for your Registration";
				$this->Session->setFlash($message);

				$this->Email->HSCoachAdminNotifiction($this->request->data['HsAauCoach'],$sportPositions,$newSchool);
				$this->redirect(array("controller"=>"Home","action"=>"index"));
				exit;
			}
		}

		$this->render("/User/registerHSCoach");
	}

	public function registerCollegeCoach(){
		$this->set("title_for_layout","College Coach Registration");

		if(isset($this->request->data['CollegeCoach'])){
			$username = strtolower($this->request->data['CollegeCoach']['username']);
			$email = strtolower($this->request->data['CollegeCoach']['email']);

			$checkUsernameExist = $this->Athlete->find("first",array("conditions"=>"CollegeCoach.username = '$username'"));
			$checkEmailExist = $this->Athlete->find("first",array("conditions"=>"CollegeCoach.email = '$email'"));

			if($checkUsernameExist){
				$this->Session->setFlash("This username is already exist, please try another one");
			}
			elseif($checkEmailExist){
				$this->Session->setFlash("This email is already assigned to another user");
			}
			else{
				$this->CollegeCoach->save($this->request->data);
				$message = "Thank you for submitting your application. Your profile will be reviewed by the College Prospect Network staff and you will be notified via email whether you are approved. Please allow 10 business days for us to process your request before contacting us.<br /><br />From, <br />College Prospect Network, LLC.";
				$this->Session->setFlash($message);

				$this->Email->athleteRegisterEmail($this->request->data['CollegeCoach'],$this->request->data['HsAauTeam'],$newSchool);
				$this->redirect(array("controller"=>"Home","action"=>"index"));
				exit;
			}
		}

		$this->render("/User/registerCollegeCoach");
	}
}