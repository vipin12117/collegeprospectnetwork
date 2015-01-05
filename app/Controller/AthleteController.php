<?php

App::uses('CakeEmail', 'Network/Email');

class AthleteController extends AppController{

	public $name = 'Athlete';

	public $components = array('Session');

	public function beforeFilter(){
		parent::beforeFilter();

		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin'){ ////for admin section template
			if ($this->checkAdminSession()){
				$this->layout = 'admin';
			}
			else{
				$this->redirect(array('controller'=>'admins','action'=>'login'));
			}
		}
		else{
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
		$userId = $this->Session->read('user_id');

		$this->loadModel('HsAauCoach');
		$this->loadModel('HsAauCoachSportposition');

		$hsAauCoach = $this->HsAauCoach->read(null,$userId);
		$hs_aau_team_id = $hsAauCoach['HsAauCoach']['hs_aau_team_id'];

		$sports = $this->HsAauCoachSportposition->find("list",array("conditions"=>"hs_aau_coach_id = '$userId'","fields"=>"sport_id"));
		if($sports){
			$this->paginate = array("Athlete" => array("conditions"=>array("Athlete.sport_id"=>$sports,"Athlete.status"=>0,"Athlete.hs_aau_team_id"=>$hs_aau_team_id)));
			$athletes = $this->paginate("Athlete");
			$this->set("athletes",$athletes);
		}
	}

	public function markApprove($id = false){
		$id = (int)$id;
		if($id){
			$this->Athlete->id = $id;
			$athlete = $this->Athlete->read(null,$id);

			$this->Athlete->saveField("approve_hs_aau_coach_id",$this->Session->read('user_id'));
			$this->Athlete->saveField("status",1);
			$this->Session->setFlash("Thank you. The athlete has been approved and a confirmation email has been sent to &nbsp;".$athlete['Athlete']['email']);

			//send network request
			$this->loadModel('Network');
			$isExist = $this->Network->isExist($this->Session->read('user_id'),$id,"coach","athlete");
			if(!$isExist){
				$isExist = $this->Network->isExist($id,$this->Session->read('user_id'),"athlete","coach");
			}

			if(!$isExist){
				$network = array();
				$network['sender_id']   = $this->Session->read('user_id');
				$network['receiver_id'] = $id;
				$network['sender_type'] = "coach";
				$network['receiver_type'] = "athlete";
				$network['status'] = "Active";
				$network['date_added']  = date('Y-m-d H:i:s');
				$network['modify_date'] = date('Y-m-d H:i:s');

				$this->Network->create();
				$this->Network->save(array("Network"=>$network));
			}

			$template = 'athlete_approval_notification';
			$cakeEmail = new CakeEmail();
			try {
				$cakeEmail->template($template);
				$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
				$cakeEmail->to(array($athlete['Athlete']['email'] => $athlete['Athlete']['firstname']));
				$cakeEmail->subject("College Prospect Network - Approval Notification");
				$cakeEmail->emailFormat('html');
				$cakeEmail->viewVars(array('athlete' => $athlete));
				// Send email
				$cakeEmail->send();
			}
			catch (Exception $e){
				//$this->Session->setFlash('Error while sending email');
			}
		}

		$this->redirect(array('controller' => 'Athlete', 'action' => 'athleteComments'));
	}

	public function athleteComments($athlete_id = false){
		if(!$athlete_id){
			$this->redirect(array('controller' => 'Athlete', 'action' => 'approval'));
			exit;
		}

		if(isset($this->request->data['Athlete'])){
			$this->Athlete->id = $athlete_id;
			$this->Athlete->save($this->request->data);

			$this->Session->setFlash("Athlete's Division Projection and Comment has been succesfully posted.");
			$this->redirect(array('controller' => 'Athlete', 'action' => 'approval'));
			exit;
		}

		$this->set("athlete_id",$athlete_id);
	}

