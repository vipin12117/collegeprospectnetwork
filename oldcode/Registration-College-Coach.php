<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    include_once ("inc/config.inc.php");
    //for paging
    session_start();
    $func = new COMMONFUNC;
    $func2 = new COMMONFUNC;
    $db = new DB;
    //$flag=1;
    $lnb = "2";
    $error_msg = '';
    $flag = 0;
    $debugstep = 0;
    
    if ($_POST['isSubmit'] == 'save') {
        //Add College User
        
        //Set CollegeSchoolId - change if user inputs Custom School
        $CollegeSchoolId = $func -> input_fun($_POST['fldCollegename']);
        
        $fldCollegename = $func -> input_fun($_POST['fldCollegename']);
        $fldUserName = $func -> input_fun($_POST['fldUserName']);
        $fldEmail = $func -> input_fun($_POST['fldEmail']);
        $fldAlternativeEmail = $func -> input_fun($_POST['fldAlternativeEmail']);
        $fldPhone = $func -> input_fun($_POST['fldPhone']);
        $fldAlternativePhone = $func -> input_fun($_POST['fldAlternativePhone']);
        $fldAddress = $func -> input_fun($_POST['fldAddress']);
        $fldDivison = $func -> input_fun($_POST['fldDivison']);
        $fldNeedType = $func -> input_fun($_POST['fldNeedType']);
        $whereClause = "fldUserName='" . $fldUserName . "' ";
        if ($db -> MatchingRec(TBL_COLLEGE_COACH_REGISTER, $whereClause) > 0) {
            #user Username already exists
            $error_msg = 'This Username is already in use.';
            $flag++;
        }        
        $whereClause_fldCancelCount = "fldCollegename='" . $fldCollegename . "'  and fldCancelCount > 0";
        if ($db -> MatchingRec(TBL_COLLEGE_COACH_REGISTER, $whereClause_fldCancelCount) > 0) {
            #user Username already exists
            $error_msg = 'This College Can Not register for 2 months!';
            $flag++;
        }
        
        //Subscription Info
        // TODO: change this back after April 1
        $fldSubscribe = 1;  //2=trial, 1=active subscription, 0=inactive
            #$whereClause_subscribe_t = "fldCollegename='" . $fldCollegename . "'  and  fldSubscribe=2";
            #$whereClause_subscribe = "fldCollegename='" . $fldCollegename . "'  and  fldNeedType='$fldNeedType' and fldSubscribe=1";
            #if ($db -> MatchingRec(TBL_COLLEGE_COACH_REGISTER, $whereClause_subscribe_t) > 0) {
                //$fldSubscribe = 2;
            #} else if ($db -> MatchingRec(TBL_COLLEGE_COACH_REGISTER, $whereClause_subscribe) > 0) {
                #user Username already exists
                //$fldSubscribe = 1;
            #} else {
                //$fldSubscribe = 0;
            #}
            
        if ($flag == 0) {
            //Insert data
            $fldCancelCount = 0;
            $debugstep = 1;
            
            ##INSERT COLLEGE COACH###
            #######################################            
            $strDataArr = array('fldUserName' => $func -> input_fun($_POST['fldUserName']), 
            'fldPassword' => $func -> input_fun($_POST['fldPassword']),
            'fldCollegename' => $CollegeSchoolId,
            'fldAddress' => $func -> input_fun($_POST['fldAddress']),
            'fldCity' => $func -> input_fun($_POST['fldCity']),
            'fldState' => $func -> input_fun($_POST['fldState']),            
            'fldZipCode' => $func -> input_fun($_POST['fldZipCode']),
            'fldSport' => $func -> input_fun($_POST['fldNeedType']),
            'fldStatus' => "ACTIVE",            
            'fldPosition' => $func -> input_fun($_POST['fldPosition']),
            'fldNeedType' => $func -> input_fun($_POST['fldNeedType']),
            'fldEmail' => $func -> input_fun($_POST['fldEmail']),
            'fldAlternativeEmail' => $func -> input_fun($_POST['fldAlternativeEmail']),
            'fldFirstName' => $func -> input_fun($_POST['fldFirstName']),
            'fldLastName' => $func -> input_fun($_POST['fldLastName']),          
            'fldPhone' => $func -> input_fun($_POST['fldPhone']),
            'fldAlternativePhone' => $func -> input_fun($_POST['fldAlternativePhone']),            
            'fldDivison' => $func -> input_fun($_POST['fldDivison']),
            'fldQuestion' => $func -> input_fun($_POST['fldQuestion']),
            'fldAnswer' => $func -> input_fun($_POST['fldAnswer']),
            'fldSubscribe' => $fldSubscribe,
            'fldCancelCount' => $fldCancelCount,
            'fldAddDate' => date("y-m-d"));
          
          $debugstep = 2;
          
          //Insert Data - Get NewUserID
          $NewUserId = $db -> insertRec(TBL_COLLEGE_COACH_REGISTER, $strDataArr);
          
          $debugstep = 3;
          
          //If NewUser success, check for Custom College
            if ($NewUserId) {
                $debugstep = 4;
                $_SESSION['FRONTEND_USER'] = $_POST['fldUserName'];
                $_SESSION['mode'] = 'college';
                $_SESSION['fldSubscribe'] = $fldSubscribe;
                $_SESSION['College_Coach_id'] = $NewUserId;
                               
                if ($_POST['fldCollegename'] == "other") {
                    
                    ##########################################
                    ### Insert Custom College ###
                    ##########################################
                    
                        //Get Lattitude & Longitude
                         $Zipcode_lat_lon = $func -> getLatLong($_POST['fldZipCode'], MAPS_APIKEY);
                         
                        //Build Insert Data
                        $strDataArr_college = array('fldName' => $func -> input_fun($_POST['txtfldName']), 
                        'fldAddress' => $func -> input_fun($_POST['fldAddress']), 
                        'fldCity' => $func -> input_fun($_POST['fldCity']), 
                        'fldState' => $func -> input_fun($_POST['fldState']), 
                        'fldZipCode' => $func -> input_fun($_POST['fldZipCode']), 
                        'fldStatus' => 1, 
                        'fldDivison' => $func -> input_fun($_POST['fldDivison']),
                        'fldLatitude' => $Zipcode_lat_lon['Latitude'], 
                        'fldLongitude' => $Zipcode_lat_lon['Longitude'],  
                        'fldAdminApproved' => 0,                     
                        'fldAddByCollegeUsername' => $_POST['fldUserName'],
                        'fldAddDate' => date("y-m-d"));           
                         
                        //Insert & Set CollegeSchoolId
                        $NewCollegeSchoolId = $db -> insertRec(TBL_COLLEGE, $strDataArr_college);
                        $CollegeSchoolId = $NewCollegeSchoolId;
                                                                                        
                        //Insert Tester     
                        #$strDataArrw = array('fldName' => $CollegeSchoolId, 'fldAddress' => $NewUserId,);       
                        #$db -> insertRec(TBL_OTHER, $strDataArrw);
                           
                        //Update College User's fldCollegename                    
                        $strDataArr_collegereg_update = array('fldCollegename' => $CollegeSchoolId);
                        $where_collegereg_update = "fldId = " . $NewUserId;
                        $db -> updateRec(TBL_COLLEGE_COACH_REGISTER, $strDataArr_collegereg_update, $where_collegereg_update);
                                    
                    ################# Insert Custom College #################
                }     

                ################################################### 
                #Email Admin COLLEGE COACH Registration Notification 
                ################################################### 

                  if ($_POST['fldCollegename'] == "other") {
                      $subjectStre = "[CPN] - New College Coach Registration + New College";
                      $bodyStre = "New College Coach Registration + New College<br />"; 
                 }
                 else {
                      $subjectStre = "[CPN] - New College Coach Registration";
                      $bodyStre = "New College Coach Registration:<br />"; 
                 }                 
                        
                #all user types   
                $bodyStre .= "<br /><b>Status:</b> Active - 5 Day Trial Period";
                $bodyStre .= "<br /><b>College User Id:</b> " . $NewUserId;
                $bodyStre .= "<br /><b>Username:</b> " . $func -> input_fun($_POST['fldUserName']) ;
                $bodyStre .= "<br /><b>Password:</b> " . $func -> input_fun($_POST['fldPassword']) ;
                $bodyStre .= "<br /><b>Name:</b> " . $func -> input_fun($_POST['fldFirstName']) . " " . $func -> input_fun($_POST['fldLastName']) ;
                $bodyStre .= "<br /><b>Email:</b> " . $func -> input_fun($_POST['fldEmail']) ;     
                $bodyStre .= "<br /><b>Alt Email:</b> " . $func -> input_fun($_POST['fldAlternativeEmail']) ;           
                $bodyStre .= "<br />";
                $bodyStre .= "<br /><b>Phone:</b> " . $func -> input_fun($_POST['fldPhone']) ;
                $bodyStre .= "<br /><b>Alt Phone:</b> " . $func -> input_fun($_POST['fldAlternativePhone']) ;
                $bodyStre .= "<br /><b>State:</b> " . $func -> input_fun($_POST['fldState']) ;
                
                //College Name
                $queryHS =" Select * from ".TBL_COLLEGE. " where fldId =".$CollegeSchoolId;  
                $db1->query($queryHS);
                $db1->next_record();
                $fldSchoolname = $db1->f('fldName');
                $bodyStre .= "<br /><b>College:</b> " . $fldSchoolname;
                $bodyStre .= "<br />" . $func -> input_fun($_POST['fldAddress']);
                $bodyStre .= "<br />" . $func -> input_fun($_POST['fldCity']). ", ". $func -> input_fun($_POST['fldState']) . " " . $func -> input_fun($_POST['fldZipCode']);
                
                //Get Sport Name
                    $fldSport = $func -> input_fun($_POST['fldNeedType']) ;                                                
                    $sportquery = "SELECT fldSportsname  from " . TBL_SPORTS . "  WHERE fldId='$fldSport'";                                            
                    $db1->query($sportquery);                                                    
                    $db1->next_record();                                                                 
                    $sports_name = $func->output_fun($db1->f('fldSportsname'));
                $bodyStre .= "<br /><br /><b>Sport:</b> " . $sports_name;
                $bodyStre .= "<br /><b>Division:</b> " . $func -> input_fun($_POST['fldDivison']) ;
                $bodyStre .= "<br /><b>Job Position:</b> " . $func -> input_fun($_POST['fldPosition']) ;
                $bodyStre .= "<br /><br />" . $_SERVER['HTTP_USER_AGENT'];
                
                $func -> sendEmail(ADMIN_EMAIL, $subjectStre, $bodyStre, $fldEmail);
            
           
                
                #################END Notifcation Email#################
                
                
                $msg = "Thank you for your registration";
                header("Location:myaccount.php?msg=$msg");
            }
            else {
            	$error_msg = 'Error Occured during Registration, please try again.  Flag:' . $flag . ' DebugStep:' . $debugstep;
            }
            #redirect to listing page on successfull updation
        }
        //this section is use to filup the value after erro message.
        if ($error_msg != "") {
            $fldUserName = $_REQUEST['fldUserName'];
            $fldPassword = $_REQUEST['fldPassword'];
            $fldCPassword = $_REQUEST['fldCPassword'];
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
            $fldDivison = $_REQUEST['fldDivison'];
            $fldZipCode = $_REQUEST['fldZipCode'];
            $fldQuestion = $_REQUEST['fldQuestion'];
            $fldAnswer = $_REQUEST['fldAnswer'];
        }
    } //END if submit
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
        <script language="javascript" type="text/javascript">
        
            function validate() {
                var error_msg = "";
                var blnResult = true;
                if(trimString(document.frmUsers.fldUserName.value) == "") {
                    error_msg += "Please Enter User name! \n";
                } else {
                    if(hasSpecialCharaters(document.frmUsers.fldUserName.value)) {
                        error_msg += "Enter Enter Valid User Name! \n";
                    }
                }
                if(trimString(document.frmUsers.fldPassword.value) == "") {
                    error_msg += "Please Enter Password! \n";
                } else {
                    if(hasSpecialCharaters(document.frmUsers.fldPassword.value)) {
                        error_msg += "Please Enter Valid Password! \n";
                    }
                }
                if(document.frmUsers.fldPassword.value != document.frmUsers.fldCPassword.value) {
                    error_msg += "Your Confirm Password Does not Match. \n";
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
                
                //========================================//
                 //College Validator
                 //========================================//
                 if(trimString(document.frmUsers.fldCollegename.value) == "select") {
                    error_msg += "Please Select College Name! \n";
                }
                    
                    //other selected
                    if(trimString(document.frmUsers.fldCollegename.value) == "other") {      
                                                                  
                           //college name
                            if(trimString(document.frmUsers.txtfldName.value) == "") {
                                error_msg += "Please Enter College Name! \n";
                            } else {
                                if(hasSpecialCharaters(document.frmUsers.txtfldName.value)) {
                                    error_msg += "Enter Valid College Name! \n";
                                }
                           }     
                                                                    
                    }                  
                   //end: other
                   
                   
                    //college or other selected
                    if(trimString(document.frmUsers.fldCollegename.value) != "select") {
                        
                            //address
                            if(trimString(document.frmUsers.fldAddress.value) == "") {
                                error_msg += "Please Enter College Address! \n";
                            } else {
                                if(hasSpecialCharaters(document.frmUsers.fldAddress.value)) {
                                    error_msg += "Enter Valid College Address! \n";
                                }
                           }                           
                            //city
                            if(trimString(document.frmUsers.fldCity.value) == "") {
                                error_msg += "Please Enter College City! \n";
                            } else {
                                if(hasSpecialCharaters(document.frmUsers.fldCity.value)) {
                                    error_msg += "Enter Valid College City! \n";
                                }
                           }                           
                           //state
                           if(trimString(document.frmUsers.fldState.value) == "select") {
                                error_msg += "Please Select College State! \n";
                            }
                            
                            //zipcode
                            if(trimString(document.frmUsers.fldZipCode.value) == "") {
                                error_msg += "Please Enter College Zip Code! \n";
                            } else {
                                if(hasSpecialCharaters(document.frmUsers.fldZipCode.value)) {
                                    error_msg += "Enter Valid College Zip Code! \n";
                                }
                           }
                      
                    }
                    //end: college or other                                       
                
                //END College Validator
                //========================================//
                
                
                if(trimString(document.frmUsers.fldNeedType.value) == "") {
                    error_msg += "Please Select the Sport! \n";
                }
                
                if(trimString(document.frmUsers.fldDivison.value) == "select") {
                    error_msg += "Please Select Divison Name! \n";
                }
                if(trimString(document.frmUsers.fldPosition.value) == "") {
                    error_msg += "Please Enter Job Position! \n";
                }
                if(hasSpecialCharaters(document.frmUsers.fldPosition.value)) {
                    error_msg += "Please Enter Valid Job Position! \n";
                }
                if(trimString(document.frmUsers.fldQuestion.value) == "") {
                    error_msg += "Please Enter Security Question! \n";
                }
                if(hasSpecialCharaters(document.frmUsers.fldQuestion.value)) {
                    error_msg += "Please Enter Valid Security Question! \n";
                }
                if(trimString(document.frmUsers.fldAnswer.value) == "") {
                    error_msg += "Please Enter Security Answer! \n";
                }
                if(hasSpecialCharaters(document.frmUsers.fldAnswer.value)) {
                    error_msg += "Please Enter Valid Security Answer! \n";
                }
                if(!document.frmUsers.agree.checked) {
                    error_msg += "You must agree to the terms";
                }
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            }

       //jQuery AJAX Calls     
        $(document).ready(function(){
            
            $("#fldSchool").change(function(){
                var ddlval=$("#fldSchool").val();
                
                if(ddlval == "") {
                    $("#AjaxResponse").html('');   
                    return;
                }
                //alert('ya');
                
                if(ddlval == "others") {
                    $("#txtschoolothers").show();
                    //document.getElementById("txtschoolothers").style.display = "";
                } else if(ddlval == "") {
                    $("#txtschoolothers").hide();
                    //document.getElementById("txtschoolothers").style.display = "none";
                    $.ajax({
                      url: 'addcollage-new.php?q='+ddlval,
                      success: function(data) {
                       $("#AjaxResponse").html(data);       
                      }
                    });
                } else {
                    $("#txtschoolothers").hide();
                    //document.getElementById("txtschoolothers").style.display = "none";
                    $.ajax({
                      url: 'addcollage-new.php?q='+ddlval,
                      success: function(data) {
                       $("#AjaxResponse").html(data);       
                      }
                    });
                }               
   
            });//dropdown change
            
        }); //document.ready
        
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
							<h1>College Coach Registration</h1>
							<?php
                            if ($error_msg){
							?>
							<div class="thankyoumessage">
								<?php    echo $error_msg;?>
							</div>
							<?
                                }
							?>							
							<span class="msg"><font color="#0000ff">&nbsp;*</font> Fields are Mandatory.</span>
							<div class="registerPage">
								<form name="frmUsers" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
									<p>
										<label>User Name:</label>
										<span>
											<input type="text" name="fldUserName" id="fldUserName" value="<?=$fldUserName?>" >
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Password:</label>
										<span>
											<input type="password" name="fldPassword" id="fldPassword" value="<?=$fldPassword?>"
											>
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Confirm Password:</label>
										<span>
											<input type="password" name="fldCPassword" id="fldCPassword" value="<?=$fldCPassword?>"
											>
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<hr class="line" />
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
										<label>Email Address:</label>
										<span>
											<input type="text" name="fldEmail" id="fldEmail" value="<?=$fldEmail?>"
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
										<hr class="line" />
										
										<p>
                                        <label>College:</label>
                                        <span> <?php
                                            echo $strcombo = '<select name="fldCollegename" id="fldSchool">';
                                            echo $strcombo = '<option value="select" class="selectgrey">Select College</option>';   
                                              
                                            $statelist = $func2 -> selectTableOrdergroupby(TBL_COLLEGE, "fldState", "fldState", "WHERE fldStatus='1'");
                                            for ($x = 0; $x < count($statelist); $x++) {
                                                echo '<optgroup label="========' . $statelist[$x]['fldState'] . '========">';
                                                
                                                $whereclaus = "WHERE fldState = '" . $statelist[$x]['fldState'] . "' ";                                                
                                                $collegelist = $func -> selectTableOrder(TBL_COLLEGE, "fldId,fldName", "fldName", $whereclaus);
                                                
                                                for ($i = 0; $i < count($collegelist); $i++) {
                                                    echo '<option value ="' . $collegelist[$i]['fldId'] . '" >' . $collegelist[$i]['fldName'] . '</option>';
                                                }
                                                
                                                echo '<option value ="other" class="addcustom_normal">****Other (Add Your College) ****</option>';
                                                
                                                echo '</optgroup>';
                                            }
                                            
                                            echo '<option value ="other" class="addcustom">Not Listed? Add Your College</option>';
                                            echo $strcombo = '</select>';
                                            
                                            ?></span><font color="#0000ff">*</font>
                                    </p>                                    
					
										<p id="txtschoolothers" style="display:none; margin-top:5px;">
											<label>&nbsp;</label>
											<span>
												<input type="hidden" name="fldOthers" id="txtschoolothers" value="<?=$fldOthers?>">
											</span>
										</p>
										<p id="AjaxResponse" ></p>
										<p>
											<label>Sport:</label>
											<span> <?php
                                                echo $strcombo = '<select name="fldNeedType" >';
                                                echo $strcombo = '<option value = "" class="selectgrey">Select Sport</option>';
                                                $categorylist = $func -> selectTableOrder(tbl_sports, "fldId,fldSportsname", "fldId");
                                                for ($i = 0; $i < count($categorylist); $i++) {
                                                    ?>                                                    
                                                    <option value ="<?php echo $categorylist[$i]['fldId'];?>" <?php if($categorylist[$i]['fldId']==$fldNeedType){ ?>selected<?php } ?> ><?php echo $categorylist[$i]['fldSportsname']; ?>
                                                </option>
                                                    <?php
                                                    }
                                                echo $strcombo = '</select>';
												?></span><font color="#0000ff">*</font>
										</p>
										<p>
											<label>Sport Divison:</label>
											<span>
												<select name="fldDivison">
													<option value="select" class="selectgrey">Select Divison</option>
													<option value="Division_I" <?php if($fldDivison=="Division_I"){ ?>selected <?php }?>>Division I</option>
													<option value="Division_II" <?php if($fldDivison=="Division_II"){ ?>selected <?php }?>>Division II</option>
													<option value="Division_III" <?php if($fldDivison=="Division_III"){ ?>selected <?php }?>>Division III</option>
													<option value="NAIA" <?php if($fldDivison=="NAIA"){ ?>selected <?php }?>>NAIA</option>
													<option value="JUCO" <?php if($fldDivison=="JUCO"){ ?>selected <?php }?>>JUCO</option>
												</select> </span><font color="#0000ff">*</font>
										</p>
										<p>
											<label>Job Position:</label>
											<span>
												<input type="text" name="fldPosition" id="fldPosition" value="<?=$fldPosition?>"
												>
											</span><font color="#0000ff">&nbsp;*</font>
										</p>
										<hr class="line" />
										<p>
											<label>Enter your Security Question:</label>
											<span>
												<input type="text" name="fldQuestion" value="<?=$fldQuestion?>" />
											</span><font color="#0000ff">&nbsp;*</font>
										</p>
										<p>
											<label>Enter your Security Answer:</label>
											<span>
												<input type="text" name="fldAnswer"  value="<?=$fldAnswer?>" />
											</span><font color="#0000ff">&nbsp;*</font>
										</p>
										<p>
											<label>
												<input type="checkbox" name="agree" value="agree_terms" />
											</label>
											<span>I Accept Terms & Conditions. <?
                                                $pageURLTerms = "page.php?page_name=term_conditions";
                                                $detailsWindowTitle = "View Terms";
                                                echo '<a href="javascript:ShowDetailsLarge(\'' . $pageURLTerms . '\',\'' . $detailsWindowTitle . '\')">View Terms</a></td>';
												?></span>
										</p>
										<p>
											<label>&nbsp;</label>
											<span>
												<input type="hidden" name="userType" value="<?=($userType!="")?$userType:""?>">
												<input type="hidden" name="oldcode" value="<?=($oldcode)?$oldcode:$code?>">
												<input type="hidden" name="isSubmit" value="save">
												<input type="submit" name="submit" value="Register">
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
