<?php
##******************************************************************
##  Project     :       Sport Social Networking - Admin Panel
##  Done by     :       Narendra Singh
##  Page name   :       index.php
##  Create Date :       10/06/2011
##  Description :       This is for admin login.
##  Copyright   :       Synapse Communications Private Limited.
## *****************************************************************
session_start();
include_once("../inc/common_functions.php");    //for common function
$func = new COMMONFUNC; //Create an instance of class COMMONFUNC

if(isset($_POST['btnSubmit']))
    {

      $userName =  $func->input_fun($_POST['username']);
      $passsword = $func->input_fun($_POST['password']);
        
      $whereClause = "username='".$userName."' and password= '".$passsword."'";
        
    
    
    /* ' and fld_admin_status= 'A'"; */
   
    $retVal = $db->MatchingRec(TBL_ADMIN,$whereClause);
    if($retVal!=0) 
    {
        

        $query =" Select username from ".TBL_ADMIN. " where  username = '$userName' ";
        $db->query($query);
        $admin_id   = $db->f('username');
        $fNname     = $func->output_fun($db->f('fld_firstname'));
        $lName      = $func->output_fun($db->f('fld_lastname'));

        $_SESSION['ADMIN_UID'] = $admin_id;
        $_SESSION['ADMIN_SESS'] = ucwords($fNname).' '.ucwords($lName);
        $_SESSION['ADMIN_USER'] = $userName;
         header("Location:ADmain.php");
    }
    else 
    {
        $msg_no ="Incorrect Username/Password";
    }
}
?>
<HTML>
<HEAD>
<TITLE><?=ADMIN_SITE_TITLE?></TITLE>
<SCRIPT LANGUAGE="JavaScript" src="../javascript/functions.js"></SCRIPT>
<script language="javascript">
function validate(docForm){
    if( trimString(docForm.username.value) == ""){
        alert("Please enter Username!");
        docForm.username.focus();
        return false;
    }
    if(trimString(docForm.username.value)!=""){
        if(hasSpecialCharaters(docForm.username.value)){
            alert("Please enter valid Username!");
            docForm.username.focus();
            return false;
        }
    }

    if( trimString(docForm.password.value) == ""){
        alert("Please enter Password!");
        docForm.password.focus();
        return false;
    }

    return true;
}
</script>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" OnLoad="document.adminForm.username.focus();">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TR>
<TD height=120>
<?include "include/ADheader.php";?>
</TD>
</TR>
<TR>
<TD></TD>
</TR>
<TR>
<TD class="heading">
<TABLE cellSpacing=0 cellPadding=0 width=716 align=center border=0>
<TR>
<TD align="center">
    <table width="400" border="0" cellpadding="1" cellspacing="0" bgcolor="#4A74A5">
    <form name="adminForm" action="" method="POST" onsubmit="return validate(document.adminForm);">
    <tr>
    <td>
    <table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
    <td>
            <table width="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF">
            <tr align="center" valign="middle">
            <td colspan="2" class="normalblack_12"><br>
            <strong>Administrator Login</strong> </td>
            </tr>
            <?
            if($msg_no!="")
            {
                echo "<tr align='center' valign='middle'><td colspan='2' class='normalblack_12'>&nbsp;</td></tr><tr align='center' valign='middle'><td colspan='2' class='normalblack_12'><font color=red>$msg_no</font></td></tr>";
            }
            ?>  
            <tr align="center" valign="middle"><td colspan="2" class="normalblack_12">&nbsp;</td>
            </tr>
            <tr>
            <td align="right" class="normalgrey_12">Username : </td>
            <td>
            <input name="username" type="text" maxlength="100" class="normalgrey_12" value=""></td>
            </tr>
            <tr>
            <td align="right" class="normalgrey_12">Password : </td>
            <td><input name="password" type="password" maxlength="50" class="normalgrey_12" value=""></td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td align="left" height="30">
            <input name="btnSubmit" type="submit" class="normalblack_12" value="Submit">    
            </td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td align="left" height="30" class="normalblack_12">
            
            
            <a class="link" href="#" onclick="javascript:window.open('forgot_password.php','ForgotPassword','left=20,top=20,width=600,height=290,toolbar=0,resizable=0,menubar=0,scrollbars=0');"> Forgot Password </a>
            
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