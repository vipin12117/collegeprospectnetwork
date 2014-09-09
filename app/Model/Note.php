<?php

class Note extends AppModel{

	public $name = 'Note';

	public $useTable = 'notes';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getNotesById($user_id , $user_type){
		$conditions = "Note.status = 1 AND Note.user_id = '$user_id' AND Note.user_type = '$user_type'";
		
		$rows = $this->find("all",array("conditions"=>$conditions));
		return $rows;
	}
}