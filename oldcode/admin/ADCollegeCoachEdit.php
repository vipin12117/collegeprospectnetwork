<?php
##******************************************************************
##  Project		:		Reusable Component- Synapse - Admin Panel
##  Done by		:		Manish Arora
##	Page name	:		ADUserEdit.php
##	Create Date	:		23/06/2009
##  Description :		It is use to perform the operation for add/edit/delete for User.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				// for admin login

$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "2";
$error_msg = '';
$flag = 0;
$fldId = $_GET['fldId'];

if($_GET['mode']=='edit' AND $fldId!=""){
	#get the records
	 $query =" Select * from ".TBL_COLLEGE_COACH_REGISTER. " where fldId = '$fldId' ";
	
	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
		$fldUserName	= $db->f('fldUserName');
		$fldCollegename = $db->f('fldCollegename');
	    $fldStatus 	    = $db->f('fldStatus');
        $fldSubscribe   = $db->f('fldSubscribe');
		$fldPosition    = $db->f('fldPosition');		
        $fldNeedType 	= $db->f('fldNeedType');
        $fldEmail			= $db->f('fldEmail');
		$fldFirstName = $db->f('fldFirstName');
		$fldLastName=$db->f('fldLastName');
		$fldAlternativeEmail= $db->f('fldAlternativeEmail');
		$fldPhone = $db->f('fldPhone');
		$fldAlternativePhone=$db->f('fldAlternativePhone');
		$fldEnrollmentNumber=$db->f('fldEnrollmentNumber');
		$fldDivison=$db->f('fldDivison');
		if($fldCollegename!='other')
		{
			$college_address_before=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where fldStatus =1 and fldId=".$fldCollegename);
			$fldCity        = $college_address_before[0]['fldCity'];
			$fldState	    = $college_address_before[0]['fldState'];
			$fldAddress     = $college_address_before[0]['fldAddress'];
			$fldZipCode     = $college_address_before[0]['fldZipCode'];
		}
		
	}
}
else {
	    $fldUserName       = "";
	    $fldPassword       = "";
		$fldCollegename    = "";
		$fldCity           = "";
		$fldState 	       = "";
		$fldStatus 	       = "";
        $fldSubscribe      = "";
		$fldPosition       = "";		
        $fldNeedType 	   = "";
        $fldEmail			= "";
		$fldFirstName = "";
		$fldLastName="";
		$fldAlternativeEmail= "";
		$fldPhone = "";
		$fldAlternativePhone="";
		$fldDescriPation="";
		$fldAddress="";
		$fldEnrollmentNumber="";
        $fldDivison="";
}
if($_POST['isSubmit']=='save'){
	
	if($_GET['fldId']!=""){
		//Edit the user info
		$fldUserName        = $func->input_fun($_POST['fldUserName']);
		$fldPassword        = $func->input_fun($_POST['fldPassword']);
		$fldCollegename     = $func->input_fun($_POST['fldCollegename']);
		$fldCity            = $func->input_fun($_POST['fldCity']);
		$fldState           = $func->input_fun($_POST['fldState']);
		$fldStatus          = $func->input_fun($_POST['fldStatus']);
		$fldSubscribe       = $func->input_fun($_POST['fldSubscribe']);
		$fldPosition        = $func->input_fun($_POST['fldPosition']);
		$fldNeedType        = $func->input_fun($_POST['fldNeedType']);
		$fldEmail			= 		$fldDescriPation=$func->input_fun($_POST['fldEmail']);
		$fldFirstName = $func->input_fun($_POST['fldFirstName']);
		$fldLastName=$func->input_fun($_POST['fldLastName']);
		$fldAlternativeEmail= $func->input_fun($_POST['fldAlternativeEmail']);
		$fldPhone = $func->input_fun($_POST['fldPhone']);
		$fldAlternativePhone=$func->input_fun($_POST['fldAlternativePhone']);
		$fldDescriPation=$func->input_fun($_POST['fldAddress']);
		$fldAddress=$_POST['fldAddress'];
		$fldEnrollmentNumber=$_POST['fldEnrollmentNumber'];
		$fldDivison=$_POST['fldDivison'];

        if($_GET['fldId']!=$_GET['fldId'] ){
		$whereClause = "fldId='".$func->input_fun($_GET['fldId'])."'";
	
			if($db->MatchingRec(TBL_COLLEGE_COACH_REGISTER,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This College Already  Exists!';
			$flag++;
			}
		}

		

		if($flag==0){
			
			//Update data
			$where = "fldId='".($_GET['fldId'])."'";

			
			$strDataArr=array(
			    'fldUserName' 				       => $func->input_fun($_POST['fldUserName']),
			   	'fldCollegename' 			       => $func->input_fun($_POST['fldCollegename']),
				'fldCity' 					       => $func->input_fun($_POST['fldCity']),
				'fldState' 				           => $func->input_fun($_POST['fldState']),
				'fldStatus' 			           => $func->input_fun($_POST['fldStatus']),
				'fldSubscribe'                     => $func->input_fun($_POST['fldSubscribe']),
				'fldPosition'                      => $func->input_fun($_POST['fldPosition']),
				'fldNeedType'                      => $func->input_fun($_POST['fldNeedType']),
				'fldEmail' 						   => $func->input_fun($_POST['fldEmail']),
				'fldFirstName'					   => $func->input_fun($_POST['fldFirstName']),
				'fldLastName'					   => $func->input_fun($_POST['fldLastName']),
				'fldAlternativeEmail'			   => $func->input_fun($_POST['fldAlternativeEmail']),
				'fldPhone' 						   =>$_POST['fldPhone'],
				'fldAlternativePhone' 			   => $func->input_fun($_POST['fldAlternativePhone']),
				'fldAddress' => $func->input_fun($_POST['fldAddress']),
				'fldEnrollmentNumber'=>$func->input_fun($_POST['fldEnrollmentNumber']),
				'fldDivison'=>$func->input_fun($_POST['fldDivison'])
				);
							
		

			$db->updateRec(TBL_COLLEGE_COACH_REGISTER,$strDataArr, $where);
			
			#redirect to listing page on successfull updation
			if($_POST['fldCollegename']!="other")
			{
				$where=" fldId =".$fldCollegename;
				$Zipcode_lat_lon=$func->getLatLong($func->input_fun($_POST['fldZipCode']),MAPS_APIKEY);
				$strDataArr_college=array(
			   	'fldAddress' => $func->input_fun($_POST['fldAddress']),
				'fldCity' 					       => $func->input_fun($_POST['fldCity']),
				'fldState' 				           => $func->input_fun($_POST['fldState']),
				'fldZipCode'                       => $func->input_fun($_POST['fldZipCode']),
				'fldDivison'                       => $func->input_fun($_POST['fldDivison']),
				'fldLatitude' 					   => $Zipcode_lat_lon['Latitude'],
'fldLongitude'                     => $Zipcode_lat_lon['Longitude']
				
				);
				$db->updateRec(TBL_COLLEGE,$strDataArr_college, $where);
				 
			}
			if($_POST['fldCollegename']=="other")
			{
			
			$where_update_college = "fldName='".$_POST['txtfldName']."'";
			$Zipcode_lat_lon=$func->getLatLong($func->input_fun($_POST['fldZipCode']),MAPS_APIKEY);
			$strDataArr_other_name=array(
			   	'fldAddress' => $func->input_fun($_POST['fldAddress']),
				'fldCity' 					       => $func->input_fun($_POST['fldCity']),
				'fldState' 				           => $func->input_fun($_POST['fldState']),
				'fldZipCode'                       => $func->input_fun($_POST['fldZipCode']),
				'fldDivison'                       => $func->input_fun($_POST['fldDivison']),
				'fldLatitude' 					   => $Zipcode_lat_lon['Latitude'],
				'fldLongitude'                     => $Zipcode_lat_lon['Longitude']
				
				);
			$db3->updateRec(TBL_COLLEGE,$strDataArr_other_name, $where_update_college);

			
			

			
			}

			header("Location: ADCollegeCoachList.php?page=".$_REQUEST['page']."&msg=College Updated Successfully!");
		}
	}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
        $fldUserName     = $_REQUEST['fldUserName'];
		
		$fldCollegename   	= $_REQUEST['fldCollegename'];
		$fldCity			= $_REQUEST['fldCity'];
		$fldState			= $_REQUEST['fldState'];
		$fldPosition		 = $_REQUEST['fldPosition'];
		$fldNeedType		 = $_REQUEST['fldNeedType']; 
		$fldEmail			 = $_REQUEST['fldEmail'];
		$fldFirstName        = $_REQUEST['fldFirstName'];
		$fldLastName         = $_REQUEST['fldLastName'];
		$fldAlternativeEmail = $_REQUEST['fldAlternativeEmail'];
		$fldPhone 			 = $_REQUEST['fldPhone'];
		$fldAlternativePhone = $_REQUEST['fldAlternativePhone'];
		$fldAddress     = $_REQUEST['fldAddress'];	
		$fldEnrollmentNumber=$_REQUEST['fldEnrollmentNumber'];	
		$fldDivison=$_REQUEST['fldDivison'];
			
	}


} //END if submit
if($_REQUEST['page']==''){$pageno='0';}else{$pageno=$_REQUEST['page'];}

