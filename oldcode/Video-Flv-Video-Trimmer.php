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
        
        var $FFLV_PATH      = "";
        var $newname        = "";
        var $output_file    = "";
        var $TRIM_START      = "";
        var $TRIM_END      = "";
        
        function __construct() {
                    
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

        function convert_video($existingFilename) {
            
                //Use Existing Video File
                $newName = $this->newname.".flv";
                $trimStartTime = $this->TRIM_START;
                $trimEndTime = $this->TRIM_END;
                
                //if(copy($tmpname,$this->APP_ROOT.$newName)) {
                    //$str = exec("file -bi $this->APP_ROOT$newName");    
                    
     
                    #############################################
                    ## Encode Video
                    #############################################    
                    ////NORMAL -  #exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -deinterlace -ar 44100 -r 25 -qmin 4 -qmax 9 ".$this->output_file.$this->newname.".flv");
                     /////SAMPLE - trim video --------  ffmpeg -i video.avi -vcodec copy -acodec copy -ss 00:00:00 -t 00:00:04 trimmed_video.avi////       
                       
                     exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$existingFilename -vcodec copy -acodec copy -ss $trimStartTime -t $trimEndTime ".$this->output_file.$this->newname.".flv");
                                        
                    
                    #############################################
                    ## Create Thumbnail
                    #############################################        

                    exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -vframes 1 -ss 00:00:05 ".$this->output_file.$this->newname.".jpg");  
                    

                   // unlink($this->APP_ROOT.$newName);
                    return($this->newname.".flv");
                // }
                // else {
                	// return '';
                // }
                
                    
        }
    }
?>