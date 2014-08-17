<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    session_start();
    if ($_SESSION['FRONTEND_USER'] == "") {
        header("Location:index.php");
    }
    //for paging
    $func = new COMMONFUNC;
    $func2 = new COMMONFUNC;
    //Create an instance of class COMMONFUNC
    $page = new Page();
    //Create an instance of class Pate
    $lnb = "2";
    $db2 = new DB;
    $db3 = new DB;
    $db5 = new DB;
         
    $error_msg = '';
    $fldEventStatus = 1;
    $flag = 0;
    
    //CHECK DATE FORMAT
    //echo "<br><br><br><br><br>";
    //echo date('Y-m-d H:i:s', strtotime('2012-02-18 18:51'));     
    //echo date('Y-m-d H:i:s', strtotime('2012-03-16 06:54')); 
    
    #Get My Team
    $AthleteUsername= $_SESSION['FRONTEND_USER'];
    $queryMy = " Select * from " . TBL_ATHELETE_REGISTER . " where fldUsername = '$AthleteUsername' ";
    $db3 -> query($queryMy);
    $db3 -> next_record();
    $Myteam = $func -> output_fun($db3 -> f('fldSchool'));    
    #echo "MyTeam: " . $Myteam;
    
    $queryMyTeam = " Select * from " . TBL_HS_AAU_TEAM . " where fldId = '$Myteam' ";
    $db3 -> query($queryMyTeam);
    $db3 -> next_record();
    $MyteamName = $func -> output_fun($db3 -> f('fldSchoolname'));
    #echo "<br />MyTeamName: " . $MyteamName;
                
     ###### DEBUG POST DATA - set Submit button to 'debug' ######       
    if ($_POST['isSubmit'] == 'debug') {
        $buff[] = 'Response from server: ';
        if(count($_POST))
        {
            $buff[] = 'POST data recived: ';
            $buff[] = '<pre style="text-align:left">'.print_r($_POST, true).'</pre>';
        }
        else
        {
            $buff[] = 'No POST data';
        }
        $buff[] = $_SERVER['HTTP_X_REQUESTED_WITH'] ? 'This is AJAX request' : 'This is POST request<br><a href="javascript:history.back();">&laquo; Back</a>';
        
        echo implode('<br>', $buff);
    }

    ###### ADD EVENT ######
    if ($_POST['isSubmit'] == 'save') {
        //Edit the user info
        $fldEventName = $func -> input_fun($_POST['fldEventName']);
        $fldSport = $func -> input_fun($_POST['fldSport']);
        $fldEventDescription = $func -> input_fun($_POST['fldEventDescription']);
        $fldEventLocation = $func -> input_fun($_POST['fldEventLocation']);
        $fldEventStartDate = $func -> input_fun($_POST['fldEventStartDate']);
        $fldEventEndDate = $func -> input_fun($_POST['fldEventEndDate']);
        $fldHomeTeam = $func -> input_fun($_POST['fldHomeTeam']);
        $fldAwayTeam = $func -> input_fun($_POST['fldAwayTeam']);
        $fldEventStatus = $func -> input_fun($_POST['fldEventStatus']);
        
        //Check if Home or Away is your own team       
        if ($fldHomeTeam != $Myteam && $fldAwayTeam != $Myteam) {
            $error_msg = 'Home or Away Team must be your Team!';
            $flag++;
        }
        
        if ($flag == 0) {
            //Set Dates to MySQL Format
            $MySQLStartDate = $_POST['fldEventStartDate'];        
            $MySQLEndDate = $_POST['fldEventEndDate'];  
            
            $strDataArr = array('fldEventName' => $func -> input_fun($_POST['fldEventName']),
                    'fldSport' => $func -> input_fun($_POST['fldSport']),
                    'fldEventDescription' => $func -> input_fun($_POST['fldEventDescription']),
                    'fldEventLocation' => $func -> input_fun($_POST['fldEventLocation']),
                    'fldEventStartDate' => $MySQLStartDate,
                    'fldEventEndDate' => $MySQLEndDate,
                    'fldHomeTeam' => $func -> input_fun($_POST['fldHomeTeam']),
                    'fldAwayTeam' => $func -> input_fun($_POST['fldAwayTeam']),
                    'fldEventStatus' => 1,
                    'fldUserName' => $func -> input_fun($_SESSION['FRONTEND_USER']),
                    'fld_UserType' => "athlete");
                    
            $newRowID = $db5 -> insertRec(TBL_EVENT, $strDataArr);            
                        
            #Debug - Print Array Details
            #print_r(array_values($strDataArr));
            #echo ("NewID:" . $newRowID . ":");
            
            #Redirect User
            header("Location: listevent.php?msg=Event successfully added.");
        }

        //this section is use to filup the value after erro message.
        #if ($error_msg != "") {
            $fldEventName = $_REQUEST['fldEventName'];
            $fldSport = $_REQUEST['fldSport'];
            $fldEventDescription = $_REQUEST['fldEventDescription'];
            $fldEventLocation = $_REQUEST['fldEventLocation'];
            $fldEventStartDate = $_REQUEST['fldEventStartDate'];
            $fldEventEndDate = $_REQUEST['fldEventEndDate'];
            $fldHomeTeam = $_REQUEST['fldHomeTeam'];
            $fldAwayTeam = $_REQUEST['fldAwayTeam'];
        #}
    } //END if submit
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - Add Event</title>
		<META NAME="Keywords" CONTENT="">
		<META NAME="Description" CONTENT="">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script language="JavaScript" type="text/JavaScript">
            function validate() {
                var error_msg = "";
                //var blnResult = true;
                if(trimString(document.frmEvent.fldEventName.value) == "") {
                    error_msg += "Please Enter Event Name! \n";
                } else {
                    if(hasSpecialCharaters(document.frmEvent.fldEventName.value)) {
                        error_msg += "Please Enter Valid Event Name! \n";
                    }
                }
                if(trimString(document.frmEvent.fldHomeTeam.value) == "select") {
                    error_msg += "Please Select Home Team! \n";
                }
                if(trimString(document.frmEvent.fldAwayTeam.value) == "select") {
                    error_msg += "Please Select Away Team! \n";
                }
                if(trimString(document.frmEvent.fldHomeTeam.value) == trimString(document.frmEvent.fldAwayTeam.value)) {
                    error_msg += "Please Select Different Home And Away Team! \n";
                }
                if(trimString(document.frmEvent.fldEventLocation.value) == "") {
                    error_msg += "Please Enter Event Location! \n";
                }
                if(trimString(document.frmEvent.fldEventStartDate.value) == "") {
                    error_msg += "Please Enter Event Start Date! \n";
                }
                if(trimString(document.frmEvent.fldEventEndDate.value) == "") {
                    error_msg += "Please Enter End Event Date! \n";
                }
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            }
		</script>

		<script type="text/javascript" language="javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js"></script>
        <script type="text/javascript" language="javascript" src="https://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.3/scriptaculous.js"></script>
        <script type="text/javascript" language="javascript" src="/js/protoplasm.js"></script>
        <script type="text/javascript" src="/js/date.js"></script>
        <script type="text/javascript" language="javascript">
      
        varStartDateOld = "";
        varEndDateOld = "";
        flagAdd2Hours = 0;
        varEndDatePlus2 = "";
        function checkStartEndDate()
        {
                        
            //Reset Local Flags   
            flagAdd2Hours = 0;
                  
             //Start Date   
            varStartDate = document.frmEvent.fldEventStartDate.value;  
                      
            if (varStartDate != "" && varStartDate != varStartDateOld) {    
                //If Start Date is different               
                varStartDateOld = varStartDate;
                //Get StartDate & Add 2 Hours Flag
                varStartDateOld = document.frmEvent.fldEventStartDate.value; 
                varEndDatePlus2 = Date.parse(varStartDateOld);
                varEndDatePlus2 =  varEndDatePlus2.addHours(2);  
                flagAdd2Hours = 1;        //Set Add2Hours Flag
            }           
            else {    
                   flagAdd2Hours = 0;        //Reset Add2Hours Flag
                }       
          
            //Format Start Date (2nd textbox)
            if (varStartDate != "") 
            {                   
                 //Set START Formatted Input
                varStartDate = Date.parse(varStartDate);
                varStartDate = varStartDate.toString("dddd, MMMM dd, yyyy h:mm tt");
                document.frmEvent.fldEventStartDateFormatted.value = varStartDate;               
            }
                        
            
            //Format End Date (2nd textbox)           
            varEndDate = document.frmEvent.fldEventEndDate.value; 
            varEndDateFormatted = varEndDate;
       
                if (flagAdd2Hours == 1) {
                    varEndDate = varEndDatePlus2.toString("yyyy-MM-dd HH:mm");
                    varEndDateFormatted = varEndDatePlus2.toString("dddd, MMMM dd, yyyy h:mm tt");
                }
               else {
                   varEndDate = varEndDate;
                   varEndDateFormatted = Date.parse(varEndDate);
                   varEndDateFormatted = varEndDateFormatted.toString("dddd, MMMM dd, yyyy h:mm tt");
               }
               
                //Set END Main Input
                //varEndDate = Date.parse(varEndDate);
                //varEndDate = varEndDate.toString("dddd, MMMM dd, yyyy h:mm tt");
                document.frmEvent.fldEventEndDate.value = varEndDate;
                
                //Set END Formatted Input
                //varEndDateFormatted = Date.parse(varEndDateFormatted);
                //varEndDateFormatted = varEndDateFormatted.toString("dddd, MMMM dd, yyyy h:mm tt");
                document.frmEvent.fldEventEndDateFormatted.value = varEndDateFormatted;
               
        }
         
    
        //****************************************
        //* Prototype DateTime Picker 
       //****************************************
       
           //Samples
            //--- Protoplasm.use('datepicker').transform('input.datepicker');
           //---- Protoplasm.use('datepicker').transform('.datetimepicker_es', { timePicker: true, use24hrs: false });      
            Protoplasm.use('datepicker').transform('.datetimepicker', {                
                dateTimeFormat: 'yyyy-MM-dd HH:mm', 
                dateFormat: 'yyyy-MM-dd', 
                firstWeekDay: 1, 
                monthCount: 3,  
                timePicker: true, 
                manual: false,
                use24hrs: false,
                });
                
            Protoplasm.use('datepicker').transform('.datetimepicker_es', {                
                dateTimeFormat: 'yyyy-MM-dd HH:mm', 
                dateFormat: 'yyyy-MM-dd', 
                firstWeekDay: 1, 
                monthCount: 3,  
                timePicker: true, 
                manual: false,
                use24hrs: false
                });


         </script>
		
		<script language="Javascript" src="javascript/functions.js"></script>
	
		<script type="text/javascript">
        
            function formsubmit_location(str) {
                /*window.location="CollegeAddEvent.php?homeTeamid="+param;*/
                var xmlhttp;
                if(str.length == 0) {
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
                    }
                }
                xmlhttp.open("GET", "getlocation.php?q=" + str, true);
                xmlhttp.send();
                formsubmit_Event(str);
            }

            function formsubmit_Event(str) {
                var xmlhttp;
                if(str.length == 0) {
                    document.getElementById("txtEvent").innerHTML = "";
                    return;
                }
                if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtEvent").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "getevent.php?q=" + str + "&HomeTeam=" + document.getElementById('fldHomeTeam').options[document.getElementById('fldHomeTeam').selectedIndex].text + "&AwayTeam=" + document.getElementById('fldAwayTeam').options[document.getElementById('fldAwayTeam').selectedIndex].text, true);
                xmlhttp.send();
            }
		</script>
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
						<div class="register-main">
							<!--<div style="float:right;"> <font color="red">*</font> Fields are Mandatory.</div>-->
							<div class="registerPage">
								<h1>Add Game / Event</h1>
								<?php
                            if($error_msg)
                            {
								?>
								<p class="thankyoumessage">
									<?php   echo $error_msg;?>
								</p>
								<?php   }?>
								<?php if(($_SESSION['mode']=='athlete')or($_SESSION['mode']=='school')){
								?>
								<form name="frmEvent" action="" method="post" enctype="multipart/form-data"  id="frmEvent">
									<?php
                                        $athlete_info = $func -> selectTableOrder(TBL_ATHELETE_REGISTER, "fldId,fldSport", "fldId", "where fldUsername='" . $_SESSION['FRONTEND_USER'] . "'");
									?>
									<input type="hidden" value="<?php  echo $athlete_info[0]['fldSport'];?>" name="fldSport">
                
									<p>
                                        <label>Home Team:</label>
                                        <span> <?php
                                            echo $strcombo = '<select name="fldHomeTeam" id="fldHomeTeam" onchange="formsubmit_location(this.value);">';
                                            echo $strcombo = '<option value="select" class="selectgrey">Select Home Team</option>';
                                            
                                            //Add My Team                                
                                             echo '<option value ="' . $Myteam . '" selected>' . $MyteamName . '</option>';
                                             
                                            //Get State List                      
                                            $statelist = $func2 -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldState", "fldState", "WHERE fldStatus='ACTIVE'");
                                            //Loop States
                                            for ($x = 0; $x < count($statelist); $x++) {
                                                echo '<optgroup label="' . $statelist[$x]['fldState'] . '">';                                               
                                                $whereclaus = "WHERE fldState = '" . $statelist[$x]['fldState'] . "' ";         
                                                //Get Teams per State                                    
                                                $homelist = $func -> selectTableOrder(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldSchoolname", $whereclaus);
                                                //Loop Teams per State
                                                for ($i = 0; $i < count($homelist); $i++) {
                                                    
                                                    #if ($homelist[$i]['fldId'] == $Myteam) {
                                                        //Select My Team by default
                                                        #echo '<option value ="' . $homelist[$i]['fldId'] . '" selected>' . $homelist[$i]['fldSchoolname'] . '</option>';
                                                    #}
                                                    #else {
                                                        echo '<option value ="' . $homelist[$i]['fldId'] . '">' . $homelist[$i]['fldSchoolname'] . '</option>';
                                                     # }                                                           
                                                    
                                               }                                                
                                                echo '</optgroup>';
                                            }                                            
                                            echo $strcombo = '</select>';
                                            
                                            ?></span><font color="#0000ff">*</font>
                                    </p>
                                    
                                    <p>
                                        <label>Away Team:</label>
                                        <span> <?php
                                            echo $strcombo = '<select name="fldAwayTeam" id="fldAwayTeam" onchange="formsubmit_Event(this.value);">';
                                            echo $strcombo = '<option value="select" class="selectgrey">Select Away Team</option>';

                                            //Add My Team                                
                                             echo '<option value ="' . $Myteam . '" >' . $MyteamName . '</option>';
                                            
                                            //Get State List                      
                                            $statelist = $func2 -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldState", "fldState", "WHERE fldStatus='ACTIVE'");
                                            //Loop States
                                            for ($x = 0; $x < count($statelist); $x++) {
                                                echo '<optgroup label="' . $statelist[$x]['fldState'] . '">';                                               
                                                $whereclaus = "WHERE fldState = '" . $statelist[$x]['fldState'] . "' ";         
                                                //Get Teams per State                                    
                                                $homelist = $func -> selectTableOrder(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldSchoolname", $whereclaus);
                                                //Loop Teams per State
                                                for ($i = 0; $i < count($homelist); $i++) {
                                                    echo '<option value ="' . $homelist[$i]['fldId'] . '" >' . $homelist[$i]['fldSchoolname'] . '</option>';
                                               }                                                
                                                echo '</optgroup>';
                                            }                                            
                                            echo $strcombo = '</select>';
                                            
                                            ?></span><font color="#0000ff">*</font>
                                    </p>

									<p id="txtEvent">
										<label>Event Name:</label>
										<span>
											<input type="text" name="fldEventName" id="fldEventName" value="<?=$fldEventName?>" maxlength="30"  style="width:375px;">
										</span><font color="#0000ff">&nbsp;*</font>
									</p>
									<p id="txtHint">
										<label>Location:</label>
										<?php  
                                            if (($_REQUEST['sportid']) and ($_REQUEST['homeTeamid']) and ($_REQUEST['homeTeamid'] != 'select')) {
                                                 $query = "Select * from " . TBL_HS_AAU_TEAM . " where fldId =" . $_REQUEST['homeTeamid'];
                                                $db -> query($query);
                                                $db -> next_record();
                                                $address = $db -> f('fldAddress');
                                                $city = $db -> f('fldCity');
                                                $state = $db -> f('fldState');
                                                $zipcode = $db -> f('fldZipcode');
                                                $location = $address . "\r\n" . $city . ", " . $state . " " . $zipcode;
                                            }
                                            else {
                                                $query = "Select * from " . TBL_HS_AAU_TEAM . " where fldId =" . $Myteam;
                                                $db -> query($query);
                                                $db -> next_record();
                                                $address = $db -> f('fldAddress');
                                                $city = $db -> f('fldCity');
                                                $state = $db -> f('fldState');
                                                $zipcode = $db -> f('fldZipcode');
                                                $location = $address . "\r\n" . $city . ", " . $state . " " . $zipcode;
                                            }
										?>
										<span><textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="15"><?php
                                                if ($location) {
                                                    echo $location;
                                                }
                                        ?></textarea> </span><font color="#0000ff">*</font>
									</p>
									<p>
										<label>Event Details:</label>
										<?php
                                            $fldEventDescription = str_replace("<br>", "\n", $fldEventDescription);
										?>
										<span><textarea name="fldEventDescription" id="fldEventDescription" class="ta1"><?php  echo $fldEventDescription;?></textarea></span>
									</p>
									<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" >
										<tr>
											<td style="color: #646464;
											font-size: 14px;
											font-weight: bold;
											line-height: 32px;
											margin-bottom: 0;
											margin-right: 0;
											margin-top: 0;
											padding: 0 6px 0 174px;
											text-align: left;
											width: 90px;">Start Date:</td>
											<td>
											<input type="text" class="datetimepicker"  id="fldEventStartDate" name="fldEventStartDate" autocomplete="off" value="<?
                                                if ($fldEventStartDate) {
                                                    echo $fldEventStartDate;
                                                }
                                                else {
                                                }
											?>" >
											
											<input type="text" class="datetimepickerformat"  id="fldEventStartDateFormatted" name="fldEventStartDateFormatted" autocomplete="off" readonly>
											
											</td>
										</tr>
									</table>
									<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" >
										<tr>
											<td style="color: #646464;
											font-size: 14px;
											font-weight: bold;
											line-height: 32px;
											margin-bottom: 0;
											margin-right: 0;
											margin-top: 0;
											padding: 0 6px 0 174px;
											text-align: left;
											width: 90px;">End Date:</td>
											<td>
											<input type="text" class="datetimepicker_es"  id="fldEventEndDate" name="fldEventEndDate" autocomplete="off" value="<?
                                                if ($fldEventEndDate) {
                                                    echo $fldEventEndDate;
                                                }
                                                else {
                                                }
											?>" >
											
											<input type="text" class="datetimepickerformat"  id="fldEventEndDateFormatted" name="fldEventEndDateFormatted" autocomplete="off" readonly>
											
											</td>
										</tr>
									</table>
									<p style="padding-top:20px;">
										<label>&nbsp;</label>
										<span>
											<input type="hidden" name="isSubmit" value="save">
											<input type="submit" name="submit" value="Submit" onclick="return validate();">
											<INPUT TYPE="button" VALUE="Back" ONCLICK="history.go(-1)">
										</span>
									</p>
								</form>
								<?php   }
                                    else
                                    {
								?><p><font color="#0000ff"><b>Access Denied</b></font></p><?php
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