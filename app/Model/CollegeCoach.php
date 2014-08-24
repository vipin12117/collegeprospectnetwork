<?php

class CollegeCoach extends AppModel{

	public $name = 'CollegeCoach';

	public $useTable = 'college_coaches';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}