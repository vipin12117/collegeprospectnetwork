<?php
class flv {
	var $extension_arr = array("avi","mp4","mpeg","mpg","mov","wmv","flv");
	var $APP_ROOT        = "";
	var $FFLV_PATH      = "";
	var $newname        = "";
	var $output_file    = "";
	var $TRIM_START      = "";
	var $TRIM_END      = "";
	function check_video() {
		if(in_array($pathInfo['extension'],$this->extension_arr)) {
		exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$existingFilename -vcodec copy -acodec copy -ss $trimStartTime -t $trimEndTime ".$this->output_file.$this->newname.".flv");
		exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -vframes 1 -ss 00:00:05 ".$this->output_file.$this->newname.".jpg");
		return($this->newname.".flv");