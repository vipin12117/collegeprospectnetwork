<?php

class NoteController extends AppController{

	public $name = 'Note';

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
	
	public function add($athlete_id = false , $type = 'athlete'){
		$this->layout = 'popup';
		
		if(isset($this->request->data['Note'])){
			$this->request->data['Note']['user_id']   = $athlete_id;
			$this->request->data['Note']['user_type'] = $type;
			$this->request->data['Note']['added_date'] = date('Y-m-d H:i:s');
			
			$this->Note->save($this->request->data);
			$this->set("message","Note added successfully");
		}
		
		$this->set("athlete_id",$athlete_id);
		$this->set("type",$type);
	}
	
	public function admin_noteList(){
		if ($this->request->is('post')){
			$searchName = addslashes($this->request->data['searchname']);
			
			if (!empty($searchName)){
				$conditions = array('OR' => array('Note.title LIKE ' => '%'.$searchName.'%', 'Note.description LIKE ' => '%'.$searchName.'%'));				
			} else {
				$conditions = array();
			}
			$limit = 100;			
			$this->paginate = array('Note'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$notes = $this->paginate('Note');
			$this->set(compact('notes', 'limit'));
		} else {
			$limit = 50;
			$this->paginate = array('Note' => array('limit' => $limit));
			$notes = $this->paginate('Note');
									
			$this->set(compact('notes', 'limit'));
		}
	}
	
	public function admin_deleteNote($id){
		if (isset($id)){
			if($this->Note->delete($id)){
				$this->Session->setFlash('Note Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Note', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Note', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_editNote($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->Note->id = $id;
				if ($this->Note->save($this->request->data)){
					$this->Session->setFlash('Note Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'Note', 'action' => 'noteList'));
				} else {
					$this->Session->setFlash('Can not update this Note', 'flash_error');
				}
			} else {
				$note = $this->Note->findById($id);																			
				$this->set('note', $note);
			}
		} else {
			$this->Session->setFlash('Do not exits this Note', 'flash_error');
		}	
	}
	
	public function admin_deleteSelectedNote(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Note->delete($id)){
					$this->Session->setFlash('Note Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_addNote(){	
		if ($this->request->is('post')){
			if ($this->Note->save($this->request->data)){
				$this->Session->setFlash('Note is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'Note', 'action' => 'noteList'));
			} else {
				$this->Session->setFlash('Can not add this Note', 'flash_error');
			}
		} 
	}
	
}