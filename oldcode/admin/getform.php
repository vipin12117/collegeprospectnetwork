<?php
include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");	
include_once("../inc/config.inc.php");


//for paging

$func = new COMMONFUNC;
$db = new DB;




         $q=$_GET["q"];
         
  	
   if($q!='select')
   {
   	?>
         
         
<table align="center"  border="0" align="center" width="60%">   	
   	<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Category Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldName" id="fldName" value="<?=$fldName?>" maxlength="30" style="width: 220px;">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
				<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Category Name(Initials)<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldNameint" id="fldNameint" value="<?=$fldNameint?>" maxlength="30" style="width: 220px;">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
				
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width: 220px;font-size:12px;">
			<option value=1 <?if($fldStatus==1){ echo "selected"; }?>>ACTIVE</option>
			<option value=0 <?if($fldStatus==0){ echo "selected"; }?>>DE-ACTIVE</option>
			
			</select></td>
			</tr>
			
   	<?php
   }
  	
  	
?> 

</table>


  

                             