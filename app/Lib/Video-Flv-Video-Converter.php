<?php
class flv {
	public $APP_ROOT  = "";
	public $FFLV_PATH      = "";
	public $newname        = "";
	public $output_file    = "";
	public function check_video() {
	public function convert_video($file_arr) {
		$allowedsize = intval($val);
		$newName = $this->newname.".".$pathInfo['extension'];
			$str = exec("file -bi $this->APP_ROOT$newName");
			exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -deinterlace -ar 44100 -r 25 -qmin 4 -qmax 9 ".$this->output_file.$this->newname.".flv");
			exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -vframes 1 -ss 00:00:05 ".$this->output_file.$this->newname.".jpg");
			unlink($this->APP_ROOT.$newName);
			return($this->newname.".flv");
			return '';
		}