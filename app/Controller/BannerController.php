<?php

class BannerController extends AppController{

	public $name = 'Banner';

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
	
	public function admin_bannerList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
			
			if (!empty($searchName)){
				$conditions = array('Banner.title LIKE ' => '%'.$searchName.'%');				
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('Banner');			
			$this->paginate = array('Banner'=>array('conditions' => $conditions,
												   'limit' => $limit));
												   
			$banners = $this->paginate('Banner');
			$this->set(compact('banners', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('Banner');
			$this->paginate = array('Banner' => array('limit' => $limit));
			$banners = $this->paginate('Banner');
									
			$this->set(compact('banners', 'limit'));
		}
	}
	
	public function admin_deleteBanner($id){
		if (isset($id)){
			if($this->Banner->delete($id)){
				$this->Session->setFlash('Banner Deleted Successfully!', 'flash_success');					
			} else {
				$this->Session->setFlash('Can not delete this Banner', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Banner', 'flash_error');
		}	
		$this->redirect($this->referer());
	}
	
	public function admin_editBanner($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->Banner->id = $id;
				if ($this->Banner->save($this->request->data)){
					$this->Session->setFlash('Banner Updated Successfully!', 'flash_success');	
					$this->redirect(array('controller' => 'Banner', 'action' => 'bannerList'));
				} else {
					$this->Session->setFlash('Can not update this Banner', 'flash_error');
				}
			} else {
				$banner = $this->Banner->findById($id);																			
				$this->set('banner', $banner);
			}
		} else {
			$this->Session->setFlash('Do not exits this Banner', 'flash_error');
		}	
	}
	
	public function admin_deleteSelectedBanner(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->Banner->delete($id)){
					$this->Session->setFlash('Banner Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}								
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_addBanner(){	
		if ($this->request->is('post')){
			if ($this->Banner->save($this->request->data)){
				$this->Session->setFlash('Banner is Added Successfully', 'flash_success');	
				$this->redirect(array('controller' => 'Banner', 'action' => 'bannerList'));
			} else {
				$this->Session->setFlash('Can not add this Banner', 'flash_error');
			}
		} 
	}
	
}