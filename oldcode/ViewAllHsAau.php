<?php
    ##******************************************************************
    ##  Project		:		Sport Social Networking - Admin Panel
    ##  Done by		:		Narendra Singh
    ##	Page name	:		ViewAllHsAau.php
    ##	Create Date	:		17/07/2011
    ##  Description :		It is use to shoe the listing of athlete.
    ##	Copyright   :       Synapse Communications Private Limited.
    ## *****************************************************************
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    session_start();
	$network_for = isset($_REQUEST["network_for"])?$_REQUEST["network_for"]:"";
    $ModeType = isset($_REQUEST["mode"])?$_REQUEST["mode"]:"";
    if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {
        header("Location:index.php");
    }
    //for paging
    $func = new COMMONFUNC;
    //Create an instance of class COMMONFUNC
    $page = new Page();
    //Create an instance of class Pate
    $lnb = "2";
    $error_msg = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - Browse All Colleges</title>
		<META NAME="Keywords" CONTENT="">
		<META NAME="Description" CONTENT="">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script language="JavaScript" type="text/JavaScript"></script>
	</head>
	<body>
		<?php
            include ('header.php');
		?>
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
							<div class="registerPage">
								<h1>HS / AAU Coach Listing</h1>
								<? if ($_REQUEST['msg'] != "") {
								     echo '<font class="thankyoumessage">' . $_REQUEST['msg'] . '</font>';  
                                }  ?>
                               
								<table cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" width="100%" class="tablePadd" style="border-collapse: collapse;">
									<?php
                                       $collegeuser_id = $_SESSION['FRONTEND_USER'];
										
                                     /*  */
										switch ($ModeType) {
											case 'athlete':
												//AthleteID
												$UserID =  isset($_SESSION['Athlete_id'])?$_SESSION['Athlete_id']:"";
												$fldSport = $func -> GetValue("tbl_athelete_register","fldSport","fldId",$UserID);	
												$query = "select first.fldId as id,first.fldSchool as schoolName, first.fldName as name,first.fldLastName as lname,first.fldEmail as email,second.fldSportId as sport from " . TBL_HS_AAU_COACH . " first," . TBL_HS_AAU_COACH_SPORT_POSITION . " second," . TBL_COLLEGE_COACH_REGISTER . " third where second.fldCoachNameId=first.fldId and second.fldSportId =" . $fldSport . " group by first.fldEmail";
												break;
											case 'coach':
												//HS Coach ID
												$UserID =isset($_SESSION['Coach_id'])?$_SESSION['Coach_id']:"";
												$fldSport = $func -> GetValue("tbl_hs_aau_coach","fldSport","fldId",$UserID);
												$query = "select first.fldId as id,first.fldSchool as schoolName,first.fldName as name,first.fldLastName as lname,first.fldEmail as email,second.fldSportId as sport from " . TBL_HS_AAU_COACH . " first," . TBL_HS_AAU_COACH_SPORT_POSITION . " second," . TBL_COLLEGE_COACH_REGISTER . " third where second.fldCoachNameId=first.fldId and second.fldSportId =" . $fldSport . " group by first.fldEmail";
												break;
											case 'college':
												//College Coach ID
												$UserID = isset($_SESSION['College_Coach_id'])?$_SESSION['College_Coach_id']:"";
												$sport_info = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId,fldNeedType", "fldId", "where fldUserName='" . $collegeuser_id . "'");
									 
                                       			$query = "select first.fldId as id,first.fldSchool as schoolName,first.fldName as name,first.fldLastName as lname,first.fldEmail as email,second.fldSportId as sport from " . TBL_HS_AAU_COACH . " first," . TBL_HS_AAU_COACH_SPORT_POSITION . " second," . TBL_COLLEGE_COACH_REGISTER . " third where second.fldCoachNameId=first.fldId and second.fldSportId =" . $sport_info[0]['fldNeedType'] . " group by first.fldEmail";
												break;
										}   
                                        
                                        $db -> query($query);
                                        $db -> next_record();
                                        $totalPages = $db -> num_rows();
                                        #Code for paging
                                        $page -> set_page_data('', $db -> num_rows(), 25, 5, true, false, true);
										$queryString = "network_for=".$network_for."&mode=".$ModeType;
                                        $page -> set_qry_string($queryString);
                                        $query = $page -> get_limit_query($query);
										
										
                                        //return the query with limits
                                        $db -> query($query);
                                        $db -> next_record();
                                        if ($db -> num_rows() > 0) {#check for record availability
                                            echo '<tr>';
                                            echo '<td align="left" class="normalblack_12" width="25%">&nbsp;<strong>HS/AAU Coach Name</strong></td>';
                                            echo '<td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Team</strong></td>';
                                            echo '<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>Sport</strong></td>';
                                            echo '<td class="normalblack_12" width="15%" align="center"><strong>View Profile</strong></td>';
                                            echo '</tr>';
                                            $count = "1";
                                            for ($i = 0; $i < $db -> num_rows(); $i++) {
                                                $fldId = $func -> output_fun($db -> f('id'));
                                                $fldFirstname = $func -> output_fun($db -> f('name'));
                                                $fldLastname = $func -> output_fun($db -> f('lname'));
                                                $fldEmail = $func -> output_fun($db -> f('email'));
                                                $fldSport = $func -> output_fun($db -> f('sport'));
												$fldSchool = $func -> output_fun($db -> f('schoolName'));
                                                $query = "SELECT fldSportsname  from " . TBL_SPORTS . "  WHERE fldId='$fldSport'";
                                                $db1 -> query($query);
                                                $db1 -> next_record();
												$fldTeam = $func->GetValue(TBL_HS_AAU_TEAM,"fldSchoolname","fldId",$fldSchool);
                                                $fldSportsname = $func -> output_fun($db1 -> f('fldSportsname'));
                                                echo '<tr>';
                                                echo '<td align="left" class="normalblack_12" >' . wordwrap(ucfirst($fldFirstname) . '&nbsp;' . ucfirst($fldLastname), 29, "\n", true) . '</td>';
                                                echo '<td align="left" class="normalblack_12" >' . wordwrap($fldTeam, 25, "\n", true) . '</td>';
                                                echo '<td align="left" class="normalblack_12" >' . wordwrap($fldSportsname, 17, "\n", true) . '</td>';
                                                echo '<td class="normalblack_12" align="center"><a href="HsAauCoachProfile.php?mode=view&fldId=' . $fldId . '"><img src="admin/images/view.gif" border="0" title="View"></a></td>';
                                                echo '</tr>';
                                                $db -> next_record();
                                                $count++;
                                            }
                                            #show pagination
                                            echo '<tr><td align="right" class="normalblack_12" colspan="10">';
                                            $page -> get_page_nav();
                                            echo '</td></tr>';
                                        } else {#no record message comes here
                                            echo '<tr><td align="center" class="normalblack_12" colspan="10" height="30">

							       <font class = "thankyoumessage">No Records Available.</font></td></tr>';
                                        }
                                        echo '</form></table>';
									?>
									<br/>
									<p>
										<label>&nbsp;</label>
										<span>
											<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">
										</span>
									</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
            include ('footer.php');
		?>
	</body>
</html>