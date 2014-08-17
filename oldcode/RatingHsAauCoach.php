<?php      session_start();    include_once ("inc/common_functions.php");    //for common function    include_once ("inc/page.inc.php");    include_once ("inc/config.inc.php");    //for paging    $func = new COMMONFUNC;    $db = new DB;        //Set Default Vars    $IsCollegeCoach= 0; //If is College Coach    $IsHSCoach = 0; //If is HS Coach    $CollegeCoachhasvoted = 0; //If College Coach has Voted    $HSCoachHasRatings = 0; //If HS Coach has Rating    $IsAthlete = 0; //If is Athlete    $college_coach_id = 0;        //Detect if athlete, display Permission Error if true    if ($_SESSION['mode'] == 'college') {        $IsCollegeCoach = 1;    }        //Check if Athlete has Ratings    $whereClause1 = "fldHs_Aau_Coach_id=" . $_REQUEST['fldId'];         if ($db -> MatchingRec(TBL_HS_AAU_COACH_RATE, $whereClause1) > 0) {            $HSCoachHasRatings = 1;        }        //Detect if College Coach, display raitings if Athlete has ratings    if ($_SESSION['mode'] == 'coach') {        $IsHSCoach = 1;               }        #Detect if College Coach, get Data    //tbl_college_coach_register    if ($_SESSION['mode'] == 'college') {        $IsCollegeCoach = 1;        $coach_query = "select * from " . TBL_COLLEGE_COACH_REGISTER . " where fldUserName ='" . $_SESSION['FRONTEND_USER'] . "'";        $db1 -> query($coach_query);        $db1 -> next_record();        $college_coach_id = $db1 -> f('fldId');        //detect if College Coach has rated this HS Coach        $whereClause = "fldHs_Aau_Coach_id=" . $_REQUEST['fldId'] . " and fld_College_Coach_id=" . $college_coach_id;        if ($db -> MatchingRec(TBL_HS_AAU_COACH_RATE, $whereClause) > 0) {            $CollegeCoachhasvoted = 1;        }                else {            $CollegeCoachhasvoted = 0;        }    }        if ($_POST['save'] == 'debug') {            $buff[] = 'Response from server: ';            if(count($_POST))            {                //AthleteID                $buff[] = $_REQUEST['fldId'];                //Coach ID                $buff[] = $college_coach_id;                //Form Values - stars                $buff[] = $_POST['fldAthlete_contribue'];                $buff[] =  $_POST['fldComunication'];                $buff[] =  $_POST['fldRequest_Game_Tape'];                $buff[] =  $_POST['fldHonest'];                $buff[] =  $_POST['fldPrepration'];                           //Date                $buff[] =  date("y-m-d");                //$buff[] = '<pre style="text-align:left">'.print_r($_POST, true).'</pre>';            }            else            {                $buff[] = 'No POST data';            }            //$buff[] = $_SERVER['HTTP_X_REQUESTED_WITH'] ? 'This is AJAX request' : 'This is POST request<br><a href="javascript:history.back();">&laquo; Back</a>';            echo implode('<br>', $buff);        //header("Location:RatingAthlete.php?fldId=" . $_REQUEST['fldId'] . "&msg=$buff");           }       if ($_POST['save'] == 'save') {        if ($IsCollegeCoach == 1) {            $starr = array(                    'fldHs_Aau_Coach_id' => $_REQUEST['fldId'],                    'fld_College_Coach_id' => $college_coach_id,                    'fldAthlete_contribue' => $_POST['fldAthlete_contribue'],                    'fldComunication' => $_POST['fldComunication'],                    'fldRequest_Game_Tape' => $_POST['fldRequest_Game_Tape'],                    'fldHonest' => $_POST['fldHonest'],                    'fldPrepration' => $_POST['fldPrepration'],                    'fldAddDate' => date("y-m-d")            );            $db -> insertRec(TBL_HS_AAU_COACH_RATE, $starr);            //$msg = 'Rating successfully added.  <a href="javascript:refreshParent();">Close Window</a>';            $msg = 'Success';            header("Location:RatingHsAauCoach.php?fldId=" . $_REQUEST['fldId'] . "&mode=view&msg=$msg");        }    }?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">    <head>        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <title>College Prospect Network - HS/AAU Coach Rating</title>        <META NAME="Keywords" CONTENT="My Account">        <META NAME="Description" CONTENT="My Account">        <link href="css/style.css" rel="stylesheet" type="text/css" />        <script language="Javascript" src="javascript/functions.js"></script>        <script language="JavaScript" type="text/JavaScript">                 function refreshParent() {                window.opener.location.href = window.opener.location.href;                if(window.opener.progressWindow) {                    window.opener.progressWindow.close()                }                window.close();            }                        function validate() {                var error_msg = "";                if(trimString(document.rating.fldAthlete_contribue.value) == "0") {                    error_msg += "Please Select #1. Accuracy value. \n";                }                if(trimString(document.rating.fldComunication.value) == "0") {                    error_msg += "Please Select #2. Communication value. \n";                }                if(trimString(document.rating.fldRequest_Game_Tape.value) == "0") {                    error_msg += "Please Select #3. Game Tape Request value. \n";                }                if(trimString(document.rating.fldHonest.value) == "0") {                    error_msg += "Please Select #4. Honesty value. \n";                }                if(trimString(document.rating.fldPrepration.value) == "0") {                    error_msg += "Please Select #5. Preparation value. \n";                }                if(error_msg != '') {                    alert(error_msg);                    return false;                } else {                    return true;                }            }        </script>                        <!-- Demo page css -->     <link rel="stylesheet" type="text/css" media="screen" href="css/demos.css?b38"/>    <style type="text/css">         .caption {            padding: 2px 0 0 .5em;            float: left;            line-height: 1em;        }     </style>    <!-- Uni-Form style sheet -->     <style type="text/css" media="screen">         @import "css/uni-form.css?b38";     </style>    <!--[if lte ie 7]>    <style type="text/css" media="screen">        .uniForm, .uniForm fieldset, .uniForm .ctrlHolder, .uniForm .formHint, .uniForm .buttonHolder, .uniForm .ctrlHolder .multiField, .uniForm .inlineLabel{ zoom:1; }        .uniForm .inlineLabels label, .uniForm .inlineLabels .label, .uniForm .blockLabels label, .uniForm .blockLabels .label, .uniForm .inlineLabel span{ padding-bottom: .2em; }        .uniForm .inlineLabel input, .uniForm .inlineLabels .inlineLabel input, .uniForm .blockLabels .inlineLabel input{ margin-top: -.3em; }    </style>    <![endif]-->    <!-- Demo page js -->    <script type="text/javascript" src="js/jquery.min.js?v=1.4.2"></script>    <script type="text/javascript" src="js/jquery-ui.custom.min.js?v=1.8"></script>    <script type="text/javascript" src="js/jquery.uni-form.js?v=1.3"></script>        <!-- Star Rating widget stuff here... -->    <script type="text/javascript" src="js/jquery.ui.stars.js?v=3.0.0b38"></script>    <link rel="stylesheet" type="text/css" href="css/jquery.ui.stars.css?v=3.0.0b38"/>        <?php  if(($CollegeCoachhasvoted==0) and ($IsCollegeCoach==1) and ($_REQUEST['mode'] != 'view') ){    ?>    <script type="text/javascript">        $(function(){            var $caption, $cap = $("<span/>").addClass("caption");            // Hide all elements (it's possible to create Stars from hidden elements too)               //#1-fldAthlete_contribue            $caption = $cap.clone();            $("#fldAthlete_contribue")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);            //#2-fldComunication            $caption = $cap.clone();            $("#fldComunication")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);            //#3-fldRequest_Game_Tape            $caption = $cap.clone();            $("#fldRequest_Game_Tape")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);            //#4-fldHonest            $caption = $cap.clone();            $("#fldHonest")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);            //#5-fldPrepration            $caption = $cap.clone();            $("#fldPrepration")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);                                  });    </script>    <?php      ##// End jQuery Display Rate Athlete##        }    ### jQuery DISPLAY RATINGS ###    // $IsCollegeCoach= 0; //If is College Coach    // $IsHSCoach = 0; //If is HS Coach    // $CollegeCoachhasvoted = 0; //If College Coach has Voted    // $HSCoachHasRatings = 0; //If HS Coach has Rating    // $IsAthlete = 0; //If is Athlete    if(($HSCoachHasRatings==1) and ($IsCollegeCoach==1 || $IsHSCoach==1) and ($_REQUEST['mode'] == 'view') ){        $info_query="select fldHs_Aau_Coach_id, ROUND(avg(fldAthlete_contribue), 1) as fldAthlete_contribue,        ROUND(avg(fldComunication), 1) as fldComunication,        ROUND(avg(fldRequest_Game_Tape), 1) as fldRequest_Game_Tape,        ROUND(avg(fldHonest), 1) as fldHonest,        ROUND(avg(fldPrepration), 1) as fldPrepration from ".TBL_HS_AAU_COACH_RATE." where fldHs_Aau_Coach_id=".$_REQUEST['fldId'];        $db2->query($info_query);        $db2->next_record();        $query_number="select * FROM tbl_hs_aau_coach_rate where fldHs_Aau_Coach_id=".$_REQUEST['fldId'];        $db3->query($query_number);        $db3->next_record();       ?>        <script type="text/javascript">        $(function(){            var $caption, $cap = $("<span/>").addClass("caption");            // Hide all elements (it's possible to create Stars from hidden elements too)                           //#1-fldAthlete_contribue            $caption = $cap.clone();            $("#fldAthlete_contribue")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);                $("#fldAthlete_contribue").stars("select", <?php  echo round($db2 -> f('fldAthlete_contribue'));?>);                            //#2-fldComunication            $caption = $cap.clone();            $("#fldComunication")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);                $("#fldComunication").stars("select", <?php  echo round($db2 -> f('fldComunication'));?>);                            //#3-fldRequest_Game_Tape            $caption = $cap.clone();            $("#fldRequest_Game_Tape")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);                $("#fldRequest_Game_Tape").stars("select", <?php  echo round($db2 -> f('fldRequest_Game_Tape'));?>);                            //#4-fldHonest            $caption = $cap.clone();            $("#fldHonest")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);                $("#fldHonest").stars("select", <?php  echo round($db2 -> f('fldHonest'));?>);                            //#5-fldPrepration            $caption = $cap.clone();            $("#fldPrepration")                .stars({                    inputType: "select",                    cancelValue: 0,                    cancelShow: true,                    captionEl: $caption                })                .append($caption);                 $("#fldPrepration").stars("select", <?php  echo round($db2 -> f('fldPrepration'));?>);                                       });    </script>    <?php    }    ?>    </head>    <body>        <!--middle panel starts from here -->        <!--content panel starts from here -->        <div class="container">            <div class="innerWraper">                <div class="middle-bg">                    <div class="cantener">                        <div class="register-main">                                                     <div class="registerPage smallest">                                             <?php  if(($CollegeCoachhasvoted==0) and ($IsCollegeCoach==1) and ($_REQUEST['mode'] != 'view') ){                                #### START -  RATE HS/AAU COACH #####                                // $IsCollegeCoach= 0; //If is College Coach
                                // $IsHSCoach = 0; //If is HS Coach
                                // $CollegeCoachhasvoted = 0; //If College Coach has Voted
                                // $HSCoachHasRatings = 0; //If HS Coach has Rating
                                // $IsAthlete = 0; //If is Athlete                                ?>                                <h1>Rate HS/AAU Coach</h1>                                <form action="" method="post" name="rating" onsubmit="return validate()" class="searchform">                                                                <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How accurate was this coach in projecting the level at which the athlete can contribute?</label></p>                                                <p style="height:40px;">                                                                                           <span class="multiField" id="fldAthlete_contribue">                                             <select name="fldAthlete_contribue">                                            <option value="0">Reset Rating</option>                                            <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                                <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How prompt was this coach in responding to your communications?</label></p>                                  <p style="height:40px;">                                                   <span class="multiField" id="fldComunication">                                             <select name="fldComunication">                                            <option value="0">Reset Rating</option>                                            <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                                <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How prompt was this coach in responding to your requests for game tape? </label></p>                                 <p style="height:40px;">                                                     <span class="multiField" id="fldRequest_Game_Tape">                                             <select name="fldRequest_Game_Tape">                                            <option value="0">Reset Rating</option>                                            <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                                <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How honest was the coach in your interactions with him/her?</label></p>                                 <p style="height:40px;">                                                 <span class="multiField" id="fldHonest">                                             <select name="fldHonest">                                            <option value="0">Reset Rating</option>                                            <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                               <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How well does this coach prepare his/her athlete's for college sports? </label></p>                                 <p style="height:40px;">                                                                     <span class="multiField" id="fldPrepration">                                             <select name="fldPrepration">                                            <option value="0">Reset Rating</option>                                            <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?><?php echo ($i == 1 ?  " (Lowest)" : ""); echo ($i == 10 ?  " (Highest)" : ""); ?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                                          <p style="height:15px;">&nbsp;</p>                                    <input type="hidden" name="save" size="40" value="save">                                    <p>                                        <label>&nbsp;</label>                                        <span>                                            <button type="submit">                                                Submit Rating                                            </button>&nbsp;&nbsp;&nbsp;&nbsp;                                        </form>                                        <button type=submit onclick="javascript:refreshParent();">                                            Close Window                                        </button>                                   </span>                                </p>                                                        <?php                                      #### END - RATE ATHLETE ####                                    }                                   if(($HSCoachHasRatings==1) and ($IsCollegeCoach==1 || $IsHSCoach==1) and ($_REQUEST['mode'] == 'view') ){                                    #### START -  SHOW HS/AAU RATING #####                                                                        // $IsCollegeCoach= 0; //If is College Coach                                    // $IsHSCoach = 0; //If is HS Coach                                    // $CollegeCoachhasvoted = 0; //If College Coach has Voted                                    // $HSCoachHasRatings = 0; //If HS Coach has Rating                                    // $IsAthlete = 0; //If is Athlete                                                                         #### START -  SHOW ATHLETE RATING #####                                    // $info_query="select fldAthlete_id, ROUND(avg(fldLeaderShip), 1) as fldLeaderShip,                                    // ROUND(avg(fldWork_Ethic), 1) as fldWork_Ethic,                                    // ROUND(avg(fldPrimacy_Go_To_Guy), 1) as fldPrimacy_Go_To_Guy,                                    // ROUND(avg(fldMental_Toughness), 1) as fldMental_Toughness,                                    // ROUND(avg(fldComposure), 1) as fldComposure,                                    // ROUND(avg(fldAwareness), 1) as fldAwareness,                                    // ROUND(avg(fldInstincts), 1) as fldInstincts,                                    // ROUND(avg(fldVision), 1) as fldVision,                                    // ROUND(avg(fldConditioning), 1) as fldConditioning,                                    // ROUND(avg(fldPhysical_Toughness), 1) as fldPhysical_Toughness,                                    // ROUND(avg(fldTenacity), 1) as fldTenacity,                                    // ROUND(avg(fldHustle), 1) as fldHustle,                                    // ROUND(avg(fldStrength), 1) as fldStrength from ".TBL_RATING." where fldAthlete_id=".$_REQUEST['fldId'];                                    // $db2->query($info_query);                                    // $db2->next_record();                                    // $query_number="select * FROM tbl_rating where fldAthlete_id=".$_REQUEST['fldId'];                                    // $db3->query($query_number);                                    // $db3->next_record();                                ?>                                    <h1>HS/AAU Ratings</h1>                                                                    <?php                                    if($_REQUEST['msg'] == 'Success')                                    {                                    ?>                                    <div class="thankyoumessage">Thank you, your Rating was successfully added.  <a href="javascript:refreshParent();">Close Window</a></div>                                                                       <?php                                      }                                    ?>                                                                                                       <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;"><b>Average Rating</b> (<?php  echo $db3 -> num_rows() . " ";  echo ($db3 -> num_rows() > 1 ?  "votes" : "vote");  ?>)</label></p>                                      <hr class="smallgap" style="margin-bottom:20px;width:500px;">                                <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How accurate was this coach in projecting the level at which the athlete can contribute?</label></p>                                                <p style="height:40px;">                                                                                           <span class="multiField" id="fldAthlete_contribue">                                             <select name="fldAthlete_contribue" disabled="disabled">                                                                           <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                                <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How prompt was this coach in responding to your communications?</label></p>                                  <p style="height:40px;">                                                   <span class="multiField" id="fldComunication">                                             <select name="fldComunication" disabled="disabled">                                                                           <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                                <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How prompt was this coach in responding to your requests for game tape? </label></p>                                 <p style="height:40px;">                                                     <span class="multiField" id="fldRequest_Game_Tape">                                             <select name="fldRequest_Game_Tape" disabled="disabled">                                                                                  <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                                <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How honest was the coach in your interactions with him/her?</label></p>                                 <p style="height:40px;">                                                 <span class="multiField" id="fldHonest">                                             <select name="fldHonest" disabled="disabled">                                                                                   <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                               <p style="margin-bottom:0px !important;line-height:normal;"><label style="width:500px;text-align:left;line-height:normal;">How well does this coach prepare his/her athlete's for college sports? </label></p>                                 <p style="height:40px;">                                                                     <span class="multiField" id="fldPrepration">                                             <select name="fldPrepration" disabled="disabled">                                                                                <?php                                            for ($i=1;$i<=10;$i++)                                            {                                            ?><option value ="<?php  echo $i;?>" ><?php  echo $i;?></option><?php                                            }                                            ?>                                        </select>                                    </span>                                                  </p>                                                              <p style="padding-top:10px;">                                        <label>&nbsp;</label>                                        <span>                                            <button type="submit"onclick="javascript:refreshParent();" class="normalbtn">Close Window</button>                                        </span>                                    </p>                                <?php                                        ##End Display Rating                                     }                                    else if(($HSCoachHasRatings==0) and ($IsCollegeCoach==1 || $IsHSCoach==1) and ($_REQUEST['mode'] == 'view') ){                                    #### START -  SHOW NO RATINGS AVAILABLE#####                                                                        // $IsCollegeCoach= 0; //If is College Coach                                    // $IsHSCoach = 0; //If is HS Coach                                    // $CollegeCoachhasvoted = 0; //If College Coach has Voted                                    // $HSCoachHasRatings = 0; //If HS Coach has Rating                                    // $IsAthlete = 0; //If is Athlete                                                                          ##Display Error if cannot retrieve Athlete Rating                                    ?>                                    <div class="thankyoumessage">                                        <?php echo "HS/AAU Coach has not yet been rated.";?>                                    </div>                                    <p>                                        <label>&nbsp;</label>                                        <span>                                            <?php                                              #echo $IsCollegeCoach . "<br />";                                              #echo $IsHSCoach . "<br />";                                              #echo $HSCoachhasvoted . "<br />";                                             #echo $AthleteHasRatings . "<br />";                                                                                       ?>                                            <button type="submit"onclick="javascript:refreshParent();" class="normalbtn">Close Window</button>                                        </span>                                    </p>                                <?php                                     ##End Display No Ratings Available                                }                                else if (($IsAthlete == 0) and ($IsHSCoach==1) and ($IsCollegeCoach==0) ) {                                                                         #### START -  SHOW NO PERMISSION#####                                  ?>                                <div class="thankyoumessage">                                        <?php echo "Sorry, only College Coaches can view HS/AAU Coach ratings";?>                                    </div>                                    <p>                                        <label>&nbsp;</label>                                        <span>                                            <button type="submit"onclick="javascript:refreshParent();" class="normalbtn">Close Window</button>                                        </span>                                    </p>                                <?php                                 ##End Display No Permission                                }                                                                               else if (($CollegeCoachhasvoted==1) and ($IsCollegeCoach==1) and ($_REQUEST['mode'] != 'view')  ) {                                                                         #### START -  SHOW NO PERMISSION#####                                  ?>                                <div class="thankyoumessage">                                        <?php                                         $viewLink = "RatingHsAauCoach.php?fldId=" . $_REQUEST['fldId'] . "&mode=view";                                        echo "Sorry, you have already voted for this HS/AAU Coach.  Please <a href='$viewLink'>Click Here</a> to view Ratings";                                        ?>                                    </div>                                    <p>                                        <label>&nbsp;</label>                                        <span>                                            <button type="submit"onclick="javascript:refreshParent();" class="normalbtn">Close Window</button>                                        </span>                                    </p>                                <?php                                 ##End Display No Permission                                }                                               ?>                            </div>                        </div>                    </div>                </div>            </div>        </div>    </body></html>