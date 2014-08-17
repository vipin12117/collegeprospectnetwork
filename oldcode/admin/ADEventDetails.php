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
		$fldEventId = $_REQUEST['fldEventId'];

		$query ="Select * from ".TBL_EVENT. " where fldEventId = '$fldEventId' ";

		$db->query($query);
		$db->next_record();
		$fldfldEventId 		       = $db->f('fldEventId');
		$fldEventName=$db->f('fldEventName');
		$fldSport=$db->f('fldSport');
		$fldEventDescription=$db->f('fldEventDescription');
		$fldEventLocation=$db->f('fldEventLocation');
		$fldEventStartDate=$db->f('fldEventStartDate');
		$fldEventEndDate=$db->f('fldEventEndDate');
		$fldHomeTeam=$db->f('fldHomeTeam');
        $fldAwayTeam=$db->f('fldAwayTeam');
       	$fldEventStatus=$db->f('fldEventStatus');
        
       	$query_sport ="Select * from ".TBL_SPORTS. " where fldId = '$fldSport' ";

		$db1->query($query_sport);
		$db1->next_record();
       	$sport_nmae=$db1->f('fldSportsname');
$query_School ="Select * from ".TBL_HS_AAU_TEAM. " where fldId = '$fldHomeTeam' ";

		$db2->query($query_School);
		$db2->next_record();
       	$team_name=$db2->f('fldSchoolname');
		
       	
       	$sport_nmae=$db1->f('fldSportsname');
 $query_AwayTeam ="Select * from ".TBL_HS_AAU_TEAM. " where fldId = '$fldAwayTeam' ";

		$db3->query($query_AwayTeam);
		$db3->next_record();
       	$team_AwayTeam=$db3->f('fldSchoolname');
		
				
		?>
		<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>Event Details</b></td>
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
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Event Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEventName?></td>
		</tr>
       
		 
		<tr>
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
		</tr>

		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Event Detail</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEventDescription?></td>
		</tr>
<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Event Location</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEventLocation?></td>
		</tr>
<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Start Date</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEventStartDate?></td>
		</tr>
		
		

<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>End date</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEventEndDate?></td>
		</tr>
<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Status</b> </td>
		<td class="normalblack_12" valign="top"><?php if($fldEventStatus==1){ ?>Active<?php }else { ?>DeActive<?php  } ?> </td>
		</tr>

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