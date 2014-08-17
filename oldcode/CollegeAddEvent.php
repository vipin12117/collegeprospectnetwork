<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
session_start();

if($_SESSION['FRONTEND_USER']=="")
{
	header("Location:index.php");
}

//for paging
$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$page=new Page();	//Create an instance of class Pate
$lnb = "2";
$error_msg = '';


$fldEventStatus=1;

if($_POST['isSubmit']=='save'){
	
        //Edit the user info
		$fldEventName   	     = $func->input_fun($_POST['fldEventName']);
		/*$fldCatagoryId			 = $func->input_fun($_POST['fldCatagoryId']);*/
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
			
		     'fldEventStatus' 		=> 0,
		     'fldUserName' 		=> $func->input_fun($_SESSION['FRONTEND_USER']),
		     'fld_PaymentStatus'=>'Pending',
		     'fld_UserType' => 'college'
						);
						

	 		$inser_id=$db->insertRec(TBL_EVENT,$strDataArr);
       
			#redirect to listing page on successfull updation
			
			header("Location: CollegeEventPaid.php?fldEventId= ".$inser_id);
		}
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		
		
		
		

		$fldEventName        = $_REQUEST['fldEventName'];
		
		$fldSport		=$_REQUEST['fldSport'];
		$fldEventDescription      = $_REQUEST['fldEventDescription'];
		$fldEventLocation        = $_REQUEST['fldEventLocation'];
		$fldEventStartDate = $_REQUEST['fldEventStartDate'];
		$fldEventEndDate = $_REQUEST['$fldEventEndDate'];
		$fldHomeTeam=$_REQUEST['fldHomeTeam'];
		$fldAwayTeam=$_REQUEST['fldAwayTeam'];
		
		

	}


} //END if submit


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>
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
<script type="text/javascript" language="javascript" src="Date Time Picker/images/prototype-1.js"></script>
			<script type="text/javascript" language="javascript" src="Date Time Picker/images/prototype-base-extensions.js"></script>
			<script type="text/javascript" language="javascript" src="Date Time Picker/images/prototype-date-extensions.js"></script>
			<script type="text/javascript" language="javascript" src="Date Time Picker/images/behaviour.js"></script>
							<script type="text/javascript" language="javascript" src="Date Time Picker/images/datepicker.js"></script>
										<link rel="stylesheet" href="Date Time Picker/images/datepicker.css">
							<script type="text/javascript" language="javascript" src="Date Time Picker/images/behaviors.js"></script>

<script language="Javascript" src="javascript/functions.js">
</script>
<script language="Javascript" src="javascript/functions.js">
</script>
<script type="text/javascript" src="javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple",
		editor_selector :"txt",
		  
	});	
	
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
</script>
</head>
<body>
<?php
include('header.php');
?>
    <!--middle panel starts from here -->
