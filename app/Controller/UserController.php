<?php

class UserController extends AppController{

	public $name = "User";

	public function beforeFilter(){
		parent::beforeFilter();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - Home | CPN");
	}

	public function register(){
		if(isset($this->request->data['Athlete'])){
			$user_type = $this->request->data['Athlete']['user_type'];
			$action = "register$user_type";

			$this->redirect(array("controller"=>"User","action"=>$action));
			exit;
		}
	}

	public function registerAthlete(){
		
		$this->render("/User/registerAthlete");
	}

	public function registerHSCoach(){

		$this->render("/User/registerHSCoach");
	}

	public function registerCollegeCoach(){

		$this->render("/User/registerCollegeCoach");
	}
}