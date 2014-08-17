<?php

    ##******************************************************************

    ##  Project		:		Sport Social Networking - Admin Panel

    ##  Done by		:		Narendra Singh

    ##	Page name	:		ViewAthleteprofile.php

    ##	Create Date	:		17/07/2011

    ##  Description :		It is use to shoe the athlete profile.

    ##	Copyright   :       Synapse Communications Private Limited.

    ## *****************************************************************

    include_once ("inc/common_functions.php");

    //for common function

    include_once ("inc/page.inc.php");

    session_start();

    if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {

        header("Location:index.php");

    }

	  $func = new COMMONFUNC;

    $func2 = new COMMONFUNC;



	if(isset($_SESSION['Athlete_id']) && $_SESSION['Athlete_id'] != "" && $_SESSION['Athlete_id'] != 0)

	{

		$UserID =$_SESSION['Athlete_id'];

		/********* Athelete Rate Checking****************/

			require_once("athlete_rating.php");

		/********* Athelete Rate Checking****************/

	}

	else if(isset($_SESSION['Coach_id']) && $_SESSION['Coach_id'] != "" && $_SESSION['Coach_id'] != 0)

	{

		$UserID =$_SESSION['Coach_id'];

	}

	else if(isset($_SESSION['College_Coach_id']) && $_SESSION['College_Coach_id'] != "" && $_SESSION['College_Coach_id'] != 0)

	{

		$UserID =$_SESSION['College_Coach_id'];

	}



    //for paging



	if(isset($_REQUEST['fldId']) && $_REQUEST['fldId']!= "" && $_REQUEST['fldId'] != 0)

	{

		$func2 -> athlete_view_profile($_REQUEST['fldId']);

    }

	//Create an instance of class COMMONFUNC

    $page = new Page();

    //Create an instance of class Pate

    $lnb = "2";

    $error_msg = '';

    $db2 = new DB;

    $db4 = new DB;



   //Local Variables

    $IsMyProfile = 0;



    #######################################

    ## SEND NETWORK REQUEST

    //Insert, Display Notification, and Email Recipient



   $GLOBALPage = "ViewAthleteprofile.php?mode=view&fldId=";

   $GLOBALProfileType = "athlete";

   include("inc/NetworkRequest.php");

   #######################################





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>College Prospect Network - Athlete Profile</title>

		<META NAME="Keywords" CONTENT="">

		<META NAME="Description" CONTENT="">

		<link href="css/style.css" rel="stylesheet" type="text/css" />

		<script language="Javascript" src="javascript/functions.js"></script>

		<script language="JavaScript" type="text/JavaScript">



		</script>

		<script type="text/javascript" src="<?php echo SITE_URL ?>mediaplayer/jwplayer.js"></script>

		<script type="text/javascript">

		function networkRequest(fldId,sessionID)

		{

			try

			{

				if(sessionID == 2)

				{

					alert("Sorry, this feature is disabled in Trial Mode, please purchase a Subscription.");

				}

				else

				{

					if(confirm("Sure you want to send this Network Request?")) {

						document.frmUsers.action = "?mode=request&fldId=" + fldId;

						document.frmUsers.submit();

					}

				}

			}catch(ex){alert(ex.message);}

        }

		function send_message(sessionID,fldID)

		{

			try

			{

				if(sessionID == 2)

				{

					alert("Sorry, this feature is disabled in Trial Mode, please purchase a Subscription.");

				}

				else

				{

					window.open("sendmsgtoath.php?id="+fldID+"&usertype=athlete","windowname1", "width=665, height=350");

				}

				return false;

			}catch(ex){alert(ex.message);}

		}

		function rate_this_athlete(fldID,isAdded)

		{

			try

			{

				if(isAdded == 1)

				{

					fldID+="&mode=view";

				}

				window.open("RatingAthlete.php?fldId="+fldID,"windowname1", "width=560, height=560");

				//return false;

			}catch(ex){alert(ex.message);}

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

				<div class="middle-bg profile">

					<div class="boxmsg" style="display:none;">

                        This section is currently under Maintenance

                    </div>

					<form name="frmUsers" action="" method="post">

						<?php



                            #########################################

	                        ## Get Athlete Data

	                        #########################################



                            //Build Query - by query or session variable

                            if ($_REQUEST['fldId'] != '') {

                                //get querystring fldId

                                $query = " Select * from " . TBL_ATHELETE_REGISTER . " where fldId = " . $_REQUEST['fldId'];

                            } else {

                                //get session Athlete_id

                                $query = " Select * from " . TBL_ATHELETE_REGISTER . " where fldId = " . $_SESSION['Athlete_id'];

                            }

                            //Get Query Results

                            $db -> query($query);

                            $db -> next_record();



                            //Get Query Results

                            $db2 -> query($query);

                            $db2 -> next_record();

                            $User_ID = $db -> f('fldId');

                            //Detect if this Athlete is Athlete viewing profile

                            $fldId = $func -> output_fun($db -> f('fldId'));

                            if (($_REQUEST['fldId'] == $_SESSION['Athlete_id']) and ($_SESSION['mode']=='athlete')){

                                $IsMyProfile = 1;

                            }



                            //Bind Data

                            $fldUsername = $func -> output_fun($db -> f('fldUsername'));

                            $fldFirstname = $func -> output_fun($db -> f('fldFirstname'));

                            $fldLastname = $func -> output_fun($db -> f('fldLastname'));

                            $fldImage = $func -> output_fun($db -> f('fldImage'));

                            $fldDescription = $func -> output_fun($db -> f('fldDescription'));

                            $fldDescription = str_replace("\n", "<br>", $fldDescription);

                            $fldEmail = $func -> output_fun($db -> f('fldEmail'));

                            $fldComments = $func -> output_fun($db -> f('fldComments'));

                            $fldDivision = $func -> output_fun($db -> f('fldDivision'));

                            $fldSchool = $func->output_fun($db->f('fldSchool'));

                            //$fldId = $func -> output_fun($db -> f('fldId'));

                            $fldForvideoId = $db -> f('fldId');

                            $fldApproveCoachId = $db -> f('fldApproveCoachId');

                            $fldJerseyNumber = $db -> f('fldJerseyNumber');

                            $fldSport = $func -> output_fun($db -> f('fldSport'));



                           //Get Sport Name

                            $sportquery = "SELECT fldSportsname  from " . TBL_SPORTS . "  WHERE fldId='$fldSport'";

                            $db1->query($sportquery);

                            $db1->next_record();

                            $sports_name = $func->output_fun($db1->f('fldSportsname'));



						?>



						<?php

                        if ($_REQUEST['msg']) {

						?>

						<div class="thankyoumessage">

							<?php     echo $_REQUEST['msg'];?>

						</div>

						<?php

                        }?>



                        <?php

                        if ($_REQUEST['errormsg']) {

                        ?>

                        <div class="errormessage">

                            <?php     echo $_REQUEST['errormsg'];?>

                        </div>

                        <?php

                        }?>





						<!--left-panel starts from here -->



						<?php

						$AthleteFullName = ucfirst($fldFirstname) . '&nbsp;' . ucfirst($fldLastname);

						If ($_SESSION['fldSubscribe'] == 2) {

						    $AthleteFullName = ucfirst($fldFirstname);

                        }

						?>



						<div style="float:left;width:400px;"><h1><?     echo $AthleteFullName . ' - #' . $fldJerseyNumber;?></h1></div>

                        <div style="float:right;width:400px;font-size:17px;text-align:right;padding-right:20px;"><span style="color:#999;font-size:14px;">Username:</span> <span style="font-weight:normal;"><?=$fldUsername?></span></div>

                        <div class="clear"></div>





						<div class="left-panel">

							<div class="mid-con">



								<div class="registerPage1">

									<div class="left-col">

										<p>

											<?php

											############ Profile Image  ###########

                                            if ($fldImage != "") {

											?><img src="athimages/<?php  echo $fldImage;?>" width="140">

											<?

                                                } else {

                                                $noimage = 'no-pre.png';

											?><img src="athimages/<?php  echo $noimage;?>" width="140" >

											<?

                                                }

											?>

										</p>



								        <?php



                                        if (($_REQUEST['fldId'] != "") AND ($IsMyProfile == 0)) {

                                           ############ Send Message  ###########

                                        ?>

										<div class="btnclass1">

											<p>

												<span>

													<INPUT TYPE="BUTTON" VALUE="Send Message" onclick="send_message('<?php echo $_SESSION['fldSubscribe']?>','<?  echo $fldId;?>')">

												</span>

											</p>

										</div>

							             <?php





										$isDisable_View_Ratings = 'disabled="disabled"';

										$hasvoted = 0;

										$Value_View_Ratings = "Rate This Athlete";

										############ Display for HS COACH    ###########

                                        if (($_SESSION['mode'] == 'coach') and ($fldApproveCoachId != '0')) {

											$isDisable_View_Ratings = '';



											$coach_query = "select * from " . TBL_HS_AAU_COACH . " where fldUsername ='" . $_SESSION['FRONTEND_USER'] . "'";

											$db1 -> query($coach_query);

											$db1 -> next_record();

											$coach_id = $db1 -> f('fldId');

											$whereClause = "fldAthlete_id=" . $_REQUEST['fldId'] . " and fldCoach_id=" . $coach_id;

											if ($db -> MatchingRec(TBL_RATING, $whereClause) > 0) {

												$hasvoted = 1;

												$Value_View_Ratings = "View Ratings";

											}

										}

										############ Display for HS COACH    ###########

										############ College - View Ratings  ###########

										if (($_SESSION['mode'] == 'college') and($fldApproveCoachId != '0')) {

												$hasvoted = 1;

												$Value_View_Ratings = "View Ratings";

												$isDisable_View_Ratings = '';

										}

										############ College - View Ratings  ###########



                                        ?>

										<div class="btnclass1">

											<p>

												<span>

                                                    <INPUT TYPE="BUTTON" VALUE="<?php echo $Value_View_Ratings;?>" onclick="rate_this_athlete('<?  echo $_REQUEST['fldId'];?>','<?  echo $hasvoted;?>')" <?php echo $isDisable_View_Ratings;?>>

												</span>

											</p>

										</div>

										<?php



										############ Network Request  ###########

                                        if (($fldApproveCoachId != '0'))

										{

											if($func->IsMyNetwork ($UserID,$_REQUEST['fldId']) == 0)

											{

											?>

										<div class="btnclass1">

                                        <p>

                                        <span>

										<INPUT TYPE="BUTTON" VALUE="Add To Network" onclick="networkRequest('<?php echo $_REQUEST['fldId'];?>','<?php echo $_SESSION['fldSubscribe'];?>'); ">

										</span>

                                        </p>

                                        </div>

										<?php }

										}

										############ Network Request  ###########



									  }

										?>

									</div>

								</div>

								<div class="right-col">

									<h3>Athletic Stats</h3>

									<div class="boxes">

										<table width="100%" cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" style="border-collapse: collapse;" class="tablePadd">

											<tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat"><b>Sport:</b>&nbsp;<?php echo $sports_name; ?></td>

                                            </tr>

                                            <tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat"><b>Class:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldClass')) {

                                                        echo $db2 -> f('fldClass');

                                                    } else {

                                                        echo "N/A";

                                                    }

                                                ?></td>

                                            </tr>

                                            <tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat" ><b>Height:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldHeight')) {

                                                        echo $db2 -> f('fldHeight');

                                                    } else {

                                                        echo "N/A";

                                                    }

                                                ?></td>

                                            </tr>

                                            <tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat" ><b>Weight:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldWeight')) {

                                                        echo $db2 -> f('fldWeight');

                                                    } else {

                                                        echo "N/A";

                                                    }

                                                ?></td>

                                            </tr>

											<tr>

												<td valign="middle"  align="left" class="normalblack_12_stat"><b>Primary Position:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldPrimaryPosition')) {

                                                        echo $db2 -> f('fldPrimaryPosition');

                                                    } else {

                                                        echo "N/A";

                                                    }

												?></td>

											</tr>

											<tr>

												<td valign="middle"  align="left" class="normalblack_12_stat" ><b>Secondary Position:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldSecondaryPosition')) {

                                                        echo $db2 -> f('fldSecondaryPosition');

                                                    } else {

                                                        echo "N/A";

                                                    }

												?></td>

											</tr>

											<tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat"><b>Bench Press:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldBenchPressMax')) {

                                                        echo $db2 -> f('fldBenchPressMax');

                                                    } else {

                                                        echo "N/A";

                                                    }

                                                ?></td>

                                            </tr>

                                            <tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat"><b>Squat Max:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldSquatMax')) {

                                                        echo $db2 -> f('fldSquatMax');

                                                    } else {

                                                        echo "N/A";

                                                    }

                                                ?></td>

                                            </tr>

											<tr>

												<td valign="middle"  align="left" class="normalblack_12_stat"><b>40-yard Dash:</b>&nbsp;<?php

                                                    if ($db2 -> f('fld40_yardDash')) {

                                                        echo $db2 -> f('fld40_yardDash');

                                                    } else {

                                                        echo "N/A";

                                                    }

												?></td>

											</tr>

											<tr>

												<td valign="middle"  align="left" class="normalblack_12_stat" ><b>Shuttle Run:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldShuttleRun')) {

                                                        echo $db2 -> f('fldShuttleRun');

                                                    } else {

                                                        echo "N/A";

                                                    }

												?></td>

											</tr>

											<tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat" ><b>Vertical Jump:</b>&nbsp;<?php

                                                    if ($db2 -> f('fldVertical')) {

                                                        echo $db2 -> f('fldVertical');

                                                    } else {

                                                        echo "N/A";

                                                    }

                                                ?></td>

                                            </tr>



										</table>

										</div>







										<h3 style="float:left;"><?php echo $sports_name; ?> Stats Summary</h3>

										<div style="float:right;">

										    <?php

                                            If ($_SESSION['fldSubscribe'] != 2) {

                                            ?>



                                                    <?php

                                                        if ($_SESSION['Athlete_id']) {

                                                            $id = $_SESSION['Athlete_id'];

                                                        } else {

                                                            $id = $_REQUEST['fldId'];

                                                        }

                                                        $pageURL = "viewallstats.php?id=$id";

                                                        echo '<a href="javascript:ShowDetails(\'' . $pageURL . '\')" > View Game Log</a>';

                                                    ?>



                                            <?php

                                            }

                                            ?>

                                        </div>

										<div class="clear"></div>



										<div class="boxes">



											<?php



                                                $query = "SELECT first.fldLabelname as lname, SUM(first.fldValue) as value,count(first.fldCategoryId) as count, second.fldNameint as initial  FROM tbl_athelete_stat first, tbl_athlete_stats_catagory second where (first.fldStatus=1 and  first.fldCategoryId=second.fldId  and first.fldAtheleteId='" . $fldId. "') GROUP BY first.fldLabelname ORDER BY second.fldSortOrder ASC";

                                                $db4 -> query($query);

                                                $db4 -> next_record();

                                                $itemcount = 0;

                                                $itemtotal= $db4 -> num_rows();

                                                $itemsin1col = $itemtotal / 2;

                                                $flagnewcol = 0;



                                                if ($db4 -> num_rows() > 0) {

                                                    //Show Data

                                                    for ($i = 0; $i < $db4 -> num_rows(); $i++) {

                                                        $Label = $func -> output_fun($db4 -> f('lname'));

                                                        $value = $func -> output_fun($db4 -> f('value'));

                                                        $count = $func -> output_fun($db4 -> f('count'));

                                                        $Initial = $func -> output_fun($db4 -> f('initial'));

                                                        $final = $value / $count;

                                                        $final = number_format($final, 1, '.', '');



                                                        if ($itemcount == 0) {

                                                         echo '<ul class="stats">' . "\r\n";

                                                         }



                                                        if ($itemcount > $itemsin1col && $flagnewcol == 0) {

                                                         echo '</ul><ul class="stats stats-rightcol">' . "\r\n";

                                                            $flagnewcol = 1;

                                                         }



                                                        echo '<li><span>' . $Label . '</span>:&nbsp;' . $final . '</li>' . "\r\n";



                                                        $itemcount = $itemcount + 1;

                                                        $db4 -> next_record();

                                                    }



                                                    echo '</ul><div class="clear"></div>' . "\r\n";





                                                } else {



                                                    //No Stats Data

                                                    echo "Athlete has not entered any stats";

                                                }

											?>



									</div>

									<!--end Game Stats Summary-->





									<div>

										<h3>Academic Stats</h3>

										<div class="boxes">

											<table width="100%" cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" style="border-collapse: collapse;" class="tablePadd">

												</tr>

												<tr>

													<td valign="middle"  align="left" class="normalblack_12_stat"><b>GPA:</b>&nbsp;<?php

                                                        if ($db2 -> f('fldGPA')) {

                                                            echo $db2 -> f('fldGPA');

                                                        } else {

                                                            echo "N/A";

                                                        }

													?></td>

													<td valign="middle"  align="left" class="normalblack_12_stat"><b>ACT Score:</b>&nbsp;<?php

                                                        if ($db2 -> f('fldACTScore')) {

                                                            echo $db2 -> f('fldACTScore');

                                                        } else {

                                                            echo "N/A";

                                                        }

													?></td>

												</tr>

												<tr>

													<td valign="middle"  align="left" class="normalblack_12_stat"><b>SAT Score:</b>&nbsp;<?php

                                                        if ($db2 -> f('fldSATScore')) {

                                                            echo $db2 -> f('fldSATScore');

                                                        } else {

                                                            echo "N/A";

                                                        }

													?></td>

													<td valign="middle"  align="left" class="normalblack_12_stat"><b>Clearinghouse Eligible:</b>&nbsp;<?php

                                                        if ($db2 -> f('fldClearinghouseEligible')) {

                                                            echo $db2 -> f('fldClearinghouseEligible');

                                                        } else {

                                                            echo "N/A";

                                                        }

                                                    ?></td>

												</tr>

												<tr>

													<td valign="middle"  align="left" class="normalblack_12_stat"><b>Class Rank:</b><br /><?php

                                                        if ($db2 -> f('fldClassRank')) {

                                                            echo $db2 -> f('fldClassRank');

                                                        } else {

                                                            echo "N/A";

                                                        }

													?></td>

													<td valign="middle"  align="left" class="normalblack_12_stat"><b>Intended Major:</b><br /><?php

                                                        if ($db2 -> f('fldIntendedMajor')) {

                                                            echo $db2 -> f('fldIntendedMajor');

                                                        } else {

                                                            echo "N/A";

                                                        }

                                                    ?></td>

												</tr>

											</table>

										</div>

									</div>

								</div>

								<div class="clr"></div>

								<div class="full-col">

									<h3>Athlete Bio</h3>

									<div class="boxes">





											<?php

                                            if ($fldDescription != '')

                                            {

                                                echo $fldDescription;



                                            }

                                            else

                                            {

                                                echo 'Not Available';

                                            }

                                            ?>



									</div>

								</div>

								<div class="full-col">



									<h3 style="float:left;">Comments From My Coach</h3>

									<div style="float:left;padding:4px 0 0 30px;"><?php

									    ##Display Edit Comment if this is their Coach

									    //Detect if is HS Coach

									    if ($_SESSION['mode'] == 'coach' && $_SESSION['Coach_id'] == $fldApproveCoachId)

                                        {

                                            //Detect if is their coach

    									    // $selquery2 = "select fldSchool from " . TBL_HS_AAU_COACH . " where fldId='" . $_SESSION['Coach_id'] . "'";

                                            // $db2 -> query($selquery2);

                                            // $db2 -> next_record();

                                            // $fldSchool = $func -> output_fun($db2 -> f('fldSchool'));



    									    $pageURL = "Popup-AthMyCoach-Division-Comment.php?AthId=$id";

                                            echo '<a href="javascript:Showcomments(\'' . $pageURL . '\',\'name\',\'700\',\'400\')" >Edit My Projection & Comment</a>';

                                        }

									    ?>

                                    </div>

									<div class="clear"></div>



									<div class="boxes">



									       <?php

                                            if ($fldDivision != '' && $_SESSION['mode'] == 'college')

                                            {

                                                if ($fldDivision == "DivisionI") {$fldDivision = "Division I";};

                                                if ($fldDivision == "DivisionII") {$fldDivision = "Division II";};

                                                if ($fldDivision == "DivisionIII") {$fldDivision = "Division III";};



                                                echo "<b>Projected Division:</b> " . $fldDivision . "<br /><br />";

                                            }

                                            ?>



                                              <?php

                                            if ($_SESSION['mode'] == 'coach' && $_SESSION['Coach_id'] == $fldApproveCoachId)

                                            {

                                                if ($fldDivision == "DivisionI") {$fldDivision = "Division I";};

                                                if ($fldDivision == "DivisionII") {$fldDivision = "Division II";};

                                                if ($fldDivision == "DivisionIII") {$fldDivision = "Division III";};



                                                echo "<b>Projected Division:</b> " . $fldDivision . " &nbsp;&nbsp;&nbsp;<font style='color:red;'>**Division only visible for College Coaches**</font><br /><br />";

                                            }

                                            ?>



											<?php

											if ($fldComments != '')

                                            {

                                                $fldComments = str_replace("\n", "<br>", $fldComments);

                                                echo $fldComments;

                                            }

                                            else

                                            {

                                                echo 'No Records Available';

                                            }

                                            ?>



									</div>

								</div>

								<div class="full-col">

									<h3>Comments From Opposing Coach</h3>

									<div class="boxes">

										<?php

                                        if ($_REQUEST['fldId']) {

                                        $query_banner = "Select * from tbl_opp_comments where fldathleteid = " . $_REQUEST['fldId'];

                                        } else {

                                        $query_banner = "Select * from tbl_opp_comments where fldathleteid = " . $_SESSION['Athlete_id'];

                                        }

                                        $db->query($query_banner);

                                        $db->next_record();

                                        if ($db->num_rows() > 0) {

                                        $count = "1";

                                        for ($i = 0; $i < $db->num_rows(); $i++) {

										?>



											<?php

											$OppComment = $func -> output_fun($db -> f('fldOppComments'));

											$OppComment = str_replace("\n", "<br>", $OppComment);

											echo $count . ':&nbsp;' . $OppComment;

											?>



										<?php

                                            $db -> next_record();

                                            $count++;

                                            }

                                            } else {

                                            echo 'No Records Available';

                                            }

										?>

									</div>

								</div>

							</div>

						</div>

						<!--right panel starts from here -->

						<div class="right-panel">

                            <div style="padding-top:0;">

                                <h3>HS / AAU Coach Quick Glance:</h3>

                                <div class="right-boxes">

                                    <?php if ($_SESSION['fldSubscribe'] != 2): ?>

                                        <?php include_once 'athleteProfileHSQuickGlance.php'; ?>

                                    <?php else: ?>

                                        Sorry, this feature is disabled in Trial Mode, please <a href='subscribe.php'>Purchase a Subscription</a>.

                                    <?php endif; ?>

                                </div>

                            </div>

							<div>

								<h3 style="float:left;">Profile Viewed</h3><br /><br />

								 <div class="right-boxes">

								 <?php $Counters =  $func->getViewCount($User_ID);?>

										<table width="100%" cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" style="border-collapse: collapse;" class="tablePadd">

											<tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat"><b>Last Week:</b>&nbsp;<?php echo $Counters["WeeklyCount"]; ?></td>

                                            </tr>

                                            <tr>

                                                <td valign="middle"  align="left" class="normalblack_12_stat"><b>Total Viewed:</b>&nbsp;<?php echo $Counters["TotalCount"];?></td>

                                            </tr>

										</table>

								 </div>

							</div>

							<div>

                                <h3 style="float:left;">Game Film</h3>

                                    <div style="float:right;">



                                      <?php

                                            if ($_REQUEST['fldId']) {

                                               echo ' ';

                                            } else {

                                                echo '<a href="Video-List.php" class="gametape">Manage Game Tape</a>';

                                            }

                                        ?>

                                    </div>

                                    <div class="clear"></div>



								<div class="right-boxesfirst" <?php if (($_SESSION['mode'] == 'college')) { ?>style="margin-bottom:0px;" <?php } ?> >

									<?php

                                        $query_video = " Select * from " . TBL_ATHLETE_VIDEO . " where (fldAthleteId=" . $fldForvideoId . ") And fldStatus='1' ";

                                        $db1 -> query($query_video);

                                        $db1 -> next_record();

                                        if ($db1 -> num_rows() > 0) {

                                        $fldVideo=$db1 -> f('fldVideo');

                                        $imagename = str_replace(".flv", ".jpg", $fldVideo);

									?>

									<div id="jwplayer">Loading the Video Player ...</div>

                                    <script type="text/javascript">

                                        jwplayer("jwplayer").setup({

                                            flashplayer: "/jwplayer/player.swf",

                                            file: "video/<?php echo $fldVideo;?>",

                                            image: "video/<?php echo $imagename;?>",

                                            skin: "skins/stormtrooper/stormtrooper.zip",

                                            controlbar: "bottom",

                                            height: 220,

                                            width: 300

                                        });

                                    </script>



									<?php

									}

                                    else

                                    {

									?>



									User has not added any videos yet.



									<?php

                                     }

                                    ?>

								</div>

							</div>







							<?php if (($_SESSION['mode'] == 'college')) { ?>

							<div class="btnclass2" style="margin-bottom:20px;">

								<p>

									<span>

									    <?php

                                        If ($_SESSION['fldSubscribe'] == 2) {

                                            echo '<INPUT TYPE="BUTTON" VALUE="Request Game Tape" onclick="alert(\'Sorry, this feature is disabled in Trial Mode, please purchase a Subscription. \');">';

                                        } else {

                                        ?>

                                        <input type=BUTTON onclick="window.open('RequestGameTape.php?fldId=<?php  echo $_REQUEST['fldId'];?>','windowname1', 'width=665, height=400'); return false;" value="Request Game Tape">

                                        <?php

                                         }

                                        ?>

									</span>

								</p>

							</div>

							<?php } ?>

						<div style="padding-top:0;">

                                <h3>Comments <?php

								$db_note = new DB;

								$query_note ="";

								$uid = 0;

								if (isset($_REQUEST['fldId']) && $_REQUEST['fldId'] != '')

								{

								   $query_note = "SELECT fldNoteId,fldPostDate FROM tbl_athlete_notes WHERE fldAthleteId = ".$_REQUEST['fldId']." ORDER BY fldPostDate DESC LIMIT 2";

								   $uid = $_REQUEST['fldId'];

								}

								else

								{

								   $query_note = "SELECT fldNoteId,fldPostDate FROM tbl_athlete_notes WHERE fldAthleteId = ".$_SESSION['Athlete_id']." ORDER BY fldPostDate DESC LIMIT 2";

									$uid = $_SESSION['Athlete_id'];

								}

								if(isset($_SESSION['Athlete_id']) && $_SESSION['Athlete_id']!="")

														{

														echo '<a href="javascript:void(0);" onclick="window.open(\'add_user_notes.php?fldAthleteid='.$uid.'&usertype=athlete\',\'winname\',\'directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no,width=980px,height=380\');" style="float:right;">Add Note</a>';

														}?></h3>

                                <div class="right-boxes">

                                    <?php



									 	if($query_note)

										{



											$db_note->query($query_note);

											$rowcount = $db_note->num_rows();



											if($rowcount > 0)

											{

												echo '<table width="100%" cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" style="border-collapse: collapse;" class="tablePadd">';

												 while($db_note->next_record())

												 {

												 	//$date = new DateTime($db_note->f('fldPostDate'));

													 //$date=$db_note->f('fldPostDate');

													//$Note_Postdate = $date->format('d-m-Y');

													$Note_Postdate=$db_note->f('fldPostDate');

													$Note_Comment = $func->GetValue("tbl_notes","fldDescription","fldId",$db_note->f('fldNoteId'));



													echo '<tr><td valign="middle"  align="left" class="normalblack_12_stat">';

													echo $Note_Comment.'<br>';

													echo '<span style="color:#CCCCCC;float:right;">'.$Note_Postdate.'</span>';

													echo '</td></tr>';

												 }

												 if($rowcount>1)

												{

														echo '<tr><td valign="middle"  align="right" class="normalblack_12_stat">';



														echo '<a href="javascript:void(0);" onclick="window.open(\'view_more_notes.php?fldAthleteid='.$uid.'&usertype=athlete\',\'winname\',\'directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no,width=980px,height=380\');" class="gametape" style="float:right;">view more</a>';



														echo '</td></tr>';

												}

											 	echo '</table>';

											}

											else

											{

												if(isset($_SESSION['Athlete_id']) && $_SESSION['Athlete_id']!="")

												{

													echo "You have not added any comments yet.";

												}

												else

												{

													echo "User has not added any comments yet.";

												}

											}





										}

										else

										{

											echo "User has not added any comments yet.";

										}

									 ?>

                                </div>

                            </div>

						<div>

								<h3>Upcoming Games</h3>

								<div class="right-boxesfirst">



								    <?php

                                    If ($_SESSION['fldSubscribe'] != 2) {

                                    ?>



        									<?php

                                    //start upcomming games

                                    $query_upcoming_games = " Select * from " . TBL_EVENT . " where fldEventEndDate > now( ) AND fldSport = '" . $fldSport . "' AND

                                    ( `fld_UserType` = 'admin' OR `fld_UserType` = 'athlete' ) AND `fldEventStatus` =1 AND (fldHomeTeam=$fldSchool OR fldAwayTeam=$fldSchool) ORDER BY `fldEventId` DESC  LIMIT 0,5";

                                    $db3->query($query_upcoming_games);

                                    $db3->next_record();

                                    if ($db3->num_rows() > 0) {

        									?>

        									<table width="100%" cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" style="border-collapse: collapse;" class="tablePadd">

        										<?php

                                    for ($i = 0; $i < $db3->num_rows(); $i++) {

                                    $fldEventId = $db3->f('fldEventId');

                                    $pageURL = "ViewEventDetail.php?fldEventId=$fldEventId";

                                    $detailsWindowTitle = "View Event Detail";

                                    $originalDate = $db3->f('fldEventStartDate');

                                    $newDate = date("m-d-Y g:i A", strtotime($originalDate));

        										?>

        										<tr>

        											<td valign="middle"  align="left" class="normalblack_12_upevent"><?php      echo '<a href="javascript:ShowDetails(\'' . $pageURL . '\',\'' . $detailsWindowTitle . '\')">' . $db3 -> f('fldEventName') . '</a>';?>&nbsp; <?=      $newDate;?>&nbsp;

        											<?php?> </td>

        										</tr>

        										<?php

                                                    $db3 -> next_record();

                                                    }

        										?>

        									</table>

        									<?

                                                }

                                               else { echo "No Games Scheduled"; }

                                               //end upcomming games

        									?>



									<?php

                                    }

                                    else {

                                        echo "Sorry, this feature is disabled in Trial Mode, please <a href='subscribe.php'>Purchase a Subscription</a>";

                                    }

                                    ?>





								</div>

							</div>

							<div style="margin-top:10px;">

								<h3 class="advertisement">Advertisement</h3>

								<div class="right-boxesfirst" style="height:226px;">

									<?php

                                $query_banner = " Select * from " . TBL_BANNER . " where fldStatus=1 and fldPosition='bottom-left'";

                                $db2->query($query_banner);

                                for ($banner_count = 0; $banner_count < $db2->num_rows(); $banner_count++) {

									?>

									<p>

										<?php      echo $func -> output_fun($db2 -> f('fldThirdParty'));?>

									</p>

									<?php

                                        $db2 -> next_record();

                                        }

									?>

								</div>

							</div>

						</div>

						<!-- end right div here -->

						<div class="clr"></div>

				</div>

				<div class="clr"></div>

				</form>

			</div>

		</div>

		</div> <?php

            include ('footer.php');

		?>

	</body>

</html>

