<?php

class Athletes extends AppModel{

	public $name = 'Athletes';

	public $useTable = 'athletes';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}