<?php

class ProfileController extends AppController{

	public $name = 'Profile';

	public $user_type = false;

	public $uses = array('Mail','Network','CollegeCoach','Athlete','HsAauCoach','Event','Banner','AthleteVideo','Note','AthleteStat');

	public $components = array('Email','Session');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();

		$this->user_type = $this->Session->read('user_type');
	}

	public function index(){
		App::import("Model","Mail");
		$this->Mail = new Mail();

		App::import("Model","Network");
		$this->Network = new Network();

		$username  = $this->Session->read("username");
		$mailCount = $this->Mail->find("count",array("conditions"=>"Mail.receiver = '$username' and Mail.status = 'unread'"));
		$this->set("mailCount",$mailCount);

		$user_id = $this->Session->read('user_id');
		$networkCount = $this->Network->find("count",array("conditions"=>"Network.receiver_id = '$user_id' and Network.status = 'unread'"));
		$this->set("networkCount",$networkCount);

		$is_trial_mode = false;
		if($this->Session->read('user_type') == 'Athlete'){
			$profileDetail = $this->Athlete->getByUsername($username);
			$this->set("profileDetail",$profileDetail);

			$total_days = time() - strtotime($profileDetail['Athlete']['added_date']);
			if($total_days > (5*24*60*60)){
				$is_trial_mode = true;
			}
			$this->set("is_trial_mode",$is_trial_mode);
		}
		elseif($this->Session->read('user_type') == 'CollegeCoach'){
			$profileDetail = $this->CollegeCoach->getByUsername($username);
			$this->set("profileDetail",$profileDetail);
		}
		else{
			$profileDetail = $this->HsAauCoach->getByUsername($username);
			$this->set("profileDetail",$profileDetail);
		}

		$this->render("/Profile/index");
	}

	public function athleteProfile($user_id = false){
		$user_id = (int)$user_id;
		if(!$user_id){
			$user_id  = $this->Session->read('user_id');
			$username = $this->Session->read("username");
		}

		$profileDetail = $this->Athlete->getById($user_id);
		$this->set("profileDetail",$profileDetail);

		//upcoming events
		$events = $this->Event->getUpcomingEvents($profileDetail['Athlete']['sport_id']);
		$this->set("events",$events);

		$banners = $this->Banner->getBannerByPosition('bottom-left');
		$this->set("banners",$banners);

		$video = $this->AthleteVideo->getVideo($user_id);
		$this->set("video",$video);

		$notes = $this->Note->getNotesById($user_id,"Athlete");
		$this->set("notes",$notes);

		$athleteStats = $this->AthleteStat->getStatsByAthleteId($user_id);
		$this->set("athleteStats",$athleteStats);
		
		$hsAauCoach = $this->HsAauCoach->getByHsAauTeamId($profileDetail['Athlete']['hs_aau_team_id']);
		$this->set("hsAauCoach",$hsAauCoach);

		$this->render("/Profile/athleteProfile");
	}

	public function editAthleteProfile(){


		$this->render("/Profile/editAthleteProfile");
	}

	public function hsAauCoachProfile(){


		$this->render("/Profile/hsAauCoachProfile");
	}

	public function editHsAauCoachProfile(){


		$this->render("/Profile/editHsAauCoachProfile");
	}

	public function collegeCoachProfile(){


		$this->render("/Profile/collegeCoachProfile");
	}

	public function editCollegeCoachProfile(){


		$this->render("/Profile/editCollegeCoachProfile");
	}

	public function changePassword(){


		$this->render("/Profile/changePassword");
	}
}