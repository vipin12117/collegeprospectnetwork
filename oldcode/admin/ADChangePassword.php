<?php
##******************************************************************
##  Project		:		Reusable Component- Synapse - Admin Panel
##  Done by		:		Manish Arora
##	Page name	:		ADChangePassword.php
##	Create Date	:		23/06/2009
##  Description :		It is use to change the admin password.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include("include/ADsessionAdmin.php");				// for admin login
$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "0";

$error_msg = '';

if($_POST['isSubmit']=='save'){

	if($_SESSION['ADMIN_USER']!="")
		{

		 $whereClause = "username='".$_SESSION['ADMIN_USER']."' and password ='".$func->input_fun($_POST['oldpassword'])."'";
		
		if( $db->MatchingRec(TBL_ADMIN,$whereClause) == 0 ) {
			$error_msg = 'Please enter correct old password!';
		}else{

			if($error_msg ==''){
				$strDataArr=array('password ' => $func->input_fun($_POST['newpassword']));
				$where = "username='".$_SESSION['ADMIN_USER']."'";
				$db->updateRec(TBL_ADMIN, $strDataArr, $where);
				header("Location: ADChangePassword.php?page=".$_REQUEST['page']."&msg=Admin password changed successfully!");
			}
		}

	}

	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		$oldpassword	    =	$_REQUEST['oldpassword'];
		$newpassword	    =	$_REQUEST['newpassword'];
		$confirmnewpassword	=	$_REQUEST['confirmnewpassword'];
	}

} //END if submit

?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	var error_msg = "";

	if(trimString(document.frmUsers.oldpassword.value) == ""){
		error_msg += "Please enter old Password! \n";
	}else if(document.frmUsers.oldpassword.value.length < 5){
		error_msg += "Old password should be more then 5 characters! \n";
	}

	if(trimString(document.frmUsers.newpassword.value) == ""){
		error_msg += "Please enter new Password! \n";
	}else if(document.frmUsers.newpassword.value.length < 5){
		error_msg += "New password should be more then 5 characters! \n";
	}

	if(trimString(document.frmUsers.confirmnewpassword.value) == ""){
		error_msg += "Please enter confirm new Password! \n";
	}else if(document.frmUsers.confirmnewpassword.value.length < 5){
		error_msg += "Confirm password should be more then 5 characters! \n";
	}

	if(trimString(document.frmUsers.newpassword.value) != trimString(document.frmUsers.confirmnewpassword.value)){
		error_msg += "Passwords do not match, please re-enter your password! \n";
	}

	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}

</script>
<HTML><HEAD><TITLE>Admin Change Password</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" OnLoad="document.frmUsers.oldpassword.focus();">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TR>
<TD height=120>
<? include "include/ADheader.php";?>
</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TR>
<TD class="heading">
<TABLE cellSpacing=0 cellPadding=1 width="95%" align=center border=0>
<TR>
<TD>
	<TABLE cellSpacing=0 cellPadding=1 width=780 border=0>
	<TR>
	<TD bgColor=#ffffff>
		<TABLE cellSpacing=0 cellPadding=0 width=900 border=0>
		<TR>
		<TD vAlign=top width=20%>
			<?include "include/ADmenu.php";?>
		</TD>
		<TD valign=top width=1%>
		&nbsp;
		</TD>
		<TD width=10><img src="spacer.gif" height="1" width="1">
		</TD>
		<TD valign=top width="" align="center">
<!-- MAin Content Starts From Here -->
			<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Admin Change Password</b>
			</td>
			</tr>
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr>
			<td valign="top" colspan=3 align="center" class="normalblack_12">
			<font color="Red"><?if($_REQUEST['msg']!=''){echo $_REQUEST['msg'];}else{echo $error_msg;}?> </font>
			</td>
			</tr>
			<tr>
			<td height="35" colspan="3" align="right" class="normalblack_12"><FONT color="Red">Fields marked with * are mandatory&nbsp;</FONT></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Old Password<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="password" name="oldpassword" value="<?=$oldpassword?>" maxlength="50" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">New Password<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="password" name="newpassword" value="<?=$newpassword?>" maxlength="50" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Confirm New Password<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="password" name="confirmnewpassword" value="<?=$confirmnewpassword?>" maxlength="50" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>

			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">&nbsp</td>
			<td valign="top"  align="center" class="normalblack_12" > &nbsp</td>
			<td valign="top" align="left" class="normalblack_12">
			<input type="hidden" name="isSubmit" value="save">
			<input type="submit" name="submit" value="Submit">&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"></td>
			</tr>
			
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" > &nbsp;</td>
			</tr>			
			
			</table>
			</td>
			</tr>
			</table>
			</form>
				
<!--Main Center Content END -->
											
		</td>
		</tr>
		</table>
	</TD>
	</TR>
	</TABLE>
</TD>
</TR>
</TABLE>
</TD>
</TR>
<?include "include/ADfooter.php";?>
<? unset($func);  unset($db); ?>
</TABLE>
</BODY>
</HTML>