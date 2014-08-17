<?php
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('America/New_York');

//Debug Mode for Local Developers
$is_local = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);
//define ('DEBUG',$is_local);


define(TBL_ADMIN,"tbl_admin");                               
define(TBL_USER_PROFILE,"athlete"); 
define(TBL_PAGE,"tbl_page");  
define(TBL_SCHOOL_REGISTER,"tbl_school_register"); 
define(TBL_HS_AAU_TEAM,"tbl_hs_aau_team"); 
define(TBL_COLLEGE_REGISTER,"tbl_college_coach_register"); 
define(TBL_COLLEGE_COACH_REGISTER,"tbl_college_coach_register"); 
define(TBL_COACH_REGISTER,"tbl_coach_register");
define(TBL_HS_AAU_COACH," tbl_hs_aau_coach");
define(TBL_SPECIAL_EVENT_REGISTER,"tbl_special_event_register");
# Contain members details
define(TBL_CATAGORY,"tbl_catagory"); 
define(TBL_EVENT,"tbl_event"); 
define(TBL_SPECIAL_EVENT,"tbl_special_event"); 
define(TBL_SPORTS,"tbl_sports");
define(TBL_TEAM,"tbl_team"); 
define(TBL_COLLEGE,"tbl_college"); 
define(TBL_COLLEGE_SUBSCRIPTION,'tbl_college_subscription');
define(TBL_COLLEGE_NEEDS, 'tbl_college_needs');
define(TBL_SCHOOL_SPORT_COACH,"tbl_hs_aau_team_coach");
define(TBL_HS_AAU_TEAM_COACH,"tbl_hs_aau_team_coach");
define(TBL_COLLEGE_SPORT_COACH,"tbl_college_sport_coach"); 
define(TBL_SUBSRIPTION,"tbl_subsription");
define(TBL_SUBSCRIPTION,"tbl_subsription");
define(TBL_SPORTCALENDER,"tbl_sportcalender");
define(TBL_MAIL,"tbl_mail");
define(TBL_ATHELETE_STAT,"tbl_athelete_stat");
define(TBL_ATHLETE_STAT, 'tbl_athelete_stat');
define(TBL_ATHELETE_REGISTER,"tbl_athelete_register");
define(TBL_ATHLETE_REGISTER, 'tbl_athelete_register');
define(TBL_BANNER,"tbl_banner");
define(TBL_ADDTONETWORK_REQUEST,"tbl_addtonetwork_request");
define(TBL_NETWORK_MESSAGE,"tbl_network_message");
define(TBL_ATHLETE_VIDEO,"tbl_athlete_video");
define(TBL_ATHLETE_STATS_CATAGORY,"tbl_athlete_stats_catagory");
//define(TBL_ATHLETE_STATS_CATEGORY, 'tbl_athlete_stats_catagory');
define(TBL_BLOCK_MESSAGE,"tbl_block_message");
define(TBL_CLASS,"tbl_class");
define(TBL_OTHER,"tbl_other");
define(TBL_HS_AAU_TEAM_NAME,"tbl_HS_AAU_team_name");
define(TBL_HS_AAU_TEAM_OTHER,"tbl_hs_aau_team_other");
define(TBL_RATING,"tbl_rating");
define(TBL_HOME_CONTENT,"tbl_home_content");
define(TBL_HS_AAU_COACH_RATE,"tbl_hs_aau_coach_rate");
define(TBL_PAYMENT_HISTORY,"tbl_payment_history");
/*tbl_Event_Subsription*/
define(TBL_EVENT_SUBSCRIPTION,"tbl_Event_Subsription");
define(TBL_HS_AAU_COACH_SPORT_POSITION,"tbl_hs_aau_coach_sportposition");
define(TBL_NETWORK,"tbl_network");
define(TBL_ZIP_CODE,"tbl_zip_code");
define(TBL_NEEDTYPE,"tbl_NeedType");
define(TBL_POSITION_FOOTBALL,'tbl_position_football');
define(TBL_POSITION_BASKETBALL,'tbl_position_basketball');
##################### TABLES END #######################################################################################
define(SITE_URL,"http://localhost/collegeprospectnetwork/oldcode/"); // example.com can be replace with your domain
define(ADMIN_URL,"http://localhost/collegeprospectnetwork/oldcode/admin/");  // example.com can be replace with your domain
define(ADMIN_SITE_TITLE,"College Prospect Network - Admin Panel");
define(SITE_TITLE,"College Prospect Network");
define(COMPANYNAME,"College Prospect Network");
define(COPY_YEAR, date("Y"));
define(CURRENCY, "&#36;");
define(MAPS_APIKEY,"ABQIAAAAMaM2NvOQCXElXp06TLIpNRSl2N-ZCAvb5VMts5Cxc8BiwUcKqBRBFoY5sEZAjMbeqdc042oUXKIbOw");
define(EMAIL_FROM,"notifications@collegeprospectnetwork.com");
define(ADMIN_EMAIL,"admin@collegeprospectnetwork.com");
#define(ADMIN_EMAIL,"admintest@collegeprospectnetwork.com");
?>
