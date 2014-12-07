<?php

class HsAauCoachSportposition extends AppModel{

	public $name = 'HsAauCoachSportposition';

	public $useTable = 'hs_aau_coach_sportpositions';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getSportsByCoachId($hs_aau_coach_id){
		$rows = $this->find("list",array("conditions"=>"hs_aau_coach_id = '$hs_aau_coach_id'","fields"=>"sport_id,sport_id"));
		return $rows;
	}
}