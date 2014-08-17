<?php //

########################################################################
	##															
	##	File Name		: forgot_password.php												
	##	Created By		: Saurabh Kumar
	##	Created On		: 11 August, 2009
	##	Company		    : Synapse Communications Pvt. Ltd., India
	##	Purpose			: Registration (Front End)
	##
	########################################################################

		include_once("../inc/common_functions.php");
		include_once("../inc/config.inc.php");	// for admin login
        include_once("../inc/db.inc.php");
        include_once("connection.class.php");
		$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
		$db=new DB();
		 
		
		if($_POST["submit"] == "Submit") {
		
		
		if(trim($_POST['email']) == "") {
			$error['email'] = 'Please Enter Email';
			$error_flag = 1;
		}
	$email=$_POST['email'];
		
		if ((!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) && !empty($_POST['email']))
			{
				$error['email'] = 'Please Enter Valid Email';
				$error_flag = 1;
			}

		$msg = "";
		if($error_flag == 0) {
			$connObj = new Connection($db->Host,$db->User,$db->Password,$db->Database);
			 $strNewPassword = get_rand_id(6);
			$encryptPwd = $strNewPassword;
			
			// Check if email exists in the database
			$where = " where `uemail` = '".$_POST['email']."'";
			$NumRows = $connObj->getNumRows(TBL_ADMIN, $where);
			
			if($NumRows > 0)
			{
				$user = $connObj->getSingleRow(TBL_ADMIN,"where uemail='".$_POST['email']."'");
				
				$sql = mysql_query("UPDATE ".TBL_ADMIN." set password = '".$encryptPwd."' where uemail='".$_POST['email']."'") or die(mysql_error());
				//Send email for notification
				sendmail($_POST['email'],$strNewPassword, $user['username'], $user['status']);
				$msg = "<div class='error'>Your password has been reset and mailed to you on your registered email id.</div>";
			} else {
				$msg = "<div class='error'>User not found. Please try again.</div>";
			}
		}
	}
	
	//generate random string
	function get_rand_id($length)
	{
	  if($length>0) 
	  { 
	  $rand_id="";
	   for($i=1; $i<=$length; $i++)
	   {
	   mt_srand((double)microtime() * 1000000);
	   $num = mt_rand(1,36);
	   $rand_id .= assign_rand_value($num);
	   }
	  }
	return $rand_id;
	} 
	
	function assign_rand_value($num)
	{
		// accepts 1 - 36
		  switch($num)
		  {
		    case "1": $rand_value = "a";		    break; 
		    case "2": $rand_value = "b";		    break;
		    case "3": $rand_value = "c";		    break;
		    case "4": $rand_value = "d";		    break;
		    case "5": $rand_value = "e";		    break;
		    case "6": $rand_value = "f";		    break;
		    case "7": $rand_value = "g";		    break;
		    case "8": $rand_value = "h";		    break;
		    case "9": $rand_value = "i";		    break;
		    case "10": $rand_value = "j";		    break;
		    case "11": $rand_value = "k";		    break;
		    case "12": $rand_value = "l";		    break;
		    case "13": $rand_value = "m";		    break; 
		    case "14": $rand_value = "n";		    break;
		    case "15": $rand_value = "o";		    break;
		    case "16": $rand_value = "p";		    break;
		    case "17": $rand_value = "q";		    break;
		    case "18": $rand_value = "r";		    break;
		    case "19": $rand_value = "s";		    break;
		    case "20": $rand_value = "t";		    break;
		    case "21": $rand_value = "u";		    break;
		    case "22": $rand_value = "v";		    break;
		    case "23": $rand_value = "w";		    break;
		    case "24": $rand_value = "x";		    break;
		    case "25": $rand_value = "y";		    break;
		    case "26": $rand_value = "z";		    break;
		    case "27": $rand_value = "0";		    break;
		    case "28": $rand_value = "1";		    break;
		    case "29": $rand_value = "2";		    break;
		    case "30": $rand_value = "3";		    break;
		    case "31": $rand_value = "4";		    break;
		    case "32": $rand_value = "5";		    break;
		    case "33": $rand_value = "6";		    break;
		    case "34": $rand_value = "7";		    break;
		    case "35": $rand_value = "8";		    break;
		    case "36": $rand_value = "9";		    break;
		  }
		return $rand_value;
		}
		
	function sendmail($email,$password, $firstname, $lastname) {
		$to = $email;
		
		$subject  = 'change your password';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		$headers .= 'From:  synapse135@gmail.com' . "\r\n";

		

		$message .= "<html>\n";
		$message .= "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:14px; color:#666666;\">\n"; 
		$message .= "<br>";
		$message .= "Dear ".$firstname." ".$lastname.", <br><br> Your password has been reset. New Password is as follows:\n<br><br>";
		
		$message .= "Password : ".$password."\n<br><br>";
		$message .= "Thank You\n\n";
		$message .= "</body>\n";
		$message .= "</html>\n";
		
		$mail_sent = mail( '"'.$to.'"', $subject, $message, $headers );
		if($mail_sent)
			return true;
		else
			return false;
	 }
?>

<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TR>
<TD height=120>
<?include "include/ADheader.php";?>
</TD>
</TR>
<TR>
<TD></TD>
</TR>
<tr><td align="center"><?php echo $msg; ?>
<?php if(isset($error['email'])) echo $error['email']; ?></td></tr>
<TR>
<TD class="heading">
<TABLE cellSpacing=0 cellPadding=0 width=716 align=center border=0>
<TR>
<TD align="center">
	<table width="400" border="0" cellpadding="1" cellspacing="0" bgcolor="#4A74A5">
	<form name="forgot_password" method="POST" action="forgot_password.php">
	<tr>
	<td>
	<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
	<td>
			
			
			<table width="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF">
			<tr align="center" valign="middle">
			<td colspan="2" class="normalblack_12"><br>
			<strong>Forgot Password</strong> </td>
			
			</tr>
			
			
				
			<tr align="center" valign="middle"><td colspan="2" class="normalblack_12">&nbsp;</td>
			</tr>
			<tr>
			<td align="right" class="normalgrey_12">Enter Your Email : </td>
			<td>
			<input type="text" name="email" id="email" class="long_inputbox" size="35"></td>
			</tr>
			
			
			<tr>
			<td>&nbsp;</td>
			<td align="left" height="30">
			<input type="submit" name="submit" id="submit" class="button" value="Submit">   
			</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td align="left" height="30" class="normalblack_12">
			</td>
			</tr>
			
			</table>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</form>
	</table>
	</TD>
	</TR>
	</TABLE>
	</TD>
	</TR>
	<TR>
	<TD height=27 class="normalgrey_12">&nbsp;</TD>
	</TR>
	<?include "include/ADfooter.php";?>
	<? unset($func);  unset($page);   unset($db); ?>
	</TABLE>
	</BODY>
	</HTML>