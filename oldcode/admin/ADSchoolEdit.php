<?php
##******************************************************************
##  Project		:		Reusable Component- Synapse - Admin Panel
##  Done by		:		Manish Arora
##	Page name	:		ADUserEdit.php
##	Create Date	:		23/06/2009
##  Description :		It is use to perform the operation for add/edit/delete for User.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				// for admin login

$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "2";
$error_msg = '';
$flag = 0;
$flag_duplicacy=0;
$fldId = $_GET['fldId'];



if($_GET['mode']=='edit' AND $fldId!="")
{
	#get the records
	 $query =" Select * from ".TBL_HS_AAU_TEAM. " where fldId = '$fldId' ";
	
	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
		
		$fldSchoolname	    = $db->f('fldSchoolname');
		$fldAddress	        = $db->f('fldAddress');
		$fldCity            = $db->f('fldCity');
		$fldState 	        = $db->f('fldState');
		$fldZipcode         = $db->f('fldZipcode');
		$fldEnrollment         = $db->f('fldEnrollment');
		$fldStatus 	        = $db->f('fldStatus');
		
	}
	
	
	
	
	
}
else {
	   
		$fldSchoolname         = "";
		$fldAddress            = "";
		$fldCity               = "";
		$fldState 	           = "";
		$fldZipcode            = "";
		
        $fldStatus 	           = "";
        $fldEnrollment ="";	

}
if($_POST['isSubmit']=='save'){

	if($_GET['fldId']!=""){
		//Edit the user info
		
		$fldSchoolname      = $func->input_fun($_POST['fldSchoolname']);
		$fldAddress         = $func->input_fun($_POST['fldAddress']);
		$fldCity            = $func->input_fun($_POST['fldCity']);
		$fldState           = $func->input_fun($_POST['fldState']);
		$fldZipcode         = $func->input_fun($_POST['fldZipcode']);
		$fldEnrollment		= $func->input_fun($_POST['fldEnrollment']);
		
		$fldStatus          = $func->input_fun($_POST['fldStatus']);
		
		

        if($_GET['fldId']!=$_GET['fldId'] ){
		$whereClause = "fldId='".$func->input_fun($_GET['fldId'])."'";
		
			if($db->MatchingRec(TBL_HS_AAU_TEAM,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This HS/AAU Team Already  Exists!';
			$flag++;
			}
		}

		

		if(($flag==0)){
			
	
			//Update data
			$where = "fldId='".($_GET['fldId'])."'";
			
			$Zipcode_lat_lon=$func->getLatLong($func->input_fun($_POST['fldZipcode']),MAPS_APIKEY);
			if($func->input_fun($_POST['fldSchoolname'])==$db->f('fldSchoolname'))
			{
				
				$strDataArr=array(
			
			
			'fldAddress'                     => $func->input_fun($_POST['fldAddress']),
			'fldCity'                        => $func->input_fun($_POST['fldCity']),
			'fldState'                       => $func->input_fun($_POST['fldState']),
			'fldZipcode'                     => $func->input_fun($_POST['fldZipcode']),
			'fldEnrollment'					 => $func->input_fun($_POST['fldEnrollment']),
			'fldStatus'                      => $func->input_fun($_POST['fldStatus']),
			'fldLatitude' 					   => $Zipcode_lat_lon['Latitude'],
'fldLongitude'                     => $Zipcode_lat_lon['Longitude']
			
			);	
			$db->updateRec(TBL_HS_AAU_TEAM,$strDataArr, $where);
			header("Location: ADSchoolList.php?page=".$_REQUEST['page']."&msg=HS / AAU Team Updated Successfully!");
						}
						else {
							
							$whereClause="fldSchoolname='".$func->input_fun($_POST['fldSchoolname'])."'";
							if($db->MatchingRec(TBL_HS_AAU_TEAM,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This HS/AAU Team Already  Exists!';
			$flag_duplicacy++;
			}
			else if($flag_duplicacy==0){
				$strDataArr=array(
			
			'fldSchoolname'                  => $func->input_fun($_POST['fldSchoolname']),
			'fldAddress'                     => $func->input_fun($_POST['fldAddress']),
			'fldCity'                        => $func->input_fun($_POST['fldCity']),
			'fldState'                       => $func->input_fun($_POST['fldState']),
			'fldZipcode'                     => $func->input_fun($_POST['fldZipcode']),
			'fldEnrollment'					 => $func->input_fun($_POST['fldEnrollment']),
			'fldStatus'                      => $func->input_fun($_POST['fldStatus']),
			'fldLatitude' 					   => $Zipcode_lat_lon['Latitude'],
'fldLongitude'                     => $Zipcode_lat_lon['Longitude']
			
			);	
			$db->updateRec(TBL_HS_AAU_TEAM,$strDataArr, $where);
			header("Location: ADSchoolList.php?page=".$_REQUEST['page']."&msg=HS / AAU Team Updated Successfully!");	
			}
							
							
						}
				
			
			
			
			
			
			
			
			#redirect to listing page on successfull updation
			
		}
	}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
      
		$fldSchoolname          = $_REQUEST['fldSchoolname'];
    	$fldAddress             = $_REQUEST['fldAddress'];
		$fldCity                = $_REQUEST['fldCity'];	
	    $fldState               = $_REQUEST['fldState'];
	    $fldZipcode             = $_REQUEST['fldZipcode'];	
	    $fldEnrollment          = $_REQUEST['fldEnrollment'];
	   	$fldStatus              = $_REQUEST['fldStatus'];
												
	}


} //END if submit
if($_REQUEST['page']==''){$pageno='0';}else{$pageno=$_REQUEST['page'];}

?>
<HTML><HEAD><TITLE>Sport Info</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">


function validate(){
	var error_msg = "";
	var blnResult = true;


	
	
	if(trimString(document.frmUsers.fldSchoolname.value) == ""){
		error_msg += "Please Enter HS/AAU Team Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldSchoolname.value)){
			error_msg += "Enter valid HS/AAU Team Name! \n";
		}
	}
	
		if(trimString(document.frmUsers.fldAddress.value) == ""){
		error_msg += "Please Enter address! \n";
	}
	
	
	
	
	
	
	if(trimString(document.frmUsers.fldCity.value) == ""){
		error_msg += "Please Enter city Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldCity.value)){
			error_msg += "Enter Valid City Name! \n";
		}
		else if(isNumeric(document.frmUsers.fldCity.value))
		{
		error_msg += "Enter Valid City Name! \n";
		}
		
	}
	
	if(trimString(document.frmUsers.fldState.value) == ""){
		error_msg += "Please Enter State Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldState.value)){
			error_msg += "Enter Valid State Name! \n";
		}
		else if(isNumeric(document.frmUsers.fldState.value))
		{
			error_msg += "Enter Valid State Name! \n";
		}
	}
	
		if(trimString(document.frmUsers.fldZipcode.value) == ""){
	error_msg += "Please Enter Zipcode! \n";
	}
	else{
	
	if(trimString(document.frmUsers.fldZipcode.value) != ""){

		if(!isNumeric(document.frmUsers.fldZipcode.value)){
			error_msg += "Please Enter numeric Zipcode! \n";
		}
		
	}
	}
	
	
	

	

	if(trimString(document.frmUsers.fldStatus.value) == ""){
		error_msg += "Please Enter status! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldStatus.value)){
			error_msg += "Enter valid status! \n";
		}
	}
	


	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}



