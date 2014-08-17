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
$query =" Select * from ".TBL_HS_AAU_TEAM. " where fldUserName ='".$_SESSION['FRONTEND_USER']."'";
	

	$db->query($query);
	$db->next_record();
$School_id=$db->f('fldId'); 
$fldSchoolname=$db->f('fldSchoolname');
$fldSchoolCity=$db->f('fldCity'); 
$fldSchoolState=$db->f('fldState');
$fldSchoolZipcode=$db->f('fldZipcode');
$fldSchoolLogo=$db->f('fldLogo');
$school_sport_coach=$func->school_sport_coach($School_id);

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
     

 
                      <div class="registerPage">
<p><h1>High School/AAU Profile</h1></p>
                      <p>
                                	
                                  <!--  <span><img src="<?php //echo SITE_URL; ?>/logo/<?php //echo $fldSchoolLogo;?>"></span>-->
                                </p>
  
<p>
                                	<label>Name :</label>
                                    <span><?php echo $fldSchoolname; ?></span>
                                </p>
                                <p>
                                	<label>Address :</label>
                                    <span><?php echo $fldSchoolname; ?></span>
                                </p> 
 
                                <p>

 	<label>City :</label>
                                    <span><?php echo $fldSchoolCity; ?></span>
                                </p>
                                <p> 
	<label>State :</label>
                                    <span><?php echo $fldSchoolState; ?></span>
                                </p> 
                                <?php for($i=0;$i<count($school_sport_coach);$i++){ 
                                	 $query_sport =" Select * from ".TBL_SPORTS. " where fldId =".$school_sport_coach[$i]['sportid'];
	

	$db->query($query_sport);
	$db->next_record();
	?><p><h1><?php echo $db->f('fldSportsname');
	

                                	?>

                              </h1></p>
                              <?php
                               $query_coach =" Select * from ".TBL_HS_AAU_COACH. " where fldId =".$school_sport_coach[$i]['coachnameid'];
	

	$db->query($query_coach);
	$db->next_record(); 
                              ?>
                                <p> 
	<label>Coach Name :</label>
                                    <span><?php echo $db->f('fldName'); ?></span>
                                </p>
                                 <p> 
	<label>Coach Email :</label>
                                    <span><?php echo $db->f('fldEmail'); ?></span>
                                </p>
                                 <p> 
	<label>Coach Phone :</label>
                                    <span><?php echo $db->f('fldPhone'); ?></span>
                                </p>
                                <?php } ?>
                         	 
                                                       </div>
                                                       
                                                       		</div>
                                                       				</div>
                                                       						</div>
                                                       							</div>
                                                       								</div>
</body>
</html>                                                       								
                                                      