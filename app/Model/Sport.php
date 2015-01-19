<?php

class Sport extends AppModel{

	public $name = 'Sport';

	public $useTable = 'sports';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getSportList(){
		$rows = $this->find("list",array("fields"=>"id,name"));
		return $rows;
	}
}