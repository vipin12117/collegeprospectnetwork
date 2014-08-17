<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Sanjay Chaudhary
##	Page name	:		ADTeam.php
##	Create Date	:		10106/2011
##  Description :		It is use to performe the operation for add for Team.
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
	
        //Edit the user info
		$fldTitle        = $func->input_fun($_POST['fldTitle']);
		$fldDescription = $func->input_fun($_POST['fldDescription']);
		$fldStatus      = $func->input_fun($_POST['fldStatus']);

		$whereClause = "fldTitle='".$func->input_fun($_POST['fldTitle'])."'";

		if($db->MatchingRec("tbl_notes",$whereClause)>0) {    #user Username already exists 
			$error_msg = 'This Note Already Exists!';
			$flag++;
			}
	
        if($flag==0){
        	
			//Insert data
		     $strDataArr=array(
		     'fldTitle' 				=> $func->input_fun($_POST['fldTitle']),
		     'fldDescription' 		=> $func->input_fun($_POST['fldDescription']),
			'fldStatus' 			=> $func->input_fun($_POST['fldStatus'])
						);

	 		$db->insertRec("tbl_notes",$strDataArr);
       
			#redirect to listing page on successfull updation
			
			header("Location: ADNotesList.php?msg=Note is Added Successfully, ");
		}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		
		
		
		$fldTitle          = $_REQUEST['fldTitle'];
		$fldDescription   = $_REQUEST['fldDescription'];
		$fldfldStatus     = $_REQUEST['fldStatus'];
	}


} //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	
	var error_msg = "";
	

    if(trimString(document.frmCatagory.fldTitle.value) == ""){
		error_msg += "Please Enter Title! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmCatagory.fldTitle.value)){
			error_msg += "Enter valid  Title! \n";
		}
	}
	if(trimString(document.frmCatagory.fldDescription.value) == ""){
		error_msg += "Please Enter Description! \n";
	}
	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}
</script>
<HTML><HEAD><TITLE>Add Note Info</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
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
		<TD valign=top width=1%>&nbsp;
		
		</TD>
		<TD width=10><img src="spacer.gif" height="1" width="1">
		</TD>
		<TD valign=top width="" align="center">
<!-- MAin Content Starts From Here -->
			<form name="frmCatagory" action="" method="post" enctype="multipart/form-data" onSubmit="return validate()">
			<TABLE width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<TR height="20">
			<TD align="center" class="normalblack_12" width="90%" valign="top" >
			<TABLE width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<TR>
			<!-- Display the message on heading of the page -->
			<TD valign="top" class="normalwhite_14" colspan="3" bgcolor="#808080" align="center">
				<b>Add Note</b>
			</TD>
			</TR>
			<TR>
			<!-- Display the message on heading of the page -->
			<TD valign="top" colspan="3" align="center">&nbsp;
			
			</TD>
			</TR>
			<TR>
			<TD valign="top" colspan="3" align="center" class="normalblack_12">
			<font color="Red"><?=$error_msg?> </font>
			</TD>
			</TR>
			<TR>
			<TD height="35" colspan="3" align="right" class="normalblack_12"><FONT color="Red">Fields marked with * are mandatory&nbsp;</FONT></TD>
			</TR>
			<TR height="20">
			<TD valign="top" class="normalwhite_14" colspan="3" align="center">&nbsp;
			
			</TD>
			</TR>		
			
			<TR height="20">
			<TD valign="top" align="right" class="normalblack_12" width="30%">Note Title<font color="red"> *</font> </TD>
			<TD valign="top"  align="center" class="normalblack_12" > : &nbsp; </TD>
			<TD valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldTitle" id="fldTitle" value="<?=$fldTitle?>" maxlength="30" style="width: 220px;">
			</TD>
			</TR>
			<TR height="20">
			<TD valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</TD>
			</TR>
			
			<TR height="20">
			<TD valign="top" align="right" class="normalblack_12" width="30%">Description<font color="red"> *</font> </TD>
			<TD valign="top"  align="center" class="normalblack_12" > : </TD>
			<TD valign="top" align="left" class="normalblack_12">
				<textarea name="fldDescription" id="fldDescription" rows="10" cols="15"  style="width: 220px;"  class="txt"><?php echo $fldDescription; ?></textarea>
			</TD>
			</TR>
			<TR height="20">
			<TD valign="top" class="normalwhite_14" colspan="3" align="center">&nbsp;
			
			</TD>	
			</TR>
			<TR height="20">
			<TD valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red"></font></TD>
			<TD valign="top"  align="center" class="normalblack_12" > : </TD>
			<TD valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width: 220px;font-size:12px;">
			<option value=1 <?if($fldStatus==1){ echo "selected"; }?>>ACTIVE</option>
			<option value=0 <?if($fldStatus==0){ echo "selected"; }?>>DE-ACTIVE</option>
			
			</select></TD>
			</TR>
			<TR height="20">
			<TD valign="top" class="normalwhite_14" colspan="3" align="center">&nbsp;
			
			</TD></TR>
			
			<TR height="20">
			<TD valign="top" align="right" class="normalblack_12" width="30%">&nbsp</TD>
			<TD valign="top"  align="center" class="normalblack_12" > &nbsp</TD>
			<TD valign="top" align="left" class="normalblack_12">
			<input type="hidden" name="isSubmit" value="save">
			<input type="submit" name="submit" value="Submit">&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"></TD>
			</TR>
			
			<TR height="20">				
			<TD valign="top" colspan="3" align="center" class="normalblack_12" >&nbsp; </TD>
			</TR>
			
			<!-- Upoad File END-->
			</TABLE>
			</TD>
			</TR>
			</TABLE>
			</form>
		 <!--Main Center Content END -->
		</TD>
		</TR>
		</TABLE>
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