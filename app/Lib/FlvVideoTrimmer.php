<?php
class FlvVideoTrimmer {
	public $extension_arr = array("avi","mp4","mpeg","mpg","mov","wmv","flv");
	public $APP_ROOT        = "";
	public $FFLV_PATH      = "";
	public $newname        = "";
	public $output_file    = "";
	public $TRIM_START      = "";
	public $TRIM_END      = "";
	public function check_video() {
		if(in_array($pathInfo['extension'],$this->extension_arr)) {
		exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$existingFilename -vcodec copy -acodec copy -ss $trimStartTime -t $trimEndTime ".$this->output_file.$this->newname.".flv");
		exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -vframes 1 -ss 00:00:05 ".$this->output_file.$this->newname.".jpg");
		return($this->newname.".flv");