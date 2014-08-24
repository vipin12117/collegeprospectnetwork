<?php

class AthleteVideo extends AppModel{

	public $name = 'AthleteVideo';

	public $useTable = 'athlete_videos';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}