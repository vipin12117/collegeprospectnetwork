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
		$fldCollegename        = $func->input_fun($_POST['fldCollegename']);
		$fldUserName        = $func->input_fun($_POST['fldUserName']);
		$fldEmail	        = $func->input_fun($_POST['fldEmail']);
		$fldAlternativeEmail= $func->input_fun($_POST['fldAlternativeEmail']);
		$fldPhone = $func->input_fun($_POST['fldPhone']);
		$fldAlternativePhone=$func->input_fun($_POST['fldAlternativePhone']);
		$fldDescriPation=$func->input_fun($_POST['fldDescriPation']);

		

		$whereClause = "fldUserName='".$fldUserName."' or fldCollegename ='$fldCollegename' or fldEmail='$fldEmail'";

		if($db->MatchingRec(TBL_COLLEGE_REGISTER,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This College is  Already Exists!';
			$flag++;
			}
	
        if($flag==0)
        {
        	
			//Insert data
				$strDataArr=array(
				'fldUserName' 				   => $func->input_fun($_POST['fldUserName']),
				'fldPassword' 				       => $func->input_fun($_POST['fldPassword']),
				'fldCollegename' 			       => $func->input_fun($_POST['fldCollegename']),
				'fldCity' 					       => $func->input_fun($_POST['fldCity']),
				'fldState' 				           => $func->input_fun($_POST['fldState']),
				'fldStatus' 			           => $func->input_fun($_POST['fldStatus']),
				'fldAddDate' =>date("y-m-d"),
				'fldSubscribe'                     => $func->input_fun($_POST['fldSubscribe']),
				'fldPosition'                      => $func->input_fun($_POST['fldPosition']),
				'fldNeedType'                      => $func->input_fun($_POST['fldNeedType']),
				'fldEmail' => $func->input_fun($_POST['fldEmail']),
				'fldFirstName'=>$func->input_fun($_POST['fldFirstName']),
				'fldLastName'=>$func->input_fun($_POST['fldLastName']),
				'fldAlternativeEmail'=>$func->input_fun($_POST['fldAlternativeEmail']),
				'fldPhone' => $func->input_fun($_POST['fldPhone']),
				'fldAlternativePhone' => $func->input_fun($_POST['fldAlternativePhone']),
				'fldDescriPation' => $func->input_fun($_POST['fldDescriPation'])
				
				
				
			);

			
		
		    
			
			$db->insertRec(TBL_COLLEGE_REGISTER,$strDataArr);
			
			
			
		     
		       
			#redirect to listing page on successfull updation
		
			header("Location: ADCollegeList.php?msg=$collegename College is Added Successfully, ");
		}
		
		
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		$fldUserName     = $_REQUEST['fldUserName'];
		$fldPassword        = $_REQUEST['fldPassword'];
		$fldCollegename   	= $_REQUEST['fldCollegename'];
		$fldCity			= $_REQUEST['fldCity'];
		$fldState			= $_REQUEST['fldState'];
		
		$fldPosition		 = $_REQUEST['fldPosition'];
		$fldNeedType		 = $_REQUEST['fldNeedType']; 
		$fldEmail			 = $_REQUEST['fldEmail'];
		$fldFirstName        = $_REQUEST['fldFirstName'];
		$fldLastName         = $_REQUEST['fldLastName'];
		$fldAlternativeEmail = $_REQUEST['fldAlternativeEmail'];
		$fldPhone 			 = $_REQUEST['fldPhone'];
		$fldAlternativePhone = $_REQUEST['fldAlternativePhone'];
		$fldDescriPation     = $_REQUEST['fldDescriPation'];
	 
	}


} //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function addfields() {
	
	var currentrow	= parseInt(document.frmUsers.currentrow.value);
	document.getElementById('trs_'+currentrow).style.display= "";
	document.getElementById('trc_'+currentrow).style.display= "";
	document.getElementById('trsb_'+currentrow).style.display= "";
	document.getElementById('trcb_'+currentrow).style.display= "";
	document.getElementById('currentrow').value=currentrow+1;
	if(document.getElementById('currentrow').value >= 1)
	{
		document.getElementById('remfield').style.display= "";
    }
}	


function removefields() {
	
	
	var currentrow	= parseInt(document.frmUsers.currentrow.value);
	document.getElementById('trs_'+currentrow).style.display= "none";
	document.getElementById('trc_'+currentrow).style.display= "none";
	document.getElementById('trsb_'+currentrow).style.display= "none";
	document.getElementById('trcb_'+currentrow).style.display= "none";
	
	if(document.getElementById('currentrow').value == 1)
	{
		document.getElementById('remfield').style.display= "none";
		document.getElementById('currentrow').value=currentrow;
    } else {
    	document.getElementById('currentrow').value=currentrow-1;	
    }
	

}	



