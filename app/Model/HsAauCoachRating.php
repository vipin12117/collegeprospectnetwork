<?php

class HsAauCoachRating extends AppModel{

	public $name = 'HsAauCoachRating';

	public $useTable = 'hs_aau_coach_rating';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}