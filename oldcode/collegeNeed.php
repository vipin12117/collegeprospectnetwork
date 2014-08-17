<?php

include_once ("inc/common_functions.php");
include_once ("inc/page.inc.php");
require_once 'inc/db.inc.php';
require_once ('zipcode.class.php');

session_start();

// accesses common functions
$func = new COMMONFUNC;

// database access
$db = new DB;

// zip code search
$z = new zipcode_class;

if (($_SESSION['mode'] != "college") or ($_SESSION['FRONTEND_USER'] == "")) {
    header("Location:index.php");
}

$coachId = $_SESSION['College_Coach_id'];

$needId = NULL;
$fldCollegeId = NULL;
$fldSport = NULL;
$fldGradClass = NULL;
$fldMinHeight = NULL;
$fldMaxHeight = NULL;
$fldMinWeight = NULL;
$fldMaxWeight = NULL;
$fldPosition = NULL;
$fldMinBenchPress = NULL;
$fldMinSquatMax = NULL;
$fldMax40YardDash = NULL;
$fldMaxShuttleRun = NULL;
$fldMinVertical = NULL;
$fldSportsStats = NULL;
$fldGPA = NULL;
$fldSATScore = NULL;
$fldClassRank = NULL;
$fldActScore = NULL;
$fldCHEligible = NULL;
$fldIntendedMajor = NULL;
$fldHighSchoolIds = NULL;
$fldDivision = NULL;
$fldCity = NULL;
$fldState = NULL;
$fldZipCode = NULL;
$fldDistance = NULL;
$fldModified = date('Y-m-d');

// fldCollegeID
$query = 'SELECT fldCollegename,fldEmail,fldLastName FROM ' . TBL_COLLEGE_COACH_REGISTER . ' WHERE fldId=' . $coachId;

if (!$db->query($query)) {
    die(mysql_error());
}

$db->next_record();

$fldCollegeId = $db->f('fldCollegename');
$collegeLname = $db->f('fldLastName');
$collegeEmail = $db->f('fldEmail');

// indicates successful query
$success = TRUE;

