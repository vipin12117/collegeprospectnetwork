<?php

class SpecialEvent extends AppModel{

	public $name = 'SpecialEvent';

	public $useTable = 'special_events';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}