<?php

// includes necessary files

require_once 'inc/class/Athlete.php';

require_once 'inc/class/AthleteSearchHelper.php';

require_once 'inc/class/FormHelper.php';

require_once 'inc/class/RequestHelper.php';

require_once 'inc/common_functions.php';

require_once 'inc/page.inc.php';

require_once 'inc/db.inc.php';



// starts the user session and authorizes the user

session_start();

    $network_for = isset($_REQUEST["network_for"])?$_REQUEST["network_for"]:"";

    $ModeType = isset($_REQUEST["mode"])?$_REQUEST["mode"]:"";

if (($_SESSION['mode'] == "") || ($_SESSION['FRONTEND_USER'] == "")) {

    header("Location:index.php");

}

// initializes page variables

$func = new COMMONFUNC; // access to common functions

$athletes = array(); // list of athletes returned by the search query

$isError = FALSE; // flag indicating if an error occurred during the search

$errorMsg = NULL; // error message to display if an error occurred during the search

$coachId = "";

$fldSport = 0;

$UserID = "";







switch ($ModeType) {

        case 'athlete':

            //AthleteID

            $UserID =  isset($_SESSION['Athlete_id'])?$_SESSION['Athlete_id']:"";

			$fldSport = $func->GetValue("tbl_athelete_register","fldSport","fldId",$UserID);

			//$fldSport = $func->GetValue(TBL_HS_AAU_TEAM,"fldSport","fldId",$db3->f('fldSchool'));

			$sportList = array($fldSport);

			$sport1 = each($sportList);

			$coachId = "";

            break;

        case 'coach':

            //HS Coach ID

           $UserID =isset($_SESSION['Coach_id'])?$_SESSION['Coach_id']:"";

			$fldSport = $func->GetValue("tbl_hs_aau_coach","fldSport","fldId",$UserID);

			$sportList = array($fldSport);

			$sport1 = each($sportList);

			$coachId = "";

            break;

        case 'college':

            //College Coach ID

			$UserID =isset($_SESSION['College_Coach_id'])?$_SESSION['College_Coach_id']:"";

            $coachId = RequestHelper::getVar('College_Coach_id', NULL, 'SESSION');

			$sportList = AthleteSearchHelper::getSubscribedSports($coachId); // list of subscribed sports

			

			$sport1 = each($sportList);

			$fldSport1 = RequestHelper::getVar('fldSport', $sport1, 'GET');

			if(count($fldSport1)>0)

				$fldSport = $fldSport1[0];

			else

				$fldSport = $fldSport1;

				

            break;

    }  



//	$coachId = RequestHelper::getVar('College_Coach_id', NULL, 'SESSION');

 // id of the current user (coach)



if (count($sportList) > 0) {

     //gets the first sport in sportList

//   $sport1 = each($sportList);

    // gets form request data

     //validates that requested sport is a subscribed sport

  if (!in_array($fldSport, $sportList)) {

        $fldSport = 10;

    }
	
    }
    $fldClass = RequestHelper::getVar('fldClass', NULL, 'GET');

    $fldDivision = RequestHelper::getVar('fldDivision', NULL, 'GET');

    $fldMinHeight = RequestHelper::getVar('fldMinHeight', NULL, 'GET');

    $fldMaxHeight = RequestHelper::getVar('fldMaxHeight', NULL, 'GET');

    $fldMinWeight = RequestHelper::getVar('fldMinWeight', NULL, 'GET');

    $fldMaxWeight = RequestHelper::getVar('fldMaxWeight', NULL, 'GET');

	$fldTotal_points_min = RequestHelper::getVar('fldTotal_points_min', NULL, 'GET');

	//$fldTotal_points_max = RequestHelper::getVar('fldTotal_points_max', NULL, 'GET');

	$fldIntangible_rating_min = RequestHelper::getVar('fldIntangible_rating_min', NULL, 'GET');

