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
	 $query =" Select * from ".TBL_HS_AAU_COACH. " where fldId = '$fldId' ";
	
	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
		$fldUsername 	    = $db->f('fldUsername');
		$fldName 	    	= $db->f('fldName');
		$fldLastName 	    = $db->f('fldLastName');
		$fldEmail 	        = $db->f('fldEmail');
		$fldAEmail 	        = $db->f('fldAEmail');
		$fldPhone	        = $db->f('fldPhone');
		$fldAPhone	        = $db->f('fldAPhone');
		//$fldDescription     = $db->f('fldDescription');
		$fldSchool	    	= $db->f('fldSchool');
		$fldSport           = $db->f('fldSport');
		$fldPosition        = $db->f('fldPosition');
		$fldPassword 	    = $db->f('fldPassword');
		$fldStatus 	        = $db->f('fldStatus');
		
	}
}
else {
	    $fldUsername       = "";
	    $fldName           = "";
	    $fldLastName       = "";
		$fldEmail          = "";
		$fldAEmail         = "";	
		$fldPhone	       = "";
		$fldAPhone	       = "";
		//$fldDescription    = "";
		$fldSchool         = "";
		$fldSport          = "";
		$fldPosition       = "";
        $fldPassword       = "";
		$fldStatus 	       = "";	

}
if($_POST['isSubmit']=='save'){

	if($_GET['fldId']!=""){
		//Edit the user info
		$fldUsername            = $func->input_fun($_POST['fldUsername']);
		$fldName                = $func->input_fun($_POST['fldName']);
		$fldLastName            = $func->input_fun($_POST['fldLastName']);
		$fldEmail               = $func->input_fun($_POST['fldEmail']);
		$fldAEmail              = $func->input_fun($_POST['fldAEmail']);
		$fldPhone               = $func->input_fun($_POST['fldPhone']);
		$fldAPhone              = $func->input_fun($_POST['fldAPhone']);
		$fldSchool              = $func->input_fun($_POST['fldSchool']);
		$fldSport               = $func->input_fun($_POST['fldSport']);
		$fldPosition            = $func->input_fun($_POST['fldPosition']);
		$fldPassword            = $func->input_fun($_POST['fldPassword']);
		$fldStatus              = $func->input_fun($_POST['fldStatus']);
		
		

        if($_GET['fldId']!=$_GET['fldId'] ){
		$whereClause = "fldId='".$func->input_fun($_GET['fldId'])."'";

			if($db->MatchingRec(TBL_HS_AAU_COACH,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This high school / AAU Coach Already  Exists!';
			$flag++;
			}
		}

	

		if($flag==0){
			
			//Update data
			$where = "fldId='".($_GET['fldId'])."'";

			$strDataArr=array(
			'fldUsername'               => $func->input_fun($_POST['fldUsername']),
			'fldName' 				    => $func->input_fun($_POST['fldName']),
		    'fldLastName'               => $func->input_fun($_POST['fldLastName']),
		    'fldEmail' 		            => $func->input_fun($_POST['fldEmail']),
		    'fldAEmail' 		        => $func->input_fun($_POST['fldAEmail']),
			'fldPhone' 			        => $func->input_fun($_POST['fldPhone']),
			'fldAPhone' 			    => $func->input_fun($_POST['fldAPhone']),
			
			'fldSchool'                 => $func->input_fun($_POST['fldSchool']),
			'fldSport'                  => $func->input_fun($_POST['fldSport']),
			'fldPosition'				=> $func->input_fun($_POST['fldPosition']),
		    
			'fldStatus' 			    => $func->input_fun($_POST['fldStatus'])
			);

			$db->updateRec(TBL_HS_AAU_COACH,$strDataArr,$where);
			$delete_query_details = "delete from ".TBL_HS_AAU_COACH_SPORT_POSITION." where fldCoachNameId='".$_GET['fldId']."'";
			$delmsg = $db->query($delete_query_details);
	
		    
			 for($n=0;$n<$_POST['currentrow'];$n++)
		     {
		     	
		     	   if($n==0)
		     	   
		     	   {
		     	   	       
							 
							 
							 $strDataArrw=array(
							'fldSportId' 				=> $func->input_fun($_POST['fldSport']),
							'fldPosition' 			    => $func->input_fun($_POST['fldPosition']),
							'fldCoachNameId' 		    => $fldId
							 );
					  
						      
						      $db->insertRec(TBL_HS_AAU_COACH_SPORT_POSITION,$strDataArrw);
		     	   }
		     	   
		     	   
		     	   else 
		     	   {
					     	$strDataArrw=array(
							'fldSportId' 				=> $func->input_fun($_POST['fldSport'.$n]),
							'fldPosition' 			    => $func->input_fun($_POST['fldPosition'.$n]),
							'fldCoachNameId' 		    => $fldId
						       );
						    $db->insertRec(TBL_HS_AAU_COACH_SPORT_POSITION,$strDataArrw);
						         
		     	   }
			                    
	           
		     	
		     }
			#redirect to listing page on successfull updation
			header("Location: ADCoachList.php?page=".$_REQUEST['page']."&msg=coach Updated Successfully!");
		}
	}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		$fldUsername	    = $_REQUEST['fldUsername'];
	    $fldName	        = $_REQUEST['fldName'];
        $fldLastName	    = $_REQUEST['fldLastName'];
		$fldEmail	        = $_REQUEST['fldEmail'];
		$fldAEmail	        = $_REQUEST['fldAEmail'];
		$fldPhone			= $_REQUEST['fldPhone'];
		$fldAPhone			= $_REQUEST['fldAPhone'];
		
	    $fldSchool			= $_REQUEST['fldSchool'];
	    $fldSport           = $_REQUEST['fldSport'];
	    $fldPosition        = $_REQUEST['fldPosition'];
		
		$fldStatus          = $_REQUEST['fldStatus'];
												
	}


} //END if submit
if($_REQUEST['page']==''){$pageno='0';}else{$pageno=$_REQUEST['page'];}
?>
<HTML><HEAD><TITLE>High School / AAU Coach Info</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

