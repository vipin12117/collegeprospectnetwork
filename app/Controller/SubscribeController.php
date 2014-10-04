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
					$result = $Authnet->createProfile($this->request->data['CollegeSubscription'],@$profileDetail['CollegeCoach']['customer_profile_id']);

					$subscriotion_id = $this->request->data['CollegeSubscription']['subscription_id'];
					$subscription = $this->Subscription->find("first",array("conditions"=>"Subscription.id = '$subscriotion_id'"));

					if($subscription){
						$this->request->data['CollegeSubscription']['start_date'] = date('Y-m-d H:i:s');
						$this->request->data['CollegeSubscription']['payment_profile_id'] = $result[1];
						$this->request->data['CollegeSubscription']['status'] = date('Y-m-d H:i:s');
						$this->request->data['CollegeSubscription']['added_date'] = date('Y-m-d H:i:s');
						$this->request->data['CollegeSubscription']['transaction_id'] = $result[0];
						$this->request->data['CollegeSubscription']['amount'] = $subscription['Subscription']['cost'];
						$this->request->data['CollegeSubscription']['college_coach_id'] = $user_id;

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
						$this->CollegeCoach->id = $user_id;
						$this->CollegeCoach->saveField('subscription_id',$subscriotion_id);

						$this->Session->setFlash("Subscription profile created successfully.");
						$this->redirect(array("controller"=>"Profile","action"=>"index"));
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
		$this->set("title_for_layout","Update Subscription - College Prospect Network");

		$user_id = $this->Session->read('user_id');
		$username  = $this->Session->read("username");
		$this->loadModel('CollegeCoach');

		$count = $this->CollegeSubscription->find("count",array("conditions"=>"CollegeSubscription.college_coach_id = '$user_id' AND CollegeSubscription.status = 1"));
		if($count == 0){
			$this->redirect(array("controller"=>"Subscribe","action"=>"index"));
			exit;
		}

		if(isset($this->request->data['CollegeSubscription'])){
			App::import('Lib','Authnet');
			$Authnet = new Authnet();

			try{
				$subscription_id  = intval($this->request->data['CollegeSubscription']['subscription_id']);
				$result = $this->CollegeSubscription->find("first",array("conditions"=>"CollegeSubscription.college_coach_id = '$user_id' AND CollegeSubscription.subscription_id = '$subscription_id'"));

				$Authnet->updateProfile($this->request->data['CollegeSubscription'],$result['CollegeSubscription']['payment_profile_id'],$result['CollegeSubscription']['transaction_id']);

				$this->Session->setFlash("Subscription profile updated successfully.");
				$this->redirect(array("controller"=>"Profile","action"=>"index"));
			}
			catch(Exception $e){
				$this->Session->setFlash($e->getMessage());
			}
		}

		$profileDetail = $this->CollegeCoach->getByUsername($username);
		$this->set("profileDetail",$profileDetail);

		$list = $this->CollegeSubscription->find("list",array("conditions"=>"CollegeSubscription.college_coach_id = '$user_id' AND CollegeSubscription.status = 1","fields"=>"CollegeSubscription.subscription_id"));
		$options = $this->Subscription->find("list",array("fields"=>"id,name","order"=>"name ASC","group"=>"name","conditions"=>array("Subscription.id"=>$list)));
		$this->set("active_subscriptions",$options);
	}

	public function history(){
		$this->set("title_for_layout","Subscription History - College Prospect Network");

		$user_id = $this->Session->read('user_id');
		$username  = $this->Session->read("username");
		
		$result = $this->CollegeSubscription->find("all",array("conditions"=>"CollegeSubscription.college_coach_id = '$user_id'"));
		$this->set("subscriptions",$result);
	}

	public function cancel(){
		$this->set("title_for_layout","Cancel Subscription - College Prospect Network");

		$user_id = $this->Session->read('user_id');
		$username  = $this->Session->read("username");

		$count = $this->CollegeSubscription->find("count",array("conditions"=>"CollegeSubscription.college_coach_id = '$user_id' AND CollegeSubscription.status = 1"));
		if($count == 0){
			$this->redirect(array("controller"=>"Subscribe","action"=>"index"));
			exit;
		}

		if(isset($this->request->data['CollegeSubscription'])){
			App::import('Lib','Authnet');
			$Authnet = new Authnet();

			try{
				$subscription_id  = intval($this->request->data['CollegeSubscription']['subscription_id']);
				$result = $this->CollegeSubscription->find("first",array("conditions"=>"CollegeSubscription.college_coach_id = '$user_id' AND CollegeSubscription.subscription_id = '$subscription_id'"));

				$Authnet->cancelProfile($this->request->data['CollegeSubscription'],$result['CollegeSubscription']['payment_profile_id'],$result['CollegeSubscription']['transaction_id']);
				$this->CollegeSubscription->updateAll(array("status"=>0,"cancel_date"=>date('Y-m-d'),"cancel_reason"=>"'".$this->request->data['CollegeSubscription']['reason']."'"),array("college_coach_id"=>$user_id,"CollegeSubscription.subscription_id"=>$subscription_id));

				$this->Session->setFlash("Subscription profile cancel successfully.");
				$this->redirect(array("controller"=>"Profile","action"=>"index"));
			}
			catch(Exception $e){
				$this->Session->setFlash($e->getMessage());
			}
		}

		$list = $this->CollegeSubscription->find("list",array("conditions"=>"CollegeSubscription.college_coach_id = '$user_id' AND CollegeSubscription.status = 1","fields"=>"CollegeSubscription.subscription_id"));
		$options = $this->Subscription->find("list",array("fields"=>"id,name","order"=>"name ASC","group"=>"name","conditions"=>array("Subscription.id"=>$list)));
		$this->set("active_subscriptions",$options);
	}
}