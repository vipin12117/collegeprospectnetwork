<?php

class ProfileController extends AppController{

	public $name = 'Profile';

	public $user_type = false;

	public $uses = array('Mail','Network','CollegeCoach','Athlete','HsAauCoach','Event','Banner','Note','AthleteStat','HsAauCoachSportposition');

	public $components = array('Email','Session','Image');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();

		$this->user_type = $this->Session->read('user_type');
	}

	public function index(){
		$this->loadModel('Mail');
		$this->loadModel('Network');

		$username  = $this->Session->read("username");
		$mailCount = $this->Mail->find('count',array('conditions'=>array('Mail.receiver' => $username, 'Mail.status' => 'unread')));
		$this->set("mailCount",$mailCount);

		$user_id = $this->Session->read('user_id');
		$networkCount = $this->Network->find('count',array('conditions'=>array('Network.receiver_id' => $user_id, 'Network.status' => 'Pending')));
		$this->set("networkCount",$networkCount);

		if($this->user_type == 'athlete'){
			$profileDetail = $this->Athlete->getByUsername($username);
			$this->set("profileDetail",$profileDetail);
		}
		elseif($this->user_type == 'college'){
			$profileDetail = $this->CollegeCoach->getByUsername($username);
			$this->set("profileDetail",$profileDetail);
		}
		else{
			$profileDetail = $this->HsAauCoach->getByUsername($username);
			$this->set("profileDetail",$profileDetail);

			$hs_aau_team_id = $profileDetail['HsAauCoach']['hs_aau_team_id'];
			$sports = $this->HsAauCoachSportposition->find("list",array("conditions"=>"hs_aau_coach_id = '$user_id'","fields"=>"sport_id"));
			if($sports){
				$this->loadModel('AthleteTeam');
				$extraAthleteList = $this->AthleteTeam->getAthleteList($hs_aau_team_id);

				$conditions1 = array("Athlete.sport_id"=>$sports,"Athlete.status"=>0,"Athlete.hs_aau_team_id"=>$hs_aau_team_id);
				$conditions2 = array("Athlete.id"=>$extraAthleteList);
					
				$athleteApproval = $this->Athlete->find("count",array("conditions"=>array("OR" => array($conditions1 , $conditions2))));
			}
			else{
				$athleteApproval = 0;
			}

			$athleteStat = $this->AthleteStat->find("first",array("conditions"=>"AthleteStat.hs_aau_coach_id = '$user_id' AND AthleteStat.status = 0 and event_id > 0",
																		  "group"=>"event_id","fields"=> "event_id"));
			$athleteStatApproval = count($athleteStat);
			$this->set("athleteApproval",$athleteApproval);
			$this->set("athleteStatApproval",$athleteStatApproval);
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

		$this->loadModel('AthleteVideo');
		$video = $this->AthleteVideo->getVideo($user_id);
		$this->set("video",$video);

		$notes = $this->Note->getNotesById($user_id,"Athlete");
		$this->set("notes",$notes);

		$athleteStats = $this->AthleteStat->getStatsByAthleteId($user_id);
		$this->set("athleteStats",$athleteStats);

		$hsAauCoach = $this->HsAauCoach->getByHsAauTeamId($profileDetail['Athlete']['hs_aau_team_id']);
		$this->set("hsAauCoach",$hsAauCoach);
		
		$this->loadModel('AthleteTeam');
		$otherComments = $this->AthleteTeam->getTeamList($user_id);
		$this->set("otherComments",$otherComments);

		$this->render("/Profile/athleteProfile");
	}

	public function editAthleteProfile(){
		$user_id  = $this->Session->read('user_id');

		if(isset($this->request->data['Athlete'])){
			$this->request->data['Athlete']['id'] = $user_id;

			//unset these fields
			unset($this->request->data['Athlete']['username']);
			unset($this->request->data['Athlete']['email']);

			$this->Image->set_paths(WWW_ROOT . 'img/athlete/', WWW_ROOT . 'img/athlete/thumb/');
			if(isset($_FILES['image']['tmp_name'])){
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

	public function hsAauCoachProfile($user_id = false){
		$user_id = (int)$user_id;
		if(!$user_id){
			$user_id  = $this->Session->read('user_id');
			$username = $this->Session->read("username");
		}

		$profileDetail = $this->HsAauCoach->getById($user_id);
		$this->set("profileDetail",$profileDetail);

		$banners = $this->Banner->getBannerByPosition('bottom-left');
		$this->set("banners",$banners);

		$this->paginate = array('Athlete' => array("conditions"=>array("Athlete.status"=>"1","Athlete.sport_id"=>$profileDetail['HsAauCoach']['sport_id'],"Athlete.hs_aau_team_id"=>$profileDetail['HsAauTeam']['id'])));
		$athletes = $this->paginate('Athlete');
		$this->set("athletes",$athletes);

		$this->render("/Profile/hsAauCoachProfile");
	}

	public function editHsAauCoachProfile(){
		$user_id  = $this->Session->read('user_id');

		if(isset($this->request->data['HsAauCoach'])){
			$this->request->data['HsAauCoach']['id'] = $user_id;

			//unset these fields
			unset($this->request->data['HsAauCoach']['username']);
			unset($this->request->data['HsAauCoach']['email']);

			$sports = $this->request->data['HsAauCoach']['sport_id'];
			$positions = $this->request->data['HsAauCoach']['position'];

			$this->request->data['HsAauCoach']['sport_id'] = $this->request->data['HsAauCoach']['sport_id'][0];
			$this->request->data['HsAauCoach']['position'] = $this->request->data['HsAauCoach']['position'][0];

			if(isset($this->request->data['Athlete']['hs_aau_team_id'])){
				$this->request->data['HsAauCoach']['hs_aau_team_id'] = $this->request->data['Athlete']['hs_aau_team_id'];
			}

			$this->HsAauCoach->save($this->request->data);

			$sportPositions = array();
			//insert all sports
			foreach($sports as $i => $value){
				$sportPosition = array();
				$sportPosition['sport_id'] = $value;
				$sportPosition['position'] = $positions[$i];
				$sportPosition['hs_aau_coach_id'] = $user_id;

				try{
					$this->HsAauCoachSportposition->create();
					$this->HsAauCoachSportposition->save(array("HsAauCoachSportposition"=>$sportPosition));
				}
				catch(Exception $e){

				}

				$sportPositions[] = $sportPosition;
			}

			$this->Session->setFlash("Profile is updated successfully");
			$this->redirect(array("controller"=>"Profile","action"=>"hsAauCoachProfile"));
			exit;
		}
		else{
			$this->request->data = $this->HsAauCoach->getById($user_id);

			$this->loadModel('HsAauTeam');
			$state_id = $this->HsAauTeam->field("state","HsAauTeam.id = '".$this->request->data['HsAauCoach']['hs_aau_team_id']."'");
			$this->request->data['HsAauCoach']['state_id'] = $state_id;

			$colleges = $this->HsAauTeam->find("list",array("conditions"=>"state='$state_id'","fields"=>"id,school_name","order"=>"school_name ASC"));
			$colleges['Other'] = array("Other"=>"Add your school");
			$this->set("colleges",$colleges);

			$this->render("/Profile/editHsAauCoachProfile");
		}
	}

	public function collegeCoachProfile($user_id = false){
		$user_id = (int)$user_id;
		if(!$user_id){
			$user_id  = $this->Session->read('user_id');
			$username = $this->Session->read("username");
		}

		$profileDetail = $this->CollegeCoach->getById($user_id);
		$this->set("profileDetail",$profileDetail);

		$this->loadModel('CollegeNeed');
		$collegeNeeds = $this->CollegeNeed->getByCollegeId($profileDetail['CollegeCoach']['college_id']);
		$this->set("collegeNeeds",$collegeNeeds);

		$networkRequests = $this->Network->find("all",array("conditions"=>"Network.receiver_id = '$user_id' and Network.status = 'Active'"));
		$this->set("networkRequests",$networkRequests);

		$this->render("/Profile/collegeCoachProfile");
	}

	public function editCollegeCoachProfile(){
		$user_id  = $this->Session->read('user_id');

		if(isset($this->request->data['CollegeCoach'])){
			$this->request->data['CollegeCoach']['id'] = $user_id;

			//unset these fields
			unset($this->request->data['CollegeCoach']['username']);
			unset($this->request->data['CollegeCoach']['email']);

			$this->CollegeCoach->save($this->request->data);

			$this->Session->setFlash("Profile is updated successfully");
			$this->redirect(array("controller"=>"Profile","action"=>"collegeCoachProfile"));
			exit;
		}
		else{
			$this->request->data = $this->CollegeCoach->getById($user_id);

			$this->loadModel('College');
			$state_id = $this->request->data['CollegeCoach']['state'];
			$this->request->data['CollegeCoach']['state_id'] = $state_id;

			$colleges = $this->College->find("list",array("conditions"=>"state='$state_id'","fields"=>"id,name","order"=>"name ASC"));
			$colleges['Other'] = array("Other"=>"Add your college");
			$this->set("colleges",$colleges);

			$this->render("/Profile/editCollegeCoachProfile");
		}
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

	public function getHsAauSchools($id = 1){
		$this->autoLayout = false;
		$this->autoRender = false;

		$state_id = @$this->request->query['data']['AthleteTeam']['state_id1'];
		if(!$state_id){
			$state_id = @$this->request->query['data']['AthleteTeam']['state_id2'];
		}

		if(!$state_id){
			return false;
		}

		if(!$this->RequestHandler->isAjax()){
			$this->redirect(array("controller"=>"Home","action"=>"index"));
			exit;
		}

		$this->loadModel('HsAauTeam');
		$colleges = $this->HsAauTeam->find("list",array("conditions"=>"state='$state_id'","fields"=>"id,school_name","order"=>"school_name ASC"));
		$this->set("colleges",$colleges);

		if($id == 1){
			$this->set("column","hs_aau_team_id1");
			$this->set("hs_aau_team_col","hs_aau_team_id1");
			$this->set("school_address_col","school_address1");
			$this->set("col_title","High School");
		}
		else{
			$this->set("column","hs_aau_team_id2");
			$this->set("hs_aau_team_col","hs_aau_team_id2");
			$this->set("school_address_col","school_address2");
			$this->set("col_title","High School/AAU Team");
		}

		$this->render("/Profile/getSchools","ajax");
	}
}