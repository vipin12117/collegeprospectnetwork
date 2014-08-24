<?php

class SpecialEventUser extends AppModel{

	public $name = 'SpecialEventUser';

	public $useTable = 'special_event_users';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}