?>
<HTML><HEAD><TITLE>Sport Info</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>


<script language="JavaScript" type="text/JavaScript">

function validate(){
	var error_msg = "";
	var blnResult = true;

	

	
		if(trimString(document.frmUsers.fldUserName.value) == ""){
		error_msg += "Please Enter User name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldUserName.value)){
			error_msg += "Enter Enter Valid Collegecode! \n";
		}
	}
	
	
	
	
	

	if(trimString(document.frmUsers.fldCollegename.value) == "select"){
		error_msg += "Please Select College Name! \n";
	}
	
	if(trimString(document.frmUsers.fldFirstName.value) == ""){
		error_msg += "Please Enter First Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldFirstName.value)){
			error_msg += "Enter Valid First Name! \n";
		}
	}
	if(trimString(document.frmUsers.fldLastName.value) == ""){
		error_msg += "Please Enter Last Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldLastName.value)){
			error_msg += "Enter Valid Last Name! \n";
		}
	}
if(trimString(document.frmUsers.fldPhone.value) == ""){
		error_msg += "Please Enter Your Phone. \n";
	}
	else{
		if(!isPhone(document.frmUsers.fldPhone.value)){
			error_msg += "Enter valid  Phone. \n";
		}
	}
	if((!isPhone(document.frmUsers.fldAlternativePhone.value)) && (trimString(document.frmUsers.fldAlternativePhone.value) != "")) {
			error_msg += "Enter Valid Alternative Phone. \n";
		}
	
	if(trimString(document.frmUsers.fldEmail.value) == ""){
		error_msg += "Please Enter Email. \n";
	}
	else{
		if(!isValid(document.frmUsers.fldEmail.value) ){
			error_msg += "Enter Valid Email. \n";
		}
	}
	
	if((!isValid(document.frmUsers.fldAlternativeEmail.value)) && (trimString(document.frmUsers.fldAlternativeEmail.value) != "")) {
			error_msg += "Enter Valid Alternative Email. \n";
		}
	if(trimString(document.frmUsers.fldCity.value) == ""){
		error_msg += "Please Enter City! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldCity.value)){
			error_msg += "Enter valid City! \n";
		}
	}


	if(trimString(document.frmUsers.fldState.value) == ""){
		error_msg += "Please Enter State! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldState.value)){
			error_msg += "Enter valid State! \n";
		}
	}

	
	if(trimString(document.frmUsers.fldNeedType.value) == ""){
		error_msg += "Please Select the Sport! \n";
	}
		
