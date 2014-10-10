<?php

class SpecialEventController extends AppController{

	public $name = 'SpecialEvent';

	public $uses = array('SpecialEventUser','Coupon');

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
		
	public function admin_specialEventList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('SpecialEvent.event_name LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('SpecialEvent');			
			$this->paginate = array('SpecialEvent'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$specialEvents = $this->paginate('SpecialEvent');
			$this->set(compact('specialEvents', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('SpecialEvent');
			$this->paginate = array('SpecialEvent' => array('limit' => $limit));
			$specialEvents = $this->paginate('SpecialEvent');						
			
			$this->set(compact('specialEvents', 'limit'));
		}
	}
	
	public function admin_deleteSpecialEvent($id){
		if (isset($id)){
			$this->loadModel('SpecialEvent');
			if($this->SpecialEvent->delete($id)){
				$this->Session->setFlash('Special Event Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Special Event', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Special Event', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_specialEventDetails($id){
		if (isset($id)){
			$this->loadModel('SpecialEvent');
			$specialEvent = $this->SpecialEvent->findById($id);
									
			$this->set('specialEvent', $specialEvent);
		} else {
			$this->Session->setFlash('Do not exits this Special Event', 'flash_error');
		}	
	}
	
	public function admin_deleteSelectedSpecialEvent(){
		$this->loadModel('SpecialEvent');
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->SpecialEvent->delete($id)){
					$this->Session->setFlash('Special Event Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_deleteSpecialEventUser($id){
		if (isset($id)){
			$this->loadModel('SpecialEventUser');
			if($this->SpecialEventUser->delete($id)){
				$this->Session->setFlash('Special Event User Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Special Event User', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Special Event User', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	
	
	public function admin_editSpecialEvent($id){
		if (isset($id)){
			if ($this->request->is('post')){				
				$this->loadModel('SpecialEvent');
				$this->SpecialEvent->id = $id;
				if ($this->SpecialEvent->save($this->request->data)){
					$this->Session->setFlash('Special Event Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'SpecialEvent', 'action' => 'specialEventList'));
				} else {
					$this->Session->setFlash('Can not update this Special Event', 'flash_error');
				}
			} else {
				$this->loadModel('SpecialEvent');
				$specialEvent = $this->SpecialEvent->findById($id);
				$this->set('specialEvent', $specialEvent);
			}
		} else {
			$this->Session->setFlash('Do not exits this Special Event', 'flash_error');
		}	
	}
	
	public function admin_addSpecialEvent(){	
		if ($this->request->is('post')){
			$this->loadModel('SpecialEvent');
			if ($this->SpecialEvent->save($this->request->data)){
				$this->Session->setFlash('SpecialEvent is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'SpecialEvent', 'action' => 'specialEventList'));
			} else {
				$this->Session->setFlash('Can not add this Special Event', 'flash_error');
			}
		} 
	}
	
	public function admin_specialEventUserList() {
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('SpecialEventUser.payment_status' => 'PAID', 'OR' => array('SpecialEventUser.firstname LIKE ' => '%'.$searchName.'%', 
												  'SpecialEventUser.lastname LIKE ' => '%'.$searchName.'%'));				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('SpecialEventUser');			
			$this->paginate = array('SpecialEventUser'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$specialEventUsers = $this->paginate('SpecialEventUser');
			$this->set(compact('specialEventUsers', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('SpecialEventUser');
			$this->paginate = array('SpecialEventUser' => array('limit' => $limit));
			$specialEventUsers = $this->paginate('SpecialEventUser');	

			$this->set(compact('specialEventUsers', 'limit'));
		}
	} 
	
}