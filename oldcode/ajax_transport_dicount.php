<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");

$func = new COMMONFUNC;
$db = new DB;
$fldTransportation=$_REQUEST['tp_id'];
$tbl_transportation_discount='tbl_transportation_discount';
$q=$_REQUEST["q"];
$que="select * from ".$tbl_transportation_discount." where Event_id='".$q."'";		
$db->query($que);
if ($db->num_rows()>0) {?>
<p>
	<label>Select Transportation:</label>
	<span>
	
	<select name="fldTransportation" id="fldTransportation" onchange="transport_charge(this.value)">
		 <option value="0">I have my own transportation</option>
	<?php 
	while($db->next_record())
	{
	$id=$func->output_fun($db->f('id'));
	$Event_id = $func->output_fun($db->f('Event_id'));
	$Diparture_City = $func->output_fun($db->f('Diparture_City'));
	$Departure_Time = $func->output_fun($db->f('Departure_Time'));
	$Transportation_charge = $func->output_fun($db->f('Transportation_charge')); 
	$Diparture_City." departing at ".$Departure_Time;?>  		          	         
	     <option value="<?php echo $id; ?>"<?php if($id==$fldTransportation){?> selected="selected" <?php }?> ><?php echo $Diparture_City." departing at ".$Departure_Time; ?></option>
	<?php } ?>
	</select>
	</span>
</p>
<div id="transport_disc_charge"></div>	 
<?php }?>	