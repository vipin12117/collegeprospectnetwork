<?php
##******************************************************************
##  Project		:		Reusable Component- Synapse - Admin Panel
##  Done by		:		Manish Arora
##	Page name	:		ADsessionAdmin.php
##	Create Date	:		23/06/2009
##  Description :		It is use to authenticate admin login.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************
session_start();
if( $_SESSION['ADMIN_SESS'] == ""){
	header("Location:index.php");
}
?>