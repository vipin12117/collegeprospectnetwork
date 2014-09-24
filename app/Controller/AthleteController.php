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
        		$this->redirect(array('controller'=>'admins','action'=>'login'));
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
	
	public function admin_edit($id){
		if (!empty($id)) {	
			$athlete = $this->Athlete->findById($id);
			// Get class list.
			$this->loadModel('Classes');
			$classes = $this->Classes->find('all', array('fields' => array('Classes.id', 'Classes.name'), 
														 'order' => array('Classes.id')));
			$classList = array();
			foreach ($classes as $class){
				$classList[$class['Classes']['name']] = $class['Classes']['name'];
			}
			
			// Get category list.
			$this->loadModel('HsAauTeam');
			$hsAauTeams = $this->HsAauTeam->find('all', array('fields' => array('HsAauTeam.id', 'HsAauTeam.school_name'), 
														 'order' => array('HsAauTeam.id')));						
			$categoryList = array();
			foreach ($hsAauTeams as $hsAauTeam){
				$categoryList[$hsAauTeam['HsAauTeam']['school_name']] = $hsAauTeam['HsAauTeam']['school_name'];
			}
			
			// Get sport list.
			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'), 
														 'order' => array('Sport.id')));						
			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['name']] = $sport['Sport']['name'];
			}
						
			$this->set(compact('athlete', 'classList', 'categoryList', 'sportList'));
								
			if ($this->request->is('post')) {							
				$this->Athlete->id = $id;
				if ($this->Athlete->save($this->request->data)){
					
					// Save school name
					$this->loadModel('HsAauTeam');
					$this->HsAauTeam->id = $athlete['Athlete']['hs_aau_team_id'];
					$this->HsAauTeam->saveField('school_name', $this->request->data['HsAauTeam']['school_name']);
					
					// Save sport name
					$this->loadModel('Sport');
					$this->Sport->id = $athlete['Athlete']['sport_id'];					
					$this->Sport->saveField('name', $this->request->data['Sport']['name']);
					$this->Session->setFlash('Athlete Updated Successfully!', 'flash_success');
					$this->redirect(array('controller' => 'Athlete', 'action' => 'list'));																				
					} else {
						$this->Session->setFlash('Can not update this athlete.', 'flash_error');
					}
			} 						
		} else {
			$this->Session->setFlash('Do not exits this athlete', 'flash_error');
			$this->redirect($this->referer());
		}
	}
	
	public function admin_delete($id){
		if (!empty($id)) {
			if ($this->Athlete->delete($id)){
				$this->Session->setFlash('Athelete Deleted Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not delete this athlete', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this athlete', 'flash_error');			
		}
		$this->redirect($this->referer());
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
	
	public function admin_deactiveRecord($id){
		if (!empty($id)) {
			$this->Athlete->id = $id;
			$this->Athlete->saveField('status', 0);
			$this->Session->setFlash('Athelete Non-Approved Successfully!', 'flash_success');
			$this->redirect($this->referer());		
		} else {
			$this->Session->setFlash('Do not exits this athlete', 'flash_error');
			$this->redirect($this->referer());
		}
	}
	
	public function admin_details($id){
		if (!empty($id)) {
			$athlete = $this->Athlete->findById($id);
			$this->set('athlete', $athlete);	
		} else {
			$this->Session->setFlash('Do not exits this athlete', 'flash_error');
			$this->redirect($this->referer());
		}
	}
}