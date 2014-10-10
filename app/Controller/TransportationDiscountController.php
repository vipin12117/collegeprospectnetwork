<?php

class TransportationDiscountController extends AppController{

	public $name = 'TransportationDiscount';

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
	
	public function admin_transportationDiscountList(){		
		$limit = 50;
		$this->paginate = array('TransportationDiscount' => array('limit' => $limit));
		$transportationDiscounts = $this->paginate('TransportationDiscount');		
		$this->set(compact('transportationDiscounts', 'limit'));		
	}
	
	public function admin_deleteTransportationDiscount($id){
		if (isset($id)){
			if($this->TransportationDiscount->delete($id)){
				$this->Session->setFlash('TransportationDiscount Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this TransportationDiscount', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this TransportationDiscount', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
			
	public function admin_deleteSelectedTransportationDiscount(){
		$this->loadModel('TransportationDiscount');
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->TransportationDiscount->delete($id)){
					$this->Session->setFlash('TransportationDiscount Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_editTransportationDiscount($id){
		if (isset($id)){
			if ($this->request->is('post')){				
				$this->loadModel('TransportationDiscount');
				$this->request->data['departure_time'] = $this->request->data['hours'].":".$this->request->data['minute']." ".$this->request->data['option'];
				$this->TransportationDiscount->id = $id;
				if ($this->TransportationDiscount->save($this->request->data)){
					$this->Session->setFlash('TransportationDiscount Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'TransportationDiscount', 'action' => 'transportationDiscountList'));
				} else {
					$this->Session->setFlash('Can not update this TransportationDiscount', 'flash_error');
				}
			} else {
				
				$this->loadModel('SpecialEvent');
				$specialEvents = $this->SpecialEvent->find('all', array('fields' => array('SpecialEvent.id', 'SpecialEvent.event_name'), 
															 'order' => array('SpecialEvent.id')));
												
				$eventList = array();
				foreach ($specialEvents as $specialEvent){
					$eventList[$specialEvent['SpecialEvent']['id']] = $specialEvent['SpecialEvent']['event_name'];
				}
				
				$transportationDiscount = $this->TransportationDiscount->findById($id);												
				$this->set(compact('transportationDiscount', 'eventList'));
			}
		} else {
			$this->Session->setFlash('Do not exits this TransportationDiscount', 'flash_error');
		}	
	}
	
	public function admin_addTransportationDiscount(){	
		if ($this->request->is('post')){
			$this->request->data['departure_time'] = $this->request->data['hours'].":".$this->request->data['minute']." ".$this->request->data['option'];
			if ($this->TransportationDiscount->save($this->request->data)){
				$this->Session->setFlash('TransportationDiscount is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'TransportationDiscount', 'action' => 'transportationDiscountList'));
			} else {
				$this->Session->setFlash('Can not add this TransportationDiscount', 'flash_error');
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
	
}