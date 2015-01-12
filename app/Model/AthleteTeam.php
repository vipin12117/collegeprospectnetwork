<?php

class AthleteTeam extends AppModel{

	public $name = 'AthleteTeam';

	public $useTable = 'athlete_teams';

	public $belongsTo = array('Athlete','HsAauTeam');

	public function getTeamList($athlete_id){
		$rows = $this->find("all",array("conditions"=>"AthleteTeam.athlete_id = '$athlete_id'"));
		return $rows;
	}

	public function getAthleteList($hs_aau_team_id){
		$rows = $this->find("list",array("conditions"=>"AthleteTeam.hs_aau_team_id = '$hs_aau_team_id' AND AthleteTeam.comments = ''",
										 "fields"=>"athlete_id,athlete_id"));
		return $rows;
	}
}