<?php

class ManagePoint extends AppModel{

	public $name = 'ManagePoint';

	public $useTable  = 'manage_points';

	public $belongsTo = array('Athlete');

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	/****** RATING MANAGEMENT SYSTEM *******/
	public function setAtheleteRating($athlete_id,$rating_type,$rating_val,$status = false){
		$isExist = $this->find("first",array("conditions"=>"athlete_id = '$athlete_id'"));
	
		if($status == true){
			if($isExist){
				$rating_val = $isExist['ManagePoint'][$rating_type];
				$rating_val = ($rating_val + $rating_val);

				$this->id = $isExist['ManagePoint']['id'];
				$this->saveField($rating_type, $rating_val);
			}
			else
			{
				$manage_point = array();
				$manage_point[$rating_type] = $rating_val;
				$manage_point['athlete_id'] = $athlete_id;
				$this->create(1);
				$this->save(array("ManagePoint" => $manage_point));
			}
		}
		
		return 1;
	}
}