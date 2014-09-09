<?php

class CollegeController extends AppController{

	public $name = 'College';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}

	public function matches(){

	}
}