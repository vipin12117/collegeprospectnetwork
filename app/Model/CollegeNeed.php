<?php

class CollegeNeed extends AppModel{

	public $name = 'CollegeNeed';

	public $useTable = 'college_needs';
	
	public $belongsTo = array('Sport','College');

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getByCollegeId($college_id){
		$rows = $this->find("all",array("conditions"=>"CollegeNeed.college_id = '$college_id'"));
		return $rows;
	}
}