//	$fldIntangible_rating_max = RequestHelper::getVar('fldIntangible_rating_max', NULL, 'GET');

	

    $fldPrimaryPosition = RequestHelper::getVar('fldPrimaryPosition', NULL, 'GET');

    $fldSecondaryPosition = RequestHelper::getVar('fldSecondaryPosition', NULL, 'GET');

    $fld40_yardDash = RequestHelper::getVar('fld40_yardDash', NULL, 'GET');

    $fldShuttleRun = RequestHelper::getVar('fldShuttleRun', NULL, 'GET');

    $fldVertical = RequestHelper::getVar('fldVertical', NULL, 'GET');

    $fldBenchPressMax = RequestHelper::getVar('fldBenchPressMax', NULL, 'GET');

    $fldSquatMax = RequestHelper::getVar('fldSquatMax', NULL, 'GET');

    $fldGPA = RequestHelper::getVar('fldGPA', NULL, 'GET');

    $fldSATScore = RequestHelper::getVar('fldSATScore', NULL, 'GET');

    $fldACTScore = RequestHelper::getVar('fldACTScore', NULL, 'GET');

    $fldClassRank = RequestHelper::getVar('fldClassRank', NULL, 'GET');

	$fldTotal_points = RequestHelper::getVar('fldTotal_points', NULL, 'GET');

    $fldIntendedMajor = RequestHelper::getVar('fldIntendedMajor', NULL, 'GET');

    $fldSchool = RequestHelper::getVar('fldSchool', NULL, 'GET');

    $fldState = RequestHelper::getVar('fldState', NULL, 'GET');

    $fldZipCode = RequestHelper::getVar('fldZipCode', NULL, 'GET');

    $fldDistance = RequestHelper::getVar('fldDistance', NULL, 'GET');
	
	$fldName = RequestHelper::getVar('fldName', NULL, 'GET');



    // gets lists of available search options

    $classList = AthleteSearchHelper::getClassList();

    $divisionList = AthleteSearchHelper::getDivisionList();

    $heightList = AthleteSearchHelper::getHeightList();

    $weightList = AthleteSearchHelper::getWeightList();

	

	$pointList = AthleteSearchHelper::getPointList();

	$ratingList = AthleteSearchHelper::getRatingList();





    $positionList = AthleteSearchHelper::getPositionList($fldSport);

    $gpaList = AthleteSearchHelper::getGPAList();

    $satList = AthleteSearchHelper::getSATScoreList();

    $actList = AthleteSearchHelper::getACTScoreList();

    $classRankList = AthleteSearchHelper::getClassRankList();

	$classRankList = AthleteSearchHelper::getClassRankList();

    $majorList = AthleteSearchHelper::getMajorList();

    $schoolList = AthleteSearchHelper::getSchoolList();

    $stateList = AthleteSearchHelper::getStateList();

    $distanceList = AthleteSearchHelper::getDistanceList();



    // creates the search query based on search paramters

    $select = 'SELECT * FROM ' . TBL_ATHLETE_REGISTER . ' ';



    $where  = "WHERE fldStatus='ACTIVE'";
	if($fldName != "")
	{
		$search_value_array = explode(" ",$fldName);
		if(count($search_value_array) == 1)
		{	
			$first_name = $search_value_array[0];
			$last_name = $search_value_array[0];
			$first_field = "fldFirstname";
			$second_field = "fldLastname";
			$where .= " and ((".$first_field." like '%".$first_name."%') or (".$second_field." like '%".$first_name."%'))";
		}
		else
		{
			$first_name = $search_value_array[0];
			$last_name = $search_value_array[1];
			$first_field = "fldFirstname";
			$second_field = "fldLastname";
			if($first_name != "" || $last_name != "")
			{
				$where .= " and ((".$first_field." like '%".$first_name."%' and ".$second_field." like '%".$last_name."%') or (".$second_field." like '%".$first_name."%' and ".$first_field." like '%".$last_name."%'))";
			}
		}
	}
    $where .= AthleteSearchHelper::getSportCond($fldSport);

    $where .= AthleteSearchHelper::getClassCond($fldClass);

    $where .= AthleteSearchHelper::getDivisionCond($fldDivision);

    $where .= AthleteSearchHelper::getHeightCond($fldMinHeight, $fldMaxHeight);

    $where .= AthleteSearchHelper::getWeightCond($fldMinWeight, $fldMaxWeight);

	

	$where .= AthleteSearchHelper::getPointCond($fldTotal_points_min, "");

	$where .= AthleteSearchHelper::getRatingCond($fldIntangible_rating_min, "");

	

	

    $where .= AthleteSearchHelper::getPositionCond('primary', $fldPrimaryPosition);

    $where .= AthleteSearchHelper::getPositionCond('secondary', $fldSecondaryPosition);

    $where .= AthleteSearchHelper::get40YardDashCond($fld40_yardDash);

    $where .= AthleteSearchHelper::getShuttleRunCond($fldShuttleRun);

    $where .= AthleteSearchHelper::getVerticalJumpCond($fldVertical);

    $where .= AthleteSearchHelper::getBenchPressCond($fldBenchPressMax);

    $where .= AthleteSearchHelper::getSquatCond($fldSquatMax);

    $where .= AthleteSearchHelper::getGPACond($fldGPA);

    $where .= AthleteSearchHelper::getSATCond($fldSATScore);

    $where .= AthleteSearchHelper::getACTCond($fldACTScore);

    $where .= AthleteSearchHelper::getClassRankCond($fldClassRank);

    $where .= AthleteSearchHelper::getMajorCond($fldIntendedMajor);

    $where .= AthleteSearchHelper::getSchoolCond($fldSchool);

    $where .= AthleteSearchHelper::getStateCond($fldState);

    $where .= AthleteSearchHelper::getSchoolsInDistance($fldZipCode, $fldDistance);



    $query  = $select . $where." ORDER BY fldTotal_points DESC , fldIntangible_rating DESC";



    // creates pagination

    if (!$db->query($query)) {

        die(mysql_error() . '<br>' . $query);

    }



    $page = new Page();



    $page->set_page_data('', $db->num_rows(), 8, 5, true, false, true);



    $data = $_GET;

    unset($data['page']);

    unset($data['submit']);



    if (count($data) > 0) {

        $page->set_qry_string(http_build_query($data));

    }



    $query = $page->get_limit_query($query);

    // retrieves athletes matching search critera from the

    // database and parses the results to be redered to the page

    if (!$db->query($query)) {

        die(mysql_error() . '<br>' . $query);

    }



    if ($db->num_rows() == 0) {

        $isError  = TRUE;

        $errorMsg = 'We currently do not have any available athletes meeting ' .

                    'your search criteria. Please broaden the criteria to find ' .

                    'the athlete you are looking for.';

    }



    while ($db->next_record()) {

        $a = new Athlete;

        

        $a->gradClass = htmlentities($db->f('fldClass'));

        $a->fname = htmlentities($db->f('fldFirstname'));

        $a->id = intval($db->f('fldId'));

        $a->imageURL = 'athimages/' . urlencode($db->f('fldImage'));

        $a->lname = htmlentities($db->f('fldLastname'));

		

		$a->hight = htmlentities($db->f('fldHeight'));

		$a->ppos = htmlentities($db->f('fldPrimaryPosition'));

		$a->spos = htmlentities($db->f('fldSecondaryPosition'));

		$a->fldTotal_points = htmlentities($db->f('fldTotal_points'));

		$a->sportname = htmlentities($func->GetValue("tbl_sports","fldSportsname","fldId",$db->f('fldSport')));

		$a->team = htmlentities($func->GetValue(TBL_HS_AAU_TEAM,"fldSchoolname","fldId",$db->f('fldSchool')));

		//$this->GetValue(TBL_HS_AAU_TEAM,"fldSchoolname","fldId",$db3->f('fldSchool'));

		

		

        $a->mapURL = 'ViewAthleteMap.php?fldId=' . $a->id;

        $a->profileURL = 'ViewAthleteprofile.php?mode=view&fldId=' . $a->id;

        $a->sport = intval($db->f('fldSport'));

        

        $athletes[] = $a;

    }

