<?php

class OpponentComment extends AppModel{

	public $name = 'OpponentComment';

	public $useTable = 'opponent_comments';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}