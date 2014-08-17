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

        //Insert the block message info
		$fldFrom         = $func->input_fun($_POST['fldFrom']);
		$fldSport        = $func->input_fun($_POST['fldSport']);
		$fldTo           = $func->input_fun($_POST['fldTo']);
		$fldStartdate    = $func->input_fun($_POST['fldStartdate']);
		$fldEndDate      = $func->input_fun($_POST['fldEndDate']);
		$fldStatus       = $func->input_fun($_POST['fldStatus']);
		

	
        if($flag==0){
       	//Insert data
		     $strDataArr=array(
		     
			'fldFrom' 			=> $func->input_fun($_POST['fldFrom']),
			'fldSport'    		=> $func->input_fun($_POST['fldSport']),
			'fldTo' 		    => $func->input_fun($_POST['fldTo']),
			'fldStartdate' 	    => $func->input_fun($_POST['fldStartdate']),
			'fldEndDate' 		=> $func->input_fun($_POST['fldEndDate']),
			'fldStatus' 		=> $func->input_fun($_POST['fldStatus'])
					);
						

	 		$db->insertRec(TBL_BLOCK_MESSAGE,$strDataArr);
     
			#redirect to listing page on successfull updation
			
			header("Location: ADBlockMessageList.php?msg=You have Successfully Block Messaging between the selected Criteria ");
		}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		$fldFrom        = $_REQUEST['fldFrom'];
		$fldSport       = $_REQUEST['fldSport'];
		$fldTo	        = $_REQUEST['fldTo'];
		$fldStartdate   = $_REQUEST['fldStartdate'];
		$fldEndDate     = $_REQUEST['fldEndDate'];
		$fldStatus      = $_REQUEST['fldStatus'];

	}


} //END if submit

?>

<script language="JavaScript" type="text/JavaScript">


function validate()
{
	var error_msg = "";
	var blnResult = true;

	
	if(trimString(document.frmUsers.fldFrom.value) == "")
	{
		    error_msg += "Please Select From! \n";
	}
	else
	{
		if(hasSpecialCharaters(document.frmUsers.fldFrom.value))
		{
			error_msg += "Please Select From! \n";
		}
	}
	

	
	 if(trimString(document.frmUsers.fldSport.value) == "")
	{
			error_msg += "Please Select Sport! \n";
	}
	else
	{
		if(hasSpecialCharaters(document.frmUsers.fldSport.value))
		{
			error_msg += "Please Select Sport! \n";
		}
	}
	
	
	
	
	
	if(trimString(document.frmUsers.fldTo.value) == "")
	{
			error_msg += "Please Select To value! \n";
	}
	
	else
	{
		if(hasSpecialCharaters(document.frmUsers.fldTo.value))
		{
			error_msg += "Please Select To value! \n";
		}
	}
	
	
	
   if(trimString(document.frmUsers.fldStartdate.value) == "")
	{
			error_msg += "Please Select Start date! \n";
	}
	
		else
	{
		if(hasSpecialCharaters(document.frmUsers.fldStartdate.value))
		{
			error_msg += "Please Select Start date! \n";
		}
	}
	
	
	
	if(trimString(document.frmUsers.fldEndDate.value) == "")
	{
		
			error_msg += "Please Select End date! \n";
	}
	
		else
	{
		if(hasSpecialCharaters(document.frmUsers.fldEndDate.value))
		{
			error_msg += "Please Select End date! \n";
		}
	}
	
	
	
	    var currentTime = new Date()
		var month = currentTime.getMonth() + 1
		var day = currentTime.getDate()
		var year = currentTime.getFullYear()  
		
		
		
	if(document.frmUsers.fldStartdate.value != (year + "-" + month + "-" +  day))
	{
		error_msg += "Start Date should be same as current date \n";
	}
	
	
	if(document.frmUsers.fldStartdate.value > document.frmUsers.fldEndDate.value)
	{
		error_msg += "End date Should be greater than Start Date \n";
	}
	
	
	
    if(trimString(document.frmUsers.fldStatus.value) == ""){
		error_msg += "Please Select status! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldStatus.value)){
			error_msg += "Enter Select status! \n";
		}
	}
	
	


	if(error_msg!='')
	{
	alert(error_msg);
		return false;
	}
	else
	{
		return true;
	}
}
</script>

 



<HTML><HEAD><TITLE>Block Message</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>

<script type='text/javascript' src='../javascript/zapatec/utils/zapatec.js'></script>
		<script type="text/javascript" src="../javascript/zapatec/zpcal/src/calendar.js"></script>
		<script type="text/javascript" src="../javascript/zapatec/zpcal/lang/calendar-en.js"></script>
		<link href="../javascript/zapatec/zpcal/themes/aqua.css" rel="stylesheet" type="text/css">
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
				<b>Message Blocking</b>
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
			<td valign="top" align="right" class="normalblack_12" width="30%">From<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
			<SELECT NAME="fldFrom" style="width:200px"><OPTION VALUE="">----Please Select---</OPTION>
		    <OPTION VALUE="college">College Coaches</OPTION>
		    <OPTION VALUE="coach">HS/AAU Coaches</OPTION>
		    </SELECT>		
		    </td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Sport<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
			
			
			
			
			<?php  
			echo $strcombo = '<select name="fldSport" style="width:200px">';
			echo $strcombo = '<option value = "">Select Sport</option>';
			$categorylist=$func->selectTableOrder(tbl_sports,"fldId,fldSportsname","fldId");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
  		    echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldSportsname'].'</option>';
            }
			echo $strcombo = '</select>';
			?>
			
			</td>
		</tr>
		<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">To<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
			<SELECT NAME="fldTo" style="width:200px"><OPTION VALUE="">----Please Select---</OPTION>
		    <OPTION VALUE="athlete">Athlete</OPTION>
		    </SELECT>		
		    </td>
		    </tr>
		
		
		
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
							<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Start Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text"  style="float: left;width:200px;" class="input_L"  id="fldStartdate" name="fldStartdate" autocomplete="off" value="<?=$fldStartdate?>"">
            <img style="float: left; padding-right: 5px; margin-top: -2px;" alt="" src="images/icon-calender.png" name="button2" id="button2">
				<script type="text/javascript">
					var cal = new Zapatec.Calendar.setup({
					
					inputField     :    "fldStartdate",     // id of the input field
					singleClick    :     true,     // require two clicks to submit
					ifFormat       :    '%Y-%m-%d',     // format of the input field
					showsTime      :     true,     // show time as well as date
					button         :    "button2"  // trigger button 
					});
				</script>

			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">End Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
		   <input type="text"  style="float: left;width:200px;" class="input_L"  id="fldEndDate" name="fldEndDate" autocomplete="off" value="<?=$fldEndDate?>"">
           <img style="float: left; padding-right: 5px; margin-top: -2px;" alt="" src="images/icon-calender.png" name="button3" id="button3">
				<script type="text/javascript">
					var cal = new Zapatec.Calendar.setup({
					
					inputField     :    "fldEndDate",     // id of the input field
					singleClick    :     true,     // require two clicks to submit
					ifFormat       :    '%Y-%m-%d',     // format of the input field
					showsTime      :     true,     // show time as well as date
					button         :    "button3"  // trigger button 
					});
				</script>

			</td>
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
			
			<option value="blocked" <?if($status=='blocked'){ echo "selected"; }?>>Blocked</option>
			<option value="unblocked" <?if($status=='unblocked'){ echo "selected"; }?>>UnBlocked</option>
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
			<input type="submit" name="submit" value="Submit"></td>
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