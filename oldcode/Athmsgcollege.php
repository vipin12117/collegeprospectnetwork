<?php
session_start();
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");				//for paging

$func = new COMMONFUNC;
$db = new DB;


if($_POST['isSubmit']=='save')
{
   		   
   				
				if ($func->input_fun($_POST['to'])== '')
				{
					 $error_msg[]= "Please Select College";
				}

				
				else if($func->input_fun($_POST['subject'])== '')
				{
					$error_msg[]= "Please Enter Subject";
				}
				
				
				else if($func->input_fun($_POST['message'])== '')
				{
					$error_msg[]= "Please Enter Message";
				}
				
				
				
				 if (count($error_msg)>0)
								 {
								
									 foreach($error_msg as $key=>$value)
									 {
?>
<div class="thankyoumessage">	<?php  echo $value . "<br>";?></div><?
}
}
else
{
$date = date(YmdHis);
$to = $func->input_fun($_POST['to']);
$subject = $func->input_fun($_POST['subject']);
$message = $func->input_fun($_POST['message']);
$strDataArrw=array(
'UserTo'        => $to,
'UserFrom'      => $_SESSION['FRONTEND_USER'],
'Subject'       => $subject,
'Message'       => $message,
'SentDate'      => $date,
'status'        => 'unread',
'visible'       => 'ACTIVE',
'Usertypeto'    => 'college',
'Usertypefrom'  => $_SESSION['mode']
);
$db->insertRec(TBL_MAIL,$strDataArrw);?>
<div align="center">	<?php
	$msg = "Message successfully sent.";
	echo "<script>document.location.href='Athmessage.php?action=inbox&msg=$msg'</script>";	?></div><?php
}
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">	<head>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>Send Messages</title>		<link href="css/style.css" rel="stylesheet" type="text/css" />		<script language="Javascript" src="javascript/functions.js"></script>		<script language="JavaScript" type="text/JavaScript">            function validate() {
                var error_msg = "";
                if(trimString(document.frmNetReg.to.value) == "") {                    error_msg += "Please Select College. \n";
                } else {
                    if(hasSpecialCharaters(document.frmNetReg.to.value)) {                        error_msg += "Please Select College. \n";
                    }
                }
                if(trimString(document.frmNetReg.subject.value) == "") {                    error_msg += "Please Enter Subject. \n";
                } else {
                    if(hasSpecialCharaters(document.frmNetReg.subject.value)) {                        error_msg += "Please Enter Subject. \n";
                    }
                }
                if(trimString(document.frmNetReg.message.value) == "") {                    error_msg += "Please Enter Message. \n";
                } else {
                    if(hasSpecialCharaters(document.frmNetReg.message.value)) {                        error_msg += "Please Enter Message. \n";
                    }
                }
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            }		</script>	</head>	<body>		<!--header link starts from here -->		<?php		include ('header.php');		?>
		<!--Header ends from here -->		<!--middle panel starts from here -->		<!--content panel starts from here -->		<div class="container">			<div class="innerWraper">				<div class="middle-bg">					<div class="cantener">						<div class="register-main">							<h1>Send Messages</h1>							<?php
if (count($error_msg)>0)
{
foreach($error_msg as $key=>$value)
{
							?>
							<?php  echo $value . "<br>";?>
							<?
							}
							}							?>
							<?php if($_REQUEST['msg']) {							?>
							<div class="thankyoumessage">								<?php  echo $_REQUEST['msg'];?>							</div>							<?php  }?>
							<div class="registerPage">								<form name="frmNetReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">									<?php
$selquery1 = "select collegeid from ".TBL_ADDTONETWORK_REQUEST." where athleteid='".$_SESSION['Athlete_id']."' and status='ACTIVE'";
$db1->query($selquery1);
$db1->next_record();
if($db1->num_rows()>0)
{
for ($i=0;$i<$db1->num_rows();$i++)
{
$collegeid .= $func->output_fun($db1->f('collegeid')).",";
$db1->next_record();
}
$collegeid =substr($collegeid,0,-1);
									?>
									<p>										<label>Select College(To):</label>										<span> <?php
										echo $strcombo = '<select name="to">';
										echo $strcombo = '<option value = "">Select College</option>';
										$collegelist = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldUserName,fldId,fldFirstName,fldLastName", "fldId", "where fldId in ($collegeid)");
										for ($i = 0; $i < count($collegelist); $i++) {
											echo '<option value ="' . $collegelist[$i]['fldUserName'] . '" >' . $collegelist[$i]['fldFirstName'] . '&nbsp;' . $collegelist[$i]['fldLastName'] . '</option>';
										}
										echo $strcombo = '</select>';											?></span>									</p>									<p>										<label>Subject:</label>										<span>											<input type="text" name="subject" value="<?=$subject?>">										</span>									</p>									<p>										<label>Message:</label>										<span> 											<textarea rows=14 cols=69 name="message"><?=$message?></textarea> </span>									</p>									<p>										<span>											<input type="hidden" name="status"  value="ACTIVE" />										</span>									</p>									<p>										<label>&nbsp;</label>										<span>											<input type="hidden" name="isSubmit" value="save">											<input type="submit" value="Send Message	"/>											<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">										</span>									</p>									<?php
									}
									else
									{
									echo '<p><label>&nbsp;</label><span><div class="thankyoumessage">Your Network Request Is Not Approved!</div></span></p>';
									echo '<p><label>&nbsp;</label><span><INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)"></span></p>';
									}									?>							</div>						</div>					</div>				</div>			</div>		</div>		<?php		include ('footer.php');		?>	</body></html>