function validate(){
	var error_msg = "";
	var blnResult = true;
	
	
	   
	    if(trimString(document.frmUsers.fldUsername.value) == ""){
		error_msg += "Please Enter User Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldUsername.value)){
			error_msg += "Enter valid User Name! \n";
		}
	} 
	
   
       if(trimString(document.frmUsers.fldName.value) == ""){
		error_msg += "Please Enter Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldName.value)){
			error_msg += "Enter valid Name! \n";
		}
	} 
	
	if(trimString(document.frmUsers.fldEmail.value) == ""){
		error_msg += "Please Enter Email! \n";
	}
	else{
		if(!isValid(document.frmUsers.fldEmail.value)){
			error_msg += "Enter Valid Email! \n";
		}
	}
	
	
	if(trimString(document.frmUsers.fldPhone.value) == ""){
		error_msg += "Please Enter Phone Number! \n";
	}
	else{
	
	if(trimString(document.frmUsers.fldPhone.value) != ""){

		if(!isPhone(document.frmUsers.fldPhone.value)){
			error_msg += "Enter valid Phone Number! \n";
		}
		if(document.frmUsers.fldPhone.value.length > 15){
			error_msg += "Phone number should be less then 16 characters! \n";
		}
	}
	}
	
	
	
	     if(trimString(document.frmUsers.fldSchool.value) == 0){
		error_msg += "Please Select School! \n";
	}
	
	
		
	     if(trimString(document.frmUsers.fldSport.value) == 0){
		error_msg += "Please Select Sport! \n";
	}
	
	 if(trimString(document.frmUsers.fldPosition.value) == ''){
		error_msg += "Please Enter Position! \n";
	}
	
		     if(trimString(document.frmUsers.fldPassword.value) == ""){
		error_msg += "Please Enter Password! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldPassword.value)){
			error_msg += "Please Enter Password! \n";
		}
	} 
	
	
		
	   if(trimString(document.frmUsers.fldPassword2.value) == ""){
		error_msg += "Please Enter confirm Password! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldPassword2.value)){
			error_msg += "Please Enter confirm Password! \n";
		}
	} 
	

   
   
	if (document.frmUsers.fldPassword.value != document.frmUsers.fldPassword2.value){
		error_msg += "Your Confirm Password Does not Match. \n";
	}
		
	
   


	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}



