<?php

class AthleteStatCategory extends AppModel{

	public $name = 'AthleteStatCategory';

	public $useTable = 'athelete_stat_categories';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}