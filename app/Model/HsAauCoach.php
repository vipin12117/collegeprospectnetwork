<?php

class HsAauCoach extends AppModel{

	public $name = 'HsAauCoach';

	public $useTable = 'hs_aau_coach';
	
	public $belongsTo = array('Sport','HsAauTeam');

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	public function getByUsername($username){
		$row = $this->find("first",array("conditions"=>"Lower(HsAauCoach.username) = Lower('$username')"));
		return $row;
	}

	public function getById($id){
		$row = $this->find("first",array("conditions"=>"HsAauCoach.id = '$id'"));
		return $row;
	}
	
	public function getByHsAauTeamId($hs_aau_team_id){
		$row = $this->find("all",array("conditions"=>"HsAauCoach.hs_aau_team_id = '$hs_aau_team_id'"));
		return $row;
	}
}