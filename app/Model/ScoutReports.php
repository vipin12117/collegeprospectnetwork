<?php

class ScoutReports extends AppModel{

	public $name = 'ScoutReports';

	public $useTable = 'scout_reports';

	public function getValues(){
		$rows = $this->find("list",array("fields"=>"id,title"));
		return $rows;
	}
}