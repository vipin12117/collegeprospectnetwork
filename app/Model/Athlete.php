<?php

class Athlete extends AppModel{

	public $name = 'Athlete';

	public $useTable = 'athletes';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}