	public function markReject($id = false){
		$id = (int)$id;
		if($id){
			$this->Athlete->id = $id;
			$athlete = $this->Athlete->read(null,$id);

			$this->Athlete->saveField("status",2);
			$this->Session->setFlash("You have rejected this Athlete and Notification Email send to ".$athlete['Athlete']['email']);

			$template = 'athlete_reject_notification';
			$cakeEmail = new CakeEmail();
			try {
				$cakeEmail->template($template);
				$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
				$cakeEmail->to(array($athlete['Athlete']['email'] => $athlete['Athlete']['firstname']));
				$cakeEmail->subject("College Prospect Network - Approval Notification");
				$cakeEmail->emailFormat('html');
				// Send email
				$cakeEmail->send();
			}
			catch (Exception $e){
				$this->Session->setFlash('Error while sending email');
			}
		}

		$this->redirect(array('controller' => 'Athlete', 'action' => 'approval'));
	}

	public function stats($athlete_id = false){
		$this->layout = 'popup';
		if(!$athlete_id){
			$athlete_id = $this->Session->read('user_id');
		}

		$this->loadModel('AthleteStat');
		$athleteStats = $this->AthleteStat->find("all",array("conditions"=>"AthleteStat.athlete_id = '$athlete_id' AND AthleteStat.event_id > 0",
															 "group"=>"AthleteStat.event_id",
															 "fields"=>"Event.event_name,AthleteStat.athlete_id,AthleteStat.event_id"));
		foreach($athleteStats as $index => $athleteStat){
			$athleteStats[$index]['stats'] = $this->AthleteStat->getStatsInfo($athleteStat['AthleteStat']['athlete_id'] , $athleteStat['AthleteStat']['event_id']);
		}
		$this->set("athleteStats",$athleteStats);
	}

	public function statsList(){
		$this->set("title_for_layout","Athlete Stats Approval");

		$userId = $this->Session->read('user_id');
		$this->loadModel('AthleteStat');

		$this->AthleteStat->unbindModelAll();
		$this->AthleteStat->bindModel(array("belongsTo"=>array("Athlete","Event")));

		$this->paginate = array("AthleteStat"=>array("conditions"=>"AthleteStat.hs_aau_coach_id = '$userId' and AthleteStat.status = 0 and Event.id > 0",
													 "order"=>"label_name ASC","group"=>"AthleteStat.event_id","limit"=>10,
													 "fields" => "AthleteStat.*,Event.event_name,Athlete.firstname,Athlete.lastname,Athlete.image,Athlete.id"));
		$athleteStats = $this->paginate('AthleteStat');
		$this->set("athleteStats",$athleteStats);
	}

	public function approveStat($athlete_id = false , $event_id = false){
		$athlete_id = (int)$athlete_id;
		$event_id = (int)$event_id;
		if(!$athlete_id || !$event_id){
			$this->redirect(array("controller"=>"Athlete","action"=>"statsList"));
			exit;
		}

		$this->set("athlete_id",$athlete_id);
		$this->set("event_id",$event_id);

		$userId = $this->Session->read('user_id');
		$this->loadModel('AthleteStat');

		if(isset($this->request->data['AthleteStat'])){
			$status = $this->request->data['AthleteStat']['status'];
			foreach($this->request->data['AthleteStat'] as $AthleteStat){
				$AthleteStat['status'] = $status;
				$this->AthleteStat->save(array("AthleteStat"=>$AthleteStat));
			}

			if($status == 1){
				$this->Session->setFlash("You have successfully Confirmed these Game Stats");
			}
			else{
				$this->Session->setFlash("You have Rejected these Game Stats, you may review / modify them at anytime.");
			}
			
			$this->redirect(array("controller"=>"Athlete","action"=>"statsList"));
			exit;
		}
		else{
			$athleteStats = $this->AthleteStat->find("all",array("conditions"=>"AthleteStat.status = 0 and AthleteStat.event_id = '$event_id' AND AthleteStat.athlete_id = '$athlete_id'"));
			$this->set("athleteStats",$athleteStats);
		}
	}

