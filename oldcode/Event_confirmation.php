<?php
include_once ("inc/common_functions.php");
//for common function
include_once ("inc/page.inc.php");
include_once ("inc/config.inc.php");
//for paging
session_start();
$func = new COMMONFUNC;
$func2 = new COMMONFUNC;
$db = new DB;
//$flag=1;
$lnb = "2";
$error_msg = '';
$flag = 0;
$debugstep = 0;
$responsetext=$_REQUEST['response_text'];
$tbl_transportation_discount='tbl_transportation_discount';
$fld_id=$_SESSION['fld_id'];
if(isset($_SESSION['fld_id']) && $_SESSION['fld_id']!='')
{
$sel ="Select * from ".TBL_SPECIAL_EVENT_REGISTER." where fldId=".$_SESSION['fld_id'];
$result=$db->query($sel);
$row=mysql_fetch_array($result);
	$fldId = $row['fldId'];
	$fldFirstName = $row['fldFirstName'];
	$fldLastName = $row['fldLastName'];
	$fldAddress = $row['fldAddress'];
	$fldEmail = $row['fldEmail'];
	$fldPhone = $row['fldPhone'];
	$fldCity = $row['fldCity'];
	$fldState = $row['fldState'];
	$fldZipCode = $row['fldZipCode'];
	$fldSpecialEvent=$row['fldSpecialEvent'];
	$fldReferredBy=$row['fldReferredBy'];
	$fldClass=$row['fldClass'];
	$fldPrimaryPosition=$row['fldPrimaryPosition'];
	$fldSecondaryPosition=$row['fldSecondaryPosition'];
	$fldHSCoachName=$row['fldHSCoachName'];
	$fldSchool=$row['fldSchool'];
	// START ADD FIELD ON 16-2-13
	$Address=$row['Address'];
	$City=$row['City'];
	$State=$row['State'];
	$ZipCode=$row['ZipCode'];
	// END ADD FIELD ON 16-2-13
	$fldOthers=$row['fldOthers'];
	$fldAAUCoachName=$row['fldAAUCoachName'];
	// START ADD FIELD ON 16-2-13
	$fldAAUSchool=$row['HS_AAU_Team'];
	$AAUAddress=$row['AAUAddress'];
	$AAUCity=$row['AAUCity'];
	$AAUState=$row['AAUState'];
	$AAUZipCode=$row['AAUZipCode'];
	$AAUOther=$row['AAUOther'];
	
	// END ADD fIELD ON 16-2-13
	$fldTransportation=$row['fldTransportation'];
	if(isset($row['fldTranscript']))
	{
	$fldTranscript =$row['fldTranscript'];
	}
	$fldCouponNumber=$row['fldCouponNumber'];
	$fldprice =$row['fldprice'];
	$fldpaymentstatus =$row['fldpaymentstatus'];
	
	$evquery ="SELECT * FROM ".TBL_SPECIAL_EVENT." WHERE `fldEventId` ='".$fldSpecialEvent."' ";				        $db->query($evquery);
	$db->next_record();
	$fldEventStartDate = $func->output_fun($db->f('fldEventStartDate'));
	$fldEventName=$func->output_fun($db->f('fldEventName'));
	$fldEventcurrentprice = $func->output_fun($db->f('fldEventcurrentprice'));
	$fldEventfutureprice = $func->output_fun($db->f('fldEventfutureprice')); 	
	$Early_Discount_day = $func->output_fun($db->f('Early_Discount_day'));
	$Early_discount_rate = $func->output_fun($db->f('Early_discount_rate'));
	$Transcript_discount = $func->output_fun($db->f('Transcript_discount'));
	$currentYear=date('Y');
	if($fldClass<=$currentYear)
		{
			$fldprice=$fldEventcurrentprice;
			$basicPrice=$fldprice;
		}
		else
		{
			$fldprice=$fldEventfutureprice;
			$basicPrice=$fldprice;
		}
			//Transportation Charge
		if($fldTransportation!="")
		{
			$trans=mysql_query("select * from ".$tbl_transportation_discount." where id='".$fldTransportation."'");
			$re=mysql_fetch_array($trans);
			$Transportation_charge=$re['Transportation_charge'];
			$fldprice=$fldprice+$Transportation_charge;
			$transportationCharge=$fldprice;
		}
		//Early Register Discount
		if($fldprice>$Early_discount_rate)
		{
		$fldEventStartDate;
		$newdate = strtotime ( '-'.$Early_Discount_day.' day' , strtotime ( $fldEventStartDate ) ) ;
		$newdate = date ( 'Y-m-d H:i:s' , $newdate );
		$cdate =strtotime( date ( 'Y-m-d H:i:s'));
			if($cdate<=strtotime($newdate))
			{
				$fldprice=$fldprice-$Early_discount_rate;
				$EarlyWeek=$fldprice;
			}
		}
		else
		{ $error_msg="Early Registeration Discount cant be applied to your order, because it is making your order total negative.";?>
			<script> window.location.href='http://collegeprospectnetwork.com/events?fld_id=<?php echo $fldId;?>&error=<?php echo $error_msg; ?>';</script>
		<?php
		}
		//Transcript Discount
		if($fldprice>$Transcript_discount)
		{
			if($fldTranscript!='')
			{
				$fldprice=$fldprice-$Transcript_discount;
			}
		}
		else
		{$error_msg="Transcript Discount cant be applied to your order, because it is making your order total negative.";?>
			<script> window.location.href='http://collegeprospectnetwork.com/events?fld_id=<?php echo $fldId;?>&error=<?php echo $error_msg; ?>';</script>
		<?php
				
		}
		//Coupon Discount
		$coupon=mysql_query("select * from tbl_cupon where cpn_number='".$fldCouponNumber."' AND status='1'");			
		$re=mysql_fetch_array($coupon);
		if($fldprice>$re['amount'])
		{
			if($fldCouponNumber==$re['cpn_number'])
			{
				$fldprice=$fldprice-$re['amount'];
				$coupondiscount=$re['amount'];
			}
		}
		else
		{$error_msg="Coupon Discount cant be applied to your order, because it is making your order total negative.";?>
			<script> window.location.href='http://collegeprospectnetwork.com/events?fld_id=<?php echo $fldId;?>&error=<?php echo $error_msg; ?>';</script>
		<?php
		}
		if($fldprice<0)
		{$error_msg="Discount cant be applied to your order, because it is making your order total negative.";?>
			<script> window.location.href='http://collegeprospectnetwork.com/events?fld_id=<?php echo $fldId;?>&error=<?php echo $error_msg; ?>';</script>
		<?php }
}
if(isset($_REQUEST['register']) && $_REQUEST['register']){
$_SESSION['cardno'] = $_REQUEST['cardno'];
$_SESSION['cardtype'] = $_REQUEST['cardtype'];
$_SESSION['expmonth'] = $_REQUEST['expmonth'];
$_SESSION['expyear'] = $_REQUEST['expyear'];
$_SESSION['securitycode'] = $_REQUEST['securitycode'];
$_SESSION['fldFirstName']=$_REQUEST['fldFirstName'];
$_SESSION['fldLastName']=$_REQUEST['fldLastName'];
$_SESSION['fldPhone']=$_REQUEST['fldPhone'];
$_SESSION['fldBSAddress']=$_REQUEST['fldBSAddress'];
$_SESSION['fldBSCity']=$_REQUEST['fldBSCity'];
$_SESSION['fldBSState']=$_REQUEST['fldBSState'];
$_SESSION['fldBSZipCode']=$_REQUEST['fldBSZipCode'];
header('location:sendmoney.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>College Prospect Network</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
<script language="javascript" type="text/javascript">

	function validate() {
		var error_msg = "";
		var blnResult = true;
		if(trimString(document.frmUsers.cardno.value)=="")
		{
			/*alert("Please enter your credit card number.");*/
			error_msg += "Please enter your credit card number. \n";
			/*return false;*/
		   
		}
		if(isNaN(document.frmUsers.cardno.value))
		{	/*alert("Please enter valid credit card number.");*/
			error_msg += "Please enter valid credit card number. \n";
			/*return false;*/
		   
		}
		var carno = document.frmUsers.cardno.value;
		if(carno.length != 16 )
		{/*alert("Please enter valid 16 digit credit card number.");*/
			error_msg += "Please enter valid 16 digit credit card number. \n";
			/*return false;*/
		   
		}
		
		if(trimString(document.frmUsers.cardtype.value) =="")
		{	/*alert("Please select your credit card type.");*/
			error_msg += "Please select your credit card type. \n";
			/*return false;*/
		   
		}
		
		if(trimString(document.frmUsers.expmonth.value)=="")
		{	/*alert("Please select your credit card expire month.");*/
			error_msg += "Please select your credit card expire month. \n";
			/*return false;*/
		   
		}
		
		if(trimString(document.frmUsers.expyear.value)=="")
		{
			/*alert("Please enter your credit card expire year.");*/
			error_msg += "Please enter your credit card expire year. \n";
		  /* return false;*/
		}
		if(isNaN(document.frmUsers.expyear.value))
		{
			/*alert("Please enter valid credit card expire year.");*/
			error_msg += "Please enter valid credit card expire year. \n";
			/*return false;*/
		   
		}
		
		if(isNaN(document.frmUsers.expyear.value))
		{
			/*alert("Please enter valid credit card expire year.");*/
			error_msg += "Please enter valid credit card expire year. \n";
			/*return false;*/
		   
		}
		
		var expyear = document.frmUsers.expyear.value;
		if(expyear.length != 4 )
		{
			/*alert("Please enter valid 4 digit credit card expire year.");*/
			error_msg += "Please enter valid 4 digit credit card expire year. \n";
			/*return false;*/
		   
		}
		
		 if(trimString(document.frmUsers.securitycode.value)=="")
		{
			/*alert("Please enter your credit card security code.");*/
			error_msg += "Please enter your credit card security code. \n";
			/*return false;*/
		   
		}
		if(trimString(document.frmUsers.fldFirstName.value) == "") {
			/*alert("Please Enter First Name!");*/
			error_msg += "Please Enter First Name! \n";
			/*return false;*/
		} else {
			if(hasSpecialCharaters(document.frmUsers.fldFirstName.value)) {
				/*alert("Enter Valid First Name!");*/
				error_msg += "Enter Valid First Name! \n";
				/*return false;*/
			}
		}
		if(trimString(document.frmUsers.fldLastName.value) == "") {
			/*alert("Please Enter Last Name!");*/
			error_msg += "Please Enter Last Name! \n";
			/*return false;*/
		} else {
			if(hasSpecialCharaters(document.frmUsers.fldLastName.value)) {
				/*alert("Enter Valid Last Name!");*/
				error_msg += "Enter Valid Last Name! \n";
				/*return false;*/
			}
		}
		
		if(trimString(document.frmUsers.fldBSAddress.value) == "") {
			/*alert("Please Enter Address!");*/
			error_msg += "Please Enter Address! \n";
			/*return false;*/
		}
		
		if(trimString(document.frmUsers.fldBSCity.value) == "") {
			/*alert("Please Enter City! \n");*/
			error_msg += "Please Enter City! \n";
			/*return false;*/
		}
		if(trimString(document.frmUsers.fldBSState.value) == "") {
			/*alert("Please Enter State! \n");*/
			error_msg += "Please Enter State! \n";
			/*return false;*/
		} 
		if(trimString(document.frmUsers.fldBSZipCode.value) == "") {
			/*alert("Please Enter Zip Code! \n");*/
			error_msg += "Please Enter Zip Code! \n";
			/*return false;*/
		} 
		if(trimString(document.frmUsers.fldPhone.value) == "") {
			/*alert("Please Enter Your Cell Phone no.");*/
			error_msg += "Please Enter Your Cell Phone no. \n";
			/*return false;*/
		} else {
			if(!isPhone(document.frmUsers.fldPhone.value)) {
				/*alert("Enter valid  Cell Phone no.");*/
				error_msg += "Enter valid  Cell Phone no. \n";
				/*return false;*/
			}
		}
		
		if(error_msg != '') {
			alert(error_msg);
			return false;
		} else {
			return true;
		}
		
		
	}
</script>
</head>
<body>
<!--header link starts from here -->
<?php
$no_popup = 'yes';
include ('header.php');
?>
<!--Header ends from here -->
<!--middle panel starts from here -->
<!--content panel starts from here -->
<div class="container">
<div class="innerWraper">
<div class="middle-bg">
<div class="cantener">
<div class="register-main">
<h1>Payment Information</h1>
<?php
if ($error_msg){
?>
<div class="thankyoumessage">
	<?php  echo $error_msg;?>
</div>
<?
	}
?>							
<div class="registerPage">
	<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onSubmit="return validate()"><input name="fld_id" id="fld_id" type="hidden" value="<?php echo $fld_id;?>" />
	<table cellpadding="5" width="100%" cellspacing="5" style="font-size:16px;">
		<tr style="border-bottom:#333333 1px solid;">
			<th width="70%"><b>Event Information</b></th>
			<th width="30%"><b>Price</b></th>
		</tr>
		<tr style="line-height:20px;" >
			<td><?php echo $fldEventName;?></td>
			<td style="padding-left:5px;">$<?php echo $basicPrice;?></td>
		</tr>
		<tr style="line-height:20px;">
		<?php if(isset($fldTransportation) && $fldTransportation!='0' && $fldTransportation!=''){?>
			<td style="color:#33CC00;padding-left:5px;"> + Transportation Charge </td>
			<td style="padding-left:5px;">$<?php echo $Transportation_charge;?></td>
		<?php }else{?>
			<td style="color:#FF0000;padding-left:5px;"> + Transportation Charge </td>
			<td style="padding-left:5px;">$0</td>
		<?php }?>
		</tr>
		<tr><td>Discount</td><td>&nbsp;</td></tr>
		<tr style="line-height:25px;">
		<?php if(isset($EarlyWeek) && $EarlyWeek!='' && $EarlyWeek!=0){?>
			<td style="color:#33CC00;padding-left:5px;"> - Early Registration Discount </td>
			<td style="padding-left:5px;">$<?php echo $Early_discount_rate;?></td>
		<?php }else{?>
			<td style="color:#FF0000;padding-left:5px;"> - Early Registration Discount </td>
			<td style="padding-left:5px;">$0</td>
		<?php }?>
		</tr>
		<tr style="line-height:20px;">
		<?php if(isset($fldTranscript) && $fldTranscript!='' && $Transcript_discount!=0){?>
			<td style="color:#33CC00;padding-left:5px;"> - Upload Transcipt Discount </td>
			<td style="padding-left:5px;">$<?php echo $Transcript_discount;?></td>
		<?php }else{?>
			<td style="color:#FF0000;padding-left:5px;"> - Upload Transcipt Discount </td>
			<td style="padding-left:5px;">$0</td>
		<?php }?>
		</tr>
		<tr style="line-height:20px;">
		<?php if(isset($coupondiscount) && $coupondiscount!=''){?>
			<td style="color:#33CC00;padding-left:5px;"> - Coupon Discount </td>
			<td style="padding-left:5px;">$<?php echo $coupondiscount;?></td>
		<?php }else{?>
			<td style="color:#FF0000;padding-left:5px;"> - Coupon Discount </td>
			<td style="padding-left:5px;">$0</td>
		<?php }?>
		</tr>
		<tr style="border-top:#333333 1px solid;line-height:20px;padding-top:5px;border-bottom:#333333 1px solid;">
			<td style="text-align:right;"><b>Event Total Price :</b></td>
			<td style="padding-left:5px;"><b>$<?=$fldprice?></b></td>
		</tr>
	</table>
		<p>&nbsp;</p>
		<?php if(isset($_REQUEST['response_text']) && $_REQUEST['response_text']!=''){?>
		<p><center>
			<span style="font-size:14px;color:#CC0000;text-align:center;"><?php echo $_REQUEST['response_text']; ?></span>
		</center></p>
		<?php unset($_REQUEST['response_text']);}?>
		<!--<hr class="line" />-->
		<h1>Payment Confirmation</h1>
		<p>
			<label>Credit Card No :</label>
			<span><input name="cardno" id="cardno" type="text"/></span>
			<font color="#0000ff">&nbsp;*</font>
		</p>
		<p>
			<label>Card Type :</label>
			<span>
			<select name="cardtype" class="cer_cent_forms_box" id="cardtype">
				<option value="">Select</option>
				<option value="Visa">Visa</option>
				<option value="MasterCard">MasterCard</option>
				<option value="American Express">American Express</option>
				<option value="Discover">Discover</option>
			  </select>
			</span>
			<font color="#0000ff">&nbsp;*</font>
		</p>
		<p>
			<label>Expiration Month :</label>
			<span>
			<select name="expmonth" class="cer_cent_forms_box" id="expmonth">
				<option value="" >Select</option>
				<option value="1">Jan</option>
				<option value="2">Feb</option>
				<option value="3">Mar</option>
				<option value="4">Apr</option>
				<option value="5">May</option>
				<option value="6">Jun</option>
				<option value="7">Jul</option>
				<option value="8">Aug</option>
				<option value="9">Sep</option>
				<option value="10">Oct</option>
				<option value="11">Nov</option>
				<option value="12">Dec</option>
			  </select>
			</span>
			<font color="#0000ff">&nbsp;*</font>
		</p>
		<p>
			<label>Expiration Year :</label>
			<span><input name="expyear" id="expyear" type="text"/></span>
			<font color="#0000ff">&nbsp;*</font>
		</p>
		<p style="border-bottom:#333333 1px solid;padding-bottom:10px;">
			<label>Security Code :</label>
			<span><input name="securitycode" id="securitycode" type="text"/></span>
			<font color="#0000ff">&nbsp;*</font>
		</p>
		<h1>Billing Information</h1>
		<p>
			<label>First Name(As per Card):</label>
			<span>
				<input type="text" name="fldFirstName" id="fldFirstName" value="<?=$fldFirstName?>"
				>
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Last Name(As per Card):</label>
			<span>
				<input type="text" name="fldLastName" id="fldLastName" value="<?=$fldLastName?>"
				>
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<?php /*?><p>
			<label>Email Address (for Receipt):</label>
			<span><input type="text" name="fldEmail" id="fldEmail" value="<?=$fldEmail?>" ></span>
			<font color="#0000ff">&nbsp;*</font>		</p><?php */?>
		<p>
			<label>Address(As per Card):</label>
			<span><textarea class="ta1" id="fldBSAddress" name="fldBSAddress"><?=$fldAddress?></textarea></span>
			<font color="#0000ff">&nbsp;*</font>		</p>
		
		<p>
			<label>City(As per Card):</label>
			<span>
				<input type="text" name="fldBSCity" id="fldBSCity" value="<?=$fldCity?>" >
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>State(As per Card):</label>
			<span>
				<input type="text" name="fldBSState" id="fldBSState" value="<?=$fldState?>" >
				</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Zip Code(As per Card):</label>
			<span>
				<input type="text" name="fldBSZipCode" id="fldBSZipCode" value="<?=$fldZipCode?>" >
				</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Cell Phone:</label>
			<span>
				<input type="text" name="fldPhone" id="fldPhone" value="<?=$fldPhone?>" >
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>&nbsp;</label>
			<span>
				<input type="submit" name="register" value="Make Payment">
				<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='Registration-Special-Event.php?fld_id=<?php echo $fld_id;?>'">
			</span>
		</p>
	</form>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
include ('footer.php');
?>
</body>
</html>