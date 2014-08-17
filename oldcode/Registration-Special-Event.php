<?php include_once ("inc/common_functions.php");
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
	//Check Sport - Display Positions for sport
	$Sportstable="tbl_position_basketball";
    //$Sportstable = "tbl_position_football";
	$tbl_transportation_discount='tbl_transportation_discount';
	$fld_id=$_REQUEST['fld_id'];
	$responsetext=$_REQUEST['response_text'];
	$evquery ="SELECT * FROM ".TBL_SPECIAL_EVENT;
	$db->query($evquery);
	if ($db->num_rows()>0) 
	{?><?php 
if(isset($_REQUEST['fld_id']) && $_REQUEST['fld_id']!='')
{
$sel ="Select * from ".TBL_SPECIAL_EVENT_REGISTER." where fldId=".$_REQUEST['fld_id'];
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
	
	$evquery ="SELECT * FROM ".TBL_SPECIAL_EVENT." WHERE `fldEventId` ='".$fldSpecialEvent."' ";				    $db->query($evquery);
	$db->next_record();
	$fldEventStatus = $func->output_fun($db->f('fldEventStatus'));
	$fldEventStartDate = $func->output_fun($db->f('fldEventStartDate'));
	$fldEventName=$func->output_fun($db->f('fldEventName'));
	$fldEventcurrentprice = $func->output_fun($db->f('fldEventcurrentprice'));
	$fldEventfutureprice = $func->output_fun($db->f('fldEventfutureprice')); 	
	$Early_Discount_day = $func->output_fun($db->f('Early_Discount_day'));
	$Early_discount_rate = $func->output_fun($db->f('Early_discount_rate'));
	$Transcript_discount = $func->output_fun($db->f('Transcript_discount'));
}
function getExtension($str) {
$i = strrpos($str, ".");
if (!$i) {
return "";
}
$l = strlen($str) - $i;
$ext = substr($str, $i + 1, $l);
return $ext;
}
	if(isset($_REQUEST['submit'])){
		$fldFirstName = $_REQUEST['fldFirstName'];
		$fldLastName = $_REQUEST['fldLastName'];
		$fldAddress = $_REQUEST['fldBSAddress'];
		$fldEmail = $_REQUEST['fldEmail'];
		$fldPhone = $_REQUEST['fldPhone'];
		$fldCity = $_REQUEST['fldBSCity'];
		$fldState = $_REQUEST['fldBSState'];
		$fldZipCode = $_REQUEST['fldBSZipCode'];
		$fldSpecialEvent=$_REQUEST['fldSpecialEvent'];
		$fldReferredBy=$_REQUEST['fldReferredBy'];
		$fldClass=$_REQUEST['fldClass'];
		//add dynamic price on 16-2-13
		if($fldSpecialEvent==$_REQUEST['fldSpecialEvent'])
		{
		$fldEventcurrentprice = $fldEventcurrentprice;
		$fldEventfutureprice = $fldEventfutureprice; 	
		$Early_Discount_day = $Early_Discount_day;
		$Early_discount_rate = $Early_discount_rate;
		$Transcript_discount = $Transcript_discount;
		}else{
		$fldEventcurrentprice = $_REQUEST['fldEventcurrentprice'];
		$fldEventfutureprice = $_REQUEST['fldEventfutureprice']; 	
		$Early_Discount_day = $_REQUEST['Early_Discount_day'];
		$Early_discount_rate = $_REQUEST['Early_discount_rate'];
		$Transcript_discount = $_REQUEST['Transcript_discount'];
		}
		$fldTransportation=$_REQUEST['fldTransportation'];
		//End add dynamic price on 16-2-13
		$fldPrimaryPosition=$_REQUEST['fldPrimaryPosition'];
		$fldSecondaryPosition=$_REQUEST['fldSecondaryPosition'];
		$fldHSCoachName=$_REQUEST['fldHSCoachName'];
		if($fldSchool==$_REQUEST['fldSchool'])
		{
		$fldSchool=$fldSchool;
		$City=$Address;
		$State=$City;
		$Zipcode=$State;
		$Address=$ZipCode;
		}else{
		$fldSchool=$_REQUEST['fldSchool'];
		$City=$_REQUEST['fldCity'];
		$State=$_REQUEST['fldState'];
		$Zipcode=$_REQUEST['fldZipcode'];
		$Address=$_REQUEST['fldAddress'];
		}
		$fldOthers=$_REQUEST['txtfldName'];
		$fldAAUCoachName=$_REQUEST['fldAAUCoachName'];
		$fldAAUOthers=$_REQUEST['txtfldAAUName'];
		
		if($fldAAUSchool==$_REQUEST['fldAAUSchool'])
		{
		$fldAAUSchool=$fldAAUSchool;
		$fldAAUAddress=$AAUAddress;
		$fldAAUCity=$AAUCity;
		$fldAAUState=$AAUState;
		$fldAAUZipcode=$AAUZipCode;
		}else{
		$fldAAUSchool=$_REQUEST['fldAAUSchool'];
		$fldAAUAddress=$_REQUEST['fldAAUAddress'];
		$fldAAUCity=$_REQUEST['fldAAUCity'];
		$fldAAUState=$_REQUEST['fldAAUState'];
		$fldAAUZipcode=$_REQUEST['fldAAUZipcode'];
		}
		// END ADD FIELD ON 16-2-13
		$fldCouponNumber=$_REQUEST['fldCouponNumber'];
		//$fldprice=$_REQUEST['fldprice'];
		$fldTranscript=$_REQUEST['fldTranscript'];
		$newname=$_REQUEST['updtranscript'];
	//Add College User
		//select Event Details	
	$fldSubscribe = 1;
	$evquery ="SELECT * FROM ".TBL_SPECIAL_EVENT." WHERE `fldEventId` ='".$_POST['fldSpecialEvent']."' ";
	$db->query($evquery);
	if ($db->num_rows()>0) {
		while($db->next_record())
		{	$fldEventName=$func->output_fun($db->f('fldEventName'));
			$fldEventStatus = $func->output_fun($db->f('fldEventStatus'));
			$fldEventStartDate = $func->output_fun($db->f('fldEventStartDate'));
			$fldEventcurrentprice = $func->output_fun($db->f('fldEventcurrentprice'));
			$fldEventfutureprice = $func->output_fun($db->f('fldEventfutureprice')); 	
			$Early_Discount_day = $func->output_fun($db->f('Early_Discount_day'));
			$Early_discount_rate = $func->output_fun($db->f('Early_discount_rate'));
			$Transcript_discount = $func->output_fun($db->f('Transcript_discount'));
			if($fldEventStatus==0)
			{
				$error_msg="";
				$flag++;
				$error_msg="full";?>
			 <script> window.location.href='register_msg.php?error=<?php echo $error_msg; ?>';</script>
			<?php }
		}
	}	
		
		if(isset($_FILES['fldTranscript']['name']) && $_FILES['fldTranscript']['name']!=''){
		$fldTranscript = $_FILES['fldTranscript']['name'];
		if ($fldTranscript) {
			$filename = stripslashes($_FILES['fldTranscript']['name']);
			$extension = getExtension($filename);
			$extension = strtolower($extension);
			//bmp
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "bmp") && ($extension != "pdf") && ($extension != "doc") && ($extension != "docx") && ($extension != "pdf") && ($extension != "xls") && ($extension != "xlsx")) {
				$error_msg = 'Please Use jpg , png , jpeg , bmp , doc, docx, pdf, xls, xlsx, gif images!';							              ?> <script> window.location.href='Registration-Special-Event.php?msg=<?php echo $error_msg; ?>';</script><?php
				$errors = 1;
				$flag++;
			} else {
				/*$size = filesize($_FILES['fldImage']['tmp_name']);
				if ($size > MAX_SIZE * 1024 * 1024) {
					$error_msg = "You have exceeded the size limit";
					$errors = 1;
				}*/
				$image_name = "cpn_" . time() . '.' . $extension;
				$newname = "transcriptfile/" . $image_name;
				$copied = copy($_FILES['fldTranscript']['tmp_name'], $newname);
				if($copied)
				{
					$transcriptfile=1;
				}
			  }
			}
			}
			
		
	if ($flag == 0) {
		 //Insert data
		$fldCancelCount = 0;
		$debugstep = 1;
		$currentYear=date('Y');
		if($_REQUEST['fldClass']<=$currentYear)
		{
			$fldprice=$fldEventcurrentprice;
			$basicPrice=$fldprice;
		}
		else
		{
			$fldprice=$fldEventfutureprice;
			$basicPrice=$fldprice;
		}
		$fldEventStartDate;
		$newdate = strtotime ( '-'.$Early_Discount_day.' day' , strtotime ( $fldEventStartDate ) ) ;
		$newdate = date ( 'Y-m-d H:i:s' , $newdate );
		$cdate =strtotime( date ( 'Y-m-d H:i:s'));
		if($cdate<=strtotime($newdate))
		{
			$fldprice=$fldprice-$Early_discount_rate;
			$EarlyWeek=$fldprice;
		}
		if($transcriptfile==1)
		{
			$fldprice=$fldprice-$Transcript_discount;
		}
		
		if($fldTransportation!="")
		{
			$trans=mysql_query("select * from ".$tbl_transportation_discount." where id='".$fldTransportation."'");
			$re=mysql_fetch_array($trans);
			$Transportation_charge=$re['Transportation_charge'];
			$fldprice=$fldprice+$Transportation_charge;
			$transportationCharge=$fldprice;
		}
		$coupon=mysql_query("select * from tbl_cupon where cpn_number='".$_POST['fldCouponNumber']."' AND status='1'");			
		$re=mysql_fetch_array($coupon);
		if($_POST['fldCouponNumber']==$re['cpn_number'])
		{
			$fldprice=$fldprice-$re['amount'];
			$coupondiscount=$re['amount'];
		}
		$fldpaymentstatus="INCOMPLETE";
		##INSERT Enent###
		#######################################            
		$strDataArr = array(
		'fldFirstName' => $func -> input_fun($_POST['fldFirstName']),
		'fldLastName' => $func -> input_fun($_POST['fldLastName']),          
		'fldAddress' => $func -> input_fun($_POST['fldBSAddress']),
		'fldCity' => $func -> input_fun($_POST['fldBSCity']),
		'fldState' => $func -> input_fun($_POST['fldBSState']),  
		'fldZipCode' => $func -> input_fun($_POST['fldBSZipCode']),          
		'fldPhone' => $func -> input_fun($_POST['fldPhone']),
		'fldEmail' => $func -> input_fun($_POST['fldEmail']),
		'fldSpecialEvent' => $func -> input_fun($_POST['fldSpecialEvent']),
		'fldReferredBy' => $func -> input_fun($_POST['fldReferredBy']),
		'fldClass' => $func -> input_fun($_POST['fldClass']),
		'fldPrimaryPosition' => $func -> input_fun($_POST['fldPrimaryPosition']),
		'fldSecondaryPosition' => $func -> input_fun($_POST['fldSecondaryPosition']),
		'fldHSCoachName' => $func -> input_fun($_POST['fldHSCoachName']),
		'fldSchool' => $func -> input_fun($fldSchool),
		'fldOthers' => $func -> input_fun($_POST['txtfldName']),
		'Address' => $func -> input_fun($Address),
		'City' => $func -> input_fun($City),
		'State' => $func -> input_fun($State),
		'Zipcode' => $func -> input_fun($Zipcode),
		'fldAAUCoachName' => $func -> input_fun($_POST['fldAAUCoachName']),
		'AAUOther' => $func -> input_fun($_POST['txtfldAAUName']),
		'HS_AAU_Team' => $func -> input_fun($fldAAUSchool),
		'AAUAddress' => $func -> input_fun($fldAAUAddress),
		'AAUCity' => $func -> input_fun($fldAAUCity),
		'AAUState' => $func -> input_fun($fldAAUState),
		'AAUZipCode' => $func -> input_fun($fldAAUZipcode),
		'fldCouponNumber' => $func -> input_fun($_POST['fldCouponNumber']),
		'fldTransportation' => $func -> input_fun($fldTransportation),
		'fldTranscript' => $newname,
		'fldprice' => $fldprice,
		'fldpaymentstatus' => $fldpaymentstatus,
		'fldAddDate' => date("y-m-d"));
		//print_r($strDataArr);
	  $debugstep = 2;
	  
	  //Insert Data - Get NewUserID
	  if(isset($_REQUEST['fld_id']) && $_REQUEST['fld_id']!='')
	  {
		$where_reg_update = "fldId = " . $_REQUEST['fld_id'];
		$result = $db -> updateRec(TBL_SPECIAL_EVENT_REGISTER,$strDataArr,$where_reg_update);
		$NewUserId=$_SESSION['fld_id'];	
	  }
	  else
	  {
		$NewUserId = $db -> insertRec(TBL_SPECIAL_EVENT_REGISTER, $strDataArr);
	  }
	  $error_msg="Thankyou for Register with Our Event";
	  $_SESSION['fld_id']=$NewUserId;
	  $debugstep = 3;?>
	  <script> window.location.href='Event_confirmation.php';</script>
	  <?php exit; }
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
		
		if(trimString(document.frmUsers.fldEmail.value) == "") {
			/*alert("Please Enter Email.");*/
			error_msg += "Please Enter Email. \n";
			/*return false;*/
		} else {
			if(!isValid(document.frmUsers.fldEmail.value)) {
				/*alert("Enter Valid Email.");*/
				error_msg += "Enter Valid Email. \n";
				/*return false;*/
			}
		}
		if(trimString(document.frmUsers.fldClass.value) == "select") {
			/*alert("Please Select Class.");*/
			error_msg += "Please Select Class. \n";
			/*return false;*/
		}
		if(trimString(document.frmUsers.fldPrimaryPosition.value) == "") {
			/*alert("Please Select Primory Position.");*/
			error_msg += "Please Select Primory Position. \n";
			/*return false;*/
		}
		if(trimString(document.frmUsers.fldSecondaryPosition.value) == "") {
			/*alert("Please Select Secondary Position.");*/
			error_msg += "Please Select Secondary Position. \n";
			/*return false;*/
		}
		if(trimString(document.frmUsers.fldHSCoachName.value) == "") {
			/*alert("Please Select HS Coach Name.");*/
			error_msg += "Please Select HS Coach Name. \n";
			/*return false;*/
		}
		if(trimString(document.frmUsers.fldSchool.value) == "select") {
			/*alert("Please Select School Name.");*/
			error_msg += "Please Select School Name. \n";
			/*return false;*/
		}
		if(trimString(document.frmUsers.fldSpecialEvent.value) == "") {
			/*alert("Please Select Event.");*/
			error_msg += "Please Select Event. \n";
			/*return false;*/
		}
		if(error_msg != '') {
			alert(error_msg);
			return false;
		} 
		else 
		{
			return true;
		}
		
		
	}

