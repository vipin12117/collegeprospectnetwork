<?php

class RatingController extends AppController{

	public $name = 'Rating';

	public $uses = array('Rating');

	public function index(){

	}

	public function coachRating($hs_aau_coach_id = false){

	}

	public function viewCoachRating($hs_aau_coach_id = false){

	}

	public function viewAthleteRating($athlete_id = false){
		$this->layout = 'popup';

		$values = array('leadership','work_ethic','primacy_go_to_guy','mental_toughness','composure','awareness','instincts','vision','conditioning','physical_toughness','tenacity','hustle','strength');
		foreach($values as $value){
			$fields[] = "ROUND(avg($value),1) as $value";
		}
		
		$ratingExist = $this->Rating->find("first",array("conditions"=>"Rating.athlete_id = '$athlete_id'","fields"=>$fields));
		$this->set("ratingExist",$ratingExist);
	}
}