<?php

class Rating extends AppModel{

	public $name = 'Rating';

	public $useTable = 'ratings';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	public function getAverageRating($athlete_id){
		$values  = array('leadership','work_ethic','primacy_go_to_guy','mental_toughness','composure','awareness','instincts','vision','conditioning','physical_toughness','tenacity','hustle','strength');
		$sum_str = "( ";
		$sum_str .= implode(" + ", $values);
		$sum_str .= ") / 13";

		$row = $this->find("first",array("fields"=>"$sum_str as rating","conditions"=>"Rating.athlete_id = '$athlete_id'"));
		if($row){
			return number_format($row[0]['rating'],2);
		}
		else{
			return 0;
		}
	}
}