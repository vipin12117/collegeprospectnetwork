<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    include_once ("inc/config.inc.php");
    //for paging
    session_start();
    $func = new COMMONFUNC;
    $db = new DB;
    $lnb = "2";
    $error_msg = '';
    $flag = 0;
    $fldId = $_SESSION['FRONTEND_USER'];
    if ($_SESSION['mode'] == 'college' AND $fldId != "") {
        #get the records
        $query = " Select * from " . TBL_COLLEGE_COACH_REGISTER . " where fldUserName = '$fldId' ";
        $db -> query($query);
        $db -> next_record();
        if ($db -> num_rows() > 0) {
            $College_id = $db -> f('fldId');
            $db -> query($query);
            $db -> next_record();
            $fldUserName = $db -> f('fldUserName');
            $fldCollegename = $db -> f('fldCollegename');
            $fldCoachname = $db -> f('fldCoachname');
            $fldPosition = $db -> f('fldPosition');
            $fldNeedType = $db -> f('fldNeedType');
            $fldEmail = $db -> f('fldEmail');
            $fldFirstName = $db -> f('fldFirstName');
            $fldLastName = $db -> f('fldLastName');
            $fldAlternativeEmail = $db -> f('fldAlternativeEmail');
            $fldPhone = $db -> f('fldPhone');
            $fldAlternativePhone = $db -> f('fldAlternativePhone');
            $fldEnrollmentNumber = $db -> f('fldEnrollmentNumber');
            $fldDivison = $db -> f('fldDivison');
            if ($fldCollegename != 'other') {
                $college_address_before = $func -> selectTableOrder(TBL_COLLEGE, "fldId,fldName,fldAddress,fldCity,fldState,fldZipCode", "fldId", "where fldStatus =1 and fldId=" . $fldCollegename);
                $fldCity = $college_address_before[0]['fldCity'];
                $fldState = $college_address_before[0]['fldState'];
                $fldAddress = $college_address_before[0]['fldAddress'];
                $fldZipCode = $college_address_before[0]['fldZipCode'];
            }
        }
    } else {
        $fldUserName = "";
        $fldCollegename = "";
        $fldCity = "";
        $fldState = "";
        $fldPosition = "";
        $fldNeedType = "";
        $fldEmail = "";
        $fldFirstName = "";
        $fldLastName = "";
        $fldAlternativeEmail = "";
        $fldPhone = "";
        $fldAlternativePhone = "";
        $fldAddress = "";
        $fldEnrollmentNumber = "";
        $fldDivison = "";
    }
    if ($_POST['isSubmit'] == 'save') {
        if ($fldId != "") {
            //Edit the user info
            $fldUserName = $func -> input_fun($_POST['fldUserName']);
            $fldCollegename = $func -> input_fun($_POST['fldCollegename']);
            $fldCity = $func -> input_fun($_POST['fldCity']);
            $fldState = $func -> input_fun($_POST['fldState']);
            $fldSport = $func -> input_fun($_POST['fldSport']);
            $fldCoachname = $func -> input_fun($_POST['fldCoachname']);
            $fldPosition = $_POST['fldPosition'];
            $fldNeedType = $_POST['fldNeedType'];
            $fldEmail = $_POST['fldEmail'];
            $fldFirstName = $_POST['fldFirstName'];
            $fldLastName = $_POST['fldLastName'];
            $fldAlternativeEmail = $_POST['fldAlternativeEmail'];
            $fldPhone = $_POST['fldPhone'];
            $fldAlternativePhone = $_POST['fldAlternativePhone'];
            $fldAddress = $_POST['fldAddress'];
            $fldEnrollmentNumber = $_POST['fldEnrollmentNumber'];
            $fldDivison = $_POST['fldDivison'];
            if ($flag == 0) {
                //Update data
                $where = "fldUserName='" . $fldId . "'";
                $strDataArr = array('fldUserName' => $func -> input_fun($_POST['fldUserName']), 'fldCollegename' => $func -> input_fun($_POST['fldCollegename']), 'fldCity' => $func -> input_fun($_POST['fldCity']), 'fldState' => $func -> input_fun($_POST['fldState']), 'fldPosition' => $func -> input_fun($_POST['fldPosition']), 'fldNeedType' => $func -> input_fun($_POST['fldNeedType']), 'fldEmail' => $func -> input_fun($_POST['fldEmail']), 'fldFirstName' => $func -> input_fun($_POST['fldFirstName']), 'fldLastName' => $func -> input_fun($_POST['fldLastName']), 'fldAlternativeEmail' => $func -> input_fun($_POST['fldAlternativeEmail']), 'fldPhone' => $func -> input_fun($_POST['fldPhone']), 'fldAlternativePhone' => $func -> input_fun($_POST['fldAlternativePhone']), 'fldAddress' => $func -> input_fun($_POST['fldAddress']), 'fldEnrollmentNumber' => $func -> input_fun($_POST['fldEnrollmentNumber']), 'fldDivison' => $func -> input_fun($_POST['fldDivison']));
				//print_r($strDataArr);exit;
                $db -> updateRec(TBL_COLLEGE_COACH_REGISTER, $strDataArr, $where);
                #if ($_POST['fldCollegename'] != "other") {
                    #$Zipcode_lat_lon = $func -> getLatLong($func -> input_fun($_POST['fldZipCode']), MAPS_APIKEY);
                    #$where = " fldId =" . $fldCollegename;
                    #$strDataArr_college = array('fldAddress' => $func -> input_fun($_POST['fldAddress']), 'fldCity' => $func -> input_fun($_POST['fldCity']), 'fldState' => $func -> input_fun($_POST['fldState']), 'fldZipCode' => $func -> input_fun($_POST['fldZipCode']), 'fldDivison' => $func -> input_fun($_POST['fldDivison']), 'fldLatitude' => $Zipcode_lat_lon['Latitude'], 'fldLongitude' => $Zipcode_lat_lon['Longitude']);
                    #$db -> updateRec(TBL_COLLEGE, $strDataArr_college, $where);
                    #$String_Delete_Query = "delete from " . TBL_OTHER . " where  fldUserId ='" . $_SESSION['FRONTEND_USER'] . "'";
                    #$db -> query($String_Delete_Query);
                #}
                #if ($_POST['fldCollegename'] == "other") {
                    #$where_update_college = "fldName='" . $_POST['txtfldName'] . "'";
                    #$Zipcode_lat_lon = $func -> getLatLong($_POST['fldZipCode'], MAPS_APIKEY);
                    #$strDataArr_other_name = array('fldAddress' => $func -> input_fun($_POST['fldAddress']), 'fldCity' => $func -> input_fun($_POST['fldCity']), 'fldState' => $func -> input_fun($_POST['fldState']), 'fldZipCode' => $func -> input_fun($_POST['fldZipCode']), 'fldDivison' => $func -> input_fun($_POST['fldDivison']), 'fldLatitude' => $Zipcode_lat_lon['Latitude'], 'fldLongitude' => $Zipcode_lat_lon['Longitude']);
                    #$db3 -> updateRec(TBL_COLLEGE, $strDataArr_other_name, $where_update_college);
                #}
                #redirect to listing page on successfull updation
                header("Location: myaccount.php?msg=Profile successfully updated.");
            }
        }
        //this section is use to filup the value after erro message.
        if ($error_msg != "") {
            $fldUserName = $_REQUEST['fldUserName'];
            $fldCollegename = $_REQUEST['fldCollegename'];
            $fldCity = $_REQUEST['fldCity'];
            $fldState = $_REQUEST['fldState'];
            $fldPosition = $_REQUEST['fldPosition'];
            $fldNeedType = $_REQUEST['fldNeedType'];
            $fldEmail = $_REQUEST['fldEmail'];
            $fldFirstName = $_REQUEST['fldFirstName'];
            $fldLastName = $_REQUEST['fldLastName'];
            $fldAlternativeEmail = $_REQUEST['fldAlternativeEmail'];
            $fldPhone = $_REQUEST['fldPhone'];
            $fldAlternativePhone = $_REQUEST['fldAlternativePhone'];
            $fldAddress = $_REQUEST['fldAddress'];
            $fldEnrollmentNumber = $_REQUEST['fldEnrollmentNumber'];
            $fldDivison = $_REQUEST['fldDivison'];
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script language="JavaScript" type="text/JavaScript">
            function addfields() {
                var currentrow = parseInt(document.frmUsers.currentrow.value);
                document.getElementById('trs_' + currentrow).style.display = "";
                document.getElementById('trc_' + currentrow).style.display = "";
                document.getElementById('currentrow').value = currentrow + 1;
                if(document.getElementById('currentrow').value >= 1) {
                    document.getElementById('remfield').style.display = "";
                }
            }

            function removefields() {
                var currentrow = parseInt(document.frmUsers.currentrow.value);
                document.getElementById('trs_' + currentrow).style.display = "none";
                document.getElementById('trc_' + currentrow).style.display = "none";
                if(document.getElementById('currentrow').value == 1) {
                    document.getElementById('remfield').style.display = "none";
                    document.getElementById('currentrow').value = currentrow;
                } else {
                    document.getElementById('currentrow').value = currentrow - 1;
                }
            }

            function validate() {
                var error_msg = "";
                var blnResult = true;
                if(trimString(document.frmUsers.fldUserName.value) == "") {
                    error_msg += "Please Enter User name! \n";
                } else {
                    if(hasSpecialCharaters(document.frmUsers.fldUserName.value)) {
                        error_msg += "Enter Enter Valid Collegecode! \n";
                    }
                }
                if(trimString(document.frmUsers.fldCollegename.value) == "select") {
                    error_msg += "Please Select College Name! \n";
                }
                if(trimString(document.frmUsers.fldFirstName.value) == "") {
                    error_msg += "Please Enter First Name! \n";
                } else {
                    if(hasSpecialCharaters(document.frmUsers.fldFirstName.value)) {
                        error_msg += "Enter Valid First Name! \n";
                    }
                }
                if(trimString(document.frmUsers.fldLastName.value) == "") {
                    error_msg += "Please Enter Last Name! \n";
                } else {
                    if(hasSpecialCharaters(document.frmUsers.fldLastName.value)) {
                        error_msg += "Enter Valid Last Name! \n";
                    }
                }
                if(trimString(document.frmUsers.fldPhone.value) == "") {
                    error_msg += "Please Enter Your Phone. \n";
                } else {
                    if(!isPhone(document.frmUsers.fldPhone.value)) {
                        error_msg += "Enter valid  Phone. \n";
                    }
                }
                if((!isPhone(document.frmUsers.fldAlternativePhone.value)) && (trimString(document.frmUsers.fldAlternativePhone.value) != "")) {
                    error_msg += "Enter Valid Alternative Phone. \n";
                }
                if(trimString(document.frmUsers.fldEmail.value) == "") {
                    error_msg += "Please Enter Email. \n";
                } else {
                    if(!isValid(document.frmUsers.fldEmail.value)) {
                        error_msg += "Enter Valid Email. \n";
                    }
                }
                if((!isValid(document.frmUsers.fldAlternativeEmail.value)) && (trimString(document.frmUsers.fldAlternativeEmail.value) != "")) {
                    error_msg += "Enter Valid Alternative Email. \n";
                }
                if(trimString(document.frmUsers.fldCity.value) == "") {
                    error_msg += "Please Enter City! \n";
                } else {
                    if(hasSpecialCharaters(document.frmUsers.fldCity.value)) {
                        error_msg += "Enter valid City! \n";
                    }
                }
                if(trimString(document.frmUsers.fldState.value) == "") {
                    error_msg += "Please Enter State! \n";
                } else {
                    if(hasSpecialCharaters(document.frmUsers.fldState.value)) {
                        error_msg += "Enter valid State! \n";
                    }
                }
                if(trimString(document.frmUsers.fldZipCode.value) == "") {
                    error_msg += "Please Enter Zip Code! \n";
                } else {
                    if(hasSpecialCharaters(document.frmUsers.fldZipCode.value)) {
                        error_msg += "Enter valid Zip Code! \n";
                    }
                }
                if(trimString(document.frmUsers.fldNeedType.value) == "") {
                    error_msg += "Please Select the Sport! \n";
                }
                if(trimString(document.frmUsers.fldDivison.value) == "select") {
                    error_msg += "Please Select Divison Name! \n";
                }
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            }

            function Addcollege(str) {
                if(str == "") {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                }
                if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                        document.getElementById("schoolid").value = str;
                    }
                }
                if(str == "others") {
                    document.getElementById('txtschoolothers').style.display = "";
                } else if(str == "") {
                    document.getElementById('txtschoolothers').style.display = "none";
                    xmlhttp.open("GET", "addcollage.php?q=" + str, true);
                    xmlhttp.send();
                } else {
                    document.getElementById('txtschoolothers').style.display = "none";
                    xmlhttp.open("GET", "addcollage.php?q=" + str, true);
                    xmlhttp.send();
                }
            }
		</script>
	</head>
	<body>
		<!--header link starts from here -->
		<?php include('header.php');
		?>
		<!--Header ends from here -->
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
							<h1>Edit College Coach Profile</h1>
							<?php
