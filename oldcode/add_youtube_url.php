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
	if($fldAthleteid > 0)
	{
		$query = " Select * from " . TBL_ATHELETE_REGISTER . " where fldId = '$fldAthleteid'";
		$db -> query($query);
		$db -> next_record();
		
		//$fldAthleteid = $db -> f('fldId');
		$fldYoutubelink = $db -> f('fldYoutubelink');
		$fldYoutubeModifiedDate = $db -> f('fldYoutubeModifiedDate');
		$youID = $func ->parse_yturl($fldYoutubelink) ;
	}
	
	 if ($_POST['isSubmit'] == 'save') {
				$nowToday = date('Y-m-d H:i:s');
			$where = "fldId = '$fldAthleteid'";
			$New_youID = $func ->parse_yturl($func -> input_fun($_POST['fldYoutubelink'])) ;
			if(trim($New_youID) == trim($youID))
			{
			
				$strDataArr = array('fldYoutubelink' => $func -> input_fun($_POST['fldYoutubelink']), 'fldYoutubeModifiedDate' => $nowToday);
			}
			else
			{
			
				$strDataArr = array('fldYoutubelink' => $func -> input_fun($_POST['fldYoutubelink']), 'fldYoutubeModifiedDate' => $fldYoutubeModifiedDate);
			}
			
			$db -> updateRec(TBL_ATHELETE_REGISTER, $strDataArr, $where);
			$error_msg = '<div class="thankyoumessage" style="margin-right:29px;">YouTube Link updated successfully.<a href="#" onclick="javascript:self.close();" class="normalbtn" style="float:right; text-decoration:none;">Close</a></div>';
		}
		
		/* if (count($error_msg)==0)
                				{
                				   
                				   echo '';
                				   echo '';							  
                				}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Messaging</title>
		<META NAME="Keywords" CONTENT="My Account">
		<META NAME="Description" CONTENT="My Account">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript">
		function validat_url(youLink)
		{
			var url = youLink.value;
			var alertsuccess = "";
			var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
			if(url.match(p))
			{
				alertsuccess = RegExp.$1 
			}
			else
			{
				alertsuccess = false;
			}
			if(alertsuccess == false)
			{
				alert("Please enter valid YouTube URL.");
				//youLink.value = "";
				return false;
			}
		}
		</script>
		
	</head>
	<body style="background:none;">
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div>
						<div>
							<h1>YouTube Url</h1>
							<div class="registerPage" >
							<?=$error_msg?>
							<form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="validat_url(this.fldYoutubelink);">
									<p>
										<label>YouTube URL:</label>
										<span>
											<input type="text" name="fldYoutubelink" value="<?= $fldYoutubelink ?>" onchange="validat_url(this)"/>
										</span>
									</p>									
									<p>
										<label>&nbsp;</label>
										<span>
											<input type="hidden" name="youID" value="<?=$youID;?>">
											<input type="hidden" name="isSubmit" value="save">
											<input type="submit" value="Update"/>
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
