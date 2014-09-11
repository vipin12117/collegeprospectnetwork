<?php

class AthleteController extends AppController{

	public $name = 'Athlete';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - Athlete Search");
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