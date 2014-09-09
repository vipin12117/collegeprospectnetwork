<?php

class MailController extends AppController{

	public $name = 'Mail';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}

	public function sent(){

	}

	public function trash(){

	}

	public function compose(){
		$this->layout = 'popup';
	}
}
