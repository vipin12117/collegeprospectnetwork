<?php

class NetworkController extends AppController{

	public $name = 'Network';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

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
