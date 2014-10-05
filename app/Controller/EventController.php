<?php

class EventController extends AppController{

	public $name = 'Event';

	public $uses = array('SpecialEvent','SpecialEventUser','Coupon');

	public $components = array('Email','RequestHandler');

	public $helpers = array('Html','Form','Js' => array('Jquery'));

	public function beforeFilter(){
		parent::beforeFilter();
		//$this->checkSession();
	}

	public function index(){

	}

	public function stats(){

	}

	public function registration(){
		$this->set("title_for_layout","College Prospect Network - Event Registration");
		
		if(isset($this->request->data['SpecialEventUser'])){
			if(isset($_FILES['transcript']['tmp_name'])){
				$file_parts = explode(".",$_FILES['transcript']['tmp_name']);
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
		
		if(isset($this->request->data['SpecialEventUser'])){
			
			
		}

		$this->set("userDetail",$userDetail);

		$eventDetail = $this->SpecialEvent->read(null,$userDetail['SpecialEventUser']['special_event_id']);
		$this->set("eventDetail",$eventDetail);

		$early_discount_rate = 0;
		$start_date = $eventDetail['SpecialEvent']['start_date'];

		$pastDays = (time() - strtotime($start_date))/(24*60*60);
		if($pastDays <= $eventDetail['SpecialEvent']['early_discount_day']){
			$early_discount_rate = $eventDetail['SpecialEvent']['early_discount_rate'];
		}
		$this->set("early_discount_rate",$early_discount_rate);
		
		//process discount
		$coupon_code = $userDetail['SpecialEventUser']['coupon_number'];
		$coupon_detail = $this->Coupon->find("first",array("conditions"=>"Coupon.name = '$coupon_code' AND Coupon.event_id = '{$userDetail['SpecialEventUser']['special_event_id']}'"));
		$this->set("coupon_detail",$coupon_detail);
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
}