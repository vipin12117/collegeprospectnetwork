<?php

class AthleteVideo extends AppModel{

	public $name = 'AthleteVideo';

	public $useTable = 'athlete_videos';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getVideo($athlete_id){
		$row = $this->find("first",array("conditions"=>"AthleteVideo.athlete_id = '$athlete_id' AND AthleteVideo.status = 1"));
		return $row;
	}
}