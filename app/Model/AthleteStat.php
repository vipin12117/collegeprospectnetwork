<?php

class AthleteStat extends AppModel{

	public $name = 'AthleteStat';

	public $useTable = 'athelete_stats';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}