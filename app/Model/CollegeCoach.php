<?php

class CollegeCoach extends AppModel{

	public $name = 'CollegeCoach';

	public $useTable = 'college_coaches';
	
	public $belongsTo = array('Sport','College');

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	public function getByUsername($username){
		$row = $this->find("first",array("conditions"=>"CollegeCoach.username = '$username'"));
		return $row;
	}

	public function getById($id){
		$row = $this->find("first",array("conditions"=>"CollegeCoach.id = '$id'"));
		return $row;
	}
}