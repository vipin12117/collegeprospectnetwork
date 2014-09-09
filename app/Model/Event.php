<?php

class Event extends AppModel{

	public $name = 'Event';

	public $useTable = 'events';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getUpcomingEvents($sport_id){
		$conditions = "Event.status = 1 AND Event.sport_id = '$sport_id' AND end_date > now() AND ( Event.user_type = 'admin' || Event.user_type = 'athlete' )";
		
		$rows = $this->find("all",array("conditions"=>$conditions));
		return $rows;
	}
}