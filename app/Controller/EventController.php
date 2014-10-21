<?php

class EventController extends AppController{

	public $name = 'Event';

	public $uses = array('SpecialEvent','SpecialEventUser','Coupon');

	public $components = array('Email','RequestHandler');

	public $helpers = array('Html','Form','Js' => array('Jquery'));

	public function beforeFilter(){
		parent::beforeFilter();

		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') ////for admin section template
		{
			if ($this->checkAdminSession()){
				$this->layout = 'admin';
			}
			else {
				$this->redirect(array('controller'=>'admins','action'=>'login'));
			}
		}
	}

	public function registration(){
		$this->set("title_for_layout","College Prospect Network - Event Registration");

		if(isset($this->request->data['SpecialEventUser'])){
			if(isset($_FILES['transcript']['tmp_name'])){
				$file_parts = explode(".",$_FILES['transcript']['name']);
				$extension  = end($file_parts);
				$filename = $this->uniqueCode(20).".$extension";

				if(move_uploaded_file($_FILES['transcript']['tmp_name'],WWW_ROOT."/files/$filename")){
					$this->request->data['SpecialEventUser']['transcript'] = $filename;
				}
				else{
					unset($this->request->data['SpecialEventUser']['transcript']);
				}
			}

			$this->SpecialEventUser->save($this->request->data);
			$event_user_id = $this->SpecialEventUser->getLastInsertId();

			$this->Session->write("event_user_id",$event_user_id);
			$this->redirect(array("controller"=>"Event","action"=>"confirmation"));
			exit;
		}

		$events = $this->SpecialEvent->find("list",array("fields"=>"id,event_name","conditions"=>"start_date > '".date('Y-m-d')."'"));
		$this->set("events",$events);
	}

	public function confirmation(){
		$event_user_id = $this->Session->read("event_user_id");
		$userDetail = $this->SpecialEventUser->read(null,$event_user_id);

		if(!$userDetail || !$event_user_id){
			$this->redirect(array("controller"=>"Event","action"=>"registration"));
			exit;
		}

		$this->set("userDetail",$userDetail);
		$eventDetail = $this->SpecialEvent->read(null,$userDetail['SpecialEventUser']['special_event_id']);
		$this->set("eventDetail",$eventDetail);

		$early_discount_rate = 0;
		$total_price = $eventDetail['SpecialEvent']['current_price'];

		if(isset($userDetail['TransportationDiscount']) AND $userDetail['TransportationDiscount']['transport_charge'] > 0){
			$total_price += $eventDetail['TransportationDiscount']['transport_charge'];
		}

		if($eventDetail['SpecialEvent']['transcript_discount'] > 0){
			$total_price -= $eventDetail['SpecialEvent']['transcript_discount'];
		}

		$start_date  = $eventDetail['SpecialEvent']['start_date'];
		$pastDays = (time() - strtotime($start_date))/(24*60*60);
		if($pastDays <= $eventDetail['SpecialEvent']['early_discount_day']){
			$early_discount_rate = $eventDetail['SpecialEvent']['early_discount_rate'];
			$total_price -= $early_discount_rate;
		}
		$this->set("early_discount_rate",$early_discount_rate);

		//process discount
		$coupon_code = $userDetail['SpecialEventUser']['coupon_number'];
		$coupon_detail = $this->Coupon->find("first",array("conditions"=>"Coupon.name = '$coupon_code' AND Coupon.event_id = '{$userDetail['SpecialEventUser']['special_event_id']}'"));
		$this->set("coupon_detail",$coupon_detail);

		if(isset($coupon_detail['Coupon']) AND $coupon_detail['Coupon']['amount'] > 0){
			$total_price -= $coupon_detail['Coupon']['amount'];
		}

		if(isset($this->request->data['SpecialEventUser'])){
			App::import('Lib','Authnet');
			$Authnet = new Authnet();

			try{
				$this->request->data['SpecialEventUser']['event_name'] = $eventDetail['SpecialEvent']['event_name'];
				$this->request->data['SpecialEventUser']['total'] = $total_price;
				$this->request->data['SpecialEventUser']['email'] = $userDetail['SpecialEventUser']['email'];
				$this->request->data['SpecialEventUser']['country'] = "USA";

				$transaction_id = $Authnet->processPayment($this->request->data['SpecialEventUser']);
				$this->SpecialEventUser->updateAll(array("SpecialEventUser.payment_status"=>"1","SpecialEventUser.transaction_id"=>"'$transaction_id'"),array("SpecialEventUser.id"=>$event_user_id));

				$userDetail['SpecialEventUser']['transaction_id'] = $transaction_id;
				$this->sendEventConfirmationAdminMail($userDetail , $eventDetail , $early_discount_rate , $coupon_detail , $total_price);
				$this->sendEventConfirmationMail($userDetail , $eventDetail , $early_discount_rate , $coupon_detail , $total_price);

				$this->Session->setFlash("Event Registration is Successfull");
				$this->redirect(array("controller"=>"Home","action"=>"index"));
				exit;
			}
			catch(Exception $e){
				$this->Session->setFlash($e->getMessage());
			}
		}
	}

