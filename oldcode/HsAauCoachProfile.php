<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    session_start();
    if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {
        header("Location:index.php");
    }
    //for paging
    $func = new COMMONFUNC;
    $page = new Page();
    $db = new DB;
    $db2 = new DB;
    $flag = 0;
    
    //Local Variables
    $IsMyProfile = 0;   
    
    if ($_REQUEST['fldId']) {
        $query = " Select * from " . TBL_HS_AAU_COACH . " where fldId ='" . $_REQUEST['fldId'] . "'";
    } else {
        $query = " Select * from " . TBL_HS_AAU_COACH . " where fldUsername ='" . $_SESSION['FRONTEND_USER'] . "'";
    }
    
    $db -> query($query);
    $db -> next_record();
    $HS_AAU_COACH_id = $db -> f('fldId');
    $HS_AAU_COACH_Username = $db -> f('fldUsername');
    $HS_AAU_COACH_name = $db -> f('fldName');
    $HS_AAU_COACH_lname = $db -> f('fldLastName');
    $HS_AAU_COACH_Phone = $db -> f('fldPhone');
    $HS_AAU_COACH_Position = $db -> f('fldPosition');
    
    //Detect if this Athlete is Athlete viewing profile                           
    if (($_REQUEST['fldId'] !='') and ($_SESSION['Coach_id']!='') and ($_REQUEST['fldId'] == $_SESSION['Coach_id'])) {
        $IsMyProfile = 1;                                
    }   
    
    #######################################
    ## SEND NETWORK REQUEST
    //Insert, Display Notification, and Email Recipient  
       
   $GLOBALPage = "HsAauCoachProfile.php?mode=view&fldId=";    
   $GLOBALProfileType = "coach";          
   include("inc/NetworkRequest.php");   
   #######################################
   
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - HS / AAU Profile</title>
		<META NAME="Keywords" CONTENT="My Account">
		<META NAME="Description" CONTENT="My Account">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script language="JavaScript" type="text/JavaScript">
            function networkRequest(fldId) {
                if(confirm("Sure you want to send this Network Request?")) {
                    document.frmUsers.action = "?mode=request&fldId=" + fldId;
                    document.frmUsers.submit();
                }
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
                        This page is currently under Maintenance
                    </div>
                    <form name="frmUsers" action="" method="post" onsubmit="">
					<div class="cantener">
						<div class="register-main">
							<!--<div style="float:right;"> <font color="red">*</font> Fields are Mandatory.</div>-->
							<div class="registerPage1">
								
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
                        
                        
								<h1 style="float:left;">HS / AAU Coach Profile</h1>                                  
                                    <?php
                                    if (($_REQUEST['fldId'] != "") and ($IsMyProfile == 0)) {
                                        ############ Network Request  ###########                               
                                    ?>                                    
                                    <div class="btnclass1" style="float:right;margin-right:20px;">
                                        <p>
                                            <span>
                                                <INPUT TYPE="BUTTON" VALUE="Add To Network" onclick="networkRequest(<?php  echo $_REQUEST['fldId'];?>); ">
                                            </span><div class="clear"></div>
                                        </p>
                                    </div>
                                    <div class="btnclass1" style="float:right;margin-right:20px;">
                                        <p>
                                            <span>
                                                <INPUT TYPE="BUTTON" VALUE="Send Message" onclick="window.open('sendmsgtoath.php?id=<?  echo $_REQUEST['fldId'];?>&usertype=coach','windowname1', 'width=665, height=350'); return false;">
                                            </span><div class="clear"></div>
                                        </p>
                                    </div>
                                    <?php      }?>                                  
                                    <div class="clear"></div>
								
								<div style="width: 890px;">
								    
									<div style="width: 340px;float:left;">										
										<h3>Coach Information</h3>
										<div class="boxes info">
										    <p>
                                                <font class="title">Username: </font><?php   echo $HS_AAU_COACH_Username;?>
                                            </p>								
    										<p>
    											<font class="title">Name: </font><?php   echo ucfirst($HS_AAU_COACH_name) . '&nbsp;' . ucfirst($HS_AAU_COACH_lname);?>
    										</p>
    										<p>
    											<font class="title">Phone: </font><?php   echo $HS_AAU_COACH_Phone;?>
    										</p>
    										<p>
    											<font class="title">Position: </font><?php   echo $HS_AAU_COACH_Position;?>
    										</p>
    										<?php
                                            if($_SESSION['mode']=='college')
                                            {
    										?>
    										<div class="btnclass1">
        										<p style="margin:30px 0 8px; 3px;">
        										    <INPUT TYPE="BUTTON" VALUE="Rate This Coach" onclick="window.open('RatingHsAauCoach.php?fldId=<? echo $_REQUEST['fldId'];?>','windowname1', 'width=700, height=450'); return false;" style="margin-right:20px;">
        										
        									   		<INPUT TYPE="BUTTON" VALUE="View Coach Ratings" onclick="window.open('RatingHsAauCoach.php?fldId=<? echo $_REQUEST['fldId'] . "&mode=view"; ?>','windowname1', 'width=700, height=450'); return false;">			
    									   		 </p>	        		
    										</div>
    										<?php   }?>
										</div><!--//end box-->
									</div><!--//end leftcol-->
									
									<div style="width: 500px;float:right">		
										<h3>High School Quick Glance</h3>
										<div class="boxes info">   
    										<?php
                                                if ($_REQUEST['fldId']) {
                                                    $query1 = "select * from tbl_hs_aau_team first,tbl_hs_aau_coach second where first.fldId = second.fldSchool and second.fldId =" . $_REQUEST['fldId'];
                                                } else {
                                                    $query1 = "select * from tbl_hs_aau_team first,tbl_hs_aau_coach second where first.fldId = second.fldSchool and second.fldId =" . $_SESSION['Coach_id'];
                                                }
                                                $db1 -> query($query1);
                                                $db1 -> next_record();
    										?>    							
    										<p>
    											<font class="title">Name: </font><?php   echo $db1 -> f('fldSchoolname');?>
    										</p>
    										<p>
    											<font class="title">Address: </font><?php   echo $db1 -> f('fldAddress');?>
    										</p>
    										<p>
    											<font class="title">City: </font><?php   echo $db1 -> f('fldCity');?>
    										</p>
    										<p>
    											<font class="title">State: </font><?php   echo $db1 -> f('fldState');?>
    										</p>
    										<p>
    											<font class="title">Zipcode: </font><?php   echo $db1 -> f('fldZipcode');?>
    										</p>
    										<p>
    											<font class="title">Enrollment: </font><?php
                                                    if ($db1 -> f('fldEnrollment')) { echo $db1 -> f('fldEnrollment');
                                                    } else {echo "Not Entered Yet";
                                                    }
    											?>
    										</p>
										</div><!--//end box-->
									</div><!--//end rightcol-->
									
								</div><!--//end top panel-->
								
								<div class="left-panel">
									
										<h3>My Athletes</h3>			
										<div class="boxes" style="width:540px;padding-bottom:0px;padding-top:10px;">		
										  <?php
                                            If ($_SESSION['fldSubscribe'] != 2) {
                                            ?>   
                                								
												<?
                                                    if ($_REQUEST['fldId']) {
                                                        $selquery2 = "select fldSchool from " . TBL_HS_AAU_COACH . " where fldId='" . $_REQUEST['fldId'] . "'";
                                                    } else {
                                                        $selquery2 = "select fldSchool from " . TBL_HS_AAU_COACH . " where fldId='" . $_SESSION['Coach_id'] . "'";
                                                    }
                                                    $db2 -> query($selquery2);
                                                    $db2 -> next_record();
                                                    $fldSchool = $func -> output_fun($db2 -> f('fldSchool'));
                                                    if ($_REQUEST['fldId']) {
                                                        $selquery1 = "select fldSportId from " . TBL_HS_AAU_COACH_SPORT_POSITION . " where fldCoachNameId='" . $_REQUEST['fldId'] . "'";
                                                    } else {
                                                        $selquery1 = "select fldSportId from " . TBL_HS_AAU_COACH_SPORT_POSITION . " where fldCoachNameId='" . $_SESSION['Coach_id'] . "'";
                                                    }
                                                    $db1 -> query($selquery1);
                                                    $db1 -> next_record();
                                                    if ($db1 -> num_rows() > 0) {
                                                        for ($i = 0; $i < $db1 -> num_rows(); $i++) {
                                                            $fldSport[] = $func -> output_fun($db1 -> f('fldSportId'));
                                                            $db1 -> next_record();
                                                        }
                                                    }
                                                    $counttest = 0;
                                                    foreach ($fldSport as $key => $fldSportvalue) {
                                                        $query = "select * from " . TBL_ATHELETE_REGISTER . " where fldSport = " . $fldSportvalue . " and fldSchool=" . $fldSchool . " and fldStatus = 'ACTIVE'";
                                                        $db -> query($query);
                                                        $db -> next_record();
                                                        $totalPages = $db -> num_rows();
                                                        #Code for paging
                                                        $page -> set_page_data('', $db -> num_rows(), 10, 5, true, false, true);
                                                        $page -> set_qry_string($queryString);
                                                        $query = $page -> get_limit_query($query);
                                                        //return the query with limits
                                                        $db -> query($query);
                                                        $db -> next_record();
                                                        if ($db -> num_rows() > 0) {#check for record availability
                                                            $query = "SELECT fldSportsname  from " . TBL_SPORTS . "  WHERE fldId='$fldSportvalue'";
                                                            $db1 -> query($query);
                                                            $db1 -> next_record();
                                                            $fldSportsname = $func -> output_fun($db1 -> f('fldSportsname'));
                                                            echo '<h4 style="margin-bottom:5px;">' . ucfirst($fldSportsname) . '</h4>';
                                                            echo '<table cellspacing="2" cellpadding="5" bordercolor="#e7e7e7" border="0" width="100%" class="tablePadd whitetable" style="border-collapse: collapse;margin-bottom:20px;">';                        
                                                            echo '<td align="center" class="normalblack_12" width="15%">&nbsp;<strong></strong></td>';
                                                            echo '<td align="center" class="normalblack_12" width="40%">&nbsp;<strong>Athlete Name</strong></td>';
                                                            echo '<td align="center" class="normalblack_12" width="25%">&nbsp;<strong>Sport</strong></td>';
                                                            echo '<td class="normalblack_12" width="10%" align="center"><strong>View</strong></td>';
                                                            echo '</tr>';
                                                            $count = "1";
                                                            for ($i = 0; $i < $db -> num_rows(); $i++) {
                                                                $fldId = $func -> output_fun($db -> f('fldId'));
                                                                $fldFirstname = $func -> output_fun($db -> f('fldFirstname'));
                                                                $fldLastname = $func -> output_fun($db -> f('fldLastname'));
                                                                
                                                                $AthFullname = wordwrap(ucfirst($fldFirstname), 17, "\n", true) .  ' ' . wordwrap(ucfirst($fldLastname), 17, "\n", true);    
                                                                //COLLEGETRIAL - hide last name                                                         
                                                                If ($_SESSION['fldSubscribe'] == 2) {
                                                                    $AthFullname = wordwrap(ucfirst($fldFirstname), 17, "\n", true);
                                                                }                                                              
                                                
                                                                $fldEmail = $func -> output_fun($db -> f('fldEmail'));
                                                                $fldSport = $func -> output_fun($db -> f('fldSport'));
                                                                $fldImage = $func -> output_fun($db -> f('fldImage'));
                                                                echo '<tr>';                                                 
                                                                echo '<td align="center" class="normalblack_12" style="text-align:center;"><img src="athimages/' . $fldImage . '" style="width:50px;"></td>';
                                                                
                                                                //Detect if College / Trial Mode
                                                                echo '<td align="center" class="normalblack_12" >' . $AthFullname . '</td>';
                                                                
                                                                echo '<td align="center" class="normalblack_12" >' . wordwrap(ucfirst($fldSportsname), 17, "\n", true) . '</td>';
                                                                echo '<td class="normalblack_12" align="center"><a href="ViewAthleteprofile.php?mode=view&fldId=' . $fldId . '"><img src="admin/images/view.gif" border="0" title="View"></a></td>';
                                                                echo '</tr>';
                                                                $db -> next_record();
                                                                $count++;
                                                            }
                                                            #show pagination
                                                            echo '<tr><td align="right" class="normalblack_12" colspan="5">';
                                                            $page -> set_qry_string("fldId=" . $_REQUEST['fldId']);
                                                            $page -> get_page_nav();
                                                            echo '</td></tr>';
                                                            echo '</table>';
                                                            $counttest = $counttest + 1;
                                                        }
                                                    }
                                                    if ($counttest <= 0) {
                                                        echo '<tr><td align="center" class="normalblack_12" colspan="5" height="30">
                                                    No Records Available.</td></tr>';
                                                    }
                                                    echo '</span>';
												?>
										<?php 
                                        }
                                        else {
                                            echo "Sorry, this feature is disabled in Trial Mode";
                                        }
                                        ?>
									</div>
								</div><!--//end leftpanel-->
								
								<div class="right-panel" style="width:150px;">
									<h3>Advertisement</h3>           
									<div class="right-boxesfirst" style="height:220px;padding-top:6px;">
										<?php
$query_banner = " Select * from " . TBL_BANNER . " where fldStatus=1 and fldPosition='bottom-left'";
$db2->query($query_banner);
for ($banner_count = 0; $banner_count < $db2->num_rows(); $banner_count++) {
										?>
										<?php   echo $func -> output_fun($db2 -> f('fldThirdParty'));?>
										<?php
                                            $db2 -> next_record();
                                            }
										?>
									</div>
								</div>
								<!--clear-rows-->
								<div class="clear"></div>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
		<?php
            include ('footer.php');
		?>
	</body>
</html>