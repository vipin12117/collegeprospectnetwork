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
	$tbl_transportation_discount='tbl_transportation_discount';
	//if(isset($_REQUEST['register'])){
	//$_REQUEST['fld_id'] = $_SESSION['fld_id'];
	if(isset($_REQUEST['fld_id']) && $_REQUEST['fld_id']!=''){
	
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
		$fldAAUSchool=$row['HS_AAU_Team'];
		$fldOthers=$row['fldOthers'];
		$fldAAUCoachName=$row['fldAAUCoachName'];
		$fldCouponNumber=$row['fldCouponNumber'];
		$fldTransportation=$row['fldTransportation'];
		if(isset($row['fldTranscript']))
		{
		$fldTranscript =$row['fldTranscript'];
		}
		$fldprice =$row['fldprice'];
		$fldpaymentstatus =$row['fldpaymentstatus'];
		
		$evquery ="SELECT * FROM ".TBL_SPECIAL_EVENT." WHERE `fldEventId` ='".$fldSpecialEvent."' ";				        $db->query($evquery);
		$db->next_record();
		$fldEventStatus = $func->output_fun($db->f('fldEventStatus'));
		$fldEventStartDate = $func->output_fun($db->f('fldEventStartDate'));
		$fldEventName=$func->output_fun($db->f('fldEventName'));
		$fldEventcurrentprice = $func->output_fun($db->f('fldEventcurrentprice'));
		$fldEventfutureprice = $func->output_fun($db->f('fldEventfutureprice')); 	
		$Early_Discount_day = $func->output_fun($db->f('Early_Discount_day'));
		$Early_discount_rate = $func->output_fun($db->f('Early_discount_rate'));
		$Transcript_discount = $func->output_fun($db->f('Transcript_discount'));
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
        if ($flag == 0) {
			 //Insert data
            $fldCancelCount = 0;
            $debugstep = 1;
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
		$fldEventStartDate;
		$newdate = strtotime ( '-'.$Early_Discount_day.' day' , strtotime ( $fldEventStartDate ) ) ;
		$newdate = date ( 'Y-m-d H:i:s' , $newdate );
		$cdate =strtotime( date ( 'Y-m-d H:i:s'));
		if($cdate<=strtotime($newdate))
		{
			$fldprice=$fldprice-$Early_discount_rate;
			$EarlyWeek=$fldprice;
		}
		if(isset($fldTranscript) && $fldTranscript!='')
		{
			$fldprice=$fldprice-$Transcript_discount;
		}
		
		if($fldTransportation!="" && $fldTransportation!='0')
		{
			$trans=mysql_query("select * from ".$tbl_transportation_discount." where id='".$fldTransportation."'");
			$re=mysql_fetch_array($trans);
			$Transportation_charge=$re['Transportation_charge'];
			$fldprice=$fldprice+$Transportation_charge;
			$transportationCharge=$fldprice;
		}
		$coupon=mysql_query("select * from tbl_cupon where cpn_number='".$fldCouponNumber."' AND event_id='".$fldSpecialEvent."' AND status='1'");			
		$re=mysql_fetch_array($coupon);
		if($fldCouponNumber==$re['cpn_number'])
		{
			$fldprice=$fldprice-$re['amount'];
			$coupondiscount=$re['amount'];
		}
			//admin email start
			 	$subjectStre = "[CPN] - Event Registration";        
                #all user types   
                $bodyStre = "<br /><b>Event :</b> " .$fldEventName;
				$bodyStre .= "<br /><b>Name :</b> " . $fldFirstName. " " .$fldLastName;
                $bodyStre .= "<br /><b>Email :</b> " .$fldEmail; 
	    	    $bodyStre .= "<br /><b>Address :</b> " .$fldAddress ;     
				$bodyStre .= "<br /><b>Phone :</b> " . $fldPhone ;
				$bodyStre .= "<br /><b>City :</b> " . $fldCity;     
				$bodyStre .= "<br /><b>State :</b> " . $fldState;
				$bodyStre .= "<br /><b>Graduate Class :</b> " . $fldClass;
				$bodyStre .= "<br /><b>Primary Position :</b> " . $fldPrimaryPosition;
				$bodyStre .= "<br /><b>Secondary Position :</b> " . $fldSecondaryPosition;
				$bodyStre .= "<br /><b>HS Coach Name :</b> " . $fldHSCoachName;
				if(isset($fldSchool) && $fldSchool!='')
				{$select=mysql_query("select * from tbl_hs_aau_team where fldId='".$fldSchool."'");
				$ar=mysql_fetch_array($select);
				$fldschool=$ar['fldSchoolname']; 
				$bodyStre .= "<br /><b>School :</b> " . $fldschool;
				}
				if(isset($fldAAUCoachName) && $fldAAUCoachName!='')
				{
				$bodyStre .= "<br /><b>AAU Coach Name :</b> " . $fldAAUCoachName;
				}
				if(isset($fldCouponNumber) && $fldCouponNumber!='')
				{
				$bodyStre .= "<br /><b>Coupon Number :</b> " . $fldCouponNumber ;
				}
				$bodyStre .= "<br /><b>Referred By :</b> " . $fldReferredBy ;
				if(isset($fldTranscript)){ 
	$bodyStre .= "<br /><b>Transcript :</b><a href='http://collegeprospectnetwork.com/$fldTranscript'>Download Transcript</a>";    		}
				$bodyStre .= "<br /><b>Event Price :</b> "."$".$basicPrice;
				if($fldTransportation!='0' && $fldTransportation!=''){
				$bodyStre .= "<br /><b>Transportation :</b> +$".$Transportation_charge ; 
				}
				if(isset($EarlyWeek) && $EarlyWeek!=''){
				$bodyStre .= "<br /><b>Early Registration Discount :</b> -$".$Early_discount_rate ; 
				}
				if(isset($fldTranscript) && $fldTranscript!='') {
				$bodyStre .= "<br /><b>Upload Transcipt Discount :</b> -$".$Transcript_discount ; 
				}
				if(isset($fldCouponNumber) && $fldCouponNumber!='') {
				$bodyStre .= "<br /><b>Coupon Discount :</b>"."$".$coupondiscount; 
				}
				$bodyStre .= "<br /><b>Event Total Price :</b> "."$".$fldprice;    
				$bodyStre .= "<br /><b>Payment Status:</b> " .$_SESSION['PAYSTATUS'];
              	$adminmail=ADMIN_EMAIL.",".EMAIL_FROM;
				//$func -> sendEmail($adminmail, $subjectStre, $bodyStre, $fldEmail);
				SendHTMLMail1($adminmail, $subjectStre, $bodyStre, $fldEmail);
				$athletsubject="College Prospect Network - Event Registration is Successfull";
				//$func -> sendEmail($fldEmail,$athletsubject, $bodyStre, $adminmail);
				SendHTMLMail1($fldEmail, $athletsubject, $bodyStre,ADMIN_EMAIL);
				//echo $bodyStre;exit;
                //$msg = "Thank you for your registration";
			##INSERT EVent###
         	 $debugstep = 2;
          $strDataArr = array('fldpaymentstatus' => $_SESSION['PAYSTATUS']);
			//$strDataArr = array('fldpaymentstatus' => 'PAID');
		  if(isset($_REQUEST['fld_id']) && $_REQUEST['fld_id']!='')
		  {
		  	$where_reg_update = "fldId  = ".$_REQUEST['fld_id'];
		  	$result = $db -> updateRec(TBL_SPECIAL_EVENT_REGISTER,$strDataArr,$where_reg_update);
		  }
		  $error_msg="Registration Successfully";
		  $debugstep = 3;
          }
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
							<h1>Event Registration Confirmation</h1>
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
								<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
									<p><input name="fld_id" id="fld_id" type="hidden" value="<?php echo $_REQUEST['fld_id'];?>" />
										<label>First Name:</label>
										<span><?=$fldFirstName?>
										</span>
									
									</p>
									<p>
										<label>Last Name:</label>
										<span><?=$fldLastName?></span>
									</p>
									<p>
										<label>Address:</label>
										<span><?=$fldAddress?></span>
									</p>
									<p>
										<label>Email Address (for Receipt):</label>
										<span><?=$fldEmail?></span>
									</p>
									<p>
										<label>City:</label>
										<span><?=$fldCity?></span>
									</p>
									<p>
										<label>State:</label>
										<span><?=$fldState?></span>
									</p>
									<p>
										<label>Zip Code:</label>
										<span><?=$fldZipCode?></span>
									</p>
									<p>
										<label>Phone Number:</label>
										<span><?=$fldPhone?></span>
									</p>
									<p>
										<label>Graduating Class: </label>
										<span><?=$fldClass?></span>
									</p>
									<p>
										<label>Primary Position:</label>
										<span><?=$fldPrimaryPosition?></span>
									</p>
									<p>
										<label>Secondary Position:</label>
										<span><?=$fldSecondaryPosition?></span>
									</p>
									<p>
										<label>HS Coach Name:</label>
										<span><?=$fldHSCoachName?></span>
									</p>
									<?php if(isset($fldSchool) && $fldSchool!='' && $fldSchool!='select') {?> 
									<p>
										<label>School Name:</label>
										<span><?php $select=mysql_query("select * from tbl_hs_aau_team where fldId='".$fldSchool."'");$ar=mysql_fetch_array($select); echo $ar['fldSchoolname'];?></span>
									</p>
									<?php } if($fldAAUCoachName!='') {?>
									<p>
										<label>AAU Coach Name:</label>
										<span><?=$fldAAUCoachName?></span>
									</p>
									<?php } if($fldAAUSchool!='select' && $fldAAUSchool!='') {?>
										<p>
											<label>HS AAU Team:</label>
											<span><?php $select=mysql_query("select * from tbl_hs_aau_team where fldId='".$fldAAUSchool."'");$ar=mysql_fetch_array($select); echo $ar['fldSchoolname'];?></span>
										</p>
										<?php } ?>
									<hr class="line" />
									<p>
                                        <label>Event:</label>
                                        <span><?php echo $fldEventName;?></span>
                                    </p>
									<p>
                                        <label>Event Srart Date:</label>
                                        <span><?php echo $fldEventStartDate;?></span>
                                    </p>
									<?php if(isset($fldReferredBy) && $fldReferredBy!=''){?>
									<p>
										<label>Referred by:</label>
										<span><?=$fldReferredBy?></span>
									</p>
									<?php } if(isset($fldCouponNumber) && $fldCouponNumber!='') {?>
									<p>
										<label>Coupon Number:</label>
										<span><?=$fldCouponNumber?></span>
									</p>
									<?php } if(isset($fldTranscript) && $fldTranscript!='') {?>
									<p>
										<label>Transcript:</label>
										<span style="width:250px;"><a href="http://collegeprospectnetwork.com/<?php echo $fldTranscript; ?>">Download Transcript</a>
										</span>
									</p>
									<?php }?>
									<hr class="line" />
									<p>
										<label>Event Price:</label>
										<span>$<?=$basicPrice?></span>
									</p>
									<?php if(isset($fldTransportation) && $fldTransportation!='0' && $fldTransportation!=''){?>
									<p>
										<label>Transportation Charge :</label>
										<span>+$<?php echo $Transportation_charge; ?></span>
									</p>
									<?php } if(isset($EarlyWeek) && $EarlyWeek!=''){?>
									<p>
										<label>Early Registration Discount:</label>
										<span>-$<?php echo $Early_discount_rate;?></span>
									</p>
									<?php } if(isset($fldTranscript) && $fldTranscript!='') {?>
									<p>
										<label>Upload Transcipt Discount:</label>
										<span>-$<?php echo $Transcript_discount;?></span>
									</p>
									<?php }if(isset($fldCouponNumber) && $fldCouponNumber!='') {?>
									<p>
										<label>Coupon Discount:</label>
										<span>-$<?=$coupondiscount?></span>
									</p>
									<?php }?>
									<hr class="line" />
									<p>
										<label>Event Total Price :</label>
										<span>$<?=$fldprice?></span>
									</p>
									<p>
											<label>&nbsp;</label>
											<span>
												<!--<input type="submit" name="register" value="Register">-->
												<INPUT TYPE="BUTTON" VALUE="Go Home" ONCLICK="window.location.href='index.php'">
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
			unset($_SESSION['fld_id']);
			unset($_SESSION['cardno']); 
			unset($_SESSION['cardtype']);
			unset($_SESSION['expmonth']);
			unset($_SESSION['expyear']);
			unset($_SESSION['securitycode']);
			unset($_SESSION['fldFirstName']);
			unset($_SESSION['fldLastName']);
			unset($_SESSION['fldPhone']);
			unset($_SESSION['fldBSAddress']);
			unset($_SESSION['fldBSCity']);
			unset($_SESSION['fldBSState']);
			unset($_SESSION['fldBSZipCode']);
		?>
	</body>
</html>