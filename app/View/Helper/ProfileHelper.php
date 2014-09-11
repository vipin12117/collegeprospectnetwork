<?php

class ProfileHelper extends AppHelper{

	public $name = "Profile";

	public function index($user_id , $type){
		switch ($type) {
			case 'athlete':
				$profile = $this->getAthleteInfo($user_id);
				return $profile;
				break;
			case 'college':
				$profile = $this->getCollegeCoachInfo($user_id);
				return $profile;
				break;
			default:
				$profile = $this->getHsAauCoachInfo($user_id);
				return $profile;
				break;
		}
	}

	public function getAthleteInfo($user_id){
		App::import("Model","Athlete");
		$this->Athlete = new Athlete();

		return $this->Athlete->getById($user_id);
	}

	public function getHsAauCoachInfo($user_id){
		App::import("Model","HsAauCoach");
		$this->HsAauCoach = new HsAauCoach();

		return $this->HsAauCoach->getById($user_id);
	}

	public function getCollegeCoachInfo($user_id){
		App::import("Model","CollegeCoach");
		$this->CollegeCoach = new CollegeCoach();

		return $this->CollegeCoach->getById($user_id);
	}
}