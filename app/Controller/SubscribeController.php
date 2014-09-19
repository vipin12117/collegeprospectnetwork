<?php

class SubscribeController extends AppController{

	public $name = 'Subscribe';

	public $uses = array('CollegeSubscription','Subscription');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$this->set("title_for_layout","Subscribe - College Prospect Network");

		$user_id = $this->Session->read('user_id');
		$username  = $this->Session->read("username");
		$this->loadModel('CollegeCoach');

		$profileDetail = $this->CollegeCoach->getByUsername($username);
		$this->set("profileDetail",$profileDetail);

		if(isset($this->request->data['CollegeSubscription'])){
			$checkExist = $this->CollegeSubscription->getDetailByCollegeCoachId($user_id , $this->request->data['CollegeSubscription']['sport_id']);
			if($checkExist){
				$this->Session->setFlash("An active subscription for that sport already exists!");
				$this->redirect(array("controller"=>"Subscribe","action"=>"index"));
			}
			else{
				App::import('Lib','Authnet');
				$Authnet = new Authnet();

				try{
					$result = $Authnet->createProfile($this->request->data['CollegeSubscription'],$profileDetail['CollegeCoach']['customer_profile_id']);

					$subscriotion_id = $this->request->data['CollegeSubscription']['subscription_id'];
					$subscription = $this->Subscription->find("first",array("conditions"=>"Subscription.id = '$subscriotion_id'"));

					if($subscription){
						$this->request->data['CollegeSubscription']['start_date'] = date('Y-m-d H:i:s');
						$this->request->data['CollegeSubscription']['payment_profile_id'] = $result[1];
						$this->request->data['CollegeSubscription']['status'] = date('Y-m-d H:i:s');
						$this->request->data['CollegeSubscription']['added_date'] = date('Y-m-d H:i:s');
						$this->request->data['CollegeSubscription']['transaction_id'] = $result[0];
						$this->request->data['CollegeSubscription']['amount'] = $subscription['Subscription']['cost'];

						switch($subscription['Subscription']['period']){
							case '3-Year':
								$this->request->data['CollegeSubscription']['next_billdate'] = date('Y-m-d H:i:s',time()+(3*12*30*24*60*60));
								break;
							case 'Yearly':
								$this->request->data['CollegeSubscription']['next_billdate'] = date('Y-m-d H:i:s',time()+(12*30*24*60*60));
								break;
							default:
								$this->request->data['CollegeSubscription']['next_billdate'] = date('Y-m-d H:i:s',time()+(30*24*60*60));
								break;
						}

						$this->CollegeSubscription->save($this->request->data['CollegeSubscription']);

						$this->Session->setFlash("subscription created successfully.");
						$this->redirect(array("controller"=>"Profile","action"=>"collegeCoachProfile"));
					}
				}
				catch(Exception $e){
					$this->Session->setFlash($e->getMessage());
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
