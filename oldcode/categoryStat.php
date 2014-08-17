<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");
$func = new COMMONFUNC;
$db = new DB;
   $q=$_GET["q"];
     	
   $selquery = " Select * from ".TBL_ATHLETE_STATS_CATAGORY. " where (fldParentId ='".$q."') and (fldStatus=1)";

	
  	$db->query($selquery);
	$db->next_record();
 for($field_count=0;$field_count<$db->num_rows();$field_count++)
 {
 	$fldName=$db->f('fldName');
 	$fldId=$db->f('fldId');
 	?>
 	<p>
                                	<label><?php echo $fldName; ?> :</label>
                                    <span><input type="text" name="category[]" />
                                    <input type="hidden" name="categoryId[]" value="<?php echo $fldId; ?>">
                                   
                                    </span>
                                </p>

 	<?php
 	$db->next_record();
 }
	?>
	