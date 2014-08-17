<?php
include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");	
include_once("../inc/config.inc.php");


//for paging

$func = new COMMONFUNC;
$db = new DB;



          $q=$_GET["q"];
 if($q!='select'){
         ?>
         <tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Location<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>     
                                	<?php $query ="Select * from ".TBL_HS_AAU_TEAM. " where fldId =".$q;
	

	$db->query($query);
	$db->next_record();
	$location=$db->f('fldAddress');
			?>
			<td valign="top" align="left" class="normalblack_12"  colspan=2><textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="24"    ><?php if($location) {echo $location; }?></textarea></td>
			</tr>
			<?php
         
        
         }
         else {
         	?>
       
          <tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Location<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>                      	

	
			<td valign="top" align="left" class="normalblack_12"  colspan=2> <textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="24"    ><?php if($location) {echo $location; }?></textarea></td>
			</tr>
			<?php
         }
      
?> 
