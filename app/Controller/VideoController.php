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

		if($this->request->data['Video']['video_path']['tmp_name']){
			$type = explode(".",$this->request->data['Video']['video_path']['name']);
			$type = end($type);

			if(!in_array($type,array("mov","flv","avi","mp4","wmv","mpeg","mpg"))){
				$this->Session->setFlash("File format is not supported");
				$this->redirect(array("controller"=>"Video","action"=>"addTape"));
				exit;
			}
			elseif($this->request->data['Video']['video_path']['size'] > (200000*1024)){
				$this->Session->setFlash("File size is limited to 200 MB");
				$this->redirect(array("controller"=>"Video","action"=>"addTape"));
				exit;
			}
			else{
				$video_path = $this->Video->uniqueCode(20).".$type";

				if(move_uploaded_file($this->request->data['Video']['video_path']['tmp_name'],WWW_ROOT."/files/$video_path")){
					$this->request->data['Video']['athlete_id'] = $user_id;
					$this->request->data['Video']['added_date'] = date('Y-m-d H:i:s');
					$this->Video->save($this->request->data['Video']);

					$this->Session->setFlash("Video is uploaded successfully.");
					$this->redirect(array("controller"=>"Video","action"=>"index"));
					exit;
				}
				else{
					$this->Session->setFlash("File is not uploaded, Please try again");
					$this->redirect(array("controller"=>"Video","action"=>"addTape"));
					exit;
				}
			}
		}
		else{

			$this->render("/Video/addTape");
		}
	}
}