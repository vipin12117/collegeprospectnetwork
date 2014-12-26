<?php

class Wingspan extends AppModel{

	public $name = 'Wingspan';

	public $useTable = 'wingspans';

	public function getValues(){
		$rows = $this->find("list",array("conditions"=>"Wingspan.status = 1","fields"=>"name,name"));
		return $rows;
	}
}