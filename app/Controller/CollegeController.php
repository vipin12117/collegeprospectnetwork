<?php

class CollegeController extends AppController{

	public $name = 'College';

	public $uses = array('College','CollegeCoach','Athlete','HsAauCoach');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - College Coach Listing");

		$user_id   = $this->Session->read('user_id');
		$user_type = $this->Session->read('user_type');

		$sport_id = 0;
		switch ($user_type){
			case 'Athlete':
				$athlete  = $this->Athlete->getById($user_id);
				$sport_id = $athlete['Athlete']['sport_id'];
				break;
			case 'CollegeCoach':
				$collegeCoach = $this->CollegeCoach->getById($user_id);
				$sport_id = $collegeCoach['CollegeCoach']['sport_id'];
				break;
			case 'HsAauCoach':
				$hsAauCoach = $this->HsAauCoach->getById($user_id);
				$sport_id = $hsAauCoach['HsAauCoach']['sport_id'];
				break;
		}

		$conditions = array();
		if($sport_id){
			$conditions[] = "CollegeCoach.sport_id = '$sport_id'";
		}

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('CollegeCoach'=>array("conditions"=>$conditions_str,"limit"=>20,"order"=>"firstname asc"));
		}
		else{
			$this->paginate = array('CollegeCoach'=>array("limit"=>20,"order"=>"firstname asc"));
		}

		$collegeCoaches = $this->paginate('CollegeCoach');
		$this->set("collegeCoaches",$collegeCoaches);
	}

	public function matches(){
		$this->set("title_for_layout","College Prospect Network - College Coach Listing");

		$user_id   = $this->Session->read('user_id');
		$user_type = $this->Session->read('user_type');

		$athlete  = $this->Athlete->getById($user_id);
		$sport_id = $athlete['Athlete']['sport_id'];

		$conditions = array();
		if($sport_id){
			$conditions[] = "CollegeCoach.sport_id = '$sport_id'";
		}

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('CollegeCoach'=>array("conditions"=>$conditions_str,"limit"=>20,"order"=>"firstname asc"));
		}
		else{
			$this->paginate = array('CollegeCoach'=>array("limit"=>20,"order"=>"firstname asc"));
		}

		$collegeCoaches = $this->paginate('CollegeCoach');
		$this->set("collegeCoaches",$collegeCoaches);
	}
}