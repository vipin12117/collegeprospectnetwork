<?php

class ScoutReport extends AppModel{

	public $name = 'ScoutReport';

	public $useTable = 'scout_report';

	public function getValues(){
		$rows = $this->find("list",array("fields"=>"id,firstname"));
		return $rows;
	}
}