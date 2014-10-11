<?php

class GameController extends AppController{

	public $name = 'Game';

	public $uses = array('Athlete','Event','HsAauTeam','AthleteStat','AthleteStatCategory');

	public $components = array('Email','RequestHandler');

	public $helpers = array('Html','Form','Js' => array('Jquery'));

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$user_id = $this->Session->read('user_id');
		$username  = $this->Session->read("username");

		$profileDetail = $this->Athlete->getByUsername($username);
		$this->set("profileDetail",$profileDetail);

		$conditions = "Event.sport_id = '".$profileDetail['Athlete']['sport_id']."'
					  AND (Event.user_type = 'athlete' OR Event.user_type = 'admin') 
					  AND Event.status = 1
					  AND (home_team = '".$profileDetail['Athlete']['hs_aau_team_id']."' OR away_team = '".$profileDetail['Athlete']['hs_aau_team_id']."')";

		$this->paginate = array("Event"=>array("conditions"=>$conditions,"limit"=>10));
		$events = $this->paginate("Event");
		$this->set("events",$events);
	}

	public function addStat(){
		$username  = $this->Session->read("username");
		$profileDetail = $this->Athlete->getByUsername($username);

		if(isset($this->request->data['Event'])){
			if($this->request->data['Event']['home_team'] != $profileDetail['Athlete']['hs_aau_team_id'] AND $this->request->data['Event']['away_team'] != $profileDetail['Athlete']['hs_aau_team_id']){
				$this->Session->setFlash("Home or Away Team must be your Team!");
			}
			elseif($this->request->data['Event']['home_team'] == $this->request->data['Event']['away_team']){
				$this->Session->setFlash("Home or Away Team can not be same!");
			}
			else{
				$this->request->data['Event']['start_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['Event']['start_date']));
				$this->request->data['Event']['end_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['Event']['end_date']));
				$this->request->data['Event']['added_date'] = date('Y-m-d H:i:s');
				$this->request->data['Event']['username']  = $username;
				$this->request->data['Event']['sport_id']  = $profileDetail['Athlete']['sport_id'];
				$this->request->data['Event']['user_type'] = $this->Session->read('user_type');

				$this->Event->save($this->request->data);

				$this->Session->setFlash("Event added successfully");
				$this->redirect(array("controller"=>"Game","action"=>"index"));
				exit;
			}
		}

		$this->set("profileDetail",$profileDetail);
		$this->render("/Game/addStat");
	}

	public function editStat($id = false){
		$id = (int)$id;
		if(!$id){
			$this->redirect(array("controller"=>"Game","action"=>"index"));
			exit;
		}

		$username  = $this->Session->read("username");
		$profileDetail = $this->Athlete->getByUsername($username);

		if(isset($this->request->data['Event'])){
			if($this->request->data['Event']['home_team'] != $profileDetail['Athlete']['hs_aau_team_id'] AND $this->request->data['Event']['away_team'] != $profileDetail['Athlete']['hs_aau_team_id']){
				$this->Session->setFlash("Home or Away Team must be your Team!");
			}
			elseif($this->request->data['Event']['home_team'] == $this->request->data['Event']['away_team']){
				$this->Session->setFlash("Home or Away Team can not be same!");
			}
			else{
				$this->request->data['Event']['start_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['Event']['start_date']));
				$this->request->data['Event']['end_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['Event']['end_date']));
				$this->request->data['Event']['modify_date'] = date('Y-m-d H:i:s');
				$this->request->data['Event']['username']  = $username;
				$this->request->data['Event']['user_type'] = $this->Session->read('user_type');

				$this->Event->id = $id;
				$this->Event->save($this->request->data);

				$this->Session->setFlash("Event updated successfully");
				$this->redirect(array("controller"=>"Game","action"=>"index"));
				exit;
			}
		}
		else{
			$this->request->data = $this->Event->read(null,$id);
		}

		$this->set("profileDetail",$profileDetail);
		$this->render("/Game/editStat");
	}

	public function deleteStat($id = false){
		$id = (int)$id;
		if(!$id){
			$this->redirect(array("controller"=>"Game","action"=>"index"));
			exit;
		}

		$this->Event->id = $id;
		$this->Event->delete();

		$this->Session->setFlash("Event deleted successfully");
		$this->redirect(array("controller"=>"Game","action"=>"index"));
		exit;
	}

	public function viewEvent($id){
		$this->autoLayout = false;

		$id = (int)$id;
		if(!$id){
			$this->redirect(array("controller"=>"Game","action"=>"index"));
			exit;
		}

		$eventDetail = $this->Event->read(null,$id);
		$homeTeam = $this->HsAauTeam->read(array("school_name"),$eventDetail['Event']['home_team']);
		$awayTeam = $this->HsAauTeam->read(array("school_name"),$eventDetail['Event']['away_team']);

		$eventDetail['Event']['home_team_name'] = $homeTeam['HsAauTeam']['school_name'];
		$eventDetail['Event']['away_team_name'] = $awayTeam['HsAauTeam']['school_name'];

		$this->set("eventDetail",$eventDetail);
		$this->render("/Game/viewEvent");
	}

	public function addAthleteStat($id){
		$id = (int)$id;
		if(!$id){
			$this->redirect(array("controller"=>"Game","action"=>"index"));
			exit;
		}

		$eventDetail = $this->Event->read(null,$id);
		$this->set("eventDetail",$eventDetail);

		$user_id = $this->Session->read('user_id');
		$username  = $this->Session->read("username");
		$profileDetail = $this->Athlete->getByUsername($username);

		if(isset($this->request->data['AthleteStat'])){
			foreach($this->request->data['AthleteStat'] as $index => $AthleteStat){
				$AthleteStat['event_id'] = $id;
				$AthleteStat['athlete_id'] = $user_id;
				$AthleteStat['hs_aau_coach_id'] = (int)$profileDetail['Athlete']['approve_hs_aau_coach_id'];
				$AthleteStat['sport_id'] = $profileDetail['Athlete']['sport_id'];
				$AthleteStat['added_date'] = date('Y-m-d H:i:s');

				$this->AthleteStat->create();
				$this->AthleteStat->save(array("AthleteStat" => $AthleteStat));
			}
				
			//find coach details
			$hsAauCoach = $this->HsAauCoach->read(array("email"),$profileDetail['Athlete']['approve_hs_aau_coach_id']);
			if($hsAauCoach){
				$this->athleteStatEmail($hsAauCoach['HsAauCoach']['email'],$profileDetail['Athlete']['name'],$eventDetail['Event']['event_name']);
			}
			
			$this->set("message","1");
		}
		else{
			$isExist = $this->AthleteStat->getStatsByAthleteId($user_id);
			if($isExist){
				$this->set("exist_message","You have already added stats for this event.");
			}
		}

		$athleteStatCategories = $this->AthleteStatCategory->find("all",array("conditions"=>"AthleteStatCategory.parent_id = '".$profileDetail['Athlete']['sport_id']."'"));
		$this->set("athleteStatCategories",$athleteStatCategories);

		$this->render("/Game/addAthleteStat");
	}

	private function athleteStatEmail($coach_email , $athlete_name , $event_name){
		$template = 'athlete_stat_email';
		$cakeEmail = new CakeEmail();
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to(array($coach_email => "Admin"));
			$cakeEmail->subject("College Prospect Network  - Stats Approval Request");
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('athlete_name' => $athlete_name, 'event_name' => $event_name));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			$this->Session->setFlash('Error while sending email');
		}
	}

	public function upcoming(){
		$user_id = $this->Session->read('user_id');
		$username  = $this->Session->read("username");

		$profileDetail = $this->Athlete->getByUsername($username);
		$this->set("profileDetail",$profileDetail);

		$conditions = "Event.sport_id = '".$profileDetail['Athlete']['sport_id']."'
					  AND (Event.user_type = 'athlete' OR Event.user_type = 'admin') 
					  AND Event.status = 1 AND end_date > now()
					  AND (home_team = '".$profileDetail['Athlete']['hs_aau_team_id']."' OR away_team = '".$profileDetail['Athlete']['hs_aau_team_id']."')";

		$this->paginate = array("Event"=>array("conditions"=>$conditions,"limit"=>10));
		$events = $this->paginate("Event");
		$this->set("events",$events);
	}

	public function getEventDetails(){
		$this->autoLayout = false;
		$this->autoRender = false;

		$home_team_name = "";
		$away_team_name = "";
		$location = "";

		if(isset($this->request->query['data']['Event']['home_team']) AND $this->request->query['data']['Event']['home_team']){
			$home_team = $this->request->query['data']['Event']['home_team'];
			$hsAauTeam = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '$home_team'"));

			$location  = $hsAauTeam['HsAauTeam']['address']. "\n ".$hsAauTeam['HsAauTeam']['city']. "\n ".$hsAauTeam['HsAauTeam']['state'].", "." ".$hsAauTeam['HsAauTeam']['zip'];
			$home_team_name  = $hsAauTeam['HsAauTeam']['school_name'];
		}

		if(isset($this->request->query['data']['Event']['away_team']) AND $this->request->query['data']['Event']['away_team']){
			$away_team = $this->request->query['data']['Event']['away_team'];
			$hsAauTeam = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '$away_team'"));

			$away_team_name  = $hsAauTeam['HsAauTeam']['school_name'];
		}

		print "$home_team_name vs. $away_team_name @@ $location";
		exit;
	}
}