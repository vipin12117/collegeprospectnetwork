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
		<table width="130%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="130%" align="center">
		<table width="100%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="130%" class="SearchHead"><b>Special Event Details Report</b></td>
		</tr>
		<tr>
		<td width="130%" class="GeneralFont">&nbsp;</td>
		</tr>
		<tr>
		<td width="130%">
		<table width="130%" cellspacing="0" cellpadding="2">
		<tr>
		<td width="130%" valign="top">
			<table width="130%" cellspacing="0" cellpadding="3">
			<tr><td colspan="16"><input type="button" name="export" value="Export" onClick="window.location.href='ADSpecialReportExport.php'" style="float:left;"></td></tr>
			<tr>
			<td class="normalblack_12" valign="top" height="25" width="3%"><b>No</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="9%"><b>Special Event Name</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="5%"><b>First Name</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="5%"><b>Last Name</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="6%"><b>Email Address(for Receipt)</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="7%"><b>Address</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="4%"><b>City</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="4%"><b>State</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="3%"><b>Zip Code</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="4%"><b>Phone Number</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="9%"><b>Referred by</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="5%"><b>Location</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="5%"><b>Start Date</b> </td>
			<?php /*?><td class="normalblack_12" valign="top" height="25" width="5%"><b>End Date</b> </td><?php */?>
			<td class="normalblack_12" valign="top" height="25" width="4%"><b>Price</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="5%"><b>Payment Status</b> </td>
			<td class="normalblack_12" valign="top" height="25" width="5%"><b>Register Date</b> </td>
			</tr>
		   <?php /*?><tr>
			<td class="normalblack_12" valign="top" height="25" width="40%"><b>Sport</b> </td>
			<td class="normalblack_12" valign="top"><?=$sport_nmae?></td>
			</tr>
			<tr>
			<td class="normalblack_12" valign="top" height="25" width="40%"><b>Home Team</b> </td>
			<td class="normalblack_12" valign="top"><?=$team_name?></td>
			</tr>
			<tr>
			<td class="normalblack_12" valign="top" height="25" width="40%"><b>Away Team</b> </td>
			<td class="normalblack_12" valign="top"><?= $team_AwayTeam?></td>
			</tr><?php */?>
			<?php
				$c=0;
				$query ="Select * from ".TBL_SPECIAL_EVENT_REGISTER." sr,".TBL_SPECIAL_EVENT. " se where sr.fldpaymentstatus='PAID' AND sr.fldSpecialEvent !='' AND se.fldEventStatus='1' order by sr.fldId";
				$res=$db->query($query);
				while($arr=mysql_fetch_array($res))
				{$c++;
				$fldfldId = $arr['fldId'];
				$fldFirstName=$arr['fldFirstName'];
				$fldLastName=$arr['fldLastName'];
				$fldAddress=$arr['fldAddress'];
				$fldCity=$arr['fldCity'];
				$fldState=$arr['fldState'];
				$fldZipCode=$arr['fldZipCode'];
				$fldPhone=$arr['fldPhone'];
				$fldEmail=$arr['fldEmail'];
				$fldSpecialEvent=$arr['fldSpecialEvent'];
				$fldReferredBy=$arr['fldReferredBy'];
				$fldTranscript=$arr['fldTranscript'];
				$fldprice=$arr['fldprice'];
				$fldpaymentstatus=$arr['fldpaymentstatus'];
				$fldAddDate=$arr['fldAddDate'];
				/*$query_sport ="Select * from ".TBL_SPECIAL_EVENT. " where fldEventId = '$fldSpecialEvent' ";
				$db1->query($query_sport);
				$db1->next_record()*/;
				$fldEventName1=$arr['fldEventName'];
				$fldEventLocation1=$arr['fldEventLocation'];
				$fldEventStartDate1=$arr['fldEventStartDate'];
				$fldEventEndDate1=$arr['fldEventEndDate'];
		?>
			<tr>
			<td class="normalblack_12" valign="top"><?=$c?></td>
			<td class="normalblack_12" valign="top"><?=$fldEventName1?></td>
			<td class="normalblack_12" valign="top"><?=$fldFirstName?></td>
			<td class="normalblack_12" valign="top"><?=$fldLastName?></td>
			<td class="normalblack_12" valign="top"><?=$fldEmail?></td>
			<td class="normalblack_12" valign="top"><?=$fldAddress?></td>
			<td class="normalblack_12" valign="top"><?=$fldCity?></td>
			<td class="normalblack_12" valign="top"><?=$fldState?></td>
			<td class="normalblack_12" valign="top"><?=$fldZipCode?></td>
			<td class="normalblack_12" valign="top"><?=$fldPhone?></td>
			<td class="normalblack_12" valign="top"><?=$fldReferredBy?></td>
			<td class="normalblack_12" valign="top"><?=$fldEventLocation1?></td>
			<td class="normalblack_12" valign="top"><?=$fldEventStartDate1?></td>
			<?php /*?><td class="normalblack_12" valign="top"><?=$fldEventEndDate1?></td><?php */?>
			<td class="normalblack_12" valign="top"><?=$fldprice?></td>
			<td class="normalblack_12" valign="top"><?=$fldpaymentstatus?></td>
			<td class="normalblack_12" valign="top"><?=$fldAddDate?></td>
			</tr>
		<?php } ?>
			<tr>		
			<td class="normalblack_12" valign="top" colspan="2">&nbsp;</td>
			</tr>
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