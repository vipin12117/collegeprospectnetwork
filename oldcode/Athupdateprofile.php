<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    session_start();
    if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {
        header("Location:index.php");
    }
    //for paging
    $func = new COMMONFUNC;
    $db = new DB;
    $flag = 0;
    $error_msg = '';
    
    $fldUsername = $_SESSION['FRONTEND_USER'];
    $query = " Select * from " . TBL_ATHELETE_REGISTER . " where fldUsername = '$fldUsername' ";
    $db -> query($query);
    $db -> next_record();
    
    
    $Status = $db -> f('fldStatus');
    
    $image_name = $db -> f('fldImage');
    $fldAthleteid = $db -> f('fldId');
    $fldFirstname = $func -> output_fun($db -> f('fldFirstname'));
    $fldLastname = $func -> output_fun($db -> f('fldLastname'));
    $fldClass = $func -> output_fun($db -> f('fldClass'));
    $fldHeight = $func -> output_fun($db -> f('fldHeight'));
    $fldWeight = $func -> output_fun($db -> f('fldWeight'));
    $fldDescription = $func -> output_fun($db -> f('fldDescription'));
    $fldDescription = str_replace("<br>", "\n", $fldDescription); 
    $fldEmail = $func -> output_fun($db -> f('fldEmail'));
    $fldUsername = $func -> output_fun($db -> f('fldUsername'));
    $fldSchool = $func -> output_fun($db -> f('fldSchool'));
    $fldSport = $func -> output_fun($db -> f('fldSport'));
    $fldJerseyNumber = $func -> output_fun($db -> f('fldJerseyNumber'));
    $fldPrimaryPosition = $func -> output_fun($db -> f('fldPrimaryPosition'));
    $fldSecondaryPosition = $func -> output_fun($db -> f('fldSecondaryPosition'));
    $fldVertical = $func -> output_fun($db -> f('fldVertical'));
    $fld40_yardDash = $func -> output_fun($db -> f('fld40_yardDash'));
    $fldShuttleRun = $func -> output_fun($db -> f('fldShuttleRun'));
    $fldBenchPressMax = $func -> output_fun($db -> f('fldBenchPressMax'));
    $fldSquatMax = $func -> output_fun($db -> f('fldSquatMax'));
    $fldGPA = $func -> output_fun($db -> f('fldGPA'));
    $fldSATScore = $func -> output_fun($db -> f('fldSATScore'));
    $fldACTScore = $func -> output_fun($db -> f('fldACTScore'));
    $fldClassRank = $func -> output_fun($db -> f('fldClassRank'));
    $fldClearinghouseEligible = $func -> output_fun($db -> f('fldClearinghouseEligible'));
    $fldIntendedMajor = $func -> output_fun($db -> f('fldIntendedMajor'));
    $fldAdminAthleticStat = $func -> output_fun($db -> f('fldAdminAthleticStat'));
  //  $fldNoteID = $db -> f('fldNoteID');
	$fldYoutubelink = $db -> f('fldYoutubelink');
	$fldYoutubeModifiedDate = $db -> f('fldYoutubeModifiedDate');
	  
    //Check Sport - Display Positions for sport
    $Sportstable = "tbl_position_football";      
    if ($fldSport == 10) {
        //Football
        $Sportstable = "tbl_position_football";  
    } else if ($fldSport == 11) {
        //Basketball - Mens
        $Sportstable = "tbl_position_basketball";  
    } else if ($fldSport == 12) {
        //Basketball - Womens
        $Sportstable = "tbl_position_basketball";  
    }
    
    if ($_POST['isSubmit'] == 'save') {
        //Get Image
        function getExtension($str) {
            $i = strrpos($str, ".");
            if (!$i) {
                return "";
            }
            $l = strlen($str) - $i;
            $ext = substr($str, $i + 1, $l);
            return $ext;
        }
        $image = $_FILES['fldImage']['name'];
        if ($image) {
            $filename = stripslashes($_FILES['fldImage']['name']);
            $extension = getExtension($filename);
            $extension = strtolower($extension);
            //bmp
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "bmp")) {
                $error_msg = 'Please Use jpg , png , jpeg , bmp , gif images!';
                $errors = 1;
            } else {
                $size = filesize($_FILES['fldImage']['tmp_name']);
                if ($size > MAX_SIZE * 1024 * 1024) {
                    $error_msg = "You have exceeded the size limit";
                    $errors = 1;
                }
                $image_name = "cpn_" . time() . '.' . $extension;
                $newname = "athimages/" . $image_name;
                $copied = copy($_FILES['fldImage']['tmp_name'], $newname);
            }
        }
        //Update data
        $fldUsername = $_SESSION['FRONTEND_USER'];
        $where = "fldUsername='" . $fldUsername . "'";
        if ($fldAdminAthleticStat != 1) {
		$nowToday = strtotime(date("now"));
            $strDataArr = array('fldEmail' => $func -> input_fun($_POST['fldEmail']), 'fldFirstname' => $func -> input_fun($_POST['fldFirstname']), 'fldLastname' => $func -> input_fun($_POST['fldLastname']), 'fldClass' => $func -> input_fun($_POST['fldClass']), 'fldHeight' => $func -> input_fun($_POST['fldHeight']), 'fldWeight' => $func -> input_fun($_POST['fldWeight']), 'fldDescription' => $func -> input_fun($_POST['fldDescription']), 'fldPrimaryPosition' => $func -> input_fun($_POST['fldPrimaryPosition']), 'fldSecondaryPosition' => $func -> input_fun($_POST['fldSecondaryPosition']), 'fldVertical' => $func -> input_fun($_POST['fldVertical']), 'fld40_yardDash' => $func -> input_fun($_POST['fld40_yardDash']), 'fldShuttleRun' => $func -> input_fun($_POST['fldShuttleRun']), 'fldBenchPressMax' => $func -> input_fun($_POST['fldBenchPressMax']), 'fldSquatMax' => $func -> input_fun($_POST['fldSquatMax']), 'fldGPA' => $func -> input_fun($_POST['fldGPA']), 'fldSATScore' => $func -> input_fun($_POST['fldSATScore']), 'fldACTScore' => $func -> input_fun($_POST['fldACTScore']), 'fldClassRank' => $func -> input_fun($_POST['fldClassRank']), 'fldClearinghouseEligible' => $func -> input_fun($fldClearinghouseEligible), 'fldJerseyNumber' => $func -> input_fun($_POST['fldJerseyNumber']), 'fldImage' => $image_name, 'fldIntendedMajor' => $func -> input_fun($_POST['fldIntendedMajor']));
        } else if ($fldAdminAthleticStat == 1) {
            $strDataArr = array('fldEmail' => $func -> input_fun($_POST['fldEmail']), 'fldFirstname' => $func -> input_fun($_POST['fldFirstname']), 'fldLastname' => $func -> input_fun($_POST['fldLastname']), 'fldClass' => $func -> input_fun($_POST['fldClass']), 'fldWeight' => $func -> input_fun($_POST['fldWeight']), 'fldDescription' => $func -> input_fun($_POST['fldDescription']), 'fldVertical' => $func -> input_fun($_POST['fldVertical']), 'fldBenchPressMax' => $func -> input_fun($_POST['fldBenchPressMax']));
        }
        if ($_POST['fldSchool'] != "others") {
            if ($fldSchool == 'others') {
                $String_Delete_Query = "delete from " . TBL_HS_AAU_TEAM_OTHER . " where  fldUserId =" . $fldAthleteid;
                $db -> query($String_Delete_Query);
            }
        }
        if ($_POST['fldSchool'] == "others") {
            $whereClause_team = "fldSchoolname='" . $func -> input_fun($_POST['txtfldName']) . "'";
            $flagss = 0;
            if ($db -> MatchingRec(TBL_HS_AAU_TEAM, $whereClause_team) > 0) {#user Username already exists
                $strDataArr_other = array('fldCoachName' => $func -> input_fun($_POST['txtfldAddress']), 'fldCoachPhone' => $func -> input_fun($_POST['txtfldContactInfo']), );
                $strDataArr_team = array('fldCoachPhone' => $func -> input_fun($_POST['txtfldAddress']), 'fldStatus' => "DEACTIVE");
                $where_team_other_Update = 'fldUserId =' . $fldAtheleteid;
                $db -> updateRec(TBL_HS_AAU_TEAM_OTHER, $strDataArr_other, $where_team_other_Update);
                $where_team_Update = "fldSchoolname='" . $func -> input_fun($_POST['txtfldName']) . "'";
                $db -> updateRec(TBL_HS_AAU_TEAM, $strDataArr, $where_team_Update);
                $flagss++;
            }
            if ($flagss == 0) {
                $strDataArr_other = array('fldName' => $func -> input_fun($_POST['txtfldName']), 'fldCoachName' => $func -> input_fun($_POST['txtfldAddress']), 'fldCoachPhone' => $func -> input_fun($_POST['txtfldContactInfo']), 'fldUserId' => $fldAtheleteid, );
                $strDataArr_team = array('fldSchoolname' => $func -> input_fun($_POST['txtfldName']), 'fldCoachPhone' => $func -> input_fun($_POST['txtfldContactInfo']), 'fldStatus' => "DEACTIVE");
                $db -> insertRec(TBL_HS_AAU_TEAM_OTHER, $strDataArr_other);
                $db -> insertRec(TBL_HS_AAU_TEAM, $strDataArr_team);
            }
        }
        $db -> updateRec(TBL_ATHELETE_REGISTER, $strDataArr, $where);
        #redirect to listing page on successfull updation
        header("Location: myaccount.php?page=" . $_REQUEST['page'] . "&msg=Profile successfully updated.");
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CPN - Update Profile</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script language="JavaScript" type="text/JavaScript">
            function validate() {
                var error_msg = "";
                if(trimString(document.frmAthReg.fldUsername.value) == "") {
                    error_msg += "Please Enter UserName! \n";
                } else {
                    if(hasSpecialCharaters(document.frmAthReg.fldUsername.value)) {
                        error_msg += "Enter valid  UserName! \n";
                    }
                }
                if(trimString(document.frmAthReg.fldEmail.value) == "") {
                    error_msg += "Please Enter Email. \n";
                } else {
                    if(!isValid(document.frmAthReg.fldEmail.value)) {
                        error_msg += "Enter Valid Email. \n";
                    }
                }
                if(trimString(document.frmAthReg.fldFirstname.value) == "") {
                    error_msg += "Please Enter First Name. \n";
                } else {
                    if(hasSpecialCharaters(document.frmAthReg.fldFirstname.value)) {
                        error_msg += "Enter valid  First Name. \n";
                    }
                }
                if(trimString(document.frmAthReg.fldLastname.value) == "") {
                    error_msg += "Please Enter Last Name. \n";
                } else {
                    if(hasSpecialCharaters(document.frmAthReg.fldLastname.value)) {
                        error_msg += "Enter valid  Last Name. \n";
                    }
                }
                if(trimString(document.frmAthReg.fldHeight.value) == "") {
                    error_msg += "Please Select Height. \n";
                } else {
                    if(hasSpecialCharaters(document.frmAthReg.fldHeight.value)) {
                        error_msg += "Please Select Height. \n";
                    }
                }
                if(trimString(document.frmAthReg.fldWeight.value) == "") {
                    error_msg += "Please Select weight. \n";
                } else {
                    if(hasSpecialCharaters(document.frmAthReg.fldWeight.value)) {
                        error_msg += "Please Select Weight. \n";
                    }
                }
                if(trimString(document.frmAthReg.fldSchool.value) == "select") {
                    error_msg += "Please Select School. \n";
                } else {
                    if(hasSpecialCharaters(document.frmAthReg.fldSchool.value)) {
                        error_msg += "Please Select School. \n";
                    }
                }
                if(trimString(document.frmAthReg.fldSport.value) == "") {
                    error_msg += "Please Select Sport. \n";
                } else {
                    if(hasSpecialCharaters(document.frmAthReg.fldSport.value)) {
                        error_msg += "Please Select Sport. \n";
                    }
                }              
                if(hasSpecialChars(document.frmAthReg.fldDescription.value)) {
                    error_msg += "Your Bio has special characters.  Please remove: ^, {, }, <, > \n";
                }        
                
                
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            }

            function getSportID(str) {
                if(str == "others") {
                    document.getElementById('txtschoolothers').style.display = "";
                }
                if(str != "others") {
                    document.getElementById('txtschoolothers').style.display = "none";
                }
            }

            function getCoachID(str) {
                var schoolid = document.getElementById("schoolid").value;
                if(str == "") {
                    document.getElementById("txtHintt").innerHTML = "";
                    return;
                }
                if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHintt").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "getcoach.php?qs=" + str + "&schoolid=" + schoolid, true);
                xmlhttp.send();
            }
		</script>
	</head>
	<body>
		<!--header link starts from here -->
		<?php
            include ('header.php');
		?>
		<!--Header ends from here -->
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
							<h1>Edit Athlete Profile</h1>
							<?php
