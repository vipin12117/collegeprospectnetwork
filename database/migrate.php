truncate table `athletes`;
INSERT INTO `athletes` 
(`id`, `username`, `password`, `email`, `firstname`, `lastname`, `class`, `height`, `weight`, `sport_id`, `primary_position`, 
`secondary_position`, `vertical`, `description`, `hs_aau_team_id`, `image`, `status`, `comments`, `division`, `yarddash_40`, `shuttle_run`,
`bench_press_max`, `squat_max`, `gpa`, `sat_score`, `act_score`, `class_rank`, `clearing_house_eligible`, `intended_major`, `coach_id`, 
`question`, `answer`, `state`, `jersey_number`, `is_notified`, `note_id`, `last_week_counter`, `weekly_counter`, 
`total_counter`, `youtube_link`, `youtube_modifydate`, `rating`, `total_points`, `approve_hs_aau_coach_id`, `added_date`, `modify_date`) 

select 
`fldId`, `fldUsername`, `fldPassword`, `fldEmail`, `fldFirstname`, `fldLastname`, `fldClass`, `fldHeight`, `fldWeight`, `fldSport`,
  `fldPrimaryPosition`, `fldSecondaryPosition`, `fldVertical`, `fldDescription`, `fldSchool`, `fldImage`, `fldStatus`, `fldComments`, `fldDivision`, 
  `fld40_yardDash`, `fldShuttleRun`, `fldBenchPressMax`, `fldSquatMax`, `fldGPA`, `fldSATScore`, `fldACTScore`,
  `fldClassRank`, `fldClearinghouseEligible`, `fldIntendedMajor`, `fldCoach`, `fldQuestion`, `fldAnswer`,
  `fldState`, `fldJerseyNumber`, `fldNotificationSent` , `fldNoteID` , `fldLastweekcounter`, `fldWeeklycounter`, 
  `fldTotalcounter`, `fldYoutubelink`, `fldYoutubeModifiedDate`, `fldIntangible_rating`, `fldTotal_points` , `fldApproveCoachId`,
  `fldAddDate`, `fldDateLastUpdated`
  from  db142079_cpn.tbl_athelete_register;
  
update `athletes` a SET status = (select IF(fldStatus = 'Active', 1 , IF(fldStatus = 'DEACTIVE' , 0 , 2)) from db142079_cpn.tbl_athelete_register where fldId = a.id);  
  
truncate table `athlete_stats`;
INSERT INTO `athlete_stats` 
(`id`, `event_id`, `athlete_id`, `athlete_stat_category_id`, `value`, `label_name`, `hs_aau_coach_id`, `sport_id`, `group`, `status`, `sort_order`, 
`added_date`, `modify_date`)   

select 
`fldId`, `fldPrograme`, `fldAtheleteId`, `fldCategoryId`, `fldValue`, `fldLabelname`, `fldCoachId`, `fldSportid`, `fldGroup`, `fldStatus`, `fldSortOrder`, 
  `fldAddDate`, fldModifiedDate from db142079_cpn.`tbl_athelete_stat`;
  

truncate table `athlete_videos`;
INSERT INTO `athlete_videos` 
(`title`, `video_path`, `video_type`, `athlete_id`, `status`, `added_date`)

select `fldTitle`, `fldVideo`, `fldVideoType`, `fldAthleteId`, `fldStatus`, `fldAddDate`
 from db142079_cpn.`tbl_athlete_video`;  
  
  
truncate table block_messages;
insert into block_messages (
id, `from` , sport , `to` , start_date , end_date , status)

select `fldId`, `fldFrom`, `fldSport`, `fldTo`, `fldStartdate`, `fldEndDate`, `fldStatus` 
from db142079_cpn.`tbl_block_message`;

truncate table colleges;
insert into colleges
(`id`, `name`, `address_1`, `city`, `state`, `zip`, `status`, `divison`, `latitude`, `longitude`, `approved`,
 `username`, `join_date`, `dateofmodification`)
 
select `fldId`, `fldName`, `fldAddress`, `fldCity`, `fldState`, `fldZipCode`, `fldStatus`, `fldDivison`, `fldLatitude`, `fldLongitude`, 
`fldAdminApproved`, `fldAddByCollegeUsername`, `fldAddDate`, `fldDateLastUpdated`
from db142079_cpn.`tbl_college`;


