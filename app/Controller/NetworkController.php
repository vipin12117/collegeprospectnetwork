<?php

/**
 * This class is used to college receive network request from athlete.
 * @author Administrator
 *
 */
class NetworkController extends AppController{

	public $name = 'Network';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	//public $uses = array('Athlete','HsAauCoach','CollegeCoach','Network');

	/**
	 * My Athletes.
	 * @param $type
	 */
	public function index($type){
		$userId   = $this->Session->read('user_id');
		$userType = $this->Session->read('user_type');

		if (isset($userId)){
			$this->set("title_for_layout","College Prospect Network - $type in my network");

			if($type == 'college'){
				$pageTitle = 'My College Coaches';
			}
			elseif($type == 'coach'){
				$pageTitle = 'My HS/AAU Coaches';
			}
			elseif($type == 'athlete'){
				$pageTitle = 'My Athletes';
			}
			else {
				$this->redirect($this->referer());
			}

			switch($userType){
				case 'athlete':
					$this->loadModel('Athlete');
					$userDetails = $this->Athlete->findById($userId, array('fields' => 'Sport.id'));
					break;
				case 'coach':
					$this->loadModel('HsAauCoach');
					$userDetails = $this->HsAauCoach->findById($userId, array('fields' => 'Sport.id'));
					break;
				case 'college':
					$this->loadModel('CollegeCoach');
					$userDetails = $this->CollegeCoach->findById($userId, array('fields' => 'Sport.id'));
					break;
			}

			$this->paginate = array('Network' =>
			array('conditions'=>
			array('OR' => array(array('AND' => array ('Network.receiver_id' => $userId, 'Network.sender_type' => $type)),
			array('AND' => array ('Network.sender_id' => $userId,  'Network.receiver_type' => $type))),
								'Network.status' => 'Active')));

			$networks = $this->paginate('Network');
				
			foreach($networks as $key => $value){
				if($userId != $value['Network']['sender_id']){
					$networks[$key]['Network']['user_id'] = $value['Network']['sender_id'];
					$networks[$key]['Network']['user_type'] = $value['Network']['sender_type'];
				}
				else{
					$networks[$key]['Network']['user_id'] = $value['Network']['receiver_id'];
					$networks[$key]['Network']['user_type'] = $value['Network']['receiver_type'];
				}

				if ($type == 'athlete'){
					$this->loadModel('Athlete');
					$athlete = $this->Athlete->findById($networks[$key]['Network']['user_id']);
					if (isset($athlete['Athlete'])){
						$networks[$key]['Network']['Athlete']['id'] = $athlete['Athlete']['id'];
						$networks[$key]['Network']['Athlete']['firstname'] = $athlete['Athlete']['firstname'];
						$networks[$key]['Network']['Athlete']['lastname'] = $athlete['Athlete']['lastname'];
						$networks[$key]['Network']['Athlete']['username'] = $athlete['Athlete']['username'];
						$networks[$key]['Network']['Athlete']['image'] = $athlete['Athlete']['image'];
						$networks[$key]['Network']['Athlete']['height'] = $athlete['Athlete']['height'];
						$networks[$key]['Network']['Athlete']['primary_position'] = $athlete['Athlete']['primary_position'];
						$networks[$key]['Network']['Athlete']['secondary_position'] = $athlete['Athlete']['secondary_position'];
						$networks[$key]['Network']['Athlete']['total_points'] = $athlete['Athlete']['total_points'];

						// Get school name.
						$this->loadModel('HsAauTeam');
						$hsAuuTeam = $this->HsAauTeam->findById($athlete['Athlete']['hs_aau_team_id'], array('fields' => 'HsAauTeam.id, HsAauTeam.school_name'));
						$networks[$key]['Network']['HsAauTeam']['school_name'] = $hsAuuTeam['HsAauTeam']['school_name'];

						// Get sport name.
						$this->loadModel('Sport');
						$sport = $this->Sport->findById($athlete['Athlete']['sport_id'], array('fields' => 'Sport.id, Sport.name'));
						$networks[$key]['Network']['Sport']['id']   = $sport['Sport']['id'];
						$networks[$key]['Network']['Sport']['name'] = $sport['Sport']['name'];
					}
				}
				elseif ($type == 'coach'){
					$this->loadModel('HsAauCoach');
					$coach = $this->HsAauCoach->findById($networks[$key]['Network']['user_id']);

					if (isset($coach['HsAauCoach'])){
						$networks[$key]['Network']['HsAauCoach']['id'] = $coach['HsAauCoach']['id'];
						$networks[$key]['Network']['HsAauCoach']['firstname'] = $coach['HsAauCoach']['firstname'];
						$networks[$key]['Network']['HsAauCoach']['lastname'] = $coach['HsAauCoach']['lastname'];
						$networks[$key]['Network']['Sport']['id'] = $coach['Sport']['id'];
						$networks[$key]['Network']['Sport']['name'] = $coach['Sport']['name'];
					}
				}
				elseif ($type == 'college') {
					$this->loadModel('CollegeCoach');
					$college = $this->CollegeCoach->findById($networks[$key]['Network']['user_id']);
					if (isset($college['CollegeCoach'])){
						$networks[$key]['Network']['CollegeCoach']['id'] = $college['CollegeCoach']['id'];
						$networks[$key]['Network']['CollegeCoach']['firstname'] = $college['CollegeCoach']['firstname'];
						$networks[$key]['Network']['CollegeCoach']['lastname'] = $college['CollegeCoach']['lastname'];
					}
				}
			}
			$this->set(compact('userDetails', 'networks', 'userType', 'pageTitle', 'type'));
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * Network Request
	 */
	public function requests(){
		$userId = $this->Session->read('user_id');
		if (isset($userId)){

			// Get received requests.
			$receivedRequests = $this->Network->find('all', array('conditions' => array('Network.status' => 'Pending', 'Network.receiver_id' => $userId)));
			$tmpReceivedRequests = $receivedRequests;

			foreach ($receivedRequests as $key => $value){
				if ($value['Network']['sender_type'] == 'athlete'){
					$this->loadModel('Athlete');
					$athlete = $this->Athlete->findById($value['Network']['sender_id'], array('fields' => 'Athlete.username, Athlete.image'));

					if (isset($athlete['Athlete'])) {
						$tmpReceivedRequests[$key]['Network']['username'] = $athlete['Athlete']['username'];
						$tmpReceivedRequests[$key]['Network']['image'] = $athlete['Athlete']['image'];
					}
				}
				else if ($value['Network']['sender_type'] == 'coach'){
					$this->loadModel('HsAauCoach');
					$this->HsAauCoach->recursive = -1;
					$coach = $this->HsAauCoach->findById($value['Network']['sender_id'], array('fields' => 'HsAauCoach.username'));

					if (isset($coach['HsAauCoach'])) {
						$tmpReceivedRequests[$key]['Network']['username'] = $coach['HsAauCoach']['username'];
					}
					// Get rating of athlete.
					$this->loadModel('Rating');
					$countRating = $this->Rating->find('count', array('conditions'=> array('Rating.athlete_id' => $value['Network']['id'])));
					$tmpReceivedRequests[$key]['Network']['count_rating'] = $countRating;

				}
				else if ($value['Network']['sender_type'] == 'college'){
					$this->loadModel('CollegeCoach');
					$college = $this->CollegeCoach->findById($value['Network']['sender_id'], array('fields' => 'CollegeCoach.username'));

					if (isset($college['CollegeCoach'])) {
						$tmpReceivedRequests[$key]['Network']['username'] = $college['CollegeCoach']['username'];
					}
				}
			}

			$receivedRequests = $tmpReceivedRequests;

			// Get sender requests.
			$sentRequests = $this->Network->find('all', array('conditions' => array('Network.status' => 'Pending', 'Network.sender_id' => $userId)));
			$tmpSentRequests = $sentRequests;

			foreach ($sentRequests as $key => $value){
				if ($value['Network']['receiver_type'] == 'athlete'){
					$this->loadModel('Athlete');
					$athlete = $this->Athlete->findById($value['Network']['receiver_id'], array('fields' => 'Athlete.username, Athlete.image'));

					if (isset($athlete['Athlete'])) {
						$tmpSentRequests[$key]['Network']['username'] = $athlete['Athlete']['username'];
						$tmpSentRequests[$key]['Network']['image'] = $athlete['Athlete']['image'];
					}
				}
				else if ($value['Network']['receiver_type'] == 'coach'){
					$this->loadModel('HsAauCoach');
					$this->HsAauCoach->recursive = -1;
					$coach = $this->HsAauCoach->findById($value['Network']['receiver_id'], array('fields' => 'HsAauCoach.username'));

					if (isset($coach['HsAauCoach'])) {
						$tmpSentRequests[$key]['Network']['username'] = $coach['HsAauCoach']['username'];
					}
				}
				else if ($value['Network']['receiver_type'] == 'college'){
					$this->loadModel('CollegeCoach');
					$college = $this->CollegeCoach->findById($value['Network']['receiver_id'], array('fields' => 'CollegeCoach.username'));

					if (isset($college['CollegeCoach'])) {
						$tmpSentRequests[$key]['Network']['username'] = $college['CollegeCoach']['username'];
					}
				}
			}

			$sentRequests = $tmpSentRequests;
			$this->set(compact('sentRequests', 'receivedRequests'));

		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}

	}

	public function sendRequest($id=false,$type='athlete'){
		$userId = $this->Session->read('user_id');
		if (isset($userId)){
			if (isset($id)){
				$Network = array();
				$Network['sender_id'] = $userId;
				$Network['receiver_id']   = $id;
				$Network['sender_type']   = $this->Session->read('user_type');
				$Network['receiver_type'] = $type;
				$Network['status'] = 'Pending';
				$Network['date_added'] = date('Y-m-d H:i:s');

				$this->Network->save($Network);
				$this->Session->setFlash("Network request sent. User has been sent a nofication.");
				//Send Email
			}
			else {
				$this->Session->setFlash("Do not exits this request.");
			}
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
		$this->redirect(array('controller' => 'Network', 'action' => 'requests'));
	}

	/**
	 * Active request
	 * @param $id
	 */
	public function activeRequest($id){
		$userId = $this->Session->read('user_id');
		if (isset($userId)){
			if (isset($id)){
				$this->Network->id = $id;
				$this->Network->saveField('status', 'Active');
				$this->Session->setFlash("Network Request approved. User has been sent a nofication.");
				//Send Email
			}
			else {
				$this->Session->setFlash("Do not exits this request.");
			}
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
		$this->redirect(array('controller' => 'Network', 'action' => 'requests'));
	}

	/**
	 * Deactive request
	 * @param $id
	 */
	public function deactiveRequest($id){
		$userId = $this->Session->read('user_id');
		if (isset($userId)){
			if (isset($id)){
				$this->Network->id = $id;
				$this->Network->saveField('status', 'Pending');
				$this->Session->setFlash("Network Link successfully de-activated");
			}
			else {
				$this->Session->setFlash("Do not exits this request.");
			}
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
		$this->redirect(array('controller' => 'Network', 'action' => 'requests'));
	}

	/**
	 * Delete request
	 * @param $id
	 */
	public function deleteRequest($id){
		$userId = $this->Session->read('user_id');
		if (isset($userId)){
			$isMine = $this->Network->find('count', array('conditions' => array('OR' => array('Network.sender_id' => $userId, 'Network.receiver_id' => $userId), 'Network.id' => $id)));
			if ($isMine > 0){
				$this->Network->delete($id);
				$this->Session->setFlash("Network Request successfully deleted.");
			}
			else {
				$this->Session->setFlash("The Network Request wasnt deleted.");
			}
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
		$this->redirect(array('controller' => 'Network', 'action' => 'requests'));
	}
}
