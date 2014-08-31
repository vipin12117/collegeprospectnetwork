<?php

class HsAauTeam extends AppModel{

	public $name = 'HsAauTeam';

	public $useTable = 'hs_aau_team';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}