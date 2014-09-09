<?php

class Banner extends AppModel{

	public $name = 'Banner';

	public $useTable = 'banners';
	
	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
	
	public function getBannerByPosition($position){
		$row = $this->find("all",array("conditions"=>"Banner.position = '$position' AND Banner.status = 1"));
		return $row;
	}
}