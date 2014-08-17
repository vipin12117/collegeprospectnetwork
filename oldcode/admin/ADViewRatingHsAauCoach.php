<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		sendmsgtoath.php
##	Create Date	:		19/07/2011
##  Description :		It is use to send the message to athlete.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************
session_start();
include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");	
include_once("../inc/config.inc.php");				//for paging
$func = new COMMONFUNC;
$db = new DB;
 
$info_query="select fld_College_Coach_id, ROUND(avg(fldAthlete_contribue), 1) as fldAthlete_contribue,
ROUND(avg(fldComunication), 1) as fldComunication,
ROUND(avg(fldRequest_Game_Tape), 1) as fldRequest_Game_Tape,
ROUND(avg(fldHonest), 1) as fldHonest,
ROUND(avg(fldPrepration), 1) as fldPrepration from ".TBL_HS_AAU_COACH_RATE." where fldHs_Aau_Coach_id=".$_REQUEST['fldId'];
			$db2->query($info_query);
			$db2->next_record();
			$query_number="select * FROM ".TBL_HS_AAU_COACH_RATE." where fldHs_Aau_Coach_id=".$_REQUEST['fldId'];
			$db3->query($query_number);
			
			$db3->next_record();
			?>




<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>HS / AAU Coach Rating</b></td>
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
		
		
		       
		<?php if($db3->num_rows()>0){ ?>
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%" nowrap>How accurate was this coach in projecting the level at which the athlete can contribute? </td>
		<td class="normalblack_12" valign="top" nowrap><?php echo $db2->f('fldAthlete_contribue'); ?>  with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		 
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%" nowrap>How prompt was this coach in responding to your communications?</td>
		<td class="normalblack_12" valign="top" nowrap><?php echo $db2->f('fldComunication'); ?>  with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%" nowrap>How prompt was this coach in responding to your requests for game tape? </td>
		<td class="normalblack_12" valign="top" nowrap><?php echo $db2->f('fldRequest_Game_Tape'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%" nowrap>How honest was the coach in your interactions with him/her? </td>
		<td class="normalblack_12" valign="top" nowrap><?php echo $db2->f('fldHonest'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%" nowrap>How well does this coach prepare his/her athlete's for college sports? </td>
		<td class="normalblack_12" valign="top" nowrap><?php echo $db2->f('fldPrepration'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		
		
		
		<?php } else {?>
		
<tr>
		
		<td class="normalblack_12" valign="top" nowrap>HS / AAU Coach Not Rated by College Coach</td>
		<td class="normalblack_12" valign="top" height="25" width="40%" nowrap><b>&nbsp;</b> </td>
		</tr>
		<?php }?>
		
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