function addfields() {

	
	var currentrow	= parseInt(document.frmUsers.currentrow.value);
	document.getElementById('trs_'+currentrow).style.display= "";
	document.getElementById('trc_'+currentrow).style.display= "";
	document.getElementById('trsb_'+currentrow).style.display= "";
	document.getElementById('trcb_'+currentrow).style.display= "";
	document.getElementById('currentrow').value=currentrow+1;
	if(document.getElementById('currentrow').value >= 1)
	{
		document.getElementById('remfield').style.display= "";
    }
}	


function removefields() {
	
	var currentrow	= parseInt(document.frmUsers.currentrow.value);
	currentrow--;
	document.getElementById('trs_'+currentrow).style.display= "none";
	document.getElementById('trc_'+currentrow).style.display= "none";
	document.getElementById('trsb_'+currentrow).style.display= "none";
	document.getElementById('trcb_'+currentrow).style.display= "none";
	
	if(currentrow == 1)
	{
		document.getElementById('remfield').style.display= "none";
		document.getElementById('currentrow').value=currentrow;
    } else {
    	currentrow++;
    	document.getElementById('currentrow').value=currentrow-1;	
    }
	

}	

</script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0"   >
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
				<b>Edit High School / AAU Coach Info</b>
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
			<td valign="top" align="right" class="normalblack_12" width="30%">User Name<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldUsername" id="fldUsername" value="<?=$fldUsername?>" maxlength="50" style="width:220px" readonly>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>                    
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">First Name<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > :&nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldName" id="fldName" value="<?=$fldName?>" maxlength="50" style="width:220px">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
		    <tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Last Name</td>
			<td valign="top"  align="center" class="normalblack_12" > : &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldLastName" id="fldLastName" value="<?=$fldLastName?>" maxlength="50" style="width:220px">
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Email<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldEmail" value="<?=$fldEmail?>" maxlength="30" style="width:220px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Alternate Email </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldAEmail" value="<?=$fldAEmail?>" maxlength="30" style="width:220px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			

			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Phone<font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldPhone" value="<?=$fldPhone?>" maxlength="40" style="width:220px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Alternate Phone</td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldAPhone" value="<?=$fldAPhone?>" maxlength="40" style="width:220px"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			

			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">High School/AAU Team <font color="red">*</font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">			
			 <?php
			      echo $strcombo = '<select name="fldSchool" style="width:220px" onChange="getSportID(this.value);">';
								echo $strcombo = '<option value = 0>Select HS / AAU Team</option>';
								$categorylist=$func->selectTableOrder(TBL_HS_AAU_TEAM,"fldId,fldSchoolname","fldSchoolname");
								for ($i=0;$i<count($categorylist);$i++) 
								{
									if($fldSchool == $categorylist[$i]['fldId'] )
									{
								    echo '<option value ="'.$categorylist[$i]['fldId'].'" selected="selected" >'.$categorylist[$i]['fldSchoolname'].'</option>';
									}
									else 
									{
									echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldSchoolname'].'</option>';
									}
								}
								echo $strcombo = '</select>';
								
			?>
			</td>
			</tr>
			</p>
								
								
								
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			

			<!--code start-->
			
			
			<?php
			$whrecon1 ="fldCoachNameId ='".$fldId."'";
			$sportslist=$func->selectTableCon(TBL_HS_AAU_COACH_SPORT_POSITION,"fldId,fldCoachNameId,fldPosition,fldSportId",$whrecon1);
			
			$sportscount=count($sportslist);
			if($sportscount==0)
			{
				$sportscount=1;
			}
		
			for ($k=0;$k<$sportscount;$k++)
		     { 
		     	
		    if ($k==0)
		    {
		    		    	  			     	
		    ?>
	
		    <tr height="20" >
			<td valign="top" align="right" class="normalblack_12" width="30%">Sport <font color="red">*</font></td>
			<? 
		    }
			else 
			{ 
			?>
			<tr height="20" >
			<td valign="top" align="right" class="normalblack_12" width="30%">Sport <?php echo $k ;?></td>
			<?
			}
			 ?>
			 
			 
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
   
			<?php
			 if ($k==0)
			 {
			echo $strcombo = '<select name="fldSport" style="width:220px">';
			 }
			 else 
			 {
			 echo $strcombo = '<select name="fldSport'.$k.'" style="width:220px">';
			 }
			
			
			echo $strcombo = '<option value = "">Select Sport</option>';
			$categorylist=$func->selectTableOrder(tbl_sports,"fldId,fldSportsname","fldSportsname");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
	   				
	   			if ($sportslist[$k]['fldSportId'] == $categorylist[$i]['fldId'] ) 
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
			
		<?php 
		  if ($k==0)
		    {  			     	
		    ?>
		    <tr height="20" >
			<td valign="top" align="right" class="normalblack_12" width="30%">Position <font color="red">*</font></td>
			<? 
		    }
			else 
			{ 
			?>
			<tr height="20" >
			<td valign="top" align="right" class="normalblack_12" width="30%">Position <?php echo $k ;?></td>
			<?
			}
			 ?>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
 
			<?php 
			
			if ($k==0)
			{
				
				echo $strcombo = '<input type = "text" name="fldPosition" style="width:220px" value="'.$sportslist[$k]['fldPosition'].'">';
			}
			else {
				
				echo $strcombo =  '<input type = "text" name="fldPosition'.$k.'" style="width:220px" value="'.$sportslist[$k]['fldPosition'].'">';
			}
	
			
						
			?>
			
			
			
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>	
			 	
  		   <? 
		     
		     }
		     ?>
  		   
  		   <?php
		
		for ($k=$sportscount;$k<=25;$k++)
		{ ?>
			<tr height="20" style="display:none" id="trs_<?php echo $k ;?>">
			<td valign="top" align="right" class="normalblack_12" width="30%">Sport <?php echo $k ;?></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">

			<?php  
			echo $strcombo = '<select name="fldSport'.$k.'" style="width:220px">';
			echo $strcombo = '<option value = "">Select Sport</option>';
			$categorylist=$func->selectTableOrder(tbl_sports,"fldId,fldSportsname","fldSportsname");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
  		    echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldSportsname'].'</option>';
            }
			echo $strcombo = '</select>';
			?>
			
			
			</tr>
			<tr height="20" style="display:none" id="trsb_<?php echo $k ;?>">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
		
			<tr height="20" style="display:none" id="trc_<?php echo $k ;?>">
			<td valign="top" align="right" class="normalblack_12" width="30%">Position <?php echo $k ;?></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12">
			<input type="text" style="width:220px" maxlength="20" value="<?php echo $_REQUEST['fldPosition'.$k];  ?>" name="fldPosition<?php echo $k; ?>">
			
			</td>
		</tr>
		<tr height="20" style="display:none" id="trcb_<?php echo $k ;?>">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
		
		<?php
		 }
		 
		 ?>

  	   
  		   
  		   <tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">&nbsp;</td>
			<td valign="top"  align="center" class="normalblack_12" > &nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<input type="hidden" name="currentrow" value="<?php echo $sportscount; ?>" id="currentrow">
			<input type="hidden" name="totalcount" value="25" id="totalcount">

			<a href="javascript:return void(0);" onclick="javascript:addfields()" style="text-decoration: none"> Add Fields  </a>&nbsp;&nbsp;
			<span id="remfield" style="display:none"><a href="javascript:return void(0);" onclick="javascript:removefields()" style="text-decoration: none"> Remove Fields  </a></span></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			
			
			
			
			
			
	
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="30%">Status<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldStatus" style="width:220px">
			<option value="" <?if($fldStatus==''){ echo "selected"; }?>>---Select---</option>
			<option value="ACTIVE" <?if($fldStatus=='ACTIVE'){ echo "selected"; }?>>ACTIVE</option>
			<option value="DEACTIVE" <?if($fldStatus=='DEACTIVE'){ echo "selected"; }?>>DE-ACTIVE</option>
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
			
		<? /*	<input type="hidden" name="oldName" value="<?=$userOldName?>">
			<input type="hidden" name="oldEmail" value="<?=$userOldEmail?>"> */ ?>
		<input type="submit" name="submit" value="Submit">&nbsp;&nbsp;
		<input type="reset" name="Submit2" value="Reset">&nbsp;&nbsp;
		<input type="button" name="backtolist" value="Back" onClick="window.location.href='ADCoachList.php?page=<?=$pageno?>'"></td>
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