	public function getTransportationDiscount(){
		$this->autoLayout = false;
		$this->autoRender = false;

		$special_event_id = @$this->request->query['data']['SpecialEventUser']['special_event_id'];
		$this->loadModel('TransportationDiscount');

		$discounts = $this->TransportationDiscount->find("list",array("fields"=>"TransportationDiscount.id,discount","conditions"=>"TransportationDiscount.event_id = '$special_event_id' AND TransportationDiscount.status = 1"));
		$this->set("discounts",$discounts);

		if(!$this->RequestHandler->isAjax()){
			$this->redirect(array("controller"=>"Home","action"=>"index"));
			exit;
		}

		if($discounts){
			$this->render("/Event/transportation_discount","ajax");
		}
		else{
			return false;
		}
	}

	public function getAddressInfo(){
		$this->autoLayout = false;
		$this->autoRender = false;

		$hs_aau_team_id = @$this->request->query['data']['SpecialEventUser']['school'];
		if(!$hs_aau_team_id){
			$hs_aau_team_id = @$this->request->query['data']['SpecialEventUser']['hs_aau_team_id'];
		}

		if($hs_aau_team_id != 'Other'){
			$hs_aau_team_id = (int)$hs_aau_team_id;
		}

		if(!$hs_aau_team_id){
			return false;
		}

		if(!$this->RequestHandler->isAjax()){
			$this->redirect(array("controller"=>"Home","action"=>"index"));
			exit;
		}

		if($hs_aau_team_id != 'Other'){
			App::import("Model","HsAauTeam");
			$this->HsAauTeam = new HsAauTeam();

			$hsAauTeamDetail = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '$hs_aau_team_id'"));
			$this->set("hsAauTeamDetail",$hsAauTeamDetail);
		}

		$this->render("/User/getAddressInfo","ajax");
	}