if(trimString(document.frmUsers.fldDivison.value) == "select"){
		error_msg += "Please Select Divison Name! \n";
	}	
	
	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}

function getSportID(str)
{

if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
  
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    document.getElementById("schoolid").value=str;
    
    }
  }
  if(str=="others")
  {
  	document.getElementById('txtschoolothers').style.display= "";
  }
    
   else
  {
  
  	document.getElementById('txtschoolothers').style.display= "none";
  	
	xmlhttp.open("GET","addcollage.php?fldUserName=<?php echo $fldUserName; ?>&q="+str,true);
	xmlhttp.send();
  }
}   

</script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" >
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TR>
<TD height=120>
<?include "include/ADheader.php";?>
</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TR>
<TD class="heading">
<TABLE cellSpacing=0 cellPadding=1 width="95%" align=center border=0>
<TR>
<TD>
	<TABLE cellSpacing=0 cellPadding=1 width=780 border=0>
	<TR>
	<TD bgColor=#ffffff>
		<TABLE cellSpacing=0 cellPadding=0 width=900 border=0>
		<TR>
		<TD vAlign=top width=20%>
			<?include "include/ADmenu.php";?>
		</TD>
		<TD valign=top width=1%>
		&nbsp;
		</TD>
		<TD width=10><img src="spacer.gif" height="1" width="1">
		</TD>
		<TD valign=top width="" align="center">
