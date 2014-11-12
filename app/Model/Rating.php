<?php

class Rating extends AppModel{

	public $name = 'Rating';

	public $useTable = 'ratings';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}