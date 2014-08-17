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
		//include("include/ADsessionAdmin.php");				// for admin login
		$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC


    
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
		<HTML>
		<HEAD>
		<TITLE>College Details</TITLE>
		<link href="css/styles.css" rel="stylesheet" type="text/css">
		</HEAD>
		<BODY>
		<?php
		$fldId = $_REQUEST['fldId'];

		$query =" Select * from ".TBL_COLLEGE_COACH_REGISTER. " where fldId = '$fldId'";

		$db->query($query);
		$db->next_record();		  
        
        $fldId                      = $func->output_fun($db->f('fldId'));
		$fldCollegename             = $func->output_fun($db->f('fldCollegename'));
		$fldCity                    = $func->output_fun($db->f('fldCity'));
		$fldState                   = $func->output_fun($db->f('fldState'));
		$fldSport                   = $func->output_fun($db->f('fldNeedType'));
		$fldUserName  = $func->output_fun($db->f('fldUserName'));
		$fldAddDate  = $func->output_fun($db->f('fldAddDate'));
		$fldSubscribe = $func->output_fun($db->f('fldSubscribe'));
		$fldPosition= $func->output_fun($db->f('fldPosition'));
        $fldEmail= $func->output_fun($db->f('fldEmail'));
        $fldExpiredate= $func->output_fun($db->f('fldExpiredate'));
        $fldFirstName = $func->output_fun($db->f('fldFirstName'));
        $fldLastName = $func->output_fun($db->f('fldLastName'));
		$fldAlternativeEmail = $func->output_fun($db->f('fldAlternativeEmail'));
		$fldPhone = $func->output_fun($db->f('fldPhone'));
		$fldAlternativePhone=$func->output_fun($db->f('fldAlternativePhone'));
		$fldDescriPation= $func->output_fun($db->f('fldDescriPation'));
        $fldStatus 	                = $func->output_fun($db->f('fldStatus'));
    	$fldSubscribe      =$db->f('fldSubscribe');	
   
		 $selquery = "select fldSportsname from ".TBL_SPORTS." where fldId='".$fldSport."'";
		 $objQuery = mysql_query($selquery);
		 $numquery = mysql_num_rows($objQuery);
		 $resquery = mysql_fetch_array($objQuery);
		 $SportsName= $resquery['fldSportsname'];		
				
		?>
		<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>College Coach Details</b></td>
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
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>College Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldCollegename?></td>
		</tr>
       <tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>First Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldFirstName?></td>
		</tr>
		 <tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Last Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldLastName?></td>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Phone</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldPhone?></td>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Alternate Phone</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldAlternativePhone?></td>
		</tr>
<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Email Address</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEmail?></td>
		</tr>
				<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Alternative Email Address</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldAlternativeEmail?></td>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>City</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldCity?></td>
		</tr>
		
		
	    <tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>state</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldState?></td>
		</tr>
		
			<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Sport</b> </td>
		<td class="normalblack_12" valign="top"><?=$SportsName?></td>
		</tr>
		
			<!--$fldSubscribe -->
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Subscription Status</b> </td>
		<td class="normalblack_12" valign="top"><?php if($fldSubscribe==0){echo "Not Subscribe";}if($fldSubscribe==1){echo "Subscribe";}if($fldSubscribe==2){echo "Trial Period";}?></td>
		</tr>
		
		
	
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Status</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldStatus?></td>
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