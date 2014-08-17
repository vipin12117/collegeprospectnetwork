<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Sanjay Chaudhary
##	Page name	:		ADCatagory.php
##	Create Date	:		10106/2011
##  Description :		It is use to performe the operation for add for Catagory.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				//for admin login



$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "10";
$error_msg = '';
$flag = 0;
$fldEventStatus=1;

if($_POST['isSubmit']=='save'){
	
        //Edit the user info
		$fldEventName   	     = $func->input_fun($_POST['fldEventName']);
		$fldSport					=$func->input_fun($_POST['fldSport']);
		
		$fldEventDescription     = $func->input_fun($_POST['fldEventDescription']);
		$fldEventLocation        = $func->input_fun($_POST['fldEventLocation']);
		$fldEventStartDate 		 = $func->input_fun($_POST['fldEventStartDate']);
		$fldEventEndDate 		 = $func->input_fun($_POST['fldEventEndDate']);
		
		$fldHomeTeam 		 = $func->input_fun($_POST['fldHomeTeam']);
		$fldAwayTeam 		 = $func->input_fun($_POST['fldAwayTeam']);
		
		$fldEventStatus      	 = $func->input_fun($_POST['fldEventStatus']);
		
		
	
	
        if($flag==0){
        	
			//Insert data
		     $strDataArr=array(
		     'fldEventName' 				=> $func->input_fun($_POST['fldEventName']),
		   'fldSport' 				=> $func->input_fun($_POST['fldSport']),
			'fldEventDescription' 			=> $func->input_fun($_POST['fldEventDescription'])
			,'fldEventLocation' 				=> $func->input_fun($_POST['fldEventLocation']),
		     'fldEventStartDate' 		=> $func->input_fun($_POST['fldEventStartDate']),
			'fldEventEndDate' 		=> $func->input_fun($_POST['fldEventEndDate']),
		  'fldHomeTeam' 		=> $func->input_fun($_POST['fldHomeTeam']),
		  'fldAwayTeam' 		=> $func->input_fun($_POST['fldAwayTeam']),
			
		     'fldEventStatus' 		=> $func->input_fun($_POST['fldEventStatus']),
		     'fldUserName' 		=> $func->input_fun($_SESSION['ADMIN_USER']),'fld_UserType'=>'admin'
						);
						

	 		$db->insertRec(TBL_EVENT,$strDataArr);
       
			#redirect to listing page on successfull updation
			
			header("Location: ADEventList.php?msg=Event is Added Successfully ");
		}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		
		
		
		

		$fldEventName        = $_REQUEST['fldEventName'];
		
		$fldSport		=$_REQUEST['fldSport'];
		$fldEventDescription      = $_REQUEST['fldEventDescription'];
		$fldEventLocation        = $_REQUEST['fldEventLocation'];
		$fldEventStartDate = $_REQUEST['fldEventStartDate'];
		$fldEventEndDate = $_REQUEST['fldEventEndDate'];
		$fldHomeTeam=$_REQUEST['fldHomeTeam'];
		$fldAwayTeam=$_REQUEST['fldAwayTeam'];

		$fldEventStatus      = $_REQUEST['fldEventStatus'];
		

	}


} //END if submit


?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	
	var error_msg = "";
	
		//var blnResult = true;

    if(trimString(document.frmEvent.fldEventName.value) == ""){
		error_msg += "Please Enter Event Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmEvent.fldEventName.value)){
			error_msg += "Enter valid Event Name! \n";
		}
	}

	 if(trimString(document.frmEvent.fldSport.value) == "select"){
		error_msg += "Please Select Sport! \n";
	}
	if(trimString(document.frmEvent.fldHomeTeam.value) == "select"){
		error_msg += "Please Select Home Team! \n";
	}
	if(trimString(document.frmEvent.fldAwayTeam.value) == "select"){
		error_msg += "Please Select Away Team! \n";
	}
	if(trimString(document.frmEvent.fldEventLocation.value) == ""){
		error_msg += "Please Enter Event Loacation! \n";
	}
	if(trimString(document.frmEvent.fldEventStartDate.value) == ""){
		error_msg += "Please Enter Event Start Date! \n";
	}
	if(trimString(document.frmEvent.fldEventEndDate.value) == ""){
		error_msg += "Please Enter End Event Date! \n";
	}
	

	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
				return true;
		
		
		}

}
</script>
<HTML><HEAD><TITLE>Add User Info</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="images/main.css">
					<script type="text/javascript" language="javascript" src="../Date Time Picker/images/prototype-1.js"></script>
			<script type="text/javascript" language="javascript" src="../Date Time Picker/images/prototype-base-extensions.js"></script>
			<script type="text/javascript" language="javascript" src="../Date Time Picker/images/prototype-date-extensions.js"></script>
			<script type="text/javascript" language="javascript" src="../Date Time Picker/images/behaviour.js"></script>
							<script type="text/javascript" language="javascript" src="../Date Time Picker/images/datepicker.js"></script>
										<link rel="stylesheet" href="../Date Time Picker/images/datepicker.css">
							<script type="text/javascript" language="javascript" src="../Date Time Picker/images/behaviors.js"></script>

<script language="Javascript" src="../javascript/functions.js">
</script>
<script language="Javascript" src="../javascript/functions.js">
</script>

<script type="text/javascript">
	
	function formsubmit_location(str)
	{
			var xmlhttp;
if (str.length==0)
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
    }
  }
