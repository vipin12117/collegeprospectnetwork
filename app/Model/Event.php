<?php

class Event extends AppModel{

	public $name = 'Event';

	public $useTable = 'events';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}