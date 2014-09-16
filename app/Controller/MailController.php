<?php

class MailController extends AppController{

	public $name = 'Mail';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}
		
	public function index(){
		// Get the number of emails.
		$username = $this->Session->read("username");
		if (!empty($username)){	
			$count = $this->Mail->find('count', array('conditions' => array('Mail.receiver' => $username, 'Mail.status' => 'unread')));
			$inboxMassages = $this->Mail->find('all', array('conditions' => array('Mail.receiver' => $username , 'Mail.status <>' => 'delete'), 'order' => 'id DESC'));

			$this->set(compact('inboxMassages', 'count'));
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
		
	}

	public function sent(){
		$username = $this->Session->read("username");
		if (!empty($username)){	
			$sentMassages = $this->Mail->find('all', array('conditions' => array('Mail.sender' => $username , 'Mail.status <>' => 'delete'), 'order' => 'id DESC'));
			$this->set('sentMassages', $sentMassages);
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}

	public function trash(){
		$username = $this->Session->read("username");
		if (!empty($username)){	
			$trashMassages = $this->Mail->find('all', array('conditions' => array('OR' => array('Mail.sender' => $username, 'Mail.receiver' => $username) , 'Mail.status <>' => 'delete'), 'order' => 'id DESC'));
			$this->set('trashMassages', $trashMassages);
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}
	
	public function view($id){
		$username = $this->Session->read("username");
		if (!empty($username) && !empty($id)){	
			$viewMassage = $this->Mail->find('first', array('conditions' => array('Mail.id' => $id), 'order' => 'id DESC'));
			
			$this->loadModel('Athlete');
			$getName =  $this->Athlete->find('first', array('conditions' => array('Athlete.username' => $viewMassage['Mail']['sender']), 
															'field' => array('Athlete.username', 'Athlete.lastname', 'Athlete.id')));						
			$fullName = ucfirst($getName['Athlete']['firstname']).'&nbsp;'.ucfirst($getName['Athlete']['lastname']);
			$newSubject = $viewMassage['Mail']['subject'];
			$userTypeFrom = $viewMassage['Mail']['usertype_from'];
			$userTypeTo = $viewMassage['Mail']['usertype_to'];
			$sender = $viewMassage['Mail']['sender'];
			$this->set(compact('sender', 'viewMassage', 'fullName', 'newSubject', 'userTypeFrom', 'userTypeTo'));
			
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}
		
	public function compose(){
		$username = $this->Session->read("username");
		if (!empty($username)){	
			if (!$this->request->is('post')){
				$id = $this->params['named']['id'];
				$mail = $this->Mail->findById($id);
				
				$message = "---------------------------------------------------------------<br>"; 
				$message = $message . $mail['Mail']['message'];
				$message = str_replace("<br>", "\n", $message); 
                $message = "\n\n\n" . $message; 
				
				$sender = $this->params['named']['sender'];
				$receiver = str_replace("%"," ",$this->params['named']['to']);
				$subject = str_replace("%"," ",$this->params['named']['subject']); 
				$this->set(compact('sender', 'receiver', 'subject', 'message'));
			} else {								
				$this->request->data['status'] = 'unread';
				$this->request->data['sent_date'] = date('YmdHis');
				$this->request->data['usertype_from'] = $this->params['named']['userTypeTo'];
				$this->request->data['usertype_to'] = $this->params['named']['userTypeFrom'];
				$this->request->data['added_date'] = date('YmdHis');
				if (isset($this->request->data['isSubmit'])){
					unset($this->request->data['isSubmit']);
				}
				$this->Mail->create();
				$this->Mail->save($this->request->data);
				$this->Session->setFlash("Message successfully sent.");
				$this->redirect(array('controller' => 'Mail', 'action' => 'index'));
			}
			
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));
		}
	}
	
	public function delete($id){
		if (empty($id)){
			$this->Session->setFlash("The message wasnt deleted.");
		} else {
			$this->Mail->id = $id;
			$this->Mail->saveField('status', 'delete');
			$this->Session->setFlash("Message successfully sent to trash.");			
		}
		$this->redirect(array('controller' => 'Mail', 'action' => 'index'));
		
	}
	
	public function deleteconfirm($id){
		if (empty($id)){
			$this->Session->setFlash("The message wasnt deleted.");
		} else {
			$this->Mail->delete($id);
			$this->Session->setFlash("Message successfully deleted (permanently).");			
		}
		$this->redirect(array('controller' => 'Mail', 'action' => 'trash'));
		
	}

	public function composePopup(){
		$this->layout = 'popup';
	}
}
