<?php

class Page extends AppModel{

	public $name = 'Page';

	public $useTable = 'pages';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}