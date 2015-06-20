<?php

class ScoutReportController extends AppController{

	public $name = 'ScoutReport';

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

	public function admin_scoutreportList(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];

			if (!empty($searchName)){
				$conditions = array('ScoutReport.name LIKE ' => '%'.$searchName.'%');
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('ScoutReport');
			$this->paginate = array('ScoutReport'=>array('conditions' => $conditions,  'limit' => $limit));

			$ScoutReports = $this->paginate('ScoutReport');
			$this->set(compact('ScoutReports', 'limit'));
		} else {
			$limit = 50;
			$this->loadModel('ScoutReport');
			$this->paginate = array('ScoutReport' => array('limit' => $limit));
			$ScoutReports = $this->paginate('ScoutReport');

			$this->set(compact('ScoutReports', 'limit'));
		}
	}

	public function admin_deleteScoutreport($id){
		if (isset($id)){
			if($this->ScoutReport->delete($id)){
				$this->Session->setFlash('Scout Report Deleted Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not delete this Scout Report', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Scout Report', 'flash_error');
		}
		$this->redirect($this->referer());
	}

	public function admin_editScoutreport($id){
		if (isset($id)){
			if ($this->request->is('post')){

                            if(isset($_FILES['picture']) && !empty($_FILES['picture'])){
                            if($_FILES['picture']['error'] == 0 && $_FILES['picture']['size'] > 0){
                            $filename = '' ;
                                if (!empty($_FILES['picture']['tmp_name']) && is_uploaded_file($_FILES['picture']['tmp_name']))
                                {
                                    // Strip path information
                                    $filename = mt_rand() . "_" . $_FILES['picture']['name'] ;
                                    move_uploaded_file( $_FILES['picture']['tmp_name'] , WWW_ROOT . DS . 'img/scoutreport' . DS . $filename);
                                    $this->request->data['picture'] = $filename ;
                                }
                                }else{
                                    $this->Session->setFlash('Picture Not Uploaded due to some error', 'flash_error');
                                }
                             }
				$this->ScoutReport->id = $id;
				if ($this->ScoutReport->save($this->request->data)){
					$this->Session->setFlash('Scout Report Updated Successfully!', 'flash_success');
					$this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
				} else {
					$this->Session->setFlash('Can not update this Scout Report', 'flash_error');
				}
			} else {
				$ScoutReport = $this->ScoutReport->findById($id);
				$this->set('ScoutReport', $ScoutReport);
			}
		} else {
			$this->Session->setFlash('Do not exits this Wingspan', 'flash_error');
		}
	}

	public function admin_addScoutreport(){
		if ($this->request->is('post')){

                    if(isset($_FILES['picture']) && !empty($_FILES['picture'])){
                        if($_FILES['picture']['error'] == 0 && $_FILES['picture']['size'] > 0){

                            $filename = '' ;
                                if (!empty($_FILES['picture']['tmp_name']) && is_uploaded_file($_FILES['picture']['tmp_name']))
                                {
                                    // Strip path information
                                    $filename = mt_rand() . "_" . $_FILES['picture']['name'] ;
                                    move_uploaded_file( $_FILES['picture']['tmp_name'] , WWW_ROOT . DS . 'img/scoutreport' . DS . $filename);
                                    $this->request->data['picture'] = $filename ;
                                }
                        }else{
                            $this->Session->setFlash('Picture Not Uploaded due to some error', 'flash_error');
                        }
                    }
                    
			if ($this->ScoutReport->save($this->request->data)){
				$this->Session->setFlash('Scout Report is Added Successfully', 'flash_success');
				$this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
			} else {
				$this->Session->setFlash('Can not add this Scout Report', 'flash_error');
			}
		}
	}

        public function admin_scoutDetails($id) {
		if (isset($id)){
			$ScoutReport = $this->ScoutReport->findById($id);
			$this->set('ScoutReport', $ScoutReport);
		} else {
			$this->Session->setFlash('Do not exits this Scout Report', 'flash_error');
		}
	}

        public function admin_getHSScout() { 
        $this->autoRender = false;
        $this->layout = 'ajax';
        $schools = array() ;
        $html = '' ;
        $this->loadModel('HsAauTeam');
        if(isset($_GET['state_id']) && !empty($_GET['state_id'])) {
            $state_id = $_GET['state_id'] ;
            $schools = $this->HsAauTeam->find("list",array("conditions"=>array('state'=>$state_id),"fields"=>"id,school_name","order"=>"school_name ASC"));
              foreach($schools as $key=>$name){
                           $html .= "<option value=$key >" . $name  . "</option>" ;              
                           }
        }
        echo $html ;die ;
        //echo'<pre>';print_r($html);exit;
          // echo json_encode($colleges); die;
        }
}