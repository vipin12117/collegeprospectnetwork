<?php

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
}