/*} else {

    $isError  = TRUE;

    $errorMsg = 'You must purchase a subscription in order to search for athletes';

}*/



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"

"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>College Prospect Network - Athlete Search</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="css/style.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>

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

            

            // gets list of positions from the database for the specified sport

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

                        var selectSP = $("[name='fldSecondaryPosition']");

                        

                        // clears current position lists

                        selectPP.html("");

                        selectSP.html("");

                        

                        selectPP.append(makeOption("", "Any Position"), false);

                        selectSP.append(makeOption("", "Any Position"));





                        

                        var positions = JSON.parse(data);

                        for (var i in positions) {

                            var sel = false;

                            

                            if (selected == positions[i]) {

                                sel = true;

                            }

                            

                            selectPP.append(makeOption(positions[i], positions[i], sel));

                            selectSP.append(makeOption(i, positions[i]));

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

            

            // executes when the page is done loading

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

		<style type="text/css">

		.box_list ul,li{ list-style:none;float:left;}

		</style>

</head>

<body>

<?php include 'header.php'; ?>

<div class="container" style="background-size: 978px 800px;">

  <div class="innerWraper">

    <div class="middle-bg">

      <div class="cantener">

        <div class="register-main">

          <div class="registerPage advancedsearch">

            <?php if ($isError): ?>

            <div class="thankyoumessage"> <?php echo $errorMsg; ?> </div>

            <?php endif; ?>

            <form name="frmAthReg" action="" method="get" enctype="multipart/form-data" onsubmit="return validate()">

              <h1 style="float:left;margin-bottom:15px;">Athlete Search</h1>

              <div class="form-footnote" style="float:right;color:#777;font-size:13px;margin-left:15px;padding-top:7px;"> * All Search Fields are optional </div>

              <div class="clear"></div>
				<div class="col-fieldset-left">
					<fieldset>
						<legend>Basic Details</legend>
							<!-- HS/AAU Team -->
							<p class="alt">
								<label>Athlete Name:</label>
								<span>
									 <input type="text" name="fldName" style="width:80px;margin-right:3px;" value="<?php echo $fldName; ?>" />
								</span>
							</p>
					</fieldset>
				</div>
              <fieldset>

              <legend>Athletic Stats</legend>

              <div class="formarea">

                <div class="col-left">

                  <?php require 'athleteSearch_AthStatsLeft.php'; ?>

                </div>

                <div class="col-right">

                  <?php require 'athleteSearch_AthStatsRight.php'; ?>

                </div>

                <div class="clear"></div>

              </div>

              </fieldset>

              <fieldset>

              <legend>Athletic Points and Intangible Ratings</legend>

              <div class="formarea">

                <div class="col-left">

                  <p>

                    <label>Points:</label>

                    <span>

                    <select name="fldTotal_points_min">

                      <option value="" class="selectgrey">Any Point</option>

                      <?php

										echo FormHelper::array2options(

											$pointList,

											$fldTotal_points_min

										);

									?>

                    </select>

                    </span>

                    <?php /*?><span style="padding-top:3px;">

								<select name="fldTotal_points_max">

									<option value="" class="selectgrey">Any Max Point</option>

									<?php

										echo FormHelper::array2options(

											$pointList,

											$fldTotal_points_max

										);

									?>

								</select>

							</span><?php */?>

                  </p>

                </div>

                <div class="col-right">

                  <p>

                    <label>Ratings:</label>

                    <span style="padding-top:3px;">

                    <select name="fldIntangible_rating_min">

                      <option value="" class="selectgrey">Any Rating</option>

                      <?php

										echo FormHelper::array2options(

											$ratingList,

											$fldIntangible_rating_min

										);

									?>

                    </select>

                    </span>

                    <?php /*?><label>&nbsp;</label>

							<span style="padding-top:3px;">

								<select name="fldIntangible_rating_max">

									<option value="" class="selectgrey">Any Max Rating</option>

									<?php

										echo FormHelper::array2options(

											$ratingList,

											$fldIntangible_rating_max

										);

									?>

								</select>

							</span><?php */?>

                  </p>

                </div>

                <div class="clear"></div>

              </div>

              </fieldset>

              <div class="col-fieldset-left">

                <fieldset>

                <legend>Academic Stats</legend>

                <?php require 'athleteSearch_AcadStats.php'; ?>

                </fieldset>

                <fieldset>

                <legend>Location</legend>

                <?php require 'athleteSearch_Location.php'; ?>

                </fieldset>

              </div>

              <div class="col-fieldset-right">

                <fieldset>

                <legend>Game Stats</legend>

                <?php require 'athleteSearch_GameStats.php'; ?>

                </fieldset>

              </div>

              <div class="clear"></div>

              <p style="padding-top:10px;padding-bottom:10px;"> <span>

                <input type="hidden" name="network_for" id="network_for" value="<?php echo $network_for;?>" />

                <input type="hidden" name="mode" id="mode" value="<?php echo $ModeType;?>" />

                <input type="submit" name="submit" value="Search"/>

                <input type="button" value="Back" onclick='javascript:window.open("my_network.php?network_for=<?php echo $network_for;?>&mode=<?php echo $ModeType;?>", "_self");'>

                </span> </p>

            </form>

            <?php if (!$isError): ?>

            <div style="clear:both;"></div>

			

            <ul class="box_list">

              <?php foreach ($athletes as $a): ?>

              <li>

                <table cellpadding="5" cellspacing="5" class="table_main">

                  <tr>

                    <td class="table_main_td1"><table cellpadding="2" cellspacing="2" class="table_main_first">

                        <tr>

                          <td><center>

                              <div class="viewhim_" id="viewhim_<?php echo $a->id; ?>"> <a href="<?php  echo $a->profileURL; ?>" title="<?php   echo html_entity_decode($a->fname); ?>">

                               

                                <img src="<?php echo $a->imageURL; ?>" title="<?php   echo html_entity_decode($a->fname); ?>" style="margin:5px 5px 1px 5px;" width="88px" height="119px" /> </a>

                                <div class="view_" id="view_<?php echo $a->id; ?>">

                                  <?php

						if($_SESSION['fldSubscribe'] == 2) {         

							echo '<a href="javascript:void(0);" onclick="alert(\'Sorry, this feature is disabled in Trial Mode, please purchase a Subscription. \');">Send Message</a>';

						} else {                                      

						?>

                                  <a href="javascript:void(0);" onclick="window.open('sendmsgtoath.php?id=<?php  echo $a->id;?>&usertype=athlete','windowname1', 'width=665, height=350'); return false;">Send Message</a>

                                  <?php

						 }

						?>

                                </div>

								<div><img src="images/Coins.png" width="20px" height="20px" style="margin:0px 5px 0px 5px;float:left; "/><div class="totpoint" style="color:#0066CC;"><?php echo $a->fldTotal_points; ?></div></div>

								</div>

                              </div>

                            </center></td>

                        </tr>

                      </table></td>

                    <td class="table_main_td2"><div class="showbutton_" id="showbutton_<?php echo $a->id; ?>">

                        <table cellpadding="2" border="0" cellspacing="2" class="table_second">

                          <tr>

                            <td><div class="td_div">

                                <label class="lbl_name">Athlete Name:</label>

								<label class="lbl_value">

                                <a href="<?php echo $a->profileURL; ?>" title="<?php echo html_entity_decode($a->fname); ?>"> <?php echo html_entity_decode($a->fname); ?> </a> 

								</label>

								</div>

							</td>

                          </tr>

                          <tr>

                            <td><div class="td_div">

                                <label class="lbl_name">Athlete Team:</label>

                                <label class="lbl_value"><?php echo html_entity_decode($a->team); ?></label>

                              </div></td>

                          </tr>

                          <tr>

                            <td><div class="td_div">

                                <label class="lbl_name">Sport:</label>

                                <label class="lbl_value"><?php echo html_entity_decode($a->sportname); ?></label>

                              </div></td>

                          </tr>

                          <tr>

                            <td><div class="td_div">

                                <label class="lbl_name">Athlete Height:</label>

                                <label class="lbl_value"><?php echo html_entity_decode($a->hight); ?></label>

                              </div></td>

                          </tr>

                          <tr>

                            <td><div class="td_div">

                                <label class="lbl_name">Primary Position:</label>

                                <label class="lbl_value"><?php echo html_entity_decode($a->ppos); ?></label>

                              </div></td>

                          </tr>

                          <tr>

                            <td><div class="td_div">

                                <label class="lbl_name">Secondary Position:</label>

                                <label class="lbl_value"><?php echo html_entity_decode($a->spos); ?></label>

                              </div>

                              <div id="showbox_<?php echo $a->id; ?>" class="showbox_"> <a href="javascript:void(0);" style="" onclick="sendNetworkRequest('<?php echo $a->id?>','<?php echo $ModeType;?>','<?php echo $UserID;?>','athlete')">Send Request</a></div></td>

                          </tr>

                        </table>

                      </div></td>

                  </tr>

                </table>

                <script language="javascript" type="text/javascript">

					try

					{

						/******* For Send Message Function ********/

						$('#viewhim_<?php echo $a->id; ?>').hover(function() {

						 $(this).find("img").animate(

							{opacity:"0.5"},

							{duration:300}

						  );

							$("#view_<?php echo $a->id; ?>").fadeIn(500);

						}, function() {

						 $(this).find("img").animate(

							{opacity:"1"},

							{duration:300}

						  );

							$("#view_<?php echo $a->id; ?>").fadeOut(500);

						});

						/******* For Send Message Function ********/

						

						/******* For Send Request Function ********/

						$('#showbutton_<?php echo $a->id; ?>').hover(function() {

							$("#showbox_<?php echo $a->id; ?>").fadeIn(500);

						}, function() {

							$("#showbox_<?php echo $a->id; ?>").fadeOut(500);

						});

						/******* For Send Request Function ********/

					}

					catch(ex)

					{

						alert(ex.message);

					}

				</script>

              </li>

              <?php endforeach; ?>

            </ul>

            <br />

            <div style="clear:both;"></div>

            <?php echo $page->get_page_nav(); ?>

            <?php endif; ?>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<script language="javascript" type="text/javascript">

		function sendNetworkRequest(fldId,senderType,senderID,receoverType)

		{ 

			try{

				$.post("NetworkRequestAjax.php", { mode: 'request' , fldId:fldId, SenderUserType: senderType, SenderUserID: senderID, ReceiverUserType: receoverType },

				   function(data) {

					if(data == "RequestSending")

						{

							alert("Thank you, your Network Request has been successfully sent.  You will be notified when they accept or deny request.");

						}

						else if(data == "RequestPending")

						{

							alert("Sorry, there is already an Active or Pending Network Request with this user.");

						}

				   });

			}

			catch(ex)

			{

				alert(ex.message);

			}

		}

		</script>

<?php include 'footer.php'; ?>

</body>

</html>

