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
$fldEventId = $_GET['fldEventId'];
if($_GET['mode']=='edit' AND $fldEventId!=""){
	#get the records
	$query =" Select * from ".TBL_SPECIAL_EVENT. " where fldEventId =".$fldEventId;
	

	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
		
				
		$fldEventName        	= $db->f('fldEventName');
		$fldSport				= $db->f('fldSport');
		$fldEventDescription    = $db->f('fldEventDescription');
		$fldEventLocation       = $db->f('fldEventLocation');
		$fldEventStartDate 		= $db->f('fldEventStartDate');
		$fldEventEndDate 		= $db->f('fldEventEndDate');
		$fldHomeTeam			= $db->f('fldHomeTeam');
		$fldAwayTeam			= $db->f('fldAwayTeam');
		$fldEventcurrentprice 	= $db->f('fldEventcurrentprice');
		$fldEventfutureprice 	= $db->f('fldEventfutureprice');
		$Early_Discount_day 	= $db->f('Early_Discount_day');
		$Early_discount_rate 	= $db->f('Early_discount_rate');
		$Transcript_discount 	= $db->f('Transcript_discount');
		$fldEventStatus      	= $db->f('fldEventStatus');
	}
}
else {
	    $fldEventName        = "";
		$fldSport="";
		$fldEventDescription      = "";
		$fldEventLocation        = "";
		$fldEventStartDate = "";
		$fldEventEndDate = "";
		$fldHomeTeam ="";
		$fldAwayTeam 	= "";
		$fldEventcurrentprice = "";
		$fldEventfutureprice  = "";
		$Early_Discount_day   = "";
		$Early_discount_rate  = "";
		$Transcript_discount  = "";
		$fldEventStatus      = "";
}
if($_POST['isSubmit']=='save'){
		/* validation area started */
		hb_php_validate($_POST['fldEventName'],"Please Enter Special Event Name!");
		hb_php_validate($_POST['fldEventLocation'],"Please Enter Special Event Loacation!");
		hb_php_validate($_POST['fldEventStartDate'],"Please Enter Special Event Start Date!");
		hb_php_validate($_POST['fldEventcurrentprice'],"Please Enter Special Event Current Price!");
		hb_php_validate($_POST['fldEventfutureprice'],"Please Enter Special Event Future Price!");
		hb_php_validate($_POST['Early_Discount_day'],"Please Enter Early Discount Day!");
		hb_php_validate($_POST['Early_discount_rate'],"Please Enter Early Discount Price!");
		hb_php_validate($_POST['Transcript_discount'],"Please Enter Transcript Discount Price!");
		
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
		/* validation area ended */
	
			$where = "fldEventId=".$fldEventId;
        			//Update data
			 $strDataArr=array(
			'fldEventName' 				=> $func->input_fun($_POST['fldEventName']),
		    'fldSport'					=> $func->input_fun($_POST['fldSport']),
			'fldEventDescription' 		=> $func->input_fun($_POST['fldEventDescription']),
			'fldEventLocation' 			=> $func->input_fun($_POST['fldEventLocation']),
		    'fldEventStartDate' 		=> $func->input_fun($_POST['fldEventStartDate']),
		    'fldEventEndDate' 			=> $func->input_fun($_POST['fldEventEndDate']),
			'fldHomeTeam'				=> $func->input_fun($_POST['fldHomeTeam']),
			'fldAwayTeam'				=> $func->input_fun($_POST['fldAwayTeam']),
			'fldEventcurrentprice'		=> $func->input_fun($_POST['fldEventcurrentprice']),
			'fldEventfutureprice'		=> $func->input_fun($_POST['fldEventfutureprice']),
			'Early_Discount_day'		=> $func->input_fun($_POST['Early_Discount_day']),
			'Early_discount_rate'		=> $func->input_fun($_POST['Early_discount_rate']),
			'Transcript_discount'		=> $func->input_fun($_POST['Transcript_discount']),
		    'fldEventStatus' 			=> $func->input_fun($_POST['fldEventStatus'])
		     		     );

			$db->updateRec(TBL_SPECIAL_EVENT,$strDataArr, $where);
			#redirect to listing page on successfull updation
		header("Location: ADSpecialEventList.php?page=".$_REQUEST['page']."&msg=Special Event Updated Successfully!");
		
	

	if($error_msg!=""){
		
		$fldEventName        = $_REQUEST['fldEventName'];
		$fldSport			 = $_REQUEST['fldSport'];
		$fldEventDescription = $_REQUEST['fldEventDescription'];
		$fldEventLocation    = $_REQUEST['fldEventLocation'];
		$fldEventStartDate 	 = $_REQUEST['fldEventStartDate'];
		$fldEventEndDate 	 = $_REQUEST['$fldEventEndDate'];
		$fldHomeTeam		 = $_REQUEST['fldHomeTeam'];
		$fldAwayTeam		 = $_REQUEST['fldAwayTeam'];
		$fldEventcurrentprice= $_POST['fldEventcurrentprice'];
		$fldEventfutureprice = $_POST['fldEventfutureprice'];
		$Early_Discount_day  = $_POST['Early_Discount_day'];
		$Early_discount_rate = $_POST['Early_discount_rate'];
		$Transcript_discount = $_POST['Transcript_discount'];
		$fldEventStatus      = $_REQUEST['fldEventStatus'];
	}
}

 //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	
	if(trimString(document.frmEvent.fldEventName.value) == ""){
		alert("Please Enter Special Event Name!");
		return false;
		document.frmEvent.fldEventName.focus();
	}
	if(trimString(document.frmEvent.fldEventLocation.value) == ""){
		alert("Please Enter Special Event Loacation!");
		return false;
		document.frmEvent.fldEventLocation.focus();
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
				<b>Edit Special Event Information</b>
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
			<tr height="20">
			<tr height="20">
			<?php /*?><td valign="top" align="right" class="normalblack_12" width="30%">Sport <font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldSport" id="fldSport" style="width: 220px;font-size:12px;" 
			>
			<?php
$sportlist=$func->selectTableOrder(TBL_SPORTS,"fldId,fldSportsname","fldSportsname","where fldStatus='ACTIVE'");
?><option value = "select">Select Sport</option><?php 

			for ($i=0;$i<count($sportlist);$i++) 
   			{
   				?>
   				<option value ="<?php echo $sportlist[$i]['fldId']?>" <?php if(isset($_REQUEST['sportid'])and ($_REQUEST['sportid']==$sportlist[$i]['fldId'])){ ?>selected <?php }elseif($sportlist[$i]['fldId']==$fldSport) {?>selected <?php } ?>><?php echo $sportlist[$i]['fldSportsname']; ?></option>
   			<?php 
			    }
			?>
</select>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			
			</td>
			</tr>
<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Home team<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldHomeTeam" id="fldHomeTeam" style="width: 220px;font-size:12px;" onChange="formsubmit_location(this.value);">
			
			<?php
			
				$homelist=$func->selectTableOrder(TBL_HS_AAU_TEAM,"fldId,fldSchoolname","fldSchoolname","where fldStatus='ACTIVE'");
			
			?>
<option value = "select" >Select Home Team</option>
<?php
if(isset($homelist))
{
			for ($i=0;$i<count($homelist);$i++) 
   			{
   			?>
   			<option value ="<?php echo $homelist[$i]['fldId']; ?>" <?php if((isset($_REQUEST['homeTeamid'])) and ($_REQUEST['homeTeamid']==$homelist[$i]['fldId'])){?>selected <?php } elseif ((isset($fldHomeTeam)) and ($fldHomeTeam==$homelist[$i]['fldId'])) {?>selected <?php } ?>><?php echo $homelist[$i]['fldSchoolname']; ?></option>
   			<?php
  		    
            }
}
            ?>
            </select>
          	</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			
			</td>
			</tr>
<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Away Team<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldAwayTeam" id="fldAwayTeam" style="width: 220px;font-size:12px;" onChange="formsubmit_Event(this.value);">
			<?php
//$awaylist=$func->selectTableOrder(TBL_SPORTS,"fldId,fldSportsname","fldId");
echo $strcombo = '<option value = "select">Select Away Team</option>';
if(isset($homelist))
{

			for ($i=0;$i<count($homelist);$i++) 
   			{
   				?><option value ="<?php echo $homelist[$i]['fldId'];?>" <?php if($homelist[$i]['fldId']==$fldAwayTeam){ ?>selected<?php } ?> ><?php echo $homelist[$i]['fldSchoolname']; ?> </option><?php
  		  
            }
}
?>
			</select>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			
			</td><?php */?>
			</tr>
<tr height="20" id="txtEvent">
			<td valign="top" align="right" class="normalblack_12" width="30%">Special Event Name <font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldEventName" id="fldEventName" value="<?=$fldEventName?>" maxlength="30" style="width: 220px;">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			</tr>

			
			<tr height="20" id="txtHint">
			<td valign="top" align="right" class="normalblack_12" width="30%">Location<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<?php 
	
if($_REQUEST['homeTeamid'])
			{
				$query ="Select * from ".TBL_HS_AAU_TEAM. " where fldId =".$_REQUEST['homeTeamid'];
	$db->query($query);
	$db->next_record();
	$location=$db->f('fldAddress');
			}
			elseif($fldEventLocation)
			{
				$location=$fldEventLocation;
			}
			
	?>
			<td valign="top" align="left" class="normalblack_12"> <textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="15"  style="width: 220px;"  ><?php if($location) {echo $location; }?></textarea></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			
			</td>	
<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Special Event Detail<font color="red"> </font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><textarea name="fldEventDescription" id="fldEventDescription" rows="10" cols="15"  style="width: 220px;"  class="txt"><?php echo $fldEventDescription; ?></textarea></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">&nbsp;
			
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Price(Early Graduation Year)<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text" style="float: left;width:220px;" id="fldEventcurrentprice" name="fldEventcurrentprice" value="<?php echo $fldEventcurrentprice; ?>" onKeyPress="return isNumber(event)"/>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Price(Future Graduation Year)<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text"  style="float: left;width:220px;" name="fldEventfutureprice" id="fldEventfutureprice" value="<?php echo $fldEventfutureprice; ?>" onKeyPress="return isNumber(event)"/>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;</td>
			</tr>
			<td valign="top" align="right" class="normalblack_12" width="30%">Early Discount Day<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<select name="Early_Discount_day" id="Early_Discount_day" style="width:180px;">
				<option value="">Select Early Discount Day</option>
				<?php 
				for($i=1;$i<=31;$i++){
				?>
				<option value="<?php echo $i;?>"<?php if($Early_Discount_day==$i){?> selected="selected" <?php }?>><?php echo $i;?></option>
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
			<input type="text"  style="float: left;width:220px;" name="Early_discount_rate" id="Early_discount_rate" value="<?php echo $Early_discount_rate;?>" onKeyPress="return isNumber(event)"/>
			</td>
			</tr>
			
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;
			</td>
			</tr>	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Transcript Discount Price<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text"  style="float: left;width:220px;" name="Transcript_discount" id="Transcript_discount" value="<?php echo $Transcript_discount;?>" onKeyPress="return isNumber(event)"/>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=2 align="center" >&nbsp;</td><td colspan="2" style="color:#333333;font-size:12px;margin-left:50px;">&nbsp;</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Start Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
									<input type="text"  style="float: left;width:200;" class="datetimepicker_es"  id="fldEventStartDate" name="fldEventStartDate" autocomplete="off" value="<?=$fldEventStartDate?>" >

			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			</tr>
			<?php /*?><tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event End Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
									<input type="text"  style="float: left;width:200;" class="datetimepicker_es"  id="fldEventEndDate" name="fldEventEndDate" autocomplete="off" value="<?=$fldEventEndDate?>">

			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">&nbsp;
			
			</td>
			</tr><?php */?>
		
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status <font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldEventStatus" style="width: 220px;font-size:12px;">
			<option value=1 <?if($fldEventStatus==1){ echo "selected"; }?>>ACTIVE</option>
			<option value=0 <?if($fldEventStatus==0){ echo "selected"; }?>>FULL</option>
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