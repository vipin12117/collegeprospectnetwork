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
$_SESSION['ADMIN_SESS'] = "";
$_SESSION['ADMIN_USER'] = "";
$_SESSION['ADMIN_UID'] = "";
header("location: index.php");
exit;
?>