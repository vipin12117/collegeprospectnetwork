<?php

class Note extends AppModel{

	public $name = 'Note';

	public $useTable = 'notes';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getNotesById($user_id , $user_type , $status = 1){
		$conditions = "Note.user_id = '$user_id' AND Note.user_type = '$user_type'"; //Note.status = '$status' AND 
		
		$rows = $this->find("all",array("conditions"=>$conditions));
		return $rows;
	}
}