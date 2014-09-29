<?php

class CollegeController extends AppController{

	public $name = 'College';

	public $uses = array('College','CollegeCoach','Athlete','HsAauCoach');

	public function beforeFilter(){
		parent::beforeFilter();
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') ////for admin section template
        {
        	if ($this->checkAdminSession()){
            	$this->layout = 'admin';
        	} else {
        		$this->redirect(array('controller'=>'admins','action'=>'login'));
        	}
		} else {
			$this->checkSession();
		}
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - College Coach Listing");

		$user_id   = $this->Session->read('user_id');
		$user_type = $this->Session->read('user_type');

		$sport_id = 0;
		switch ($user_type){
			case 'Athlete':
				$athlete  = $this->Athlete->getById($user_id);
				$sport_id = $athlete['Athlete']['sport_id'];
				break;
			case 'CollegeCoach':
				$collegeCoach = $this->CollegeCoach->getById($user_id);
				$sport_id = $collegeCoach['CollegeCoach']['sport_id'];
				break;
			case 'HsAauCoach':
				$hsAauCoach = $this->HsAauCoach->getById($user_id);
				$sport_id = $hsAauCoach['HsAauCoach']['sport_id'];
				break;
		}

		$conditions = array();
		if($sport_id){
			$conditions[] = "CollegeCoach.sport_id = '$sport_id'";
		}

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('CollegeCoach'=>array("conditions"=>$conditions_str,"limit"=>20,"order"=>"firstname asc"));
		}
		else{
			$this->paginate = array('CollegeCoach'=>array("limit"=>20,"order"=>"firstname asc"));
		}

		$collegeCoaches = $this->paginate('CollegeCoach');
		$this->set("collegeCoaches",$collegeCoaches);
	}

	public function matches(){
		$this->set("title_for_layout","College Prospect Network - College Coach Listing");

		$user_id   = $this->Session->read('user_id');
		$user_type = $this->Session->read('user_type');

		$athlete  = $this->Athlete->getById($user_id);
		$sport_id = $athlete['Athlete']['sport_id'];

		$conditions = array();
		if($sport_id){
			$conditions[] = "CollegeCoach.sport_id = '$sport_id'";
		}

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('CollegeCoach'=>array("conditions"=>$conditions_str,"limit"=>20,"order"=>"firstname asc"));
		}
		else{
			$this->paginate = array('CollegeCoach'=>array("limit"=>20,"order"=>"firstname asc"));
		}

		$collegeCoaches = $this->paginate('CollegeCoach');
		$this->set("collegeCoaches",$collegeCoaches);
	}
	
	public function admin_addCollege(){
		if ($this->request->is('post')){			
			// Check exits.
			$college = $this->College->findByName($this->request->data['name']);
			if (!empty($college)){
				$this->Session->setFlash('This College Already Exists!', 'flash_error');
			} else {
				$colleges = array();
				$colleges['College']['name'] = $this->request->data['name'];
				$colleges['College']['address_1'] = $this->request->data['address_1'];
				$colleges['College']['city'] = $this->request->data['city'];
				$colleges['College']['state'] = $this->request->data['state'];
				$colleges['College']['zip'] = $this->request->data['zip'];
				$colleges['College']['divison'] = $this->request->data['divison'];
				$colleges['College']['status'] = $this->request->data['status'];
				
				if ($this->College->save($colleges)){
					$this->Session->setFlash('College is Added Successfully', 'flash_success');
					$this->redirect(array('controller' => 'College', 'action' => 'listCollege'));
				} else {
					$this->Session->setFlash('Can not add this College', 'flash_error');
				}
			}
		} 
	}
	
	public function admin_listOther(){
		if ($this->request->is('post')){
			$limit = 100;
			$this->loadModel('Other');
			$others = $this->paginate('Other');
			$this->set(compact('others', 'limit'));
		} else {
			$limit = 100;
			$this->loadModel('Other');			
			$others = $this->paginate('Other');
			$this->set(compact('others', 'limit'));
		}
	}
	
}