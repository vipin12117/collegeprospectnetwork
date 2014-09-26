<?php

class NoteController extends AppController{

	public $name = 'Note';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){

	}
	
	public function add($athlete_id = false , $type = 'athlete'){
		$this->layout = 'popup';
		
		if(isset($this->request->data['Note'])){
			$this->request->data['Note']['user_id']   = $athlete_id;
			$this->request->data['Note']['user_type'] = $type;
			$this->request->data['Note']['added_date'] = date('Y-m-d H:i:s');
			
			$this->Note->save($this->request->data);
			$this->set("message","Note added successfully");
		}
		
		$this->set("athlete_id",$athlete_id);
		$this->set("type",$type);
	}
}