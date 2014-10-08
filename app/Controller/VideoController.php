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

		$this->paginate = array('AthleteVideo'=>array("conditions"=>"AthleteVideo.athlete_id = '$user_id'"));
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
					$this->request->data['AthleteVideo']['video_type'] = $this->request->data['AthleteVideo']['video_path']['type'];
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
							$this->request->data['AthleteVideo']['video_type'] = $this->request->data['AthleteVideo']['video_path']['type'];
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

	}
}