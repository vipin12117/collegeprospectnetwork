<?php    include_once ("inc/common_functions.php");    //for common function    include_once ("inc/page.inc.php");    $func = new COMMONFUNC;    $db = new DB;    $flag = 0;    $error_msg = '';    if ($_POST['isSubmit'] == 'save') {        $fldEmail = $func -> input_fun($_POST['fldEmail']);        $question = $func -> input_fun($_POST['question']);        $answer = $func -> input_fun($_POST['answer']);        $logininfo = $func -> input_fun($_POST['logininfo']);        if ($logininfo == 'athlete') {            $whereClause = "fldEmail='" . $fldEmail . "' and fldStatus ='ACTIVE'";            $whereClauseques = "fldQuestion='" . $question . "'";            $whereClauseans = "fldAnswer='" . $answer . "'";            if ($db -> MatchingRec(TBL_ATHELETE_REGISTER, $whereClause) == 0) {                $error_msg = 'Email Invalid, Please Enter Valid Email';            } else if ($db -> MatchingRec(TBL_ATHELETE_REGISTER, $whereClauseques) == 0) {                $error_msg = 'Question Invalid, Please Enter Valid Question';            } else if ($db -> MatchingRec(TBL_ATHELETE_REGISTER, $whereClauseans) == 0) {                $error_msg = 'Answer Invalid, Please Enter Valid Answer';            } else {                if ($error_msg == '') {                    $query = "select fldFirstname,fldPassword,fldUsername from " . TBL_ATHELETE_REGISTER . " where fldEmail = " . "'$fldEmail'";                    $db -> query($query);                    $db -> next_record();                    $firstname = $func -> output_fun($db -> f('fldFirstname'));                    $password = $func -> output_fun($db -> f('fldPassword'));                    $username = $func -> output_fun($db -> f('fldUsername'));                    $subjectStre = "College Prospect Network - Password Recovery";                    $bodyStre = "Hello&nbsp;" . ucfirst($firstname) . ",</br></br>";                    $bodyStre .= "Here is your log-in information for College Prospect Network:</br></br>";                    $bodyStre .= "Username -" . $username . "<br />";                    $bodyStre .= "Password -" . $password . "<br /><br />";                    $bodyStre .= "Thank you," . "<br />";                    $bodyStre .= "College Prospect Network Support";                    $adminmail = ADMIN_EMAIL;                    $func -> sendEmail($fldEmail, $subjectStre, $bodyStre, $adminmail);                    header("Location: login.php?&msgforpass=Your password has been sent to your email.");                }            }        }        /////////////////////////////////        if ($logininfo == 'coach') {            $whereClause = "fldEmail='" . $fldEmail . "' and fldStatus ='ACTIVE'";            $whereClauseques = "fldQuestion='" . $question . "'";            $whereClauseans = "fldAnswer='" . $answer . "'";            if ($db -> MatchingRec(TBL_HS_AAU_COACH, $whereClause) == 0) {                $error_msg = 'This Email is not Exists,Please Enter Valid Email';            } else if ($db -> MatchingRec(TBL_HS_AAU_COACH, $whereClauseques) == 0) {                $error_msg = 'This Question is not Exists,Please Enter Valid Question';            } else if ($db -> MatchingRec(TBL_HS_AAU_COACH, $whereClauseans) == 0) {                $error_msg = 'This Answer is not Exists,Please Enter Valid Answer';            } else {                if ($error_msg == '') {                    $query = "select fldName,fldUsername,fldPassword from " . TBL_HS_AAU_COACH . " where fldEmail = " . "'$fldEmail'";                    $db -> query($query);                    $db -> next_record();                    $firstname = $func -> output_fun($db -> f('fldName'));                    $username = $func -> output_fun($db -> f('fldUsername'));                    $password = $func -> output_fun($db -> f('fldPassword'));                    $subjectStre = "College Prospect Network Password";                    $bodyStre = "Hello&nbsp;" . ucfirst($firstname) . ",<br /><br />";                    $bodyStre .= "Here is your log-in information for College Prospect Network:<br /><br />";                    $bodyStre .= "Username -" . $username . "<br />";                    $bodyStre .= "Password -" . $password . "<br /><br />";                    $bodyStre .= "Thank you," . "<br />";                    $bodyStre .= "College Prospect Network Support";                    $adminmail = ADMIN_EMAIL;                    $func -> sendEmail($fldEmail, $subjectStre, $bodyStre, $adminmail);                    header("Location: login.php?&msgforpass=Your password has been sent to your email.");                }            }        }        ////////////////////////////////        if ($logininfo == 'college') {            $whereClause = "fldEmail='" . $fldEmail . "' and fldStatus ='ACTIVE'";            $whereClauseques = "fldQuestion='" . $question . "'";            $whereClauseans = "fldAnswer='" . $answer . "'";            if ($db -> MatchingRec(TBL_COLLEGE_COACH_REGISTER, $whereClause) == 0) {                $error_msg = 'This Email is not Exists,Please Enter Valid Email';            } else if ($db -> MatchingRec(TBL_COLLEGE_COACH_REGISTER, $whereClauseques) == 0) {                $error_msg = 'This Question is not Exists,Please Enter Valid Question';            } else if ($db -> MatchingRec(TBL_COLLEGE_COACH_REGISTER, $whereClauseans) == 0) {                $error_msg = 'This Answer is not Exists,Please Enter Valid Answer';            } else {                if ($error_msg == '') {                    $query = "select fldFirstName,fldUserName,fldPassword from " . TBL_COLLEGE_COACH_REGISTER . " where fldEmail = " . "'$fldEmail'";                    $db -> query($query);                    $db -> next_record();                    $firstname = $func -> output_fun($db -> f('fldFirstName'));                    $username = $func -> output_fun($db -> f('fldUserName'));                    $password = $func -> output_fun($db -> f('fldPassword'));                    $subjectStre = "College Prospect Network Password";                    $bodyStre = "Hello&nbsp;" . ucfirst($firstname) . ",<br /><br />";                    $bodyStre .= "Here is your log-in information for College Prospect Network:<br /><br />";                    $bodyStre .= "Username -" . $username . "<br />";                    $bodyStre .= "Password -" . $password . "<br /><br />";                    $bodyStre .= "Thank you," . "<br />";                    $bodyStre .= "College Prospect Network Support";                    $adminmail = ADMIN_EMAIL;                    $func -> sendEmail($fldEmail, $subjectStre, $bodyStre, $adminmail);                    header("Location: login.php?&msgforpass=Your password has been sent to your email.");                }            }        }        //this section is use to filup the value after error message.        if ($error_msg != "") {            $fldEmail = $_REQUEST['fldEmail'];            $question = $_REQUEST['question'];            $answer = $_REQUEST['answer'];        }    }?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">	<head>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>Forgot Password</title>		<META NAME="Keywords" CONTENT="My Account">		<META NAME="Description" CONTENT="My Account">		<link href="css/style.css" rel="stylesheet" type="text/css" />		<script language="Javascript" src="javascript/functions.js"></script>		<script language="JavaScript" type="text/JavaScript">            function validate() {                var error_msg = "";                if(trimString(document.frmAthReg.fldEmail.value) == "") {                    error_msg += "Please Enter Email. \n";                } else {                    if(!isValid(document.frmAthReg.fldEmail.value)) {                        error_msg += "Please Enter Valid Email. \n";                    }                }                if(trimString(document.frmAthReg.question.value) == "") {                    error_msg += "Please Enter Security Question. \n";                } else {                    if(hasSpecialCharaters(document.frmAthReg.question.value)) {                        error_msg += "Please Enter Valid Security Question. \n";                    }                }                if(trimString(document.frmAthReg.answer.value) == "") {                    error_msg += "Please Enter Security Answer. \n";                } else {                    if(hasSpecialCharaters(document.frmAthReg.answer.value)) {                        error_msg += "Please Enter Valid Security Answer. \n";                    }                }                if(error_msg != '') {                    alert(error_msg);                    return false;                } else {                    return true;                }            }		</script>	</head>	<body>		<?php            include ('header.php');		?>		<!--middle panel starts from here -->		<!--content panel starts from here -->		<div class="container">			<div class="innerWraper">				<div class="middle-bg">					<div class="cantener">						<div class="register-main">							<h1>Reset Password</h1>							<div class="registerPage">								<form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">									<?php if ($error_msg!=''){									?>
									<div class="thankyoumessage">										<?  echo $error_msg;?>									</div>									<?php                                        }									?>
									<p>										<label>Enter your email:</label>										<span>											<input type="text" name="fldEmail" value="<?=$fldEmail?>" />										</span><font color="#0000ff">*</font>									</p>									<p>										<label>Enter your Security Question:</label>										<span>											<input type="text" name="question" value="<?=$question?>" />										</span><font color="#0000ff">*</font>									</p>									<p>										<label>Enter your Security Answer:</label>										<span>											<input type="text" name="answer" value="<?=$answer?>" />										</span><font color="#0000ff">*</font>									</p>									<p>										<label>User Type:</label>										<span class="rdio-spac">											<input type="radio"  name="logininfo" value="athlete" checked="checked"/>											<label>Athlete</label>											<input type="radio"  name="logininfo" value="coach">											<label>High School / AAU Coach</label>											<input type="radio"  name="logininfo" value="college"/>											<label>College Coach</label> </span>									</p>									<p>										<label>&nbsp;</label>										<span>											<input type="hidden" name="isSubmit" value="save">											<input type="submit" name="submit" value="Submit"/>											<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">										</span>									</p>							</div>						</div>					</div>				</div>			</div>		</div>		<?php            include ('footer.php');		?>	</body></html>