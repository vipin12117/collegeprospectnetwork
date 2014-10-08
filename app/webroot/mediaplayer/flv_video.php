<?php

if($_POST['submit']=='submit')
{
	//echo "hello";
$uploadFile = "../video/" . $_FILES['video']['name'];  
   

//   print_r($_FILES);  
            include_once 'script.php';
			$flvobj = new flv();
			$flvobj->FFLV_PATH = '/usr/bin/';
			$flvobj->APP_ROOT = '../video/';
			$flvobj->output_file = '../video/';
			$flvobj->newname = time();
		$flvobj->convert_video($_FILES['video']);
}

			?>
			
			<form name="trp" enctype="multipart/form-data" method="POST">
			<input type="file" name="video">
			<input type="submit" value="submit" name="submit">
			</form>