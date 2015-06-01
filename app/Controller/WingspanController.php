<?php

class WingspanController extends AppController{

	public $name = 'Wingspan';

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
	
	public function admin_wingspanList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('Wingspan.name LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('Wingspan');			
			$this->paginate = array('Wingspan'=>array('conditions' => $conditions,  'limit' => $limit));
												   
			$wingspans = $this->paginate('Wingspan');
			$this->set(compact('wingspans', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('Wingspan');
			$this->paginate = array('Wingspan' => array('limit' => $limit));
			$wingspans = $this->paginate('Wingspan');
									
			$this->set(compact('wingspans', 'limit'));
		}
	}
	
	public function admin_deleteWingspan($id){
		if (isset($id)){
			if($this->Wingspan->delete($id)){
				$this->Session->setFlash('Wingspan Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Wingspan', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Wingspan', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_editWingspan($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->Wingspan->id = $id;
				if ($this->Wingspan->save($this->request->data)){
					$this->Session->setFlash('Wingspan Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'Wingspan', 'action' => 'wingspanList'));
				} else {
					$this->Session->setFlash('Can not update this Wingspan', 'flash_error');
				}
			} else {
				$wingspan = $this->Wingspan->findById($id);																			
				$this->set('wingspan', $wingspan);
			}
		} else {
			$this->Session->setFlash('Do not exits this Wingspan', 'flash_error');
		}	
	}
	
	public function admin_addWingspan(){	
		if ($this->request->is('post')){
			if ($this->Wingspan->save($this->request->data)){
				$this->Session->setFlash('Wingspan is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'Wingspan', 'action' => 'wingspanList'));
			} else {
				$this->Session->setFlash('Can not add this Wingspan', 'flash_error');
			}
		} 
	}
}