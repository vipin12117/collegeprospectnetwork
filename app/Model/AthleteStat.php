<?php

class AthleteStat extends AppModel{

	public $name = 'AthleteStat';

	public $useTable  = 'athlete_stats';

	public $belongsTo = array('AthleteStatCategory',"Event");

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	public function getStatsByAthleteId($athlete_id){
		$row = $this->find("all",array("conditions"=>"AthleteStat.athlete_id = '$athlete_id'","group"=>"label_name","fields"=>"label_name,SUM(value) as value,count(athlete_stat_category_id) as count, `code` as initial"));
		return $row;
	}

	public function getStatsInfo($athlete_id , $event_id){
		$this->unbindModelAll();
		$rows = $this->find("all",array("conditions"=>"AthleteStat.athlete_id = '$athlete_id' AND AthleteStat.event_id = '$event_id'",
										"order"=>"sort_order ASC","fields"=>"label_name,value"));
		return $rows;
	}
}