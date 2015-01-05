<?php

class CollegeController extends AppController{

	public $name = 'College';

	public $uses = array('College','CollegeCoach','Athlete','HsAauCoach');

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
		$this->set("title_for_layout","College Prospect Network - College Coach Listing");

		$user_id   = $this->Session->read('user_id');
		$user_type = $this->Session->read('user_type');

		$sport_id = 0;
		switch ($user_type){
			case 'Athlete':
				$athlete  = $this->Athlete->getById($user_id);
				$sport_id = $athlete['Athlete']['sport_id'];
				break;
			case 'CollegeCoach':
				$collegeCoach = $this->CollegeCoach->getById($user_id);
				$sport_id = $collegeCoach['CollegeCoach']['sport_id'];
				break;
			case 'HsAauCoach':
				$hsAauCoach = $this->HsAauCoach->getById($user_id);
				$sport_id = $hsAauCoach['HsAauCoach']['sport_id'];
				break;
		}

		$conditions = array();
		if($sport_id){
			$conditions[] = "CollegeCoach.sport_id = '$sport_id'";
		}

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('CollegeCoach'=>array("conditions"=>$conditions_str,"limit"=>20,"order"=>"firstname asc"));
		}
		else{
			$this->paginate = array('CollegeCoach'=>array("limit"=>20,"order"=>"firstname asc"));
		}

		$collegeCoaches = $this->paginate('CollegeCoach');
		$this->set("collegeCoaches",$collegeCoaches);
	}

	public function matches(){
		$this->set("title_for_layout","College Prospect Network - College Coach Listing");

		$user_id   = $this->Session->read('user_id');
		$user_type = $this->Session->read('user_type');

		$athlete  = $this->Athlete->getById($user_id);
		$sport_id = $athlete['Athlete']['sport_id'];

		$conditions = array();
		if($sport_id){
			$conditions[] = "CollegeCoach.sport_id = '$sport_id'";
		}

		if($conditions){
			$conditions_str = implode(" AND ",$conditions);
			$this->paginate = array('CollegeCoach'=>array("conditions"=>$conditions_str,"limit"=>20,"order"=>"firstname asc"));
		}
		else{
			$this->paginate = array('CollegeCoach'=>array("limit"=>20,"order"=>"firstname asc"));
		}

		$collegeCoaches = $this->paginate('CollegeCoach');
		$this->set("collegeCoaches",$collegeCoaches);
	}

	public function admin_addCollege(){
		if ($this->request->is('post')){
			// Check exits.
			$college = $this->College->findByName($this->request->data['name']);
			if (!empty($college)){
				$this->Session->setFlash('This College Already Exists!', 'flash_error');
			} else {
				$colleges = array();
				$colleges['College']['name'] = $this->request->data['name'];
				$colleges['College']['address_1'] = $this->request->data['address_1'];
				$colleges['College']['city'] = $this->request->data['city'];
				$colleges['College']['state'] = $this->request->data['state'];
				$colleges['College']['zip'] = $this->request->data['zip'];
				$colleges['College']['divison'] = $this->request->data['divison'];
				$colleges['College']['status'] = $this->request->data['status'];

				if ($this->College->save($colleges)){
					$this->Session->setFlash('College is Added Successfully', 'flash_success');
					$this->redirect(array('controller' => 'College', 'action' => 'listCollege'));
				} else {
					$this->Session->setFlash('Can not add this College', 'flash_error');
				}
			}
		}
	}

	public function admin_listOther(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
				
			if (!empty($searchName)){
				$conditions = array('Other.name LIKE ' => '%'.$searchName.'%');
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->loadModel('Other');
				
			$this->paginate = array('Other'=>array('conditions' => $conditions,
												   'limit' => $limit));
				
			$others = $this->paginate('Other');
			$this->set(compact('others', 'limit'));
		} else {
			$limit = 100;
			$this->loadModel('Other');
			$others = $this->paginate('Other');
			$this->set(compact('others', 'limit'));
		}
	}

	public function admin_updateOther($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$this->loadModel('Other');
				$this->Other->id = $id;
				if($this->Other->saveField('status', $this->request->data['status'])){
					$this->Session->setFlash('Other Updated Successfully!', 'flash_success');
					$this->redirect(array('controller' => 'College', 'action' => 'listOther'));
				} else {
					$this->Session->setFlash('Can not update this Other', 'flash_error');
				}
			} else {
				$this->loadModel('Other');
				$other = $this->Other->findById($id);
				$this->set('other', $other);
			}
		} else {
			$this->Session->setFlash('Do not exits this Other', 'flash_error');
		}
	}

	public function admin_deleteOther($id){
		if (isset($id)){
			$this->loadModel('Other');
			if($this->Other->delete($id)){
				$this->Session->setFlash('Other Deleted Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not delete this Other', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this Other', 'flash_error');
		}
		$this->redirect($this->referer());
	}

	public function admin_otherNameDetails($id){
		if (isset($id)){
			$this->loadModel('Other');
			$other = $this->Other->findById($id);
			$this->set('other', $other);
		} else {
			$this->Session->setFlash('Do not exits this Other', 'flash_error');
		}

	}

	public function admin_listCollege(){
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
				
			if (!empty($searchName)){
				$conditions = array('College.name LIKE ' => '%'.$searchName.'%',
									'College.status' => '1');				
			} else {
				$conditions = array('College.status' => '1');
			}
			$limit = 100;
			$this->paginate = array('College'=>array('conditions' => $conditions,
													 'limit' => $limit));
			$colleges = $this->paginate('College');
			$this->set(compact('colleges', 'limit'));
				
		} else {
			$limit = 100;
			$conditions = array('College.status' => '1');
			$this->paginate = array('College'=>array('conditions' => $conditions,
													 'limit' => $limit));
			$colleges = $this->paginate('College');
			$this->set(compact('colleges', 'limit'));
		}
	}

	public function admin_editCollege($id){
		if (isset($id)){
			if ($this->request->is('post')){
				$colleges = array();
				$colleges['College']['name'] 		= $this->request->data['name'];
				$colleges['College']['address_1'] 	= $this->request->data['address_1'];
				$colleges['College']['city'] 		= $this->request->data['city'];
				$colleges['College']['state'] 		= $this->request->data['state'];
				$colleges['College']['zip'] 		= $this->request->data['zip'];
				$colleges['College']['divison'] 	= $this->request->data['divison'];
				$colleges['College']['status'] 		= $this->request->data['status'];

				$this->College->id = $id;
				if ($this->College->save($colleges)){
					$this->Session->setFlash('College Updated Successfully!', 'flash_success');
					$this->redirect(array('controller' => 'College', 'action' => 'listCollege'));
				} else {
					$this->Session->setFlash('Can not update this College', 'flash_error');
				}
			} else {
				$college = $this->College->findById($id);
				$this->set('college', $college);
			}
		} else {
			$this->Session->setFlash('Do not exits this College', 'flash_error');
		}
	}

	public function admin_deleteCollege($id){
		if (isset($id)){
			if($this->College->delete($id)){
				$this->Session->setFlash('College Deleted Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not delete this College', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this College', 'flash_error');
		}
		$this->redirect($this->referer());
	}

	public function admin_collegeNameDetails($id){
		if (isset($id)){
			$colNameDet = $this->College->findById($id);
			$this->set('colNameDet', $colNameDet);
		} else {
			$this->Session->setFlash('Do not exits this College', 'flash_error');
		}
	}

	/**
	 * Delete selected College.
	 */
	public function admin_deleteSelectedCollege(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->College->delete($id)){
					$this->Session->setFlash('College Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}
			}
		}
		$this->redirect($this->referer());
	}

	public function admin_listCoach() {
		$this->loadModel('CollegeCoach');
		if ($this->request->is('post')){
			$searchName =  $this->request->data['searchname'];
				
			if (!empty($searchName)){
				$conditions = array('CollegeCoach.name LIKE ' => '%'.$searchName.'%');
			} else {
				$conditions = array();
			}
			$limit = 100;
			$this->paginate = array('CollegeCoach'=>array('conditions' => $conditions,
													 'limit' => $limit));
			$colCoachs = $this->paginate('CollegeCoach');
			$this->set(compact('colCoachs', 'limit'));
				
		} else {
			$limit = 100;
			$conditions = array();
			$this->paginate = array('CollegeCoach'=>array('conditions' => $conditions,
													 'limit' => $limit));
			$colCoachs = $this->paginate('CollegeCoach');
			$this->set(compact('colCoachs', 'limit'));
		}
	}

	public function admin_editCollegeCoach($id) {
		if (isset($id)){
			$this->loadModel('CollegeCoach');
			if ($this->request->is('post')){
				// Save post data.
				$this->CollegeCoach->id = $id;
				
				$scouting_report = $this->request->data['scouting_report'];
				if($scouting_report['tmp_name']){
					// get extension
					$exploded = explode('.', $scouting_report['name']);
					$extension = end($exploded);

					$path = 'files/' .md5(microtime()) . '.' . $extension;
					if(move_uploaded_file($scouting_report['tmp_name'],WWW_ROOT.$path)){
						$this->request->data['scouting_report'] = $path;
					}
				}
				else{
					unset($this->request->data['scouting_report']);
				}

				if ($this->CollegeCoach->save($this->request->data)){
					$this->Session->setFlash('College Coach Updated Successfully!', 'flash_success');
					$this->redirect(array('controller' => 'College', 'action' => 'listCoach'));
				} else {
					$this->Session->setFlash('Can not update this College Coach', 'flash_error');
				}
			} else {
				$collCoach = $this->CollegeCoach->findById($id);
					
				// Get College.
				$colleges = $this->College->find('all', array('conditions' => array('College.status' => '1'),
															  'fields' => array('College.id', 'College.name'),
															  'order' => array('College.id')));
				$collegeList = array();
				foreach ($colleges as $college){
					$collegeList[$college['College']['id']] = $college['College']['name'];
				}

				// Get sport list.
				$this->loadModel('Sport');
				$sports = $this->Sport->find('all', array('fields' => array('Sport.id', 'Sport.name'),
															 'order' => array('Sport.id')));						
				$sportList = array();
				foreach ($sports as $sport){
					$sportList[$sport['Sport']['name']] = $sport['Sport']['name'];
				}

				$this->set(compact('collCoach', 'collegeList', 'sportList'));
			}
		} else {
			$this->Session->setFlash('Do not exits this College', 'flash_error');
		}
	}

	public function admin_collegeAddressInfo($college_id){
		if ($college_id != 'other'){
			$collegeAddressInfo = $this->College->find('first', array('conditions' => array('College.status' => '1', 'College.id' => $college_id),
																	  'fields' => array('College.id', 'College.name', 'College.address_1', 'College.city', 'College.state', 'College.zip'),
																	  'order' => array('College.id') 	
			));
		} else {
			$otherInfo = $this->Other->find('first', array('conditions' => array('Other.user_id' => $college_id),
														   'fields' => array('Other.id', 'Other.name'),
			                                               'order' => array('Other.id')
			));
			$collegeAddressInfo = $this->College->find('first', array('conditions' => array('College.name' => $otherInfo['Other']['name']),
																	  'fields' => array('College.id', 'College.name', 'College.address_1', 'College.city', 'College.state', 'College.zip'),
			                                                          'order' => array('College.id')
			));
		}
		echo json_encode($collegeAddressInfo);
		exit();
	}

	public function admin_deleteCollegeCoach($id) {
		if (isset($id)){
			if($this->CollegeCoach->delete($id)){
				$this->Session->setFlash('College Coach Deleted Successfully!', 'flash_success');
			} else {
				$this->Session->setFlash('Can not delete this College Coach', 'flash_error');
			}
		} else {
			$this->Session->setFlash('Do not exits this College Coach', 'flash_error');
		}
		$this->redirect($this->referer());
	}

	public function admin_collegeCoachDetails($id){
		if (isset($id)){
			$this->loadModel('CollegeCoach');
			$collegeCoach = $this->CollegeCoach->findById($id);
			$this->set('collegeCoach', $collegeCoach);
		} else {
			$this->Session->setFlash('Do not exits this College Coach', 'flash_error');
		}

	}

	/**
	 * Delete selected College Coach.
	 */
	public function admin_deleteSelectedCollegeCoach(){
		if(isset($this->request->data['check_delete'])) {
			foreach ($this->request->data['check_delete'] as $id){
				if ($this->CollegeCoach->delete($id)){
					$this->Session->setFlash('College Coach Deleted Successfully!', 'flash_success');
				} else {
					$this->Session->setFlash('Delete error.', 'flash_error');
				}
			}
		}
		$this->redirect($this->referer());
	}
	
	public function admin_viewCollegeCoach($id){
		if (isset($id)){
			$this->loadModel('CollegeCoach');
			$collegeCoach = $this->CollegeCoach->findById($id);
			if(isset($collegeCoach)){
				$this->Session->write("name",$collegeCoach['CollegeCoach']['firstname']);
				$this->Session->write("username",$collegeCoach['CollegeCoach']['username']);
				$this->Session->write("user_id",$collegeCoach['CollegeCoach']['id']);
				$this->Session->write("user_type","college");			
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