<?php

class MailController extends AppController{

	public $name = 'Mail';

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

	/**
	 * Inbox Email
	 */
	public function index(){
		// Get the number of emails.
		$username = $this->Session->read("username");
		if (!empty($username)){
			$count = $this->Mail->find('count', array('conditions' => array('Mail.receiver' => $username, 'Mail.status' => 'unread')));
			$inboxMassages = $this->Mail->find('all', array('conditions' => array('Mail.receiver' => $username , 'Mail.status <>' => 'delete'), 'order' => 'id DESC'));

			// Get id of sender
			$tmpInboxMassages = $inboxMassages;
			foreach ($inboxMassages as $key => $value){
				if ($value['Mail']['usertype_from'] == 'athlete'){
					$this->loadModel('Athlete');
					$athlete = $this->Athlete->find('first', array('conditions' => array('Athlete.username' => $value['Mail']['sender']), 'fields' => array('Athlete.id')));
					if (isset($athlete['Athlete'])) {
						$tmpInboxMassages[$key]['Mail']['from_id'] = $athlete['Athlete']['id'];
					}
				}
				else if ($value['Mail']['usertype_from'] == 'coach'){
					$this->loadModel('HsAauCoach');
					$coach = $this->HsAauCoach->find('first', array('conditions' => array('HsAauCoach.username' => $value['Mail']['sender']), 'fields' => array('HsAauCoach.id')));
					if (isset($coach['HsAauCoach'])) {
						$tmpInboxMassages[$key]['Mail']['from_id'] = $coach['HsAauCoach']['id'];
					}
				}
				else if ($value['Mail']['usertype_from'] == 'college'){
					$this->loadModel('CollegeCoach');
					$college = $this->CollegeCoach->find('first', array('conditions' => array('CollegeCoach.username' => $value['Mail']['sender']), 'fields' => array('CollegeCoach.id')));
					if (isset($college['CollegeCoach'])) {
						$tmpInboxMassages[$key]['Mail']['from_id'] = $college['CollegeCoach']['id'];
					}
				}
			}
			$inboxMassages = $tmpInboxMassages;
			$this->set(compact('inboxMassages', 'count'));
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * Sent Email
	 */
	public function sent(){
		$username = $this->Session->read("username");
		if (!empty($username)){
			$sentMassages = $this->Mail->find('all', array('conditions' => array('Mail.sender' => $username , 'Mail.status <>' => 'delete'), 'order' => 'id DESC'));

			// Get id of receiver.
			$tmpSentMassages = $sentMassages;
			foreach ($sentMassages as $key => $value){
				if ($value['Mail']['usertype_from'] == 'athlete'){
					$this->loadModel('Athlete');
					$athlete = $this->Athlete->find('first', array('conditions' => array('Athlete.username' => $value['Mail']['receiver']), 'fields' => array('Athlete.id')));
					if (isset($athlete['Athlete'])) {
						$tmpSentMassages[$key]['Mail']['to_id'] = $athlete['Athlete']['id'];
					}
				}
				else if ($value['Mail']['usertype_from'] == 'coach'){
					$this->loadModel('HsAauCoach');
					$coach = $this->HsAauCoach->find('first', array('conditions' => array('HsAauCoach.username' => $value['Mail']['receiver']), 'fields' => array('HsAauCoach.id')));
					if (isset($coach['HsAauCoach'])) {
						$tmpSentMassages[$key]['Mail']['to_id'] = $coach['HsAauCoach']['id'];
					}
				}
				else if ($value['Mail']['usertype_from'] == 'college'){
					$this->loadModel('CollegeCoach');
					$college = $this->CollegeCoach->find('first', array('conditions' => array('CollegeCoach.username' => $value['Mail']['receiver']), 'fields' => array('CollegeCoach.id')));
					if (isset($college['CollegeCoach'])) {
						$tmpSentMassages[$key]['Mail']['to_id'] = $college['CollegeCoach']['id'];
					}
				}
			}
			$sentMassages = $tmpSentMassages;
			$this->set('sentMassages', $sentMassages);
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * Trash Email
	 */
	public function trash(){
		$username = $this->Session->read("username");
		if (!empty($username)){
			$trashMassages = $this->Mail->find('all', array('conditions' => array('OR' => array('Mail.sender' => $username, 'Mail.receiver' => $username) , 'Mail.status ' => 'delete'), 'order' => 'id DESC'));
			$this->set('trashMassages', $trashMassages);
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * View email by $id
	 */
	public function view($id){
		$username = $this->Session->read("username");
		if (!empty($username) && !empty($id)){
			// Set status to read.
			$this->Mail->id = $id;
			$this->Mail->saveField('status', 'read');

			// View message
			$viewMassage = $this->Mail->find('first', array('conditions' => array('Mail.receiver' => $username, 'Mail.id' => $id), 'order' => 'id DESC'));

			$fullName = "";
			$userTypeFrom = $viewMassage['Mail']['usertype_from'];
			if ($userTypeFrom == 'athlete') {
				$this->loadModel('Athlete');
				$getName =  $this->Athlete->find('first', array('conditions' => array('Athlete.username' => $viewMassage['Mail']['receiver']),
																'fields' => array('Athlete.firstname', 'Athlete.lastname', 'Athlete.id')));
				if (isset($getName['Athlete'])){
					$fullName = ucfirst($getName['Athlete']['firstname']).'&nbsp;'.ucfirst($getName['Athlete']['lastname']);
				}
			}
			else if ($userTypeFrom == 'coach') {
				$this->loadModel('HsAauCoach');
				$getName =  $this->HsAauCoach->find('first', array('conditions' => array('HsAauCoach.username' => $viewMassage['Mail']['receiver']),
																'fields' => array('HsAauCoach.firstname', 'HsAauCoach.lastname', 'HsAauCoach.id')));
					
				if (isset($getName['HsAauCoach'])){
					$fullName = ucfirst($getName['HsAauCoach']['firstname']).'&nbsp;'.ucfirst($getName['HsAauCoach']['lastname']);
				}
			}
			else if ($userTypeFrom == 'college') {
				$this->loadModel('CollegeCoach');
				$getName =  $this->CollegeCoach->find('first', array('conditions' => array('CollegeCoach.username' => $viewMassage['Mail']['receiver']),
																'fields' => array('CollegeCoach.firstname', 'CollegeCoach.lastname', 'CollegeCoach.id')));
				if (isset($getName['CollegeCoach'])){
					$fullName = ucfirst($getName['CollegeCoach']['firstname']).'&nbsp;'.ucfirst($getName['CollegeCoach']['lastname']);
				}
			}
			$newSubject = $viewMassage['Mail']['subject'];
			$userTypeTo = $viewMassage['Mail']['usertype_to'];
			$newFrom = $viewMassage['Mail']['sender'];
			$this->set(compact('newFrom', 'viewMassage', 'fullName', 'newSubject', 'userTypeFrom', 'userTypeTo'));
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * Compose email.
	 */
	public function compose(){
		$username = $this->Session->read("username");
		// Reply and maybe forward
		if (!empty($username) && !isset($this->params['named']['value']) && isset($this->params['named']['id'])){
			if (!$this->request->is('post')){
				$id = $this->params['named']['id'];
				$mail = $this->Mail->findById($id);

				$message = "---------------------------------------------------------------<br>";
				$message = $message . $mail['Mail']['message'];
				$message = str_replace("<br>", "\n", $message);
				$message = "\n\n\n" . $message;

				$sender = $this->params['named']['newFrom'];
				$receiver = str_replace("%"," ",$this->params['named']['to']);
				$subject = str_replace("%"," ",$this->params['named']['subject']);
				$this->set(compact('sender', 'receiver', 'subject', 'message'));
			}
			else {
				$this->request->data['status'] = 'unread';
				$this->request->data['sent_date'] = date('YmdHis');
				$this->request->data['usertype_from'] = $this->params['named']['userTypeFrom'];
				$this->request->data['usertype_to'] = $this->params['named']['userTypeTo'];
				$this->request->data['sender'] = $username;
				$this->request->data['receiver'] = $this->params['named']['newFrom'];
				if (isset($this->request->data['isSubmit'])){
					unset($this->request->data['isSubmit']);
				}

				$this->Mail->save($this->request->data);
				$this->Session->setFlash("Message successfully sent.");
				$this->redirect(array('controller' => 'Mail', 'action' => 'index'));
			}
		}
		// New email
		elseif (!empty($username) && isset($this->params['named']['value'])) {
			$value = $this->params['named']['value'];
			if (!$this->request->is('post')){
				if ($value == 'coach'){
					$this->loadModel('HsAauCoach');
					$coachList = $this->HsAauCoach->find('all', array('fields' => array('HsAauCoach.id', 'HsAauCoach.firstname', 'HsAauCoach.lastname', 'HsAauCoach.username'),
																	  'order' => array('HsAauCoach.lastname')));

				}
				elseif ($value == 'athlete') {
					$this->loadModel('Athlete');
					$coachList = $this->Athlete->find('all', array('fields' => array('Athlete.id', 'Athlete.firstname', 'Athlete.lastname', 'Athlete.username'),
																	  'order' => array('Athlete.lastname')));				
				}
				elseif ($value == 'college') {
					$this->loadModel('CollegeCoach');
					$coachList = $this->CollegeCoach->find('all', array('fields' => array('CollegeCoach.id', 'CollegeCoach.firstname', 'CollegeCoach.lastname', 'CollegeCoach.username'),
																	  'order' => array('CollegeCoach.lastname')));																			
				}
			}
			else {
				$this->request->data['sender'] = $username;
				$this->request->data['receiver'] = $this->request->data['to'];
				if ($this->Session->read('user_type') == 'Athlete') {
					$this->request->data['usertype_from'] = 'athlete';
				}
				elseif ($this->Session->read('user_type') == 'CollegeCoach') {
					$this->request->data['usertype_from'] = 'college';
				}
				elseif ($this->Session->read('user_type') == 'HsAauCoach') {
					$this->request->data['usertype_from'] = 'coach';
				}
				$this->request->data['usertype_to'] = $this->params['named']['value'];
				$this->request->data['status'] = 'unread';
				$this->request->data['sent_date'] = date('YmdHis');

				if (isset($this->request->data['isSubmit'])){
					unset($this->request->data['isSubmit']);
				}

				$this->Mail->save($this->request->data);
				$this->Session->setFlash("Message successfully sent.");
				$this->redirect(array('controller' => 'Mail', 'action' => 'index'));
			}

			$this->set(compact('value', 'coachList'));
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * View sent email by $id.
	 */
	public function viewSent($id){
		$username = $this->Session->read("username");
		if (!empty($username) && !empty($id)){
			$viewSent = $this->Mail->find('first', array('conditions' => array('Mail.sender' => $username, 'Mail.id' => $id), 'order' => 'id DESC'));
			$userTypeTo = $viewSent['Mail']['usertype_to'];

			$fullName = "";
			if ($userTypeTo == 'athlete') {
				$this->loadModel('Athlete');
				$getName =  $this->Athlete->find('first', array('conditions' => array('Athlete.username' => $viewSent['Mail']['receiver']),
																'fields' => array('Athlete.firstname', 'Athlete.lastname', 'Athlete.id')));

				if (isset($getName['Athlete'])){
					$fullName = ucfirst($getName['Athlete']['firstname']).'&nbsp;'.ucfirst($getName['Athlete']['lastname']);
				}
			}
			else if ($userTypeTo == 'coach') {
				$this->loadModel('HsAauCoach');
				$getName =  $this->HsAauCoach->find('first', array('conditions' => array('HsAauCoach.username' => $viewSent['Mail']['receiver']),
																'fields' => array('HsAauCoach.firstname', 'HsAauCoach.lastname', 'HsAauCoach.id')));
				if (isset($getName['HsAauCoach'])){
					$fullName = ucfirst($getName['HsAauCoach']['firstname']).'&nbsp;'.ucfirst($getName['HsAauCoach']['lastname']);
				}
			}
			else if ($userTypeTo == 'college') {
				$this->loadModel('CollegeCoach');
				$getName =  $this->CollegeCoach->find('first', array('conditions' => array('CollegeCoach.username' => $viewSent['Mail']['receiver']),
																'fields' => array('CollegeCoach.firstname', 'CollegeCoach.lastname', 'CollegeCoach.id')));
				if (isset($getName['CollegeCoach'])){
					$fullName = ucfirst($getName['CollegeCoach']['firstname']).'&nbsp;'.ucfirst($getName['CollegeCoach']['lastname']);
				}
			}

			$this->set(compact('viewSent', 'fullName'));
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * View trash email by $id.
	 */
	public function viewTrash($id){
		$username = $this->Session->read("username");
		if (!empty($username) && !empty($id)){
			$viewTrash = $this->Mail->find('first', array('conditions' => array('Mail.id' => $id, 'Mail.status' => 'delete'), 'order' => 'id DESC'));
			$userTypeTo = $viewTrash['Mail']['usertype_to'];
			$fullName = "";
			if ($userTypeTo == 'athlete') {
				$this->loadModel('Athlete');
				$getName =  $this->Athlete->find('first', array('conditions' => array('Athlete.username' => $viewTrash['Mail']['sender']),
																'fields' => array('Athlete.firstname', 'Athlete.lastname', 'Athlete.id')));
				if (isset($getName['Athlete'])){
					$fullName = ucfirst($getName['Athlete']['firstname']).'&nbsp;'.ucfirst($getName['Athlete']['lastname']);
				}
			}
			else if ($userTypeTo == 'coach') {
				$this->loadModel('HsAauCoach');
				$getName =  $this->HsAauCoach->find('first', array('conditions' => array('HsAauCoach.username' => $viewTrash['Mail']['sender']),
																'fields' => array('HsAauCoach.firstname', 'HsAauCoach.lastname', 'HsAauCoach.id')));
				if (isset($getName['HsAauCoach'])){
					$fullName = ucfirst($getName['HsAauCoach']['firstname']).'&nbsp;'.ucfirst($getName['HsAauCoach']['lastname']);
				}
			}
			else if ($userTypeTo == 'college') {
				$this->loadModel('CollegeCoach');
				$getName =  $this->CollegeCoach->find('first', array('conditions' => array('CollegeCoach.username' => $viewTrash['Mail']['sender']),
																'fields' => array('CollegeCoach.firstname', 'CollegeCoach.lastname', 'CollegeCoach.id')));
				if (isset($getName['CollegeCoach'])){
					$fullName = ucfirst($getName['CollegeCoach']['firstname']).'&nbsp;'.ucfirst($getName['CollegeCoach']['lastname']);
				}
			}

			$this->set(compact('viewTrash', 'fullName'));
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}

	}

	/**
	 * Restore email by $id.
	 */
	public function restore($id){
		$username = $this->Session->read("username");
		if (!empty($username) && !empty($id)){
			$this->Mail->id = $id;
			$this->Mail->saveField('status', 'read');
			$this->Session->setFlash("Message successfully Moved to Inbox.");
			$this->redirect(array('controller' => 'Mail', 'action' => 'trash'));
		}
		else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	/**
	 * Delete email by $id.
	 */
	public function delete($id){
		if (empty($id)){
			$this->Session->setFlash("The message wasnt deleted.");
		}
		else {
			$this->Mail->id = $id;
			$this->Mail->saveField('status', 'delete');
			$this->Session->setFlash("Message successfully sent to trash.");
		}
		$this->redirect(array('controller' => 'Mail', 'action' => 'index'));
	}

	/**
	 * Delete email permanently by $id.
	 */
	public function deleteconfirm($id){
		if (empty($id)){
			$this->Session->setFlash("The message wasnt deleted.");
		}
		else {
			$this->Mail->delete($id);
			$this->Session->setFlash("Message successfully deleted (permanently).");
		}
		$this->redirect(array('controller' => 'Mail', 'action' => 'trash'));
	}

	public function composePopup(){
		$this->layout = 'popup';

		if(isset($this->request->data['Mail'])){
			$this->request->data['Mail']['sender'] = $this->Session->read('username');
			$this->request->data['Mail']['usertype_from'] = $this->Session->read('user_type');
				
			$this->Mail->save($this->request->data['Mail']);
			$this->set("message","Message is sent successfully");
		}
		else{
			$usertype_to = $this->params['named']['type'];
			$receiver = $this->params['named']['receiver'];
				
			if($usertype_to == 'athlete'){
				$this->loadModel('Athlete');
				$userDetail = $this->Athlete->getByUsername($receiver);
				$this->set("userDetail",$userDetail['Athlete']);
			}
			elseif($usertype_to == 'college'){
				$this->loadModel('CollegeCoach');
				$userDetail = $this->CollegeCoach->getByUsername($receiver);
				$this->set("userDetail",$userDetail['CollegeCoach']);
			}
			else{
				$this->loadModel('HsAauCoach');
				$userDetail = $this->HsAauCoach->getByUsername($receiver);
				$this->set("userDetail",$userDetail['HsAauCoach']);
			}

			$this->set("receiver",$receiver);
			$this->set("usertype_to",$usertype_to);
		}
	}
	
	public function admin_listMessage(){
		if ($this->request->is('post')){
			$startDate 	= $this->request->data['startdate'];
			$endDate 	= $this->request->data['enddate'];
			$content 	= $this->request->data['content'];
			
			if ($startDate != 'Please Select Start Date' && $endDate != 'Please Select End Date' && $content != 'Search By Content'){
				$conditions = array('OR' =>array('Mail.message like ' => '%'.$content.'%',
												 'AND' => array(
													 'Mail.sent_date  >= ' => $startDate,
					                                 'Mail.sent_date  <= ' => $endDate
												 )));
			} elseif ($startDate == 'Please Select Start Date' && $endDate != 'Please Select End Date' && $content != 'Search By Content') {	
				$conditions = array('OR' =>array('Mail.message like ' => '%'.$content.'%', 
												 'Mail.sent_date  <= ' => $endDate));												 
			} elseif ($startDate != 'Please Select Start Date' && $endDate == 'Please Select End Date' && $content != 'Search By Content') {
				$conditions = array('OR' =>array('Mail.message like ' => '%'.$content.'%', 
												 'Mail.sent_date  >= ' => $startDate));
			} elseif ($startDate != 'Please Select Start Date' && $endDate != 'Please Select End Date' && $content == 'Search By Content'){
				$conditions = array('Mail.sent_date  >= ' => $startDate,
									'Mail.sent_date  <= ' => $endDate);					                								   
			} elseif ($startDate == 'Please Select Start Date' && $endDate == 'Please Select End Date' && $content != 'Search By Content'){
				$conditions = array('Mail.message like ' => '%'.$content.'%');
			} elseif ($startDate != 'Please Select Start Date' && $endDate == 'Please Select End Date' && $content == 'Search By Content'){
				$conditions = array('Mail.sent_date  >= ' => $startDate);
			} elseif ($startDate == 'Please Select Start Date' && $endDate != 'Please Select End Date' && $content == 'Search By Content'){
				$conditions = array('Mail.sent_date  <= ' => $endDate);
			} else {
				$conditions = array();
			}													
			$limit = 100;				   
			$this->paginate = array('Mail'=>array('conditions' => $conditions,
												  'order' => 'Mail.id',
												  'limit' => $limit));
			$mails = $this->paginate('Mail');
			$this->set(compact('mails', 'limit')); 
			
		} else {
			$limit = 100;
			$this->paginate = array('Mail'=>array('order' => 'Mail.id',
												  'limit' => $limit));
			$mails = $this->paginate('Mail');
			$this->set(compact('mails', 'limit')); 
		}
	}
	
	public function admin_messageDetails($id){
		if (isset($id)){
			$messge = $this->Mail->findById($id);
			$this->set('messge', $messge);
		} else {
			$this->Session->setFlash('Do not exits this Message', 'flash_error');
		}			
	}
	
	/**
	 * Delete selected Messages.
	 */
	public function admin_deleteSelectedMessages(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Mail->delete($id)){
					$this->Session->setFlash('Message Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_listBlockMessage(){
		$this->loadModel('BlockMessage');
		$limit = 100;
		$this->paginate = array('BlockMessage'=>array('order' => 'BlockMessage.id DESC',
												  	  'limit' => $limit));												      
		$blockMessages = $this->paginate('BlockMessage');
		$this->set(compact('blockMessages', 'limit'));
	}
	
	public function admin_deleteBlockMessage($id){
		if (!empty($id)) {
			$this->loadModel('BlockMessage');
			if ($this->BlockMessage->delete($id)){
				$this->Session->setFlash('Message Block Deleted Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not delete this Message', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Message', 'flash_error');			
		}
		$this->redirect($this->referer());
	}
	
	/**
	 * Delete selected Block Messages.
	 */
	public function admin_deleteSelectedBlockMessages(){
		$this->loadModel('BlockMessage');
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->BlockMessage->delete($id)){
					$this->Session->setFlash('Message Block Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_addBlockMessage(){
		if (!$this->request->is('post')){
			// Get sport list.
			$this->loadModel('Sport');
			$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'), 
													  'order' => array('Sport.id')));						
			$sportList = array();
			foreach ($sports as $sport){
				$sportList[$sport['Sport']['name']] = $sport['Sport']['name'];
			}
			
			$this->set(compact('sportList', 'sports'));
		} else {
			$this->loadModel('BlockMessage');
			if ($this->BlockMessage->save($this->request->data)){
				$this->Session->setFlash('Block Messaging is added successfully.', 'flash_success');
				$this->redirect(array('controller' => 'Mail', 'action' => 'listBlockMessage'));				
			} else {
				$this->Session->setFlash('Can not add this Block Message.', 'flash_error');
			}						
		}
	}
}