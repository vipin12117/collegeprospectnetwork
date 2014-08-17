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

<?php
   $query =" Select * from ".TBL_SPORTCALENDER. " where fldID ='".$_REQUEST['fldId']."'";
  
	

	$db->query($query);
	$db->next_record();

?>
 <p><h1>Sports Calendar</h1></p>
                      <div class="registerPage">
<p>
                                	
                                  <!--  <span><img src="<?php //echo SITE_URL; ?>/logo/<?php //echo $fldSchoolLogo;?>"></span>-->
                                </p>
  
<p>
                                	<label>Team :</label>
                                    <span><?php echo $db->f('fldTeam'); ?></span>
                                </p>
                                
                                <p>

 	<label>Date & time :</label>
                                    <span><?php echo $db->f('fldDate')."&nbsp;".$db->f('fldTime'); ?></span>
                                </p>
                                <p> 
	<label>Location :</label>
                                    <span><?php  echo $db->f('fldLocation'); ?></span>
                                </p> 
                                <p> 
	<label>School :</label>
                                    <span><?php echo $db->f('fldSchool'); ?></span>
                                </p>
                             
               <p> 
	<label>Sport :</label>
                                    <span><?php echo $db->f('fldSport'); ?></span>
                                </p>
                                 <p> 
	<label>&nbsp;</label>
                                    <span><INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)"></span>
                                </p>
                                                       
                                                       
</div>
  </div>
  
  </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
                                                      