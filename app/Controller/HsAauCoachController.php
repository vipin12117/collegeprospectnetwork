<?php

class HsAauCoachController extends AppController{

	public $name = 'HsAauCoach';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - HS / AAU Coach Listing");

		$conditions = array();

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('HsAauCoach'=>array("conditions"=>$conditions_str,"limit"=>20,"order"=>"firstname asc"));
		}
		else{
			$this->paginate = array('HsAauCoach'=>array("limit"=>20,"order"=>"firstname asc"));
		}

		$hsAauCoaches = $this->paginate('HsAauCoach');
		$this->set("hsAauCoaches",$hsAauCoaches);
	}
}