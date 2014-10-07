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
	
	public function admin_editCoach($id){
		if (isset($id)){
			if ($this->request->is('post')){
				// Get HsAauCoach
				$hsAauCoachs = array();
				$hsAauCoachs['HsAauCoach']['firstname'] 	= $this->request->data['firstname'];
				$hsAauCoachs['HsAauCoach']['lastname'] 		= $this->request->data['lastname'];
				$hsAauCoachs['HsAauCoach']['email'] 		= $this->request->data['email'];
				$hsAauCoachs['HsAauCoach']['email2'] 		= $this->request->data['email2'];
				$hsAauCoachs['HsAauCoach']['phone'] 		= $this->request->data['phone'];
				$hsAauCoachs['HsAauCoach']['phone2'] 		= $this->request->data['phone2'];
				$hsAauCoachs['HsAauCoach']['position'] 		= $this->request->data['position'];
				$hsAauCoachs['HsAauCoach']['status'] 		= $this->request->data['status'];
				
				// Get HsAauCoachSportposition
				/*$this->loadModel('HsAauCoachSportposition');
				$countSports = $this->HsAauCoachSportposition->find('count', array(																		
																		'conditions' => array('HsAauCoachSportposition.hs_aau_coach_id' => $id)
																	));			
				for ($i = 1; $i <= $countSports; $i++){
					$hsACSportPos = array();
					$hsACSportPos['HsAauCoachSportposition']['hs_aau_coach_id'] = $id;
					if (($this->request->data['sport_id'.$i] != 'select') && ($this->request->data['position'.$i] != '')){
						$hsACSportPos['HsAauCoachSportposition']['sport_id'] = $this->request->data['sport_id'.$i];
						$hsACSportPos['HsAauCoachSportposition']['position'] = $this->request->data['position'.$i];
						$this->HsAauCoachSportposition->save($hsACSportPos);
					} elseif (($this->request->data['position'.$i] != '') && ($this->request->data['sport_id'.$i] == 'select')){					
						$hsACSportPos['HsAauCoachSportposition']['position'] = $this->request->data['position'.$i];
						$this->HsAauCoachSportposition->save($hsACSportPos);
					} elseif (($this->request->data['sport_id'.$i] != 'select') && ($this->request->data['position'.$i] == '')){
						$hsACSportPos['HsAauCoachSportposition']['sport_id'] = $this->request->data['sport_id'.$i];
						$this->HsAauCoachSportposition->save($hsACSportPos);
					}
				}*/
								
				$this->HsAauCoach->id = $id;
				if ($this->HsAauCoach->save($hsAauCoachs)){
					$this->Session->setFlash('Coach Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'HsAauCoach', 'action' => 'coachList'));
				} else {
					$this->Session->setFlash('Can not update this Coach', 'flash_error');
				}
			} else {
				
				// Get sport list.
				$this->loadModel('Sport');
				$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'), 
															 'order' => array('Sport.name')));						
				$sportOptions = array();
				foreach ($sports as $sport){
					$sportOptions[$sport['Sport']['id']] = $sport['Sport']['name'];
				}
				
				$sportsList = array();
				$this->loadModel('HsAauCoachSportposition');
				$sportsList = $this->HsAauCoachSportposition->find('all', array(
																		'fields' => array('HsAauCoachSportposition.id',
																						  'HsAauCoachSportposition.hs_aau_coach_id',
																						  'HsAauCoachSportposition.position',
				                                                                          'HsAauCoachSportposition.sport_id'
																						  ),
																		'conditions' => array('HsAauCoachSportposition.hs_aau_coach_id' => $id)
																	));
				
				$hsAauCoach = $this->HsAauCoach->findById($id);
				
				// Get category list.
				$this->loadModel('HsAauTeam');
				$hsAauTeams = $this->HsAauTeam->find('all', array('fields' => array('HsAauTeam.id', 'HsAauTeam.school_name'), 
															 'order' => array('HsAauTeam.id')));
				
				$categoryList = array();
				foreach ($hsAauTeams as $hsAauTeam){
					$categoryList[$hsAauTeam['HsAauTeam']['id']] = $hsAauTeam['HsAauTeam']['school_name'];
				}

				$this->set(compact('hsAauCoach', 'sportOptions', 'sportsList', 'categoryList'));
			}
		} else {
			$this->Session->setFlash('Do not exits this Coach', 'flash_error');
		}
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
						
			$hsAauCoachRating = $this->HsAauCoachRating->find('all', array(
													'conditions' => array('HsAauCoachRating.hs_aau_coach_id' => $id),
													'fields' => array(	
																	'HsAauCoachRating.college_coach_id',
																	'ROUND(avg(HsAauCoachRating.contribute), 1) as contribute',
																	'ROUND(avg(HsAauCoachRating.comunication), 1) as comunication',
																	'ROUND(avg(HsAauCoachRating.request_game_tape), 1) as request_game_tape',
																	'ROUND(avg(HsAauCoachRating.honest), 1) as honest',
																	'ROUND(avg(HsAauCoachRating.prepration), 1) as prepration'
																)																									
												));
			$this->set('hsAauCoachRating', $hsAauCoachRating);
		} else {
			$this->Session->setFlash('Do not exits this HsAauCoachRating', 'flash_error');
		}
	}
	
	/**
	 * Delete selected Coach.
	 */
	public function admin_deleteSelectedCoachList(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->HsAauCoach->delete($id)){
					$this->Session->setFlash('High School / AAU Coach Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
}