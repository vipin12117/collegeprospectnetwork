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
$fldEventStatus=1;

if($_POST['isSubmit']=='save'){

		/* Validation Area Start*/
		hb_php_validate($_POST['fldEventName'],"Please Enter Special Event Name!");
		hb_php_validate($_POST['fldEventLocation'],"Please Enter Special Event Loacation!");
		hb_php_validate($_POST['fldEventStartDate'],"Please Enter Special Event Start Date!");
		hb_php_validate($_POST['fldEventcurrentprice'],"Please Enter Special Event Current Price!");
		hb_php_validate($_POST['fldEventfutureprice'],"Please Enter Special Event Future Price!");
		hb_php_validate($_POST['Early_Discount_day'],"Please Enter Early Discount Day!");
		hb_php_validate($_POST['Early_discount_rate'],"Please Enter Early Discount Price!");
		hb_php_validate($_POST['Transcript_discount'],"Please Enter Transcript Discount Price!");
		/* Validation Area End*/
        //Edit the user info
		$fldEventName   	     = $func->input_fun($_POST['fldEventName']);
		/*$fldSport					=$func->input_fun($_POST['fldSport']);*/
		$fldEventDescription     = $func->input_fun($_POST['fldEventDescription']);
		$fldEventLocation        = $func->input_fun($_POST['fldEventLocation']);
		$fldEventStartDate 		 = $func->input_fun($_POST['fldEventStartDate']);
		$fldEventcurrentprice 	 = $func->input_fun($_POST['fldEventcurrentprice']);
		$fldEventfutureprice 	 = $func->input_fun($_POST['fldEventfutureprice']);
		$Early_Discount_day 	 = $func->input_fun($_POST['Early_Discount_day']);
		$Early_discount_rate 	 = $func->input_fun($_POST['Early_discount_rate']);
		$Transcript_discount 	 = $func->input_fun($_POST['Transcript_discount']);
		/*$fldEventEndDate 		 = $func->input_fun($_POST['fldEventEndDate']);*/
		/*$fldHomeTeam 		 = $func->input_fun($_POST['fldHomeTeam']);
		$fldAwayTeam 		 = $func->input_fun($_POST['fldAwayTeam']);*/
		$fldEventStatus      	 = $func->input_fun($_POST['fldEventStatus']);
		
		$cur_price=$_POST['fldEventcurrentprice'];
		$future_price=$_POST['fldEventfutureprice'];
		if($cur_price>$future_price)
		{  $evnt_price=$future_price;}
		else
		{ $evnt_price=$cur_price; }
		if($evnt_price<$_POST['Early_discount_rate'])
		{
		?><script type="text/javascript">
			alert("Please Enter Current Price Larger then Early Registration Discount!");
			window.history.go(-1);
			</script>
		<?php exit;}
		if($evnt_price<$_POST['Transcript_discount'])
		{?><script type="text/javascript">
			alert("Please Enter Current Price Larger then Transcript Discount!");
			window.history.go(-1);
			</script>
		<?php exit;}
		
        if($flag==0){
        	
			//Insert data
		     $strDataArr=array(
		     'fldEventName' 			=> $func->input_fun($_POST['fldEventName']),
			 'fldEventDescription' 		=> $func->input_fun($_POST['fldEventDescription']),
			 'fldEventLocation' 			=> $func->input_fun($_POST['fldEventLocation']),
		     'fldEventStartDate' 		=> $func->input_fun($_POST['fldEventStartDate']),
			 'fldEventcurrentprice'	 	=> $func->input_fun($_POST['fldEventcurrentprice']),
			 'fldEventfutureprice'	 	=>$func->input_fun($_POST['fldEventfutureprice']),
			 'Early_Discount_day'	 	=>$func->input_fun($_POST['Early_Discount_day']),
			 'Early_discount_rate'	 	=>$func->input_fun($_POST['Early_discount_rate']),
			 'Transcript_discount'	 	=>$func->input_fun($_POST['Transcript_discount']),
		     'fldEventStatus' 		=> $func->input_fun($_POST['fldEventStatus']),
			 'fld_UserType'=>'admin'
						);
						

	 		$db->insertRec(TBL_SPECIAL_EVENT,$strDataArr);
       
			#redirect to listing page on successfull updation
			
			header("Location: ADSpecialEventList.php?msg=Special Event is Added Successfully ");
		}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		
		
		
		

		$fldEventName        = $_REQUEST['fldEventName'];
		
		$fldSport		=$_REQUEST['fldSport'];
		$fldEventDescription      = $_REQUEST['fldEventDescription'];
		$fldEventLocation        = $_REQUEST['fldEventLocation'];
		$fldEventStartDate = $_REQUEST['fldEventStartDate'];
		$fldEventEndDate = $_REQUEST['fldEventEndDate'];
		$fldHomeTeam=$_REQUEST['fldHomeTeam'];
		$fldAwayTeam=$_REQUEST['fldAwayTeam'];
		$fldEventcurrentprice 	 = $func->input_fun($_POST['fldEventcurrentprice']);
		$fldEventfutureprice 	 = $func->input_fun($_POST['fldEventfutureprice']);
		$Early_Discount_day 	 = $func->input_fun($_POST['Early_Discount_day']);
		$Early_discount_rate 	 = $func->input_fun($_POST['Early_discount_rate']);
		$Transcript_discount 	 = $func->input_fun($_POST['Transcript_discount']);
		$fldEventStatus      = $_REQUEST['fldEventStatus'];
		

	}


} //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	var error_msg = "";
	
	if(trimString(document.frmEvent.fldEventName.value) == ""){
		alert("Please Enter Special Event Name!");
		return false;
		document.frmEvent.fldEventName.focus();
		/*error_msg += "Please Enter Special Event Name! \n";*/
	}
	if(trimString(document.frmEvent.fldEventLocation.value) == ""){
		alert("Please Enter Special Event Loacation!");
		return false;
		document.frmEvent.fldEventLocation.focus();
		/*error_msg += "Please Enter Special Event Loacation! \n";*/
	}

	if(document.frmEvent.fldEventcurrentprice.value == ""){
		alert("Please Enter Special Event Current Price!");
		return false;
		document.frmEvent.fldEventcurrentprice.focus();
		/*error_msg += "Please Enter Special Event Current Price! \n";*/
	}
	else
	{
		var cur_price=parseInt(document.frmEvent.fldEventcurrentprice.value);
		var tranc_disc=parseInt(document.frmEvent.Transcript_discount.value);
		var early_disc=parseInt(document.frmEvent.Early_discount_rate.value);
		if(cur_price < early_disc)
		{
			alert("Please Enter Current Price Larger then Early Register Discount!");
			return false;
			document.frmEvent.Transcript_discount.focus();
		}
		else if(cur_price<tranc_disc)
		{
			alert("Please Enter Current Price Larger then Transcript Discount!");
			return false;
			document.frmEvent.Transcript_discount.focus();
		}
	}

	if(document.frmEvent.fldEventfutureprice.value == ""){
		alert("Please Enter Special Event Future Price!");
		return false;
		document.frmEvent.fldEventfutureprice.focus();
		/*error_msg += "Please Enter Special Event Future Price! \n";*/
	}
	else
	{
		var future_price=parseInt(document.frmEvent.fldEventfutureprice.value);
		var tranc_disc=parseInt(document.frmEvent.Transcript_discount.value);
		var early_disc=parseInt(document.frmEvent.Early_discount_rate.value);
		
		if(future_price < early_disc)
		{
			alert("Please Enter Future Price Larger then Early Register Discount!");
			return false;
			document.frmEvent.Early_discount_rate.focus();
		}
		else if(future_price<tranc_disc)
		{
			alert("Please Enter Future Price Larger then Transcript Discount!");
			return false;
			document.frmEvent.Transcript_discount.focus();
		}
	}
	if(document.frmEvent.Early_Discount_day.value == ""){
		alert("Please Enter Early Discount Day!");
		return false;
		document.frmEvent.Early_Discount_day.focus();
		/*error_msg += "Please Enter Special Event Future Price! \n";*/
	}
	if(document.frmEvent.Early_discount_rate.value == ""){
		alert("Please Enter Early Discount Price!");
		return false;
		document.frmEvent.Early_discount_rate.focus();
		/*error_msg += "Please Enter Special Event Future Price! \n";*/
	}
	else
	{
		var cur_price=parseInt(document.frmEvent.fldEventcurrentprice.value);
		var future_price=parseInt(document.frmEvent.fldEventfutureprice.value);
		var early_disc=parseInt(document.frmEvent.Early_discount_rate.value);
		//alert(cur_price+"  hh "+future_price+ " bv " +early_disc);return false;
		if(cur_price > future_price)
		{
			calc_price = future_price;
		}
		else
		{
			calc_price = cur_price;
		}
		if(early_disc > calc_price)
		{
			alert("Please Enter Early Discount Price Smaller then Event Price!");
			return false;
			document.frmEvent.Early_discount_rate.focus();
		}
	}
	
	if(document.frmEvent.Transcript_discount.value == ""){
		alert("Please Enter Transcript Discount Price!");
		return false;
		document.frmEvent.Transcript_discount.focus();
		/*error_msg += "Please Enter Special Event Future Price! \n";*/
	}
	else
	{
		var cur_price=parseInt(document.frmEvent.fldEventcurrentprice.value);
		var future_price=parseInt(document.frmEvent.fldEventfutureprice.value);
		var tranc_disc=parseInt(document.frmEvent.Transcript_discount.value);
		
		if(cur_price > future_price)
		{
			calc_price = future_price;
		}
		else
		{
			calc_price = cur_price;
		}
		if(tranc_disc > calc_price)
		{
			alert("Please Enter Transcript Discount Price Smaller then Event Price!");
			return false;
			document.frmEvent.Transcript_discount.focus();
		}
	}	
	if(trimString(document.frmEvent.fldEventStartDate.value) == ""){
		alert("Please Enter Special Event Start Date!");
		return false;
		document.frmEvent.fldEventStartDate.focus();
		/*error_msg += "Please Enter Special Event Start Date! \n";*/
	}
	
	/*if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
				return true;
		}*/

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
	{
	var xmlhttp;
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
<TABLE cellSpacing="0" cellPadding="0" width="100%" border="0">
<TR>
<TD height=120>
<?php include "include/ADheader.php";?>
</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TR>
<TD class="heading">
<TABLE cellSpacing="0" cellPadding="1" width="95%" align="center" border="0">
<TR>
<TD>
	<TABLE cellSpacing="0" cellPadding="1" width="780" border="0">
	<TR>
	<TD bgColor=#ffffff>
		<TABLE cellSpacing=0 cellPadding=0 width=900 border=0>
		<TR>
		<TD vAlign="top" width="20%">
			<?php include "include/ADmenu.php";?>
		</TD>
		<TD valign="top" width="1%">&nbsp;
		
		</TD>
		<TD width="10"><img src="spacer.gif" height="1" width="1">
		</TD>
		<TD valign="top" width="" align="center">
<!-- MAin Content Starts From Here -->
			<form name="frmEvent" action="" method="post" enctype="multipart/form-data" id="frmEvent" onSubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Add Event</b>
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
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			
			</td>
			</tr>		
			
			<!--</select></td></tr>-->
			
			<tr height="20" id="txtEvent">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Name <font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldEventName" id="fldEventName" value="<?=$fldEventName?>" style="width: 220px;">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			</tr>

			<tr height="20" id="txtHint">
			<td valign="top" align="right" class="normalblack_12" width="30%">Location<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<?php  $query ="Select * from ".TBL_HS_AAU_TEAM. " where fldId =".$_REQUEST['homeTeamid'];
	
if(($_REQUEST['homeTeamid'])and ($_REQUEST['homeTeamid']!='select'))
			{
	$db->query($query);
	$db->next_record();
	$location=$db->f('fldAddress');
			}
	?>
			<td valign="top" align="left" class="normalblack_12"> <textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="15"  style="width: 220px;"  ><?php if($location) {echo $location; }?></textarea></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Detail<font color="red"> </font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><textarea name="fldEventDescription" id="fldEventDescription" rows="10" cols="15"  style="width: 220px;"  class="txt"><?php echo $fldEventDescription; ?></textarea></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Price (Early Graduation Year)<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text" style="float: left;width:220px;" id="fldEventcurrentprice" name="fldEventcurrentprice" value="" onKeyPress="return isNumber(event)"/>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Price (Future Graduation Year)<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text"  style="float: left;width:220px;" name="fldEventfutureprice" id="fldEventfutureprice" value="" onKeyPress="return isNumber(event)"/>
			</td>
			</tr>
			
			
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Early Discount Day<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<select name="Early_Discount_day" id="Early_Discount_day" style="width:180px;">
				<option value="">Select Early Discount Day</option>
				<?php 
				for($i=1;$i<=31;$i++){
				?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php } ?>
			</select>
			</td>
			</tr>
			
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Early Discount Price<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text"  style="float: left;width:220px;" name="Early_discount_rate" id="Early_discount_rate" value="" onKeyPress="return isNumber(event)"/>
			</td>
			</tr>
			
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Transcript Discount Price<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text"  style="float: left;width:220px;" name="Transcript_discount" id="Transcript_discount" value="" onKeyPress="return isNumber(event)"/>
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text"  style="float: left;width:200;" class="datetimepicker_es" name="fldEventStartDate" id="fldEventStartDate" autocomplete="off" value="<? if($fldEventStartDate){echo $fldEventStartDate;}else{echo date("Y-m-d 19:30");}?>" >
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			</td>
			</tr>
			<?php /*?><tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event End Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
									<input type="text"  style="float: left;width:200;" class="datetimepicker_es"  id="fldEventEndDate" name="fldEventEndDate" autocomplete="off" value="<? if($fldEventEndDate){echo $fldEventEndDate;}else{ echo date("y-m-d 20:30");}?>">

			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr><?php */?>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status <font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<select name="fldEventStatus" style="width: 220px;font-size:12px;">
				<option value="1" <?php if($fldEventStatus==1){ echo "selected"; }?>>ACTIVE</option>
				<option value="0" <?php if($fldEventStatus==0){ echo "selected"; }?>>FULL</option>
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
			<input type="submit" name="submit" value="Submit">&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"></td>
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