<!--content panel starts from here -->
<div class="container">
  <div class="innerWraper">
    <div class="middle-bg">
    <div class="cantener">
  <div class="register-main">
     
 
 

                      <div class="registerPage">
  <h1>Add Event</h1>
  <?php if(($_SESSION['mode']=='college')){?>
                       	
					<form name="frmEvent" action="" method="post" enctype="multipart/form-data"  id="frmEvent">
                            	  <p>
                                	<label>Event Name :</label>
                                    <span><input type="text" name="fldEventName" id="fldEventName" value="<?=$fldEventName?>" maxlength="30" ></span><font color="#0000ff">*</font>
                                </p>
                                  <p>
                                	<label>Sport :</label>
                                    <span><select name="fldSport" id="fldSport"  
			>
			<?php
$sportlist=$func->selectTableOrder(TBL_SPORTS,"fldId,fldSportsname","fldSportsname");
?><option value = "select">Select Sport</option><?php 

			for ($i=0;$i<count($sportlist);$i++) 
   			{
   				?>
   				<option value ="<?php echo $sportlist[$i]['fldId']?>" <?php if(isset($_REQUEST['sportid'])and ($_REQUEST['sportid']==$sportlist[$i]['fldId'])){ ?>selected <?php } ?>><?php echo $sportlist[$i]['fldSportsname']; ?></option>
   				<?php 

   				
            }
			?>
</select></span><font color="#0000ff">*</font>
                                </p>
                                  <p>
                                	<label>Home team :</label>
                                    <span><select name="fldHomeTeam"  onchange="formsubmit_location(this.value);">
			<?php
			
$homelist=$func->selectTableOrder(TBL_HS_AAU_TEAM,"fldId,fldSchoolname","fldId");
			
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
            </span><font color="#0000ff">*</font>
                                </p>
                                  <p>
                                	<label>Away Team :</label>
                                    <span><select name="fldAwayTeam" >
			<?php

echo $strcombo = '<option value = "select">Select Away Team</option>';
if(isset($homelist))
{

			for ($i=0;$i<count($homelist);$i++) 
   			{
  		    echo '<option value ="'.$homelist[$i]['fldId'].'" >'.$homelist[$i]['fldSchoolname'].'</option>';
            }
}
			echo $strcombo = '</select>';?></span><font color="#0000ff">*</font>
                                </p>
                                  <p>
                                	<label>Event Detail :</label>
                                    <span><textarea name="fldEventDescription" id="fldEventDescription" class="ta1"><?php echo $fldEventDescription; ?></textarea></span>
                                </p>
                                  <p id="txtHint">
                                	<label>Location :</label>
                                	<?php $query ="Select * from ".TBL_HS_AAU_TEAM. " where fldId =".$_REQUEST['homeTeamid'];
	
if(($_REQUEST['homeTeamid'])and ($_REQUEST['homeTeamid']!='select'))
			{
	$db->query($query);
	$db->next_record();
	$location=$db->f('fldAddress');
			}
	?>
                                    <span><textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="15"    ><?php if($location) {echo $location; }?></textarea></span><font color="#0000ff">*</font>
                                </p>
                                 
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" >
								<tr>
									<td style="color: #646464;
    font-size: 14px;
    font-weight: bold;
    line-height: 32px;
    margin-bottom: 0;
    margin-right: 0;
    margin-top: 0;
    padding: 0 6px 0 174px;
    text-align: left;
    width: 90px;">Start Date :</td>	
									<td>
			<input type="text"   class="datetimepicker_es"  id="fldEventStartDate" style="background:url(images/inputBg2.jpg) no-repeat !important; width:270px;" name="fldEventStartDate" autocomplete="off" value="<? if($fldEventStartDate){echo $fldEventStartDate;}else{echo date("y-m-d 19:30");}?>" >									</td>
								</tr>
							</table>
                              	<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" >
								<tr>
									<td style="color: #646464;
    font-size: 14px;
    font-weight: bold;
    line-height: 32px;
    margin-bottom: 0;
    margin-right: 0;
    margin-top: 0;
    padding: 0 6px 0 174px;
    text-align: left;
    width: 90px;">End Date :</td>	
									<td>
										<input type="text"  style="background:url(images/inputBg2.jpg) no-repeat !important; width:270px;" class="datetimepicker_es"  id="fldEventEndDate" name="fldEventEndDate" autocomplete="off" value="<? if($fldEventEndDate){echo $fldEventEndDate;}else{ echo date("y-m-d 20:30");}?>" >
									</td>
								</tr>
							</table>
                                  
   <p>
                                	<label>&nbsp;</label>
                                    <span><input type="hidden" name="isSubmit" value="save">
			<input type="submit" name="submit" value="Submit" onclick="return validate();">
			 <INPUT TYPE="button" VALUE="Back" ONCLICK="history.go(-1)">
			</span>
                                </p>
                                </form>		
							<?php }
							else 
							{
								?><p><font color="#0000ff"><b>Access Denied</b></font></p><?php
							}
							
							?>
							
                            </div>
                         
                            
  </div>
  
  </div>
    </div>
  </div>
</div>



<?php 
include('footer.php');

?>
</body>
</html>