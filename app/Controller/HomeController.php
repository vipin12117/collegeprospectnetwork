<?php

class HomeController extends AppController{

	public $name = 'Home';

	public function beforeFilter(){
		parent::beforeFilter();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - Home | CPN");
	}

	public function features(){

	}

	public function aboutus(){

	}

	public function contactus(){

	}

	public function privacyPolicy(){

	}

	public function termsConditions(){

	}
	
	public function refundPolicy(){
		
	}

	public function login(){

	}
	
	public function forgotPassword(){
		
	}
	
	public function logout(){
		
	}
}