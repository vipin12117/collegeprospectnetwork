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
		<TITLE>Message</TITLE>
		<link href="css/styles.css" rel="stylesheet" type="text/css">
		</HEAD>
		<BODY>
		<?php
		$mail_id = $_REQUEST['mail_id'];

		$query =" Select * from ".TBL_MAIL. " where mail_id = '$mail_id' ";

		$db->query($query);
		$db->next_record();		  
        
        $UserTo                       = $func->output_fun($db->f('UserTo'));
		$UserFrom                     = $func->output_fun($db->f('UserFrom'));
		$Subject                      = $func->output_fun($db->f('Subject'));
		$Message                      = $func->output_fun($db->f('Message'));
		$status                       = $func->output_fun($db->f('status'));
		$SentDate                     = $func->output_fun($db->f('SentDate'));
		
   
		
	        
        
		
				
		?>
		<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>Message Details</b></td>
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
		<td class="normalblack_12" valign="top"><b>User To</b> </td>
		<td class="normalblack_12" valign="top"><?=$UserTo?></td>			
		</tr>
    


		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>User From</b> </td>
		<td class="normalblack_12" valign="top"><?=$UserFrom?></td>
		</tr>
       
		 
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Subject</b> </td>
		<td class="normalblack_12" valign="top"><?=$Subject?></td>
		</tr>
		
		
	    <tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Message</b> </td>
		<td class="normalblack_12" valign="top"><?=$Message?></td>
		</tr>
		
		
	
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Status</b> </td>
		<td class="normalblack_12" valign="top"><?=$status?></td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Sent date</b> </td>
		<td class="normalblack_12" valign="top"><?=$SentDate?></td>
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