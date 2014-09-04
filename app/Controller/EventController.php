<?php

class EventController extends AppController{

	public $name = 'Event';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}
}
