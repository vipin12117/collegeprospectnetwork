<?php

class CollegeSubscription extends AppModel{

	public $name = 'CollegeSubscription';

	public $useTable = 'college_subscriptions';
	
	public $belongsTo = array('CollegeCoach','Subscription');

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getDetailByCollegeCoachId($college_coach_id){
		$row = $this->find("first",array("conditions"=>"CollegeSubscription.college_coach_id = '$college_coach_id'"));
		return $row;
	}
}