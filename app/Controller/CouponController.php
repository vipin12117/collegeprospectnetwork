<?php

class CouponController extends AppController{

	public $name = 'Coupon';

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
	
	public function admin_couponList($eventId = null){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('Coupon.name LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('Coupon');			
			$this->paginate = array('Coupon'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$coupons = $this->paginate('Coupon');
			$this->set(compact('coupons', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('Coupon');
			if (isset($eventId)){
				$conditions = array('Coupon.event_id' => $eventId);
			} else {
				$conditions = array();
			}
			$this->paginate = array('Coupon' => array('conditions' => $conditions,
													  'limit' => $limit));
			$coupons = $this->paginate('Coupon');
									
			$this->set(compact('coupons', 'limit'));
		}
	}
	
	public function admin_deleteCoupon($id){
		if (isset($id)){
			if($this->Coupon->delete($id)){
				$this->Session->setFlash('Coupon Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Coupon', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Coupon', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_editCoupon($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->Coupon->id = $id;
				if ($this->Coupon->save($this->request->data)){
					$this->Session->setFlash('Coupon Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'Coupon', 'action' => 'couponList'));
				} else {
					$this->Session->setFlash('Can not update this Coupon', 'flash_error');
				}
			} else {
				$this->loadModel('SpecialEvent');
				$specialEvents = $this->SpecialEvent->find('all', array('fields' => array('SpecialEvent.id', 'SpecialEvent.event_name'), 
															 'order' => array('SpecialEvent.id')));
																
				$eventList = array();
				foreach ($specialEvents as $specialEvent){
					$eventList['SpecialEvent']['id'] = $specialEvent['SpecialEvent']['event_name'];
				}
								
				$coupon = $this->Coupon->findById($id);																			
				$this->set(compact('coupon', 'eventList'));
			}
		} else {
			$this->Session->setFlash('Do not exits this Coupon', 'flash_error');
		}	
	}
	
	public function admin_deleteSelectedCoupon(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Coupon->delete($id)){
					$this->Session->setFlash('Coupon Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_addCoupon(){	
		if ($this->request->is('post')){
			if ($this->Coupon->save($this->request->data)){
				$this->Session->setFlash('Coupon is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'Coupon', 'action' => 'couponList'));
			} else {
				$this->Session->setFlash('Can not add this Coupon', 'flash_error');
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