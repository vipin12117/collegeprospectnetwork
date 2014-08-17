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

		$query ="Select * from ".TBL_SPORTS. " where fldId = '$fldId' ";

		$db->query($query);
		$db->next_record();
		$fldId 		       = $db->f('fldId');
		
		$fldSportsname	   = $func->output_fun($db->f('fldSportsname'));
	
		$fldDescription	   = $func->output_fun($db->f('fldDescription'));
        $fldStatus 	       = $func->output_fun($db->f('fldStatus'));
        
     
    
        
		
				
		?>
		<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>Sports Details</b></td>
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
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Sports Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldSportsname?></td>
		</tr>
       
		 
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Description</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldDescription?></td>
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