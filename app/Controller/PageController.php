<?php

class PageController extends AppController{

	public $name = 'Page';

	public $components = array('Email','RequestHandler');

	public $helpers = array('Html','Form','Js' => array('Jquery'));

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
	
	public function admin_pageList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('Page.title LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('Page');			
			$this->paginate = array('Page'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$pages = $this->paginate('Page');
			$this->set(compact('pages', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('Page');
			$this->paginate = array('Page' => array('limit' => $limit));
			$pages = $this->paginate('Page');
									
			$this->set(compact('pages', 'limit'));
		}
	}
	
	public function admin_deletePage($id){
		if (isset($id)){
			if($this->Page->delete($id)){
				$this->Session->setFlash('Page Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Page', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Page', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_editPage($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->Page->id = $id;
				if ($this->Page->save($this->request->data)){
					$this->Session->setFlash('Page Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'Page', 'action' => 'pageList'));
				} else {
					$this->Session->setFlash('Can not update this Page', 'flash_error');
				}
			} else {
				$page = $this->Page->findById($id);																			
				$this->set('page', $page);
			}
		} else {
			$this->Session->setFlash('Do not exits this Page', 'flash_error');
		}	
	}
	
	public function admin_deleteSelectedPage(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Page->delete($id)){
					$this->Session->setFlash('Page Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_addPage(){	
		if ($this->request->is('post')){
			if ($this->Page->save($this->request->data)){
				$this->Session->setFlash('Page is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'Page', 'action' => 'pageList'));
			} else {
				$this->Session->setFlash('Can not add this Page', 'flash_error');
			}
		} 
	}
	
	public function admin_homeContentList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('HomeContent.title LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('HomeContent');			
			$this->paginate = array('HomeContent'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$homeContents = $this->paginate('HomeContent');
			$this->set(compact('homeContents', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('HomeContent');
			$this->paginate = array('HomeContent' => array('limit' => $limit));
			$homeContents = $this->paginate('HomeContent');
									
			$this->set(compact('homeContents', 'limit'));
		}
	}
	
	public function admin_editHomeContent($id){
		$this->loadModel('HomeContent');
		if (isset($id)){
			if ($this->request->is('post')){
				$this->HomeContent->id = $id;
				if ($this->HomeContent->save($this->request->data)){
					$this->Session->setFlash('HomeContent Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'Page', 'action' => 'homeContentList'));
				} else {
					$this->Session->setFlash('Can not update this HomeContent', 'flash_error');
				}
			} else {
				$homeContent = $this->HomeContent->findById($id);																			
				$this->set('homeContent', $homeContent);
			}
		} else {
			$this->Session->setFlash('Do not exits this HomeContent', 'flash_error');
		}	
	}
	
}