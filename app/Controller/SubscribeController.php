<?php

class SubscribeController extends AppController{

	public $name = 'Subscribe';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$this->set("title_for_layout","Subscribe - College Prospect Network");

		$username  = $this->Session->read("username");
		$this->loadModel('CollegeCoach');
		
		$profileDetail = $this->CollegeCoach->getByUsername($username);
		$this->set("profileDetail",$profileDetail);
	}

	public function edit(){

	}

	public function history(){

	}

	public function cancel(){

	}
}
