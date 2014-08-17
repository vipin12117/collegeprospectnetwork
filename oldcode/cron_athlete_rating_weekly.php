<?php
include_once ("inc/common_functions.php");
include_once ("inc/page.inc.php");

session_start();

$rating_func = new COMMONFUNC;
$rating_db_1 = new DB;
$rating_db_2 = new DB;
$rating_db_3 = new DB;
$rating_db_4 = new DB;
$rating_db_5 = new DB;
$rating_db_6 = new DB;
$rating_db_7 = new DB;

		##############################################
		######### WEEKLY RATING START ################
		##############################################
		
		########### ADDING_GAME_STATE ################
		$query_1 = "select * from tbl_event where ((date(fldEventStartDate) < (now()) AND date(fldEventStartDate) >= (DATE_SUB(now(), INTERVAL 8 day))) OR date(fldEventEndDate) >= (DATE_SUB(now(), INTERVAL 8 day))) and fld_UserType='athlete'";
		
		
		
		$rating_db_1 -> query($query_1);
		$rating_db_1 -> next_record();
		$arr_info = array();
		$totalPages = $rating_db_1->num_rows();
		if($totalPages > 0)
		{
			for ($k = 0; $k < $totalPages; $k++) 
			{
				$arr_info[$k]['fldUserName'] = $rating_db_1 -> f('fldUserName');
			//	$arr_info[$k]['fldEventStartDate'] = $rating_db_1 -> f('fldEventStartDate');
				$rating_db_1 -> next_record();
			}
			
			for ($kj = 0; $kj < count($arr_info); $kj++) 
			{
				$fldAthleteId =  $rating_func -> GetValue("tbl_athelete_register","fldId","fldUserName",$arr_info[$kj]['fldUserName']);
				$rating_func -> setAtheleteRating("WEEKLY",$fldAthleteId,"ADDING_GAME_STATE",true);
			}
		}
		##############################################
		########### RESPONDING_TO_EMAILS #############
		$query_2 = "select * from tbl_mail where (date(SentDate) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(SentDate)< (now())) AND Usertypeto='athlete'";
		$rating_db_2 -> query($query_2);
		$totalPages = $rating_db_2->num_rows();
		
		
		$arr_info = array();
		
		if($totalPages > 0)
		{
			$rating_db_2 -> next_record();
			for ($k = 0; $k < $totalPages; $k++) 
			{
				$checkUnread =  $rating_func -> GetValue("tbl_mail","mail_id","status='unread' AND UserTo",$rating_db_2 -> f('UserTo'));
				if(trim($checkUnread) == "")
				{
					$arr_info[$k] = trim($rating_db_2 -> f('UserTo'));
				}
				$rating_db_2 -> next_record();
			}
			$uniqueInfo = array_unique($arr_info);
			for ($kj = 0; $kj < count($uniqueInfo); $kj++) 
			{
				$fldAthleteId =  $rating_func -> GetValue("tbl_athelete_register","fldId","fldUserName",$uniqueInfo[$kj]);
				$rating_func -> setAtheleteRating("WEEKLY",$fldAthleteId,"RESPONDING_TO_EMAILS",true);
			}
		}
		##############################################
		########### SEND_NETWORK_REQUEST #############
		$query_3 = "select * from tbl_network where (date(fldSendingDate) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(fldSendingDate)< (now())) and fldSenderType='athlete' and fldReceiverType='college'";
		$rating_db_3 -> query($query_3);
		$totalPages = $rating_db_3->num_rows();
		
		$arr_info = array();

		if($totalPages > 0)
		{
			$rating_db_3 -> next_record();
			for ($k = 0; $k < $totalPages; $k++) 
			{
				$arr_info[$k] = trim($rating_db_3 -> f('fldSenderid'));
				$rating_db_3 -> next_record();
			}
			$uniqueInfo = array_unique($arr_info);
			for ($kj = 0; $kj < count($uniqueInfo); $kj++) 
			{
				$fldAthleteId =  $rating_func -> GetValue("tbl_athelete_register","fldId","fldUserName",$uniqueInfo[$kj]);
				$rating_func -> setAtheleteRating("WEEKLY",$fldAthleteId,"SEND_NETWORK_REQUEST",true);
			}
		}
		########################################################
		########### RESPONDING_ALL_NETWORK_REQUEST #############
		$query_4 = "select * from tbl_network where (date(fldDateModified) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(fldDateModified)< (now())) AND fldReceiverType='athlete' AND fldStatus='Active'";
		$rating_db_4 -> query($query_4);
		$arr_info = array();
		$totalPages = $rating_db_4->num_rows();
		if($totalPages > 0)
		{
			$rating_db_4 -> next_record();
			for ($k = 0; $k < $totalPages; $k++) 
			{
				$arr_info[$k] = trim($rating_db_4 -> f('fldReceiverid'));
				$rating_db_4 -> next_record();
			}
			$uniqueInfo = array_unique($arr_info);
			for ($kj = 0; $kj < count($arr_info); $kj++) 
			{
				$fldAthleteId =  $rating_func -> GetValue("tbl_athelete_register","fldId","fldUserName",$uniqueInfo[$kj]);
				$rating_func -> setAtheleteRating("WEEKLY",$fldAthleteId,"RESPONDING_ALL_NETWORK_REQUEST",true);
			}
		}
		########################################################
		########### ADDING_LINKS_TO_HIGHLIGHT_FILMS_ON_YOUTUBE #############
		$query_5 = "select * from tbl_athelete_register where (date(fldYoutubeModifiedDate) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(fldYoutubeModifiedDate)< (now())) AND fldStatus='Active'";
		$rating_db_5 -> query($query_5);
		$arr_info = array();
		$totalPages = $rating_db_5->num_rows();
		if($totalPages > 0)
		{
			$rating_db_5 -> next_record();
			for ($k = 0; $k < $totalPages; $k++) 
			{
				$rating_func -> setAtheleteRating("WEEKLY",$rating_db_5 -> f('fldId'),"ADDING_LINKS_TO_HIGHLIGHT_FILMS_ON_YOUTUBE",true);
				$rating_db_5 -> next_record();
			}
		}
		
		########################################################
		########### FEEDBAK_FROM_OPPOSING_COACH #############
		$query_6 = "select * from tbl_opp_comments where (date(fldaddedDate) >= (DATE_SUB(now(), INTERVAL 8 day)) AND date(fldaddedDate)< (now())) GROUP BY fldathleteid,fldcoachid";
		$rating_db_6 -> query($query_6);
		$arr_info = array();
		$totalPages = $rating_db_6->num_rows();
		
	
		if($totalPages > 0)
		{
			$rating_db_6 -> next_record();
			for ($k = 0; $k < $totalPages; $k++) 
			{
				$UserID = $rating_db_6 -> f('fldId');
				$rating_func -> setAtheleteRating("WEEKLY",$UserID,"FEEDBAK_FROM_OPPOSING_COACH",true);
				$rating_db_6 -> next_record();
			}
		}
		########################################################
		########### MOST_PROFILE_VIEW #############
		$query_7 = "select * from tbl_athelete_register where fldStatus='Active' ORDER BY fldWeeklycounter DESC";
		$rating_db_7 -> query($query_7);
		$arr_info = array();
		$totalPages = $rating_db_7->num_rows();
		
		$rating_func -> reset_weekly_counter();
		if($totalPages > 0)
		{
			$rating_db_7 -> next_record();
			$UserID = $rating_db_7 -> f('fldId');
			$rating_func -> setAtheleteRating("WEEKLY",$UserID,"MOST_PROFILE_VIEW",true);
			
		}
		##############################################
		######### WEEKLY RATING END ##################
		##############################################

	die;
?>