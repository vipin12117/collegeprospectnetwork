<?php

    ##******************************************************************
    ##  Project		:		Sport Social Networking - Admin Panel
    ##  Done by		:		Narendra Singh
    ##	Page name	:		sendmsgtoath.php
    ##	Create Date	:		19/07/2011
    ##  Description :		It is use to send the message to athlete.
    ##	Copyright   :       Synapse Communications Private Limited.
    ## *****************************************************************
    session_start();
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/config.inc.php");
    //for paging
	$func = new COMMONFUNC;
    $db = new DB;
	
	$fldAthleteid = isset($_REQUEST["fldAthleteid"])?$_REQUEST["fldAthleteid"]:0;
	$fldYoutubelink = "";
	$fldYoutubeModifiedDate = "";
	$youID = "";
	$error_msg = "";
	
	
	 if ($_POST['isSubmit'] == 'save') {
			$nowToday = date('Y-m-d H:i:s');
			$fldNoteID = $func -> input_fun($_POST['fldNoteID']);
			if($fldNoteID <=0 || $fldNoteID == "")
			{
				$error_msg = '<div class="thankyoumessage" style="margin-right:29px;">Please select Note.</div>';
			}
			else
			{
				$strDataArr = array('fldAthleteId'  => $fldAthleteid,'fldNoteId' => $fldNoteID, 'fldPostDate' => $nowToday);
				$db -> insertRec("tbl_athlete_notes", $strDataArr, "");
				
				$error_msg = '
				<script language="JavaScript" type="text/JavaScript">
				window.opener.location.reload(false);
				self.close();
				</script>
				';
			}
		}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Messaging</title>
		<META NAME="Keywords" CONTENT="My Account">
		<META NAME="Description" CONTENT="My Account">
		<link href="css/style.css" rel="stylesheet" type="text/css" />	
	</head>
	<body style="background:none;">
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div>
						<div>
							<h1>Add Note / Comment</h1>
							<div class="registerPage" >
							<?=$error_msg?>
							<form name="frmAthReg" action="" method="post">									
									<p>
										<label>Notes:</label>
										<span> <?php
                                           
                                            echo '<select name="fldNoteID"><option value="0" >Select notes</option>';
                                           
                                            $Noteslist = $func -> selectTableOrder("tbl_notes", "fldId,fldTitle,fldDescription", "fldId","where fldStatus=1");
                                            for ($i = 0; $i < count($Noteslist); $i++) {
                                                if ($fldNoteID == $Noteslist[$i]['fldId']) {
                                                    echo '<option value ="' . $Noteslist[$i]['fldId'] . '" selected = "selected" >' . $Noteslist[$i]['fldDescription'] . '</option>';
                                                } else {
                                                    echo '<option value ="' . $Noteslist[$i]['fldId'] . '"  >' . $Noteslist[$i]['fldDescription'] . '</option>';
                                                }
                                            }
                                            echo '</select>';
											?></span><font color="#0000ff">&nbsp;</font>
									</p>
									<p>
										<label>&nbsp;</label>
										<span>
											<input type="hidden" name="fldAthleteid" value="<?=$fldAthleteid;?>">
											<input type="hidden" name="isSubmit" value="save">
											<input type="submit" value="Save"/>
											<input type="button" onclick="javascript:self.close();" value="Close" />
										</span>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
