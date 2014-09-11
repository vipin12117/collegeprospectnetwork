<?php
class flv {	public $extension_arr = array("avi","mp4","mpeg","mpg","mov","wmv","flv");
	public $APP_ROOT  = "";
	public $FFLV_PATH      = "";
	public $newname        = "";
	public $output_file    = "";
	public function check_video() {		$filename = $_FILES['videoFile']['name'];		$pathInfo = pathinfo($filename);		if(in_array($pathInfo['extension'],$this->extension_arr)) {			return true;		}		else {			return false;		}	}
	public function convert_video($file_arr) {		$filename    = $file_arr['name'];		$tmpname     = $file_arr['tmp_name'];		$filesize    = $file_arr['size'];		$file_error  = $file_arr['error'];		$val         =  ini_get('upload_max_filesize');		$pathInfo    = pathinfo($filename);
		$allowedsize = intval($val);		$last = strtolower($val{strlen($val)-1});		switch($last) {			case 'g':				$val *= 1024;			case 'm':				$val *= 1024;			case 'k':				$val *= 1024;		}
		$newName = $this->newname.".".$pathInfo['extension'];		if(copy($tmpname,$this->APP_ROOT.$newName)) {
			$str = exec("file -bi $this->APP_ROOT$newName");
			exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -deinterlace -ar 44100 -r 25 -qmin 4 -qmax 9 ".$this->output_file.$this->newname.".flv");
			exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -vframes 1 -ss 00:00:05 ".$this->output_file.$this->newname.".jpg");
			unlink($this->APP_ROOT.$newName);
			return($this->newname.".flv");		}		else {
			return '';
		}	}}?>