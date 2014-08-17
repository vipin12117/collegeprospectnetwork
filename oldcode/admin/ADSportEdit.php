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
$fldId = $_GET['fldId'];

if($_GET['mode']=='edit' AND $fldId!=""){
	#get the records
	 $query =" Select * from ".TBL_SPORTS. " where fldId = '$fldId' ";
	
	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
		
		$fldSportsname	    = $db->f('fldSportsname');
		$fldDescription     = $db->f('fldDescription');
        $fldStatus	        = $db->f('fldStatus');
		
	}
}
else {
	   
		$fldSportsname     = "";
		$fldDescription    = "";
        $fldStatus 	       = "";	

}
if($_POST['isSubmit']=='save'){

	if($_GET['fldId']!=""){
	
		$fldSportsname      = $func->input_fun($_POST['fldSportsname']);
		$fldDescription     = $func->input_fun($_POST['fldDescription']);
		$fldStatus          = $func->input_fun($_POST['fldStatus']);
		
		

        if($_GET['fldId']!=$_GET['fldId'] ){
		$whereClause = "fldId='".$func->input_fun($_GET['fldId'])."'";
		
			if($db->MatchingRec(TBL_SPORTS,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This coach Already  Exists!';
			$flag++;
			}
		}

		
		if($flag==0){
			
			//Update data
			$where = "fldId='".($_GET['fldId'])."'";

			$strDataArr=array(
			//'fldCategoryid' 	    => $func->input_fun($_POST['fldCategoryid']),
		    'fldSportsname' 		=> $func->input_fun($_POST['fldSportsname']),
			'fldDescription' 		=> $func->input_fun($_POST['fldDescription']),				
			'fldStatus' 			=> $func->input_fun($_POST['fldStatus'])
			);

			$db->updateRec(TBL_SPORTS,$strDataArr, $where);
			
			#redirect to listing page on successfull updation
			header("Location: ADSportList.php?page=".$_REQUEST['page']."&msg=Sport Updated Successfully!");
		}
	}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
       
		$fldSportsname      = $_REQUEST['fldSportsname'];
		
		$fldDescription     = $_REQUEST['fldDescription'];
		$fldStatus          = $_REQUEST['fldStatus'];
												
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

	

	
	if(trimString(document.frmUsers.fldSportsname.value) == ""){
		error_msg += "Please Enter SportsName email! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldSportsname.value)){
			error_msg += "Enter SportsName email! \n";
		}
	}

	
	
	
	
	

	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}

function membercode(fieldValue)
{
	  var iChars = "'!@#$%^&*()+=[]\\\';,/{}|\":<>";
	  var flag = false;
	  for (var i = 0; i < fieldValue.length; i++) {
	  	if (iChars.indexOf(fieldValue.charAt(i)) != -1) {
	  		flag = true;
	  		break;
	  	}
	  }
	  if(flag){
	  	return true;
	  }else{
	  	return false;
	  }
}

function textCounter(field,cntfield,maxlimit) {
	
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else
cntfield.value = maxlimit - field.value.length;
}

</script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0"   >
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
				<b>Edit Sport Info</b>
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
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Sports<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldSportsname" id="fldSportsname" value="<?=$fldSportsname?>" maxlength="50" style="width:220px">
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			

			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Description<font color="red"></font></td><td valign="top"  align="center" class="normalblack_12" > : </td><td valign="top" align="left" class="normalblack_12">
			<textarea name="fldDescription" id="fldDescription" value="<?=$fldDescription?>" rows="5" cols="15"  style="width:220px" onKeyDown="textCounter(document.frmUsers.fldDescription,document.frmUsers.remLen2,250)" onKeyUp="textCounter(document.frmUsers.fldDescription,document.frmUsers.remLen2,250)"><?=$fldDescription?></textarea>
			
</td>
			</tr>		
			
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width:220px">
			
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