//jQuery AJAX Calls
function select_val(str,trans_id)
{	var trans_id=document.getElementById("fld_trance").value;
 if (str=="")
  {
  document.getElementById("transportation").innerHTML="";
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
    document.getElementById("transportation").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","ajax_transport_dicount.php?q="+str+'&tp_id='+trans_id,true);
xmlhttp.send();
}  
</script>
<script type="text/javascript">
function transport_charge(val)
{ 

	try{
		$.post("ajax_transport_charge.php", { c: val },
		   function(data) {
			document.getElementById("transport_disc_charge").innerHTML=data;
		   });
	}
	catch(ex)
	{
		alert(ex.message);
	}
}
</script>
<script type="text/javascript">
//jQuery AJAX Calls     
$(document).ready(function(){

$("#fldSchool").change(function(){
	var ddlval=$("#fldSchool").val();
	
	if(ddlval == "") {
		$("#AjaxResponse").html('');   
		return;
	}
	//alert('ya');
	
	if(ddlval == "others") {
		$("#xtxtschoolothers").show();
		//document.getElementById("txtschoolothers").style.display = "";
	} else if(ddlval == "") {
		$("#txtschoolothers").hide();
		//document.getElementById("txtschoolothers").style.display = "none";
		$.ajax({
		  url: 'addschool-new.php?q='+ddlval,
		  success: function(data) {
		   $("#AjaxResponse").html(data);       
		  }
		});
	} else {
		$("#txtschoolothers").hide();
		//document.getElementById("txtschoolothers").style.display = "none";
		$.ajax({
		  url: 'addschool-new.php?q='+ddlval,
		  success: function(data) {
		   $("#AjaxResponse").html(data);       
		  }
		});
	}               

});//dropdown change

}); //document.ready

//jQuery AJAX Calls     
$(document).ready(function(){

$("#fldAAUSchool").change(function(){
	var ddlval=$("#fldAAUSchool").val();
	
	if(ddlval == "") {
		$("#AjaxResponse1").html('');   
		return;
	}
	//alert('ya');
	
	if(ddlval == "others") {
		$("#txtschoolothers1").show();
		//document.getElementById("txtschoolothers").style.display = "";
	} else if(ddlval == "") {
		$("#txtschoolothers1").hide();
		//document.getElementById("txtschoolothers").style.display = "none";
		$.ajax({
		  url: 'addschool-new-aau.php?q='+ddlval,
		  success: function(data) {
		   $("#AjaxResponse1").html(data);       
		  }
		});
	} else {
		$("#txtschoolothers1").hide();
		//document.getElementById("txtschoolothers").style.display = "none";
		$.ajax({
		  url: 'addschool-new-aau.php?q='+ddlval,
		  success: function(data) {
		   $("#AjaxResponse1").html(data);       
		  }
		});
	}               

});//dropdown change

}); //document.ready


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
<h1>Event Registration</h1>
<?php
if (isset($_REQUEST['msg']) && $_REQUEST['msg']!=''){
?>
<div class="thankyoumessage">
	<?php echo $_REQUEST['msg'];?>
</div>
<?
	unset($_REQUEST['msg']);}
?>
<?php if(isset($_REQUEST['error']) && $_REQUEST['error']!=''){?>
		<p><center>
			<span style="font-size:14px;color:#CC0000;text-align:center;"><?php echo $_REQUEST['error']; ?></span>
		</center></p>
		<?php unset($_REQUEST['error']);}?>
<?php if(isset($_REQUEST['response_text']) && $_REQUEST['response_text']!=''){?>
		<p><center>
			<span style="font-size:14px;color:#CC0000;text-align:center;"><?php echo $_REQUEST['response_text']; ?></span>
		</center></p>
		<?php unset($_REQUEST['response_text']);}?>
							
<span class="msg"><font color="#0000ff">&nbsp;*</font> Fields are Mandatory.</span>
<div class="registerPage">
	<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onSubmit="return validate()">
		<p>
			<label>First Name:</label>
			<span>
				<input type="text" name="fldFirstName" id="fldFirstName" value="<?=$fldFirstName?>"
				>
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Last Name:</label>
			<span>
				<input type="text" name="fldLastName" id="fldLastName" value="<?=$fldLastName?>"
				>
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Address:</label>
			<span><textarea class="ta1" id="fldBSAddress" name="fldBSAddress"><?=$fldAddress?></textarea></span>
			<font color="#0000ff">&nbsp;*</font>		</p>
		
		<p>
			<label>City:</label>
			<span>
				<input type="text" name="fldBSCity" id="fldBSCity" value="<?=$fldCity?>" >
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>State:</label>
			<span>
				<input type="text" name="fldBSState" id="fldBSState" value="<?=$fldState?>" >
				</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Zip Code:</label>
			<span>
				<input type="text" name="fldBSZipCode" id="fldBSZipCode" value="<?=$fldZipCode?>" >
				</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Cell Phone:</label>
			<span>
				<input type="text" name="fldPhone" id="fldPhone" value="<?=$fldPhone?>" >
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Email Address (for Receipt):</label>
			<span><input type="text" name="fldEmail" id="fldEmail" value="<?=$fldEmail?>" ></span>
			<font color="#0000ff">&nbsp;*</font>		</p>
		 <p>
			<label>Graduating Class:</label>
			<span> 
			<select name="fldClass" id="fldClass">
				<option value="select" class="selectgrey" >Select Class</option>
				<?php $classlist = $func -> selectTableOrder(TBL_CLASS, "fldId,fldClass", "fldClass");
				for ($i = 0; $i < count($classlist); $i++) {?>
				<option value ="<?php echo $classlist[$i]['fldClass']; ?>"<?php if($classlist[$i]['fldClass']==$fldClass){?> selected="selected" <?php }?>><?php echo $classlist[$i]['fldClass'] ?></option>
	  <?php   }?>
			</select>
			</span>
			<font color="#0000ff">*</font>		</p>
		<p>
			<label>Primary Position:</label>
			<span>
			<?php
				 $classlist = $func -> selectTableOrder($Sportstable, "Position,SortOrder", "SortOrder");
			?>
				<select name="fldPrimaryPosition" id="fldPrimaryPosition" ><option value="">Please Select</option> 
					<?php        									    
						$classlist = $func -> selectTableOrder($Sportstable, "Position,SortOrder", "SortOrder");
						for ($i = 0; $i < count($classlist); $i++) {
							if ($fldPrimaryPosition == $classlist[$i]['Position']) {
								echo '<option value ="' . $classlist[$i]['Position'] . '" selected = "selected" >' . $classlist[$i]['Position'] . '</option>';
							} else {
								echo '<option value ="' . $classlist[$i]['Position'] . '"  >' . $classlist[$i]['Position'] . '</option>';
							}
						}                                         
					?>
				</select>
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>Secondary Position:</label>									
			<span>
				<select name="fldSecondaryPosition" id="fldSecondaryPosition" ><option value="">Please Select</option> 
					<?php                                               
						$classlist = $func -> selectTableOrder($Sportstable, "Position,SortOrder", "SortOrder");
						for ($i = 0; $i < count($classlist); $i++) {
							if ($fldSecondaryPosition == $classlist[$i]['Position']) {
								echo '<option value ="' . $classlist[$i]['Position'] . '" selected = "selected" >' . $classlist[$i]['Position'] . '</option>';
							} else {
								echo '<option value ="' . $classlist[$i]['Position'] . '"  >' . $classlist[$i]['Position'] . '</option>';
							}
						}                                         
					?>
				</select>
			</span> <font color="#0000ff">&nbsp;*</font>		</p>
		<p>
			<label>HS Coach Name:</label>
			<span>
			<input type="text" name="fldHSCoachName" id="fldHSCoachName" value="<?=$fldHSCoachName?>">
			</span><font color="#0000ff">&nbsp;*</font>		</p>
		<p>
		<label>High School:</label>
		<span> 
			<select name="fldSchool" id="fldSchool" style="width:276px" >
			<!--onchange="select_val(this.value)"-->
			<option value="select" class="selectgrey">Select High School</option>
		   <?php
			#$categorylist = $func -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldState");
			#for ($i = 0; $i < count($categorylist); $i++) {
				#echo '<option value ="' . $categorylist[$i]['fldId'] . '" >' . $categorylist[$i]['fldSchoolname'] . '</option>';
			#}
			
			$statelist = $func2 -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldState", "fldState", "WHERE fldStatus='ACTIVE'");
			for ($x = 0; $x < count($statelist); $x++) {
				echo '<optgroup label="========' . $statelist[$x]['fldState'] . '========">';
				#echo '<option value ="' . $statelist[$x]['fldState'] . '" >' . $statelist[$x]['fldState'] . '</option>';
				
				$whereclaus = "WHERE fldState = '" . $statelist[$x]['fldState'] . "' ";
				
				$categorylist = $func -> selectTableOrder(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldSchoolname", $whereclaus);
				for ($i = 0; $i < count($categorylist); $i++) {
					?><option value ="<?php echo $categorylist[$i]['fldId'];?>"<?php if($categorylist[$i]['fldId']==$fldSchool){?> selected="selected" <?php } ?> ><?php echo $categorylist[$i]['fldSchoolname'];?></option><?php
			   }
				
				echo '<option value ="other" class="addcustom_normal">**** Other (Add Your School) ****</option>';
				
				echo '</optgroup>';
			}
			
			echo '<option value ="other" class="addcustom">Not Listed? Add Your School</option>';
			echo $strcombo = '</select>';
			
			?></span><font color="#0000ff">*</font>
		</p>
		<p id="txtschoolothers" style="display:none; margin-top:5px;">
			<label>&nbsp;</label>
			<span>
				<input type="hidden" name="fldOthers" id="txtschoolothers" value="<?=$fldOthers?>">
			</span>
		</p>
		<p id="AjaxResponse" ></p>
		
		<p>
			<label>AAU Coach Name:</label>
			<span>
				<input type="text" name="fldAAUCoachName" id="fldAAUCoachName1" value="<?php echo $fldAAUCoachName; ?>"
				>
			</span>
		</p>
		
		 <p>
		<label>HS/AAU Team:</label>
		<span> 
			<select name="fldAAUSchool" id="fldAAUSchool" style="width:276px" > <!--onchange="selectAAUschool(this.velue)"-->
			<option value="select" class="selectgrey">Select HS/AAU Team</option>
		   <?php
			#$categorylist = $func -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldState");
			#for ($i = 0; $i < count($categorylist); $i++) {
				#echo '<option value ="' . $categorylist[$i]['fldId'] . '" >' . $categorylist[$i]['fldSchoolname'] . '</option>';
			#}
			
			$statelist = $func2 -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldState", "fldState", "WHERE fldStatus='ACTIVE'");
			for ($x = 0; $x < count($statelist); $x++) {
				echo '<optgroup label="========' . $statelist[$x]['fldState'] . '========">';
				#echo '<option value ="' . $statelist[$x]['fldState'] . '" >' . $statelist[$x]['fldState'] . '</option>';
				
				$whereclaus = "WHERE fldState = '" . $statelist[$x]['fldState'] . "' ";
				
				$categorylist = $func -> selectTableOrder(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldSchoolname", $whereclaus);
				for ($i = 0; $i < count($categorylist); $i++) {
					?><option value ="<?php echo $categorylist[$i]['fldId'];?>"<?php if($categorylist[$i]['fldId']==$fldAAUSchool){?> selected="selected" <?php } ?> ><?php echo $categorylist[$i]['fldSchoolname'];?></option><?php
			   }
				
				echo '<option value ="other" class="addcustom_normal">**** Other (Add Your School) ****</option>';
				
				echo '</optgroup>';
			}
			
			echo '<option value ="other" class="addcustom">Not Listed? Add Your School</option>';
			echo $strcombo = '</select>';
			
			?></span>
	</p>
		<p id="txtschoolothers1" style="display:none; margin-top:5px;">
			<label>&nbsp;</label>
			<span>
				<input type="hidden" name="fldAAUOthers" id="txtschoolothers1" value="<?=$fldOthers?>">
			</span>
		</p>

		<p id="AjaxResponse1" ></p>
		
		<hr class="line" />
		<p>
			<label>Event:</label>
			<span> 
				<input type="hidden" name="fld_trance" id="fld_trance" value="<?php echo $fldTransportation; ?>" />
				<select name="fldSpecialEvent" id="fldSpecialEvent" onchange="select_val(this.value)">
				<option value="" class="selectgrey">Select Event</option>
				<?php
				$query =" Select * from ".TBL_SPECIAL_EVENT;
				$db->query($query);
				if ($db->num_rows()>0) {
				while($db->next_record())
				{
				$fldEventId = $func->output_fun($db->f('fldEventId'));
				$fldEventName = $func->output_fun($db->f('fldEventName'));
				$fldEventcurrentprice = $func->output_fun($db->f('fldEventcurrentprice'));
				$fldEventfutureprice = $func->output_fun($db->f('fldEventfutureprice')); 	
				$Early_Discount_day = $func->output_fun($db->f('Early_Discount_day'));
				$Early_discount_rate = $func->output_fun($db->f('Early_discount_rate'));
				$Transcript_discount = $func->output_fun($db->f('Transcript_discount'));
				?><option value="<?php echo $fldEventId; ?>" <?php if($fldEventId==$fldSpecialEvent){?> selected="selected"<?php }?>><?php echo $fldEventName; ?></option><?php
				}
				}
				
				?>
				</select>
			 </span><font color="#0000ff">&nbsp;*</font>
		</p>
		<input type="hidden" name="fldEventcurrentprice" id="fldEventcurrentprice" value="<?php echo $fldEventcurrentprice;?>" />
		<input type="hidden" name="fldEventfutureprice" id="fldEventfutureprice" value="<?php echo $fldEventfutureprice;?>" />
		<input type="hidden" name="Early_Discount_day" id="Early_Discount_day" value="<?php echo $Early_Discount_day;?>" />
		<input type="hidden" name="Early_discount_rate" id="Early_discount_rate" value="<?php echo $Early_discount_rate;?>" />
		<input type="hidden" name="Transcript_discount" id="Transcript_discount" value="<?php echo $Transcript_discount;?>" />
		<p>
			<label>Referred by:</label>
			<span><textarea class="ta1" id="fldReferredBy" name="fldReferredBy"><?=$fldReferredBy?></textarea></span>		</p>
		<p>
			<label>Coupon Number:</label>
			<span>
				<input type="text" name="fldCouponNumber" id="fldCouponNumber" value="<?php echo $fldCouponNumber; ?>" />
			</span>		</p>
		<div id="transportation"></div>
		<!--event Price code Start-->
		<?php /*?><div id="event_price"></div>
		<?php
			if(isset($q) && $q!=''){
			$query =" Select * from ".TBL_SPECIAL_EVENT." where fldEventId='".$q."'";
				$db->query($query);
				$db->next_record();
				$fldEventId = $func->output_fun($db->f('fldEventId'));
				$fldEventName = $func->output_fun($db->f('fldEventName'));
				$fldEventcurrentprice = $func->output_fun($db->f('fldEventcurrentprice'));
				$fldEventfutureprice = $func->output_fun($db->f('fldEventfutureprice'));
				if($class<=2013){
				$event_price=$fldEventcurrentprice;
				}else{$event_price=$fldEventfutureprice;}
		?>
		<p>
			<label>Event Price:</label>
			<span>
				<input type="text" name="EventPrice" id="EventPrice" value="<?php echo $event_price;?>"  readonly/>
			</span>
		</p>
		<?php }?><?php */?>
		<!--event Price code End-->
		<p>
			<label>Upload Transcript:</label>
			<span style="width:250px;">
			<input type="file" value="<?php echo $fldTranscript;?>" name="fldTranscript" id="fldTranscript">
			<?php /*?><img src="./transcriptfile/<?php echo $fldTranscript; ?>" alt="" /><?php */?>
			</span>
			<?php if(isset($fldTranscript) && $fldTranscript!='') {?>
			<a href="ajax_remove_trans.php?fld_id=<?php echo $fld_id;?>" id="remove_trance" style="padding-left:32px;">Remove Transcript</a>
			<?php }?>
		</p>
		<input type="hidden" name="updtranscript" id="updtranscript" value="<?php echo $fldTranscript;?>" />
		<p>
			<label>&nbsp;</label>										
			<span style="color:#444;line-height:18px;">                                            
				<font style="color:#777;">*Supported Image Types:</font>&nbsp; Files, Word and PDF<br>
				<font style="color:#777;">*If you don’t have your transcript right now, bring it to the showcase for<br /> a $5 refund at the door.</font>			</span>		</p>                                   
			<p>
				<label>&nbsp;</label>
				<span>
					<?php /*?><input type="hidden" name="userType" value="<?=($userType!="")?$userType:""?>">
					<input type="hidden" name="oldcode" value="<?=($oldcode)?$oldcode:$code?>"><?php */?>
					<input type="hidden" name="isSubmit" value="save">
					<input type="submit" name="submit" value="Register">
					<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">
				</span>			</p>
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
<script type="text/javascript">
try
{
var str=document.getElementById("fldSpecialEvent").value;
var trans_id=document.getElementById("fld_trance").value;
select_val(str,trans_id);
transport_charge('<?php echo $fldTransportation;?>');
}
catch(ex)
{
alert(ex.message);
}
</script>
<?php 
}
else
{
	$error_msg="145";
	header("location:register_msg.php?error=".$error_msg);
}
?>