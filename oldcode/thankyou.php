<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
session_start();
if(($_SESSION['mode']=="")or($_SESSION['FRONTEND_USER']==""))
{
	header("Location:index.php");
}
$func = new COMMONFUNC;
$db = new DB;
$flag=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>College Prospect Network</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!--<script language="Javascript" src="javascript/functions.js"></script>-->
</head>
<body>

<?php include('header.php'); ?>
<!--header link starts from here -->
   
    <!--Header ends from here -->
    <!--middle panel starts from here -->
<!--content panel starts from here -->
<div class="container">
  <div class="innerWraper">
    <div class="middle-bg">
    <div class="cantener">
  <div class="register-main">

  <div class="registerPage">
  <h1>Transaction have been completed thanks for using this site</h1>
                            	<p></p>   
                            </div>
  </div>
  
  </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
