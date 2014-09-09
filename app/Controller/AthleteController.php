<?php

class AthleteController extends AppController{

	public $name = 'Athlete';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

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