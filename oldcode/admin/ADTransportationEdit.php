<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Sanjay Chaudhary
##	Page name	:		ADCatagoryEdit.php
##	Create Date	:		10106/2011
##  Description :		It is use to performe the operation for edit for Catagory Information.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				//for admin login

$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "2";
$error_msg = '';
$flag = 0;
$tbl_transportation_discount='tbl_transportation_discount';
$id = $_GET['id'];
$fldEventId=$_REQUEST['fldEventId'];
/*if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
{
	echo $q="select * from '".$tbl_coupon."' where id='".$Couponid."'";
			
	$db->query($q);
	if ($db->num_rows()>0) {
		while($db->next_record())
		{	echo $coupon_name=$func->output_fun($db->f('cpn_number'));
			echo $discount_amount = $func->output_fun($db->f('amount'));
			$StartDate = $func->output_fun($db->f('StartDate'));
			$EndDate = $func->output_fun($db->f('EndDate'));
			$Status = $func->output_fun($db->f('Status'));
		}
	}
}*/
if($_GET['mode']=='edit' AND $id!=""){
	#get the records
	$query =" Select * from ".$tbl_transportation_discount. " where id =".$id;
	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
			$id               	= $func->output_fun($db->f('id'));
			$Event_id         	= $func->output_fun($db->f('Event_id'));
			$Diparture_City  	= $func->output_fun($db->f('Diparture_City'));
			$Departure_Time1  	= $func->output_fun($db->f('Departure_Time'));
			$Time=explode(":",$Departure_Time1);
			$hour=$Time[0];
			$option1=explode(" ",$Time[1]);
			$minute=$option1[0];
			$option=$option1[1];
			$Transportation_charge = $func->output_fun($db->f('Transportation_charge'));		
			$status 			= $func->output_fun($db->f('status'));	
	}
}
else {
		    $id="";
			$Event_id = "";
			$Diparture_City ="";
			$Departure_Time = "";
			$Transportation_charge="";
			$status = "";
		

	}
if($_POST['isSubmit']=='save'){
	
	$where = "id=".$id;
        			//Update data
			$strDataArr=array(
		     'Event_id' 					=> $func->input_fun($_POST['Event_id']),
			 'Diparture_City' 				=> $func->input_fun($_POST['Diparture_City']),
			 'Departure_Time' 				=> $func->input_fun($_POST['hours'].":".$_POST['minute']." ".$_POST['option']),
		     'Transportation_charge' 		=> $func->input_fun($_POST['Transportation_charge']),
			 'status' 						=> $func->input_fun($_POST['status']));
			$db->updateRec($tbl_transportation_discount,$strDataArr, $where);
			#redirect to listing page on successfull updation
		header("Location: ADTransportationManage.php?page=".$_REQUEST['page']."&msg=Transportation Discount Updated Successfully!");
	if($error_msg!=""){
		$Event_id  			   = $_REQUEST['Event_id'];
		$Diparture_City		   = $_REQUEST['Diparture_City'];
		$Departure_Time        = $_POST['hours'].":".$_POST['minute']." ".$_POST['option'];
		$Transportation_charge = $_REQUEST['Transportation_charge'];
		$Status 			   = $_REQUEST['status'];
	}
}

 //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	function validate(){
	if(trimString(document.frmtransport.Event_id.value) == ""){
		alert("Please Enter Event!");
		return false;
		document.frmtransport.Event_id.focus();
	}
	if(trimString(document.frmtransport.Diparture_City.value) == ""){
		alert("Please Enter Diparture City!");
		return false;
		document.frmtransport.Diparture_City.focus();
	}
	
	if(trimString(document.frmtransport.hours.value) == ""){
		alert("Please Enter Departure Hour!");
		return false;
		document.frmtransport.hours.focus();
	}
	if(trimString(document.frmtransport.minute.value) == ""){
		alert("Please Enter Departure Minute!");
		return false;
		document.frmtransport.minute.focus();
	}
	if(trimString(document.frmtransport.option.value) == ""){
		alert("Please Enter AM/PM!");
		return false;
		document.frmtransport.option.focus();
	}
	
	if(trimString(document.frmtransport.Transportation_charge.value) == ""){
		alert("Please Enter Transportation Charge!");
		return false;
		document.frmtransport.Transportation_charge.focus();
	}
}
</script>
<HTML><HEAD><TITLE>Transportation Discount</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="images/main.css">
					<script type="text/javascript" language="javascript" src="../Date Time Picker/images/prototype-1.js"></script>
			<script type="text/javascript" language="javascript" src="../Date Time Picker/images/prototype-base-extensions.js"></script>
			<script type="text/javascript" language="javascript" src="../Date Time Picker/images/prototype-date-extensions.js"></script>
			<script type="text/javascript" language="javascript" src="../Date Time Picker/images/behaviour.js"></script>
							<script type="text/javascript" language="javascript" src="../Date Time Picker/images/datepicker.js"></script>
										<link rel="stylesheet" href="../Date Time Picker/images/datepicker.css">
							<script type="text/javascript" language="javascript" src="../Date Time Picker/images/behaviors.js"></script>

