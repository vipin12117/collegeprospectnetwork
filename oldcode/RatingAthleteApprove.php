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
	
	/*if($mode == "approve")
	{
	
		$Id = $_REQUEST['fldId'];
		$active_query_details = "update " . TBL_NETWORK . " set fldStatus = 'Active' where fldId='" . $Id . "'";
		$activemsg = $db -> query($active_query_details);
		if (isset($activemsg) && $activemsg == 1) {
		    $msg = 'ApproveSuccess';
			header("Location:RatingAthleteApproval.php?fldId=" . $_REQUEST['fldId'] . "&fldAthleteID=".$_REQUEST['fldAthleteID']."&mode=approveSuccess&msg=$msg");
	 }*/
		
	//}
    //Check if Athlete has Ratings
     $whereClause1 = "fldAthlete_id=" . $_REQUEST['fldAthleteID'];    
	
     if ($db -> MatchingRec(TBL_RATING, $whereClause1) > 0) {
            $AthleteHasRatings = 1;
        }
   
    //Detect if College Coach, display raitings if Athlete has ratings
   /* if ($_SESSION['mode'] == 'college') {
        $IsCollegeCoach = 1;           
    }*/
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
			//print_r($starr);
            $db -> insertRec(TBL_RATING, $starr);
            //$msg = 'Rating successfully added.  <a href="javascript:refreshParent();">Close Window</a>';
			
			/*if ($_REQUEST["mode"] == "active") {
				$Id = $_REQUEST['Id'];
				$active_query_details = "update " . TBL_NETWORK . " set fldStatus = 'Active' where fldId='" . $Id . "'";
				$activemsg = $db -> query($active_query_details);
				if (isset($activemsg)) {
					//$_REQUEST['msg'] = "Network Request Aapproved. User has been sent a nofication.";
				}
				//Send Email
			}*/
			
			$func -> getAverageRating($_REQUEST['fldAthleteID']);
            $msg = 'Rating Successfully!';?>
			<script type="text/javascript">
			alert("<?php echo $msg; ?>");
			window.opener.location.reload(true);self.close();
			/*window.parent.location.href=window.parent.location.href;*/
			</script>
			<?php 
