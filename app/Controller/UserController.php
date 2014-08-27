<?php

class UserController extends AppController{

	public $name = "User";

	public function beforeFilter(){
		parent::beforeFilter();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - Home | CPN");
	}

	public function register(){

	}

	public function registerAthlete(){

	}

	public function registerHSCoach(){

	}

	public function registerCollegeCoach(){

	}
}