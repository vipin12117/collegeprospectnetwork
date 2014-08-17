<?php
    ##******************************************************************
    ##  Project		:		Sport Social Networking - Admin Panel
    ##  Done by		:		Narendra Singh
    ##	Page name	:		CoachAthapprove.php
    ##	Create Date	:		2/08/2011
    ##  Description :		This file is used to approve/reject athlete request.
    ##	Copyright   :       Synapse Communications Private Limited.
    ## *****************************************************************
    session_start();
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    if ($_SESSION['FRONTEND_USER'] == "") {
        header("Location:login.php");
    }
    $func = new COMMONFUNC;
    $page = new Page();
    $db = new DB;
    $db1 = new DB;
    $db2 = new DB;
    $flag = 0;
    $email = $_SESSION['EMAIL'];
    $userid=$_REQUEST['userID'];
	$que="select * from ".TBL_NETWORK." where (fldSenderid='".$_REQUEST['userID']."' AND fldSenderType='athlete' AND fldReceiverid='".$_SESSION['Coach_id']."' AND fldReceiverType='coach') OR (fldSenderid='".$_SESSION['Coach_id']."' AND fldSenderType='coach' AND fldReceiverid='".$_REQUEST['userID']."' AND fldReceiverType='athlete')"; 
	$db2 -> query($que);
	$db2 -> next_record();
	$netfldId = $func -> output_fun($db2 -> f('fldId'));   
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - Athlete Approval & Projection</title>
		<META NAME="Keywords" CONTENT="My Account">
		<META NAME="Description" CONTENT="My Account">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script language="JavaScript" type="text/JavaScript">
            function validate() {
                var error_msg = "";    
                //Check Values
                 if(trimString(document.frmSubmit.fldDivision.value) == "select") {
                    error_msg += "Please Select the Athlete's Projected Division. \n";
                }
                if(trimString(document.frmSubmit.fldComments.value) == "") {
                    error_msg += "Please Fill the Comment Box. \n";
                } else {
                    if(hasSpecialChars(document.frmSubmit.fldComments.value)) {
                        error_msg += "Your Comment has special characters.  Please remove: ^, {, }, <, > \n";
                    }
                }
              
                //Display Error
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            } 
function rate_this_athlete(fldID,fldAthleteID,isAdded)
{
try
{
if(isAdded == 1)
{
	fldID+="&mode=view";
}
window.open("RatingAthleteApproval.php?fldAthleteID="+fldAthleteID+"&mode=active&fldId="+fldID,"windowname1", "width=560, height=560"); 
//return false;
}catch(ex){alert(ex.message);}
}
        </script>
		
	</head>
	<body>
		<?php
            include ('header.php');
		?>
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
						    
							<?php if (($_REQUEST['msg'] == 1) and ($_POST['isSubmit']!='save')) {
							?>
    							<div class="thankyoumessage">
    								<?php  echo "Thank you. The athlete has been approved and a confirmation email has been sent to " . $_REQUEST['mail'];?>
    							</div>
							<?php  } else if (($_REQUEST['msg'] == 2) and ($_POST['isSubmit']!='save')) {?>
    							<div class="thankyoumessage">
    								<?php  echo "You have rejected this Athlete and Notification Email send to " . $_REQUEST['mail'];?>
    							</div>
							<?php  } ?>
							
							<h1>Project the Athlete's Ceiling</h1>
							
							<div class="registerPage">
								<div class="registerPage">
									<?php
									if($_POST['isSubmit']=='save')
									{
									    $success = 0;
    									if($func->input_fun($_POST['fldComments'])=='')
    									{
    									       $error_msg[]="Please Fill the Comment Box.";
    									       
    									} else if($func->input_fun($_POST['fldDivision'])=='')
    									{
    									       $error_msg[]="Please Select the Division.";
    									}
									   else
									   {	$userid=$_REQUEST['userID'];
        									$fldId = $_REQUEST['postId'];
        									$where = "fldId=".$userid;
        									$strDataArr=array('fldComments' => $func->input_fun($_POST['fldComments']),'fldDivision' => $func->input_fun($_POST['fldDivision']));
        									$db->updateRec(TBL_ATHELETE_REGISTER,$strDataArr, $where);
        									if(count($error_msg)==0)
        									{
        									    $success = 1;
        									?>
        									<div class="thankyoumessage">
        										<?php  echo "Athlete's Division Projection and Comment has been succesfully posted. ";?> <a href="CoachAthapprove.php" style="text-decoration: underline;">Return to Athlete Approval page</a>
        									</div>
        									<?
                                                }
                                        }
                                    }
									?>
									
									<?php
                                    if ($_POST['isSubmit']!='save')
                                    {
                                    ?>
									<p>Please select the top at which this athlete can contribute and write a short comment about their strengths</p>
									<?php
									}
									?>
																	
									
									<?php
									if (count($error_msg)>0)
									{
									   foreach($error_msg as $key=>$value)
									   {
									       echo "<div class='thankyoumessage'>" . $value . "</div>";
                                       }
                                    }

                                    if($error_msg!=""){
                                        $fldComments = $_REQUEST['fldComments'];
                                    }
                                    
                                    
									?>
									
									<?php if (($_REQUEST['msg'] == 1) && ($_POST['isSubmit']!='save')) {
                            ?>
									
									<form name="frmSubmit"  action="" method="post" onsubmit="return validate()">							<?php /*?><p>
											<div><a href="javascript:rate_this_athlete('<?php echo $netfldId ; ?>',<?php echo $userid; ?>,'0')" style="margin-left:10px;font-size:16px;float:right;">Rate This Approval Athlete</a></div>
										</p><?php */?>
										<p>
											<label>Projected Division:</label>
											<span>
												<select name="fldDivision">
													<option value="select" class="selectgrey">Please Select</option>
													<option value="DivisionI">Division I</option>
													<option value="DivisionII">Division II</option>
													<option value="DivisionIII">Division III</option>
													<option value="NAIA">NAIA</option>
													<option value="JUCO">JUCO</option>
												</select> </span><font color="#0000ff">&nbsp;*</font>
										</p>
										<p style="padding-top:0px;padding-bottom:0px;;">
                                            <label>&nbsp;</label>
                                            <span>*Projected Division is only visible to College Coaches</span>
                                        </p>
										<p>
											<label>Comments:</label>
											<span><textarea name="fldComments" id="fldComments" class="ta1"><?=$fldComments?></textarea></span><font color="#0000ff">&nbsp;*</font>
										</p>
										<p style="padding-top:0px;padding-bottom:0px;;">
										    <label>&nbsp;</label>
										    <span>*Comments are visible to all users.</span>
										</p>
										<p>
											<label>&nbsp;</label>
											<span>
											    <input type="hidden" name="postId" value="<? echo $AthleteID;?>">
												<input type="hidden" name="isSubmit" value="save">
												<button type="submit" class="normalbtn">
													Submit
												</button>&nbsp;&nbsp;&nbsp;&nbsp; </span>
										</p>
									</form>
									
									<?php
									}
                                    ?>
									<br /><br /><br /><br />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
                include ('footer.php');
			?>
	</body>
</html>