<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    include_once ("inc/config.inc.php");
    //for paging
    $func = new COMMONFUNC;
    $func2 = new COMMONFUNC;
    $db = new DB;
    //$flag=1;
    
    if ($_POST['isSubmit'] == 'save') {
        $aname = $func -> input_fun($_POST['fldFirstname']);
        $anamel = $func -> input_fun($_POST['fldLastname']);
        $fldEmail = $func -> input_fun($_POST['fldEmail']);
        
        //Check if Emails Exists
        // $whereClause = "fldEmail='" . $fldEmail . "'";
         // if ($db -> MatchingRec(TBL_ATHELETE_REGISTER, $whereClause) > 0) {
            // $error_msg[] = 'This Email Address is already associated to another Athlete Account';        
         // }
        
        
        $fldUsername = $func -> input_fun($_POST['fldUsername']);
        
        //Set HighSchoolId - change if user inputs Custom School
        $HighSchoolId = $func -> input_fun($_POST['fldSchool']);
        
        //Check if Username Exists
        $whereClause = "fldUsername='" . $fldUsername . "'";
        if ($db -> MatchingRec(TBL_ATHELETE_REGISTER, $whereClause) > 0) {
            $error_msg[] = 'This Username is already in use.';
        }
        if ($_REQUEST['fldUsername'] == '') {
            $error_msg[] = " Please Enter User Name.";
        }
        if ($_REQUEST['fldEmail'] == '') {
            $error_msg[] = "Please Enter Email.";
        }
        if ($_REQUEST['fldFirstname'] == '') {
            $error_msg[] = "Please Enter First Name.";
        }
        if ($_REQUEST['fldLastname'] == '') {
            $error_msg[] = "Please Enter Last Name.";
        }
   
        if ($_REQUEST['fldSchool'] == '') {
            $error_msg[] = "Please Select School.";
        }
        if ($_REQUEST['fldPassword'] == '') {
            $error_msg[] = "Please Enter Password.";
        }
        if ($_POST['fldSport'] == 'select') {
            $error_msg[] = "Please Select Sport..";
            $sport_empty = " ";
        } else {
            $sport_empty = $_POST['fldSport'];
        }
        if ($_POST['fldSchool'] == 'others') {
            $Team_id = "others";
            #check Other School Fields
            if ($_REQUEST['txtfldName'] == '') {
            $error_msg[] = "Please Enter School Name";
            }
            if ($_REQUEST['txtfldAddress'] == '') {
            $error_msg[] = "Please Enter Coach's Name";
            }
            if ($_REQUEST['txtfldContactInfo'] == '') {
            $error_msg[] = "Please Enter Coach's Phone";
            }
            
        } else {
            $Team_id = $func -> input_fun($_POST['fldSchool']);
        }
        if ($_REQUEST['fldJerseyNumber'] == '') {
            $error_msg[] = "Please Select Jersey Number.";
        }
        $mysqlDateString = date('Y-m-d H:i:s', $phpdate);
        
        
        $strDataArr = array('fldUsername' => $func -> input_fun($_POST['fldUsername']), 
        'fldPassword' => $func -> input_fun($_POST['fldPassword']), 
        'fldEmail' => $func -> input_fun($_POST['fldEmail']), 
        'fldFirstname' => $func -> input_fun($_POST['fldFirstname']), 
        'fldLastname' => $func -> input_fun($_POST['fldLastname']), 
        'fldClass' => $func -> input_fun($_POST['fldClass']), 
        'fldHeight' => $func -> input_fun($_POST['fldHeight']), 
        'fldWeight' => $func -> input_fun($_POST['fldWeight']), 
        'fldSchool' => $Team_id, 
        'fldSport' => $sport_empty,         
        'fldStatus' => $func -> input_fun($_POST['fldStatus']), 
        'fldIntendedMajor' => $func -> input_fun($_POST['fldIntendedMajor']), 
        'fldOthers' => $func -> input_fun($_POST['fldOthers']), 
        'fldQuestion' => $func -> input_fun($_POST['fldQuestion']), 
        'fldAnswer' => $func -> input_fun($_POST['fldAnswer']), 
        'fldState' => $func -> input_fun($_POST['fldState']), 
        'fldJerseyNumber' => $func -> input_fun($_POST['fldJerseyNumber']), 
        'fldAddDate' => date("y-m-d"));
        
        //Continue If No Form Errors
        if (count($error_msg) == 0) {
            
            //Insert Data - Get NewUserID
            $res = $db -> insertRec(TBL_ATHELETE_REGISTER, $strDataArr);
            $NewUserId = $res;
            
      
           if ($_POST['fldSchool'] == "other") {
                    
                ##########################################
                ### Insert Custom College ###
                ##########################################
                
                    //Get Lattitude & Longitude
                     $Zipcode_lat_lon = $func -> getLatLong($_POST['fldZipcode'], MAPS_APIKEY);
                     
                    //Build Insert Data
                    $fldStatus = "ACTIVE";
                    $strDataArr_school = array('fldSchoolname' => $func -> input_fun($_POST['txtfldName']), 
                    'fldAddress' => $func -> input_fun($_POST['fldAddress']), 
                    'fldCity' => $func -> input_fun($_POST['fldCity']), 
                    'fldState' => $func -> input_fun($_POST['fldState']), 
                    'fldZipcode' => $func -> input_fun($_POST['fldZipcode']), 
                    'fldStatus' => $fldStatus,
                    'fldLatitude' => $Zipcode_lat_lon['Latitude'], 
                    'fldLongitude' => $Zipcode_lat_lon['Longitude'],  
                    'fldAdminApproved' => 0,                     
                    'fldAddByAthleteUsername' => $_POST['fldUsername'],
                    'fldAddDate' => date("y-m-d"));           
                     
                    //Insert & Set CollegeSchoolId
                    $NewSchoolId = $db -> insertRec(TBL_HS_AAU_TEAM, $strDataArr_school);
                    $HighSchoolId = $NewSchoolId;                                                                                       
                       
                    //Update  User's fldSchool column                    
                    $strDataArr_schoolreg_update = array('fldSchool' => $HighSchoolId);
                    $where_schoolreg_update = "fldId = " . $NewUserId;
                    $db -> updateRec(TBL_ATHELETE_REGISTER, $strDataArr_schoolreg_update, $where_schoolreg_update);
                                
                ################# Insert Custom College #################
            } 

            // Send email to coach for Approval
            if ($_POST['fldSchool'] != "other") {
                //User Selected School
                $schoolid = $func -> input_fun($_POST['fldSchool']);
                $sportid = $func -> input_fun($_POST['fldSport']);
                $emailarr = array();
                $selquery = 'select first.fldId,first.fldEmail as fldEmail,first.fldName as name,first.fldLastName as lname,first.fldUsername as HSCoachUsername,first.fldPassword as HSCoachPassword from ' . TBL_HS_AAU_COACH . ' first,' . TBL_HS_AAU_COACH_SPORT_POSITION . ' second  where second.fldCoachNameId = first.fldId and second.fldSportId =' . $sportid . ' and first.fldSchool =' . $schoolid;
                $db -> query($selquery);
                $db -> next_record();
                if ($db -> num_rows() > 0) {
                    for ($i = 0; $i < $db -> num_rows(); $i++) {
                        $emailarr[] = $func -> output_fun($db -> f('fldEmail'));
                        $name = $func -> output_fun($db -> f('name'));
                        $lname = $func -> output_fun($db -> f('lname'));
                        #Login Info
                        $HSCoachUsername = $func -> output_fun($db -> f('HSCoachUsername'));
                        $HSCoachPassword = $func -> output_fun($db -> f('HSCoachPassword'));
                        
                        $db -> next_record();
                    }
                    foreach ($emailarr as $key => $emailvalue) {
                        
                        ######################## EMAIL to HS COACH - Athlete Approval Notification ########################
                        #Subject
                        $subjectStre = "College Prospect Network - Athlete Pending Approval";
                        
                        #Intro
                        $bodyStre = "Hi Coach " . ucfirst($name) . '&nbsp;' . ucfirst($lname) . ",<br /><br />";
                        
                        #Main Body
                        $bodyStre .= "You are receiving this email because " . ucfirst($aname) . "&nbsp;" . ucfirst($anamel) . " has applied to join <a href=http://www.CollegeProspectNetwork.com>www.CollegeProspectNetwork.com.</a> <br />";
                        $bodyStre .= "<br />";
                        $bodyStre .= "Our website is dedicated to helping athletes get recruited by colleges and it is 100 percent free for you and your athletes. ";
                        $bodyStre .= "Please take a couple of minutes to login and review " . ucfirst($aname) . "&nbsp;" . ucfirst($anamel) . "s application to confirm that he/she is a legitimate prospect in their sport. <br />";
                        $bodyStre .= "<br />";
                        $bodyStre .=  "We also ask that you project the top level of competition at which you can contribute and look over the information he/she has entered to confirm accuracy. It is a simple process and will only take a couple of minutes.<br />";
                        $bodyStre .= "<br />";
                        $bodyStre .= "If " . ucfirst($aname) . "&nbsp;" . ucfirst($anamel) . " lacks the talent necessary or is not one of your athletes, please deny the application. " . ucfirst($aname) . "&nbsp;" . ucfirst($anamel) . " will be notified that the application has been denied but there will be no mention that you have had any part in the process.<br />";
                        $bodyStre .= "<br />";
                        $bodyStre .= "Please do not reply to this email. If you have any questions or concerns, please use the Contact Us page on the website or email us at contact@collegeprospectnetwork.com.<br />";
                        $bodyStre .= "<br />";
                        
                        #Login Info & Directions
                        $bodyStre .= "-------------------------------------------------------- <br />";
                        $bodyStre .= "Login: <a href=http://www.collegeprospectnetwork.com/login.php>http://www.collegeprospectnetwork.com/login.php</a><br />";
                        $bodyStre .= "Username: " . $HSCoachUsername . "<br />";
                        $bodyStre .= "Password: " . $HSCoachPassword ."<br />";
                        $bodyStre .= "User Type: HS/AAU Coach<br />";
                        $bodyStre .= "<br />";
                        $bodyStre .= "You can view all pending approval requests at My Account > Athlete Approval section<br />";
                        $bodyStre .= "-------------------------------------------------------- <br />";
                        $bodyStre .= "<br />";
                        
                        #Footer
                        $bodyStre .= "Thank you in advance Coach " . ucfirst($name) . "&nbsp;" . ucfirst($lname) . ",<br />";
                        $bodyStre .= "<br />";
                        $bodyStre .= "College Prospect Network<br />";
                        $bodyStre .= "<a href=http://www.CollegeProspectNetwork.com>www.CollegeProspectNetwork.com</a>";
                        
                        #SEND EMAL
						$coach=$emailvalue;
                        #SEND EMAL
						$mail1=SendHTMLMail1($coach, $subjectStre, $bodyStre, $fldEmail);
                        //$func -> sendEmail($emailvalue, $subjectStre, $bodyStre, $fldEmail);
                        ########## ///END EMAIL/// ##########
                        
                    }
                }
            } else {
                //User Added Custom School
                #$subjectStre = "CollegeProspectNetwork.com - New Athlete Pending Approval";
                #$bodyStre = "Athlete Approval request";
                #$func -> sendEmail(ADMIN_EMAIL, $subjectStre, $bodyStre, $fldEmail);
            }
            $msg = 1;
            
                ################################################### 
                #Email Admin ATHLETE Registration Notification 
                ################################################### 
               
                if ($_POST['fldSchool'] == "other") {
                      $subjectStre = "[CPN] - New Athlete Registration + New School";
                      $bodyStre = "New Athlete Registration + New School:<br />"; 
                 }
                 else {
                      $subjectStre = "[CPN] - New Athlete Registration";
                      $bodyStre = "New Athlete Registration:<br />"; 
                 }         
                 
                 
                $bodyStre .= "<br /><b>Status:</b> Waiting Approval by HS Coach";
                $bodyStre .= "<br /><b>Athlete User Id:</b> " . $NewUserId;
                $bodyStre .= "<br /><b>Username:</b> " . $func -> input_fun($_POST['fldUsername']) ;
                $bodyStre .= "<br /><b>Password:</b> " . $func -> input_fun($_POST['fldPassword']) ;
                $bodyStre .= "<br /><b>Name:</b> " . $func -> input_fun($_POST['fldFirstname']) . " " . $func -> input_fun($_POST['fldLastname']) ;
                $bodyStre .= "<br /><b>Email:</b> " . $func -> input_fun($_POST['fldEmail']) ;            
                $bodyStre .= "<br />";
                $bodyStre .= "<br /><b>State:</b> " . $func -> input_fun($_POST['fldState']) ;
              
                //Get HS/AAU Name
                $queryHS =" Select * from ".TBL_HS_AAU_TEAM. " where fldId =".$HighSchoolId;  
                $db1->query($queryHS);
                $db1->next_record();
                $HighSchoolName = $db1->f('fldSchoolname');                
                //HS/AAU Name
                $bodyStre .= "<br /><b>HS/AAU:</b> " . $HighSchoolName;
                $bodyStre .= "<br />" . $func -> input_fun($_POST['fldAddress']);
                $bodyStre .= "<br />" . $func -> input_fun($_POST['fldCity']). ", ". $func -> input_fun($_POST['fldState']) . " " . $func -> input_fun($_POST['fldZipcode']);

                //Get Sport Name                                                 
                    $sportquery = "SELECT fldSportsname  from " . TBL_SPORTS . "  WHERE fldId='$sport_empty'";                                            
                    $db1->query($sportquery);                                                    
                    $db1->next_record();                                                                 
                    $sports_name = $func->output_fun($db1->f('fldSportsname'));
                $bodyStre .= "<br /><br /><b>Sport:</b> " . $sports_name;
                $bodyStre .= "<br /><b>Jersey Number:</b> " . $func -> input_fun($_POST['fldJerseyNumber']) ;
                $bodyStre .= "<br /><b>Graduating Class:</b> " . $func -> input_fun($_POST['fldClass']) ;
                $bodyStre .= "<br /><b>Intended Major:</b> " . $func -> input_fun($_POST['fldIntendedMajor']) ;       
                $bodyStre .= "<br /><br />" . $_SERVER['HTTP_USER_AGENT'];  

               	$adminmail=ADMIN_EMAIL.",".EMAIL_FROM;
				$mail=SendHTMLMail1($adminmail, $subjectStre, $bodyStre, $fldEmail);
			    //$func -> sendEmail(ADMIN_EMAIL, $subjectStre, $bodyStre, $fldEmail);
                
                #################END Notifcation Email#################
                
                
            header("Location:Registration-Athlete.php?msg=$msg");
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
        <script language="javascript" type="text/javascript">
        
            function validate() {
                var error_msg = "";
                if(trimString(document.frmAthReg.fldUsername.value) == "") {
                    error_msg += "Please Enter UserName. \n";
                } else {
                    if(hasSpecialCharaters(document.frmAthReg.fldUsername.value)) {
                        error_msg += "Enter valid  UserName. \n";
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
                
                if(trimString(document.frmAthReg.fldPassword.value) == "") {
                    error_msg += "Please Enter Password. \n";
                }
                if(trimString(document.frmAthReg.fldPassword2.value) == "") {
                    error_msg += "Please Enter Confirm Password. \n";
                }
                if(document.frmAthReg.fldPassword.value != document.frmAthReg.fldPassword2.value) {
                    error_msg += "Your Confirm Password Does not Match. \n";
                }
                
                //========================================//
                 //School Validator
                 //========================================//
                 if(trimString(document.frmAthReg.fldSchool.value) == "select") {
                    error_msg += "Please Select HS/AAU Team! \n";
                }
                    
                    //other selected
                    if(trimString(document.frmAthReg.fldSchool.value) == "other") {      
                                                                  
                           //college name
                            if(trimString(document.frmAthReg.txtfldName.value) == "") {
                                error_msg += "Please Enter School Name! \n";
                            } else {
                                if(hasSpecialCharaters(document.frmAthReg.txtfldName.value)) {
                                    error_msg += "Enter Valid School Name! \n";
                                }
                           }     
                                                                    
                    }                  
                   //end: other
                   
                   
                    //School or other selected
                    if(trimString(document.frmAthReg.fldSchool.value) != "select") {
                        
                            //address
                            if(trimString(document.frmAthReg.fldAddress.value) == "") {
                                error_msg += "Please Enter School Address! \n";
                            } else {
                                if(hasSpecialCharaters(document.frmAthReg.fldAddress.value)) {
                                    error_msg += "Enter Valid School Address! \n";
                                }
                           }                           
                            //city
                            if(trimString(document.frmAthReg.fldCity.value) == "") {
                                error_msg += "Please Enter School City! \n";
                            } else {
                                if(hasSpecialCharaters(document.frmAthReg.fldCity.value)) {
                                    error_msg += "Enter Valid School City! \n";
                                }
                           }                           
                           //state
                           if(trimString(document.frmAthReg.fldState.value) == "select") {
                                error_msg += "Please Select School State! \n";
                            }
                            
                            //zipcode
                            if(trimString(document.frmAthReg.fldZipcode.value) == "") {
                                error_msg += "Please Enter School Zip Code! \n";
                            } else {
                                if(hasSpecialCharaters(document.frmAthReg.fldZipcode.value)) {
                                    error_msg += "Enter Valid School Zip Code! \n";
                                }
                           }
                      
                    }
                    //end: School or other                                       
                
                //END School Validator
                //========================================//
                
                      
          
                if(trimString(document.frmAthReg.fldSchool.value) == "others") {
                    if(trimString(document.frmAthReg.fldOthers.value) == "") {
                        error_msg += "Please Enter your choice HS/AAU Team. \n";
                    } else {
                        if(hasSpecialCharaters(document.frmAthReg.fldOthers.value)) {
                            error_msg += "Please Enter your choice HS/AAU Team. \n";
                        }
                    }
                } else {
                    if(trimString(document.frmAthReg.fldSport.value) == "") {
                        error_msg += "Please Select Sport. \n";
                    } else {
                        if(hasSpecialCharaters(document.frmAthReg.fldSport.value)) {
                            error_msg += "Please Select Sport. \n";
                        }
                    }
                }
                
              
                if(trimString(document.frmAthReg.fldSchool.value) == 0) {
                    error_msg += "Please Select High School / AAU Team. \n";
                }
                if(trimString(document.frmAthReg.fldSport.value) == 'select') {
                    error_msg += "Please Select Sport. \n";
                }
                if(trimString(document.frmAthReg.fldJerseyNumber.value) == "") {
                    error_msg += "Please Enter Jersey Number . \n";
                }
                if(trimString(document.frmAthReg.fldClass.value) == "select") {
                    error_msg += "Please Select Graduating Class. \n";
                }
                if(trimString(document.frmAthReg.fldQuestion.value) == "") {
                    error_msg += "Please Enter Security Question. \n";
                }
                if(hasSpecialCharaters(document.frmAthReg.fldQuestion.value)) {
                    error_msg += "Please Enter Security Question. \n";
                }
                if(trimString(document.frmAthReg.fldAnswer.value) == "") {
                    error_msg += "Please Enter Security Answer. \n";
                }
                if(hasSpecialCharaters(document.frmAthReg.fldAnswer.value)) {
                    error_msg += "Please Enter Security Answer. \n";
                }
                if(!document.frmAthReg.agree.checked) {
                    error_msg += "You must agree to the terms";
                }
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            }

            function getSchool(str) {
                if(str == "others") {
                    document.getElementById('txtschoolothers').style.display = "";
                }
                if(str != "others") {
                    document.getElementById('txtschoolothers').style.display = "none";
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
                      url: 'addschool-new.php?q='+ddlval,
                      success: function(data) {
                       $("#AjaxResponse").html(data);       
                      }
                    });
                } else {
                    $("#txtschoolothers").hide();
                    //document.getElementById("txtschoolothers").style.display = "none";
                    $.ajax({
                      url: 'addschool-new.php?q='+ddlval,
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
							<h1>Athlete Registration</h1>
							<?php
if($_REQUEST['msg']==1)
{
							?>
							<div class="thankyoumessage">
								<?php echo "Thank you for submitting your application.  Your profile will be reviewed by the College Prospect
Network staff and you will be notified via email whether you are approved.  Please allow 10 business days for
us to process your request before contacting us.<br /><br />From, <br />College Prospect Network, LLC.";
								?>
							</div>
							<?php
                                }
                                else
                                {
                                if (count($error_msg)>0)
                                {
                                foreach($error_msg as $key=>$value)
                                {
							?>
							<div class="thankyoumessage">
								<?php    echo $value;?>
							</div>
							<?
                                }
                                }
							?>
							<span class="msg"><font color="#0000ff">&nbsp;*</font> Fields are Mandatory.</span>
							<div class="registerPage">
								<form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
									<p>
										<label>User Name:</label>
										<span>
											<input type="text" name="fldUsername" value="<?php
                                            if (isset($_POST['fldUsername']))
                                                echo $_POST['fldUsername'];
 ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Password:</label>
										<span>
											<input type="password" name="fldPassword" value="<?php
                                            if (isset($_POST['fldPassword']))
                                                echo $_POST['fldPassword'];
 ?>"  />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Confirm Password:</label>
										<span>
											<input type="password" name="fldPassword2" value="<?php
                                            if (isset($_POST['fldPassword2']))
                                                echo $_POST['fldPassword2'];
 ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<hr class="line" />
									<p>
										<label>First Name:</label>
										<span>
											<input type="text" name="fldFirstname" value="<?php
                                            if (isset($_POST['fldFirstname']))
                                                echo $_POST['fldFirstname'];
 ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Last Name:</label>
										<span>
											<input type="text" name="fldLastname"  value="<?php
                                            if (isset($_POST['fldLastname']))
                                                echo $_POST['fldLastname'];
 ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Email:</label>
										<span>
											<input type="text" name="fldEmail" value="<?php
                                            if (isset($_POST['fldEmail']))
                                                echo $_POST['fldEmail'];
 ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Height:</label>
										<span> <?php    echo '<select name="fldHeight"><option value="" class="selectgrey">Select Height</option>';
                                            for ($i = 5; $i < 7; $i++) {
                                                for ($j = 0; $j < 12; $j++) {
                                                    echo '<option value="' . $i . "-" . $j . '"';
                                                    echo '>' . $i . "' " . $j . '</option>';
                                                }
                                            }
                                            for ($kcount = 0; $kcount < 3; $kcount++) {
                                                echo '<option value="' . "7" . "-" . $kcount . '"';
                                                echo '>' . "7" . "' " . $kcount . '</option>';
                                            }
                                            echo '</select>';
											?></span>
									</p>
									<p>
										<label>Weight:</label>
										<span> <?php
                                            echo '<select name="fldWeight"><option value="" class="selectgrey">Select Weight</option>';
                                            echo '<option value="under140">Under 140</option>';
                                            for ($i = 127; $i < 245; $i++) {
                                                $i = $i + 14;
                                                $j = $i + 14;
                                                echo '<option value="' . $i . "-" . $j . '"';
                                                echo '>' . $i . "-" . $j . '</option>';
                                            }
                                            echo '<option value="Over260">Over 260</option>';
                                            echo '</select>';
											?></span>
									</p>
									<hr class="line" />							
									<p>
                                        <label>High School/AAU Team:</label>
                                        <span> <?php
                                            echo $strcombo = '<select name="fldSchool" id="fldSchool" style="width:276px">';
                                            echo $strcombo = '<option value="select" class="selectgrey">Select HS/AAU Team</option>';
                                           
                                            #$categorylist = $func -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldState");
                                            #for ($i = 0; $i < count($categorylist); $i++) {
                                                #echo '<option value ="' . $categorylist[$i]['fldId'] . '" >' . $categorylist[$i]['fldSchoolname'] . '</option>';
                                            #}
                                            
                                            $statelist = $func2 -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldState", "fldState", "WHERE fldStatus='ACTIVE'");
                                            for ($x = 0; $x < count($statelist); $x++) {
                                                echo '<optgroup label="========' . $statelist[$x]['fldState'] . '========">';
                                                #echo '<option value ="' . $statelist[$x]['fldState'] . '" >' . $statelist[$x]['fldState'] . '</option>';
                                                
                                                $whereclaus = "WHERE fldState = '" . $statelist[$x]['fldState'] . "' ";
                                                
                                                $categorylist = $func -> selectTableOrder(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldSchoolname", $whereclaus);
                                                for ($i = 0; $i < count($categorylist); $i++) {
                                                    echo '<option value ="' . $categorylist[$i]['fldId'] . '" >' . $categorylist[$i]['fldSchoolname'] . '</option>';
                                               }
                                                
                                                echo '<option value ="other" class="addcustom_normal">**** Other (Add Your School) ****</option>';
                                                
                                                echo '</optgroup>';
                                            }
                                            
                                            echo '<option value ="other" class="addcustom">Not Listed? Add Your School</option>';
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
										<label>Sport:</label><!--<span>-->
										<input type="hidden" name="schoolid" id="schoolid" value="">
										<span> <?php
                                            $sportlist = $func -> selectTableOrder(TBL_SPORTS, "fldId,fldSportsname", "fldSportsname");
											?><select name="fldSport" ><option value = "select" class="selectgrey">Select Sport</option><?php
											for ($i=0;$i<count($sportlist);$i++)
											{
											?>
											<option value ="<?php echo $sportlist[$i]['fldId']?>" <?php if(isset($_REQUEST['sportid'])and ($_REQUEST['sportid']==$sportlist[$i]['fldId'])){ ?>selected <?php }?>><?php echo $sportlist[$i]['fldSportsname'];?></option>
											<?php
                                                }
											?>
											</select> </span><font color="#0000ff">*</font>
									</p>
									<p>
										<label>Jersey Number:</label>
										<span>
											<input type="text" name="fldJerseyNumber"  value="<?php if (isset($_POST['fldJerseyNumber'])) echo $_POST['fldJerseyNumber']; ?>"  style="width:80px;" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Graduating Class:</label>
										<span> <?php    echo '<select name="fldClass"><option value="select" class="selectgrey">Select Class</option>';
                                            $classlist = $func -> selectTableOrder(TBL_CLASS, "fldId,fldClass", "fldClass");
                                            for ($i = 0; $i < count($classlist); $i++) {
                                                echo '<option value ="' . $classlist[$i]['fldClass'] . '" >' . $classlist[$i]['fldClass'] . '</option>';
                                            }
                                            echo $strcombo = '</select>';
											?></span><font color="#0000ff">*</font>
									</p>
									<p>
										<label>Intended Major:</label>
										<span> <?php
                                            echo '<select name="fldIntendedMajor"><option value="" class="selectgrey">Please Select</option>';
											?>
											<option value="Undecided / General Studies" <?php if($fldIntendedMajor=="Undecided / General Studies"){ ?>selected <?php }?> >Undecided / General Studies</option> <option value="Agriculture" <?php if($fldIntendedMajor=="Agriculture"){ ?>selected <?php }?>>Agriculture</option> <option value="Architecture" <?php if($fldIntendedMajor=="Architecture"){ ?>selected <?php }?>>Architecture</option> <option value="Arts" <?php if($fldIntendedMajor=="Arts"){ ?>selected <?php }?>>Arts</option> <option value="Business" <?php if($fldIntendedMajor=="Business"){ ?>selected <?php }?>>Business</option> <option value="Communications" <?php if($fldIntendedMajor=="Architecture"){ ?>selected <?php }?>>Communications</option> <option value="Computers / Information Technology" <?php if($fldIntendedMajor=="Architecture"){ ?>selected <?php }?>>Computers / Information Technology</option> <option value="Education" <?php if($fldIntendedMajor=="Education"){ ?>selected <?php }?>>Education</option> <option value="Engineering" <?php if($fldIntendedMajor=="Engineering"){ ?>selected <?php }?>>Engineering</option> <option value="Liberal Arts" <?php if($fldIntendedMajor=="Liberal Arts"){ ?>selected <?php }?>>Liberal Arts</option> <option value="Math" <?php if($fldIntendedMajor=="Math"){ ?>selected <?php }?>>Math</option> <option value="Science" <?php if($fldIntendedMajor=="Science"){ ?>selected <?php }?>>Science</option> <option value="Other" <?php if($fldIntendedMajor=="Other"){ ?>selected <?php }?>>Other</option> <?php
                                                echo '</select>';
											?></span>
									</p>
									<hr class="line" />
									<p>
										<label>Enter your Security Question:</label>
										<span>
											<input type="text" name="fldQuestion" value="<?php
                                            if (isset($_POST['fldQuestion']))
                                                echo $_POST['fldQuestion'];
 ?>"  />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<label>Enter your Security Answer:</label>
										<span>
											<input type="text" name="fldAnswer"  value="<?php
                                            if (isset($_POST['fldAnswer']))
                                                echo $_POST['fldAnswer'];
 ?>" />
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p>
										<span>
											<input type="hidden" name="fldStatus"  value="DEACTIVE" />
										</span>
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
											<input type="hidden" name="isSubmit" value="save">
											<input type="submit" name="submit" value="Register">
											<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">
										</span>
									</p>
								</form>
							</div>
							<?php
                                }
							?>
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
