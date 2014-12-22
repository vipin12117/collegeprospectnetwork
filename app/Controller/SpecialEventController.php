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
	
	public function admin_specialEventReport(){
		$this->loadModel('SpecialEventUser');
		$this->loadModel('SpecialEvent');
		
        $specialEventReports = $this->SpecialEventUser->specialEventReport();
        $this->set(compact('specialEventReports'));        			
	}
	
	public function admin_specialReportExport() {
		$specialEventReports = $this->SpecialEventUser->specialEventReport();		
		$content = "No.,Special Event,First Name,Last Name,Email,Address,City,State,Phone,Referred By,Event Location,Start Date,Price,PaymentStatus,Register Date \n";		
		$c=0;
		
		if (count($specialEventReports)>0)
		{
			foreach ($specialEventReports as $report)
			{
				$c++;
				$no = $c.",";	
				$fldEventName=	str_replace(","," ",$report['se']['event_name']).",";			
				$fldFirstName = str_replace(","," ",$report['sr']['firstname']).",";
				$fldLastName = str_replace(","," ",$report['sr']['lastname']).",";	
				$fldEmail = str_replace(","," ",$report['sr']['email']).",";	
				$fldAddress = str_replace(","," ",$report['sr']['address_1']).",";	
				$fldCity = str_replace(","," ",$report['sr']['city']).",";	
				$fldState = str_replace(","," ",$report['sr']['state']).",";	
				$fldPhone = str_replace(","," ",$report['sr']['phone']).",";	
				$fldReferredBy = str_replace(","," ",$report['sr']['referred_by']).",";
				$fldEventLocation = str_replace(","," ",$report['se']['location']).",";	
				$fldEventStartDate = str_replace(","," ",$report['se']['start_date']).",";	
				$fldprice = str_replace(","," ",$report['sr']['price']).",";				
				$fldpaymentstatus = str_replace(","," ",$report['sr']['payment_status']).",";	
				$fldAddDate = str_replace(","," ",date("m-d-Y", strtotime($report['sr']['added_date'])))."\n";					
				$content = $content.$no.$fldEventName.$fldFirstName.$fldLastName.$fldEmail.$fldAddress.$fldCity.$fldState.$fldPhone.$fldReferredBy.$fldEventLocation.$fldEventStartDate.$fldprice.$fldpaymentstatus.$fldAddDate;		
			}
		}
		else
		{
			$content = "No Data Found !";
		}
		$tmp_file = "Exported_Special_Event_".date('m_d_Y').".csv";
		header("Content-Disposition: attachment; filename=$tmp_file");
		echo $content;
		exit();
	}
	
	public function admin_specialEventUserDetails($id) {
		if (isset($id)){
			$this->loadModel('SpecialEventUser');
			$this->loadModel('SpecialEvent');
			$specialEventUser = $this->SpecialEventUser->findById($id);
			$specialEvent = $this->SpecialEvent->findById($specialEventUser['SpecialEventUser']['special_event_id']);						
			$this->set(compact('specialEventUser', 'specialEvent'));
		} else {
			$this->Session->setFlash('Do not exits this Special Event User', 'flash_error');
		}
	}
	
}