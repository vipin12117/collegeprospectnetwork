<?php

class Classes extends AppModel{

	public $name = 'Classes';

	public $useTable = 'classes';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}