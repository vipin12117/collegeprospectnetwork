<?php

class GameController extends AppController{

	public $name = 'Game';

	public $uses = array('Athlete','Event','HsAauTeam');

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

		if($this->request->data['Event']){
			$this->Event->save($this->request->data);

			$this->Session->setFlash("Event added successfully");
			$this->redirect(array("controller"=>"Game","action"=>"index"));
			exit;
		}

		$this->render("/Game/addStat");
	}

	public function editStat($id = false){
		$id = (int)$id;
		if(!$id){
			$this->redirect(array("controller"=>"Game","action"=>"index"));
			exit;
		}

		if($this->request->data['Event']){
			$this->Event->save($this->request->data);

			$this->Session->setFlash("Event added successfully");
			$this->redirect(array("controller"=>"Game","action"=>"index"));
			exit;
		}
		else{
			$this->request->data = $this->Event->read(null,$id);
		}

		$this->render("/Game/editStat");
	}

	public function upcoming(){

	}

	public function getEventDetails(){
		$this->autoLayout = false;
		$this->autoRender = false;

		$home_team_name = "";
		$away_team_name = "";
		$location = "";

		if(isset($this->request->query['data']['Event']['home_team'])){
			$home_team = $this->request->query['data']['Event']['home_team'];
			$hsAauTeam = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '$home_team'"));

			$location  = $hsAauTeam['HsAauTeam']['address']. "\n ".$hsAauTeam['HsAauTeam']['city']. "\n ".$hsAauTeam['HsAauTeam']['state'].", "." ".$hsAauTeam['HsAauTeam']['zip'];
			$home_team_name  = $hsAauTeam['HsAauTeam']['school_name'];
		}

		if(isset($this->request->query['data']['Event']['away_team'])){
			$away_team = $this->request->query['data']['Event']['away_team'];
			$hsAauTeam = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '$away_team'"));

			$away_team_name  = $hsAauTeam['HsAauTeam']['school_name'];
		}

		print "$home_team_name vs. $away_team_name @@ $location";
		exit;
	}
}