</script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" onload="javascript:textCounter(document.frmUsers.address,document.frmUsers.remLen2,100)"  >
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
			<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Edit HS/AAU Team Info</b>
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
			<td valign="top" align="right" class="normalblack_12" width="30%">Name
			<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text" name="fldSchoolname" id="fldSchoolname" value="<?=$fldSchoolname?>" 
             maxlength="50" style="width:200px" >
			</td>
			</tr>			
			
			
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Enrollment
			<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text" name="fldEnrollment" id="fldEnrollment" value="<?=$fldEnrollment?>" 
             maxlength="50" style="width:200px" >
			</td>
			</tr>			
			
			
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Address<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><textarea name="fldAddress" id="fldAddress" rows="5" cols="9"  style="width: 200px;" onKeyDown="textCounter(document.frmUsers.fldAddress,document.frmPage.remLen2,100000)"
             onKeyUp="textCounter(document.frmUsers.fldAddress,document.frmPage.remLen2,100000)" class="txt"><?php echo $fldAddress; ?></textarea></td>
			</tr>
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">City<font color="red">*            </font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text" name="fldCity" id="fldCity" value="<?=$fldCity?>" maxlength="50" 
             style="width:200px">
			</td>
			</tr>
			
			
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">State
			<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text" name="fldState" id="fldState" value="<?=$fldState?>" 
             maxlength="50" style="width:200px">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Zip Code<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<input type="text" name="fldZipcode" value="<?=$fldZipcode?>" maxlength="30" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
	
	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width:200px">
			<!--<option value="" <?if($status==''){ echo "selected"; }?>>---Select---</option>-->
			<option value="ACTIVE" <?if($fldStatus=='ACTIVE'){ echo "selected"; }?>>ACTIVE</option>
			<option value="DEACTIVE" <?if($fldStatus=='DEACTIVE'){ echo "selected"; }?>>DE-ACTIVE</option>
			</select></td>
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
			<input type="hidden" name="userType" value="<?=($userType!="")?$userType:""?>">
			<input type="hidden" name="oldcode" value="<?=($oldcode)?$oldcode:$code?>">
			<input type="hidden" name="isSubmit" value="save">
			
		
		<input type="submit" name="submit" value="Submit">&nbsp;&nbsp;
		<input type="reset" name="Submit2" value="Reset">&nbsp;&nbsp;
		
		</td>
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