<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Sanjay Chaudhary
##	Page name	:		ADCatagory.php
##	Create Date	:		10106/2011
##  Description :		It is use to performe the operation for add for Catagory.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				//for admin login



$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "10";
$error_msg = '';
$flag = 0;
$fldStatus=1;
if($_POST['isSubmit']=='save'){
	/*print_r($_POST);
	echo "inthis";
	die();
*/
        //Edit the user info
		$fldName        = $func->input_fun($_POST['fldName']);
		$fldDescription = $func->input_fun($_POST['fldDescription']);
		$fldStatus      = $func->input_fun($_POST['fldStatus']);

		$whereClause = "fldName='".$func->input_fun($_POST['fldName'])."'";

		if($db->MatchingRec(TBL_CATAGORY,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This Page Already Exists!';
			$flag++;
			}
	
        if($flag==0){
        	
			//Insert data
		     $strDataArr=array(
		     'fldName' 				=> $func->input_fun($_POST['fldName']),
		     'fldDescription' 		=> $func->input_fun($_POST['fldDescription']),
			'fldStatus' 			=> $func->input_fun($_POST['fldStatus'])
						);

	 		$db->insertRec(TBL_CATAGORY,$strDataArr);
       
			#redirect to listing page on successfull updation
			//header("Location: ADUserList.php");
			header("Location: ADCatagoryList.php?msg=Catagory is Added Successfully, ");
		}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		
		
		
		$fldName          = $_REQUEST['fldName'];
		$fldDescription   = $_REQUEST['fldDescription'];
		$fldStatus     = $_REQUEST['fldStatus'];
		

	}


} //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	
	var error_msg = "";
	//var blnResult = true;

    if(trimString(document.frmCatagory.fldName.value) == ""){
		error_msg += "Please Enter Catagory Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmCatagory.fldName.value)){
			error_msg += "Enter valid  Catagory Name! \n";
		}
	}

	if(trimString(document.frmCatagory.fldDescription.value) == ""){
		error_msg += "Please Enter Page Detail! \n";
	}
		
	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}
</script>
<HTML><HEAD><TITLE>Add User Info</TITLE>
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
			<form name="frmCatagory" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Add Catagory</b>
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
			<td valign="top" align="right" class="normalblack_12" width="30%">Catagory Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldName" id="fldName" value="<?=$fldName?>" maxlength="30" style="width: 220px;">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Catagory Detail<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><textarea name="fldDescription" id="fldDescription" rows="10" cols="15"  style="width: 220px;" onKeyDown="textCounter(document.frmPage.fldPageDescraption,document.frmPage.remLen2,100000)"
             onKeyUp="textCounter(document.frmPage.fldPageDescraption,document.frmPage.remLen2,100000)" class="txt"><?php echo $fldDescription; ?></textarea></td>
			</tr>
			<tr height="20">
			<td align="center" valign="top" colspan="3" class="normalwhite_14">
			&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width: 220px;font-size:12px;">
			<option value=1 <?if($fldStatus==1){ echo "selected"; }?>>ACTIVE</option>
			<option value=0 <?if($fldStatus==0){ echo "selected"; }?>>DE-ACTIVE</option>
			
			</select></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
				
			
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