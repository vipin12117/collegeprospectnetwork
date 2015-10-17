<?php

class VideoController extends AppController{

	public $name = 'Video';

	public $uses = array("Athlete","AthleteVideo");

	public function beforeFilter(){
		parent::beforeFilter();
		$this->checkSession();
	}

	public function index(){
		$user_id = $this->Session->read('user_id');

		$this->paginate = array('AthleteVideo'=>array("conditions"=>"AthleteVideo.athlete_id = '$user_id'","limit"=>1));
		$AthleteVideos  = $this->paginate('AthleteVideo');
		$this->set("AthleteVideos",$AthleteVideos);
	}

	public function addTape(){
		$user_id = $this->Session->read('user_id');

		if(isset($this->request->data['AthleteVideo']['video_path']['tmp_name'])){
			$type = explode(".",$this->request->data['AthleteVideo']['video_path']['name']);
			$type = end($type);

			if(!in_array($type,array("mov","flv","avi","mp4","wmv","mpeg","mpg"))){
				$this->Session->setFlash("File format is not supported");
			}
			elseif($this->request->data['AthleteVideo']['video_path']['size'] > (200000*1024)){
				$this->Session->setFlash("File size is limited to 200 MB");
			}
			else{
				$video_path = $this->AthleteVideo->uniqueCode(20).".$type";

				if(move_uploaded_file($this->request->data['AthleteVideo']['video_path']['tmp_name'],WWW_ROOT."/video/$video_path")){
					$this->request->data['AthleteVideo']['video_type'] = $this->request->data['AthleteVideo']['video_type'];
					$this->request->data['AthleteVideo']['video_path'] = $video_path;
					$this->request->data['AthleteVideo']['athlete_id'] = $user_id;
					$this->request->data['AthleteVideo']['added_date'] = date('Y-m-d H:i:s');
					$this->AthleteVideo->save($this->request->data);

					$this->Session->setFlash("Video is uploaded successfully.");
					$this->redirect(array("controller"=>"Video","action"=>"index"));
					exit;
				}
				else{
					$this->Session->setFlash("File is not uploaded, Please try again");
				}
			}
		}

		$this->render("/Video/addTape");
	}

	public function editTape($id = false){
		$user_id = $this->Session->read('user_id');

		if($user_id and $id){
			if(isset($this->request->data['AthleteVideo'])){
				$error = false;

				if(isset($this->request->data['AthleteVideo']['video_path']['tmp_name']) && $this->request->data['AthleteVideo']['video_path']['tmp_name']){
					$type = explode(".",$this->request->data['AthleteVideo']['video_path']['name']);
					$type = end($type);

					if(!in_array($type,array("mov","flv","avi","mp4","wmv","mpeg","mpg"))){
						$this->Session->setFlash("File format is not supported");
						$error = true;
					}
					elseif($this->request->data['AthleteVideo']['video_path']['size'] > (200000*1024)){
						$this->Session->setFlash("File size is limited to 200 MB");
						$error = true;
					}
					else{
						$video_path = $this->AthleteVideo->uniqueCode(20).".$type";

						if(move_uploaded_file($this->request->data['AthleteVideo']['video_path']['tmp_name'],WWW_ROOT."/video/$video_path")){
							$this->request->data['AthleteVideo']['video_type'] = $this->request->data['AthleteVideo']['video_type'];
							$this->request->data['AthleteVideo']['video_path'] = $video_path;
						}
						else{
							$this->Session->setFlash("File is not uploaded, Please try again");
							$error = true;
						}
					}
				}
				else{
					unset($this->request->data['AthleteVideo']['video_path']);
				}

				if($error == false){
					$this->Session->setFlash("Video is updated successfully.");
				}
				else{
					unset($this->request->data['AthleteVideo']['video_path']);
				}

				$this->AthleteVideo->id = $id;
				$this->AthleteVideo->save($this->request->data);

				$this->redirect(array("controller"=>"Video","action"=>"index"));
				exit;
			}
			else{
				$this->request->data = $this->AthleteVideo->find("first",array("conditions"=>array("AthleteVideo.athlete_id"=>$user_id,"AthleteVideo.id"=>$id)));
			}
		}

		$this->render("/Video/editTape");
	}

	public function deleteTape($id = false){
		$user_id = $this->Session->read('user_id');
		if($user_id and $id){
			$this->AthleteVideo->deleteAll(array("AthleteVideo.athlete_id"=>$user_id,"AthleteVideo.id"=>$id));
			$this->Session->setFlash("Video is deleted successfully.");
		}

		$this->redirect(array("controller"=>"Video","action"=>"index"));
		exit;
	}

	public function trimTape($id = false){
		$user_id = $this->Session->read('user_id');

		$user_id = $this->Session->read('user_id');
		if($user_id and $id){
			$video_details = $this->AthleteVideo->read(null,$id);
				
			App::import("Lib","FlvVideoTrimmer");
			$FlvVideoTrimmer = new FlvVideoTrimmer();
			$response = $FlvVideoTrimmer->convert_video($video_details['AthleteVideo']);
			
			if($response){
				unset($video_details['AthleteVideo']['id']);
				$video_details['AthleteVideo']['video_type'] = 'Highlight Video';
				
				$this->AthleteVideo->create();
				$this->AthleteVideo->save($video_details);
			}
			
			$this->Session->setFlash("Video is trimmed successfully.");
		}
		else{
			$this->Session->setFlash("Please try again.");
		}

		$this->redirect(array("controller"=>"Video","action"=>"index"));
		exit;
	}

	public function request($athlete_id = false){
		$this->layout = 'popup';

		if(!$athlete_id){
			$this->set("message","Athlete is not found. Please follow the correct link.");
		}

		if(isset($this->request->data['Mail'])){
			$this->request->data['Mail']['sender'] = $this->Session->read('username');
			$this->request->data['Mail']['usertype_from'] = $this->Session->read('user_type');

			$this->loadModel('Mail');
			$this->Mail->save($this->request->data['Mail']);
			$this->set("message","Message is sent successfully");
		}
		else{
			$this->loadModel('Athlete');
			$userDetail = $this->Athlete->getById($athlete_id);
			$this->set("userDetail",$userDetail['Athlete']);

			$user_id = $this->Session->read('user_id');
			$this->loadModel('CollegeCoach');
			$coachDetail = $this->CollegeCoach->getById($user_id);
			$this->set("CollegeCoach",$coachDetail['CollegeCoach']);

			$this->loadModel('College');
			$College = $this->College->getById($coachDetail['CollegeCoach']['college_id']);
			$this->set("College",$College['College']);

			$this->set("athlete_id",$athlete_id);
			$this->set("receiver","college");
			$this->set("usertype_to","athlete");
		}
	}
}