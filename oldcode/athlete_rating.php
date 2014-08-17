<?php 
$SessionUserID = isset($_SESSION['Athlete_id'])?$_SESSION['Athlete_id']:0;
$rating_func = new COMMONFUNC;
$rating_db = new DB;
if($SessionUserID >0)
{  
    $query = "Select * from tbl_athelete_register where fldId = '$SessionUserID' ";
    $rating_db -> query($query);
    $rating_db -> next_record();
    
    $totalPages = $rating_db->num_rows();
	
	if($totalPages > 0)
	{
		$UserID = $rating_db -> f('fldId');
		$uploadImage = $rating_db -> f('fldImage');
		$coachApprove = $rating_db -> f('fldApproveCoachId');
		$uploadVideo =  $rating_func -> GetValue("tbl_athlete_video","fldId","fldAthleteId",$rating_db -> f('fldId'));
		
		$uploadGameSchedule  =  $rating_func -> GetValue("tbl_event","fldEventId","fld_UserType='athlete' AND fldUserName",$rating_db -> f('fldUsername'));
		
		$fldGPA = $rating_func -> output_fun($rating_db -> f('fldGPA'));
		$fldSATScore = $rating_func -> output_fun($rating_db -> f('fldSATScore'));
		$fldACTScore = $rating_func -> output_fun($rating_db -> f('fldACTScore'));
		$fldClassRank = $rating_func -> output_fun($rating_db -> f('fldClassRank'));
		$fldClearinghouseEligible = $rating_func -> output_fun($rating_db -> f('fldClearinghouseEligible'));
		$fldIntendedMajor = $rating_func -> output_fun($rating_db -> f('fldIntendedMajor'));
	
		$fldClass = $rating_func -> output_fun($rating_db -> f('fldClass'));
		$fldHeight = $rating_func -> output_fun($rating_db -> f('fldHeight'));
		$fldWeight = $rating_func -> output_fun($rating_db -> f('fldWeight'));
		$fldSport = $rating_func -> output_fun($rating_db -> f('fldSport'));
		//$fldJerseyNumber = $rating_func -> output_fun($rating_db -> f('fldJerseyNumber'));
		$fldPrimaryPosition = $rating_func -> output_fun($rating_db -> f('fldPrimaryPosition'));
		$fldSecondaryPosition = $rating_func -> output_fun($rating_db -> f('fldSecondaryPosition'));
		$fldVertical = $rating_func -> output_fun($rating_db -> f('fldVertical'));
		$fld40_yardDash = $rating_func -> output_fun($rating_db -> f('fld40_yardDash'));
		$fldShuttleRun = $rating_func -> output_fun($rating_db -> f('fldShuttleRun'));
		$fldBenchPressMax = $rating_func -> output_fun($rating_db -> f('fldBenchPressMax'));
		$fldSquatMax = $rating_func -> output_fun($rating_db -> f('fldSquatMax'));
		
		##############################################
		######### PROFILE COMLITION RATING START #####
		##############################################	
		
			####### APPROVED_BY_COACH ################
			if($coachApprove > 0 || $coachApprove != "")
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"APPROVED_BY_COACH",true);
			}
			else
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"APPROVED_BY_COACH",false);
			}
			##########################################
			####### UPLOADING_GAME_TAPE ##############
			if($uploadVideo > 0 || $uploadVideo != "")
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"UPLOADING_GAME_TAPE",true);
			}
			else
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"UPLOADING_GAME_TAPE",false);
			}
			#########################################
			####### ADDING_PROFILE_PICTURE ##########
			if($uploadImage != "default.jpg" || $uploadImage != "")
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"ADDING_PROFILE_PICTURE",true);
			}
			else
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"ADDING_PROFILE_PICTURE",false);
			}
			##########################################
			####### UPLOADING_GAME_SHEDULE ###########
			if($uploadGameSchedule > 0 || $uploadGameSchedule != "")
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"UPLOADING_GAME_SHEDULE",true);
			}
			else
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"UPLOADING_GAME_SHEDULE",false);
			}
			#########################################
			####### COMPLETING_ACADEMIC_STATE #######
			if($fldGPA != "" && $fldSATScore != "" && $fldACTScore != "" && $fldClassRank != "" && $fldClearinghouseEligible != "" && $fldIntendedMajor != "")
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"COMPLETING_ACADEMIC_STATE",true);
			}
			else
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"COMPLETING_ACADEMIC_STATE",false);
			}
			##########################################
			####### COMPLETING_PHYSICAL_SECTION ######
			if($fldClass != "" && $fldHeight != "" && $fldWeight != "" && $fldSport != "" && $fldPrimaryPosition != "" && $fldSecondaryPosition != ""
			&& $fldVertical != "" && $fld40_yardDash != "" && $fldShuttleRun != "" && $fldBenchPressMax != "" && $fldSquatMax != "")
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"COMPLETING_PHYSICAL_SECTION",true);
			}
			else
			{
				$rating_func -> setAtheleteRating("PROFILE",$UserID,"COMPLETING_PHYSICAL_SECTION",false);
			}
			#########################################
		$rating_func -> athlete_total_rating($UserID);	
		##############################################
		######### PROFILE COMLITION RATING END #######
		##############################################		
	}
}
?>