function validate(){
	var error_msg = "";
	var blnResult = true;

	

	
		if(trimString(document.frmUsers.fldUserName.value) == ""){
		error_msg += "Please Enter User name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldUserName.value)){
			error_msg += "Enter Enter Valid Collegecode! \n";
		}
	}
	
	
	
	if(trimString(document.frmUsers.fldPassword.value) == ""){
		error_msg += "Please Enter Password! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldPassword.value)){
			error_msg += "Enter Enter Password! \n";
		}
	}
	
	
	if (document.frmUsers.fldPassword.value != document.frmUsers.fldCPassword.value){
		error_msg += "Your Confirm Password Does not Match! \n";
	}
	

	if(trimString(document.frmUsers.fldCollegename.value) == ""){
		error_msg += "Please Enter College Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldCollegename.value)){
			error_msg += "Enter Valid College Name! \n";
		}
	}
	if(trimString(document.frmUsers.fldFirstName.value) == ""){
		error_msg += "Please Enter First Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldFirstName.value)){
			error_msg += "Enter Valid First Name! \n";
		}
	}
	if(trimString(document.frmUsers.fldLastName.value) == ""){
		error_msg += "Please Enter Last Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldLastName.value)){
			error_msg += "Enter Valid Last Name! \n";
		}
	}
if(trimString(document.frmUsers.fldPhone.value) == ""){
		error_msg += "Please Enter Your Phone. \n";
	}
	else{
		if(!isPhone(document.frmUsers.fldPhone.value)){
			error_msg += "Enter valid  Phone. \n";
		}
	}
	if((!isPhone(document.frmUsers.fldAlternativePhone.value)) && (trimString(document.frmUsers.fldAlternativePhone.value) != "")) {
			error_msg += "Enter Valid Alternative Phone. \n";
		}
	
	if(trimString(document.frmUsers.fldEmail.value) == ""){
		error_msg += "Please Enter Email. \n";
	}
	else{
		if(!isValid(document.frmUsers.fldEmail.value) ){
			error_msg += "Enter Valid Email. \n";
		}
	}
	
	if((!isValid(document.frmUsers.fldAlternativeEmail.value)) && (trimString(document.frmUsers.fldAlternativeEmail.value) != "")) {
			error_msg += "Enter Valid Alternative Email. \n";
		}
	if(trimString(document.frmUsers.fldCity.value) == ""){
		error_msg += "Please Enter City! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldCity.value)){
			error_msg += "Enter valid City! \n";
		}
	}


	if(trimString(document.frmUsers.fldState.value) == ""){
		error_msg += "Please Enter State! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldState.value)){
			error_msg += "Enter valid State! \n";
		}
	}

	
	if(trimString(document.frmUsers.fldNeedType.value) == ""){
		error_msg += "Please Select the Sport! \n";
	}
		

	

	

	
	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}







</script>
<HTML><HEAD><TITLE>Add College Info</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" >
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
				<b>Add College Coach Info</b>
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
			<td valign="top" align="right" class="normalblack_12" width="30%">User Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldUserName" id="fldUserName" value="<?=$fldUserName?>" maxlength="50" style="width:200px">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Passowrd<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="password" name="fldPassword" id="fldPassword" value="<?=$fldPassword?>" maxlength="10" style="width:200px">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Confirm Passowrd<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="password" name="fldCPassword" id="fldCPassword" value="<?=$fldCPassword?>" maxlength="10" style="width:200px">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">College Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldCollegename" value="<?=$fldCollegename?>" maxlength="30" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">First Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldFirstName" value="<?=$fldPhone?>" maxlength="30" style="width:200px" id="fldFirstName"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Last Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldLastName" value="<?=$fldCollegename?>" maxlength="30" style="width:200px" id="fldLastName"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Phone<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldPhone" value="<?=$fldCollegename?>" maxlength="30" style="width:200px" id="fldPhone"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Alternate Phone<font color="red"></font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldAlternativePhone" value="<?=$fldAlternativePhone?>" maxlength="30" style="width:200px" id="fldAlternativePhone"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Email Address<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldEmail" value="<?=$fldEmail?>" maxlength="30" style="width:200px" id="fldEmail"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Alternative Email<font color="red"></font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldAlternativeEmail" value="<?=$fldAlternativeEmail?>" maxlength="30" style="width:200px" id="fldAlternativeEmail"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>

			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">City<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldCity" value="<?=$fldCity?>" maxlength="40" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">State<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldState" value="<?=$fldState?>" maxlength="40" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Description<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">  <textarea rows=5 cols=22 name=fldDescriPation><?=$fldDescriPation?></textarea>
			
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Position<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldPosition" value="<?=$fldPosition?>" maxlength="40" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Sport<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">

			
			
			<?php  
			echo $strcombo = '<select name="fldNeedType" style="width:200px">';
			echo $strcombo = '<option value = "">Select Type</option>';
			$categorylist=$func->selectTableOrder(tbl_sports,"fldId,fldSportsname","fldId");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
  		    echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldSportsname'].'</option>';
            }
			echo $strcombo = '</select>';
			?>
			
			
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Subscribe<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
              
			<select name="fldSubscribe" style="width:200px">
			<option value="">Please Select</option>
			<option value="2">Trial Period</option>
			<option value="1">Subscribe</option>
			<option value="0">UnSubscribe</option>	
			</select>
		
			</tr>
			
			
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>

			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width:200px">
			
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