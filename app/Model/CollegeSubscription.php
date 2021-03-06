<?php

class CollegeSubscription extends AppModel{

	public $name = 'CollegeSubscription';

	public $useTable = 'college_subscriptions';

	public $belongsTo = array('CollegeCoach','Subscription','Sport');

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	public function getDetailByCollegeCoachId($college_coach_id , $sport_id = false){
		if($sport_id){
			$row = $this->find("first",array("conditions"=>"CollegeSubscription.college_coach_id = '$college_coach_id' AND CollegeSubscription.sport_id = '$sport_id' AND CollegeSubscription.status = 1","order"=>"next_billdate DESC"));
		}
		else{
			$row = $this->find("first",array("conditions"=>"CollegeSubscription.college_coach_id = '$college_coach_id' AND CollegeSubscription.status = 1","order"=>"next_billdate DESC"));
		}
		
		return $row;
	}
	
	public function getSportsList($college_coach_id){
		return $this->find("list", array("conditions"=>"CollegeSubscription.college_coach_id = '$college_coach_id'",
										 "fields"=>"CollegeSubscription.sport_id"));
	}
}