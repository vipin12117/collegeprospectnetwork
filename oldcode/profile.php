<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
session_start();
if(($_SESSION['mode']=="")or($_SESSION['FRONTEND_USER']==""))
{
	header("Location:index.php");
}
//for paging
$func = new COMMONFUNC;
$db = new DB;
$flag=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Account</title>
<META NAME="Keywords" CONTENT="My Account">
  <META NAME="Description" CONTENT="My Account">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>
</head>
<body>
<?php
include('header.php');
?>
    <!--middle panel starts from here -->
<!--content panel starts from here -->
<div class="container">
  <div class="innerWraper">
    <div class="middle-bg">
    <div class="cantener">
  <div class="register-main">
     
 
 
 <!--<div style="float:right;"> <font color="red">*</font> Fields are Mandatory.</div>-->
                      <div class="registerPage">
  <?php if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='school')) { ?>
  
<?php   include("schoolprofile.php");
  }
                                                       if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='athlete'))
                                                       {
                                                       	?>
                                                       	<p><h1>Athelete Profile</h1></p>
                      <div class="registerPage">
  
    <p>
  Comming soon</p>
  
                         	 
                                                       </div>
                                                       	<?php
                                                       	
                                                       }
                                                       
          if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='collage'))
                                                       {
                         include("collageprofile.php");        
          	
                                                       }
                                                       
                                                       ?>
                            	
                            </div>
                         
                            
  </div>
  
  </div>
    </div>
  </div>
</div>



<?php 
include('footer.php');

?>
</body>
</html>