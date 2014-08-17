<?php
include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");	
include_once("../inc/config.inc.php");


//for paging

$func = new COMMONFUNC;
$db = new DB;

$q=$_GET['q'];

       if($q=="other")
         {
         	
         	$other_info=$func->selectTableOrder(TBL_OTHER,"fldId,fldName","fldId"," where fldUserId ='".$_GET['fldUserName']."'");
         	
         	$college_address_other_info=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where fldStatus =0 and fldId='".$other_info[0]['fldId']."'");
         	?>
         	<table align="center"  border="0" align="center" width="60%">
         	<tr height="20">
                 
			<td valign="top" align="right" class="normalblack_12" width="30%">College Name<font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <input type="text" name="txtfldName" id="txtfldName" style="width:200px;" value="<?=$other_info[0]['fldName']?>" readonly >
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
         	 <tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Address <font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <textarea rows=5 cols=23 name=fldAddress><?=$college_address_other_info[0]['fldAddress']?></textarea>
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">City <font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <input type="text" name="fldCity" id="fldCity" value="<?=$college_address_other_info[0]['fldCity']?>" style="width:200px;"> 
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>

			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">State<font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <input type="text" name="fldState" id="fldState" value="<?=$college_address_other_info[0]['fldState']?>" style="width:200px;" 
             >
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Zip Code<font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <input type="text" name="fldZipCode" id="fldZipCode" value="<?=$college_address_other_info[0]['fldZipCode']?>" style="width:200px;" 
             >
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			</table>
         	<?php
         }
         else if(($q!='select')&&($q!="other")){
         	
         	
        $college_address_info=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where fldStatus =1 and fldId=".$q);
       //  print_r($college_address_info);
         	?>
         	
         	<table align="center"  border="0" align="center" width="60%">
         <tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Address <font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <textarea rows=5 cols=23 name=fldAddress><?=$college_address_info[0]['fldAddress']?></textarea>
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">City <font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <input type="text" name="fldCity" id="fldCity" value="<?=$college_address_info[0]['fldCity']?>" style="width:200px;"> 
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>

			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">State<font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <input type="text" name="fldState" id="fldState" value="<?=$college_address_info[0]['fldState']?>" style="width:200px;" 
             >
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Zip Code<font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <input type="text" name="fldZipCode" id="fldZipCode" value="<?=$college_address_info[0]['fldZipCode']?>" style="width:200px;"
             >
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
                                 
           </table>                        

         	<?php
         }
        
      
?> 




  

                             