xmlhttp.open("GET","getlocation.php?q="+str,true);

xmlhttp.send();
		
	}
	function formsubmit_Event(str)
	{
		
	
		var xmlhttp;
if (str.length==0)
  {
  document.getElementById("txtEvent").innerHTML="";
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
    document.getElementById("txtEvent").innerHTML=xmlhttp.responseText;
  
    }
  }


xmlhttp.open("GET","getevent.php?q="+str+"&HomeTeam="+document.getElementById('fldHomeTeam').options[document.getElementById('fldHomeTeam').selectedIndex].text+"&AwayTeam= "+document.getElementById('fldAwayTeam').options[document.getElementById('fldAwayTeam').selectedIndex].text,true);

xmlhttp.send();
		
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
			<form name="frmEvent" action="" method="post" enctype="multipart/form-data"  id="frmEvent">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>Add Event</b>
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
			
						

			
			</select></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>-->
<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Sport <font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<select name="fldSport" id="fldSport" style="width: 220px;font-size:12px;" 
			>
			<?php
$sportlist=$func->selectTableOrder(TBL_SPORTS,"fldId,fldSportsname","fldSportsname","where fldStatus='ACTIVE'");
?><option value = "select">Select Sport</option><?php 

			for ($i=0;$i<count($sportlist);$i++) 
   			{
   				?>
   				<option value ="<?php echo $sportlist[$i]['fldId']?>" <?php if(isset($_REQUEST['sportid'])and ($_REQUEST['sportid']==$sportlist[$i]['fldId'])){ ?>selected <?php } ?>><?php echo $sportlist[$i]['fldSportsname']; ?></option>
   				<?php 

   				
            }
			?>
</select>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Home team<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldHomeTeam" id="fldHomeTeam" style="width: 220px;font-size:12px;" onchange="formsubmit_location(this.value);">
			<?php
			
$homelist=$func->selectTableOrder(TBL_HS_AAU_TEAM,"fldId,fldSchoolname","fldSchoolname","where fldStatus='ACTIVE'");
			
?>
<option value = "select">Select Home Team</option>
<?php
if(isset($homelist))
{
			for ($i=0;$i<count($homelist);$i++) 
   			{
   			?>
   			<option value ="<?php echo $homelist[$i]['fldId']; ?>" <?php if((isset($_REQUEST['homeTeamid'])) and ($_REQUEST['homeTeamid']==$homelist[$i]['fldId'])){?>selected <?php } ?>><?php echo $homelist[$i]['fldSchoolname']; ?></option>
   			<?php
  		    
            }
}
            ?>
            </select>
            
			

			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Away Team<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldAwayTeam" id="fldAwayTeam" style="width: 220px;font-size:12px;" onchange="formsubmit_Event(this.value);">
			<?php

echo $strcombo = '<option value = "select">Select Away Team</option>';
if(isset($homelist))
{

			for ($i=0;$i<count($homelist);$i++) 
   			{
  		    echo '<option value ="'.$homelist[$i]['fldId'].'" >'.$homelist[$i]['fldSchoolname'].'</option>';
            }
}
			echo $strcombo = '</select>';?>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20" id="txtEvent">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Name <font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldEventName" id="fldEventName" value="<?=$fldEventName?>" maxlength="30" style="width: 220px;">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>

					<tr height="20" id="txtHint">
			<td valign="top" align="right" class="normalblack_12" width="30%">Location<font color="red"> *</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<?php  $query ="Select * from ".TBL_HS_AAU_TEAM. " where fldId =".$_REQUEST['homeTeamid'];
	
if(($_REQUEST['homeTeamid'])and ($_REQUEST['homeTeamid']!='select'))
			{
	$db->query($query);
	$db->next_record();
	$location=$db->f('fldAddress');
			}
	?>
			<td valign="top" align="left" class="normalblack_12"> <textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="15"  style="width: 220px;"  ><?php if($location) {echo $location; }?></textarea></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Detail<font color="red"> </font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"><textarea name="fldEventDescription" id="fldEventDescription" rows="10" cols="15"  style="width: 220px;"  class="txt"><?php echo $fldEventDescription; ?></textarea></td>
			</tr>
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>	
						<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event Start Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
									<input type="text"  style="float: left;width:200;" class="datetimepicker_es"  id="fldEventStartDate" name="fldEventStartDate" autocomplete="off" value="<? if($fldEventStartDate){echo $fldEventStartDate;}else{echo date("y-m-d 19:30");}?>" >

			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
				
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Event End Date<font color="red"> *</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
									<input type="text"  style="float: left;width:200;" class="datetimepicker_es"  id="fldEventEndDate" name="fldEventEndDate" autocomplete="off" value="<? if($fldEventEndDate){echo $fldEventEndDate;}else{ echo date("y-m-d 20:30");}?>">

			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status <font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldEventStatus" style="width: 220px;font-size:12px;">
			<option value=1 <?if($fldEventStatus==1){ echo "selected"; }?>>ACTIVE</option>
			<option value=0 <?if($fldEventStatus==0){ echo "selected"; }?>>DE-ACTIVE</option>
						</select></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">&nbsp</td>
			<td valign="top"  align="center" class="normalblack_12" > &nbsp</td>
			<td valign="top" align="left" class="normalblack_12">
			<input type="hidden" name="isSubmit" value="save">
			<input type="submit" name="submit" value="Submit" onclick="return validate();">&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"></td>
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