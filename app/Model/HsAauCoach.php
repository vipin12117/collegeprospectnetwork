<?php

class HsAauCoach extends AppModel{

	public $name = 'HsAauCoach';

	public $useTable = 'hs_aau_coach';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}