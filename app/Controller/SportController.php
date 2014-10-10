<?php

class SportController extends AppController{

	public $name = 'Sport';

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
	
	public function admin_sportList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('Sport.name LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('Sport');			
			$this->paginate = array('Sport'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$sports = $this->paginate('Sport');
			$this->set(compact('sports', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('Sport');
			$this->paginate = array('Sport' => array('limit' => $limit));
			$sports = $this->paginate('Sport');
									
			$this->set(compact('sports', 'limit'));
		}
	}
	
	public function admin_deleteSport($id){
		if (isset($id)){
			if($this->Sport->delete($id)){
				$this->Session->setFlash('Sport Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Sport', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Sport', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_editSport($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->Sport->id = $id;
				if ($this->Sport->save($this->request->data)){
					$this->Session->setFlash('Sport Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'Sport', 'action' => 'sportList'));
				} else {
					$this->Session->setFlash('Can not update this Sport', 'flash_error');
				}
			} else {
											
				$sport = $this->Sport->findById($id);																			
				$this->set('sport', $sport);
			}
		} else {
			$this->Session->setFlash('Do not exits this Sport', 'flash_error');
		}	
	}
	
	public function admin_deleteSelectedSport(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Sport->delete($id)){
					$this->Session->setFlash('Sport Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_addSport(){	
		if ($this->request->is('post')){
			if ($this->Sport->save($this->request->data)){
				$this->Session->setFlash('Sport is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'Sport', 'action' => 'sportList'));
			} else {
				$this->Session->setFlash('Can not add this Sport', 'flash_error');
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
		
	public function admin_sportDetails($id){
		if (isset($id)){
			$sport = $this->Sport->findById($id);									
			$this->set('sport', $sport);
		} else {
			$this->Session->setFlash('Do not exits this Sport', 'flash_error');
		}	
	}
	
}