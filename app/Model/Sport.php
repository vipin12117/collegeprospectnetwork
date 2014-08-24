<?php

class Sport extends AppModel{

	public $name = 'Sport';

	public $useTable = 'sports';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}