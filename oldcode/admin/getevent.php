<?php
include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");	
include_once("../inc/config.inc.php");


//for paging

$func = new COMMONFUNC;
$db = new DB;
//$flag=1;



          $q=$_GET["q"];
         if($q!='select'){
         ?>
        <tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>     
                                	
			
			<td valign="top" align="left" class="normalblack_12"  colspan=2><input type="text" name="fldEventName" id="fldEventName" value="<?php echo $_GET['HomeTeam']." versus ".$_GET['AwayTeam']; ?>" style="width:220px;" ></td></tr>
			<?php
         
        
         }
         else {
         	 ?>
          <tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>     
                                	
			
			<td valign="top" align="left" class="normalblack_12"  colspan=2><input type="text" name="fldEventName" id="fldEventName"   ></td></tr>
			<?php
         }
         
         
      
?> 




  

                             