	public function events(){
		$this->set("title_for_layout","Athlete Stats Events");

		$userId = $this->Session->read('user_id');
		$this->loadModel('AthleteStat');

		$this->AthleteStat->unbindModelAll();
		$this->AthleteStat->bindModel(array("belongsTo"=>array("Athlete","Event")));

		$this->loadModel('HsAauCoachSportposition');
		$sports = $this->HsAauCoachSportposition->getSportsByCoachId($userId);
		$sport_str = implode(",",$sports);

		//recent events
		if($sport_str){
			$this->paginate = array("AthleteStat"=>array("conditions"=>"AthleteStat.hs_aau_coach_id != '$userId' and AthleteStat.sport_id in ($sport_str) and AthleteStat.status = 1 and Event.id > 0",
													 "order"=>"label_name ASC","group"=>"AthleteStat.event_id","limit"=>10,
													 "fields" => "AthleteStat.*,Event.event_name,Athlete.firstname,Athlete.lastname,Athlete.image,Athlete.id"));
		}
		else{
			$this->paginate = array("AthleteStat"=>array("conditions"=>"AthleteStat.hs_aau_coach_id != '$userId' and AthleteStat.status = 1 and Event.id > 0",
													 "order"=>"label_name ASC","group"=>"AthleteStat.event_id","limit"=>10,
													 "fields" => "AthleteStat.*,Event.event_name,Athlete.firstname,Athlete.lastname,Athlete.image,Athlete.id"));	
		}

		$events = $this->paginate('AthleteStat');
		$this->set("events",$events);
	}

	public function invite(){
		$userId = $this->Session->read('user_id');

		if(isset($this->request->data['Athlete'])){
			$email = $this->request->data['Athlete']['email'];

			$this->loadModel('HsAauCoach');
			$HsAauCoach = $this->HsAauCoach->getById($userId);

			$cakeEmail = new CakeEmail();
			$subject  = "Coach  " . $HsAauCoach['HsAauCoach']['firstname'] . " " . $HsAauCoach['HsAauCoach']['lastname'] . " Has Invited You to Join Our Site!";
			$template = 'athlete_invite_email';
			try {
				$cakeEmail->template($template);
				$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
				$cakeEmail->to(array($email => $email));
				$cakeEmail->subject($subject);
				$cakeEmail->emailFormat('html');
				$cakeEmail->viewVars(array('HsAauCoach' => $HsAauCoach));
				// Send email
				$cakeEmail->send();
			}
			catch (Exception $e){
				//$this->Session->setFlash('Error while sending email');
			}

			$this->Session->setFlash("Athlete has been invited. Please also notify the athlete that he/she has been invited, as they may not check their email frequently. Once you confirm that the athlete's entered information is accurate, his/her profile will be activated. Thank you.");

			$this->redirect(array('controller' => 'Athlete', 'action' => 'invite'));
			exit;
		}
	}

