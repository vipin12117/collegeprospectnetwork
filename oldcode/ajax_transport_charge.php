<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");

$func = new COMMONFUNC;
$db = new DB;
$tbl_transportation_discount='tbl_transportation_discount';
$c=$_REQUEST["c"];
$que="select * from ".$tbl_transportation_discount." where id='".$c."'";		
$db->query($que);
if ($db->num_rows()>0) {?>
	<?php 
	while($db->next_record())
	{
	$Transportation_charge = $func->output_fun($db->f('Transportation_charge')); 
	} ?>

<p>
<label>Transportation Charge:</label>
<span>
<input type="text" name="Transportation_charge" id="Transportation_charge" value="<?php echo $Transportation_charge; ?>" readonly />
<!-- <span style="color:#444;line-height:18px;margin-left:230px;">
<font style="color:#777;">* We provide Transportation for Event and our charge is $20 <br />from sterling high school.<br></font>
<font style="color:#777;">* Bus leave at 6:15am & back at 8:00 pm<br />* If you want to interesting so selecting above Select Transportation</font>-->   								    
</span>
</p>                                   
</p>	 
<?php }?>	
