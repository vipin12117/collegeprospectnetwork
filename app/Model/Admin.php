<?php

class Admin extends AppModel{

	public $name = 'Admin';

	public $useTable = 'admin';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}