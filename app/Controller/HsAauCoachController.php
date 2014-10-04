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
			if (!empty($searchName)){
				$conditions = array('OR' => array('HsAauCoach.firstname LIKE ' => '%'.$searchName.'%', 'HsAauCoach.lastname LIKE ' => '%'.$searchName.'%'));
			} else {
				$conditions = array();
			}
			
			$limit = 100;
			$this->loadModel('HsAauCoach');
			$this->paginate = array('HsAauCoach'=>array('fields' => array('HsAauCoach.id', 'HsAauCoach.username', 'HsAauCoach.email', 'HsAauCoach.firstname', 'HsAauCoach.lastname', 'HsAauCoach.sport_id', 'HsAauCoach.status'),
													 'conditions' => $conditions,
													 'order' =>  array('HsAauCoach.id'),
													 'limit' => $limit));
			$hsAauCoachs = $this->paginate('HsAauCoach');
			$this->set(compact('hsAauCoachs', 'limit'));

		} else {
			
			$limit = 100;
			$this->loadModel('HsAauCoach');
			$this->paginate = array('HsAauCoach'=>array('fields' => array('HsAauCoach.id', 'HsAauCoach.username', 'HsAauCoach.email', 'HsAauCoach.firstname', 'HsAauCoach.lastname', 'HsAauCoach.sport_id', 'HsAauCoach.status'),
													 'order' =>  array('HsAauCoach.id'),
													 'limit' => $limit));
			$hsAauCoachs = $this->paginate('HsAauCoach');
			$this->set(compact('hsAauCoachs', 'limit'));
		}
	}
	
	public function admin_coachEdit($id){
		
	}
}