<!-- MAin Content Starts From Here -->
			<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Edit College Coach Info</b>
			</td>
			</tr>
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr>
			<td valign="top" colspan=3 align="center" class="normalblack_12">
			<font color="Red"><?=$error_msg?> </font>
			</td>
			</tr>
			<tr>
			<td height="35" colspan="3" align="right" class="normalblack_12"><FONT color="Red">Fields marked with * are mandatory&nbsp;</FONT></td>
			</tr>
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
		
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">User Name
			<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text" name="fldUserName" id="fldUserName" value="<?=$fldUserName?>" maxlength="50" readonly style="width:200px"></td>
			</tr>
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Enrollment Number
			<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<input type="text" name="fldEnrollmentNumber" id="fldEnrollmentNumber" value="<?=$fldEnrollmentNumber?>" maxlength="50"  style="width:200px"></td>
			</tr>	
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			
			

			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">College Name
			<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			<?php
			echo $strcombo = '<select name="fldCollegename" style="width:200px;" onChange="getSportID(this.value);">';
			echo $strcombo = '<option value = "select" >Select College</option>';
			$collegelist=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName","fldId","where fldStatus =1");
			
			for ($i=0;$i<count($collegelist);$i++) 
   			{
   				if($fldCollegename == $collegelist[$i]['fldId'])
   				{
   					
  		    echo '<option value ="'.$collegelist[$i]['fldId'].'" '.'selected = "selected" >'.$collegelist[$i]['fldName'].'</option>';
   				}
   				    				
   				else {
   					 echo '<option value ="'.$collegelist[$i]['fldId'].'">'.$collegelist[$i]['fldName'].'</option>';
   				}
            }
            
             if($fldCollegename=="other")
   				{
  		    echo '<option value ="other" '." selected ".'>'."other".'</option>';
   				}
   				
   				
				echo $strcombo = '</select>';
			?>
			</td>
			</tr>			
			
			
			
			<!--ajex code start	-->	
