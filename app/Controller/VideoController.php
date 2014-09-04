<?php

class VideoController extends AppController{

	public $name = 'Video';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}
}
