<?php

class HsAauCoachController extends AppController{

	public $name = 'HsAauCoach';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}
	
	public function index(){
		
	}

	public function viewAll($type){
		$userId = $this->Session->read('user_id');
		if (isset($userId) && isset($type)){
			
		} else {
			$this->redirect(array('controller' => 'Home', 'action' => 'login'));			
		}
	}
}