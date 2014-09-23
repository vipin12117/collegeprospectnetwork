<?php

class AthleteController extends AppController{

	public $name = 'Athlete';
	
	public $components = array('Session');

	public function beforeFilter(){
		parent::beforeFilter();
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') ////for admin section template
        {
        	if ($this->checkAdminSession()){
            	$this->layout = 'admin';
        	} else {
        		$this->redirect(array('controller'=>'admin','action'=>'login'));
        	}
		} else {
			$this->checkSession();
		}
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - Athlete Search");

		$conditions = array();
		if(@$_GET['division']){
			$_GET['division'] = $this->filterKeyword($_GET['division']);
			$conditions[] = "Athlete.division = '{$_GET['division']}'";
			$this->set("division",$_GET['division']);
		}

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('Athlete'=>array("conditions"=>$conditions_str,"limit"=>10));
		}
		else{
			$this->paginate = array('Athlete'=>array("limit"=>10));
		}

		$athletes = $this->paginate('Athlete');
		$this->set("athletes",$athletes);
	}

	public function approval(){

	}

	public function stats(){

	}

	public function invite(){

	}

	public function search(){
		$this->set("title_for_layout","College Prospect Network - Athlete Search");

		$conditions = array();
		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('Athlete'=>array("conditions"=>$conditions_str,"limit"=>10));
		}
		else{
			$this->paginate = array('Athlete'=>array("limit"=>10));
		}

		$athletes = $this->paginate('Athlete');
		$this->set("athletes",$athletes);
	}

	public function addRating($networkId, $athleteId, $isAdded){
		$userId = $this->Session->read('user_id');
		if (isset($userId)){			
			$this->redirect(array('controller' => 'Network', 'action' => 'requests'));
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}
	
	public function admin_list(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			if (!empty($searchName)){
				$conditions = array('OR' => array('Athlete.firstname LIKE ' => '%'.$searchName.'%', 'Athlete.lastname LIKE ' => '%'.$searchName.'%'));
			} else {
				$conditions = array();
			}
			
			$limit = 100;
			$this->loadModel('Athlete');
			$this->paginate = array('Athlete'=>array('fields' => array('Athlete.id', 'Athlete.username', 'Athlete.email', 'Athlete.firstname', 'Athlete.lastname', 'Athlete.sport_id', 'Athlete.status'),
													 'conditions' => $conditions,
													 'order' =>  array('Athlete.id'),
													 'limit' => $limit));
			$athletes = $this->paginate('Athlete');
			$this->set(compact('athletes', 'limit'));

		} else {
			
			$limit = 100;
			$this->loadModel('Athlete');
			$this->paginate = array('Athlete'=>array('fields' => array('Athlete.id', 'Athlete.username', 'Athlete.email', 'Athlete.firstname', 'Athlete.lastname', 'Athlete.sport_id', 'Athlete.status'),
													 'order' =>  array('Athlete.id'),
													 'limit' => $limit));
			$athletes = $this->paginate('Athlete');
			$this->set(compact('athletes', 'limit'));
		}
	}
	
	public function admin_activeRecord($id){
		if (!empty($id)) {
			$this->Athlete->id = $id;
			$this->Athlete->saveField('status', 1);
			$this->Session->setFlash('Athelete Approved Successfully!', 'flash_success');
			$this->redirect($this->referer());		
		} else {
			$this->Session->setFlash('Do not exits this athlete', 'flash_error');
			$this->redirect($this->referer());
		}
	}
}