// get form values
if (!empty($_POST['submit'])) {
    // fldNeedId
    $fldNeedId = 'NULL';
    
    if (!empty($_POST['fldNeedId'])) {
        $fldNeedId = mysql_real_escape_string($_POST['fldNeedId']);
    }
    
    // fldSport
    $fldSport = mysql_real_escape_string($_POST['fldSport']);
    
    // fldGradClass
    $fldGradClass = 'NULL';
    
    if (!empty($_POST['fldClass'])) {
        $fldGradClass = "'" . mysql_real_escape_string($_POST['fldClass']) . "'";
    }
    
    // fldMinHeight
    $fldMinHeight = 'NULL';
    
    if (!empty($_POST['fldMinHeight'])) {
        $fldMinHeight = mysql_real_escape_string(
            substr($_POST['fldMinHeight'], 0, 1) * 12 
            + substr($_POST['fldMinHeight'], 2)
        );
    }
    
    // fldMaxHeight
    $fldMaxHeight = 'NULL';
    
    if (!empty($_POST['fldMaxHeight'])) {
        $fldMaxHeight = mysql_real_escape_string(
            substr($_POST['fldMaxHeight'], 0, 1) * 12 
            + substr($_POST['fldMaxHeight'], 2)
        );
    }
    
    // fldMinWeight
    $fldMinWeight = 'NULL';
    
    if (!empty($_POST['fldMinWeight'])) {
        if ($_POST['fldMinWeight'] == 'under140') {
            $fldMinWeight = 0;
        } else if ($_POST['fldMinWeight'] == 'Over260') {
            $fldMinWeight = 260;
        } else {
            $fldMinWeight = mysql_real_escape_string(
                substr($_POST['fldMinWeight'], 0, 3)
            );
        }
    }
    
    // fldMaxWeight
    $fldMaxWeight = 'NULL';
    
    if (!empty($_POST['fldMaxWeight'])) {
        if ($_POST['fldMaxWeight'] == 'under140') {
            $fldMaxWeight = 140;
        } else if ($_POST['fldMaxWeight'] == 'Over260') {
            $fldMaxWeight = 1000;
        } else {
            $fldMaxWeight = mysql_real_escape_string(
                substr($_POST['fldMaxWeight'], -3)
            );
        }
    }
    
    // fldPosition
    $fldPosition = 'NULL';
    
    if (!empty($_POST['fldPrimaryPosition'])) {
        $fldPosition = "'" . mysql_real_escape_string($_POST['fldPrimaryPosition']) . "'";
    }
    
    // fldMinBenchPress
    $fldMinBenchPress = 'NULL';
    
    if (!empty($_POST['fldBenchPressMax'])) {
        $fldMinBenchPress = mysql_real_escape_string(
            $_POST['fldBenchPressMax']
        );
    }
    
    // fldMinSquatMax
    $fldMinSquatMax = 'NULL';
    
    if (!empty($_POST['fldSquatMax'])) {
        $fldMinSquatMax = mysql_real_escape_string($_POST['fldSquatMax']);
    }
    
    // fldMax40YardDash
    $fldMax40YardDash = 'NULL';
    
    if (!empty($_POST['fld40_yardDash'])) {
        $fldMax40YardDash = mysql_real_escape_string($_POST['fld40_yardDash']);
    }
    
    // fldMaxShuttleRun
    $fldMaxShuttleRun = 'NULL';
    
    if (!empty($_POST['fldShuttleRun'])) {
        $fldMaxShuttleRun = mysql_real_escape_string($_POST['fldShuttleRun']);
    }
    
    // fldMinVertical
    $fldMinVertical = 'NULL';
    
    if (!empty($_POST['fldVertical'])) {
        $fldMinVertical = mysql_real_escape_string($_POST['fldVertical']);
    }
    
    // fldSportsStats
    $fldSportsStats = 'NULL';
    
    if (!empty($_POST['fldStatCategories'])) {
        $gameStats = array();
        
        foreach ($_POST['fldStatCategories'] as $stat => $value) {
            if ($value != '') {
                $gameStats[$stat] = $value;
            }
        }
        
        $fldSportsStats = "'" . json_encode($gameStats) . "'";
    }
    
    // fldGPA
    $fldGPA = 'NULL';
    
    if (!empty($_POST['fldGPA'])) {
        $fldGPA = "'" . mysql_real_escape_string($_POST['fldGPA']) . "'";
    }
    
    // fldSATScore
    $fldSATScore = 'NULL';
    
    if (!empty($_POST['fldSATScore'])) {
        $fldSATScore = "'" . mysql_real_escape_string($_POST['fldSATScore']) . "'";
    }
    
    // fldClassRank
    $fldClassRank = 'NULL';
    
    if (!empty($_POST['fldClassRank'])) {
        $fldClassRank = "'" . mysql_real_escape_string($_POST['fldClassRank']) . "'";
    }
    
    // fldActScore
    $fldActScore = 'NULL';
    
    if (!empty($_POST['fldACTScore'])) {
        $fldActScore = "'" . mysql_real_escape_string($_POST['fldACTScore']) . "'";
    }
    
    // fldCHEligible
    $fldCHEligible = 'NULL';
    
    if (($_POST['fldCHEligible']) != "") {
        $fldCHEligible = mysql_real_escape_string($_POST['fldCHEligible']);
    }
    
    // fldIntendedMajor
    $fldIntendedMajor = 'NULL';
    
    if (!empty($_POST['fldIntendedMajor'])) {
        $fldIntendedMajor = "'" . mysql_real_escape_string($_POST['fldIntendedMajor']) . "'";
    }
    
    // fldSelectedSchool, fldHighSchoolIds
    $fldSelectedSchool = 'NULL';
    $fldHighSchoolIds = 'NULL';
    
    if ($_POST['fldSchool'] != 0) {
        $fldSelectedSchool = "'" . mysql_real_escape_string($_POST['fldSchool']) . "'";
        $fldHighSchoolIds = $fldSelectedSchool;
    } else if (!empty($_POST['fldZipCode']) && !empty($_POST['fldDistance'])) {
        // get all schools within radius of ZIP
        $zips = $z->get_zips_in_range(
            $_POST['fldZipCode'], 
            $_POST['fldDistance'], 
            _ZIPS_SORT_BY_DISTANCE_ASC, 
            true
        );
        
        $zipsList = implode(',', $zips);
        
        $query = sprintf("SELECT * FROM %s WHERE fldZipcode in (%s) AND fldStatus='ACTIVE'",
                 TBL_HS_AAU_TEAM,
                 mysql_real_escape_string($zipsList));
        
        if (!$db->query($query)) {
            die(mysql_error());
        }
        
        $numRows = $db->num_rows();
        
        $team_list_id = '';
        $db->next_record();
        
        for ($i = 0; $i < $numRows; $i++) {
            $team_list_id .= $db->f('fldId');
            
            // skips the comma after the last item in the list
            if ($i != $numRows - 1) {
                $team_list_id .= ',';
            }
            
            $db->next_record();
        }
        
        if (strlen($team_list_id) > 0) {
            $fldHighSchoolIds = "'" . $team_list_id . "'";
        }
    }
    
    // fldDivision
    $fldDivision = 'NULL';
    
    if (!empty($_POST['fldDivision'])) {
        $fldDivision = "'" . mysql_real_escape_string($_POST['fldDivision']) . "'";
    }
    
    // fldCity
    $fldCity = 'NULL';
    
    if (!empty($_POST['fldCity'])) {
        $fldCity = "'" . mysql_real_escape_string($_POST['fldCity']) . "'";
    }
    
    // fldState
    $fldState = 'NULL';
    
    if (!empty($_POST['fldState'])) {
        $fldState = "'" . mysql_real_escape_string($_POST['fldState']) . "'";
    }
    
    // fldZipCode
    $fldZipCode = 'NULL';
    
    if (!empty($_POST['fldZipCode'])) {
        $fldZipCode = "'" . mysql_real_escape_string($_POST['fldZipCode']) . "'";
    }
    
    // fldDistance
    $fldDistance = 'NULL';
    
    if (!empty($_POST['fldDistance'])) {
        $fldDistance = "'" . mysql_real_escape_string($_POST['fldDistance']) . "'";
    }
    
    // fldModified
    $fldModified = date('Y-m-d');
    
    // query
    $query = NULL;
    if ($_REQUEST['action'] == 'add') {
        $query = "INSERT INTO " . TBL_COLLEGE_NEEDS  . " VALUES (" .
                 "NULL, " . 
                 "$fldCollegeId, " .
                 "$fldSport, " .
                 "$fldGradClass, " .
                 "$fldMinHeight, " .
                 "$fldMaxHeight, " .
                 "$fldMinWeight, " .
                 "$fldMaxWeight, " .
                 "$fldPosition, " .
                 "$fldMinBenchPress, " .
                 "$fldMinSquatMax, " .
                 "$fldMax40YardDash, " .
                 "$fldMaxShuttleRun, " .
                 "$fldMinVertical, " .
                 "$fldSportsStats, " .
                 "$fldGPA, " .
                 "$fldSATScore, " .
                 "$fldClassRank, " .
                 "$fldActScore, " .
                 "$fldCHEligible, " .
                 "$fldIntendedMajor, " .
                 "$fldSelectedSchool, " .
                 "$fldHighSchoolIds, " .
                 "$fldDivision, " .
                 "$fldCity, " .
                 "$fldState, " .
                 "$fldZipCode, " .
                 "$fldDistance, " .
                 "'$fldModified')";
    }
    
    if ($_REQUEST['action'] == 'edit') {
        $query = "UPDATE " . TBL_COLLEGE_NEEDS  . " SET " .
                 "fldSportId=$fldSport, " .
                 "fldGradClass=$fldGradClass, " .
                 "fldMinHeight=$fldMinHeight, " .
                 "fldMaxHeight=$fldMaxHeight, " .
                 "fldMinWeight=$fldMinWeight, " .
                 "fldMaxWeight=$fldMaxWeight, " .
                 "fldPosition=$fldPosition, " .
                 "fldMinBenchPress=$fldMinBenchPress, " .
                 "fldMinSquatMax=$fldMinSquatMax, " .
                 "fldMax40YardDash=$fldMax40YardDash, " .
                 "fldMaxShuttleRun=$fldMaxShuttleRun, " .
                 "fldMinVertical=$fldMinVertical, " .
                 "fldSportStats=$fldSportsStats, " .
                 "fldGPA=$fldGPA, " .
                 "fldSATScore=$fldSATScore, " .
                 "fldClassRank=$fldClassRank, " .
                 "fldActScore=$fldActScore, " .
                 "fldCHEligible=$fldCHEligible, " .
                 "fldIntendedMajor=$fldIntendedMajor, " .
                 "fldSelectedSchool=$fldSelectedSchool, " .
                 "fldHighSchoolIds=$fldHighSchoolIds, " .
                 "fldDivision=$fldDivision, " .
                 "fldCity=$fldCity, " .
                 "fldState=$fldState, " .
                 "fldZipCode=$fldZipCode, " .
                 "fldDistance=$fldDistance, " .
                 "fldLastModified='$fldModified' " .
                 "WHERE fldId=" . $fldNeedId;
    }
    
    if (!$db->query($query)) {
        die(mysql_error());
        $success = FALSE;
    }
}

