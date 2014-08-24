<?php

class Subscription extends AppModel{

	public $name = 'Subscription';

	public $useTable = 'subscriptions';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}