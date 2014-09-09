<?php

class SubscribeController extends AppController{

	public $name = 'Subscribe';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}

	public function edit(){

	}

	public function history(){

	}

	public function cancel(){

	}
}
