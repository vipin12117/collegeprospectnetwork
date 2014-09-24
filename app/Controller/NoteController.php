<?php

class NoteController extends AppController{

	public $name = 'Note';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}
}