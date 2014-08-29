<?php

class Page extends AppModel{

	public $name = 'Page';

	public $useTable = 'pages';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	public function getPageDetails($page_key){
		$row = $this->find("first",array("conditions"=>array("Page.page_key = '$page_key'")));
		return $row;
	}
}