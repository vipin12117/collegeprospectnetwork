<?php

class SubscriptionController extends AppController{

	public $name = 'Subscription';

	public $components = array('Email','RequestHandler');

	public $helpers = array('Html','Form','Js' => array('Jquery'));

	public function beforeFilter(){
		parent::beforeFilter();
		
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') ////for admin section template
        {
        	if ($this->checkAdminSession()){
            	$this->layout = 'admin';
        	} else {
        		$this->redirect(array('controller'=>'admins','action'=>'login'));
        	}
		} else {
			$this->checkSession();
		}
	}
	
	public function admin_subscriptionList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('Subscription.name LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('Subscription');			
			$this->paginate = array('Subscription'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$subscriptions = $this->paginate('Subscription');
			$this->set(compact('subscriptions', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('Subscription');
			$this->paginate = array('Subscription' => array('limit' => $limit));
			$subscriptions = $this->paginate('Subscription');
									
			$this->set(compact('subscriptions', 'limit'));
		}
	}
	
	public function admin_deleteSubscription($id){
		if (isset($id)){
			if($this->Subscription->delete($id)){
				$this->Session->setFlash('Subscription Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Subscription', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Subscription', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_editSubscription($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->Subscription->id = $id;
				if ($this->Subscription->save($this->request->data)){
					$this->Session->setFlash('Subscription Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'Subscription', 'action' => 'subscriptionList'));
				} else {
					$this->Session->setFlash('Can not update this Subscription', 'flash_error');
				}
			} else {
											
				$subscription = $this->Subscription->findById($id);																			
				$this->set('subscription', $subscription);
			}
		} else {
			$this->Session->setFlash('Do not exits this Subscription', 'flash_error');
		}	
	}
	
	public function admin_deleteSelectedSubscription(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Subscription->delete($id)){
					$this->Session->setFlash('Subscription Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_addSubscription(){	
		if ($this->request->is('post')){
			if ($this->Subscription->save($this->request->data)){
				$this->Session->setFlash('Subscription is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'Subscription', 'action' => 'subscriptionList'));
			} else {
				$this->Session->setFlash('Can not add this Subscription', 'flash_error');
			}
		} else {
			$this->loadModel('SpecialEvent');
			$specialEvents = $this->SpecialEvent->find('all', array('fields' => array('SpecialEvent.id', 'SpecialEvent.event_name'), 
														 'order' => array('SpecialEvent.id')));
															
			$eventList = array();
			foreach ($specialEvents as $specialEvent){
				$eventList[$specialEvent['SpecialEvent']['id']] = $specialEvent['SpecialEvent']['event_name'];
			}

			$this->set('eventList', $eventList);
		}
	}
		
	public function admin_subscriptionDetails($id){
		if (isset($id)){
			$subscription = $this->Subscription->findById($id);									
			$this->set('subscription', $subscription);
		} else {
			$this->Session->setFlash('Do not exits this Subscription', 'flash_error');
		}	
	}
	
}