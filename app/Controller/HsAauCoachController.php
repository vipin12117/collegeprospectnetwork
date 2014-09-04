<?php

class HsAauCoachController extends AppController{

	public $name = 'HsAauCoach';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}
	
	public function index(){
		
	}
}