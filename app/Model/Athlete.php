<?php

class Athlete extends AppModel{

	public $name = 'Athlete';

	public $useTable = 'athletes';

	public $belongsTo = array('Sport','HsAauTeam');

	public function getByUsername($username){
		$row = $this->find("first",array("conditions"=>"Athlete.username = '$username'"));
		return $row;
	}

	public function getById($id){
		$row = $this->find("first",array("conditions"=>"Athlete.id = '$id'"));
		return $row;
	}
}