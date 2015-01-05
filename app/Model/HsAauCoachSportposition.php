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
	
	public function getCoachListBySportId($sport_id){
		$q =   'SELECT 
					HsAauCoach.id,
					HsAauCoach.firstname,
					HsAauCoach.lastname,
					HsAauCoach.username
				FROM 
					hs_aau_coach_sportpositions HsAauCoachSportposition,
					hs_aau_coach HsAauCoach			
				WHERE 
					(HsAauCoach.id = HsAauCoachSportposition.hs_aau_coach_id AND HsAauCoachSportposition.sport_id = '.$sport_id.')
				GROUP BY
					HsAauCoach.lastname';  
				
		$results = $this->query($q);
		return $results;
	}
	
}