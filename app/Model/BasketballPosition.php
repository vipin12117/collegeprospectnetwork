<?php

class BasketballPosition extends AppModel{

	public $name = 'BasketballPosition';

	public $useTable = 'basketball_positions';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}