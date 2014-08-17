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

        function convert_video($file_arr) {
            
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
          
                
                $newName = $this->newname.".".$pathInfo['extension'];
                
                if(copy($tmpname,$this->APP_ROOT.$newName)) {
                    $str = exec("file -bi $this->APP_ROOT$newName");    
                    
     
                    #############################################
                    ## Encode Video
                    #############################################                  
                    //First we are convertion the allowable video into the flv video format
                    //exec(the/path/to/ffmpeg.exe.”ffmpeg -i “.$directory_path_full.” “.$directory_path.$file_name.”.flv”);    
                       
                     //Example - http://www.johnrockefeller.net/using-ffmpeg-to-convert-mpg-or-mov-to-flv/
                    //exec("ffmpeg -i $file -deinterlace -ar 44100 -r 25 -qmin 3 -qmax 6 $new_filename");
                    
                    #orginal
                    //exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -ab 56k -ar 22050 -b 300k -r 15 -s -sameq ".$this->output_file.$this->newname.".flv");
                    //exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -ab 56k -ar 22050 -b 300k -r 15 -s 480x360 ".$this->output_file.$this->newname.".flv");
                  
                     #high quality - same dimensions
                     //exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -deinterlace -ar 44100 -r 25 -qmin 3 -qmax 6 ".$this->output_file.$this->newname.".flv");
                     
                     #optimized - same dimensions
                     exec($this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -deinterlace -ar 44100 -r 25 -qmin 4 -qmax 9 ".$this->output_file.$this->newname.".flv");
                                        
                    
                    #############################################
                    ## Create Thumbnail
                    #############################################         
                    //Example - ffmpeg  -itsoffset -4  -i test.avi -vcodec mjpeg -vframes 1 -an -f rawvideo -s 320x240 test.jpg          
                      
                    #original
                    //exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -t 0.01 -ss 3 -vframes 3 -f mjpeg -s 320x240 ".$this->output_file.$this->newname.".jpg");  
                    exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -vframes 1 -ss 00:00:05 ".$this->output_file.$this->newname.".jpg");  
                    
                    #optimized
                    //exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -t 0.01 -ss 00:01:00 -vframes 1 -f mjpeg -s 320x240 ".$this->output_file.$this->newname.".jpg");      
                    
                    //examples   
                    //ffmpeg -i n.wmv -ss 00:00:20 -t 00:00:1 -s 320×240 -r 1 -f singlejpeg myframe.jpg
                    //exec('ffmpeg  -i '.$uploadfile.' -f mjpeg -vframes 1 -s 150x150 -an '.$new_image_path.'');
                    //ffmpeg -i video.flv -y -f image2 -ss 8 -sameq -t 0.001 -s 320*240 /image_dir/screenshot.jpg
                    //ffmpeg -i video.flv -vcodec png -vframes 1 -an -f rawvideo -s 320×240 output_img_name
                    
                    #test
                    //exec( $this->FFLV_PATH."ffmpeg -i $this->APP_ROOT$newName -f mjpeg -vframes 1 -s 320x240 -an ".$this->output_file.$this->newname.".jpg");          
                    
                    //we are watermarking the videos on flv converted videos.You can comment the code if you do not want to watermark the FLV video.            
                    
                        unlink($this->APP_ROOT.$newName);
                        return($this->newname.".flv");
                }
                else {
                	return '';
                }
                
                    
        }
    }
?>