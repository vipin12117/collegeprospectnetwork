<?php

class HaAauTeam extends AppModel{

	public $name = 'HaAauTeam';

	public $useTable = 'hs_aau_team';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}