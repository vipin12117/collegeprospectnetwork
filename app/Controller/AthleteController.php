<?php

class AthleteController extends AppController{

	public $name = 'Athlete';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - Athlete Search");

		$conditions = array();

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('Athlete'=>array("conditions"=>$conditions_str,"limit"=>10));
		}
		else{
			$this->paginate = array('Athlete'=>array("limit"=>10));
		}

		$athletes = $this->paginate('Athlete');
		$this->set("athletes",$athletes);
	}

	public function approval(){

	}

	public function stats(){

	}

	public function invite(){

	}

	public function search(){

	}

	public function addRating(){

	}
}