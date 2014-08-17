		<?php
		##******************************************************************
		##  Project		:		Reusable Component- Synapse - Admin Panel
		##  Done by		:		Manish Arora
		##	Page name	:		ADUserDetails.php
		##	Create Date	:		23/06/2009
		##  Description :		It is use to show the details of User.
		##	Copyright   :       Synapse Communications Private Limited.
		## *****************************************************************

		include_once("../inc/common_functions.php");		//for common function
			
		$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC


    
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
		<HTML>
		<HEAD>
		<TITLE>Coach Details</TITLE>
		<link href="css/styles.css" rel="stylesheet" type="text/css">
		</HEAD>
		<BODY>
		<?php
		$fldId = $_REQUEST['fldId'];

		$query ="Select * from ".TBL_SPECIAL_EVENT_REGISTER. " where fldId = '$fldId' ";

		$db->query($query);
		$db->next_record();
		$fldfldId 		       = $db->f('fldId');
		$fldFirstName=$db->f('fldFirstName');
		$fldLastName=$db->f('fldLastName');
		$fldAddress=$db->f('fldAddress');
		$fldCity=$db->f('fldCity');
		$fldState=$db->f('fldState');
		$fldZipCode=$db->f('fldZipCode');
		$fldPhone=$db->f('fldPhone');
		$fldEmail=$db->f('fldEmail');
		$fldSpecialEvent=$db->f('fldSpecialEvent');
        $fldReferredBy=$db->f('fldReferredBy');
       	$fldTranscript=$db->f('fldTranscript');
		$fldCouponNumber=$db->f('fldCouponNumber');
		$fldTransportation 	=$db->f('fldTransportation');
		$fldAddDate=$db->f('fldAddDate');
        
       	$query_sport ="Select * from ".TBL_SPECIAL_EVENT. " where fldEventId = '$fldSpecialEvent' ";

		$db1->query($query_sport);
		$db1->next_record();
       	$fldEventName=$db1->f('fldEventName');
		$Early_Discount_day = $db1->f('Early_Discount_day');
		$fldEventStartDate = $db1->f('fldEventStartDate');
		?>
		<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>Special Event Register Details</b></td>
		</tr>
		<tr>
		<td width="100%" class="GeneralFont">&nbsp;</td>
		</tr>
		<tr>
		<td width="100%">
		<table width="100%" cellspacing="0" cellpadding="2">
		<tr>
		<td width="100%" valign="top">
		<table width="100%" cellspacing="0" cellpadding="3">
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>First Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldFirstName?></td>
		</tr>
    	<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Last Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldLastName?></td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Address</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldAddress?></td>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>City</b> </td>
		<td class="normalblack_12" valign="top"><?= $fldCity?></td>
		</tr>

		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>State</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldState?></td>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Zip Code</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldZipCode?></td>
		</tr>
<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Phone Number</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldPhone?></td>
		</tr>
<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Email Address (for Receipt)</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEmail?></td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Special Event</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEventName?></td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Referred by</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldReferredBy?></td>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Transportation</b> </td>
		<td class="normalblack_12" valign="top"><?php if($fldTransportation!='0' && $fldTransportation !=''){ echo "Yes";}else{echo "No";}?></td>
		</tr>
		<?php   //echo $fldEventStartDate;
				//echo $fldAddDate;//7day
				$addate =strtotime($fldAddDate);
				$evedate=strtotime($fldEventStartDate);
		?>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Early Register</b> </td>
		<td class="normalblack_12" valign="top">
		<?php if($addate<$evedate)
				{
					echo "Yes";
				}
				else
				{
					echo "No";
				}?></td>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Transcript</b> </td>
		<?php if(isset($fldTranscript) && $fldTranscript!=''){?>
		<td class="normalblack_12" valign="top"><a href="https://www.collegeprospectnetwork.com/<?php echo $fldTranscript; ?>" target="_blank">Download Transcript</a></td>
		<?php }else{ ?>
		<td class="normalblack_12" valign="top"> No </td>
		<?php }?>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Coupon</b> </td>
		<td class="normalblack_12" valign="top">
		<?php if(isset($fldCouponNumber) && $fldCouponNumber!='')
		{ echo "Yes";}else{ echo "No";}?></td>
		</tr>
<?php /*?><tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>End date</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEventEndDate?></td>
		</tr><?php */?>
<?php /*?><tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Status</b> </td>
		<td class="normalblack_12" valign="top"><?php if($fldEventStatus==1){ ?>Active<?php }else { ?>FULL<?php  } ?> </td>
		</tr>

		<tr>		
		<td class="normalblack_12" valign="top" colspan="2">&nbsp;</td>
		</tr><?php */?>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%" colspan="2"><input type=button value="Close" onClick="javascript:window.close();"></td>		
		</tr>

		</table>
		</td>

		</tr>
		</table>
		</td>
		</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td width="100%" align="center">&nbsp;</td>
		</tr>
		</table>
		</BODY>
		</HTML><? unset($func); unset($db); ?>