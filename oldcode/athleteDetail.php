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
<title>Athelete Detail</title>
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
  $query1 =" Select * from ".TBL_ATHELETE_REGISTER. " where fldID ='".$_REQUEST['athleteid']."'";
	

$db->query($query1);
$db->next_record();
$fldId=$db->f('fldId'); 
$Firstname=$db->f('fldFirstname');
$Lastname=$db->f('fldLastname'); 
$Age=$db->f('fldAge');
$Height=$db->f('fldHeight');
$Weight=$db->f('fldWeight');
$Description=$db->f('fldDescription');
$School=$db->f('fldSchool');
$Sport=$db->f('fldSport');
$Coach=$db->f('fldCoach');
$Image=$db->f('fldImage');

$query2 =" Select * from ".TBL_HS_AAU_TEAM. " where fldId =".$School;
	

	$db->query($query2);
	$db->next_record();
 $School_id=$db->f('fldId'); 
$fldSchoolname=$db->f('fldSchoolname');


?>
 <p><h1>Athelete Information</h1></p>
                      <div class="registerPage">
<!--<p>-->
                                	
                                  <!--  <span><img src="<?php //echo SITE_URL; ?>/logo/<?php //echo $fldSchoolLogo;?>"></span>-->
                               <!-- </p>-->
  
<p>
                                	<label>First Name :</label>
                                    <span><?php echo $Firstname; ?><div style="width: 200px;margin-left:350px;margin-top:-10px">  <img height="144" width="144" src="admin/logo/<?php echo $Image; ?>"></div></span>
                                </p>
                                
                                <p>

 	<label>Last Name :</label>
                                    <span><?php echo $Lastname; ?></span>
                                </p>
                                <p> 
	<label>Age :</label>
                                    <span><?php echo $Age; ?></span>
                                </p>
                                 <p> 
	<label>Height :</label>
                                    <span><?php echo $Height; ?></span>
                                </p>
                                   <p> 
	<label>Weight :</label>
                                    <span><?php echo $Weight; ?></span>
                                </p> 
                                
 <p> 
	<label>Description :</label>
                                    <span><?php echo $Description; ?></span>
                                </p>
                                 <p> 
	<label>School :</label>
                                    <span><?php echo $fldSchoolname; ?></span>
                                </p>

                                <?php  
                               	 $query_sport1 =" Select * from ".TBL_SPORTS. " where fldId =".$Sport;
	

	$db->query($query_sport1);
	$db->next_record();
	?><p><label>Sport :

                              </label>
                              <span>
                              <?php echo $db->f('fldSportsname');
	

                                	?>
                              </span>
                              
                              </p>
                              <?php
                               $query_coach1 =" Select * from ".TBL_HS_AAU_COACH. " where fldId =".$Coach;
	

	$db->query($query_coach1);
	$db->next_record();
                              ?>
                                <p> 
	<label>Coach Name :</label>
                                    <span><?php echo $db->f('fldName'); ?></span>
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
                                                      