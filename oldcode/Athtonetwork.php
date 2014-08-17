<?php
session_start();
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");
if($_SESSION['FRONTEND_USER']=="")
{
	header("Location:login.php");
}				//for paging

$func = new COMMONFUNC;
$db = new DB;
//$flag=1;

if($_POST['isSubmit']=='save')
{
   		   
   				
				if ($_REQUEST['collegeid']== '')
				{
					 $error_msg[]=" Please Select College";
				}
					
				
			 $collegeid = $func->input_fun($_POST['collegeid']);
				
	$ath_name=$func->selectTableOrder(TBL_ATHELETE_REGISTER,"fldFirstname,fldLastname","fldId","where fldId='".$_SESSION['Athlete_id']."' and fldStatus ='ACTIVE'");
	$name = ucfirst($ath_name[0]['fldFirstname']).' '.ucfirst($ath_name[0]['fldLastname']);
			
	
     $strDataArr=array(
		     'collegeid' 				=> $collegeid,
		     'athleteid' 				=> $_SESSION['Athlete_id'],
		     'athname'                  => $name,
			 'status' 			        => $func->input_fun($_POST['status']));
			 
			 $whereClause = "athleteid='".$_SESSION['Athlete_id']."' and collegeid = '".$collegeid."'";
			 
			 if($db->MatchingRec(TBL_ADDTONETWORK_REQUEST,$whereClause)>0) 
		       {    
			   	 $error_msg[] = 'You Have Already Send the Request!';
			   }	
			 
			if (count($error_msg)==0)
			{
		 	  $db->insertRec(TBL_ADDTONETWORK_REQUEST,$strDataArr);
	 		  $msg =  "Your Request has been sent! Wait for Approval";
	 		  header("Location: myaccount.php?msg=$msg");
			}
			
			
	
}


?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add to Network</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>

<script language="JavaScript" type="text/JavaScript">
function validate()
{
	
	
	var error_msg = "";
	     
	if(trimString(document.frmNetReg.collegeid.value) == ""){
		error_msg += "Please Select College. \n";
	}
	else{
		if(hasSpecialCharaters(document.frmNetReg.collegeid.value)){
			error_msg += "Please Select College. \n";
		}
	}
	
	if(error_msg!=''){
	alert(error_msg);
	return false;
	}
	
	else
	
	{
		return true;
	}
	
}	
	
</script>
</head>

<body>
<!--header link starts from here -->
<?php include('header.php'); ?>
    <!--Header ends from here -->
    <!--middle panel starts from here -->
<!--content panel starts from here -->
<div class="container">
<div class="innerWraper">
<div class="middle-bg">
<div class="cantener">
<div class="register-main">
<h1>Add To Network</h1>
<?php
	
	if (count($error_msg)>0)
	{
	 foreach($error_msg as $key=>$value)
		{
		?>
			<div class="thankyoumessage"><?php echo $value. "<br>";?> </div>
		<?
		}
	}
		?>

  <div class="registerPage">
  <form name="frmNetReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
  
	<p>
	<label>Select College-Coach:</label>
	<span>                          
        <?php                            
		echo $strcombo = '<select name="collegeid" style="width:276px">';
		echo $strcombo = '<option value = "">-Please Select College-</option>';
		$collegelist=$func->selectTableOrder(TBL_COLLEGE_COACH_REGISTER,"fldId,fldFirstName,fldLastName","fldId");
		for ($i=0;$i<count($collegelist);$i++) 
   		{
  		  echo '<option value ="'.$collegelist[$i]['fldId'].'">'.$collegelist[$i]['fldFirstName'].'&nbsp;'.$collegelist[$i]['fldLastName'].'</option>';
    			
   		}
        echo $strcombo = '</select>';
        ?>         
    </span>
    </p>
                                                           
                                                               
     <p>
     <span><input type="hidden" name="status"  value="DEACTIVE" /></span>
     </p>
                               
                                
                              
                                
    <p>
    	<label>&nbsp;</label>
        <span><input type="hidden" name="isSubmit" value="save">
        <input type="submit" value="Send Request"/>
		<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)"></span>
    </p> 
                                </form>
</div>
</div>
</div>
</div>
</div>
</div>


<?php include('footer.php'); ?>
</body>
</html>


