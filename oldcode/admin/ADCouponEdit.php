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
$tbl_coupon='tbl_cupon';
$Couponid = $_GET['id'];
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
if($_GET['mode']=='edit' AND $Couponid!=""){
	#get the records
	$query =" Select * from ".$tbl_coupon. " where id =".$Couponid;
	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
			$coupon_name=$func->output_fun($db->f('cpn_number'));
			$discount_amount = $func->output_fun($db->f('amount'));
			$StartDate = $func->output_fun($db->f('start_date'));
			$EndDate = $func->output_fun($db->f('end_date'));
			$event_id1  = $func->output_fun($db->f('event_id'));
			$Status = $func->output_fun($db->f('Status'));
	}
}
else {
		    $coupon_name="";
			$discount_amount = "";
			$StartDate ="";
			$EndDate = "";
			$event_id="";
			$Status = "";
		

	}
if($_POST['isSubmit']=='save'){
	
	$where = "id=".$Couponid;
        			//Update data
			$strDataArr=array(
		     'cpn_number' 				=> $func->input_fun($_POST['coupon_name']),
			 'amount' 				=> $func->input_fun($_POST['discount_amount']),
			 'start_date' 				=> $func->input_fun($_POST['StartDate']),
		     'end_date' 		=> $func->input_fun($_POST['EndDate']),
			 'event_id' 		=> $func->input_fun($_POST['event_id']),
		     'status' 		=> $func->input_fun($_POST['Status'])
			 			);

			$db->updateRec($tbl_coupon,$strDataArr, $where);
			#redirect to listing page on successfull updation
		header("Location: ADCouponManage.php?page=".$_REQUEST['page']."&msg=Coupon Updated Successfully!");
	if($error_msg!=""){
		$coupon_name  = $_REQUEST['cpn_number'];
		$discount_amount	=$_REQUEST['discount_amount'];
		$StartDate      = $_REQUEST['StartDate'];
		$EndDate        = $_REQUEST['EndDate'];
		$event_id        = $_REQUEST['event_id'];
		$Status = $_REQUEST['status'];
	}
}

 //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	
	var error_msg = "";
	
		//var blnResult = true;

     if(trimString(document.frmEvent.coupon_name.value) == ""){
		error_msg += "Please Enter Coupon Number! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmEvent.discount_amount.value)){
			error_msg += "Enter valid Discount Amount! \n";
		}
	}

	if(trimString(document.frmEvent.StartDate.value) == ""){
		error_msg += "Please Enter Start Date! \n";
	}
	if(trimString(document.frmEvent.EndDate.value) == ""){
		error_msg += "Please Enter Event End Date! \n";
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
				<b>Edit Coupon Information</b>
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
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			<tr height="20" id="txtEvent">
			<td valign="top" align="right" class="normalblack_12" width="30%">Special Event<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<select name="event_id" id="event_id" style="width:220px;">
				<option value="">Select Event</option>
			<?php 
			$EventList = $func -> selectTableOrder(TBL_SPECIAL_EVENT, "fldEventId,fldEventName", "fldEventId");
			for ($i = 0; $i < count($EventList); $i++) {?>
			<option value ="<?php echo $EventList[$i]['fldEventId']; ?>"<?php if($EventList[$i]['fldEventId']==$event_id1){?> selected="selected" <?php }?>><?php echo $EventList[$i]['fldEventName'] ?></option>
			<?php }?>
		</select>
			</td>
			</tr>
			</tr>		
			
			<tr height="20">
			<tr height="20" id="txtEvent">
			<td valign="top" align="right" class="normalblack_12" width="30%">Coupon Name <font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="coupon_name" id="coupon_name" value="<?=$coupon_name?>" maxlength="30" style="width: 220px;">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			
			</td>	
<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Discount Amount<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><input type="text" name="discount_amount" id="discount_amount" value="<?=$discount_amount?>" maxlength="30" style="width: 220px;"></td>
			</tr>
			<?php /*?><tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Start Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
									<input type="text"  style="float: left;width:200;" class="datetimepicker_es"  id="StartDate" name="StartDate" autocomplete="off" value="<? if($StartDate){echo $StartDate;}else{echo date("Y-m-d 19:30");}?>" >

			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">End Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
									<input type="text"  style="float: left;width:200;" class="datetimepicker_es"  id="EndDate" name="EndDate" autocomplete="off" value="<? if($EndDate){echo $EndDate;}else{echo date("Y-m-d 19:30");}?>" >

			</td>
			</tr><?php */?>
			<tr><td>&nbsp;</td></tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status <font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<select name="Status" id="Status" style="width: 220px;font-size:12px;">
				<option value="1" <?php if($Status=="1"){ echo "selected"; }?>>ACTIVE</option>
				<option value="0" <?php if($Status=="0"){ echo "selected"; }?>>DEACTIVE</option>
			</select></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
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