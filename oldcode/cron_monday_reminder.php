<?php
include_once ("inc/common_functions.php");
include_once ("inc/page.inc.php");

session_start();

$rating_func = new COMMONFUNC;
$rating_db = new DB;
$rating_db_1 = new DB;
$rating_db_2 = new DB;
$rating_db_3 = new DB;
$rating_db_4 = new DB;
$profile_db = new DB;
$coach_db = new DB;
		##############################################
		######### MONDAY REMINDERS START ################
		##############################################
		 
		$query_1 = "select * from tbl_event where (date(fldEventStartDate) <= (now()) AND date(fldEventEndDate) <= (now())) and fld_UserType='athlete'";
		$rating_db -> query($query_1);
		$rating_db -> next_record();
		
		 $totalPages = $rating_db->num_rows();
		if($totalPages > 0)
		{
			for ($k = 0; $k < $totalPages; $k++) 
			{
				$userName = $rating_db -> f('fldUserName');
				$EventId = $rating_db -> f('fldEventId');
				
				$UserId =  $rating_func -> GetValue("tbl_athelete_register","fldId","fldUsername",$userName);
				$eventTitle = $rating_func -> GetValue("tbl_event","fldEventName","fldEventId",$EventId);
				/************/
				$query_1_1 = "select * from tbl_athelete_stat WHERE fldAtheleteId='".$UserId."' AND fldPrograme='".$EventId."' GROUP BY fldAtheleteId,fldPrograme";
				$rating_db_1 -> query($query_1_1);
				$rating_db_1 -> next_record();
				$arr_info_1 = array();
				$totalPages_1 = $rating_db_1->num_rows();
				if($totalPages_1 == 0)
				{
					 $msg = "Hello ".$userName.", <br /><br />
					You are receiving this email because you have not posted Game Stats for a particular game/event. Please login to your Account at www.collegeprospectnetwork.com, and post Game Stats.
					<br /><br />
					*It's import to keep your profile accurate as possible.  Please post Game Stats carefully & make your changes.
					<br /><br />
					<b>Game / Event:</b> " .  $eventTitle . "<br />  
					<br />     
					Thank you in advance ".$userName.",<br />
					College Prospect Network<br />
					www.CollegeProspectNetwork.com";
		
					$athleteEmail =  $rating_func -> GetValue("tbl_athelete_register","fldEmail","fldUsername",$userName);
					
					$toStre1 = "harish.bhatt@meticul.com";
					$subjectStre = "College Prospect Network  - Request for post Game Stats";
					$bodyStre = $msg;
					$t = $rating_func -> sendEmail($toStre1, $subjectStre, $bodyStre, $athleteEmail);
				}
				/************/
			
				$rating_db -> next_record();
			}
			
		}
		
		##############################################
		##############################################
		##############################################
		
		$query = "Select * from tbl_athelete_register where fldStatus = 'ACTIVE'";
		$profile_db -> query($query);
		$profile_db -> next_record();
		
		$totalPages = $profile_db->num_rows();
		
		if($totalPages > 0)
		{
			for ($k = 0; $k < $totalPages; $k++) 
			{
				$athlete_pending_task = array();
				$uploadImage = $profile_db -> f('fldImage');
				$coachApprove = $profile_db -> f('fldApproveCoachId');
				$fldId = $profile_db -> f('fldId');
				$uploadVideo =  $rating_func -> GetValue("tbl_athlete_video","fldId","fldAthleteId",$fldId);
				$fldUsername = $profile_db -> f('fldUsername');
				$uploadGameSchedule  =  $rating_func -> GetValue("tbl_event","fldEventId","fld_UserType='athlete' AND fldUserName",$fldUsername);
				
				$fldGPA = $rating_func -> output_fun($profile_db -> f('fldGPA'));
				$fldSATScore = $rating_func -> output_fun($profile_db -> f('fldSATScore'));
				$fldACTScore = $rating_func -> output_fun($profile_db -> f('fldACTScore'));
				$fldClassRank = $rating_func -> output_fun($profile_db -> f('fldClassRank'));
				$fldClearinghouseEligible = $rating_func -> output_fun($profile_db -> f('fldClearinghouseEligible'));
				$fldIntendedMajor = $rating_func -> output_fun($profile_db -> f('fldIntendedMajor'));
				$fldEmail= $rating_func -> output_fun($profile_db -> f('fldEmail'));
				$fldClass = $rating_func -> output_fun($profile_db -> f('fldClass'));
				$fldHeight = $rating_func -> output_fun($profile_db -> f('fldHeight'));
				$fldWeight = $rating_func -> output_fun($profile_db -> f('fldWeight'));
				$fldSport = $rating_func -> output_fun($profile_db -> f('fldSport'));
				$fldSchool = $rating_func -> output_fun($profile_db -> f('fldSchool'));
				
				$fldPrimaryPosition = $rating_func -> output_fun($profile_db -> f('fldPrimaryPosition'));
				$fldSecondaryPosition = $rating_func -> output_fun($profile_db -> f('fldSecondaryPosition'));
				$fldVertical = $rating_func -> output_fun($profile_db -> f('fldVertical'));
				$fld40_yardDash = $rating_func -> output_fun($profile_db -> f('fld40_yardDash'));
				$fldShuttleRun = $rating_func -> output_fun($profile_db -> f('fldShuttleRun'));
				$fldBenchPressMax = $rating_func -> output_fun($profile_db -> f('fldBenchPressMax'));
				$fldSquatMax = $rating_func -> output_fun($profile_db -> f('fldSquatMax'));
				
				####### APPROVED_BY_COACH ################
				if($coachApprove == 0 || $coachApprove == "")
				{
						// mail to Coach for pending approval request		
						
							
						//User Selected School
						$schoolid =$fldSchool;
						$sportid = $fldSport;
						$emailarr = array();
						$selquery = 'select first.fldId,first.fldEmail as fldEmail,first.fldName as name,first.fldLastName as lname,first.fldUsername as HSCoachUsername,first.fldPassword as HSCoachPassword from ' . TBL_HS_AAU_COACH . ' first,' . TBL_HS_AAU_COACH_SPORT_POSITION . ' second  where second.fldCoachNameId = first.fldId and second.fldSportId =' . $sportid . ' and first.fldSchool =' . $schoolid;
						$coach_db -> query($selquery);
						$coach_db -> next_record();
						if ($coach_db -> num_rows() > 0) {
							for ($i = 0; $i < $coach_db -> num_rows(); $i++) {
								$emailarr[] = $rating_func -> output_fun($coach_db -> f('fldEmail'));
								$name = $rating_func -> output_fun($coach_db -> f('name'));
								$lname = $rating_func -> output_fun($coach_db -> f('lname'));
								#Login Info
								$HSCoachUsername = $rating_func -> output_fun($coach_db -> f('HSCoachUsername'));
								$HSCoachPassword = $rating_func -> output_fun($coach_db -> f('HSCoachPassword'));
								
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
								$rating_func -> sendEmail($emailvalue, $subjectStre, $bodyStre, $fldEmail);
								########## ///END EMAIL/// ##########
								
							}
						}
							
				}
				##########################################
				####### UPLOADING_GAME_TAPE ##############
				if($uploadVideo > 0 || $uploadVideo != "")
				{
					$athlete_pending_task[] ="UPLOADING_GAME_TAPE"; 
				}
				#########################################
				####### ADDING_PROFILE_PICTURE ##########
				if($uploadImage == "default.jpg" || $uploadImage == "")
				{
					// please upload profile picture
					$athlete_pending_task[] ="ADDING_PROFILE_PICTURE"; 
				}
				##########################################
				####### UPLOADING_GAME_SHEDULE ###########
				if($uploadGameSchedule == 0 || $uploadGameSchedule == "")
				{
				$athlete_pending_task[] ="UPLOADING_GAME_SHEDULE"; 
				}
				#########################################
				####### COMPLETING_ACADEMIC_STATE #######
				if($fldGPA != "" && $fldSATScore != "" && $fldACTScore != "" && $fldClassRank != "" && $fldClearinghouseEligible != "" && $fldIntendedMajor != "")
				{ 
					//********//
					
				}
				else
				{
					$athlete_pending_task[] ="COMPLETING_ACADEMIC_STATE";
				}
				##########################################
				####### COMPLETING_PHYSICAL_SECTION ######
				if($fldClass != "" && $fldHeight != "" && $fldWeight != "" && $fldSport != "" && $fldPrimaryPosition != "" && $fldSecondaryPosition != ""
				&& $fldVertical != "" && $fld40_yardDash != "" && $fldShuttleRun != "" && $fldBenchPressMax != "" && $fldSquatMax != "")
				{
					//********//
				}
				else
				{
					$athlete_pending_task[] ="COMPLETING_PHYSICAL_SECTION";
				}
				#########################################
				
				$firstName = $rating_func -> output_fun($profile_db -> f('fldFirstname'));
				$lastName =  $rating_func -> output_fun($profile_db -> f('fldLastname'));
				$pass =  $rating_func -> output_fun($profile_db -> f('fldLastname'));
				
				if(count($athlete_pending_task)>0)
				{
					######################## EMAIL Athlete ########################
								#Subject
								$subjectStre = "College Prospect Network - Athlete Pending Task";
								
								#Intro
								$bodyStre = "Hi " . ucfirst($firstName) . '&nbsp;' . ucfirst($lastName) . ",<br /><br />";
								
								#Main Body
								$bodyStre .= "You are receiving this email because your profile is not fully updated and pending some tasks <a href=http://www.CollegeProspectNetwork.com>www.CollegeProspectNetwork.com.</a> <br />";
								$bodyStre .= "<br />";
								$bodyStre .= "Please take a couple of minutes to login and update your profile. <br />";
								$bodyStre .= "<br />";
								$bodyStre .= "Please do not reply to this email. If you have any questions or concerns, please use the Contact Us page on the website or email us at contact@collegeprospectnetwork.com.<br />";
								$bodyStre .= "<br />";
								
								#Login Info & Directions
								$bodyStre .= "-------------------------------------------------------- <br />";
								$bodyStre .= "Login: <a href=http://www.collegeprospectnetwork.com/login.php>http://www.collegeprospectnetwork.com/login.php</a><br />";
								$bodyStre .= "Username: " . $fldUsername . "<br />";
								$bodyStre .= "Password: " . $pass ."<br />";
								$bodyStre .= "User Type: Athlete<br />";
								$bodyStre .= "<br />";
								$bodyStre .= "-------------------------------------------------------- <br />";
								$bodyStre .= "<br />";
								
								#Footer
								$bodyStre .= "Thank you in advance Coach " . ucfirst($firstName) . "&nbsp;" . ucfirst($lastName) . ",<br />";
								$bodyStre .= "<br />";
								$bodyStre .= "College Prospect Network<br />";
								$bodyStre .= "<a href=http://www.CollegeProspectNetwork.com>www.CollegeProspectNetwork.com</a>";
								
								#SEND EMAL
								$rating_func -> sendEmail($fldEmail, $subjectStre, $bodyStre, "admin@collegeprospectnetwork.com");
								########## ///END EMAIL/// ##########
				}
				##############################################
				########### RESPONDING_TO_EMAILS #############
				$query_2 = "select * from tbl_mail where Usertypeto='athlete' AND UserTo='".$fldUsername."' AND status='unread'";
				$rating_db_2 -> query($query_2);
				$totalPages = $rating_db_2->num_rows();
				
				if($totalPages > 0)
				{
					$rating_db_2 -> next_record();
					// please read emails 
					######################## EMAIL Athlete ########################
								#Subject
								$subjectStre = "College Prospect Network - Athlete Unreaded Email";
								
								#Intro
								$bodyStre = "Hi " . ucfirst($firstName) . "&nbsp;" . ucfirst($lastName) . ",<br /><br />";
								
								#Main Body
								$bodyStre .= "You are receiving this email because you have some unreaded mails so please read your emails and responds them if needed. <a href=http://www.CollegeProspectNetwork.com>www.CollegeProspectNetwork.com.</a> <br />";
								$bodyStre .= "<br />";
								$bodyStre .= "Please take a couple of minutes to login and check your unreaded emails. <br />";
								$bodyStre .= "<br />";
								$bodyStre .= "Please do not reply to this email. If you have any questions or concerns, please use the Contact Us page on the website or email us at contact@collegeprospectnetwork.com.<br />";
								$bodyStre .= "<br />";
								
								#Login Info & Directions
								$bodyStre .= "-------------------------------------------------------- <br />";
								$bodyStre .= "Login: <a href=http://www.collegeprospectnetwork.com/login.php>http://www.collegeprospectnetwork.com/login.php</a><br />";
								$bodyStre .= "Username: " . $fldUsername . "<br />";
								$bodyStre .= "Password: " . $pass ."<br />";
								$bodyStre .= "User Type: Athlete<br />";
								$bodyStre .= "<br />";
								$bodyStre .= "-------------------------------------------------------- <br />";
								$bodyStre .= "<br />";
								
								#Footer
								$bodyStre .= "Thank you in advance  " . ucfirst($firstName) . "&nbsp;" . ucfirst($lastName) . ",<br />";
								$bodyStre .= "<br />";
								$bodyStre .= "College Prospect Network<br />";
								$bodyStre .= "<a href=http://www.CollegeProspectNetwork.com>www.CollegeProspectNetwork.com</a>";
								
								#SEND EMAL
								$rating_func -> sendEmail($fldEmail, $subjectStre, $bodyStre, "admin@collegeprospectnetwork.com");
								########## ///END EMAIL/// ##########
				}
				##############################################
				########### SEND_NETWORK_REQUEST #############
				$query_3 = "select * from tbl_network where fldReceiverid='".$fldId."' AND fldReceiverType='athlete' AND fldStatus='Pending'";
				$rating_db_3 -> query($query_3);
				$totalPages = $rating_db_3->num_rows();
				
				$arr_info = array();
		
				if($totalPages > 0)
				{
					$rating_db_3 -> next_record();
					// please respond to network request emails 
					######################## EMAIL Athlete ########################
								#Subject
								$subjectStre = "College Prospect Network - Athlete Pending Network Request";
								
								#Intro
								$bodyStre = "Hi " . ucfirst($firstName) . "&nbsp;" . ucfirst($lastName) . ",<br /><br />";
								
								#Main Body
								$bodyStre .= "You are receiving this email because you have pending some network request for approval. <a href=http://www.CollegeProspectNetwork.com>www.CollegeProspectNetwork.com.</a> <br />";
								$bodyStre .= "<br />";
								$bodyStre .= "Please take a couple of minutes to login and manage your Network. <br />";
								$bodyStre .= "<br />";
								$bodyStre .= "Please do not reply to this email. If you have any questions or concerns, please use the Contact Us page on the website or email us at contact@collegeprospectnetwork.com.<br />";
								$bodyStre .= "<br />";
								
								#Login Info & Directions
								$bodyStre .= "-------------------------------------------------------- <br />";
								$bodyStre .= "Login: <a href=http://www.collegeprospectnetwork.com/login.php>http://www.collegeprospectnetwork.com/login.php</a><br />";
								$bodyStre .= "Username: " . $fldUsername . "<br />";
								$bodyStre .= "Password: " . $pass ."<br />";
								$bodyStre .= "User Type: Athlete<br />";
								$bodyStre .= "<br />";
								$bodyStre .= "-------------------------------------------------------- <br />";
								$bodyStre .= "<br />";
								
								#Footer
								$bodyStre .= "Thank you in advance Coach " . ucfirst($firstName) . "&nbsp;" . ucfirst($lastName) . ",<br />";
								$bodyStre .= "<br />";
								$bodyStre .= "College Prospect Network<br />";
								$bodyStre .= "<a href=http://www.CollegeProspectNetwork.com>www.CollegeProspectNetwork.com</a>";
								
								#SEND EMAL
								$rating_func -> sendEmail($fldEmail, $subjectStre, $bodyStre, "admin@collegeprospectnetwork.com");
								########## ///END EMAIL/// ##########
				}
				
				$profile_db -> next_record();
			}
		}
	die;
?>