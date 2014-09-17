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
				$pageTitle = 'My College Coach';				
			}
			elseif($type == 'coach'){
				$pageTitle = 'My HS/AAU Coach';
			}
			elseif($type == 'athlete'){
				$pageTitle = 'My Athletes';
			} else {
				$this->redirect($this->referer());
			}
						
			switch($userType){
				case 'Athlete':
					$this->loadModel('Athlete');
					$userDetails = $this->Athlete->findById($userId);									
					break;
				case 'HsAauCoach':
					$this->loadModel('HsAauCoach');
					$userDetails = $this->HsAauCoach->findById($userId);
					break;
				case 'CollegeCoach':
					$this->loadModel('CollegeCoach');
					$userDetails = $this->CollegeCoach->findById($userId);
					break;
			}
					
			$this->paginate = array('Network' => array('conditions'=> 
														array('OR' => array(array('Network.receiver_id' => $userId, 'Network.sender_type' => $type), 
																	        array('Network.sender_id' => $userId, 'Network.receiver_type' => $type)), 
															  'Network.status' => 'Active')));
																	       
			$networks = $this->paginate('Network');
				
			foreach($networks as $i => $network){
				if($userId != $network['Network']['sender_id']){
					$networks[$i]['Network']['user_id'] = $network['Network']['sender_id'];
					$networks[$i]['Network']['user_type'] = $network['Network']['sender_type'];
				}
				else{
					$networks[$i]['Network']['user_id'] = $network['Network']['receiver_id'];
					$networks[$i]['Network']['user_type'] = $network['Network']['receiver_type'];
				}
			}
			
			$this->set(compact('userDetails', 'networks', 'userType', 'pageTitle', 'type'));
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * Network Request 
	 */
	public function requests(){
		$userId = $this->Session->read('user_id');
		if (isset($userId)){
			
			// Get receiver requests.
			$receiverRequests = $this->Network->find('all', array('conditions' => array('Network.status' => 'Pending', 'Network.receiver_id' => $userId)));
			$tmpReceiverRequests = $receiverRequests;
			 
			foreach ($receiverRequests as $key => $value){
				if ($value['Network']['receiver_type'] == 'athlete'){
					$this->loadModel('Athlete');
					$athlete = $this->Athlete->findById($userId);
					if (isset($athlete['Athlete'])) {
						$tmpReceiverRequests[$key]['Network']['username'] = $athlete['Athlete']['username'];
						$tmpReceiverRequests[$key]['Network']['image'] = $athlete['Athlete']['image'];
					}
				} else if ($value['Network']['receiver_type'] == 'coach'){										
					$this->loadModel('HsAauCoach');
					$this->HsAauCoach->recursive = -1;
					$coach = $this->HsAauCoach->findById($userId);

					if (isset($coach['HsAauCoach'])) {
						$tmpReceiverRequests[$key]['Network']['username'] = $coach['HsAauCoach']['username'];
					}
				} else if ($value['Network']['receiver_type'] == 'college'){
					$this->loadModel('CollegeCoach');
					$college = $this->CollegeCoach->findById($userId);
					if (isset($college['CollegeCoach'])) {
						$tmpReceiverRequests[$key]['Network']['username'] = $college['CollegeCoach']['username'];
					}
				}				
			}
			
			$receiverRequests = $tmpReceiverRequests;
			$this->set('receiverRequests', $receiverRequests);
						
			// Get sender requests.
			$senderRequests = $this->Network->find('all', array('conditions' => array('Network.status' => 'Pending', 'Network.sender_id' => $userId)));
			$tmpSenderRequests = $senderRequests;
			 
			foreach ($senderRequests as $key => $value){
				if ($value['Network']['sender_type'] == 'athlete'){
					$this->loadModel('Athlete');
					$athlete = $this->Athlete->findById($userId);
					if (isset($athlete['Athlete'])) {
						$tmpSenderRequests[$key]['Network']['username'] = $athlete['Athlete']['username'];
						$tmpSenderRequests[$key]['Network']['image'] = $athlete['Athlete']['image'];
					}
				} else if ($value['Network']['sender_type'] == 'coach'){										
					$this->loadModel('HsAauCoach');
					$this->HsAauCoach->recursive = -1;
					$coach = $this->HsAauCoach->findById($userId);

					if (isset($coach['HsAauCoach'])) {
						$tmpSenderRequests[$key]['Network']['username'] = $coach['HsAauCoach']['username'];
					}
				} else if ($value['Network']['sender_type'] == 'college'){
					$this->loadModel('CollegeCoach');
					$college = $this->CollegeCoach->findById($userId);
					if (isset($college['CollegeCoach'])) {
						$tmpSenderRequests[$key]['Network']['username'] = $college['CollegeCoach']['username'];
					}
				}				
			}
			
			$senderRequests = $tmpSenderRequests;
			$this->set('senderRequests', $senderRequests);
												
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));			
		}
		
	}

	public function sendRequest(){

	}

	public function confirmRequest(){

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
			} else {
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
				//Send Email
			} else {
				$this->Session->setFlash("Do not exits this request.");
			}		
		} else {
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
			} else {
				$this->Session->setFlash("The Network Request wasnt deleted.");
			}			
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));		
		}
		$this->redirect(array('controller' => 'Network', 'action' => 'requests'));		
	}
}
