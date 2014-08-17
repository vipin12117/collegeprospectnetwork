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
		<TITLE>Athlete Details</TITLE>
		<link href="css/styles.css" rel="stylesheet" type="text/css">
		</HEAD>
		<BODY>
		<?php
		$fldId = $_REQUEST['fldId'];

		$info_query="select fldAthlete_id, ROUND(avg(fldLeaderShip), 1) as fldLeaderShip,
ROUND(avg(fldWork_Ethic), 1) as fldWork_Ethic,
ROUND(avg(fldPrimacy_Go_To_Guy), 1) as fldPrimacy_Go_To_Guy,
ROUND(avg(fldMental_Toughness), 1) as fldMental_Toughness,
ROUND(avg(fldComposure), 1) as fldComposure,
ROUND(avg(fldAwareness), 1) as fldAwareness,
ROUND(avg(fldInstincts), 1) as fldInstincts,
ROUND(avg(fldVision), 1) as fldVision,
ROUND(avg(fldConditioning), 1) as fldConditioning,
ROUND(avg(fldPhysical_Toughness), 1) as fldPhysical_Toughness,
ROUND(avg(fldTenacity), 1) as fldTenacity,
ROUND(avg(fldHustle), 1) as fldHustle,

ROUND(avg(fldStrength), 1) as fldStrength from ".TBL_RATING." where fldAthlete_id=".$_REQUEST['fldId'];
			$db2->query($info_query);
			$db2->next_record();
			$query_number="select * FROM tbl_rating where fldAthlete_id=".$_REQUEST['fldId'];
			$db3->query($query_number);
			
			$db3->next_record();

		
        
    
   
        
			
		$Athleteflag=0;
		 
		$whereClause1 = "fldAthlete_id=".$_REQUEST['fldId'];

   				
   				if($db->MatchingRec(TBL_RATING,$whereClause1)>0) 
		       {    
			   $Athleteflag++;
			   } 
	        
        
		
				
		?>
		<table width="100%" cellpadding="3" cellspacing="5">
		<tr>
		<td width="100%" align="center">
		<table width="95%" cellpadding="0" cellspacing="3">
		<tr>
		<td width="100%" class="SearchHead"><b>Athlete Rating</b></td>
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
		
		
		       
		<?php if($Athleteflag==1){ ?> 
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Leadership</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldLeaderShip'); ?>  with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		 
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Work Ethic</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldWork_Ethic'); ?>  with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Primacy (Go-To Guy)</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldPrimacy_Go_To_Guy'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Mental Toughness</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldMental_Toughness'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Composure</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldComposure'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Awareness</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldAwareness'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Instincts</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldInstincts'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Vision</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldVision'); ?> with <?php echo $db3->num_rows();?>  votes</span></td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Conditioning</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldConditioning'); ?> with <?php echo $db3->num_rows();?>  votes</span></td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Physical Toughness</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldTenacity'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Tenacity</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldTenacity'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Hustle</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldHustle'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Strength</b> </td>
		<td class="normalblack_12" valign="top"><?php echo $db2->f('fldStrength'); ?> with <?php echo $db3->num_rows();?>  votes</td>
		</tr>
		
		<?php } else {?>
		
<tr>
		
		<td class="normalblack_12" valign="top">Athlete Not Rated by HS/AAU Coach</td>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>&nbsp;</b> </td>
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