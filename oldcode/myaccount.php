<?php

    ##******************************************************************

    ##  Project		:		Sport Social Networking - Admin Panel

    ##  Done by		:		Sanjay chaudhary

    ##	Page name	:		ViewAthleteprofile.php

    ##	Create Date	:		2/07/2011

    ##  Description :		It is use to show the myaccount page of college,athlete,school.

    ##	Copyright   :       Synapse Communications Private Limited.

    include_once ("inc/common_functions.php");

    //for common function

    include_once ("inc/page.inc.php");

    session_start();

    if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {

        header("Location:login.php");

    }

    //echo print_r($_SESSION);die();

    //for paging

    $func = new COMMONFUNC;

    $db = new DB;

    $flag = 0;

    

      #### DEMO MODE SWITCHER (user san_jac) ####

    if ($_POST['trial'])

    {

        $where = "fldId='" . $_POST['userid'] . "'";

        $strDataArr = array('fldSubscribe' => 2);

        $db -> updateRec(TBL_COLLEGE_COACH_REGISTER, $strDataArr, $where);

    }

    if ($_POST['subscription'])

    {

        $where = "fldId='" . $_POST['userid'] . "'";

        $strDataArr = array('fldSubscribe' => 1);

        $db -> updateRec(TBL_COLLEGE_COACH_REGISTER, $strDataArr, $where);

    }

    if ($_POST['inactive'])

    {

        $where = "fldId='" . $_POST['userid'] . "'";

        $strDataArr = array('fldSubscribe' => 0);

        $db -> updateRec(TBL_COLLEGE_COACH_REGISTER, $strDataArr, $where);

    }

    

    //Global Vars

    $UserID = "";

    $UserType = $_SESSION['mode'];

    

	$NetworkReq_Pending = "";

	 switch ($UserType) {

        case 'athlete':

            //AthleteID

            $UserID = $_SESSION['Athlete_id'];

			/********* Athelete Rate Checking****************/

			require_once("athlete_rating.php");

			/********* Athelete Rate Checking****************/

		    break;

        case 'coach':

            //HS Coach ID

            $UserID = $_SESSION['Coach_id']; 

            break;

        case 'college':

            //College Coach ID

            $UserID = $_SESSION['College_Coach_id'];

			//Check Subscription Status

            $query = " Select fldSubscribe from " . TBL_COLLEGE_COACH_REGISTER . " where fldId ='" . $UserID . "' ";           

            $db -> query($query);

            $db -> next_record();  

            $_SESSION['fldSubscribe'] = $db -> f('fldSubscribe');

            break;

    }               

         

   	

    #### PENDING NETWORK REQUESTS ####

			$Pending_request = $func -> selectTableOrder(TBL_NETWORK, "fldId", "fldId", "where fldReceiverid='" . $UserID . "' and fldReceiverType='" . $UserType ."' and fldStatus='Pending'");    

    		if (count($Pending_request) > 0) {

				 $NetworkReq_Pending = "(<font style='color:red;'>" . count($Pending_request) . " Pending</font>)";

			}

    #### PENDING NETWORK REQUESTS ####

    

     #### INBOX ####

    $inboxinfo = $func -> selectTableOrder(TBL_MAIL, "mail_id", "mail_id", "where UserTo='" . $_SESSION['FRONTEND_USER'] . "' and status ='unread'");

    $Countinboxinfo = count($inboxinfo);

    if ($Countinboxinfo > 0) {

         $Countinboxinfo = "(<font style='color:red;'>" . $Countinboxinfo . " Unread</font>)";

    }

    else

    {

        $Countinboxinfo = "";

    }



    

    

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>College Prospect Network - My Account</title>

		<META NAME="Keywords" CONTENT="My Account">

		<META NAME="Description" CONTENT="My Account">

		<link href="css/style.css" rel="stylesheet" type="text/css" />

		<script language="Javascript" src="javascript/functions.js"></script>

	</head>

	<body>

		<?php

            include ('header.php');?>

		<div class="container">

			<div class="innerWraper">

				<div class="middle-bg">

					<div class="infomessage center" style="display:none;">

						Site is currently under Maintenance until 7:30AM EST.

					</div>

					<div class="cantener">

						<div class="register-main myaccount">

							<?php if($_REQUEST['msg']) {

							?>

							<div class="thankyoumessage">

								<?php     echo $_REQUEST['msg'];?>

							</div>

							<?php     }?>

							

							

							

							<?php if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='school'))

                                {

							?>

							<h1 class="margin5">My Account</h1>

							<div class="registerPage">

								<p class="bg-icon" style="padding-left:18px; font-size:13px;"><a href="editSchoolProfile.php">Edit Profile</a></p>

								<p class="bg-icon" style="padding-left:18px; font-size:13px;"><a href="Athmessage.php">Messaging</a></p>

							</div>

							<?php

                                }?>

                                

                                

							<?

							###############################################################

                            ## ATHLETE

                            ###############################################################    

                            

                            if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='athlete'))

                            {

                                

                                #echo "Is Approved: " . $_SESSION['IsApproved'];

                                #echo "<br>Status: " .$_SESSION['IsStatus'];

                                

							?>



							<h1 class="margin5">My Account</h1>

							<div class="registerPage" style="position:relative;">

								<h2>My Profile</h2>

									<p><img src="img/bullet-grey.gif"><a href="ViewAthleteprofile.php">View My Profile</a></p>

									<p><img src="img/bullet-grey.gif"><a href="Video-List.php"><b>Manage Game Tape</b></a></p>

									<p><img src="img/bullet-grey.gif"><a href="Athupdateprofile.php">Edit My Profile</a></p>

									<p><img src="img/bullet-grey.gif"><a href="Athchangepassword.php">Change Password</a></p>

								<h2>Messaging</h2>

									<p><img src="img/bullet-grey.gif"><a href="Athmessage.php">Inbox <?php echo $Countinboxinfo; ?></a></p>

									<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=sentmessage">Sent</a></p>

									<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=trash">Trash</a></p>

									<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=coach">Send Message to a HS / AAU Coaches</a></p>								

									<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=athlete">Send Message to a Fellow Athlete</a></p>

									<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=college">Send Message to a College Coaches</a></p>

							    

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

										//echo $query;

                                        //Get Query Results

                                        $db -> query($query);

                                        $db -> next_record();

                                        //Bind Data

                                        $fldFirstname = $func -> output_fun($db -> f('fldFirstname'));

                                        $fldLastname = $func -> output_fun($db -> f('fldLastname'));

                                        $fldImage = $func -> output_fun($db -> f('fldImage'));

                                        $fldDescription = $func -> output_fun($db -> f('fldDescription'));

                                        $fldDescription = str_replace("\n", "<br>", $fldDescription);

                                        $fldEmail = $func -> output_fun($db -> f('fldEmail'));

                                        $fldComments = $func -> output_fun($db -> f('fldComments'));

                                        $fldId = $func -> output_fun($db -> f('fldId'));

                                        $fldForvideoId = $db -> f('fldId');

                                        $fldApproveCoachId = $db -> f('fldApproveCoachId');

                                        $fldJerseyNumber = $db -> f('fldJerseyNumber');

                                        $fldSport = $func -> output_fun($db -> f('fldSport'));

                                        $query_coach_info = " Select * from " . TBL_HS_AAU_COACH . " where fldId = " . $fldApproveCoachId;

                                        $db1 -> query($query_coach_info);

                                        $db1 -> next_record();

                                        $teaminfo = $func->selectTableOrder(TBL_HS_AAU_TEAM, "fldId,fldSchoolname,fldAddress,fldEnrollment", "fldSchoolname", "where  fldId='" . $db1->f('fldSchool') . "'")

    								?>

                         

                                    

                                    <h2>My Network</h2>                                    

										<?php /*?><p><img src="img/bullet-grey.gif"><a href="HsAauCoachProfile.php?mode=view&fldId=<?php  echo $db1 -> f('fldId');?>">My HS/AAU Coach</a></p><?php */?>

										<p><img src="img/bullet-grey.gif"><a href="Network-Requests.php">Network Requests <? echo $NetworkReq_Pending; ?></a></p>  

										<p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=athlete&mode=athlete">My Athletes</a></p>

										<p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=coach&mode=athlete">My HS/AAU Coaches</a></p>

										<p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=college&mode=athlete">My College Coaches</a></p>

   								    <h2>Find a College</h2>

    									<p><img src="img/bullet-grey.gif"><a href="ViewCollegeCoach.php">Browse All Colleges</a></p>

    									<!-- TODO: make visible -->

    									<p><img src="img/bullet-grey.gif" /><a href="ViewCollegeNeedMatches.php">View College Need Matches</a></p>

    								<h2>Games & Events</h2>

                                    	<!--<p ><img src="img/bullet-grey.gif"><a href="Registration-Special-Event.php">Event</a></p>-->

    									<p ><img src="img/bullet-grey.gif"><a href="ViewCalender.php">Add Game Stats</a></p>

    									<p><img src="img/bullet-grey.gif"><a href="addevent.php">Add New Game or Event</a></p>									

    									<p ><img src="img/bullet-grey.gif"><a href="ViewCalender.php">View All Games & Events</a></p>

    									<p><img src="img/bullet-grey.gif"><a href="listevent.php">View Upcoming Games & Events</a></p>

							</div>						



							<?php

                                }

                            ############## END ATHLETE #############

                                ?>

                                

                                

                                

                                <?php

                                ###############################################################

                                ## HS/AAU COACH 

                                ###############################################################         

                                       

                                if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='coach'))

                                {?>

                                    

							<h1 class="margin5">My Account</h1>

							<div class="registerPage" style="position:relative;">

								<h2>Profile</h2>

								<p><img src="img/bullet-grey.gif"><a href="HsAauCoachProfile.php">View My Profile</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Coachupdateprofile.php">Edit My Profile</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Coachchangepassword.php">Change Password</a>

								</p>

								<h2>Messaging</h2>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php">Inbox <?php echo $Countinboxinfo; ?></a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=sentmessage">Sent</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=trash">Trash</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=coach">Send Message to a Fellow HS / AAU Coaches </a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=athlete">Send Message to an Athlete</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=college">Send Message to a College Coaches</a>

								</p>

								<h2>Athlete Approval Requests</h2>

								<?php

								    //Count Pending Approval Requests

                                    $coach_information = $func -> selectTableOrder(TBL_HS_AAU_COACH, "fldSchool", "fldId", "where fldId='" . $_SESSION['Coach_id'] . "'");

                                    $selquery1 = "select fldSportId from " . TBL_HS_AAU_COACH_SPORT_POSITION . " where fldCoachNameId='" . $_SESSION['Coach_id'] . "'";

                                    $db1 -> query($selquery1);

                                    $db1 -> next_record();

                                    if ($db1 -> num_rows() > 0) {

                                        for ($i = 0; $i < $db1 -> num_rows(); $i++) {

                                            $fldSport .= $func -> output_fun($db1 -> f('fldSportId')) . ",";

                                            $db1 -> next_record();

                                        }

                                    }

                                    $fldSport = substr($fldSport, 0, -1);

                                    $ahtlete_pending = $func -> selectTableOrder(TBL_ATHELETE_REGISTER, "fldId", "fldId", "where fldSport in ($fldSport) and fldSchool='" . $coach_information[0]['fldSchool'] . "' and fldStatus ='DEACTIVE'");

                                    $Countahtlete_pending = count($ahtlete_pending);                  

                                     if ($Countahtlete_pending > 0) {

                                         $Countahtlete_pending = "(<font style='color:red;'>" . $Countahtlete_pending . " Pending</font>)";

                                    }

                                    else

                                    {

                                        $Countahtlete_pending = "";

                                    }   

								?>

								<p><img src="img/bullet-grey.gif"><a href="CoachAthapprove.php">Athlete Approval <?php echo $Countahtlete_pending; ?></a> 

								</p>

								<?php

								    //Count Pending Athlete Stats

                                    $ahtlete_stat_pending=$func->selectTableOrdergroupby(TBL_ATHELETE_STAT,"fldAtheleteId,fldStatus,fldPrograme","fldPrograme","where fldCoachId='".$_SESSION['Coach_id']."' and fldStatus = '0'");      

                                    $Countahtlete_stat_pending = count($ahtlete_stat_pending);                  

                                     if ($Countahtlete_stat_pending > 0) {

                                         $Countahtlete_stat_pending = "(<font style='color:red;'>" . $Countahtlete_stat_pending . " Pending</font>)";

                                    }

                                    else

                                    {

                                        $Countahtlete_stat_pending = "";

                                    }    

								?>

								<p><img src="img/bullet-grey.gif"><a href="ViewAthletesStats.php">Athlete Stats Approval <?php echo $Countahtlete_stat_pending; ?></a>

								</p>

                                

                                <h2>My Network</h2>

                                <p><img src="img/bullet-grey.gif"><a href="Network-Requests.php">Network Requests <? echo $NetworkReq_Pending; ?></a></p>

								<p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=athlete&mode=coach">My Athletes</a></p>

								<p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=coach&mode=coach">My HS/AAU Coaches</a></p>

								<p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=college&mode=coach">My College Coaches</a></p>

								<h2>Find an Athlete</h2>

								<!--<p><img src="img/bullet-grey.gif"><a href="Search-Athletes.php">Athlete Search</a>-->

                                </p>

                                <p><img src="img/bullet-grey.gif"><a href="ViewAthletelist.php">Browse All Athletes</a>

                                </p>

						

								<p><img src="img/bullet-grey.gif"><a href="invite.php">Invite an Athlete to Join Site</a>

								</p>

								<h2>Find a College</h2>

                                    <!--<p><img src="img/bullet-grey.gif"><a href="collegesearch.php">College Search</a></p>-->

                                    <!--<p><img src="img/bullet-grey.gif"><a href="ViewCollegeCoachbyNeeds.php">Find Colleges for Your Network</a> (by College needs)

                                    </p>-->

                                    <p><img src="img/bullet-grey.gif"><a href="ViewCollegeCoach.php">Browse All Colleges</a>

                                    </p>

							</div>

							<?php

                                }

                                ############## END HS/AAU COACH #############

                                ?>

                                

                                

                                <?php

                                ###############################################################

                                ## COLLEGES 

                                ###############################################################

                                

                                if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='college'))

                                {?>

                                    

							 <?

                                /////////////////////To get the count of Network Request Received ///////////////////////

                                $request = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId", "fldId", "where fldUserName='" . $_SESSION['FRONTEND_USER'] . "' and fldStatus='ACTIVE'");                                

                                /////////////////////To get the count of Message from athlete///////////////////////

                                $re_msg = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId", "fldId", "where fldUserName='" . $_SESSION['FRONTEND_USER'] . "' and fldStatus='ACTIVE'");                          

                                ///Get Coach info//

                                $query = " Select * from " . TBL_COLLEGE_COACH_REGISTER . " where fldUserName = '" . $_SESSION['FRONTEND_USER'] . "' ";

                                $db -> query($query);

                                $db -> next_record();

                                

                                $fldCollegeUserId = $db -> f('fldId');

                                $fldSubscribe = $db -> f('fldSubscribe');

                                $fldLastPayAmount = $db -> f('fldLastPayAmount');

                                $fldAddDate = $db -> f('fldAddDate');

                                $fldDateLastUpdated = $db -> f('fldDateLastUpdated');

                                $fldSubscriptionType = $db -> f('fldSubscriptionType');              

                                $fldLastPaymentDate = $db -> f('fldLastPaymentDate');      

                                                  

                                $SubscriptionStatus = "5-Day Trial";

                                $SubscriptionType = "Type";

                                //Set Subscription Info

                                if ($fldSubscribe == '2') {

                                    $SubscriptionStatus = "Active";

                                    $SubscriptionType = "Free Trial";

                                }

                                else

                                if ($fldSubscribe == '1') {

                                    $SubscriptionStatus = "Active";

                                    $SubscriptionType = $fldSubscriptionType;

                                }

                                else

                                if ($fldSubscribe == '0') {

                                    $SubscriptionStatus = "Inactive";

                                    $SubscriptionType = "None";

                                }

                                

                                // Gets the subscription status

                                $query = 'SELECT * FROM ' . TBL_COLLEGE_SUBSCRIPTION . ' WHERE fldActive=1 AND fldCoach=' . $fldCollegeUserId;

                                $db->query($query);

                                $db->next_record();

                                

                                $subscriptions = array();

                                

                                while ($db->next_record()) {

                                    $sub = array();



                                    $subId = $db->f('fldId');

                                    $subNextBill = $db->f('fldNextBillDate');

                                    $subAmount = $db->f('fldAmount');

                                    

                                    // gets the name of the sport for this subscription

                                    $query = 'SELECT fldSportsname FROM ' . TBL_SPORTS . ' INNER JOIN ' . 

                                             TBL_COLLEGE_SUBSCRIPTION . ' ON ' . TBL_SPORTS . '.fldId=' . 

                                             TBL_COLLEGE_SUBSCRIPTION . '.fldSport WHERE ' . 

                                             TBL_COLLEGE_SUBSCRIPTION . '.fldId=' . $subId;

                                    

                                    $db1->query($query);

                                    $db1->next_record();

                                    

                                    $sub['fldSport'] = $db1->f('fldSportsname');

                                    

                                    // gets the name of the subscription type

                                    $query = 'SELECT fldName FROM ' . TBL_SUBSCRIPTION . ' INNER JOIN ' . 

                                             TBL_COLLEGE_SUBSCRIPTION . ' ON ' . 

                                             TBL_SUBSCRIPTION . '.fldId=' . 

                                             TBL_COLLEGE_SUBSCRIPTION . '.fldType WHERE ' . 

                                             TBL_COLLEGE_SUBSCRIPTION . '.fldId=' . $subId;

                                    

                                    $db1->query($query);

                                    $db1->next_record();

                                    

                                    $sub['fldType'] = $db1->f('fldName');

                                    

                                    $subscriptions[] = $sub;

                                }

                                

                                

                                

							?>

							<?php

if ($fldSubscribe == '2' or $fldSubscribe == '0') {

							?>

							<div class="thankyoumessage">

								You currently have limited access to Athletes & HS/AAU Coaches. please <a href="subscribe.php">Purchase a Subscription</a> to gain full access.

							</div>

							<?php

                                }

							?>

							<h1 class="margin5">My Account</h1>

							<div class="registerPage" style="position:relative;">

								<div class="subscriptionbox">

									<h2>Your Subscription</h2>

									<?php

                            if ($fldSubscribe == '2' or $fldSubscribe == '0') {

									?>

									<p style="color:#222;margin-bottom:15px;">

										You currently have limited access to Athletes & HS/AAU Coaches. please <a href="subscribe.php" class="underline">Purchase a Subscription</a> to gain full access.

									</p>

									<?php

                                        }

									?>

									<p>

										<b>Type:</b><?php  echo $SubscriptionType;?>

									</p>

									<p>

										<b>Status:</b><?php  echo $SubscriptionStatus;?>

									</p>

									<p>

										<b>Valid Until:</b>

										<?php

                                            if ($fldSubscribe == '2') {

                                                //Trial Time Left

                                                $time_left = $func -> GetAprilTrialTimeLeft($fldAddDate);

                                            }

                                            else

                                            if ($fldSubscribe == '1') {

                                                //Subscription Time Left

                                                $time_left = $func -> GetSubscriptionTimeLeft($fldLastPaymentDate);

                                            }

                                            else

                                            if ($fldSubscribe == '0') {

                                                //Inactive Time Left

                                                $time_left = "0 Days";

                                            }

                                            echo $time_left;

										?>

									</p>

									<br />

									<br />

									<h2>Account Details</h2>

									<p>

										<b>Last Amount Paid:</b>$<?php  echo $fldLastPayAmount;?>

										USD

									</p>

									<p>

										<b>Created On:</b><?php  echo $func -> FormatDate($fldAddDate);?>

									</p>

									<p>

										<b>Last Modified On:</b><?php  echo $func -> FormatDate($fldDateLastUpdated);?>

									</p>

									



									    <?php

									    if ($fldCollegeUserId == '74') {

									        echo '<br /><br />';									        

                                            echo '<h2>Demo Options (san_jac only)</h2>';

                                            echo '<p>';		                                            

                                            ?>			

                                            

                                            <form action="" method="post">		

                                                <div style="display:block;margin-bottom:5px;"><b>Switch this Demo Account to:</b></div>

                                                <input type="submit" name="trial" value="Trial Mode" class="normalbtn" style="display:block;margin-bottom:5px;">

                                                <input type="submit" name="subscription" value="Active Subscription" class="normalbtn" style="display:block;margin-bottom:5px;">

                                                <input type="submit" name="inactive" value="No Subscription / Trial Ended" class="normalbtn" style="display:block;margin-bottom:5px;">       

                                                <input type="hidden" name="userid" value="<?=$UserID?>">

                                            </form>

                                            

                                            <?php 

                                            echo '</p>';

                                         }

                                        ?>									    

								

								</div>

								

								

								<h2>Profile</h2>

								<p><img src="img/bullet-grey.gif"><a href="collegeprofile.php">View My Profile</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="editCollegeProfile.php">Edit My Profile</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="CollegeChangePassword.php">Change Password</a>

								</p>

								<h2>Messaging</h2>

								<?php

                                If ($_SESSION['fldSubscribe'] != 2) {

                                ?>   

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php">Inbox <?php echo $Countinboxinfo; ?></a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=sentmessage">Sent</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=trash">Trash</a>

								</p>								

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=coach">Send Message to a HS / AAU Coaches</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=athlete">Send Message to an Athlete</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=college">Send Message to a Fellow College Coaches</a>

								</p>

								<?php 

								}

                                else {

                                    echo "Sorry, this feature is disabled in Trial Mode, please <a href='subscribe.php'>Purchase a Subscription</a>";

                                }

                                ?>

								

								<h2>My Network</h2>

								<?php

                                If ($_SESSION['fldSubscribe'] != 2) {

                                ?>   

                                <p><img src="img/bullet-grey.gif"><a href="Network-Requests.php">Network Requests <? echo $NetworkReq_Pending; ?></a></p>

                                <?php 

                                }

                                else {

                                    echo "Sorry, this feature is disabled in Trial Mode";

                                }

                                ?>

                                <p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=athlete&mode=college">My Athletes</a></p>

								<p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=coach&mode=college">My HS/AAU Coaches</a></p>

								<p><img src="img/bullet-grey.gif"><a href="my_network.php?network_for=college&mode=college">My College Coaches</a></p>

								

								<h2>Athlete Section</h2>

								<!--<p><img src="img/bullet-grey.gif"><a href="athleteSearch.php">Athlete Search</a> 

								</p>-->
								<p><img src="img/bullet-grey.gif"><a href="athleteSearch_all.php?network_for=athlete&mode=college">Athlete Search</a> 

								</p>

								<p><img src="img/bullet-grey.gif"><a href="Listathleteall.php">Browse All Athletes</a> 

								</p>

								<h2>HS / AAU Coach  Section</h2>

								<p><img src="img/bullet-grey.gif"><a href="ViewAllHsAau.php?network_for=coach&mode=college">Browse  HS / AAU Coaches</a>

								</p>

								<h2>Manage Subscription</h2>

								<p><img src="img/bullet-grey.gif"><a href="https://www.collegeprospectnetwork.com/subscribe.php">Add New Subscription</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="https://www.collegeprospectnetwork.com/UpdateSubscription.php">Edit Subscription</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="https://www.collegeprospectnetwork.com/CollegeViewPayment.php">View Payment History</a>

								</p>

								<p><img src="img/bullet-grey.gif"><a href="https://www.collegeprospectnetwork.com/CancelSubscription.php">Cancel Subscription</a>

								</p>

							</div>

							<?php

							############## END COLLEGE  #############

                                }?>

						</div>

					</div>

				</div>

			</div>

		</div>

		<?php

            include ('footer.php');?>

	</body>

</html>

