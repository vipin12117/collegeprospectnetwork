<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		ADUserAdd.php
##	Create Date	:		10/06/2011
##  Description :		It is use to performe the operation for add/edit/delete for User.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				// for admin login



$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "10";
$error_msg = '';
$flag = 0;

 

if($_POST['isSubmit']=='save'){
        //Edit the user info
		$fldSchoolname        = $func->input_fun($_POST['fldSchoolname']);
	
		$whereClause = "fldSchoolname='".$fldSchoolname ."'";

		if($db->MatchingRec(TBL_HS_AAU_TEAM,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This HS/AAU Team Code Already Exists!';
			$flag++;
			}
	
        if($flag==0)
        {
        	
        	 $errors=0;

        	    
        	 
        	
			//Insert data
			$Zipcode_lat_lon=$func->getLatLong($func->input_fun($_POST['fldZipcode']),MAPS_APIKEY);
			
				$strDataArr=array(
				
				'fldSchoolname' 			    => $func->input_fun($_POST['fldSchoolname']),
				'fldAddress' 			        => $func->input_fun($_POST['fldAddress']),
				'fldCity' 					    => $func->input_fun($_POST['fldCity']),
				'fldState' 				        => $func->input_fun($_POST['fldState']),
				'fldZipcode' 					=> $func->input_fun($_POST['fldZipcode']),
				'fldStatus' 			        => $func->input_fun($_POST['fldStatus']),
				'fldEnrollment' 			    => $func->input_fun($_POST['fldEnrollment']),
				'fldLatitude' 					   => $Zipcode_lat_lon['Latitude'],
				'fldLongitude'                     => $Zipcode_lat_lon['Longitude']
				);

//$s=$_POST;	
//print_r($s);	

	
			 




            
		     
		     
		     
		     $db->insertRec(TBL_HS_AAU_TEAM,$strDataArr);
		     
	
		     
		       
			#redirect to listing page on successfull updation
		
			header("Location: ADSchoolList.php?msg=$fldSchoolname is Added Successfully, ");
		}
		
		
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		
		$fldSchoolname		= $_REQUEST['fldSchoolname'];
		$fldAddress		    = $_REQUEST['fldAddress'];
		$fldCity		    = $_REQUEST['fldCity'];
		$fldState			= $_REQUEST['fldState'];
		$fldZipcode		    = $_REQUEST['fldZipcode'];
		$fldEnrollment      =$_REQUEST['fldEnrollment'];
		$fldStatus          = $_REQUEST['fldStatus'];
	 
	}


} //END if submit


?>

<script language="JavaScript" type="text/JavaScript">




function validate(){
	var error_msg = "";
	var blnResult = true;
	
	

	
	

	
	
	if(trimString(document.frmUsers.fldSchoolname.value) == ""){
		error_msg += "Please Enter HS/AAU Team name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldSchoolname.value)){
			error_msg += "Enter HS/AAU Team name with no SpecialCharaters! \n";
		}
	}
	
	
		if(trimString(document.frmUsers.fldAddress.value) == ""){
		error_msg += "Please Enter address! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldAddress.value)){
			error_msg += "Enter address! \n";
		}
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
		if(document.frmUsers.fldZipcode.value.length > 15){
			error_msg += "Zipcode should be less then 16 characters! \n";
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
	
	
	
	///////////////////////////////////
	
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
<script language="Javascript" src="../javascript/functions.js"></script>
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
			<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Add HS/AAU Team Info</b>
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
			<td valign="top" align="left" class="normalblack_12"> 
			<input type="text" name="fldSchoolname" value="<?=$fldSchoolname?>" maxlength="30" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Enrollment<font color="red"></font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<input type="text" name="fldEnrollment" value="<?=$fldEnrollment?>" maxlength="30" style="width:200px"></td>
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
			<td valign="top" align="right" class="normalblack_12" width="30%">City<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldCity" value="<?=$fldCity?>" maxlength="40" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">State<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldState" value="<?=$fldState?>" maxlength="40" style="width:200px"></td>
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
			<option value="ACTIVE" <?if($status=='ACTIVE'){ echo "selected"; }?>>ACTIVE</option>
			<option value="DEACTIVE" <?if($status=='DEACTIVE'){ echo "selected"; }?>>DE-ACTIVE</option>
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