	public function sendEventConfirmationAdminMail($userDetail , $eventDetail , $early_discount_rate , $coupon_detail , $total_price){
		$subject   = "College Prospect Network - Event Registration is Successfull";
		$template  = 'event_confirmation_mail';
		$cakeEmail = new CakeEmail();
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to(array("admin@collegeprospectnetwork.com" => "Admin"));
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('userDetail' => $userDetail, 'eventDetail' => $eventDetail));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			$this->Session->setFlash('Error while sending email');
		}
	}

	public function sendEventConfirmationMail($userDetail , $eventDetail , $early_discount_rate , $coupon_detail , $total_price){
		$subject   = "College Prospect Network - Event Registration is Successfull";
		$template  = 'event_confirmation_mail';
		$cakeEmail = new CakeEmail();
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to(array($userDetail['SpecialEventUser']['email'] => $userDetail['SpecialEventUser']['firstname']));
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('userDetail' => $userDetail, 'eventDetail' => $eventDetail));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			$this->Session->setFlash('Error while sending email');
		}
	}

	public function admin_eventList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
				
			if (!empty($searchName)){
				$conditions = array('Event.event_name LIKE ' => '%'.$searchName.'%');
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('Event');
			$this->paginate = array('Event'=>array('conditions' => $conditions,
												   'limit' => $limit));
				
			$events = $this->paginate('Event');
			$this->set(compact('events', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('Event');
			$this->paginate = array('Event' => array('limit' => $limit));
			$events = $this->paginate('Event');
				
			// Get sport list.
			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
														 'order' => array('Sport.id')));						
			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
			}
				
			$this->set(compact('events', 'limit', 'sportList'));
		}
	}

	public function admin_deleteEvent($id){
		if (isset($id)){
			$this->loadModel('Event');
			if($this->Event->delete($id)){
				$this->Session->setFlash('Event Deleted Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not delete this Event', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Event', 'flash_error');
		}
		$this->redirect($this->referer());
	}

	public function admin_eventDetails($id){
		if (isset($id)){
			$this->loadModel('Event');
			$eventDet = $this->Event->findById($id);
				
			// Get Sport Name
			$this->loadModel('Sport');
			$sportName = $this->Sport->findById($eventDet['Event']['sport_id']);
				
			// Get Team Name
			$this->loadModel('HsAauTeam');
			$teamName = $this->HsAauTeam->findById($eventDet['Event']['home_team']);
			$awayTeam = $this->HsAauTeam->findById($eventDet['Event']['away_team']);
				
			$this->set(compact('eventDet', 'sportName', 'teamName', 'awayTeam'));
		} else {
			$this->Session->setFlash('Do not exits this Event', 'flash_error');
		}
	}

	public function admin_deleteSelectedEvent(){
		$this->loadModel('Event');
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Event->delete($id)){
					$this->Session->setFlash('Event Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}
			}
		}
		$this->redirect($this->referer());
	}

	public function admin_editEvent($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->loadModel('Event');
				$this->Event->id = $id;
				if ($this->Event->save($this->request->data)){
					$this->Session->setFlash('Event Updated Successfully!', 'flash_success');
					$this->redirect(array('controller' => 'Event', 'action' => 'eventList'));
				} else {
					$this->Session->setFlash('Can not update this Event', 'flash_error');
				}
			} else {
				$this->loadModel('Event');
				$event = $this->Event->findById($id);
					
				// Get Sport Name
				$this->loadModel('Sport');
				$sport = $this->Sport->findById($event['Event']['sport_id']);

				$this->loadModel('Sport');
				$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
															 'order' => array('Sport.name')));

				$sportList = array();
				foreach ($sports as $sport){
					$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
				}
					
				// Get category list.
				$this->loadModel('HsAauTeam');
				$hsAauTeams = $this->HsAauTeam->find('all', array('conditions' => array('HsAauTeam.status' => '1'),
																  'fields' => array('HsAauTeam.id', 'HsAauTeam.school_name'), 
															 	  'order' => array('HsAauTeam.school_name')));
				$categoryList = array();
				foreach ($hsAauTeams as $hsAauTeam){
					$categoryList[$hsAauTeam['HsAauTeam']['id']] = $hsAauTeam['HsAauTeam']['school_name'];
				}

				$this->set(compact('event', 'sport', 'categoryList', 'sportList'));
			}
		} else {
			$this->Session->setFlash('Do not exits this Event', 'flash_error');
		}
	}

	public function admin_addEvent(){
		if ($this->request->is('post')){
			$this->loadModel('Event');
			if ($this->Event->save($this->request->data)){
				$this->Session->setFlash('Event is Added Successfully', 'flash_success');
				$this->redirect(array('controller' => 'Event', 'action' => 'eventList'));
			} else {
				$this->Session->setFlash('Can not add this Event', 'flash_error');
			}
		} else {
			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
														 'order' => array('Sport.name')));
				
			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
			}
				
			// Get category list.
			$this->loadModel('HsAauTeam');
			$hsAauTeams = $this->HsAauTeam->find('all', array('conditions' => array('HsAauTeam.status' => '1'),
															  'fields' => array('HsAauTeam.id', 'HsAauTeam.school_name'), 
															  'order' => array('HsAauTeam.school_name')));
			$categoryList = array();
			foreach ($hsAauTeams as $hsAauTeam){
				$categoryList[$hsAauTeam['HsAauTeam']['id']] = $hsAauTeam['HsAauTeam']['school_name'];
			}
				
			$this->set(compact('categoryList', 'sportList'));
		}
	}
}