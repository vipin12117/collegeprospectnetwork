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
		//include("include/ADsessionAdmin.php");			// for admin login
		$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC


    
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
		<HTML>
		<HEAD>
		<TITLE>High School / AAU Coach  Details</TITLE>
		<link href="css/styles.css" rel="stylesheet" type="text/css">
		</HEAD>
		<BODY>
		<?php
		$fldId = $_REQUEST['fldId'];

		$query =" Select * from ".TBL_HS_AAU_COACH. " where fldId = '$fldId' ";

		$db->query($query);
		$db->next_record();
		$fldId 		           = $db->f('fldId');
		$fldName 	           = $func->output_fun($db->f('fldName'));
		$fldEmail 		       = $func->output_fun($db->f('fldEmail'));
		$fldPhone 		       = $func->output_fun($db->f('fldPhone'));
		$fldStatus 	           = $func->output_fun($db->f('fldStatus'));
        
        
	
        
		
				
		?>
		<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>Coach Details</b></td>
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
		<td class="normalblack_12" valign="top"><b>Name</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldName?></td>			
		</tr>
    


		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Email</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEmail?></td>
		</tr>
        
		 <tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Phone</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldPhone?></td>
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