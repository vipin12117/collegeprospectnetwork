<?php

class SubscribeController extends AppController{

	public $name = 'Subscribe';

	public $uses = array('CollegeSubscription');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$this->set("title_for_layout","Subscribe - College Prospect Network");

		$user_id = $this->Session-read('user_id');
		$username  = $this->Session->read("username");
		$this->loadModel('CollegeCoach');

		$profileDetail = $this->CollegeCoach->getByUsername($username);
		$this->set("profileDetail",$profileDetail);

		if(isset($this->request->data['CollegeSubscription'])){
			$checkExist = $this->CollegeSubscription->getDetailByCollegeCoachId($user_id , $sport_id);
			if($checkExist){
				$this->Session->setFlash("An active subscription for that sport already exists!");
				$this->redirect(array("controller"=>"Subscribe","action"=>"index"));
			}
			else{
				App::import('Lib','Authnet');
				$Authnet = new Authnet();

				try{
					$result = $Authnet->createProfile($this->request->data['CollegeSubscription'],$profileDetail['CollegeCoach']['customer_profile_id']);
				}
				catch(Exception $e){
					$this->Session->setFlash($e->getMessage());
					$this->redirect(array("controller"=>"Subscribe","action"=>"index"));
				}
			}
		}
		
		$this->render("/Subscribe/index");
	}

	public function edit(){

	}

	public function history(){

	}

	public function cancel(){

	}
}
