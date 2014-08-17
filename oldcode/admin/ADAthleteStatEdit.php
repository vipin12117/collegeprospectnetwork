<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Sanjay Chaudhary
##	Page name	:		ADPageEdit.php
##	Create Date	:		10106/2011
##  Description :		It is use to performe the operation for add/edit/delete for User.
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
	$query =" Select * from ".TBL_ATHELETE_STAT. " where fldId = '$fldId' ";
	

	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
		$fldPrograme              = $db->f('fldPrograme');
		
		$fldPerformanceType          = $db->f('fldPerformanceType');
		$fldPoints    = $db->f('fldPoints');
		$fldRebounds        = $db->f('fldRebounds');
		$fldAssist             = $db->f('fldAssist');

		$fldSteals             = $db->f('fldSteals');
		$fldStatus             = $db->f('fldStatus');
	}
}
else {
	    $fldPrograme              = "";
		$fldPerformanceType        = "";
		$fldPoints          = "";
		$fldRebounds    = "";
		$fldAssist       = "";
		$fldSteals             = "";
		$fldStatus		="";
}
if($_POST['isSubmit']=='save'){
	
	$where = "fldId='".$fldId."'";
        			//Update data
		$strDataArr=array(
		    'fldPrograme' 			=> $func->input_fun($_POST['fldPrograme']),
			'fldPerformanceType' 				=> $func->input_fun($_POST['fldPerformanceType']),
			'fldPoints' 		=> $func->input_fun($_POST['fldPoints']),
			'fldRebounds' 			=> $func->input_fun($_POST['fldRebounds']),
			'fldAssist' 				=> $func->input_fun($_POST['fldAssist']),
			'fldSteals' 				=> $func->input_fun($_POST['fldSteals']),'fldStatus' 				=> $func->input_fun($_POST['fldStatus']));

			$db->updateRec(TBL_ATHELETE_STAT,$strDataArr, $where);
			#redirect to listing page on successfull updation
			header("Location: ADAtheleteStateList.php?page=".$_REQUEST['page']."&msg=Athlete Stats Updated Successfully!");
		
	

	if($error_msg!=""){
		
	 $fldPrograme              = $_REQUEST['fldPrograme'];
		$fldPerformanceType        = $_REQUEST['fldPerformanceType'];
		$fldPoints          = $_REQUEST['fldPoints'];
		$fldRebounds    = $_REQUEST['fldRebounds'];
		$fldAssist       = $_REQUEST['fldAssist'];
		$fldSteals             = $_REQUEST['fldSteals'];
		$fldStatus		=$_REQUEST['fldStatus'];	

	}
}

 //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	
	var error_msg = "";
			

  

	 if(document.frmAthReg.fldPrograme.value == "select"){
		error_msg += "Please Select Programe! \n";
	}
	
	if(document.frmAthReg.fldPerformanceType.value == "select"){
		error_msg += "Please Select Performance Type! \n";
	}
		if(trimString(document.frmAthReg.fldPoints.value) == ""){
		error_msg += "Please Enter Points! \n";
	}
	
if(trimString(document.frmAthReg.fldRebounds.value) == ""){
		error_msg += "Please Enter Event Rebounds! \n";
	}
	
	if(trimString(document.frmAthReg.fldAssist.value) == ""){
		error_msg += "Please Enter Assist! \n";
	}
	
if(trimString(document.frmAthReg.fldSteals.value) == ""){
		error_msg += "Please Enter Steals! \n";
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
			<form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Edit Athlete Stat</b>
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
			<td valign="top" align="right" class="normalblack_12" width="30%">Game / Event<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			 <?php 
                                    $eventName=$func->selectTableOrder(TBL_EVENT,"fldEventId,fldEventName","fldEventId");
								
                                    ?>
                                    <select name="fldPrograme" style="width: 220px;">
                                    <option value="select">Select Programe</option>
                                <?php 
                                for ($i=0;$i<count($eventName);$i++) 
								{
									
									?>
									<option value="<?php echo $eventName[$i]['fldEventId']; ?>" <?php if($eventName[$i]['fldEventId']==$fldPrograme){?>selected<?php } ?>><?php echo $eventName[$i]['fldEventName']; ?></option>
									<?php
								
								}
                                ?>
                                    </select>
			
             </td>
			</tr>

			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
						
						<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Stat Type<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			 <select name="fldPerformanceType" style="width: 220px;">
                                    <option value="select">Select Type</option>
                                    <option value="Academic Stat" <?php if($fldPerformanceType=='Academic Stat'){?>selected <?php } ?>>Academic Stat</option>
                                    <option value="Professional Stat" <?php if($fldPerformanceType=='Athlete Stat'){?>selected <?php } ?>>Athlete Stat</option>
                                    </select>
			</td>
			</tr>
				<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
						</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Point<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<input type="text" name="fldPoints" value="<?=$fldPoints?>"  style="width: 220px;">
			
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Rebounds<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldRebounds" value="<?=$fldRebounds?>"  style="width:220px;"/>			
             
			</td>
			</tr>
			<tr height="20">
			<td align="center" valign="top" colspan="3" class="normalwhite_14">
			&nbsp;
			</td>
			</tr>	
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Assist<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldAssist" value="<?=$fldAssist?>"  style="width: 220px;"></td>
			</tr>
			
			
			<tr height="20">
			<td align="center" valign="top" colspan="3" class="normalwhite_14">
			&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Steals<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldSteals" value="<?=$fldSteals?>"  style="width: 220px;"></td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">  <select name="fldStatus" style="width: 220px;">
                                    <option value="select">Select Type</option>
                                    <option value="0" <?php if($fldPerformanceType==0){?>selected <?php } ?>>Pending</option>
                                    <option value="1" <?php if($fldPerformanceType==1){?>selected <?php } ?>>Approved</option></td>
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