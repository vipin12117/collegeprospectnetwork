<?php
class FlvVideoTrimmer {
	public $extension_arr = array("avi","mp4","mpeg","mpg","mov","wmv","flv");
	public $FFLV_PATH      = "";
	public $TRIM_START     = "00:00:00";
	public $TRIM_END       = "00:00:30";
	public function check_video() {		$filename = $_FILES['videoFile']['name'];		$pathInfo = pathinfo($filename);
		if(in_array($pathInfo['extension'],$this->extension_arr)) {			return true;		}		else {			return false;		}	}	public function convert_video($video_details) {		$video_path  = $video_details['video_path'];		$video_parts = explode(".", $video_path);		$extension   = end($video_parts);				$existingFilename = ROOT."/webroot/video/".$video_path;		$newName = ROOT."/webroot/video_highlights/".$video_path;		$newJpg  = ROOT."/webroot/video/".$video_parts[0].".jpg";				$trimStartTime = $this->TRIM_START;		$trimEndTime   = $this->TRIM_END;				exec("ffmpeg -i $existingFilename -vcodec copy -acodec copy -ss $trimStartTime -t $trimEndTime ".$newName);		exec("ffmpeg -i $newName -vframes 1 -ss 00:00:05 ".$newJpg);
		return true;	}}?>