truncate table college_coaches;
insert into college_coaches
(`id`, `username`, `password`, `college_id`, `city`, `state`, `zip`, `address_1`, `sport_id`, `position`, `need_type_id`, 
`email`, `email2`, `firstname`, `lastname`, `phone`, `phone2`, `division`, `question`, `answer`, `status`, `added_date`, `modified_date`, `subscription_id`)
 
select `fldId`, `fldUserName`, `fldPassword`,  `fldCollegename`, `fldCity`, `fldState`, `fldZipCode`, `fldAddress`, 
 `fldSport`, `fldPosition`, `fldNeedType`, `fldEmail`, `fldAlternativeEmail`, `fldFirstName`, `fldLastName`, `fldPhone`, 
 `fldAlternativePhone`, `fldDivison`, `fldQuestion`, `fldAnswer`, `fldStatus`, `fldAddDate`, `fldDateLastUpdated`, `fldANetCustomerProfileId`
from db142079_cpn.`tbl_college_coach_register`;


truncate table hs_aau_coach;
insert into hs_aau_coach
(`id`, `username`, `password`, `firstname`, `lastname`, `email`, `email2`, `phone`, `phone2`, `description`, `hs_aau_team_id`, `sport_id`, `position`,
 `question`, `answer`, `status`, `added_date`, `modify_date`) 
 
select `fldId`, `fldUsername`, `fldPassword`, `fldName`, `fldLastName`, `fldEmail`, `fldAEmail`, `fldPhone`, `fldAPhone`, `fldDescription`, 
`fldSchool`, `fldSport`, `fldPosition`,  `fldQuestion`, `fldAnswer`, `fldStatus`, `fldAddDate`, `fldDateLastUpdated`
from db142079_cpn.`tbl_hs_aau_coach`;


truncate table hs_aau_coach_sportpositions;
insert into hs_aau_coach_sportpositions
(`id`, `sport_id`, `position`, `hs_aau_coach_id`) 
 
select `fldId`, `fldSportId`, `fldPosition`, `fldCoachNameId`
from db142079_cpn.tbl_hs_aau_coach_sportposition;


truncate table hs_aau_team;
insert into hs_aau_team
(`id`, `username`, `password`, `school_name`, `coach_name`, `coach_phone`, `email`, `city`, `state`, `address`, `zip`, `logo`, 
`sport_id`, `athlete_username`, `coach_username`, `enrollment`,  admin_approved, `latitude`, `longitude`, `status`, `added_date`, `modify_date`) 
 
select `fldId`, `fldUserName`, `fldPassword`, `fldSchoolname`, `fldCoachname`, `fldCoachPhone`, `fldEmail`, `fldCity`, `fldState`, `fldAddress`,
`fldZipcode`, `fldLogo`, `fldSport`,  `fldAddByAthleteUsername`,  `fldAddByCoachUsername`,`fldEnrollment`, `fldAdminApproved`, `fldLatitude`, 
`fldLongitude`, `fldStatus` , `fldAddDate`, `fldDateLastUpdated`
from db142079_cpn.`tbl_hs_aau_team`;

  
truncate table events;
insert into events (`id`, `sport_id`, `event_name`, `event_desc`, `location`, `start_date`, `end_date`, `home_team`, `away_team`, `event_opponent`, 
`status`, `user_type`, `username`)

select `fldEventId`, `fldSport`, `fldEventName`, `fldEventDescription`, `fldEventLocation`, `fldEventStartDate`, `fldEventEndDate`, `fldHomeTeam`, 
`fldAwayTeam`,`fldEventOpponent`, `fldEventStatus`, `fld_UserType` , `fldUserName` from db142079_cpn.`tbl_event`;

truncate table networks;
insert into networks(`sender_id`, `receiver_id`, `sender_type`, `receiver_type`, `status`, 
`date_added`, `modify_date`)

select `fldSenderid`, `fldReceiverid`, `fldSenderType`,  `fldReceiverType`, `fldStatus`, 
 `fldSendingDate`, `fldDateModified` from db142079_cpn.`tbl_network`;


truncate table mails;
insert into mails(`sender`, `receiver`, `subject`, `message`, `status`, `sent_date`, 
`usertype_from`, `usertype_to`)

select `UserFrom`, `UserTo`, `Subject`, `Message`, `status`, `SentDate`, 
`Usertypefrom` , `Usertypeto` from db142079_cpn.`tbl_mail`;
  