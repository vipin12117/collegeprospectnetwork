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
		if(isset($this->request->data['Athlete'])){
			foreach($this->request->data['Athlete'] as $key => $value){
				if(strlen($value) > 0){
					if($key == 'weight_min'){
						$conditions[] = "Athlete.weight <= '$value'";
					}
					elseif($key == 'weight_max'){
						$conditions[] = "Athlete.weight >= '$value'";
					}
					elseif($key == 'distance'){
						//$conditions[] = "Athlete.weight >= '$value'";
					}
					elseif($key == 'athlete_stat_category_id'){
						//$conditions[] = "Athlete.weight >= '$value'";
					}
					else{
						$conditions[] = "Athlete.$key = '$value'";
					}
				}
			}

			$this->Session->write("athlete_conditions",$conditions);
			$this->Session->write("athlete_conditions_data",$this->request->data['Athlete']);
		}
		elseif($this->Session->read("athlete_conditions")){
			$conditions = $this->Session->read("athlete_conditions");
			$this->request->data['Athlete'] = $this->Session->read("athlete_conditions_data");;
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
	
	public function admin_viewRating($id){
		if (!empty($id)) {			
			$this->loadModel('Rating');
			$ratingAthlete = $this->Rating->find('first', array(
								'fields' => array(
												    'ROUND(avg(Rating.leadership), 1) as leadership',
													'ROUND(avg(Rating.work_ethic), 1) as work_ethic',
													'ROUND(avg(Rating.primacy_go_to_guy), 1) as primacy_go_to_guy',
													'ROUND(avg(Rating.mental_toughness), 1) as mental_toughness',
													'ROUND(avg(Rating.composure), 1) as composure',
													'ROUND(avg(Rating.awareness), 1) as awareness',
													'ROUND(avg(Rating.instincts), 1) as instincts',
													'ROUND(avg(Rating.vision), 1) as vision',
													'ROUND(avg(Rating.conditioning), 1) as conditioning',
													'ROUND(avg(Rating.physical_toughness), 1) as physical_toughness',
													'ROUND(avg(Rating.tenacity), 1) as tenacity',
													'ROUND(avg(Rating.hustle), 1) as hustle',
													'ROUND(avg(Rating.strength), 1) as strength'			
												 ),
								'conditions' => array('Rating.athlete_id' => $id)
							 ));

			$this->set('ratingAthlete', $ratingAthlete);
		} else {
			$this->Session->setFlash('Do not exits this athlete', 'flash_error');
			$this->redirect($this->referer());
		}
	}
	
	public function admin_deleteSelected(){
		if(isset($this->request->data['check_delete'])) {	
					
			foreach ($this->request->data['check_delete'] as $id){
				$this->Athlete->delete($id);
				$this->Session->setFlash('Athlete Deleted Successfully!', 'flash_success');				
			}			
		}
		$this->redirect(array('controller' => 'Athlete', 'action' => 'list'));
	}
	
	public function admin_stateList(){
		$limit = 10;		
		$this->loadModel('AthleteStat');
		$this->AthleteStat->recursive = -1;
		$this->paginate = array('AthleteStat' => array(
												'group' => 'AthleteStat.event_id',
												'limit' => $limit));
		$athleteStats = $this->paginate('AthleteStat');

		$tmpAthleteStats = $athleteStats;
		$this->loadModel('Event');
		$this->loadModel('HsAauCoach');
		foreach ($athleteStats as $key => $value){
			// Get event name
			$event = $this->Event->findById($value['AthleteStat']['event_id']);
			$tmpAthleteStats[$key]['Event']['event_name'] = $event['Event']['event_name'];
			
			// Get athlete name
			$athlete = $this->Athlete->findById($value['AthleteStat']['athlete_id']);
			$tmpAthleteStats[$key]['Athlete']['firstname'] = $athlete['Athlete']['firstname']; 			
			$tmpAthleteStats[$key]['Athlete']['lastname'] = $athlete['Athlete']['lastname'];
			
			// Get coach name
			$hsAauCoach = $this->HsAauCoach->findById($value['AthleteStat']['hs_aau_coach_id']);
			$tmpAthleteStats[$key]['HsAauCoach']['firstname'] = $hsAauCoach['HsAauCoach']['firstname']; 			
			$tmpAthleteStats[$key]['HsAauCoach']['lastname'] = $hsAauCoach['HsAauCoach']['lastname'];
		}
		$athleteStats = $tmpAthleteStats;
		$this->set(compact('athleteStats', 'limit'));
	} 
	
	public function admin_athleteStatView(){
		if (isset($this->params['named']['eventId']) && isset($this->params['named']['athId'])) {
			$eventId = $this->params['named']['eventId'];
			$athId = $this->params['named']['athId'];
			
			// Get athlete state
			$this->loadModel('AthleteStat');
			$this->AthleteStat->recursive = -1;		
			$athleteStats = $this->AthleteStat->find('all', array('conditions' => array('AthleteStat.event_id' => $eventId, 'AthleteStat.athlete_id' => $athId)));
			
			// Get event name
			$this->loadModel('Event');
			$event = $this->Event->findById($eventId);
			$this->set(compact('athleteStats', 'event'));
		} else {
			$this->redirect($this->referer());
		}
	}
	
	public function admin_deleteAthleteStat($id){
		
	}

}