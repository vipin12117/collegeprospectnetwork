<?php

class FootballPosition extends AppModel{

	public $name = 'FootballPosition';

	public $useTable = 'football_positions';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}