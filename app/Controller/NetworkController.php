<?php

class NetworkController extends AppController{

	public $name = 'Network';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}
}
