<?php    include_once ("inc/common_functions.php");    //for common function    include_once ("inc/page.inc.php");    include_once 'Video-Flv-Video-Converter.php';    session_start();    if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "") or $_SESSION['mode'] != "athlete") {        header("Location:login.php");    }    $func = new COMMONFUNC;    $db = new DB;    $flag = 0;    define("MAX_SIZE", "50000");    function getExtension($str) {        $i = strrpos($str, ".");        if (!$i) {            return "";        }        $l = strlen($str) - $i;        $ext = substr($str, $i + 1, $l);        return $ext;    }    if ($_POST['isSubmit'] == 'save') {        //Edit the user info        $fldTitle = $func -> input_fun($_POST['fldTitle']);        $fldStatus = $func -> input_fun($_POST['fldStatus']);        $whereClause = "fldTitle='" . $func -> input_fun($_POST['fldTitle']) . "'";        if ($db -> MatchingRec(TBL_ATHLETE_VIDEO, $whereClause) > 0) {#user Username already exists            $error_msg = 'This Game Tape already exists, please choose a different Title';            $flag++;        }        $image = $_FILES['fldVideo']['name'];        if ($image) {            $filename = stripslashes($_FILES['fldVideo']['name']);            $extension = getExtension($filename);            $extension = strtolower($extension);            if (($extension != "mov") && ($extension != "flv") && ($extension != "avi") && ($extension != "mp4") && ($extension != "wmv") && ($extension != "mpeg") && ($extension != "mpg")) {                $error_msg = 'Unknown Video Extension: only .mov .flv .avi .mp4 .wmv .mpeg .mpg are supported';                $flag++;            } else {                $size = filesize($_FILES['fldVideo']['tmp_name']);                if ($size > MAX_SIZE * 1024) {                    $error_msg = 'This Game Tape exceeds the 50MB Size Limit, please upload a smaller version.';                    $flag++;                }            }        }        if ($flag == 0) {            //Insert data            ///////////            $newname = "video/" . $video_name;            $flvobj = new flv();            $flvobj -> FFLV_PATH = '/usr/bin/';            $flvobj -> APP_ROOT = 'video/';            $flvobj -> output_file = 'video/';            $flvobj -> newname = time();            $video = $flvobj -> convert_video($_FILES['fldVideo']);                        //Append AthleteID to beginning of filename            $query_Athlete = " Select * from " . TBL_ATHELETE_REGISTER . " where fldUsername ='" . $_SESSION['FRONTEND_USER'] . "'";            $db1 -> query($query_Athlete);            $db1 -> next_record();            $video = $db1 -> f('fldId') . '-' . $video;                        $strDataArr = array('fldTitle' => $func -> input_fun($_POST['fldTitle']), 'fldVideo' => $video, 'fldAddDate' => date("y-m-d"), 'fldStatus' => $func -> input_fun($_POST['fldStatus']), 'fldAthleteId' => $db1 -> f('fldId'));            $db -> insertRec(TBL_ATHLETE_VIDEO, $strDataArr);            #redirect to listing page on successfull updation            header("Location:Video-List.php?msg=Game Tape successfully added.");        }        //this section is use to filup the value after erro message.        if ($error_msg != "") {            $fldTitle = $_REQUEST['fldTitle'];            $fldThirdParty = $_REQUEST['fldThirdParty'];            $fldStatus = $_REQUEST['fldStatus'];        }    } //END if submit?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">	<head>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>College Prospect Network</title>		<link href="css/style.css" rel="stylesheet" type="text/css" />		<script language="Javascript" src="javascript/functions.js"></script>		<script language="JavaScript" type="text/JavaScript">            function validate() {                var error_msg = "";                //var blnResult = true;                if(trimString(document.frmBanner.fldTitle.value) == "") {                    error_msg += "Please enter Title. \n";                } else {                    if(hasSpecialCharaters(document.frmBanner.fldTitle.value)) {                        error_msg += "Please enter a valid Title. \n";                    }                }                if(trimString(document.frmBanner.fldVideo.value) == "") {                    error_msg += "Please select a Video File ! \n";                }                if(error_msg != '') {                    alert(error_msg);                    return false;                } else {                    return true;                }            }		</script>	</head>	<body>		<?php        include ('header.php');		?>		<!--header link starts from here -->		<!--Header ends from here -->		<!--middle panel starts from here -->		<!--content panel starts from here -->		<div class="container">			<div class="innerWraper">				<div class="middle-bg">					<div class="cantener">						<div class="register-main">							<div class="registerPage">								<form name="frmBanner" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">									<h1>Add New Game Tape</h1>																		<div style="margin-bottom:20px;">									    <b>Notice:</b><br/>In accordance with NCAA regulations, the video you upload may only be from a high school game. No videos from AAU, Select or Traveling team games are allowed. Posting one of these videos may result in the removal of your profile from the website.									</div>									    									<?php                                if($_REQUEST['msg'])                                 {									?>									<font class="thankyoumessage"><?php  echo $_REQUEST['msg'];?></font>									<?php   }?>																											<?php                                    if($error_msg )                                    {									?>									<font class="errormessage"><?php  echo $error_msg;?></font>									<?php   }?>																											<p>										<label>Title:</label>										<span>											<input type="text" name="fldTitle" value="<?php if(isset($_POST['fldTitle'])) echo $_POST['fldTitle']; ?>" />										</span>									</p>									<p style="margin-top:10px;margin-bottom:0px;">										<label>Video File:</label>										<span>											<input type="file" name="fldVideo" style=" background: url("images/inputBg2.jpg") no-repeat scroll left top transparent;											border: medium none;											color: #646464;											display: inline-block;											font-size: 13px;											height: 32px;											margin: 0 0 5px;											padding: 0 2px 0 6px;											width: 270px;" />																			</span>									</p>									<p style="padding-top:0;margin-top:0;">									    <label>&nbsp;</label>									    <span style="color:#444;"><font style="color:#777;">Supported video types:</font>&nbsp; .mov .flv .avi .mp4 .wmv .mpeg .mpg</span>									    									</p>									<p>										<label>Show on Profile:</label>										<span>											<select name="fldStatus" id="fldStatus">																								<option value="1">Yes</option>												<option value="0">No</option>											</select> </span>									</p>									<p style="padding-top:30px;">										<label>&nbsp;</label>										<span>											<input type="hidden" name="isSubmit" value="save">											<input type="submit" name="submit" value="Save"/>											<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)" style="margin-left:40px;">										</span>									</p>								</form>							</div>						</div>					</div>				</div>			</div>		</div>		<?php            include ('footer.php');		?>	</body></html>