<p id="txtschoolothers" style="display:none; margin-top:5px;">
								<label>&nbsp;</label>
								<span>
							</span>
								</p>
			</td>
			</tr>
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" > &nbsp;</td>
			</tr>
			<tr  height="20">
			
			<td valign="top"  colspan=3 >
			<div  id="txtHint">
			
			
			
			<?php
			
       
       if(($fldCollegename!="other"))
       {
       	$college_address_info=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where fldStatus =1 and fldId=".$fldCollegename);
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
                 <?php }
                 elseif($fldCollegename=='other')
                 { 
                 	
                 	$other_info=$func->selectTableOrder(TBL_OTHER,"fldId,fldName","fldId"," where fldUserId ='".$fldUserName."'");
                 	
                 	$college_address_info=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where  fldName='".$other_info[0]['fldName']."'");?>
                 	
                 	<table align="center"  border="0" align="center" width="60%">
                 	<tr height="20">
                 
			<td valign="top" align="right" class="normalblack_12" width="30%">College Name<font color="red"> *</font> </td>
         	
         	<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
         	<td valign="top" align="left" class="normalblack_12"  colspan=2> 
                                    <input type="text" name="txtfldName" id="txtfldName" style="width:200px;" value="<?=$other_info[0]['fldName']?>" readonly>
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

			</div>
			</td>
			
			</tr>	
						
	<!--ajex code End	-->
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">First Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldFirstName" value="<?=$fldFirstName?>" maxlength="30" style="width:200px" id="fldFirstName"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Last Name<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldLastName" value="<?=$fldLastName?>" maxlength="30" style="width:200px" id="fldLastName"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Phone<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldPhone" value="<?=$fldPhone?>" maxlength="30" style="width:200px" id="fldPhone"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Alternate Phone<font color="red"></font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldAlternativePhone" value="<?=$fldAlternativePhone?>" maxlength="30" style="width:200px" id="fldAlternativePhone"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Email Address<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldEmail" value="<?=$fldEmail?>" maxlength="30" style="width:200px" id="fldEmail" ></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Alternative Email<font color="red"></font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldAlternativeEmail" value="<?=$fldAlternativeEmail?>" maxlength="30" style="width:200px" id="fldAlternativeEmail"></td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Position<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldPosition" value="<?=$fldPosition?>" maxlength="40" style="width:200px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Division<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">

			
		 
			 <select name="fldDivison" style="width:200px;">
            <option value="select">Select Divison</option>
            <option value="Division_I" <?php if($fldDivison=="Division_I"){ ?>selected <?php } ?>>Division I</option>
            <option value="Division_II" <?php if($fldDivison=="Division_II"){ ?>selected <?php } ?>>Division II</option>
            <option value="Division_III" <?php if($fldDivison=="Division_III"){ ?>selected <?php } ?>>Division III</option>
             <option value="NAIA" <?php if($fldDivison=="NAIA"){ ?>selected <?php } ?>>NAIA</option>
<option value="JUCO" <?php if($fldDivison=="JUCO"){ ?>selected <?php } ?>>JUCO</option>
</select>
			
			
			
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Sport<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">

			
		<?php  
			echo $strcombo = '<select name="fldNeedType" style="width:200px">';
			echo $strcombo = '<option value = "">Select Type</option>';
			$categorylist=$func->selectTableOrder(tbl_sports,"fldId,fldSportsname","fldId");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
   				if($fldNeedType == $categorylist[$i]['fldId'] )
   				{
  		       echo '<option value ="'.$categorylist[$i]['fldId'].'" selected="selected" >'.$categorylist[$i]['fldSportsname'].'</option>';
   				}
  		       else 
  		       {
  		       	echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldSportsname'].'</option>';
  		       }
            }
			echo $strcombo = '</select>';
			?>
			
			
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Subscribe<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
              
			<select name="fldSubscribe" style="width:200px">
			<option value="">Please Select</option>
			
			
            
			<option value="2" <?php if($fldSubscribe == '2')
			{ ?>selected="selected"<?php } ?>>Trial Period</option>
			
			
			<option value="1" <?php if($fldSubscribe == '1')
			{ ?>selected="selected"<?php } ?>>Subscribe</option>
			
			
			<option value="0" <?php if($fldSubscribe == '0')
			{ ?>selected="selected"<?php } ?>>Inactive</option>	
			
			
			</select>
		
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="40%">Status<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width:200px">
			
			<option value="ACTIVE" <?if($status=='ACTIVE'){ echo "selected"; }?>>ACTIVE</option>
			<option value="DEACTIVE" <?if($status=='DEACTIVE'){ echo "selected"; }?>>DE-ACTIVE</option>
			</select></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" > &nbsp;</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">&nbsp</td>
			<td valign="top"  align="center" class="normalblack_12" > &nbsp</td>
			<td valign="top" align="left" class="normalblack_12">
			<input type="hidden" name="userType" value="<?=($userType!="")?$userType:""?>">
			<input type="hidden" name="oldcode" value="<?=($oldcode)?$oldcode:$code?>">
			<input type="hidden" name="isSubmit" value="save">
			
		
		<input type="submit" name="submit" value="Submit">&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset">
		
		
		</td>
			</tr>
			
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" > &nbsp;</td>
			</tr>
			
			<!-- Upoad File END-->
			</table>
			</td>
			</tr>
			</table>
			</form>
		 <!--Main Center Content END -->
		</td>
		</tr>
		</table>
	</TD>
	</TR>
	</TABLE>
</TD>
</TR>
</TABLE>
</TD>
</TR>
<?include "include/ADfooter.php";?>
<? unset($func);  unset($db); ?>
</TABLE>
</BODY>
</HTML>