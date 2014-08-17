<?php
include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");	
include_once("../inc/config.inc.php");


//for paging

$func = new COMMONFUNC;
$db = new DB;

         $q=$_GET["q"];
         $selquery = 'select s.fldSportsname as name,s.fldId as id from tbl_sports s,'.TBL_HS_AAU_TEAM_COACH.' ts where s.fldId=ts.sportid and ts.schoolid ='.$q;
	
   	$db->query($selquery);
	$db->next_record();

	 $strcombo = '';
	 $strcombo .= '<select name="fldSport" style="width:220px" onChange="getCoachID(this.value);">';	 
	 $strcombo .= '<option value = "">Select Sport</option>';
	 
	 for ($i=0;$i<$db->num_rows();$i++) 
	   {
	   	 $strcombo .='<option value="'.$db->f('id').'">';
	   	 $strcombo .= $db->f('name').'</option>';
	   	 $db->next_record();
	   }
  	 echo  $strcombo .= '</select>';
  	
   
  	
  	
?> 




  

                             