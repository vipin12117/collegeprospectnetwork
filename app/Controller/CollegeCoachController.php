<?php

App::uses('CakeEmail', 'Network/Email');

class CollegeCoachController extends AppController{

	public $name = 'CollegeCoach';

	public $uses = array('College','CollegeCoach','CollegeNeed');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$this->redirect(array("controller"=>"Profile","action"=>"index"));
		exit;
	}

	public function addNeed(){
		$this->layout = 'popup';
		$user_id = $this->Session->read('user_id');

		if(isset($this->request->data['CollegeNeed'])){
			$college_id = $this->CollegeCoach->field("college_id","CollegeCoach.id = '$user_id'");
			$this->request->data['CollegeNeed']['college_id'] = $college_id;
			$this->request->data['CollegeNeed']['dateofmodification'] = date('Y-m-d H:i:s');

			$this->CollegeNeed->save($this->request->data);
			$this->set("message","Your need is added successfully");

			$college_need_id = $this->CollegeNeed->getLastInsertId();
			$this->sendNeedAlert($college_need_id);
		}
		else{
			$this->set("user_id",$user_id);
		}
	}

	public function editNeed($college_need_id = false){
		$this->layout = 'popup';
		$user_id = $this->Session->read('user_id');

		if(isset($this->request->data['CollegeNeed'])){
			$college_id = $this->CollegeCoach->field("college_id","CollegeCoach.id = '$user_id'");
			$this->request->data['CollegeNeed']['college_id'] = $college_id;
			$this->request->data['CollegeNeed']['dateofmodification'] = date('Y-m-d H:i:s');

			$this->CollegeNeed->id = $college_need_id;
			$this->CollegeNeed->save($this->request->data);
			$this->set("message","Your need is updated successfully");
		}
		else{
			$this->set("user_id",$user_id);
			$this->set("college_need_id",$college_need_id);
			$this->request->data = $this->CollegeNeed->read(null,$college_need_id);
		}
	}

	public function deleteNeed($college_need_id = false){
		$college_need_id = (int)$college_need_id;
		if($college_need_id){
			$this->CollegeNeed->id = $college_need_id;
			$this->CollegeNeed->delete();

			$this->Session->setFlash("Your need is deleted successfully");
		}

		$user_id = $this->Session->read('user_id');
		$this->redirect(array("controller"=>"Profile","action"=>"collegeCoachProfile",$user_id));
		exit;
	}

	public function viewNeedMatches($college_coach_id = false){

	}

	public function sendNeedAlert($college_need_id = false){
		$this->loadModel("Athlete");

		$college_need_id = (int)$college_need_id;
		if(!$college_need_id){
			$needsMatchs = $this->Athlete->query("select college_id ,firstname , lastname from athletes as Athlete inner join college_needs as CollegeNeed
							 on (Athlete.sport_id = CollegeNeed.sport_id AND Athlete.class = CollegeNeed.grade_class)");
		}
		else{
			$needsMatchs = $this->Athlete->query("select college_id ,firstname , lastname from athletes as Athlete inner join college_needs as CollegeNeed
							 on (Athlete.sport_id = CollegeNeed.sport_id AND Athlete.class = CollegeNeed.grade_class) where CollegeNeed.id = '$college_need_id'");	
		}

		if($needsMatchs){
			$cakeEmail = new CakeEmail();
			$subject  = "College Prospect Network - We've found an athlete who matches your needs!";
			$template = 'college_need_alert_mail';

			foreach($needsMatchs as $needsMatch){
				$first_name  = $needsMatch['Athlete']['firstname'];
				$last_name   = $needsMatch['Athlete']['lastname'];
				$college_id  = $needsMatch['Athlete']['college_id'];

				$collegeCoach = $this->CollegCoach->find("first",array("conditions"=>"CollegCoach.college_id = '$college_id'"));
				$coach_name  = $collegeCoach['CollegCoach']['firstname']." ".$collegeCoach['CollegCoach']['lastname'];
				$coach_email = $collegeCoach['CollegCoach']['email'];
					
				try {
					$cakeEmail->template($template);
					$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
					$cakeEmail->to(array($coach_email => $coach_name));
					$cakeEmail->to(array("admin@collegeprospectnetwork.com" => "Admin"));
					$cakeEmail->subject($subject);
					$cakeEmail->emailFormat('html');
					$cakeEmail->viewVars(array('first_name' => $first_name, 'last_name' => $last_name, 'coach_name' => $coach_name));
					// Send email
					$cakeEmail->send();
				}
				catch (Exception $e){
					//$this->Session->setFlash('Error while sending email');
				}
			}
		}
	}
}