	public function search(){
		$this->set("title_for_layout","College Prospect Network - Athlete Search");

		$conditions = array();
		if(isset($this->request->data['Athlete'])){
			foreach($this->request->data['Athlete'] as $key => $value){
				if((is_string($value) && strlen($value) > 0) || $value){
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
					elseif($key == 'state'){
						$cond = array();
						foreach($value as $val){
							$cond[] = " Athlete.state like '%$val%' ";
						}
						$conditions[] = "(". implode(" OR ",$cond). " ) ";
					}
					elseif($key == 'firstname'){
						$value = strtolower($value);
						$conditions[] = "( Lower(Athlete.firstname) like '%$value%' OR Lower(Athlete.lastname) like '%$value%' )";
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

		if($this->Session->read('user_type') == 'college' AND !$this->Session->read("is_trial_mode")){
			$this->set("user_id",$this->Session->read('user_id'));
		}
		else{
			$this->set("user_id",0);
		}

		$this->loadModel('Rating');
		$athletes = $this->paginate('Athlete');
		if($athletes){
			foreach($athletes as $index => $athlete){
				$athletes[$index]['Athlete']['avg_rating'] = $this->Rating->getAverageRating($athlete['Athlete']['id']);
			}
		}

		$this->set("athletes",$athletes);
	}

	public function addRating($athlete_id = false){
		$this->layout = 'popup';
		if (!isset($athlete_id)){
			$this->redirect(array('controller' => 'Network', 'action' => 'requests'));
			exit;
		}

		$athlete_id = (int)$athlete_id;
		$userId = $this->Session->read('user_id');

		$this->loadModel('Rating');

		if(isset($this->request->data['Rating'])){
			$this->request->data['Rating']['add_date'] = date('Y-m-d H:i:s');
			$this->request->data['Rating']['athlete_id'] = $athlete_id;
			$this->request->data['Rating']['hs_aau_coach_id'] = $userId;

			$this->Rating->create();
			$this->Rating->save($this->request->data);

			$this->set("ratingSaved",1);
		}
		else{
			$ratingExist = $this->Rating->find("first",array("conditions"=>"Rating.athlete_id = '$athlete_id' AND Rating.hs_aau_coach_id = '$userId'"));
			$this->set("ratingExist",$ratingExist);
			$this->set("athlete_id",$athlete_id);
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
								'conditions' => array('Rating.athlete_id' => $id)));

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
			if (isset($event['Event']['event_name'])){
				$tmpAthleteStats[$key]['Event']['event_name'] = $event['Event']['event_name'];
			} else {
				$tmpAthleteStats[$key]['Event']['event_name'] = "";
			}

			// Get athlete name
			$athlete = $this->Athlete->findById($value['AthleteStat']['athlete_id']);
			if (isset($athlete['Athlete']['firstname']) && isset($athlete['Athlete']['lastname'])){
				$tmpAthleteStats[$key]['Athlete']['firstname'] = $athlete['Athlete']['firstname'];
				$tmpAthleteStats[$key]['Athlete']['lastname'] = $athlete['Athlete']['lastname'];
			} else {
				$tmpAthleteStats[$key]['Athlete']['firstname'] = "";
				$tmpAthleteStats[$key]['Athlete']['lastname'] = "";
			}

			// Get coach name
			$hsAauCoach = $this->HsAauCoach->findById($value['AthleteStat']['hs_aau_coach_id']);
			if (isset($hsAauCoach['HsAauCoach']['firstname']) && isset($hsAauCoach['HsAauCoach']['lastname'])){
				$tmpAthleteStats[$key]['HsAauCoach']['firstname'] = $hsAauCoach['HsAauCoach']['firstname'];
				$tmpAthleteStats[$key]['HsAauCoach']['lastname'] = $hsAauCoach['HsAauCoach']['lastname'];
			} else {
				$tmpAthleteStats[$key]['HsAauCoach']['firstname'] = "";
				$tmpAthleteStats[$key]['HsAauCoach']['lastname'] = "";
			}
			
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
		$this->loadModel('AthleteStat');
		if($this->AthleteStat->delete($id)){
			$this->Session->setFlash('Athlete Stat Deleted Successfully!', 'flash_success');
		} else {
			$this->Session->setFlash('Can not delete this Athlete', 'flash_error');
		}
		$this->redirect($this->referer());
	}

	/**
	 * Delete selected Athlete Stat
	 */
	public function admin_deleteSelectedAthleteStat(){
		$this->loadModel('AthleteStat');
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				$this->AthleteStat->delete($id);
				$this->Session->setFlash('Athlete Stat Deleted Successfully!', 'flash_success');
			}
		}
		$this->redirect($this->referer());
	}

	/**
	 * It is use to perform the operation for add for Catagory.
	 */
	public function admin_categoryAdd(){
		if (!$this->request->is('post')){
			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
													  'order' => array('Sport.name'),
			                                          'conditions' => array('Sport.status' => '1')));

			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
			}

