<?php

class ProfileController extends AppController{

	public $name = 'Profile';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		App::import("Model","Mail");
		$this->Mail = new Mail();
		
		App::import("Model","Network");
		$this->Network = new Network();

		$username  = $this->Session->read("username");
		$mailCount = $this->Mail->find("count",array("conditions"=>"Mail.receiver = '$username' and Mail.status = 'unread'"));
		$this->set("mailCount",$mailCount);
		
		$user_id = $this->Session->read('user_id');
		$networkCount = $this->Network->find("count",array("conditions"=>"Network.receiver_id = '$user_id' and Network.status = 'unread'"));
		$this->set("networkCount",$networkCount);
		
		$this->render("/Profile/index");
	}

	public function athleteProfile(){

	}

	public function hsAauCoachProfile(){

	}

	public function collegeCoachProfile(){

	}
}
