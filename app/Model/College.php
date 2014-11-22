<?php

class College extends AppModel{

	public $name = 'College';

	public $useTable = 'colleges';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	public function getById($id){
		$row = $this->find("first",array("conditions"=>"College.id = '$id'"));
		return $row;
	}
}