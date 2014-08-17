<?php
    ##******************************************************************
    ##  Project		:		Sport Social Networking - Admin Panel
    ##  Done by		:		Narendra Singh
    ##	Page name	:		sendmsgtoath.php
    ##	Create Date	:		19/07/2011
    ##  Description :		It is use to send the message to athlete.
    ##	Copyright   :       Synapse Communications Private Limited.
    ## *****************************************************************
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    include_once ("inc/config.inc.php");
    session_start();
    //for paging
    $func = new COMMONFUNC;
    $db = new DB;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - Review Game Stats</title>
		<META NAME="Keywords" CONTENT="My Account">
		<META NAME="Description" CONTENT="My Account">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script language="JavaScript" type="text/JavaScript">		    
		     function refreshParent() {
                window.opener.location.href = window.opener.location.href;
                if(window.opener.progressWindow) {
                    window.opener.progressWindow.close()
                }
                window.close();
            }            
            
            function validate() {
                var error_msg = "";
                var x = document.getElementsByName("category[]")
                var len = x.length;
                if(x) {
                    for(var i = 0; i < len; i++) {
                        if(x[i].value == "") {
                            alert(error_msg + "\n Please Enter values in All Fields ");
                            return false;
                        } else {
                            if(!isNumeric(x[i].value)) {
                                alert(error_msg + "\"Please Enter numeric values in All Fields! ");
                                return false;
                            }
                        }
                    }
                }
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            }
            
		</script>
	</head>
	<body>
	<?php include ('header.php');?>
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
							<h1 style="margin-bottom:5px;">Review Athlete's Game Stats</h1>
							<h3 style="margin-bottom:16px;color:#333;font-size:13px;">Please review these Game Stats carefully & make your changes, then Confirm or Reject these game stats.</h3>
							
							<div class="registerPage smaller">
								<?php
                                    if ($_POST['isSubmit'] == 'save') {
                                        $sel_query = "delete from " . TBL_ATHELETE_STAT . " where fldPrograme=" . $_REQUEST['programId'] . " and fldAtheleteId=" . $_REQUEST['athid'] . " and fldStatus=0";
                                        $delmsg = $db -> query($sel_query);
                                        for ($cataStatcount = 0; $cataStatcount < count($_POST['category']); $cataStatcount++) {
                                            
                                            //Check if Value is nothing
                                            $dataval = 0;
                                            $datavaltemp = $func -> input_fun($_POST['category'][$cataStatcount]);
                                            if ($datavaltemp != '') {
                                                $dataval = $datavaltemp;
                                             }
                                                
                                            $strDataArr = array(
                                                    'fldPrograme' => $_REQUEST['programId'],
                                                    'fldCategoryId' => $func -> input_fun($_POST['categoryId'][$cataStatcount]),
                                                    'fldValue' => $dataval,
                                                    'fldLabelname' => $func -> input_fun($_POST['labelname'][$cataStatcount]),
                                                    'fldGroup' => $func -> input_fun($_POST['groupname'][$cataStatcount]), 
                                                    'fldSortOrder' => $func -> input_fun($_POST['sortorder'][$cataStatcount]), 
                                                    'fldStatus' => $_POST['fldStatus'],
                                                    'fldCoachId' => $_SESSION['Coach_id'],
                                                    'fldSportid' => $_REQUEST['spid'],
                                                    'fldAtheleteId' => $_REQUEST['athid'],
                                                    'fldAddDate' => date("y-m-d")
                                            );
                                            $db -> insertRec(TBL_ATHELETE_STAT, $strDataArr);
                                        }

                                        if ($_POST['fldStatus'] == '1') {
                                            $msg = "You have successfully Confirmed these Game Stats";
                                        } else {
                                            $msg = "You have Rejected these Game Stats, you may review / modify them at anytime.";
                                        }                                        
                                        
                                    }
								?>
								<?php
if($msg)
{?>
<div class="thankyoumessage"><?php echo $msg; ?></div>
<p><label>&nbsp;</label><span><button type=submit onclick="window.location.href='myaccount.php'" class="normalbtn">Close Window</button></span> </p>
<?php
}
else
{
								?>
								<form action="" method="post" onsubmit="return validate()">
									<?php
                            $selquery = " Select * from ".TBL_ATHELETE_STAT. " where (fldPrograme ='".$_REQUEST['programId']."')
                            and (fldAtheleteId='".$_REQUEST['athid']."') and (fldCoachId='".$_SESSION['Coach_id']."') and  (fldStatus=0) ORDER BY fldSortOrder ASC";
                            $db->query($selquery);
                            $db->next_record();
                            for($i=0;$i<$db->num_rows();$i++)
                            {
                            $fldCategoryId=$db->f('fldCategoryId');
                            $fldLabelname=$db->f('fldLabelname');
                            $fldId=$db->f('fldValue');
                            $fldStatus=$db->f('fldStatus');
                            $fldGroup=$db->f('fldGroup');
                            $fldSortOrder=$db->f('fldSortOrder');
									?>
									<p>
										<label><?php  echo $fldLabelname;?>:</label>
										<span>
											<input type="text" name="category[]"  value="<?php  echo $fldId;?>"/>
											<input type="hidden" name="categoryId[]" value="<?php  echo $fldCategoryId;?>">
											<input type="hidden" name="labelname[]" value="<?php  echo $fldLabelname;?>">
											<input type="hidden" name="groupname[]" value="<?php  echo $fldGroup;?>">
                                            <input type="hidden" name="sortorder[]" value="<?php  echo $fldSortOrder;?>">
										</span>
									</p>
									<?php
                                        $db -> next_record();
                                        }
									?>
									<p>
										<label>Action: </label>
										<span>
											<select name="fldStatus" style="width:260px;">
												<option value="1">Confirm (approve these stats)</option>
												<option value="0">Reject (you may approve these later)</option>
											</select></span><font color="#0000ff">*</font>
									</p>
									<p style="padding-top:20px;">
										<label>&nbsp;</label>
										<span>
											<input type="hidden" name="isSubmit" value="save">
											<button type="submit" class="normalbtn">
												Submit Form
											</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<button TYPE="BUTTON" ONCLICK="history.go(-1)" class="normalbtn"></span>
												Close Window
											</button> </span>
									</p>
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
	</body>
</html>