if ($error_msg != '') {
							?>
							<div class='thankyoumessage'>
								<?php  echo $error_msg;?>
							</div>
							<?
                                }
							?>
							<span class="msg"> <font color="#0000ff">&nbsp;*</font> Fields are Mandatory.</span>
							<div class="registerPage wideform">
								<form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
								    
								    <?php if ($Status == "ACTIVE")
                                    {
                                    ?>    
                                     <p>
                                        <label>&nbsp;</label>
                                        <span> <a href="Video-List.php" class="gametape">Manage Game Tape</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="window.open('add_youtube_url.php?fldAthleteid=<?php  echo $fldAthleteid;?>&usertype=athlete','winname','directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no,width=980px,height=380');" class="gametape">Manage YouTube Link</a> </span>
                                    
                                      
                                    </p>
                                    <?php   
                                    }
                                    ?>									
									
									<p>
										<label>User Name:</label>
										<span>
											<input type="text" name="fldUsername" value="<?= $fldUsername ?>"  readonly/>
										</span>
									</p>
									<p>
										<label>Email:</label>
										<span>
											<input type="text" name="fldEmail" value="<?= $fldEmail ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>First Name:</label>
										<span>
											<input type="text" name="fldFirstname" value="<?= $fldFirstname ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Last Name:</label>
										<span>
											<input type="text" name="fldLastname"  value="<?= $fldLastname ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<?php /*?><p>
										<label>Notes:</label>
										<span> <?php
                                           
                                            echo '<select name="fldNoteID"><option value="" >Select notes</option>';
                                           
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
									</p><?php */?>
									<p>
										<label>Profile Image:</label>
										<span style="width:250px;">
											<input type="file" name="fldImage"  value="<?=$fldImage?>" />
										</span>
									</p>
									<p>
										<label>&nbsp;</label>										
										<span style="color:#444;line-height:18px;">                                            
                                            <font style="color:#777;">*Supported Image Types:</font>&nbsp; .mov .flv .avi .mp4 .wmv .mpeg .mpg<br />
                                            <font style="color:#777;">*Recommended Width:</font>&nbsp; 140px
                                        </span>    								    
									</p>
									<p>
										<label>Class:</label>
										<span> <?php
                                            if ($fldAdminAthleticStat == 1) {
                                                echo '<select name="fldClass" disabled><option value="" >Select year</option>';
                                            } else {
                                                echo '<select name="fldClass"><option value="" >Select year</option>';
                                            }
                                            $classlist = $func -> selectTableOrder(TBL_CLASS, "fldId,fldClass", "fldId");
                                            for ($i = 0; $i < count($classlist); $i++) {
                                                if ($fldClass == $classlist[$i]['fldClass']) {
                                                    echo '<option value ="' . $classlist[$i]['fldClass'] . '" selected = "selected" >' . $classlist[$i]['fldClass'] . '</option>';
                                                } else {
                                                    echo '<option value ="' . $classlist[$i]['fldClass'] . '"  >' . $classlist[$i]['fldClass'] . '</option>';
                                                }
                                            }
                                            echo $strcombo = '</select>';
											?></span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Height:</label>
										<span> <?php
                                            if ($fldAdminAthleticStat == 1) {
                                                echo '<select name="fldHeight" disabled><option value="">Select Height</option>';
                                            } else {
                                                echo '<select name="fldHeight"><option value="">Select Height</option>';
                                            }
                                            for ($i = 5; $i < 7; $i++) {
                                                for ($j = 0; $j < 12; $j++) {
                                                    if ($fldHeight == $i . "-" . $j) {
                                                        echo '<option value="' . $i . "-" . $j . '" selected = "selected"';
                                                        echo '>' . $i . "' " . $j . '"</option>';
                                                    } else {
                                                        echo '<option value="' . $i . "-" . $j . '"';
                                                        echo '>' . $i . "' " . $j . '"</option>';
                                                    }
                                                }
                                            }
                                            for ($kcount = 0; $kcount < 3; $kcount++) {
                                                if ($fldHeight == "7" . "-" . $kcount) {
                                                    echo '<option value="' . "7" . "-" . $kcount . '"';
                                                    echo '
selected = "selected" >' . "7" . "' " . $kcount . '"</option>';
                                                } else {
                                                    echo '<option value="' . "7" . "-" . $kcount . '"';
                                                    echo '>' . "7" . "' " . $kcount . '"</option>';
                                                }
                                            }
                                            echo '</select>';
											?></span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Weight:</label>
										<span> <?php
                                            if ($fldAdminAthleticStat == 1) {
                                                echo '<select name="fldWeight" disabled><option value="" >Select Weight</option>';
                                            } else {
                                                echo '<select name="fldWeight"><option value="">Select Weight</option>';
                                            }
                                            echo '<option value="under140">Under 140</option>';
                                            for ($i = 127; $i < 245; $i++) {
                                                $i = $i + 14;
                                                $j = $i + 14;
                                                if ($fldWeight == $i . "-" . $j) {
                                                    echo '<option value="' . $i . "-" . $j . '" selected = "selected"';
                                                    echo '>' . $i . "-" . $j . '</option>';
                                                } else {
                                                    echo '<option value="' . $i . "-" . $j . '"';
                                                    echo '>' . $i . "-" . $j . '</option>';
                                                }
                                            }
                                            echo '<option value="Over260">Over 260</option>';
                                            echo '</select>';
											?></span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Primary Position:</label>
										<span>
										<?
											 $classlist = $func -> selectTableOrder($Sportstable, "Position,SortOrder", "SortOrder");
										?>
										    <select name="fldPrimaryPosition" ><option value="">Please Select</option> 
    										    <?php        									    
                                                    $classlist = $func -> selectTableOrder($Sportstable, "Position,SortOrder", "SortOrder");
                                                    for ($i = 0; $i < count($classlist); $i++) {
                                                        if ($fldPrimaryPosition == $classlist[$i]['Position']) {
                                                            echo '<option value ="' . $classlist[$i]['Position'] . '" selected = "selected" >' . $classlist[$i]['Position'] . '</option>';
                                                        } else {
                                                            echo '<option value ="' . $classlist[$i]['Position'] . '"  >' . $classlist[$i]['Position'] . '</option>';
                                                        }
                                                    }                                         
                                                ?>
                                            </select>
                                        </span>							
									</p>
									<p>
										<label>Secondary Position:</label>									
										<span>
                                            <select name="fldSecondaryPosition" ><option value="">Please Select</option> 
                                                <?php                                               
                                                    $classlist = $func -> selectTableOrder($Sportstable, "Position,SortOrder", "SortOrder");
                                                    for ($i = 0; $i < count($classlist); $i++) {
                                                        if ($fldSecondaryPosition == $classlist[$i]['Position']) {
                                                            echo '<option value ="' . $classlist[$i]['Position'] . '" selected = "selected" >' . $classlist[$i]['Position'] . '</option>';
                                                        } else {
                                                            echo '<option value ="' . $classlist[$i]['Position'] . '"  >' . $classlist[$i]['Position'] . '</option>';
                                                        }
                                                    }                                         
                                                ?>
                                            </select>
                                        </span> 
									</p>
									<p>
										<label>Vertical:</label>
										<span>
											<input type="text" name="fldVertical" value="<?= $fldVertical ?>" />
										</span>
									</p>
									<p>
										<label>40-yard Dash:</label>
										<span>
											<input type="text" name="fld40_yardDash" value="<?= $fld40_yardDash ?>" <?php if ($fldAdminAthleticStat == 1) { ?>readonly<?php  }?> />
										</span>
									</p>
									<p>
										<label>Shuttle Run:</label>
										<span>
											<input type="text" name="fldShuttleRun" value="<?= $fldShuttleRun ?>" <?php if ($fldAdminAthleticStat == 1) { ?>readonly<?php  }?> />
										</span>
									</p>
									<p>
										<label>Bench Press Max:</label>
										<span>
											<input type="text" name="fldBenchPressMax" value="<?= $fldBenchPressMax ?>" <?php if ($fldAdminAthleticStat == 1) { ?>readonly<?php  }?> />
										</span>
									</p>
									<p>
										<label>Squat Max:</label>
										<span>
											<input type="text" name="fldSquatMax" value="<?= $fldSquatMax ?>" <?php if ($fldAdminAthleticStat == 1) { ?>readonly<?php  }?>/>
										</span>
									</p>
									<p>
										<label>GPA:</label>
										<span> <?php
                                            echo '<select name="fldGPA"><option value="">Please Select</option>';
											?><option value="under2.0" <?php if ($fldGPA == "under2.0") { ?>selected <?php  }?>>Under 2.0</option><?php?><option value="2.0-2.5" <?php if ($fldGPA == "2.0-2.5") { ?>selected <?php  }?>>2.0 - 2.5</option><?php?><option value="2.6-3.0" <?php if ($fldGPA == "2.6-3.0") { ?>selected <?php  }?>>2.6 - 3.0</option> <?php?><option value="3.1-3.5" <?php if ($fldGPA == "3.1-3.5") { ?>selected <?php  }?>>3.1 - 3.5</option><?php?><option value="3.6-4.0" <?php if ($fldGPA == "3.6-4.0") { ?>selected <?php  }?> >3.6 - 4.0</option><?php?><option value="Above4.0" <?php if ($fldGPA == "Above4.0") { ?>selected <?php  }?>>Above 4.0</option><?php
                                                echo '</select>';
											?></span>
									</p>
									<p>
										<label>SAT Score:</label>
										<span> <?php
                                            $lower = 601;
                                            $upper = 800;
                                            echo '<select name="fldSATScore"><option value="">Please Select</option>';
                                            if ($fldSATScore == '400' . "-" . "600") {
                                                echo '<option value="' . "400" . "-" . "600" . '" selected = "selected"';
                                                echo '>' . "400" . "-" . "600" . '</option>';
                                            } else {
                                                echo '<option value="' . "400" . "-" . "600" . '"';
                                                echo '>' . "400" . "-" . "600" . '</option>';
                                            }
                                            for ($i_count = 1; $i_count < 10; $i_count++) {
                                                if ($fldSATScore == $lower . "-" . $uppler) {
                                                    echo '<option value="' . $lower . "-" . $upper . '" selected = "selected"';
                                                    echo '>' . $lower . "-" . $upper . '</option>';
                                                } else {
                                                    echo '<option value="' . $lower . "-" . $upper . '"';
                                                    echo '>' . $lower . "-" . $upper . '</option>';
                                                }
                                                $lower = $lower + 200;
                                                $upper = $upper + 200;
                                            }
                                            echo '</select>';
											?></span>
									</p>
									<p>
										<label>ACT Score:</label>
										<span> <?php
                                            echo '<select name="fldACTScore"><option value="">Please Select</option>';
											?><option value="under10" <?php if ($fldACTScore == "under10") { ?>selected <?php  }?>>Under 10</option> <option value="10-15" <?php if ($fldACTScore == "10-15") { ?>selected <?php  }?>>10 - 15</option> <option value="16-20" <?php if ($fldACTScore == "16-20") { ?>selected <?php  }?>>16 - 20</option> <option value="21-25" <?php if ($fldACTScore == "21-25") { ?>selected <?php  }?>>21 - 25</option> <option value="26-30" <?php if ($fldACTScore == "26-30") { ?>selected <?php  }?>>26 - 30</option> <option value="Above30" <?php if ($fldACTScore == "Above30") { ?>selected <?php  }?>>Above 30</option> <?php
                                                echo '</select>';
											?></span>
									</p>
									<p>
										<label>Class Rank:</label>
										<span> <?php
                                            if ($fldAdminAthleticStat == 1) {
                                                echo '<select name="fldClassRank" disabled><option value="">Please Select</option>';
                                            } else {
                                                echo '<select name="fldClassRank"><option value="">Please Select</option>';
                                            }
											?><option value="Not in Top 50% of Class" <?php if ($fldClassRank == "Not in Top 50% of Class") { ?>selected <?php  }?>> Not in Top 50% of Class
											</option> <option value="Top 50% - Top 26%" <?php if ($fldClassRank == "Top 50% - Top 26%") { ?>selected <?php  }?>>Top 50% - Top 26%</option> <option value="Top 25% - Top 11%" <?php if ($fldClassRank == "Top 25% - Top 11%") { ?>selected <?php  }?>>Top 25% - Top 11%</option> <option value="Top 10% - Top 6%" <?php if ($fldClassRank == "Top 10% - Top 6%") { ?>selected <?php  }?>>Top 10% - Top 6%</option> <option value="Top 5% or better" <?php if ($fldClassRank == "Top 5% or better") { ?>selected <?php  }?>>Top 5% or better</option> <?php
                                                echo '</select>';
											?></span>
									</p>
									<p>
										<label>Intended Major:</label>
										<span> <?php
                                            echo '<select name="fldIntendedMajor"><option value="">Please Select</option>';
											?>
											<option value="Undecided / General Studies" <?php if ($fldIntendedMajor == "Undecided / General Studies") { ?>selected <?php  }?> >Undecided / General Studies</option> <option value="Agriculture" <?php if ($fldIntendedMajor == "Agriculture") { ?>selected <?php  }?>>Agriculture</option> <option value="Architecture" <?php if ($fldIntendedMajor == "Architecture") { ?>selected <?php  }?>>Architecture</option> <option value="Arts" <?php if ($fldIntendedMajor == "Arts") { ?>selected <?php  }?>>Arts</option> <option value="Business" <?php if ($fldIntendedMajor == "Business") { ?>selected <?php  }?>>Business</option> <option value="Communications" <?php if ($fldIntendedMajor == "Architecture") { ?>selected <?php  }?>>Communications</option> <option value="Computers / Information Technology" <?php if ($fldIntendedMajor == "Architecture") { ?>selected <?php  }?>>Computers / Information Technology</option> <option value="Education" <?php if ($fldIntendedMajor == "Education") { ?>selected <?php  }?>>Education</option> <option value="Engineering" <?php if ($fldIntendedMajor == "Engineering") { ?>selected <?php  }?>>Engineering</option> <option value="Liberal Arts" <?php if ($fldIntendedMajor == "Liberal Arts") { ?>selected <?php  }?>>Liberal Arts</option> <option value="Math" <?php if ($fldIntendedMajor == "Math") { ?>selected <?php  }?>>Math</option> <option value="Science" <?php if ($fldIntendedMajor == "Science") { ?>selected <?php  }?>>Science</option> <option value="Other" <?php if ($fldIntendedMajor == "Other") { ?>selected <?php  }?>>Other</option> <?php
                                                echo '</select>';
											?></span>
									</p>
									<p>
										<label>Clearinghouse Eligible:</label>
										<span> 
										    <?php
                                            if ($fldClearinghouseEligible == 'Approved') {
                                                echo '<select name="fldClearinghouseEligible" disabled><option value="Approve" >Approved</option>';
                                             } else if ($fldClearinghouseEligible == 'Pending') {
                                                echo '<select name="fldClearinghouseEligible" disabled><option value="Pending" >Pending</option>';
                                            } else {
                                                echo '<select name="fldClearinghouseEligible" disabled><option value="No" >No</option>';
                                            }
											?>
											<!--<option value="No" <?php if ($fldClearinghouseEligible == "No") { ?>selected <?php  }?>>No</option>--> 
											<!--<option value="Pending" <?php if ($fldClearinghouseEligible == "Pending") { ?>selected <?php  }?>>Yes</option>-->
										
											</select>
											</span>									
									</p>
									<p>
										<label>BIO:</label>
										<span><textarea name=fldDescription class="ta2"><?= $fldDescription ?></textarea></span>
									</p>
									<p>
										<label>HS/AAU Team:</label>
										<span> <?php
                                            echo $strcombo = '<select name="fldSchool" style="width:276px" onChange="getSportID(this.value);" disabled>';
                                            echo $strcombo = '<option value = 0>Select HS/AAU Team</option>';
                                            $categorylist = $func -> selectTableOrder(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldId");
                                            for ($i = 0; $i < count($categorylist); $i++) {
                                                if ($categorylist[$i]['fldId'] == $fldSchool) {
                                                    echo '<option value ="' . $categorylist[$i]['fldId'] . '" selected="selected" >' . $categorylist[$i]['fldSchoolname'] . '</option>';
                                                } else {
                                                    echo '<option value ="' . $categorylist[$i]['fldId'] . '">' . $categorylist[$i]['fldSchoolname'] . '</option>';
                                                }
                                            }
                                            if ($fldSchool == "others") {
                                                echo '<option value ="others" selected="selected">Others</option>';
                                            } else {
                                                echo '<option value ="others">Others</option>';
                                            }
                                            echo $strcombo = '</select>';
											?></span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p id="txtschoolothers" <?php if ($fldSchool != "others") { ?>style="display:none; margin-top:5px;"<?php  } else {?>style="margin-top:5px;"<?php  }?>>
										<?php
                                            $query_other_info = " Select * from " . TBL_HS_AAU_TEAM_OTHER . " where fldUserId = " . $fldAthleteid;
                                            $db1 -> query($query_other_info);
                                            $db1 -> next_record();
                                            $txtfldName = $db1 -> f('fldName');
                                            $txtfldAddress = $db1 -> f('fldCoachName');
                                            $txtfldContactInfo = $db1 -> f('fldCoachPhone');
										?>
										<label>Other Name :</label>
										<span>
											<input type="text" name="txtfldName" id="txtfldName" value="<?= $txtfldName ?>">
										</span>
										<label>Coach Name:</label>
										<span>
											<input type="text" name="txtfldAddress" id="txtfldAddress" value="<?= $txtfldAddress ?>" >
										</span>
										<label>Coach Phone:</label>
										<span>
											<input type="text" name="txtfldContactInfo" id="txtfldContactInfo" value="<?= $txtfldContactInfo ?>">
										</span>
									</p>
									<p>
										<label>Sport:</label><span>
											<input type="hidden" name="schoolid" id="schoolid" value="">
											<span > <?php
                                                $sportlist = $func -> selectTableOrder(TBL_SPORTS, "fldId,fldSportsname", "fldId");
												?><select name="fldSport" disabled ><option value = "select">Select Sport</option><?php
												for ($i = 0; $i < count($sportlist); $i++) {
												?>
												<option value ="<?php echo $sportlist[$i]['fldId'] ?>" <?php if (isset($fldSport) and ($fldSport == $sportlist[$i]['fldId'])) { ?>selected <?php  }?>><?php  echo $sportlist[$i]['fldSportsname'];?></option>
												<?php
                                                    }
												?>
												</select> </span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Jersey Number:</label>
										<span>
											<input type="text" name="fldJerseyNumber" value="<?= $fldJerseyNumber ?>" style="width:80px;"  />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>	
									<?php /*?><p>
										<label>YouTube URL:</label>
										<span>
											<input type="text" name="fldYoutubelink" value="<?= $fldYoutubelink ?>" />
										</span>
									</p>	<?php */?>								
									<p>
										<label>&nbsp;</label>
										<span>
											<input type="hidden" name="isSubmit" value="save">
											<input type="submit" value="Update"/>
											<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">
										</span>
									</p>
								</form>
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
