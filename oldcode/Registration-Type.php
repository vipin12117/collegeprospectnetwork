<?php
include_once ("inc/common_functions.php");//for common function
include_once ("inc/page.inc.php");
if (($_REQUEST['user_type'] == "Athlete")) {
	header("Location:Registration-Athlete.php");
}
if (($_REQUEST['user_type'] == "HS / AAU Coach")) {
	header("Location:Registration-HS-Coach.php");
}
if (($_REQUEST['user_type'] == "College Coach")) {
	header("Location:Registration-College-Coach.php");
}
$func = new COMMONFUNC;
$db = new DB;
$flag = 0;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">	<head>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>College Prospect Network - Select User Type</title>		<link href="css/style.css" rel="stylesheet" type="text/css" />		<script type="text/javascript">            function formsubmit(param) {
                window.location = "Registration-Type.php?user_type=" + param;
            }		</script>	</head>	<body>		<?php		include ('header.php');		?>
		<!--header link starts from here -->		<!--Header ends from here -->		<!--middle panel starts from here -->		<!--content panel starts from here -->		<div class="container">			<div class="innerWraper">				<div class="middle-bg">					<div class="cantener">						<div class="register-main">							<div class="registerPage">								<h1>User Registration - Select Account Type</h1>								<form name="user_type" method="POST">									<p>										<label>Select User Type:</label>										<span> <?php echo '<select name="fldUserType" onchange="javascript:return formsubmit(this.value);"><option value="Select">------- Select User Type -------</option>';
											echo '<option value ="Athlete" >Athlete Registration</option>';
											echo '<option value ="HS / AAU Coach" >HS / AAU Coach Registration</option>';
											echo '<option value ="College Coach" >College Coach Registration</option>';
											echo $strcombo = '</select>';											?></span>									</p>								</form>							</div>						</div>					</div>				</div>			</div>		</div>		<?php			include ('footer.php');		?>	</body></html>