<?php

class HsAauCoachSportposition extends AppModel{

	public $name = 'HsAauCoachSportposition';

	public $useTable = 'hs_aau_coach_sportpositions';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}