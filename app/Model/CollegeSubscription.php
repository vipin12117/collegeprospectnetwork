<?php

class CollegeSubscription extends AppModel{

	public $name = 'CollegeSubscription';

	public $useTable = 'college_subscriptions';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}