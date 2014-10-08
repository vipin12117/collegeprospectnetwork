<?php
	session_start();
	error_reporting(E_WARNING);
	class flv {
		var $extension_arr = array("avi","mp4","mpeg","mpg","mov","wmv","flv");
		
		######################################################
		# extension_arr contains the file extensions allowed
		# during upload of video files		
		######################################################		
		
		var $APP_ROOT        = "";   
		
		######################################################
		# physical path where uploaded videos store
		# during upload of video files		
		######################################################
		
		var $FFLV_PATH		= "";
		var $newname		= "";
		var $output_file	= "";
		
		function __construct() {
			//$this->newname = date("YmdHis").rand();					
		}		

		######################################################
		# check_video() will check wheather uploaded file is
		# video file or not
		# during upload of video files		
		######################################################

		function check_video() {
			$filename = $_FILES['videoFile']['name'];
			$pathInfo = pathinfo($filename);
			if(in_array($pathInfo['extension'],$this->extension_arr)) {
				return true;
			}
			else {
				return false;
			}
		}

		######################################################
		# convert_video() will convert uploaded 
		# video file to flv file.
		# during upload of video files		
		######################################################

		function convert_video($file_arr) {
			/*echo "<pre>";
			print_r($file_arr);
			die();*/
			$filename    = $file_arr['name'];
			$tmpname     = $file_arr['tmp_name'];
			$filesize    = $file_arr['size'];
			$file_error  = $file_arr['error'];
			$val         =  ini_get('upload_max_filesize');
			$pathInfo    = pathinfo($filename);
			
			$allowedsize = intval($val);
			$last = strtolower($val{strlen($val)-1});
			
			
		    switch($last) {
		        // The 'G' modifier is available since PHP 5.1.0
		        case 'g':
		            $val *= 1024;
		        case 'm':
		            $val *= 1024;
		        case 'k':
		            $val *= 1024;
		    }
		    /*if ($filesize<>'0'){*/
			/*if($filesize <= $val) {*/
				
				$newName = $this->newname.".".$pathInfo['extension'];
				
				if(copy($tmpname,$this->APP_ROOT.$newName)) {
					$str = exec("file -bi $this->APP_ROOT$newName");	
					
									
					// avi, wmv, mov
					//First we are convertion the allowable video into the flv video format
					
	           //exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -ab 56k -ar 22050 -b 300k -r 15 -s 480x360 ".$this->output_file.$this->newname.".flv");
	                exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -ab 56k -b 300k -ar 22050  -r 15 -s 480x360 ".$this->output_file.$this->newname.".flv");
	                
	                
	               //exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -acodec libfaac -ab 128k -ac 2 -vcodec libx264 -vpre hq -crf 22 -threads 0 ".$this->output_file.$this->newname.".flv");
	                
	                
	  				//exec($this->FFLV_PATH."ffmpeg -y -i $this->APP_ROOT$newName -pass 1 -vcodec libx264 -vpre fastfirstpass -b 512k -bt 512k -threads 0 -f mp4 -an ".$this->output_file.$this->newname.".flv");

	  				//exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -pass 2 -acodec libfaac -ab 128k -ac 2 -vcodec libx264 -vpre hq -b 512k -bt 512k -threads 0 -f ".$this->output_file.$this->newname.".flv");
	                
	                	
	              	//exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -deinterlace -y -f flv -acodec mp3 -ab 56k -ar 22050 -b 300k -r 15 -s 480x360 ".$this->output_file.$this->newname.".flv");	
					
	              	//From this script we are cropping the image for display on the page.		
					exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -t 0.01 -ss 3 -vframes 3 -f mjpeg -s 320x240 ".$this->output_file.$this->newname.".jpg");					
					
				 	//we are watermarking the videos on flv converted videos.You can comment the code if you do not want to watermark the FLV video.			
					//exec($this->FFLV_PATH."ffmpeg -i  ".$this->APP_ROOT.$newName."  -y -f flv -sameq -ar 44100 -s 320x240 -vhook '/usr/lib/vhook/watermark.so -m 1 -t 222222 -f video-watermark.gif' ".$this->output_file.$this->newname.".flv");
					unlink($this->APP_ROOT.$newName);
				}
				
		    		
		}
	}
?>