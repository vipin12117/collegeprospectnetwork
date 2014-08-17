<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    session_start();
    //for paging
    $func = new COMMONFUNC;
    $db = new DB;
    $flag = 0;
    $query = " Select * from " . TBL_PAGE . " where fldPageTitle = '" . $_REQUEST['page_name'] . "' ";
    $db -> query($query);
    $db -> next_record();
    if ($db -> num_rows() > 0) {
        $flag = 1;
        $db -> query($query);
        $db -> next_record();
        //print_r();
    }
    if ((isset($_POST['isSubmit'])) and ($_POST['isSubmit'] == 'save')) {
        
        $Comments = str_replace("\n", "<br>", $_POST['fldComments']); 
        
        
        $msg = '<b>Contact Form Details:</b><br /><br />
        <b>Name:</b> ' . $_POST['fldName'] . '<br /><br />
        <b>Email:</b> ' . $_POST['fldEmail'] . '<br /><br />
        <b>Comments:</b><br />' . $Comments. '<br />
        
           </div>';
        //$toStre1 = "admin@collegeprospectnetwork.com";
        $subjectStre = "[CPN] - Contact Inquiry ";
        $bodyStre = $msg;
		$admin_mail="admin@collegeprospectnetwork.com";
	    SendHTMLMail1($admin_mail,$subjectStre,$bodyStre,$_POST['fldEmail']);
        //if (isset($t)) {
            //Thanks for sending mail
            header("location:page.php?page_name=contactus&msg=Your email has been sent to the appropriate team to best address your needs, and you should receive a response shortly.");
        //}
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php
            if ($flag == 1) {
                echo $db -> f('fldPageMetaTitle');
            }
			?></title>
		<META NAME="Keywords" CONTENT="<?php
            if ($flag == 1) {
                echo $db -> f('fldPageMetaKeyword');
            }
		?>">
		<META NAME="Description" CONTENT="<?php
            if ($flag == 1) {
                echo $db -> f('fldPageMetaDescraption');
            }
		?>">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
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
						<div class="register-main" style="height:629px;">
							<div class="registerPage_cmspage">
								<?php   echo $func -> output_fun($db -> f('fldPageDescraption'));?>
								<?php  if((isset($_REQUEST['page_name'])) and ($_REQUEST['page_name']=='contactus'))
                        {
								?>
								<script language="JavaScript" type="text/JavaScript">
                                    function validate() {
                                        var error_msg = "";
                                        if(trimString(document.frmAthReg.fldName.value) == "") {
                                            error_msg += "Please Enter Name! \n";
                                        } else {
                                            if(hasSpecialCharaters(document.frmAthReg.fldName.value)) {
                                                error_msg += "Enter valid  Name! \n";
                                            }
                                        }
                                        if(trimString(document.frmAthReg.fldEmail.value) == "") {
                                            error_msg += "Please Enter Email! \n";
                                        } else {
                                            if(!isValid(document.frmAthReg.fldEmail.value)) {
                                                error_msg += "Enter Valid Email! \n";
                                            }
                                        }
                                        if(trimString(document.frmAthReg.fldComments.value) == "") {
                                            error_msg += "Please Enter Comments! \n";
                                        } else {
                                            if(hasSpecialCharaters(document.frmAthReg.fldComments.value)) {
                                                error_msg += "Please Enter Comments! \n";
                                            }
                                        }
                                        if(error_msg != '') {
                                            alert(error_msg);
                                            return false;
                                        } else {
                                            return true;
                                        }
                                    }

                                    function getSportID(val) {
                                        return val;
                                    }
								</script>
								<form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()" style="width:800px;">
									<?php?>
									<div class="msg" >
										<font color="#0000ff">*</font> Fields are Mandatory.
									</div>
									<div class="registerPage">
										<?php if($_GET['msg']) {
										?>
										<div class="thankyoumessage">
											<?php   echo $_GET['msg'];?>
										</div>
										<?php   }?>
										<p>
											<label style="width:100px;">Name:</label>
											<span>
												<input type="text" name="fldName" value="<?=$fldName?>" />
												<font color="#0000ff">*</font></span>
										</p>
										<p>
											<label style="width:100px;">Email:</label>
											<span>
												<input type="text" name="fldEmail"  value="<?=$fldEmail?>" />
												<font color="#0000ff">*</font></span>
										</p>
										<p>
											<label style="width:100px;">Comments:</label>
											<span><textarea  rows="5" cols="15" value="<?=$fldComments?>" name="fldComments" style="width:340px;"><?=$fldComments?></textarea><font color="#0000ff">*</font></span>
										</p>
										<p>
											<label style="width:100px;">&nbsp;</label>
											<span>
												<input type="hidden" name="isSubmit" value="save">
												<input type="submit" name="submit" value="Send"/>
											</span>
										</p>
									</div>
								</form>
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
            include ('footer.php');
		?>
	</body>
</html>