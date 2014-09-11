<?php

class ProfileController extends AppController{

	public $name = 'Profile';

	public $user_type = false;

	public $uses = array('Mail','Network','CollegeCoach','Athlete','HsAauCoach','Event','Banner','AthleteVideo','Note','AthleteStat');

	public $components = array('Email','Session','Image');

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
		if($this->user_type == 'Athlete'){
			$profileDetail = $this->Athlete->getByUsername($username);
			$this->set("profileDetail",$profileDetail);

			$total_days = time() - strtotime($profileDetail['Athlete']['added_date']);
			if($total_days > (5*24*60*60)){
				$is_trial_mode = true;
			}
			$this->set("is_trial_mode",$is_trial_mode);
		}
		elseif($this->user_type == 'CollegeCoach'){
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
		$user_id  = $this->Session->read('user_id');

		if(isset($this->request->data['Athlete'])){
			$this->request->data['Athlete']['id'] = $user_id;

			//unset these fields
			unset($this->request->data['Athlete']['username']);
			unset($this->request->data['Athlete']['email']);

			if($this->request->data['Athlete']['image']){
				$this->Image->set_paths(WWW_ROOT . 'img/athlete/', WWW_ROOT . 'img/athlete/thumb/');

				$this->request->data['Athlete']['image'] = $_FILES['image'];
				$photo_path = $this->Image->upload_image('Athlete.image');

				$this->request->data['Athlete']['image'] = basename($photo_path);
			}
			else{
				unset($this->request->data['Athlete']['image']);
			}

			$this->Athlete->save($this->request->data);

			$this->Session->setFlash("Profile is updated successfully");
			$this->redirect(array("controller"=>"Profile","action"=>"athleteProfile"));
			exit;
		}
		else{
			$this->request->data = $this->Athlete->getById($user_id);
			$this->render("/Profile/editAthleteProfile");
		}
	}

	public function hsAauCoachProfile(){


		$this->render("/Profile/hsAauCoachProfile");
	}

	public function editHsAauCoachProfile(){
		$user_id  = $this->Session->read('user_id');
		$profileDetail = $this->Athlete->getById($user_id);
		$this->set("profileDetail",$profileDetail);

		$this->render("/Profile/editHsAauCoachProfile");
	}

	public function collegeCoachProfile(){


		$this->render("/Profile/collegeCoachProfile");
	}

	public function editCollegeCoachProfile(){
		$user_id  = $this->Session->read('user_id');
		$profileDetail = $this->Athlete->getById($user_id);
		$this->set("profileDetail",$profileDetail);

		$this->render("/Profile/editCollegeCoachProfile");
	}

	public function changePassword(){
		$user_id  = $this->Session->read('user_id');

		if(isset($this->request->data['Athlete'])){
			if($this->user_type == 'HsAauCoach'){
				$this->request->data['HsAauCoach']['id'] = $user_id;
				$this->request->data['HsAauCoach']['password'] = $this->request->data['Athlete']['password'];
				$this->HsAauCoach->save($this->request->data);
			}
			elseif($this->user_type == 'CollegeCoach'){
				$this->request->data['CollegeCoach']['id'] = $user_id;
				$this->request->data['CollegeCoach']['password'] = $this->request->data['Athlete']['password'];
				$this->CollegeCoach->save($this->request->data);
			}
			else{
				$this->request->data['Athlete']['id'] = $user_id;
				$this->Athlete->save($this->request->data);
			}

			$this->Session->setFlash("Your password is updated successfully");
			$this->redirect(array("controller"=>"Profile","action"=>"athleteProfile"));
			exit;
		}

		$this->render("/Profile/changePassword");
	}
}