			$this->set('sportList', $sportList);
		} else {
			$athStatCat = array();
			$athStatCat['AthleteStatCategory']['name'] = $this->request->data['name'];
			$athStatCat['AthleteStatCategory']['code'] = $this->request->data['code'];
			$athStatCat['AthleteStatCategory']['parent_id'] = $this->request->data['parent_id'];
			$athStatCat['AthleteStatCategory']['status'] = $this->request->data['status'];
			$this->loadModel('AthleteStatCategory');
			if($this->AthleteStatCategory->save($athStatCat)){
				$this->Session->setFlash('Category is Added Successfully', 'flash_success');
			} else {
				$this->Session->setFlash('Can not add this category', 'flash_error');
			}

			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
													  'order' => array('Sport.name'),
			                                          'conditions' => array('Sport.status' => '1')));

			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
			}

			$this->set('sportList', $sportList);
		}
	}

	/**
	 * It is use to show the list of Page.
	 */
	public function admin_categoryList($sportId=null){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];

			if (!empty($searchName)){
				if (isset($sportId) && $sportId > 0){
					$conditions = array('AthleteStatCategory.name LIKE ' => '%'.$searchName.'%',
										'AthleteStatCategory.parent_id' => $sportId,
										'AthleteStatCategory.status' => '1');
				} else {
					$conditions = array('AthleteStatCategory.name LIKE ' => '%'.$searchName.'%',
										'AthleteStatCategory.status' => '1');
				}
			} else {
				if (isset($sportId)){
					$conditions = array(
										'AthleteStatCategory.parent_id' => $sportId,
										'AthleteStatCategory.status' => '1');
				} else {
					$conditions = array('AthleteStatCategory.status' => '1');

				}
			}

			$limit = 100;
			$this->loadModel('AthleteStatCategory');
			$this->paginate = array('AthleteStatCategory'=>array(
														 'conditions' => $conditions,
														 'limit' => $limit));
			$athStatCats = $this->paginate('AthleteStatCategory');

			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
													  'order' => array('Sport.id')
			));

			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
			}

			$this->set(compact('athStatCats', 'limit', 'sportList', 'sportId'));

		} else {

			if (isset($sportId) && $sportId > 0){
				$conditions = array(
									'AthleteStatCategory.parent_id' => $sportId,
									'AthleteStatCategory.status' => '1');
			} else {
				$conditions = array(
									'AthleteStatCategory.status' => '1');
			}

			$limit = 100;
			$this->loadModel('AthleteStatCategory');
			$this->paginate = array('AthleteStatCategory'=>array('conditions' => $conditions,
																 'limit' => $limit));

			$athStatCats = $this->paginate('AthleteStatCategory');

			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
													  'order' => array('Sport.id')
			));

			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
			}

			$this->set(compact('athStatCats', 'limit', 'sportList', 'sportId'));

		}
	}

	public function admin_categoryEdit($id){
		if (!$this->request->is('post')){
			$this->loadModel('AthleteStatCategory');
			$athStatCat = $this->AthleteStatCategory->findById($id);

			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
														  'order' => array('Sport.id')
			));

			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
			}
			$this->set(compact('athStatCat', 'sportList'));
		} else {
			$athStatCat = array();
			$athStatCat['AthleteStatCategory']['name'] = $this->request->data['name'];
			$athStatCat['AthleteStatCategory']['code'] = $this->request->data['code'];
			$athStatCat['AthleteStatCategory']['parent_id'] = $this->request->data['parent_id'];
			$athStatCat['AthleteStatCategory']['status'] = $this->request->data['status'];
			$this->loadModel('AthleteStatCategory');
			$this->AthleteStatCategory->id = $id;
			if($this->AthleteStatCategory->save($athStatCat)){
				$this->Session->setFlash('Category Updated Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not update this category', 'flash_error');
			}

			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
													  'order' => array('Sport.name'),
			                                          'conditions' => array('Sport.status' => '1')));

			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['id']] = $sport['Sport']['name'];
			}

			$this->set(compact('athStatCat', 'sportList'));
			$this->redirect(array('controller' => 'Athlete', 'action' => 'categoryList'));
		}
	}

	public function admin_deleteCategory($id){
		if (isset($id)){
			$this->loadModel('AthleteStatCategory');
			$this->AthleteStatCategory->delete($id);
			$this->Session->setFlash('Category Deleted Successfully!', 'flash_success');
		} else {
			$this->Session->setFlash('Do not exits this category.', 'flash_error');
		}
		$this->redirect($this->referer());
	}

	public function admin_categoryDetails($id){
		if (isset($id)){
			$this->loadModel('AthleteStatCategory');
			$this->loadModel('Sport');
			$categoryDetail = $this->AthleteStatCategory->findById($id);
			$sport = $this->Sport->findById($categoryDetail['AthleteStatCategory']['parent_id']);
			$this->set(compact('categoryDetail', 'sport'));
		} else {
			$this->Session->setFlash('Do not exits this category.', 'flash_error');
		}
	}

	/**
	 * Delete selected Category.
	 */
	public function admin_deleteSelectedCategory(){
		$this->loadModel('AthleteStatCategory');
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->AthleteStatCategory->delete($id)){
					$this->Session->setFlash('Category Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}
			}
		}
		$this->redirect($this->referer());
	}

	public function admin_classList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];

			if (!empty($searchName)){
				$conditions = array('Classes.name LIKE ' => '%'.$searchName.'%');
			} else {
				$conditions = array();
			}

			$limit = 100;
			$this->loadModel('Classes');
			$this->paginate = array('Classes'=>array('conditions' => $conditions,
													 'order' => 'Classes.name',
													 'limit' => $limit));	 														 
			$classes = $this->paginate('Classes');
			$this->set(compact('classes', 'limit'));

		} else {

			$limit = 100;
			$this->loadModel('Classes');
			$this->paginate = array('Classes'=>array('order' => 'Classes.name', 'limit' => $limit));
			$classes = $this->paginate('Classes');
			$this->set(compact('classes', 'limit'));
		}
	}

	public function admin_deleteClass($id){
		if (isset($id)){
			$this->loadModel('Classes');
			$this->Classes->delete($id);
			$this->Session->setFlash('Class Deleted Successfully!', 'flash_success');
		} else {
			$this->Session->setFlash('Do not exits this class.', 'flash_error');
		}
		$this->redirect($this->referer());
	}

	/**
	 * Delete selected Class.
	 */
	public function admin_deleteSelectedClass(){
		$this->loadModel('Classes');
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Classes->delete($id)){
					$this->Session->setFlash('Category Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}
			}
		}
		$this->redirect($this->referer());
	}

	/**
	 * Add Class.
	 */
	public function admin_classAdd(){
		if ($this->request->is('post')){
			$this->loadModel('Classes');
			$className = $this->request->data['class'];
			//Check class is already exists!
			$count = $this->Classes->find('count', array('conditions' => array('Classes.name' => $className)));
			if ($count > 0) {
				$this->Session->setFlash('This Class Already Exists!', 'flash_error');
				$this->redirect($this->referer());
			} else {
				$class = array();
				$class['Classes']['name'] = $className;
				if($this->Classes->save($class)){
					$this->Session->setFlash('Class is Added Successfully', 'flash_success');
				} else {
					$this->Session->setFlash('Can not add this class', 'flash_error');
					$this->redirect($this->referer());
				}
			}
			$this->redirect(array('controller' => 'Athlete', 'action' => 'classList'));
		}
	}
	
	public function admin_viewAthlete($id){
		if (isset($id)){
			$this->loadModel('Athlete');
			$athlete = $this->Athlete->findById($id);
			if(isset($athlete)){
				$this->Session->write("name",$athlete['Athlete']['firstname']);
				$this->Session->write("username",$athlete['Athlete']['username']);
				$this->Session->write("user_id",$athlete['Athlete']['id']);
				$this->Session->write("user_type","athlete");			
				$this->redirect('/my-account.php');								
			}
			else{
				$this->Session->SetFlash("Entered password is wrong. Please try again");
			}
		} else {
			$this->Session->setFlash('Do not exits this Athlete.', 'flash_error');
		}
	}
}