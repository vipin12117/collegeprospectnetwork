<?php

class NetworkController extends AppController{

	public $name = 'Network';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}
	
	public $uses = array('Athlete','HsAauCoach','CollegeCoach','Network');

	public function index($type = 'athlete'){
		$this->set("title_for_layout","College Prospect Network - $type in my network");

		if($type == 'college'){
			$page_title = 'My College Coach';
		}
		elseif($type == 'coach'){
			$page_title = 'My HS/AAU Coach';
		}
		else{
			$type = "athlete";
			$page_title = 'My Athletes';
		}

		$this->set("page_title",$page_title);
		$this->set("type",$type);

		$user_id   = $this->Session->read('user_id');
		$user_type = $this->Session->read('user_type');
		$this->set("user_type",$user_type);

		switch($user_type){
			case 'Athlete':
				$userDetails = $this->Athlete->getById($user_id);
				break;
			case 'HsAauCoach':
				$userDetails = $this->HsAauCoach->getById($user_id);
				break;
			case 'CollegeCoach':
				$userDetails = $this->CollegeCoach->getById($user_id);
				break;
		}
		
		$this->set("userDetails",$userDetails);

		$this->paginate = array('Network' => array("conditions"=>"((Network.receiver_id = '$user_id' AND Network.sender_type = '$type') OR (Network.sender_id = '$user_id' AND Network.receiver_type = '$type')) AND Network.status = 'Active'"));
		$networks = $this->paginate('Network');

		foreach($networks as $i => $network){
			if($user_id != $network['Network']['sender_id']){
				$networks[$i]['Network']['user_id'] = $network['Network']['sender_id'];
				$networks[$i]['Network']['user_type'] = $network['Network']['sender_type'];
			}
			else{
				$networks[$i]['Network']['user_id'] = $network['Network']['receiver_id'];
				$networks[$i]['Network']['user_type'] = $network['Network']['receiver_type'];
			}
		}

		$this->set("networks",$networks);
	}

	public function requests(){

	}

	public function sendRequest(){

	}

	public function confirmRequest(){

	}

	public function deleteRequest(){

	}
}
