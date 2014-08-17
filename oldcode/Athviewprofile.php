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
$error_msg= '';


        $fldUsername = $_SESSION['FRONTEND_USER'];

		$query =" Select * from ".TBL_ATHELETE_REGISTER. " where fldUsername = '$fldUsername' ";

		$db->query($query);
		$db->next_record();		  
        
        $fldFirstname              = $func->output_fun($db->f('fldFirstname'));
		$fldLastname               = $func->output_fun($db->f('fldLastname'));
		$fldAge                    = $func->output_fun($db->f('fldAge'));
		$fldHeight                 = $func->output_fun($db->f('fldHeight'));
		$fldWeight                 = $func->output_fun($db->f('fldWeight'));
		$fldDescription            = $func->output_fun($db->f('fldDescription'));
		$fldEmail                  = $func->output_fun($db->f('fldEmail'));
		$fldUsername               = $func->output_fun($db->f('fldUsername'));
		$fldPassword               = $func->output_fun($db->f('fldPassword'));
        $fldImage                  = $func->output_fun($db->f('fldImage'));


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
<h1>Athlete Profile</h1>

  <form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
 
 
    <div class="registerPage">
  
 
                      <div class="registerPage">
                      
                               
                                
                                <p>
                                    <label>Image;</label>
                                    <span><img src="athimages/<?=$fldImage?>" height="200px;" width="170px;"></span>
                                </p>
                      
                                <p>
                                	<label>First Name:</label>
                                    <span style="font-size:14px; font-weight: bold; color: #646464;"><?=ucwords($fldFirstname);?></span>
                                </p>
                                
                                <p>
                                	<label>Last Name :</label>
                                    <span style="font-size:14px; font-weight: bold; color: #646464;"><?=ucwords($fldLastname);?></span>
                                </p>
                                
                                <p>
                                	<label>Email:</label>
                                    <span style="font-size:14px; font-weight: bold; color: #646464;"><?=$fldEmail?></span>
                                </p>
                                
                                <p>
                                	<label>Description:</label>
                                    <span style="font-size:14px; font-weight: bold; color: #646464;"><?=$fldDescription?></span>
                                </p>
                                
                                <p>
                                	<label>Height:</label>
                                    <span style="font-size:14px; font-weight: bold; color: #646464;"><?=$fldHeight?></span>
                                </p>
                                
                                
                                <p>
                                	<label>Weight:</label>
                                    <span style="font-size:14px; font-weight: bold; color: #646464;"><?=$fldWeight?></span>
                                </p>
                                
                                                             
                                <p>
                                	<label>Age:</label>
                                    <span style="font-size:14px; font-weight: bold; color: #646464;"><?=$fldAge?></span>
                                </p>
                                
                                
                                
                                
                                <p>
                                	<label>&nbsp;</label>
                                	<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">
                                </p>
                                
                                
  
                             </div>
                                                    
                                                       	
                      <div class="registerPage">
                      </div>
                                                                  
                            	
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