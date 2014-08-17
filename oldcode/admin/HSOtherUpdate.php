<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Sanjay Chaudhary
##	Page name	:		ADTeamEdit.php
##	Create Date	:		10106/2011
##  Description :		It is use to performe the operation for edit for Team Information.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				//for admin login



$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "2";
$error_msg = '';
$flag = 0;
$fldId = $_GET['fldId'];

if($_GET['mode']=='edit' AND $fldId!=""){
	#get the records
	$query =" Select * from ".TBL_HS_AAU_TEAM_OTHER. " where fldId =".$fldId;
	

	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
		
		$fldName        = $db->f('fldName');
		$fldAddress        = $db->f('fldCoachName');
		$fldContactInfo        = $db->f('fldCoachPhone');
		$fldStatus        = $db->f('fldStatus');
		
	}
}
else {
	    $fldName        = "";
		$fldAddress        = "";
		$fldContactInfo ="";
		$fldStatus        = "";
		

}
if($_POST['isSubmit']=='save'){
	
	$where = "fldId=".$fldId;
        			//Update data
				     $strDataArr=array(
		     		     'fldCoachName' 			    => $func->input_fun($_POST['fldAddress']),'fldCoachPhone' 			    => $func->input_fun($_POST['fldContactInfo']),		
            'fldStatus' 				=> $func->input_fun($_POST['fldStatus']));

			$db->updateRec(TBL_HS_AAU_TEAM_OTHER,$strDataArr, $where);
			if($_POST['fldStatus']==1)
			{
				$query_others="select * from ".TBL_HS_AAU_TEAM_OTHER;
				$db1->query($query_others);
				$db1->next_record();
				$fld_other_username=$db1->f('fldUserId');
				$query_others="select * from ".TBL_ATHELETE_REGISTER." where fldId ='".$fld_other_username."' and fldSchool ='others'";
				$db2->query($query_others);
				$db2->next_record();
				$db2->f('fldEmail');
				$where1 = "fldId ='".$fld_other_username ."'";
        			//Update data
        			if($func->input_fun($_POST['fldStatus'])==1)
        			{
        				$status="ACTIVE";
        			}
        			
				     $strDataArr_college=array(
		      'fldCoachPhone' 			    => $func->input_fun($_POST['fldCoachPhone']),			   		
            'fldStatus' 				=> $status);

			$db3->updateRec(TBL_HS_AAU_TEAM, $strDataArr_college, $where1);
				$subjectStre = "HS / AAU TEAM Add Confirmation";
						$bodyStre = "Hi (Username)</br>College XXXXXXX has been added in the college list. Please edit your profile and update college name. </br>Thanks</br>Admin</br>www.ddd.com</br>
";
						$fldEmail="Admin";
						 $func->sendEmail($db2->f('fldEmail'),$subjectStre,$bodyStre,$db2->f('fldEmail'));
						$func->sendEmail(ADMIN_EMAIL,$subjectStre,$bodyStre,ADMIN_EMAIL);

			}
			#redirect to listing page on successfull updation
			header("Location: HsAauOtherList.php?page=".$_REQUEST['page']."&msg=Other Updated Successfully!");
		
	

	if($error_msg!=""){
		
		$fldName        = $_REQUEST['fldName'];
		$fldAddress        = $_REQUEST['fldCoachName'];
		$fldContactInfo        = $_REQUEST['fldCoachPhone'];
		$fldfldStatus        = $_REQUEST['fldfldStatus'];

	}
}

 //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	var error_msg = "";
	//var blnResult = true;

    if(trimString(document.frmCatagory.fldName.value) == ""){
		error_msg += "Please Enter  Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmCatagory.fldName.value)){
			error_msg += "Enter valid   Coach Name! \n";
		}
	}

	if(trimString(document.frmCatagory.fldAddress.value) == ""){
		error_msg += "Please Enter  Phone Number! \n";
	}
		
	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}


</script>
<HTML><HEAD><TITLE>Add Team Info</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js">
</script>
<script language="Javascript" src="../javascript/functions.js">
</script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" OnLoad="textCounter(document.frmUsers.address,document.frmUsers.remLen2,100)" >
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TR>
<TD height=120>
<?include "include/ADheader.php";?>
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
			<form name="frmPage" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Edit Other Information</b>
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
			<font color="Red"><?=$error_msg?> </font>
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
			<td valign="top" align="right" class="normalblack_12" width="30%">Name<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldName" id="fldName" value="<?=$fldName?>" maxlength="30" style="width: 220px;" readonly>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Coach Name<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><textarea name="fldAddress" id="fldAddress" rows="10" cols="15"  style="width: 220px;"  class="txt"><?php echo $fldAddress; ?></textarea>
            </td>
			</tr>
			<tr height="20">
			<td align="center" valign="top" colspan="3" class="normalwhite_14">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Coach phone<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><input type="text" name="fldContactInfo" id="fldContactInfo" rows="10" cols="15"  style="width: 220px;"  class="txt" value="<?php echo $fldContactInfo; ?>">            </td>
			</tr>
			<tr height="20">
			<td align="center" valign="top" colspan="3" class="normalwhite_14">
			&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width: 220px;font-size:12px;">
			<option value=1 <?if($fldStatus==1){ echo "selected"; }?>>ACTIVE</option>
			<option value=0 <?if($fldStatus==0){ echo "selected"; }?>>DE-ACTIVE</option>
			
			</select></td>
			</tr>
			
			
			
			
			<tr height="20">
			<td align="center" valign="top" colspan="3" class="normalwhite_14">
			&nbsp;
			</td>
			</tr>	
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			
			
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" > &nbsp;</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">&nbsp</td>
			<td valign="top"  align="center" class="normalblack_12" > &nbsp</td>
			<td valign="top" align="left" class="normalblack_12">
			<input type="hidden" name="isSubmit" value="save">
			<input type="submit" name="submit" value="Submit">&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"></td>
			</tr>
			
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" > &nbsp;</td>
			</tr>
			
			<!-- Upoad File END-->
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