exit;			/*header("Location:RatingAthleteApprove.php?fldAthleteID=".$_REQUEST['fldAthleteID']."&mode=view&msg=$msg");*/
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
        ROUND(avg(fldInstincts), 1) as fldInstincts,
        ROUND(avg(fldVision), 1) as fldVision,
        ROUND(avg(fldConditioning), 1) as fldConditioning,
        ROUND(avg(fldPhysical_Toughness), 1) as fldPhysical_Toughness,
        ROUND(avg(fldTenacity), 1) as fldTenacity,
        ROUND(avg(fldHustle), 1) as fldHustle,
        ROUND(avg(fldStrength), 1) as fldStrength from ".TBL_RATING." where fldAthlete_id=".$_REQUEST['fldAthleteID'];
        $db2->query($info_query);
        $db2->next_record();
        $query_number="select * FROM tbl_rating where fldAthlete_id=".$_REQUEST['fldAthleteID'];
        $db3->query($query_number);
        $db3->next_record();   
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
                    cancelShow: false,
                    captionEl: $caption          
                })
                .append($caption);
                $("#LeaderShip").stars("select", <?php  echo round($db2 -> f('fldLeaderShip'));?>);
             
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
                $("#WorkEthic").stars("select", <?php  echo round($db2 -> f('fldWork_Ethic'));?>);
                
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
                $("#Primacy").stars("select", <?php  echo round($db2 -> f('fldPrimacy_Go_To_Guy'));?>);
                
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
                $("#MentalToughness").stars("select", <?php  echo round($db2 -> f('fldMental_Toughness'));?>);
                
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
                $("#Composure").stars("select", <?php  echo round($db2 -> f('fldComposure'));?>);
                
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
                $("#Awareness").stars("select", <?php  echo round($db2 -> f('fldAwareness'));?>);
                
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
                $("#Instincts").stars("select", <?php  echo round($db2 -> f('fldInstincts'));?>);
                
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
                $("#Vision").stars("select", <?php  echo round($db2 -> f('fldVision'));?>);
                
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
                $("#Conditioning").stars("select", <?php  echo round($db2 -> f('fldConditioning'));?>);
                
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
                $("#PhysicalToughness").stars("select", <?php  echo round($db2 -> f('fldPhysical_Toughness'));?>);
                
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
                $("#Tenacity").stars("select", <?php  echo round($db2 -> f('fldTenacity'));?>);
                
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
                $("#Hustle").stars("select", <?php  echo round($db2 -> f('fldHustle'));?>);
                
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
                $("#Strength").stars("select", <?php  echo round($db2 -> f('fldStrength'));?>);
                               
        });
    </script>
    <?php
    }
    ?>
	</head>
	<body>
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">							
							<div class="registerPage smallest">				
								<?php  if(($HSCoachhasvoted==0) and ($IsHSCoach==1) and ($_REQUEST['mode'] != 'view') ){
							    #### START -  RATE ATHLETE #####
                                //$IsCollegeCoach= 0; //If is College Coach
                                //$IsHSCoach = 0;  //If is HS Coach
                                //$HSCoachhasvoted = 0; //If HS Coach Voted
                                //$AthleteHasRatings = 0; //If Athlete has Ratings
								?>
								<h1>Rate Athlete</h1>
								<form action="" method="post" name="rating" onsubmit="return validate()" class="searchform">
            								 <input type="hidden" id="mode" name="mode" value="<?php echo $mode;?>" />
											 <input type="hidden" id="Id" name="Id" value="<?php echo $_REQUEST['fldId'];?>" />   
                				<p>
                                    <label>Leadership:</label>                     
                                    <span class="multiField" id="LeaderShip">     
                                        <select name="fldLeaderShip">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Work Ethic:</label>                     
                                    <span class="multiField" id="WorkEthic">     
                                        <select name="fldWork_Ethic">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Primacy (Go-To Guy):</label>                     
                                    <span class="multiField" id="Primacy">     
                                        <select name="fldPrimacy_Go_To_Guy">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Mental Toughness:</label>                     
                                    <span class="multiField" id="MentalToughness">     
                                        <select name="fldMental_Toughness">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Composure:</label>                     
                                    <span class="multiField" id="Composure">     
                                        <select name="fldComposure">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Awareness:</label>                     
                                    <span class="multiField" id="Awareness">     
                                        <select name="fldAwareness">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Instincts:</label>                     
                                    <span class="multiField" id="Instincts">     
                                        <select name="fldInstincts">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Vision:</label>                     
                                    <span class="multiField" id="Vision">     
                                        <select name="fldVision">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Conditioning:</label>                     
                                    <span class="multiField" id="Conditioning">     
                                        <select name="fldConditioning">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Physical Toughness:</label>                     
                                    <span class="multiField" id="PhysicalToughness">     
                                        <select name="fldPhysical_Toughness">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Tenacity:</label>                     
                                    <span class="multiField" id="Tenacity">     
                                        <select name="fldTenacity">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Hustle:</label>                     
                                    <span class="multiField" id="Hustle">     
                                        <select name="fldHustle">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Strength:</label>                     
                                    <span class="multiField" id="Strength">     
                                        <select name="fldStrength">
                                            <option value="0">Reset Rating</option>
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
            
                               <p style="height:20px;">&nbsp;</p>
            						<input type="hidden" name="save" size="40" value="save">
            						<p>
            							<label>&nbsp;</label>
            							<span>
            								<button type="submit">
            									Submit Rating
            								</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    					</form>
                    					<button type=submit onclick="javascript:refreshParent();">
                    						Close Window
                    					</button>
            					   </span>
            					</p>
						
								<?php  
								    #### END - RATE ATHLETE ####
                                    } 

                                  if(($AthleteHasRatings==1) and ($IsHSCoach==1 || $IsCollegeCoach==1) and ($_REQUEST['mode'] == 'view') ){
                                    #### START -  SHOW ATHLETE RATING #####                                    
                                    //$IsCollegeCoach= 0; //If is College Coach
                                    //$IsHSCoach = 0;  //If is HS Coach
                                    //$HSCoachhasvoted = 0; //If HS Coach Voted
                                    //$AthleteHasRatings = 0; //If Athlete has Ratings                                   
      
                                     #### START -  SHOW ATHLETE RATING #####
                                    // $info_query="select fldAthlete_id, ROUND(avg(fldLeaderShip), 1) as fldLeaderShip,
                                    // ROUND(avg(fldWork_Ethic), 1) as fldWork_Ethic,
                                    // ROUND(avg(fldPrimacy_Go_To_Guy), 1) as fldPrimacy_Go_To_Guy,
                                    // ROUND(avg(fldMental_Toughness), 1) as fldMental_Toughness,
                                    // ROUND(avg(fldComposure), 1) as fldComposure,
                                    // ROUND(avg(fldAwareness), 1) as fldAwareness,
                                    // ROUND(avg(fldInstincts), 1) as fldInstincts,
                                    // ROUND(avg(fldVision), 1) as fldVision,
                                    // ROUND(avg(fldConditioning), 1) as fldConditioning,
                                    // ROUND(avg(fldPhysical_Toughness), 1) as fldPhysical_Toughness,
                                    // ROUND(avg(fldTenacity), 1) as fldTenacity,
                                    // ROUND(avg(fldHustle), 1) as fldHustle,
                                    // ROUND(avg(fldStrength), 1) as fldStrength from ".TBL_RATING." where fldAthlete_id=".$_REQUEST['fldId'];
                                    // $db2->query($info_query);
                                    // $db2->next_record();
                                    // $query_number="select * FROM tbl_rating where fldAthlete_id=".$_REQUEST['fldId'];
                                    // $db3->query($query_number);
                                    // $db3->next_record();
								?>
								    <h1>Athlete Ratings</h1>
								
    								<?php
                                    if($_REQUEST['msg'] == 'Success')
                                    {
    								?>
    								<div class="thankyoumessage">Thank you, your Rating was successfully added.  <a href="javascript:refreshParent();">Close Window</a></div>									
    								<?php  
    								}
    								?>
									
    								<p>
                                        <label>&nbsp;</label>
                                        <span style="line-height:26px;font-size:12px;"><b>Average Rating</b> (<?php  echo $db3 -> num_rows() . " ";  echo ($db3 -> num_rows() > 1 ?  "votes" : "vote");  ?>)</span>
                                    </p>

    								<p>
                                        <label>Leadership:</label>                     
                                        <span class="multiField" id="LeaderShip">
                                            <select name="fldLeaderShip" disabled="disabled">                                               
                                                <?php
                                                for ($i=1;$i<=10;$i++)
                                                {
                                                ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                                }
                                                ?>
                                            </select>
                                        </span>                  
                                    </p>							    								
    								<p>
                                    <label>Work Ethic:</label>                     
                                    <span class="multiField" id="WorkEthic">     
                                        <select name="fldWork_Ethic" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Primacy (Go-To Guy):</label>                     
                                    <span class="multiField" id="Primacy">     
                                        <select name="fldPrimacy_Go_To_Guy" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Mental Toughness:</label>                     
                                    <span class="multiField" id="MentalToughness">     
                                        <select name="fldMental_Toughness" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Composure:</label>                     
                                    <span class="multiField" id="Composure">     
                                        <select name="fldComposure" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Awareness:</label>                     
                                    <span class="multiField" id="Awareness">     
                                        <select name="fldAwareness" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Instincts:</label>                     
                                    <span class="multiField" id="Instincts">     
                                        <select name="fldInstincts" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Vision:</label>                     
                                    <span class="multiField" id="Vision">     
                                        <select name="fldVision" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Conditioning:</label>                     
                                    <span class="multiField" id="Conditioning">     
                                        <select name="fldConditioning" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Physical Toughness:</label>                     
                                    <span class="multiField" id="PhysicalToughness">     
                                        <select name="fldPhysical_Toughness" disabled="disabled">
                                           <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Tenacity:</label>                     
                                    <span class="multiField" id="Tenacity">     
                                        <select name="fldTenacity" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Hustle:</label>                     
                                    <span class="multiField" id="Hustle">     
                                        <select name="fldHustle" disabled="disabled">
                                            <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>
                                <p>
                                    <label>Strength:</label>                     
                                    <span class="multiField" id="Strength">     
                                        <select name="fldStrength" disabled="disabled">
                                           <?php
                                            for ($i=1;$i<=10;$i++)
                                            {
                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </span>                  
                                </p>			
    								<p style="padding-top:10px;">
    									<label>&nbsp;</label>
    									<span>
    										<button type="submit" onclick="javascript:refreshParent();" class="normalbtn">Close Window</button>
    									</span>
																	<?php /*?>	<span>
    										<button type="submit"onclick="javascript:approveRequest('<?php echo $_REQUEST['fldId'];?>','approve','<?php echo $_REQUEST['fldAthleteID'];?>');" class="normalbtn">Approve</button>
    									</span><?php */?>
    	
    								</p>
								<?php
								        ##End Display Rating
								     }

                                    else if(($AthleteHasRatings==0) and ($IsHSCoach==1 || $IsCollegeCoach==1) and ($_REQUEST['mode'] == 'view') ){
                                    #### START -  SHOW NO RATINGS AVAILABLE#####                                    
                                    //$IsCollegeCoach= 0; //If is College Coach
                                    //$IsHSCoach = 0;  //If is HS Coach
                                    //$HSCoachhasvoted = 0; //If HS Coach Voted
                                    //$AthleteHasRatings = 0; //If Athlete has Ratings     
                             
                                        ##Display Error if cannot retrieve Athlete Rating
								    ?>
    								<div class="thankyoumessage">
    									<?php echo "Athlete has not yet been rated.";?>
    								</div>
    								<p>
    									<label>&nbsp;</label>
    									<span>
    									    <?php
    									      #echo $IsCollegeCoach . "<br />";
                                              #echo $IsHSCoach . "<br />";
                                              #echo $HSCoachhasvoted . "<br />";
                                             #echo $AthleteHasRatings . "<br />";    									    
    									    ?>
    										<button type="submit"onclick="javascript:refreshParent();" class="normalbtn">Close Window</button>
    									</span>
    								</p>
    							<?php
    							     ##End Display No Ratings Available
                                }

                                else if (($IsAthlete == 1) and ($IsHSCoach==0) and ($IsCollegeCoach==0) ) {                                    
                                     #### START -  SHOW NO PERMISSION#####  
    							?>
    							<div class="thankyoumessage">
                                        <?php echo "Sorry, Athletes cannot view fellow Athlete Ratings";?>
                                    </div>
                                    <p>
                                        <label>&nbsp;</label>
                                        <span>
                                            <button type="submit"onclick="javascript:refreshParent();" class="normalbtn">Close Window</button>
                                        </span>
                                    </p>
    							<?php
    							 ##End Display No Permission
                                }        
                                       
                                else if (($HSCoachhasvoted==1) and ($IsHSCoach==1) and ($_REQUEST['mode'] != 'view')  ) {                                    
                                     #### START -  SHOW NO PERMISSION#####  
                                ?>
                                <div class="thankyoumessage">
								
								<?php
                                    if($_REQUEST['msg'] == 'ApproveSuccess')
                                    {
    									echo 'Thank you,request succesfully accepted by you.  <a href="javascript:refreshParent();">Close Window</a>';  
    								}
    								else
									{
                                        $viewLink = "RatingAthleteApproval.php?fldId=" . $_REQUEST['fldId'] . "&fldAthleteID=".$_REQUEST['fldAthleteID']. "&mode=view";
                                        echo "Sorry, you have already voted for this Athlete.  Please <a href='$viewLink'>Click Here</a> to view Ratings";
										}
                                        ?>
                                    </div>
                                    <p>
                                        <label>&nbsp;</label>
                                        <span>
                                            <button type="submit"onclick="javascript:refreshParent();" class="normalbtn">Close Window</button>
                                        </span>
                                    </p>
                                <?php
                                 ##End Display No Permission
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