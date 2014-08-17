<?php
##******************************************************************
##  Project		:		Reusable Component- Synapse - Admin Panel
##  Done by		:		Manish Arora
##	Page name	:		ADlogout.php
##	Create Date	:		23/06/2009
##  Description :		It is use to logout the admin user.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

session_start();
$_SESSION['FRONTEND_USER']="";
$_SESSION['mode']="";
$_SESSION['fldSubscribe']="";
$_SESSION['EMAIL']="";
$_SESSION['Coach_id']="";
$_SESSION['Athlete_id']="";
$_SESSION['College_Coach_id']="";


if($_REQUEST['msg'] !='')
{
header("Location: index.php?page=".$_REQUEST['page']."&msg=Your password has been updated.");
}

else 
{

header("Location: login.php");
}

exit;
?>