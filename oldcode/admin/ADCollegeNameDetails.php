		<?php
		##******************************************************************
		##  Project		:		Reusable Component- Synapse - Admin Panel
		##  Done by		:		Narendra Singh
		##	Page name	:		ADAthleteDetails.php
		##	Create Date	:		25/07/2011
		##  Description :		It is use to show the details of athlete.
		##	Copyright   :       Synapse Communications Private Limited.
		## *****************************************************************

		include_once("../inc/common_functions.php");		//for common function
		$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC


    
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
		<HTML>
		<HEAD>
		<TITLE>College Name Details</TITLE>
		<link href="css/styles.css" rel="stylesheet" type="text/css">
		</HEAD>
		<BODY>
		<?php
		$fldId = $_REQUEST['fldId'];

		$query =" Select * from ".TBL_COLLEGE. " where fldId = '$fldId' ";

		$db->query($query);
		$db->next_record();		  
        
       
				
		?>
		<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>College Details</b></td>
		</tr>
		<tr>
		<td width="100%" class="GeneralFont">&nbsp;</td>
		</tr>
		<tr>
		<td width="100%">
		<table width="100%" cellspacing="0" cellpadding="2">
		       
		 
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$db->f('fldName');?></td>
		</tr>
		
		 <tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Address</b> </td>
		
		<td class="normalblack_12" valign="top"><?=$db->f('fldAddress')?></td>
		</tr>
			<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>City</b> </td>
		
		<td class="normalblack_12" valign="top"><?=$db->f('fldCity')?></td>
		</tr>	
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>State</b> </td>
		
		<td class="normalblack_12" valign="top"><?=$db->f('fldState')?></td>
		</tr>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Zip Code</b> </td>
		
		<td class="normalblack_12" valign="top"><?=$db->f('fldZipCode')?></td>
		</tr>	
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Divison</b> </td>
		
		<td class="normalblack_12" valign="top"><?=$db->f('fldDivison')?></td>
		</tr>	
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Status</b> </td>
		<td class="normalblack_12" valign="top"><?php if($db->f('fldStatus')==1) echo "Active"; else echo "DeActive";?></td>
		</tr>
		

		
		
		</table></td>
		
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