<script language="Javascript" src="../javascript/functions.js">
</script>
<script language="Javascript" src="../javascript/functions.js">
</script>

<script type="text/javascript">

	
	function formsubmit_location(str)
	{	var xmlhttp;
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getlocation.php?q="+str,true);

xmlhttp.send();
		
	}
	
	function formsubmit_Event(str)
	{
		
		
		var xmlhttp;
if (str.length==0)
  {
  document.getElementById("txtEvent").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtEvent").innerHTML=xmlhttp.responseText;
  
    }
  }


xmlhttp.open("GET","getevent.php?q="+str+"&HomeTeam="+document.getElementById('fldHomeTeam').options[document.getElementById('fldHomeTeam').selectedIndex].text+"&AwayTeam= "+document.getElementById('fldAwayTeam').options[document.getElementById('fldAwayTeam').selectedIndex].text,true);

xmlhttp.send();
		
	}
function isNumber(evt) {
evt = (evt) ? evt : window.event;
var charCode = (evt.which) ? evt.which : evt.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	return false;
}
return true;
}
</script>
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
		<TD valign=top width=1%>&nbsp;
		
		</TD>
		<TD width=10><img src="spacer.gif" height="1" width="1">
		</TD>
		<TD valign=top width="" align="center">
<!-- MAin Content Starts From Here -->
			<form name="frmEvent" action="" method="post" enctype="multipart/form-data" onSubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Edit Transportation Discount Information</b>
			</td>
			</tr>
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" colspan=3 align="center">&nbsp;
			
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
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			</td>
			<tr height="20" id="txtEvent">
			<td valign="top" align="right" class="normalblack_12" width="30%">Special Event<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<select name="Event_id" id="Event_id" style="width:220px;">
				<option value="">Select Event</option>
			<?php 
			$EventList = $func -> selectTableOrder(TBL_SPECIAL_EVENT, "fldEventId,fldEventName", "fldEventId");
			for ($i = 0; $i < count($EventList); $i++) {?>
			<option value ="<?php echo $EventList[$i]['fldEventId']; ?>"<?php if($EventList[$i]['fldEventId']==$Event_id){?> selected="selected" <?php }?>><?php echo $EventList[$i]['fldEventName'] ?></option>
			<?php }?>
		</select>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			<tr height="20" id="txtEvent">
			<td valign="top" align="right" class="normalblack_12" width="30%">Diparture City <font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="Diparture_City" id="Diparture_City" value="<?=$Diparture_City?>" maxlength="30" style="width: 220px;">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			</td>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Departure Time<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
			<select name="hours" id="hours">
				<option value="">Select Hours</option>
				<?php for($i=1;$i<=12;$i++){
					if($i<10)
					{ $i="0".$i;}?>
				<option value="<?php echo $i;?>" <?php if($i==$hour){?> selected="selected" <?php }?>><?php echo $i;?></option>
				<?php } ?>
			</select>
			<select name="minute" id="minute">
				<option value="">Select Minute</option>
				<?php for($i=1;$i<=60;$i++){
					if($i<10)
					{ $i="0".$i;}?>
				<option value="<?php echo $i;?>"<?php if($i==$minute){?> selected="selected" <?php }?>><?php echo $i;?></option>
				<?php } ?>
			</select>
			<select name="option" id="option">
				<option value="">Select AM/PM</option>
				<option value="AM" <?php if($option=='AM'){?> selected="selected" <?php }?>>AM</option>
				<option value="PM" <?php if($option=='PM'){?> selected="selected" <?php }?>>PM</option>
			</select><?php /*?><input type="text" name="Departure_Time" id="Departure_Time" value="<?=$Departure_Time?>" style="width: 220px;"><?php */?></td>
			</tr>
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			</td>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Transportation Charge<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><input type="text" name="Transportation_charge" id="Transportation_charge" value="<?=$Transportation_charge?>" style="width: 220px;" onKeyPress="return isNumber(event)"></td>
			</tr>
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status <font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<select name="status" id="status" style="width: 220px;font-size:12px;">
				<option value="1" <?php if($Status=="1"){ echo "selected"; }?>>ACTIVE</option>
				<option value="0" <?php if($Status=="0"){ echo "selected"; }?>>DEACTIVE</option>
			</select></td>
			</tr>
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" >&nbsp; </td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">&nbsp</td>
			<td valign="top"  align="center" class="normalblack_12" > &nbsp</td>
			<td valign="top" align="left" class="normalblack_12">
			<input type="hidden" name="isSubmit" value="save">
			<input type="submit" name="submit" value="Submit"><!--&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset">--></td>
			</tr>
			
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" >&nbsp; </td>
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