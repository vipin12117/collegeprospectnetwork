<?php
    session_start();
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    include_once ("inc/config.inc.php");
    //for paging
    $func = new COMMONFUNC;
    $db = new DB;
    
    //Set Default Vars
    $IsCollegeCoach= 0; //If is College Coach
    $IsHSCoach = 0; //If is HS Coach
    $HSCoachhasvoted = 0; //If HS Coach Voted
    $AthleteHasRatings = 0; //If Athlete has Rating
    $IsAthlete = 0; //If Athlete, show Permission Error
    
    //Detect if athlete, display Permission Error if true
    if ($_SESSION['mode'] == 'athlete') {
        $IsAthlete = 1;
    }
    $mode = isset($_REQUEST["mode"])?$_REQUEST["mode"]:0;
	
	if($mode == "approve")
	{
	
		$Id = $_REQUEST['fldId'];
		$active_query_details = "update " . TBL_NETWORK . " set fldStatus = 'Active' where fldId='" . $Id . "'";
		$activemsg = $db -> query($active_query_details);
		if (isset($activemsg) && $activemsg == 1) {
		    $msg = 'ApproveSuccess';
			header("Location:RatingAthleteApproval.php?fldId=" . $_REQUEST['fldId'] . "&fldAthleteID=".$_REQUEST['fldAthleteID']."&mode=approveSuccess&msg=$msg");
		}
		
	}
    //Check if Athlete has Ratings
     $whereClause1 = "fldAthlete_id=" . $_REQUEST['fldAthleteID'];    
	
     if ($db -> MatchingRec(TBL_RATING, $whereClause1) > 0) {
            $AthleteHasRatings = 1;
        }
   
    //Detect if College Coach, display raitings if Athlete has ratings
    if ($_SESSION['mode'] == 'college') {
        $IsCollegeCoach = 1;           
    }
    #Detect if HS Coach, get Coach Data
    if ($_SESSION['mode'] == 'coach') {
        $IsHSCoach = 1;
        $coach_query = "select * from " . TBL_HS_AAU_COACH . " where fldUsername ='" . $_SESSION['FRONTEND_USER'] . "'";
        $db1 -> query($coach_query);
        $db1 -> next_record();
        $coach_id = $db1 -> f('fldId');
        //detect if HS Coach has rated this user
        $whereClause = "fldAthlete_id=" . $_REQUEST['fldAthleteID'] . " and fldCoach_id=" . $coach_id;
        if ($db -> MatchingRec(TBL_RATING, $whereClause) > 0) {
            $HSCoachhasvoted = 1;
        }        
        else {
            $HSCoachhasvoted = 0;
        }
    }
    
    if ($_POST['save'] == 'debug') {
            $buff[] = 'Response from server: ';
            if(count($_POST))
            {
                //AthleteID
                $buff[] = $_REQUEST['fldAthleteID'];
                //Coach ID
                $buff[] = $coach_id;
                //Form Values - stars
                $buff[] = $_POST['fldLeaderShip'];
                $buff[] =  $_POST['fldWork_Ethic'];
                $buff[] =  $_POST['fldPrimacy_Go_To_Guy'];
                $buff[] =  $_POST['fldMental_Toughness'];
                $buff[] =  $_POST['fldComposure'];
                $buff[] = $_POST['fldAwareness'];
                $buff[] =  $_POST['fldInstincts'];
                $buff[] =  $_POST['fldVision'];
                $buff[] = $_POST['fldConditioning'];
                $buff[] =  $_POST['fldPhysical_Toughness'];
                $buff[] =  $_POST['fldTenacity'];
                $buff[] = $_POST['fldHustle'];
                $buff[] = $_POST['fldStrength'];
                //Date
                $buff[] =  date("y-m-d");
                //$buff[] = '<pre style="text-align:left">'.print_r($_POST, true).'</pre>';
            }
            else
            {
                $buff[] = 'No POST data';
            }
            //$buff[] = $_SERVER['HTTP_X_REQUESTED_WITH'] ? 'This is AJAX request' : 'This is POST request<br><a href="javascript:history.back();">&laquo; Back</a>';
            echo implode('<br>', $buff);
        //header("Location:RatingAthlete.php?fldId=" . $_REQUEST['fldId'] . "&msg=$buff");       
    }
    
    if ($_POST['save'] == 'save') {
        if ($IsHSCoach == 1) {
            $starr = array(
                    'fldAthlete_id' => $_REQUEST['fldAthleteID'],
                    'fldCoach_id' => $coach_id,
                    'fldLeaderShip' => $_POST['fldLeaderShip'],
                    'fldWork_Ethic' => $_POST['fldWork_Ethic'],
                    'fldPrimacy_Go_To_Guy' => $_POST['fldPrimacy_Go_To_Guy'],
                    'fldMental_Toughness' => $_POST['fldMental_Toughness'],
                    'fldComposure' => $_POST['fldComposure'],
                    'fldAwareness' => $_POST['fldAwareness'],
                    'fldInstincts' => $_POST['fldInstincts'],
                    'fldVision' => $_POST['fldVision'],
                    'fldConditioning' => $_POST['fldConditioning'],
                    'fldPhysical_Toughness' => $_POST['fldPhysical_Toughness'],
                    'fldTenacity' => $_POST['fldTenacity'],
                    'fldHustle' => $_POST['fldHustle'],
                    'fldStrength' => $_POST['fldStrength'],
                    'fldAddDate' => date("y-m-d")
            );
			
            $db -> insertRec(TBL_RATING, $starr);
            //$msg = 'Rating successfully added.  <a href="javascript:refreshParent();">Close Window</a>';
			
			if ($_REQUEST["mode"] == "active") {
				$Id = $_REQUEST['Id'];
				$active_query_details = "update " . TBL_NETWORK . " set fldStatus = 'Active' where fldId='" . $Id . "'";
				$activemsg = $db -> query($active_query_details);
				if (isset($activemsg)) {
					//$_REQUEST['msg'] = "Network Request Aapproved. User has been sent a nofication.";
				}
				//Send Email
			}
			
			$func -> getAverageRating($_REQUEST['fldAthleteID']);
            $msg = 'Success';
            header("Location:RatingAthleteApproval.php?fldId=" . $_REQUEST['fldId'] . "&fldAthleteID=".$_REQUEST['fldAthleteID']."&mode=view&msg=$msg");
        }
    }
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - Athlete Rating</title>
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
            function approveRequest(fldID,mode,fldAthleteID)
			{
			
				window.location.href='RatingAthleteApproval.php?fldId='+fldID+'&fldAthleteID='+fldAthleteID+'&mode='+mode;
			}
            function validate() {
                var error_msg = "";
                if(trimString(document.rating.fldLeaderShip.value) == "0") {
                    error_msg += "Please Select LeaderShip. \n";
                }
                if(trimString(document.rating.fldWork_Ethic.value) == "0") {
                    error_msg += "Please Select Work Ethic. \n";
                }
                if(trimString(document.rating.fldPrimacy_Go_To_Guy.value) == "0") {
                    error_msg += "Please Select Primacy Go To Guy. \n";
                }
                if(trimString(document.rating.fldMental_Toughness.value) == "0") {
                    error_msg += "Please Select Mental Toughness. \n";
                }
                if(trimString(document.rating.fldComposure.value) == "0") {
                    error_msg += "Please Select Composure. \n";
                }
                if(trimString(document.rating.fldAwareness.value) == "0") {
                    error_msg += "Please Select Awareness. \n";
                }
                if(trimString(document.rating.fldInstincts.value) == "0") {
                    error_msg += "Please Select Instincts. \n";
                }
                if(trimString(document.rating.fldVision.value) == "0") {
                    error_msg += "Please Select Vision. \n";
                }
                if(trimString(document.rating.fldConditioning.value) == "0") {
                    error_msg += "Please Select Conditioning. \n";
                }
                if(trimString(document.rating.fldPhysical_Toughness.value) == "0") {
                    error_msg += "Please Select Physical Toughness. \n";
                }
                if(trimString(document.rating.fldTenacity.value) == "0") {
                    error_msg += "Please Select Tenacity. \n";
                }
                if(trimString(document.rating.fldHustle.value) == "0") {
                    error_msg += "Please Select Hustle. \n";
                }
                if(trimString(document.rating.fldStrength.value) == "0") {
                    error_msg += "Please Select Strength. \n";
                }
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            }
		</script>
		
		
		<!-- Demo page css --> 
    <link rel="stylesheet" type="text/css" media="screen" href="css/demos.css?b38"/>
    <style type="text/css"> 
        .caption {
            padding: 2px 0 0 .5em;
            float: left;
            line-height: 1em;
        } 
    </style>

    <!-- Uni-Form style sheet --> 
    <style type="text/css" media="screen"> 
        @import "css/uni-form.css?b38"; 
    </style>
    <!--[if lte ie 7]>
    <style type="text/css" media="screen">
        .uniForm, .uniForm fieldset, .uniForm .ctrlHolder, .uniForm .formHint, .uniForm .buttonHolder, .uniForm .ctrlHolder .multiField, .uniForm .inlineLabel{ zoom:1; }
        .uniForm .inlineLabels label, .uniForm .inlineLabels .label, .uniForm .blockLabels label, .uniForm .blockLabels .label, .uniForm .inlineLabel span{ padding-bottom: .2em; }
        .uniForm .inlineLabel input, .uniForm .inlineLabels .inlineLabel input, .uniForm .blockLabels .inlineLabel input{ margin-top: -.3em; }
    </style>
    <![endif]-->

    <!-- Demo page js -->
    <script type="text/javascript" src="js/jquery.min.js?v=1.4.2"></script>
    <script type="text/javascript" src="js/jquery-ui.custom.min.js?v=1.8"></script>
    <script type="text/javascript" src="js/jquery.uni-form.js?v=1.3"></script>
    
    <!-- Star Rating widget stuff here... -->
    <script type="text/javascript" src="js/jquery.ui.stars.js?v=3.0.0b38"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.ui.stars.css?v=3.0.0b38"/>
    
    <?php  if(($HSCoachhasvoted==0) and ($IsHSCoach==1) and ($_REQUEST['mode'] != 'view') ){
    ?>
    <script type="text/javascript">
        $(function(){
            var $caption, $cap = $("<span/>").addClass("caption");
            // Hide all elements (it's possible to create Stars from hidden elements too)   

            //#1-LeaderShip
            $caption = $cap.clone();
            $("#LeaderShip")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#2-WorkEthic
            $caption = $cap.clone();
            $("#WorkEthic")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#3-Primacy
            $caption = $cap.clone();
            $("#Primacy")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#4-MentalToughness
            $caption = $cap.clone();
            $("#MentalToughness")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#5-Composure
            $caption = $cap.clone();
            $("#Composure")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#6-Awareness
            $caption = $cap.clone();
            $("#Awareness")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#7-Instincts
            $caption = $cap.clone();
            $("#Instincts")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#8-Vision
            $caption = $cap.clone();
            $("#Vision")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#9-Conditioning
            $caption = $cap.clone();
            $("#Conditioning")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#10-PhysicalToughness
            $caption = $cap.clone();
            $("#PhysicalToughness")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#11-Tenacity
            $caption = $cap.clone();
            $("#Tenacity")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#12-Hustle
            $caption = $cap.clone();
            $("#Hustle")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);
            //#13-Strength
            $caption = $cap.clone();
            $("#Strength")
                .stars({
                    inputType: "select",
                    cancelValue: 0,
                    cancelShow: true,
                    captionEl: $caption
                })
                .append($caption);                
        });
    </script>
    <?php  
    ##// End jQuery Display Rate Athlete##    
    }

    ### jQuery DISPLAY RATINGS ###
    if(($AthleteHasRatings==1) and ($IsHSCoach==1 || $IsCollegeCoach==1) and ($_REQUEST['mode'] == 'view') ){
        $info_query="select fldAthlete_id, ROUND(avg(fldLeaderShip), 1) as fldLeaderShip,
        ROUND(avg(fldWork_Ethic), 1) as fldWork_Ethic,
        ROUND(avg(fldPrimacy_Go_To_Guy), 1) as fldPrimacy_Go_To_Guy,
        ROUND(avg(fldMental_Toughness), 1) as fldMental_Toughness,
        ROUND(avg(fldComposure), 1) as fldComposure,
        ROUND(avg(fldAwareness), 1) as fldAwareness,
        ROUND(a