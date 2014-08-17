<?php
    ##******************************************************************
    ##  Project		:		Sport Social Networking - Admin Panel
    ##  Done by		:		Sanjay chaudhary
    ##	Page name	:		ViewAthleteprofile.php
    ##	Create Date	:		2/07/2011
    ##  Description :		It is use to show the myaccount page of college,athlete,school.
    ##	Copyright   :       Synapse Communications Private Limited.    include_once ("inc/common_functions.php");    //for common function
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
    
    //Global Vars
    $UserID = "";
    $UserType = $_SESSION['mode'];
    
     switch ($UserType) {
        case 'athlete':
            //AthleteID
            $UserID = $_SESSION['Athlete_id'];
            break;
        case 'coach':
            //HS Coach ID
            $UserID = $_SESSION['Coach_id']; 
            break;
        case 'college':
            //College Coach ID
            $UserID = $_SESSION['College_Coach_id'];   
            break;
    }               
         
    #### PENDING NETWORK REQUESTS ####
    $NetworkReq_Pending = $func -> selectTableOrder(TBL_NETWORK, "fldId", "fldId", "where fldReceiverid='" . $UserID . "' and fldReceiverType='" . $UserType ."' and fldStatus='Pending'");    
    $NetworkReq_Pending = count($NetworkReq_Pending);
    if ($NetworkReq_Pending > 0) {
         $NetworkReq_Pending = "(" . $NetworkReq_Pending . ")";
    }
    else
    {
        $NetworkReq_Pending = "(0)";
    }
   
    
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - My Account | CPN</title>
		<META NAME="Keywords" CONTENT="My Account">
		<META NAME="Description" CONTENT="My Account">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
	</head>
	<body>
		<?php            include ('header.php');?>		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="infomessage center" style="display:block;">
						Site is currently under Maintenance
					</div>
					<div class="cantener">
						<div class="register-main myaccount">
							<?php if($_REQUEST['msg']) {							?>							<div class="thankyoumessage">
								<?php     echo $_REQUEST['msg'];?>
							</div>
							<?php     }?>
							
							
														<?php if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='school'))
                                {
							?>							<h1 class="margin5">My Account</h1>
							<div class="registerPage">
								<p class="bg-icon" style="padding-left:18px; font-size:13px;">
									<a href="editSchoolProfile.php">Edit Profile</a>
								</p>
								<p class="bg-icon" style="padding-left:18px; font-size:13px;">
									<a href="Athmessage.php">Messaging</a>
								</p>
							</div>
							<?php                                }?>
                                
                                							<?
							###############################################################
                            ## ATHLETE
                            ###############################################################    
                                                        if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='athlete'))                            {
                                
                                #echo "Is Approved: " . $_SESSION['IsApproved'];
                                #echo "<br>Status: " .$_SESSION['IsStatus'];
                                							?>
							<?php
                                if ($_SESSION['IsApproved']==0)  {
                                ?>
                                <div class="errormessage" style="line-height:22px;">
                                    <?php echo "Your account has not been Approved by your HS/AAU Coach yet. You must be approved to access all the features!  <br /><span style='font-weight:normal;'>Please instruct Your HS/AAU Coach to Login or Register (using the Same School), and Approve your account.</span>."; ?>
                                </div>
                           <?php  }?>							<h1 class="margin5">My Account</h1>
							<div class="registerPage" style="position:relative;">
								<h2>My Profile</h2>
								<p><img src="img/bullet-grey.gif"><a href="ViewAthleteprofile.php">View My Profile</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Video-List.php">Manage Game Tape</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athupdateprofile.php">Edit My Profile</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athchangepassword.php">Change Password</a>
								</p>
								<h2>Messaging</h2>
								<?php                                    $inboxinfo = $func -> selectTableOrder(TBL_MAIL, "mail_id", "mail_id", "where UserTo='" . $_SESSION['FRONTEND_USER'] . "' and status ='unread'");?>								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php">Inbox (<?php echo count($inboxinfo);?>)</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=sentmessage">Sent</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=trash">Trash</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=coach">Send Message to a HS / AAU Coach</a>
								</p>
								
								    <p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=athlete">Send Message to a Fellow Athlete</a>
								    </p>
							    <?php if ($_SESSION['IsApproved']==1) { ?>
								    <p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=college">Send Message to a College Coach</a>
								    </p>
							    <?php } ?> 
							    
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
                                    <p><img src="img/bullet-grey.gif"><a href="Network-Requests.php">Network Requests <? echo $NetworkReq_Pending; ?></a></p>
                                    <?php if ($_SESSION['IsApproved']==1) { ?><p><img src="img/bullet-grey.gif"><a href="HsAauCoachProfile.php?mode=view&fldId=<?php  echo $db1 -> f('fldId');?>">My HS/AAU Coach</a></p><?php } ?>
                                    <p><img src="img/bullet-grey.gif"><a href="Network-Athlete.php">Athletes In My Network</a></p>                                
                                    <p><img src="img/bullet-grey.gif"><a href="Network-HS-Coach.php">HS/AAU Coaches In My Network</a></p>     
                                    <p><img src="img/bullet-grey.gif"><a href="Network-College-Coach.php">College Coaches In My Network</a></p>     
                                                                    
    									<!--    									<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=coach">Send a Message to a HS / AAU Coach</a></p>    									<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=athlete">Send a Message to a Fellow Athlete</a></p>    									<p><img src="img/bullet-grey.gif"><a href="Athtonetwork.php">Send Network Request to College</a></p>    									<p><img src="img/bullet-grey.gif"><a href="Athmsgcollege.php">Send Message to College Coach</a></p>    									-->
    									
    									<!--<p><img src="img/bullet-grey.gif"><a href="collegesearch.php">College Search</a></p>-->
    									<!--<p><img src="img/bullet-grey.gif"><a href="ViewCollegeCoachbyNeeds.php">Find Colleges for Your Network</a> (by College needs)
    									</p>-->
    									<?php if ($_SESSION['IsApproved']==1) { ?>
    								   <h2>Find a College</h2>
    									<p><img src="img/bullet-grey.gif"><a href="ViewCollegeCoach.php">Browse All Colleges</a>
    									</p>
    									<h2>Games & Events</h2>
    									<p ><img src="img/bullet-grey.gif"><a href="ViewCalender.php">Add Game Stats</a>
                                        </p>
    									<p><img src="img/bullet-grey.gif"><a href="addevent.php">Add New Game or Event</a>
    									</p>									
    									<p ><img src="img/bullet-grey.gif"><a href="ViewCalender.php">View All Games & Events</as>
    									</p>
    									<p><img src="img/bullet-grey.gif"><a href="listevent.php">View Upcoming Games & Events</a>
    									</p>
									<?php } ?> 
							</div>						

							<?php                                }
                                ############## END ATHLETE #############
                                ?>
                                
                                
                                
                                <?php
                                ###############################################################
                                ## HS/AAU COACH 
                                ###############################################################         
                                                                       if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='coach'))                                {?>
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
								<?php                                    $inboxinfo = $func -> selectTableOrder(TBL_MAIL, "mail_id", "mail_id", "where UserTo='" . $_SESSION['FRONTEND_USER'] . "' and status ='unread'");?>								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php">Inbox (<?php     echo count($inboxinfo);?>)</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=sentmessage">Sent</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=trash">Trash</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=coach">Send Message to a Fellow HS / AAU Coach </a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=athlete">Send Message to an Athlete</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=college">Send Message to a College Coach</a>
								</p>
								<h2>Athlete Approval Requests</h2>
								<?php                                    $coach_information = $func -> selectTableOrder(TBL_HS_AAU_COACH, "fldSchool", "fldId", "where fldId='" . $_SESSION['Coach_id'] . "'");                                    $selquery1 = "select fldSportId from " . TBL_HS_AAU_COACH_SPORT_POSITION . " where fldCoachNameId='" . $_SESSION['Coach_id'] . "'";
                                    $db1 -> query($selquery1);
                                    $db1 -> next_record();
                                    if ($db1 -> num_rows() > 0) {
                                        for ($i = 0; $i < $db1 -> num_rows(); $i++) {
                                            $fldSport .= $func -> output_fun($db1 -> f('fldSportId')) . ",";
                                            $db1 -> next_record();
                                        }
                                    }
                                    $fldSport = substr($fldSport, 0, -1);
                                    $ahtlete_panding_info = $func -> selectTableOrder(TBL_ATHELETE_REGISTER, "fldId", "fldId", "where fldSport in ($fldSport) and fldSchool='" . $coach_information[0]['fldSchool'] . "' and fldStatus ='DEACTIVE'");
								?>								<p><img src="img/bullet-grey.gif"><a href="CoachAthapprove.php">Athlete Approval (<?php     echo count($ahtlete_panding_info);?>)</a> 
								</p>
								<?php//select * from tbl_athelete_stat where fldCoachId=71 and fldStatus = '1' group by fldPrograme$ahtlete_stat_panding_info=$func->selectTableOrdergroupby(TBL_ATHELETE_STAT,"fldAtheleteId,fldStatus,fldPrograme","fldPrograme","where fldCoachId='".$_SESSION['Coach_id']."' and fldStatus = '0'")								?>								<p><img src="img/bullet-grey.gif"><a href="ViewAthletesStats.php">Athlete Stats Approval (<?php    echo count($ahtlete_stat_panding_info);?>)</a>
								</p>
                                
                                <h2>My Network</h2>
                                <p><img src="img/bullet-grey.gif"><a href="Network-Requests.php">Network Requests <? echo $NetworkReq_Pending; ?></a></p>
                                <p><img src="img/bullet-grey.gif"><a href="Network-Athlete.php">Athletes In My Network</a></p>
                                <p><img src="img/bullet-grey.gif"><a href="Network-HS-Coach.php">HS/AAU Coaches In My Network</a></p>
                                <p><img src="img/bullet-grey.gif"><a href="Network-College-Coach.php">College Coaches In My Network</a></p>
                                
								<h2>Find an Athlete</h2>
								<p><img src="img/bullet-grey.gif"><a href="ViewAthletelist.php">Browse All Athletes</a>
                                </p>
								<p><img src="img/bullet-grey.gif"><a href="HSCoach-Athlete-Search.php">Athlete Search</a> (New, need to copy over)
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
							<?php                                }
                                ############## END HS/AAU COACH #############
                                ?>
                                
                                
                                <?php                                ###############################################################
                                ## COLLEGES 
                                ###############################################################
                                                                if((isset($_SESSION['mode'])) and ($_SESSION['mode']=='college'))                                {?>
                                    							 <?                                /////////////////////To get the count of Network Request Received ///////////////////////                                $request = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId", "fldId", "where fldUserName='" . $_SESSION['FRONTEND_USER'] . "' and fldStatus='ACTIVE'");                                                                /////////////////////To get the count of Message from athlete///////////////////////                                $re_msg = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId", "fldId", "where fldUserName='" . $_SESSION['FRONTEND_USER'] . "' and fldStatus='ACTIVE'");                          
                                ///Get Subscription Status//
                                $query = " Select * from " . TBL_COLLEGE_COACH_REGISTER . " where fldUserName = '" . $_SESSION['FRONTEND_USER'] . "' ";
                                $db -> query($query);
                                $db -> next_record();
                                $fldSubscribe = $db -> f('fldSubscribe');
                                $fldLastPayAmount = $db -> f('fldLastPayAmount');
                                $fldAddDate = $db -> f('fldAddDate');
                                $fldDateLastUpdated = $db -> f('fldDateLastUpdated');
                                $SubscriptionStatus = "5-Day Trial";
                                $SubscriptionType = "Type";
                                //Set Subscription Info
                                if ($fldSubscribe == '2') {
                                    $SubscriptionStatus = "Active";
                                    $SubscriptionType = "5-Day Free Trial";
                                }
                                else
                                if ($fldSubscribe == '1') {
                                    $SubscriptionStatus = "Active";
                                    $SubscriptionType = "Subscription";
                                }
                                else
                                if ($fldSubscribe == '0') {
                                    $SubscriptionStatus = "Inactive";
                                    $SubscriptionType = "None";
                                }
							?>							<?php
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
                                                $time_left = $func -> GetTrialTimeLeft($fldAddDate);
                                            }
                                            else
                                            if ($fldSubscribe == '1') {
                                                //Subscription Time Left
                                                $time_left = $func -> GetSubscriptionTimeLeft();
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
										<b>Created On:</b><?php  echo $fldAddDate;?>
									</p>
									<p>
										<b>Last Modified On:</b><?php  echo $fldDateLastUpdated;?>
									</p>
								</div>
								<h2>Profile</h2>
								<p><img src="img/bullet-grey.gif"><a href="collegeprofile.php">View My Profile</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="editCollegeProfile.php">Edit My Profile</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="CollegeChangePassword.php">Change Password</a>
								</p>
								<h2>Messaging</h2>
								<?php                                    $inboxinfo = $func -> selectTableOrder(TBL_MAIL, "mail_id", "mail_id", "where UserTo='" . $_SESSION['FRONTEND_USER'] . "' and status ='unread'");
                                    $inboxMessage = "0";
                                    if (count($inboxinfo) > 0) 
                                    {
                                         $inboxMessage = count($inboxinfo) . " New"; 
                                    }
                                    ?>								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php">Inbox (<?php    echo count($inboxinfo);?> Unread)</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=sentmessage">Sent</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=trash">Trash</a>
								</p>								
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=coach">Send Message to a HS / AAU Coach</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=athlete">Send Message to an Athlete</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Athmessage.php?action=compose&value=college">Send Message to a Fellow College Coach</a>
								</p>
								
								<h2>My Network</h2>
								<p><img src="img/bullet-grey.gif"><a href="Network-Requests.php">Network Requests <? echo $NetworkReq_Pending; ?></a></p>
                                <p><img src="img/bullet-grey.gif"><a href="Network-Athlete.php">Athletes In My Network</a></p>
                                <p><img src="img/bullet-grey.gif"><a href="Network-HS-Coach.php">HS/AAU Coaches In My Network</a></p>
                                <p><img src="img/bullet-grey.gif"><a href="Network-College-Coach.php">College Coaches In My Network</a></p>
                                
								<h2>Athlete Section</h2>
								<p><img src="img/bullet-grey.gif"><a href="athleteSearch.php">Athlete Search</a> 
								</p>
								<p><img src="img/bullet-grey.gif"><a href="Listathleteall.php">Browse All Athletes</a> 
								</p>
								<h2>HS / AAU Coach  Section</h2>
								<p><img src="img/bullet-grey.gif"><a href="ViewAllHsAau.php">Browse  HS / AAU Coaches</a>
								</p>
								<h2>Manage Subscription</h2>
								<p><img src="img/bullet-grey.gif"><a href="subscribe.php">Add New Subscription</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="UpdateSubscription.php">Edit Subscription</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="CollegeViewPayment.php">View Payment History</a>
								</p>
								<p><img src="img/bullet-grey.gif"><a href="CancelSubscription.php">Cancel Subscription</a>
								</p>
							</div>
							<?php
							############## END COLLEGE  #############                                }?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php            include ('footer.php');?>
	</body>
</html>