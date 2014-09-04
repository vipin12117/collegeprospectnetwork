<?php

class MailController extends AppController{

	public $name = 'Mail';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}
}
