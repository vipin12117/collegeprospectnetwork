<?php

class HsAauCoachController extends AppController{

	public $name = 'HsAauCoach';

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
		$this->set("title_for_layout","College Prospect Network - HS / AAU Coach Listing");

		$conditions = array();

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('HsAauCoach'=>array("conditions"=>$conditions_str,"limit"=>20,"order"=>"firstname asc"));
		}
		else{
			$this->paginate = array('HsAauCoach'=>array("limit"=>20,"order"=>"firstname asc"));
		}

		$hsAauCoaches = $this->paginate('HsAauCoach');
		$this->set("hsAauCoaches",$hsAauCoaches);
	}
	
	public function admin_coachList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			$schoolName =  $this->request->data['school_name'];

			if (!empty($searchName)){
				if (!empty($schoolName)){
					$conditions = array('AND' => array('HsAauCoach.hs_aau_team_id' => $schoolName, 'OR' => array('HsAauCoach.firstname LIKE ' => '%'.$searchName.'%', 'HsAauCoach.lastname LIKE ' => '%'.$searchName.'%')));
				} else {
					$conditions = array('OR' => array('HsAauCoach.firstname LIKE ' => '%'.$searchName.'%', 'HsAauCoach.lastname LIKE ' => '%'.$searchName.'%'));
				}
			} else {
				if (!empty($schoolName)){
					$conditions = array('HsAauCoach.hs_aau_team_id' => $schoolName);
				} else {
					$conditions = array();
				}
			}

			$limit = 100;
			$this->loadModel('HsAauCoach');
			$this->paginate = array('HsAauCoach'=>array('fields' => array('HsAauCoach.id', 'HsAauCoach.username', 'HsAauCoach.email', 'HsAauCoach.phone', 'HsAauCoach.firstname', 'HsAauCoach.lastname', 'HsAauCoach.sport_id', 'HsAauCoach.status'),
													 'conditions' => $conditions,
													 'order' =>  array('HsAauCoach.id'),
													 'limit' => $limit));
			
			$this->loadModel('HsAauTeam');
			$hsAauTeams = $this->HsAauTeam->find('all', array('fields' => array('HsAauTeam.id', 'HsAauTeam.school_name'),
													  'order' => array('HsAauTeam.school_name')));			                                          
														 
			$schoolList = array();
			foreach ($hsAauTeams as $hsAauTeam){
				$schoolList[$hsAauTeam['HsAauTeam']['id']] = $hsAauTeam['HsAauTeam']['school_name'];
			}
			
			$hsAauCoachs = $this->paginate('HsAauCoach');
			$this->set(compact('hsAauCoachs', 'limit', 'schoolList'));

		} else {
			
			$limit = 100;
			$this->loadModel('HsAauCoach');
			$this->paginate = array('HsAauCoach'=>array('fields' => array('HsAauCoach.id', 'HsAauCoach.username', 'HsAauCoach.email', 'HsAauCoach.phone', 'HsAauCoach.firstname', 'HsAauCoach.lastname', 'HsAauCoach.sport_id', 'HsAauCoach.status'),
													 'order' =>  array('HsAauCoach.id'),
													 'limit' => $limit));
			$hsAauCoachs = $this->paginate('HsAauCoach');
			
			$this->loadModel('HsAauTeam');
			$hsAauTeams = $this->HsAauTeam->find('all', array('fields' => array('HsAauTeam.id', 'HsAauTeam.school_name'),
													  'order' => array('HsAauTeam.school_name')));			                                          
														 
			$schoolList = array();
			foreach ($hsAauTeams as $hsAauTeam){
				$schoolList[$hsAauTeam['HsAauTeam']['id']] = $hsAauTeam['HsAauTeam']['school_name'];
			}
			
			$this->set(compact('hsAauCoachs', 'limit', 'schoolList'));
		}
	}
	
	public function admin_coachEdit($id){
		
	}
	
	public function admin_deleteCoach($id){
		if (isset($id)){
			$this->HsAauCoach->delete($id);
			$this->Session->setFlash('High School / AAU Coach Deleted Successfully!', 'flash_success');			
		} else {
			$this->Session->setFlash('Do not exits this High School / AAU Coach.', 'flash_error');
		}
		$this->redirect($this->referer());
	}
	
	public function admin_coachDetails($id){
		if (isset($id)){
			$this->loadModel('HsAauCoach');
			$hsAauCoach = $this->HsAauCoach->findById($id);
			$this->set('hsAauCoach', $hsAauCoach);
		} else {
			$this->Session->setFlash('Do not exits this HsAauCoach', 'flash_error');
		}
	}
	
	public function admin_viewRatingHsAauCoach($id){
		if (isset($id)){
			$this->loadModel('HsAauCoachRating');
			$hsAauCoachRating = $this->HsAauCoachRating->findById($id);
			$this->set('hsAauCoachRating', $hsAauCoachRating);
		} else {
			$this->Session->setFlash('Do not exits this HsAauCoachRating', 'flash_error');
		}
	}
}