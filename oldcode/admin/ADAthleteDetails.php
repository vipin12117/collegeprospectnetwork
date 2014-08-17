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

		$query =" Select * from ".TBL_ATHELETE_REGISTER. " where fldId = '$fldId' ";

		$db->query($query);
		$db->next_record();		  
        
        $fldUsername                     = $func->output_fun($db->f('fldUsername'));
		$fldEmail                        = $func->output_fun($db->f('fldEmail'));
		$fldFirstname                    = $func->output_fun($db->f('fldFirstname'));
		$fldLastname                     = $func->output_fun($db->f('fldLastname'));
		$fldAge                          = $func->output_fun($db->f('fldClass'));
		$fldHeight                       = $func->output_fun($db->f('fldHeight'));
		$fldWeight                       = $func->output_fun($db->f('fldWeight'));
        $fldDescription 	             = $func->output_fun($db->f('fldDescription')); 
        $fldSchool                       = $func->output_fun($db->f('fldSchool'));
		$fldSport                        = $func->output_fun($db->f('fldSport'));
        $fldImage	                     = $func->output_fun($db->f('fldImage'));
        
    
   
        
		 $selquery = "select fldSchoolname from ".TBL_HS_AAU_TEAM." where fldId='".$fldSchool."'";
		 $objQuery = mysql_query($selquery);
		 $numquery = mysql_num_rows($objQuery);
		 $resquery = mysql_fetch_array($objQuery);
		 $fldSchoolname= $resquery['fldSchoolname'];
        
        
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
		<td width="100%" class="SearchHead"><b>Athlete Details</b></td>
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
		<td align="center"><img src="../images/<?php echo $fldImage; ?>" height="200px;" width="150px;"></td>

		<td><table border="0">
		<tr>	
		<td class="normalblack_12" valign="top" height="25" width="40%"><b> Name</b> </td>
		<td class="normalblack_12" valign="top"><?=ucfirst($fldFirstname) .'&nbsp;'. ucfirst($fldLastname)?></td>
		</tr>
		       
		 
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Email</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldEmail?></td>
		</tr>
		
		 <tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Description</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldDescription?></td>
		</tr>
		
		
		<?if($SportsName != '')
		{
		?>
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Sport</b> </td>
		<td class="normalblack_12" valign="top"><?=$SportsName?></td>
		</tr>
		<?
		}
		
		if($fldSchoolname != '')
		{
		?>
	
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>School</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldSchoolname?></td>
		</tr>
		<?
		}
		?>
		
		
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Class</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldAge?></td>
		</tr>
		
		
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Height</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldHeight?></td>
		</tr>
		
		
		<tr>
		<td class="normalblack_12" valign="top" height="25" width="40%"><b>Weight</b> </td>
		<td class="normalblack_12" valign="top"><?=$fldWeight?></td>
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