if($_REQUEST['msg'])
{
							?>
							<div class="thankyoumessage">
								<?php echo $_REQUEST['msg']. "<br>";
								?>
							</div>
							<?php
}
							?>
							<span class="msg"><font color="#0000ff">&nbsp;*</font> Fields are Mandatory.</span>
							<div class="registerPage">
								<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
									<p>
										<label>User Name:</label>
										<span>
											<input type="text" name="fldUserName" id="fldUserName" value="<?=$fldUserName?>"  readonly >
										</span>
									</p>
									<p>
										<label>Position:</label>
										<span>
											<input type="text" name="fldPosition" id="fldPosition" value="<?=$fldPosition?>"
											>
										</span>
									</p>
									<p>
										<label>College Name:</label>
										<span><?php
echo $strcombo = '<select name="fldCollegename" onChange="Addcollege(this.value);" readonly>';
echo $strcombo = '<option value = "select">Select College</option>';
$collegelist=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName","fldId","where fldStatus =1");
for ($i=0;$i<count($collegelist);$i++)
{
if($fldCollegename == $collegelist[$i]['fldId'])
{
echo '<option value ="'.$collegelist[$i]['fldId'].'" '.'selected = "selected" >'.$collegelist[$i]['fldName'].'</option>';
}
else {
echo '<option value ="'.$collegelist[$i]['fldId'].'">'.$collegelist[$i]['fldName'].'</option>';
}
}
if($fldCollegename=="other")
{
echo '<option value ="other" '." selected ".'>'."other".'</option>';
}
else {
echo '<option value ="other">other</option>';
}
echo $strcombo = '</select>';
?>
</span><font color="#0000ff">&nbsp;*</font>
</p>
<p id="txtschoolothers" style="display:none; margin-top:5px;">
<label>&nbsp;</label>
<span>
<input type="hidden" name="fldOthers" id="txtschoolothers" value="<?=$fldOthers?>"></span>
</p>
<p id="txtHint" >
<?php
if($fldCollegename=="other")
{
$query_other_info =" Select * from ".TBL_OTHER. " where fldUserId = '".$_SESSION['FRONTEND_USER']."'";
$db1->query($query_other_info);
$db1->next_record();
$txtfldName=$db1->f('fldName');
											?>
											<label>College Name:</label> <span>
												<input type="text" name="txtfldName" id="txtfldName" value="<?=$txtfldName?>" readonly>
											</span> <?php
$college_address_other_info=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where fldStatus =0 and fldName='".$txtfldName."'");
//  print_r($college_address_info);
											?>
											<label>Address:</label> <span> 												<textarea rows=14 cols=69 name=fldAddress><?=$college_address_other_info[0]['fldAddress']?></textarea> </span>
											<br/>
											<br/>
											<br/>
											<br/>
											<br/>
											<br/>
											<label>City :</label> <span>
												<input type="text" name="fldCity" id="fldCity" value="<?=$college_address_other_info[0]['fldCity']?>" readonly>
												<font color="#0000ff">&nbsp;*</font></span>
											<br/>
											<br/>
											<label>State:</label> <span>
												<input type="text" name="fldState" id="fldState" value="<?=$college_address_other_info[0]['fldState']?>"
												>
												<font color="#0000ff">&nbsp;*</font></span> <label>Zip Code:</label> <span>
												<input type="text" name="fldZipCode" id="fldZipCode" value="<?=$college_address_other_info[0]['fldZipCode']?>"
												>
												<font color="#0000ff">&nbsp;*</font></span><?php
}
if($fldCollegename!="other")
{
											?>
											<label>Address:</label> <span> 												<textarea rows=14 cols=69 name=fldAddress readonly><?=$fldAddress?></textarea> </span><font color="#0000ff"></font> <label>City:</label> <span>
												<input type="text" name="fldCity" id="fldCity" value="<?=$fldCity?>" readonly>
											</span> <label>State:</label> <span>
												<input type="text" name="fldState" id="fldState" value="<?=$fldState?>" readonly
												>
											</span> <label>Zip Code:</label> <span>
												<input type="text" name="fldZipCode" id="fldZipCode" value="<?=$fldZipCode?>" readonly
												>
											</span>
									</p>
									<?php }
									?>
									<p>
										<label>First Name:</label>
										<span>
											<input type="text" name="fldFirstName" id="fldFirstName" value="<?=$fldFirstName?>"
											>
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Last Name:</label>
										<span>
											<input type="text" name="fldLastName" id="fldLastName" value="<?=$fldLastName?>"
											>
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Phone:</label>
										<span>
											<input type="text" name="fldPhone" id="fldPhone" value="<?=$fldPhone?>"
											>
										</span><font color="#0000ff">&nbsp;*</font>
										<p>
											<label>Alternate Phone:</label>
											<span>
												<input type="text" name="fldAlternativePhone" id="fldAlternativePhone" value="<?=$fldAlternativePhone?>"
												>
											</span>
										</p>
										<p>
											<label>Email Address:</label>
											<span>
												<input type="text" name="fldEmail" id="fldEmail" value="<?=$fldEmail?>" readonly
												>
											</span><font color="#0000ff">&nbsp;*</font>
										</p>
										<p>
											<label>Alternative Email:</label>
											<span>
												<input type="text" name="fldAlternativeEmail" id="fldAlternativeEmail" value="<?=$fldAlternativeEmail?>"
												>
											</span><font color="#0000ff"></font>
										</p>
										<p>
											<label>Divison:</label>
											<span>
												<select name="fldDivison">
													<option value="select">Select Divison</option>
													<option value="Division_I" <?php if($fldDivison=="Division_I"){ ?>selected <?php } ?>>Division I</option>
													<option value="Division_II" <?php if($fldDivison=="Division_II"){ ?>selected <?php } ?>>Division II</option>
													<option value="Division_III" <?php if($fldDivison=="Division_III"){ ?>selected <?php } ?>>Division III</option>
													<option value="NAIA" <?php if($fldDivison=="NAIA"){ ?>selected <?php } ?>>NAIA</option>
													<option value="JUCO" <?php if($fldDivison=="JUCO"){ ?>selected <?php } ?>>JUCO</option>
												</select> </span><font color="#0000ff">&nbsp;*</font>
										</p>
										<p>
											<label>Enrollment Number:</label>
											<span>
												<input type="text" name="fldEnrollmentNumber" id="fldEnrollmentNumber" value="<?=$fldEnrollmentNumber?>" >
											</span><font color="#0000ff">&nbsp;*</font>
										</p>
										<p>
											<label>Sport:</label>
											<span> <?php
echo $strcombo = '<select name="fldNeedType" >';
echo $strcombo = '<option value = "">Select Sport</option>';
$categorylist=$func->selectTableOrder(tbl_sports,"fldId,fldSportsname","fldId");
for ($i=0;$i<count($categorylist);$i++)
{
?>
<option value ="<?php echo $categorylist[$i]['fldId'];?>" <?php if($categorylist[$i]['fldId']==$fldNeedType){ ?>selected<?php } ?> ><?php
echo 	$categorylist[$i]['fldSportsname'];
												?>
												</option>
												<?php
}
echo $strcombo = '</select>';
												?></span>
										</p>
										<p>
											<label>&nbsp;</label>
											<span>
												<input type="hidden" name="userType" value="<?=($userType!="")?$userType:""?>">
												<input type="hidden" name="oldcode" value="<?=($oldcode)?$oldcode:$code?>">
												<input type="hidden" name="isSubmit" value="save">
												<?  /*	<input type="hidden" name="oldName" value="<?=$userOldName?>">
                                                     <input type="hidden" name="oldEmail" value="<?=$userOldEmail?>"> */
												?>
												<input type="submit" name="submit" value="Submit">
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
