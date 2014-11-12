<?php

class RatingController extends AppController{

	public $name = 'Rating';

	public $uses = array();

	public function index(){

	}

	public function coachRating($hs_aau_coach_id = false){

	}

	public function viewCoachRating($hs_aau_coach_id = false){

	}

	public function viewAthleteRating($athlete_id = false){
		$ratingExist = $this->Rating->find("first",array("conditions"=>"Rating.athlete_id = '$athlete_id'"));
		$this->set("ratingExist",$ratingExist);
	}
}