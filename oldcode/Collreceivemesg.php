<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		Collreceivemesg.php
##	Create Date	:		23/07/2011
##  Description :		This file is used to receive message from those athlete who is approved by the college.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
session_start();

$func = new COMMONFUNC;
$db = new DB;
$flag=0;

$fldUserName = $_SESSION['FRONTEND_USER'];

 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message List</title>
<META NAME="Keywords" CONTENT="My Account">
<META NAME="Description" CONTENT="My Account">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">



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
<h1>Message List</h1>
<div class="registerPage">
<form name="frmUsers" action="" method="post" onsubmit="">
<?php 

     $selquery = "select fldId from ".TBL_COLLEGE_COACH_REGISTER." where fldUserName='$fldUserName' and fldStatus='ACTIVE'";
	 $db->query($selquery);
	 $db->next_record();
	 $fldId = $func->output_fun($db->f('fldId'));	     
	
	 
	  $selquery = "select * from ".TBL_NETWORK_MESSAGE." where fldCollegeid='$fldId'";
	  $db->query($selquery);
	  $db->next_record();
	 	 
	if($db->num_rows()=='0')
	 {
	 	?>
		 <div class="thankyoumessage">There is no Message in your network!</div>
		 
		 
		 <p>
    	<label>&nbsp;</label><br>
        <span><INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)"></span>
        </p>
		<?php
		
	 }
		   
		     
	else 
	{	    
	    
		echo "</br></br><table cellpadding=2 cellspacing=1 width=500 align='center'>"; 
		
		            echo '<tr>
							<td align="left" class="normalblack_12" width="8%">&nbsp;<strong>S.No.</strong></td>
							<td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Athlete(Email)</strong></td>
							<td align="left" class="normalblack_12" width="35%">&nbsp;<strong>Message</strong></td>';  		
				  echo '</tr>';							 
							   		
									
									
									
							
		
		$count="1";
		for ($i=0;$i<$db->num_rows();$i++) 
		{ 
			$athletename = $func->output_fun($db->f('fldAthletename'));
			$fldMessage = $func->output_fun($db->f('fldMessage'));
				
				echo '<tr>';
				echo '<td align="left" class="normalblack_12">&nbsp;'.($count).'</td>';
				echo '<td align="left" class="normalblack_12" >'.ucwords($athletename).'</td>';
                echo '<td align="left" class="normalblack_12" >'.$fldMessage.'</td>';
                echo '</tr>';
			
			
		
		$db->next_record();
		$count++;
		} 
		echo "</form></table>"; 
		
		?>
		<p>
    	<label>&nbsp;</label><br>
        <span><INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)"></span>
        </p>
		
		<?php
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