// TODO: Should the sport list be restricted to the sports that the coach has an active subscription to?
$query = 'SELECT tbl_sports.fldId, tbl_sports.fldSportsname ' .
         'FROM tbl_sports INNER JOIN tbl_college_subscription ' .
         'ON tbl_sports.fldId=tbl_college_subscription.fldSport ' .
         'WHERE tbl_college_subscription.fldActive=1 ' .
         'AND tbl_college_subscription.fldCoach=' . $coachId;

if (!$db->query($query)) {
    die(mysql_error());
}

$fldSportList = array();

while ($db->next_record()) {
    $fldSportList[$db->f('fldId')] = $db->f('fldSportsname');
}

$arrDistances = array('0','10','25','50','100','Any');
$fldClassList = $classlist = $func -> selectTableOrder(TBL_CLASS, "fldId,fldClass", "fldId");

if ($_REQUEST['action'] == 'edit') {
    $needId = $_REQUEST['id'];
    
    $query = 'SELECT * FROM ' . TBL_COLLEGE_NEEDS . ' WHERE fldId=' . $needId;
    
    if (!$db->query($query)) {
        die(mysql_error());
    }
    $db->next_record();
    
    $fldSport = $db->f('fldSportId');
    $fldGradClass = $db->f('fldGradClass');
    $fldMinHeight = intval($db->f('fldMinHeight')/12) . '-' 
             . intval($db->f('fldMinHeight')%12);
    
    $fldMaxHeight = intval($db->f('fldMaxHeight')/12) . '-'
             . intval($db->f('fldMaxHeight')%12);
    
    switch ($db->f('fldMinWeight')) {
        case 0:
            $fldMinWeight = 'under140';
            break;
            
        case 141:
            $fldMinWeight = '141-155';
            break;
            
        case 156:
            $fldMinWeight = '156-170';
            break;
            
        case 171:
            $fldMinWeight = '171-185';
            break;
            
        case 186:
            $fldMinWeight = '186-200';
            break;
            
        case 201:
            $fldMinWeight = '201-215';
            break;
            
        case 213:
            $fldMinWeight = '216-230';
            break;
            
        case 231:
            $fldMinWeight = '231-245';
            break;
            
        case 246:
            $fldMinWeight = '246-260';
            break;
            
        case 260:
            $fldMinWeight = 'Over260';
            break;
    }
    
    switch ($db->f('fldMaxWeight')) {
        case 140:
            $fldMaxWeight = 'under140';
            break;
            
        case 155:
            $fldMaxWeight = '141-155';
            break;
            
        case 170:
            $fldMaxWeight = '156-170';
            break;
            
        case 185:
            $fldMaxWeight = '171-185';
            break;
            
        case 200:
            $fldMaxWeight = '186-200';
            break;
            
        case 215:
            $fldMaxWeight = '201-215';
            break;
            
        case 230:
            $fldMaxWeight = '216-230';
            break;
            
        case 245:
            $fldMaxWeight = '231-245';
            break;
            
        case 260:
            $fldMaxWeight = '246-260';
            break;
            
        case 1000:
            $fldMaxWeight = 'Over260';
            break;
    }
    
    $fldPosition = $db->f('fldPosition');
    $fldMinBenchPress = $db->f('fldMinBenchPress');
    $fldMinSquatMax = $db->f('fldMinSquatMax');
    $fldMax40YardDash = $db->f('fldMax40YardDash');
    $fldMaxShuttleRun = $db->f('fldMaxShuttleRun');
    $fldMinVertical = $db->f('fldMinVertical');
    $fldSportStats = json_decode($db->f('fldSportStats'));
    $fldGPA = $db->f('fldGPA');
    $fldSATScore = $db->f('fldSATScore');
    $fldClassRank = $db->f('fldClassRank');
    $fldActScore = $db->f('fldActScore');
    $fldCHEligible = $db->f('fldCHEligible');
    $fldIntendedMajor = $db->f('fldIntendedMajor');
    $fldSelectedSchool = $db->f('fldSelectedSchool');
    $fldDivision = $db->f('fldDivision');
    $fldCity = $db->f('fldCity');
    $fldState = $db->f('fldState');
    $fldZipCode = $db->f('fldZipCode');
    $fldDistance = $db->f('fldDistance');
    $fldModified = date('Y-m-d');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($_REQUEST['action'] == 'edit') ? 'Edit Need' : 'Add Need';?></title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            fieldset legend {
                background: none;
            }
            
            fieldset {
                background-color: white;
            }

            div.col-fieldset-right,
            div.col-fieldset-left
            {
                background-color: inherit;
            }
            
            #fldPositions {
                display: none;
            }
        </style>
        <script src="/js/jquery-1.6.1.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var stats;
            var isAlt = <?php echo (count($fldSportStats)%2 == 0) ? 1 : 0; ?>;
            
            function refreshParent() {
                window.opener.location.href = window.opener.location.href;
                if(window.opener.progressWindow) {
                    window.opener.progressWindow.close()
                }
                window.close();
            }
            
            function label2select(label)
            {
                // gets the label text
                var statLabel = $(label).html();
                
                // creates a new select element
                var select = document.createElement("select");
                
                // creates a select option for each
                // stat and adds the option to select
                for (var i = 0; i < stats.length; i++) {
                    var option = document.createElement("option");
                    
                    var attrValue = document.createAttribute("value");
                    attrValue.value = stats[i];
                    
                    if (statLabel === stats[i]) {
                        var attrSelected = document.createAttribute("selected");
                        attrSelected.value = "selected";
                        
                        option.setAttributeNode(attrSelected);
                    }
                    
                    var text = document.createTextNode(stats[i]);
                    
                    option.setAttributeNode(attrValue);
                    option.appendChild(text);
                    
                    select.appendChild(option);
                }
                
                // binds event listeners
                $(select).bind('change blur', function() {
                    select2label(select);
                });
                
                // replaces the label with select
                $(label).replaceWith(select);
            }
            
            function select2label(select)
            {
                // gets the selected value
                var statLabel = $(select).val();
                
                // creates a labe element
                var label = document.createElement("label");
                var text = document.createTextNode(statLabel);
                
                label.appendChild(text);
                
                var style = document.createAttribute("style");
                style.value="width: 200px;";
                
                label.setAttributeNode(style);
                
                // binds the event listener
                $(label).bind('click', function() {
                    label2select(label);
                });
                
                // changes the name attr of the corresponding input
                //var input = $(select).next("input");
                var fldName = "fldStatCategories[" + statLabel + "]";
                $(select).next("input").attr("name", fldName);
                
                // replaces select with label
                $(select).replaceWith(label);
            }
            
            function clearGameStats()
            {
                var legend = document.createElement("legend");
                legend.appendChild(document.createTextNode("Game Stats"));
                
                $("#gameStats").html(legend);
                
                var btn = document.createElement("input");
                var attr = document.createAttribute("type");
                attr.value = "button";
                btn.setAttributeNode(attr);
                
                attr = document.createAttribute("onclick");
                attr.value = "addStatsField();";
                btn.setAttributeNode(attr);
                
                attr = document.createAttribute("value");
                attr.value = "Add More";
                btn.setAttributeNode(attr);
                
                var span = document.createElement("span");
                var p = document.createElement("p");
                
                attr = document.createAttribute("id");
                attr.value = "statsBtn";
                p.setAttributeNode(attr);
                
                span.appendChild(btn);
                p.appendChild(span);
                
                $("#gameStats").append(p);
            }
            
            function addStatsField()
            {
                // creates a new select element
                var select = document.createElement("select");
                
                var option = document.createElement("option");
                var text = document.createTextNode("Select Game Stat");
                option.appendChild(text);
                select.appendChild(option);
                
                // creates a select option for each
                // stat and adds the option to select
                for (var i = 0; i < stats.length; i++) {
                    var option = document.createElement("option");
                    
                    var attrValue = document.createAttribute("value");
                    attrValue.value = stats[i];
                    
                    var text = document.createTextNode(stats[i]);
                    
                    option.setAttributeNode(attrValue);
                    option.appendChild(text);
                    
                    select.appendChild(option);
                }
                
                // binds event listeners
                $(select).bind('change blur', function() {
                    select2label(select);
                });
                
                var input = document.createElement("input");
                var attr = document.createAttribute("type");
                attr.value = "text";
                input.setAttributeNode(attr);
                
                var p = document.createElement("p");
                
                if (isAlt) {
                    var attr = document.createAttribute("class");
                    attr.value = "alt";
                    
                    p.setAttributeNode(attr);
                    isAlt = 0;
                } else {
                    isAlt = 1;
                }
                
                var span = document.createElement("span");
                
                var attr = document.createAttribute("style");
                attr.value = "padding-left: 3px;"
                span.setAttributeNode(attr);
                
                span.appendChild(select);
                span.appendChild(input);
                p.appendChild(span);
                
                $("#statsBtn").before(p);
            }
            
            // makes an option element
            function makeOption(value, text, selected)
            {
                var option = document.createElement("option");
                
                var attr = document.createAttribute("value");
                attr.value = value;
                
                var text = document.createTextNode(text);
                
                option.setAttributeNode(attr);
                option.appendChild(text);
                
                if (selected == true) {
                    attr = document.createAttribute("selected");
                    attr.value = "selected";
                    
                    option.setAttributeNode(attr);
                }
                
                return option;
            }
            
            function getPositionsBySport(sport, selected)
            {
                $.ajax({
                    type: "POST",
                    url: "ajax/positions.php",
                    data: "sport=" + sport,
                    success: function(data) {
                        // primary position select element
                        var selectPP = $("[name='fldPrimaryPosition']");
                        // secondary position select element
                        //var selectSP = $("[name='fldSecondaryPosition']");
                        
                        // clears current position lists
                        selectPP.html("");
                        //selectSP.html("");
                        
                        selectPP.append(makeOption("", "Any Position"), false);
                        //selectSP.append(makeOption("", "Any Position"));
                        
                        var positions = JSON.parse(data);
                        for (var i in positions) {
                            var sel = false;
                            
                            if (selected == positions[i]) {
                                sel = true;
                            }
                            
                            selectPP.append(makeOption(positions[i], positions[i], sel));
                            //selectSP.append(makeOption(i, positions[i]));
                        }
                        
                        // unhides fldPositions
                        $("#fldPositions").show();
                    }
                });
            }
            
            function getStatsBySport(sport)
            {
                // gets list of gamestats for selected sport
                $.ajax({
                    type: "POST",
                    url: "ajax/gameStats.php",
                    data: "sport=" + $("[name='fldSport']").val(),
                    success: function(data) {
                        stats = JSON.parse(data);
                    }
                });
            }
            
            $(document).ready(function () {
                if($("[name='fldSport']").val() != "") {
                    getPositionsBySport($("[name='fldSport']").val(), "<?php echo $fldPosition; ?>");
                    getStatsBySport($("[name='fldSport']").val());
                }
                
                $("[name='fldSport']").change(function () {
                    getPositionsBySport($("[name='fldSport']").val());
                    getStatsBySport($("[name='fldSport']").val());
                    
                    clearGameStats();
                    addStatsField();
                });
            });
        </script>
    </head>
	<body>
        <div class="container">
        <div class="innerWraper">
        <div class="middle-bg">
        <div class="cantener">
        <div class="register-main">
        <div class="registerPage advancedsearch">
            <?php if (!empty($_POST['submit'])): ?>
            <p class="thankyoumessage">
                <?php if ($success): ?>
                	<?php require 'emailAlert_NeedsMatch.php'; ?>
                    Need posted successfully.
                <?php else: ?>
                    There was an error posting your need.
                <?php endif; ?>
            </p>
            <p>
                <span>
                    <input type="button" value="Back" onclick="javascript:refreshParent();" />
                </span>
            </p>
            <?php else: ?>
                <?php if (count($fldSportList) == 0): ?>
                    <p class="thankyoumessage">
                        You do not have any active subscriptions
                    </p>
                <?php else: ?>
                    <form action="" method="post" name="needtype" onsubmit="return validate();">
                        <h1 style="float:left;margin-bottom:15px;"><?php echo ($_REQUEST['action'] == 'edit') ? 'Edit Need' : 'Add Need';?></h1>
                        <div style="float:right;color:#777;font-size:13px;margin-left:15px;padding-top:7px;">
                            *All Search Fields are optional
                        </div>
                        <div class="clear"></div>
                        <fieldset>
                            <legend>Athletic Stats</legend>
                            <div class="formarea">
                                <div class="col-left">
                                    <!-- Sport -->
                                    <p class="alt">
                                        <label>Sport</label>
                                        <span>
                                            <select name="fldSport">
                                                <option value="" class="selectgrey">Select a Sport</option>
                                                <?php foreach ($fldSportList as $id => $sport): ?>
                                                    <?php $selected = ($fldSport == $id) ? ' selected="selected" ' : NULL; ?>
                                                    <option value="<?php echo $id; ?>" <?php echo $selected?>>
                                                        <?php echo $sport; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </span>
                                    </p>
                                    
                                    <!-- Graduating Class -->
                                    <p>
                                        <label>Graduating Class:</label>
                                        <span>
                                            <select name="fldClass">
                                                <option value="" class="selectgrey">Any Class</option>
                                                <?php foreach ($fldClassList as $class): ?>
                                                    <?php $selected = ($fldGradClass == $class['fldClass']) ? ' selected="selected" ' : NULL; ?>
                                                    <option value="<?php echo $class['fldClass']; ?>" <?php echo $selected?>>
                                                        <?php echo $class['fldClass']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </span>
                                    </p>
                            									
                                    <!-- Division -->
                                    <p class="alt">
                                        <label>Division:</label>
                                        <span>
                                            <select name="fldDivision">
                                                <option value="" class="selectgrey">Any Division</option>
                                                <option value="DivisionI" <?php  if ($fldDivision=='DivisionI'){?>selected<?php }?> >Division I</option>
                                                <option value="DivisionII"  <?php  if ($fldDivision=='DivisionII'){?>selected<?php }?>>Division II</option>
                                                <option value="DivisionIII"  <?php  if ($fldDivision=='DivisionIII'){?>selected<?php }?>>Division III</option>
                                                <option value="NAIA"  <?php  if ($fldDivision=='NAIA'){?>selected<?php }?>>NAIA</option>
                                                <option value="JUCO" <?php  if ($fldDivision=='JUCO'){?>selected<?php }?> >JUCO</option>
                                            </select>
                                        </span>
                                    </p>
                                    
                                    <!-- Clearinghouse Eligible -->
                                    <p>
                                        <label>Clearinghouse Eligible:</label>
                                        <span>
                                            <select name="fldCHEligible">
                                                <option value="">Any Eligibility</option>
                                                <option value="0" <?php if ($fldCHEligible=='0'){?>selected<?php }?>>No</option>
                                                <option value="1" <?php if ($fldCHEligible=='1'){?>selected<?php }?>>Yes</option>
                                            </select>
                                        </span>
                                    </p>

				                    <!-- Height -->
                                    <p class="alt">
                                        <label>Height:</label>
                                        <span>
                                            <select name="fldMinHeight">
                                                <option value="" class="selectgrey">Any Min Height</option>
                                                <?php                                                
                                                for ($i = 60; $i <= 86; $i++) {
                                                    $ft = floor($i/12);
                                                    $in = $i%12;
                                                    
                                                    echo '<option value="'.$ft.'-'.$in.'"';
                                                    
                                                    if (strcmp($fldMinHeight, $ft.'-'.$in) == 0) {
                                                        echo ' selected="selected"';
                                                    }
                                                    
                                                    echo ' >'.$ft."' ".$in.'</option>';
                                                }                                                
                                                ?>
                                            </select>
                                        </span>    
                                        <span style="padding-top:3px;">
                                            <select name="fldMaxHeight">
                                                <option value="" class="selectgrey">Any Max Height</option>
                                                <?php                                                
                                                for ($i = 60; $i <= 86; $i++) {
                                                    $ft = floor($i/12);
                                                    $in = $i%12;
                                                    
                                                    echo '<option value="'.$ft.'-'.$in.'"';
                                                    
                                                    if (strcmp($fldMaxHeight, $ft.'-'.$in) == 0) {
                                                        echo ' selected="selected"';
                                                    }
                                                    
                                                    echo ' >'.$ft."' ".$in.'</option>';
                                                }                                                
                                                ?>
                                            </select>
                                        </span>                          
                                    </p>
                                                    
                                    <!-- Weight -->
                                    <p>
                                        <label>Weight:</label>
                                        <span> 
                                            <select name="fldMinWeight"><option value="" class="selectgrey">Any Min Weight</option>
                                            <option value="under140" <?php if ($fldMinWeight=='under140'){?>selected<?php }?>>Under 140</option>
                                            
                                            <?php
                                            for ($i = 127; $i < 245; $i++) {
                                                $i = $i + 14;
                                                $j = $i + 14;
                                                echo '<option value="' . $i . "-" . $j . '"';
                                                
                                                if (strcmp($fldMinWeight, $i . '-' . $j) == 0) {
                                                    echo ' selected="selected"';
                                                }
                                                
                                                echo ' >' . $i . "-" . $j . '</option>';
                                            }
                                            ?>
                                            <option value="Over260" <?php if ($fldMinWeight=='Over260'){?>selected<?php }?>>Over 260</option>
                                            </select>
                                        </span>
                                        <span style="padding-top:3px;">
                                            <select name="fldMaxWeight"><option value="" class="selectgrey">Any Max Weight</option>
                                            <option value="under140" <?php if ($fldMaxWeight=='under140'){?>selected<?php }?>>Under 140</option>
                                            
                                            <?php
                                            for ($i = 127; $i < 245; $i++) {
                                                $i = $i + 14;
                                                $j = $i + 14;
                                                echo '<option value="' . $i . "-" . $j . '"';
                                                
                                                if (strcmp($fldMaxWeight, $i . '-' . $j) == 0) {
                                                    echo ' selected="selected"';
                                                }
                                                
                                                echo ' >' . $i . "-" . $j . '</option>';
                                            }
                                            ?>
                                            
                                            <option value="Over260" <?php if ($fldMaxWeight=='Over260'){?>selected<?php }?>>Over 260</option>
                                            </select>
                                        </span>
                                    </p>
                                                    
                                    <!-- Position -->
                                    <p id="fldPositions">
                                        <label>Sport Position:</label>
                                        <span>
                                            <select name="fldPrimaryPosition">
                                            </select>
                                        </span>
                                    </p>
                                                    
                                </div>                                   
                                <div class="col-right">            
                                    <!-- Max 40-yard Dash (sec) -->
                                    <p class="alt">
                                        <label>40-yard Dash:</label>
                                        <span>
                                            <input name="fld40_yardDash" type="text" value="<?php echo $fldMax40YardDash; ?>" class="maskNumericFloat" />
                                            <span class="description">seconds or faster</span>
                                        </span>
                                    </p>
                                                    
                                    <!-- Max Shuttle Run (sec) -->
                                    <p>
                                        <label>Shuttle Run:</label>
                                        <span>
                                            <input name="fldShuttleRun" type="text" value="<?php echo $fldMaxShuttleRun; ?>" class="maskNumericFloat" />
                                            <span class="description">seconds or faster</span>
                                        </span>
                                    </p>        
                                                    
                                    <!-- Min Vertical Jump (inches) -->
                                    <p class="alt">
                                        <label>Vertical Jump:</label>
                                        <span>
                                            <input name="fldVertical" type="text" value="<?php echo $fldMinVertical; ?>" class="maskNumeric" />
                                            <span class="description">inches or higher</span>
                                        </span>
                                    </p>                                        

                                    <!-- Min Bench Press (lbs) -->
                                    <p>
                                        <label>Bench Press:</label>
                                        <span>
                                            <input name="fldBenchPressMax" type="text" value="<?php echo $fldMinBenchPress; ?>" class="maskNumeric" />
                                            <span class="description">lbs or heaver</span>
                                        </span>
                                    </p>
                                                    
                                    <!-- Min Squat Max (lbs) -->
                                    <p class="alt">
                                        <label>Squat Max:</label>
                                        <span>
                                            <input name="fldSquatMax" type="text" value="<?php echo $fldMinSquatMax; ?>" class="maskNumeric" />
                                            <span class="description">lbs or heaver</span>
                                        </span>
                                    </p>
                                                
                                </div>
                                <div class="clear"></div>
                            </div>
				        </fieldset>
                        <div class="col-fieldset-left">
                            <fieldset>
                                <legend>Academic Stats (IN DEV)</legend>      
                                <div class="formarea">
                                    
                                    <!--GPA-->
                                    <p class="alt">
                                        <label>GPA:</label>
                                        <span>
                                            <select name="fldGPA">
                                                <option value="" class="selectgrey">Any GPA</option>
                                                <option value="under2.0" <?php if ($fldGPA == "under2.0") { ?>selected <?php  }?>>Under 2.0</option>
                                                <option value="2.0-2.5" <?php if ($fldGPA == "2.0-2.5") { ?>selected <?php  }?>>2.0 - 2.5</option>
                                                <option value="2.6-3.0" <?php if ($fldGPA == "2.6-3.0") { ?>selected <?php  }?>>2.6 - 3.0</option>
                                                <option value="3.1-3.5" <?php if ($fldGPA == "3.1-3.5") { ?>selected <?php  }?>>3.1 - 3.5</option>
                                                <option value="3.6-4.0" <?php if ($fldGPA == "3.6-4.0") { ?>selected <?php  }?> >3.6 - 4.0</option>
                                                <option value="Above4.0" <?php if ($fldGPA == "Above4.0") { ?>selected <?php  }?>>Above 4.0</option>
                                            </select>
                                        </span>
                                    </p>
                                                    
                                    <!--SAT Score-->
                                    <p>
                                        <label>SAT Score:</label>
                                        <span> <?php
                                            $lower = 601;
                                            $upper = 800;
                                            echo '<select name="fldSATScore"><option value="" class="selectgrey">Any SAT Score</option>';
                                            if ($fldSATScore == '400' . "-" . "600") {
                                                echo '<option value="' . "400" . "-" . "600" . '" selected = "selected"';
                                                echo '>' . "400" . "-" . "600" . '</option>';
                                            } else {
                                                echo '<option value="' . "400" . "-" . "600" . '"';
                                                echo '>' . "400" . "-" . "600" . '</option>';
                                            }
                                            for ($i_count = 1; $i_count < 10; $i_count++) {
                                                if ($fldSATScore == $lower . "-" . $upper) {
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
                                            ?>
                                              
                                        </span>
                                    </p>
                                                    
                                    <!--ACT Score-->
                                    <p class="alt">
                                        <label>ACT Score:</label>
                                        <span>
                                            <select name="fldACTScore">
                                                <option value="" class="selectgrey">Any ACT Score</option>
                                                <option value="under10" <?php if ($fldActScore == "under10") { ?>selected <?php  }?>>Under 10</option>
                                                <option value="10-15" <?php if ($fldActScore == "10-15") { ?>selected <?php  }?>>10 - 15</option>
                                                <option value="16-20" <?php if ($fldActScore == "16-20") { ?>selected <?php  }?>>16 - 20</option>
                                                <option value="21-25" <?php if ($fldActScore == "21-25") { ?>selected <?php  }?>>21 - 25</option>
                                                <option value="26-30" <?php if ($fldActScore == "26-30") { ?>selected <?php  }?>>26 - 30</option>
                                                <option value="Above30" <?php if ($fldActScore == "Above30") { ?>selected <?php  }?>>Above 30</option>
                                            </select>
                                              
                                        </span>
                                    </p>

                                    <!--Class Rank-->
                                    <p>
                                        <label>Class Rank:</label>
                                        <span>
                                            <select name="fldClassRank">
                                                <option value="" class="selectgrey">Any Class Rank</option>
                                                <option value="Not in Top 50% of Class" <?php if ($fldClassRank  == "Not in Top 50% of Class") { ?>selected <?php  }?>> Not in Top 50% of Class</option>
                                                <option value="Top 50% - Top 26%" <?php if ($fldClassRank  == "Top 50% - Top 26%") { ?>selected <?php  }?>>Top 50% - Top 26%</option>
                                                <option value="Top 25% - Top 11%" <?php if ($fldClassRank  == "Top 25% - Top 11%") { ?>selected <?php  }?>>Top 25% - Top 11%</option>
                                                <option value="Top 10% - Top 6%" <?php if ($fldClassRank  == "Top 10% - Top 6%") { ?>selected <?php  }?>>Top 10% - Top 6%</option>
                                                <option value="Top 5% or better" <?php if ($fldClassRank  == "Top 5% or better") { ?>selected <?php  }?>>Top 5% or better</option>
                                            </select>
                                        </span>
                                    </p>

                                    <!--Intended Major-->
                                    <p class="alt">
                                        <label>Intended Major:</label>
                                        <span>
                                            <select name="fldIntendedMajor">
                                                <option value="" class="selectgrey">Any Intended Major</option>
                                                <option value="Undecided / General Studies" <?php if ($fldIntendedMajor == "Undecided / General Studies") { ?>selected <?php  }?> >Undecided / General Studies</option>
                                                <option value="Agriculture" <?php if ($fldIntendedMajor == "Agriculture") { ?>selected <?php  }?>>Agriculture</option>
                                                <option value="Architecture" <?php if ($fldIntendedMajor == "Architecture") { ?>selected <?php  }?>>Architecture</option>
                                                <option value="Arts" <?php if ($fldIntendedMajor == "Arts") { ?>selected <?php  }?>>Arts</option>
                                                <option value="Business" <?php if ($fldIntendedMajor == "Business") { ?>selected <?php  }?>>Business</option>
                                                <option value="Communications" <?php if ($fldIntendedMajor == "Communications") { ?>selected <?php  }?>>Communications</option>
                                                <option value="Computers / Information Technology" <?php if ($fldIntendedMajor == "Computers / Information Technology") { ?>selected <?php  }?>>Computers / Information Technology</option>
                                                <option value="Education" <?php if ($fldIntendedMajor == "Education") { ?>selected <?php  }?>>Education</option>
                                                <option value="Engineering" <?php if ($fldIntendedMajor == "Engineering") { ?>selected <?php  }?>>Engineering</option>
                                                <option value="Liberal Arts" <?php if ($fldIntendedMajor == "Liberal Arts") { ?>selected <?php  }?>>Liberal Arts</option>
                                                <option value="Math" <?php if ($fldIntendedMajor == "Math") { ?>selected <?php  }?>>Math</option>
                                                <option value="Science" <?php if ($fldIntendedMajor == "Science") { ?>selected <?php  }?>>Science</option>
                                                <option value="Other" <?php if ($fldIntendedMajor == "Other") { ?>selected <?php  }?>>Other</option>
                                            </select>
                                        </span>
                                    </p>
                                </div>
                            </fieldset>      
                			<fieldset>
                                <legend>Location</legend>      
                                <div class="formarea">
					                
					                <!--Team-->
                                    <p class="alt">
                                        <label>HS/AAU Team:</label>      
                                        <span><?php
                                            echo $strcombo = '<select name="fldSchool" id="fldSchool" style="width:250px">';
                                            echo $strcombo = '<option value="0" class="selectgrey">Any HS/AAU Team</option>';

                                            //State Loop
                                            $statelist = $func -> selectTableOrdergroupby(TBL_HS_AAU_TEAM, "fldState", "fldState", "WHERE fldStatus='ACTIVE'");                                            
                                            for ($x = 0; $x < count($statelist); $x++) {                                                                                                
                                                echo '<optgroup label="========' . $statelist[$x]['fldState'] . '========">';         
                                                 
                                                 //School Loop (in state)                                      
                                                $whereclaus = "WHERE fldState = '" . $statelist[$x]['fldState'] . "' ";                                                
                                                $categorylist = $func -> selectTableOrder(TBL_HS_AAU_TEAM, "fldId,fldSchoolname", "fldSchoolname", $whereclaus);
                                                for ($i = 0; $i < count($categorylist); $i++) {
                                                    if ($fldSelectedSchool == $categorylist[$i]['fldId']) {
                                                        echo '<option value ="' . $categorylist[$i]['fldId'] . '" selected>' . $categorylist[$i]['fldSchoolname'] . '</option>';
                                                    } else {
                                                        echo '<option value ="' . $categorylist[$i]['fldId'] . '" >' . $categorylist[$i]['fldSchoolname'] . '</option>';
                                                    }
                                                }
                                                echo '</optgroup>';
                                            }                                           

                                            echo $strcombo = '</select>';       

                                            ?>
                                        </span>
                                    </p>
                                                        
                                    <!--State-->
                                    <p>
                                        <label>State:</label>
                                        <span>
                                            <select name="fldState">
                                               <option value="" class="selectgrey">Any State</option>
                                               <optgroup label="United States">
                                                   <option value='Alaska' <?php if ($fldState == 'Alaska') echo 'selected'; ?>>Alaska</option>
                                                   <option value='Alabama' <?php if ($fldState == 'Alabama') echo 'selected'; ?>>Alabama</option>
                                                   <option value='Arkansas' <?php if ($fldState == 'Arkansas') echo 'selected'; ?>>Arkansas</option>
                                                   <option value='Arizona' <?php if ($fldState == 'Arizona') echo 'selected'; ?>>Arizona</option>
                                                   <option value='California' <?php if ($fldState == 'California') echo 'selected'; ?>>California</option>
                                                   <option value='Colorado' <?php if ($fldState == 'Colorado') echo 'selected'; ?>>Colorado</option>
                                                   <option value='Connecticut' <?php if ($fldState == 'Connecticut') echo 'selected'; ?>>Connecticut</option>
                                                   <option value='District of Columbia' <?php if ($fldState == 'District of Columbia') echo 'selected'; ?>>District of Columbia</option>
                                                   <option value='Delaware' <?php if ($fldState == 'Delaware') echo 'selected'; ?>>Delaware</option>
                                                   <option value='Florida' <?php if ($fldState == 'Florida') echo 'selected'; ?>>Florida</option>
                                                   <option value='Georgia' <?php if ($fldState == 'Georgia') echo 'selected'; ?>>Georgia</option>
                                                   <option value='Hawaii' <?php if ($fldState == 'Hawaii') echo 'selected'; ?>>Hawaii</option>
                                                   <option value='Iowa' <?php if ($fldState == 'Iowa') echo 'selected'; ?>>Iowa</option>
                                                   <option value='Idaho' <?php if ($fldState == 'Idaho') echo 'selected'; ?>>Idaho</option>
                                                   <option value='Illinois' <?php if ($fldState == 'Illinois') echo 'selected'; ?>>Illinois</option>
                                                   <option value='Indiana' <?php if ($fldState == 'Indiana') echo 'selected'; ?>>Indiana</option>
                                                   <option value='Kansas' <?php if ($fldState == 'Kansas') echo 'selected'; ?>>Kansas</option>
                                                   <option value='Kentucky' <?php if ($fldState == 'Kentucky') echo 'selected'; ?>>Kentucky</option>
                                                   <option value='Louisiana' <?php if ($fldState == 'Louisiana') echo 'selected'; ?>>Louisiana</option>
                                                   <option value='Massachusetts' <?php if ($fldState == 'Massachusetts') echo 'selected'; ?>>Massachusetts</option>
                                                   <option value='Maryland' <?php if ($fldState == 'Maryland') echo 'selected'; ?>>Maryland</option>
                                                   <option value='Maine' <?php if ($fldState == 'Maine') echo 'selected'; ?>>Maine</option>
                                                   <option value='Michigan' <?php if ($fldState == 'Michigan') echo 'selected'; ?>>Michigan</option>
                                                   <option value='Minnesota' <?php if ($fldState == 'Minnesota') echo 'selected'; ?>>Minnesota</option>
                                                   <option value='Missouri' <?php if ($fldState == 'Missouri') echo 'selected'; ?>>Missouri</option>
                                                   <option value='Mississippi' <?php if ($fldState == 'Mississippi') echo 'selected'; ?>>Mississippi</option>
                                                   <option value='Montana' <?php if ($fldState == 'Montana') echo 'selected'; ?>>Montana</option>
                                                   <option value='North Carolina' <?php if ($fldState == 'North Carolina') echo 'selected'; ?>>North Carolina</option>
                                                   <option value='North Dakota' <?php if ($fldState == 'North Dakota') echo 'selected'; ?>>North Dakota</option>
                                                   <option value='Nebraska' <?php if ($fldState == 'Nebraska') echo 'selected'; ?>>Nebraska</option>
                                                   <option value='New Hampshire' <?php if ($fldState == 'New Hampshire') echo 'selected'; ?>>New Hampshire</option>
                                                   <option value='New Jersey' <?php if ($fldState == 'New Jersey') echo 'selected'; ?>>New Jersey</option>
                                                   <option value='New Mexico' <?php if ($fldState == 'New Mexico') echo 'selected'; ?>>New Mexico</option>
                                                   <option value='Nevada' <?php if ($fldState == 'Nevada') echo 'selected'; ?>>Nevada</option>
                                                   <option value='New York' <?php if ($fldState == 'New York') echo 'selected'; ?>>New York</option>
                                                   <option value='Ohio' <?php if ($fldState == 'Ohio') echo 'selected'; ?>>Ohio</option>
                                                   <option value='Oklahoma' <?php if ($fldState == 'Oklahoma') echo 'selected'; ?>>Oklahoma</option>
                                                   <option value='Oregon' <?php if ($fldState == 'Oregon') echo 'selected'; ?>>Oregon</option>
                                                   <option value='Pennsylvania' <?php if ($fldState == 'Pennsylvania') echo 'selected'; ?>>Pennsylvania</option>
                                                   <option value='Puerto Rico' <?php if ($fldState == 'Puerto Rico') echo 'selected'; ?>>Puerto Rico</option>
                                                   <option value='Rhode Island' <?php if ($fldState == 'Rhode Island') echo 'selected'; ?>>Rhode Island</option>
                                                   <option value='South Carolina' <?php if ($fldState == 'South Carolina') echo 'selected'; ?>>South Carolina</option>
                                                   <option value='South Dakota' <?php if ($fldState == 'South Dakota') echo 'selected'; ?>>South Dakota</option>
                                                   <option value='Tennessee' <?php if ($fldState == 'Tennessee') echo 'selected'; ?>>Tennessee</option>
                                                   <option value='Texas' <?php if ($fldState == 'Texas') echo 'selected'; ?>>Texas</option>
                                                   <option value='Utah' <?php if ($fldState == 'Utah') echo 'selected'; ?>>Utah</option>
                                                   <option value='Virginia' <?php if ($fldState == 'Virginia') echo 'selected'; ?>>Virginia</option>
                                                   <option value='Vermont' <?php if ($fldState == 'Vermont') echo 'selected'; ?>>Vermont</option>
                                                   <option value='Washington' <?php if ($fldState == 'Washington') echo 'selected'; ?>>Washington</option>
                                                   <option value='Wisconsin' <?php if ($fldState == 'Wisconsin') echo 'selected'; ?>>Wisconsin</option>
                                                   <option value='West Virginia' <?php if ($fldState == 'West Virginia') echo 'selected'; ?>>West Virginia</option>
                                                   <option value='Wyoming' <?php if ($fldState == 'Wyoming') echo 'selected'; ?>>Wyoming</option>
                                               </optgroup>
                                                <optgroup label="Canada">
                                                   <option value='Alberta' <?php if ($fldState == 'Alberta') echo 'selected'; ?>>Alberta</option>
                                                   <option value='British Columbia' <?php if ($fldState == 'British Columbia') echo 'selected'; ?>>British Columbia</option>
                                                   <option value='Manitoba' <?php if ($fldState == 'Manitoba') echo 'selected'; ?>>Manitoba</option>
                                                   <option value='New Brunswick' <?php if ($fldState == 'New Brunswick') echo 'selected'; ?>>New Brunswick</option>
                                                   <option value='Newfoundland' <?php if ($fldState == 'Newfoundland') echo 'selected'; ?>>Newfoundland</option>
                                                   <option value='Northwest Territories' <?php if ($fldState == 'Northwest Territories') echo 'selected'; ?>>Northwest Territories</option>
                                                   <option value='Nova Scotia' <?php if ($fldState == 'Nova Scotia') echo 'selected'; ?>>Nova Scotia</option>
                                                   <option value='Nunavut' <?php if ($fldState == 'Nunavut') echo 'selected'; ?>>Nunavut</option>
                                                   <option value='Ontario' <?php if ($fldState == 'Ontario') echo 'selected'; ?>>Ontario</option>
                                                   <option value='Prince Edward Island' <?php if ($fldState == 'Prince Edward Island') echo 'selected'; ?>>Prince Edward Island</option>
                                                   <option value='Quebec' <?php if ($fldState == 'Quebec') echo 'selected'; ?>>Quebec</option>
                                                   <option value='Saskatchewan' <?php if ($fldState == 'Saskatchewan') echo 'selected'; ?>>Saskatchewan</option>
                                                   <option value='Yukon Territory' <?php if ($fldState == 'Yukon Territory') echo 'selected'; ?>>Yukon Territory</option>
                                               </optgroup> 
                                           </select>                                        
                                        </span>                                     
                                    </p>
                                                        
					                <!--Zip Code-->
					                <p class="alt">
						                <label>Zip Code:</label>
						                <span>
							                <input type="text" name="fldZipCode" style="width:80px;margin-right:3px;" value="<?php echo $fldZipCode; ?>">
							                within&nbsp;
							                <select name="fldDistance" style="width: 95px;margin-right:5px;">
							                    <?php
							                    
							                    /*
                                                 * Added First Load & Post Detection of fldDistance - 10 Miles as default
                                                 * @author  Mike Kuczynski
                                                 * @date    2012-02-28
                                                 */
							                    $selectedDistance = "any";
							                    if ($fldDistance) {
							                        $selectedDistance = $fldDistance;
                                                }
                                                /*
                                                 * end
                                                 */
							                    
					                            foreach ($arrDistances as $dist) {

					                                echo '<option value="' . strtolower($dist) . '"';
					                                
					                                if ($selectedDistance == strtolower($dist)) {
					                                    echo ' selected="selected"';
				                                    }
				                                    
				                                    echo ' >' . $dist . ' Miles</option>';
					                            }
					                            ?>
							                </select>										
						                </span>
					                </p>
                    			</div>
                            </fieldset>
                        </div>
                        <div class="col-fieldset-right">
                            <fieldset id="gameStats">
                                <legend>Game Stats</legend>       
                                <?php if (!empty($fldSport)): ?>
                                    <?php if (!empty($fldSportStats)): ?>
                                        <?php $isAlt = 1; ?>
                                        <?php foreach ($fldSportStats as $stat => $value): ?>
                                            <?php
                                            if ($isAlt) {
                                                echo '<p class="alt">';
                                                $isAlt = 0;
                                            } else {
                                                echo '<p>';
                                                $isAlt = 1;
                                            }
                                            ?>
                                                <span>
                                                    <label style="width: 200px;" onclick="label2select(this);"><?php echo $stat; ?></label>
                                                    <input type="text" name="fldStatCategories[<?php echo $stat; ?>]" value="<?php echo $value; ?>">
                                                </span>
                                            </p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <p id="statsBtn">
                                        <span>
                                            <input type="button" onclick="addStatsField();" value="Add More">
                                        </span>
                                    </p>
                                <?php else: ?>                         
                                    <p>
                                        <span>
                                            Select a sport to add game stats
                                        </span>
                                    </p>
                                <?php endif; ?>
                            </fieldset>
                        </div>
                        <div class="clear"></div>
                        <div style="margin-left: auto; margin-right: auto;">
                            <p>
                                <span>
                                    <input type="submit" name="submit" value="Submit" />
                                    <input type="button" value="Back" onclick="javascript:refreshParent();" />
                                    <?php if (!empty($needId)): ?>
                                        <input type="hidden" name="fldNeedId" value="<?php echo $needId; ?>">
                                    <?php endif; ?>
                                </span>
                            </p>
                        </div>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
	</body>
</html>
