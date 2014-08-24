<?php

class College extends AppModel{

	public $name = 'College';

	public $useTable = 'colleges';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}