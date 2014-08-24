<?php

class Network extends AppModel{

	public $name = 'Network';

	public $useTable = 'networks';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}