<?php

class HsAauTeamController extends AppController{

	public $name = 'HsAauTeam';

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
		
	}
	
	public function admin_schoolList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			if (!empty($searchName)){
				$conditions = array('HsAauTeam.school_name LIKE ' => '%'.$searchName.'%');
			} else {
				$conditions = array();
			}
			
			$limit = 100;
			$this->loadModel('HsAauTeam');
			$this->paginate = array('HsAauTeam'=>array('fields' => array('HsAauTeam.id', 'HsAauTeam.school_name', 'HsAauTeam.city', 'HsAauTeam.state', 'HsAauTeam.sport_id', 'HsAauTeam.coach_name'),
													 'conditions' => $conditions,
													 'order' =>  array('HsAauTeam.id'),
													 'limit' => $limit));
			$hsAauTeams = $this->paginate('HsAauTeam');
			$this->set(compact('hsAauTeams', 'limit'));

		} else {
			
			$limit = 100;
			$this->loadModel('HsAauTeam');
			$this->paginate = array('HsAauTeam'=>array('fields' => array('HsAauTeam.id', 'HsAauTeam.school_name', 'HsAauTeam.city', 'HsAauTeam.state', 'HsAauTeam.sport_id', 'HsAauTeam.coach_name'),
													 'order' =>  array('HsAauTeam.id'),
													 'limit' => $limit));
			$hsAauTeams = $this->paginate('HsAauTeam');
			$this->set(compact('hsAauTeams', 'limit'));
		}
	}
	
	public function admin_schoolDetails($id) {
		if (isset($id)){
			$schoolDetail = $this->HsAauTeam->findById($id);
			$this->set('schoolDetail', $schoolDetail);
		} else {
			$this->Session->setFlash('Do not exits this School', 'flash_error');
		}	
	}
	
	
	public function admin_schoolEdit($id){
		if (isset($id)){
			if ($this->request->is('post')){				
				$this->HsAauTeam->id = $id;				
				if ($this->HsAauTeam->save($this->request->data)){
					$this->Session->setFlash('HS / AAU Team Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'HsAauTeam', 'action' => 'schoolList'));
				} else {
					$this->Session->setFlash('Can not update this HS / AAU Team', 'flash_error');
				}
			} else {
				$hsAauTeam = $this->HsAauTeam->findById($id);
				$this->set('hsAauTeam', $hsAauTeam);
			}
		} else {
			$this->Session->setFlash('Do not exits this Member', 'flash_error');
		}	
	}
	
	public function admin_deleteSchool($id){
		if (!empty($id)) {
			if ($this->HsAauTeam->delete($id)){
				$this->Session->setFlash('HS/AAU Deleted Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not delete this HS/AAU', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this HS/AAU', 'flash_error');			
		}
		$this->redirect($this->referer());
	}
	
	public function admin_deleteSelectedHsAauTeams(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->HsAauTeam->delete($id)){
					$this->Session->setFlash('HS/AAU Team Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect(array('controller' => 'HsAauTeam', 'action' => 'schoolList'));
	}
	
	public function admin_otherList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('HsAauTeamOther.name LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('HsAauTeamOther');
			
			$this->paginate = array('HsAauTeamOther'=>array('conditions' => $conditions,
												   'limit' => $limit));
			
			$hsAauTeamOthers = $this->paginate('HsAauTeamOther');
			$this->set(compact('hsAauTeamOthers', 'limit'));
		} else {
			$limit = 100;
			$this->loadModel('HsAauTeamOther');			
			$hsAauTeamOthers = $this->paginate('HsAauTeamOther');
			$this->set(compact('hsAauTeamOthers', 'limit'));
		}
	}
	
	public function admin_deleteOther($id){
		if (isset($id)){
			$this->loadModel('HsAauTeamOther');
			if($this->HsAauTeamOther->delete($id)){
				$this->Session->setFlash('Other HS / AAU Team Name Deleted Successfully!', 'flash_success');				
			} else {
				$this->Session->setFlash('Can not delete this Other HS / AAU Team', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Other HS / AAU Team', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_otherNameDetails($id){
		if (isset($id)){
			$this->loadModel('HsAauTeamOther');
			$hsAauTeamOther = $this->HsAauTeamOther->findById($id);
			$this->set('hsAauTeamOther', $hsAauTeamOther);
		} else {
			$this->Session->setFlash('Do not exits this Other HS / AAU Team', 'flash_error');
		}	
		
	}
	
	public function admin_editOther($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->loadModel('HsAauTeamOther');
				$this->HsAauTeamOther->id = $id;
				if ($this->HsAauTeamOther->save($this->request->data)){
					$this->Session->setFlash('Other Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'HsAauTeam', 'action' => 'otherList'));
				} else {
					$this->Session->setFlash('Can not update this Other HsAauTeam', 'flash_error');
				}
			} else {
				$this->loadModel('HsAauTeamOther');
				$hsAauTeamOther = $this->HsAauTeamOther->findById($id);
				$this->set('hsAauTeamOther', $hsAauTeamOther);
			}
		} else {
			$this->Session->setFlash('Do not exits this Other HsAauTeam', 'flash_error');
		}			
	}
	
	public function admin_deleteSelectedHsAauTeamOther(){
		$this->loadModel('HsAauTeamOther');
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				$this->HsAauTeamOther->delete($id);
				$this->Session->setFlash('Athlete Stat Deleted Successfully!', 'flash_success');				
			}			
		}
		$this->redirect($this->referer());
	}
	
	public function admin_addSchool() {
		if ($this->request->is('post')){
			// Check exits.
			$hsAauTeam = $this->HsAauTeam->findBySchoolName($this->request->data['school_name']);
			if (!empty($hsAauTeam)){
				$this->Session->setFlash('This HS/AAU Team Code Already Exists!', 'flash_error');
			} else {				
				$hsAauTeams = array();
				$hsAauTeams['HsAauTeam']['school_name'] = $this->request->data['school_name'];
				$hsAauTeams['HsAauTeam']['enrollment'] = $this->request->data['enrollment'];
				$hsAauTeams['HsAauTeam']['address'] = $this->request->data['address'];
				$hsAauTeams['HsAauTeam']['state'] = $this->request->data['state'];
				$hsAauTeams['HsAauTeam']['zip'] = $this->request->data['zip'];
				$hsAauTeams['HsAauTeam']['status'] = $this->request->data['status'];
								
				if ($this->HsAauTeam->save($hsAauTeams)){
					$this->Session->setFlash($hsAauTeams['HsAauTeam']['school_name'].' is added successfully', 'flash_success');
					$this->redirect(array('controller' => 'HsAauTeam', 'action' => 'schoolList'));
				} else {
					$this->Session->setFlash('Can not add this '.$hsAauTeams['HsAauTeam']['school_name'], 'flash_error');
				}
			}
		}
	}
}