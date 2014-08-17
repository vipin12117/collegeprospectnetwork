<?php
    ##******************************************************************
    ##  Project		:		Sport Social Networking - Admin Panel
    ##  Done by		:		Narendra Singh
    ##	Page name	:		CoachAthapprove.php
    ##	Create Date	:		2/08/2011
    ##  Description :		This file is used to approve/reject athlete request.
    ##	Copyright   :       Synapse Communications Private Limited.
    ## *****************************************************************
    session_start();
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    if ($_SESSION['FRONTEND_USER'] == "") {
        header("Location:login.php");
    }
    $func = new COMMONFUNC;
    $page = new Page();
    $db = new DB;
    $db1 = new DB;
    $db2 = new DB;
    $flag = 0;
    $email = $_SESSION['EMAIL'];
    
    if ($_REQUEST['mode'] == "active") {
       $Id = $_REQUEST['fldId'];
		
        $active_query_details = "update " . TBL_ATHELETE_REGISTER . " set fldStatus = 'ACTIVE',fldApproveCoachId=" . $_SESSION['Coach_id'] . " where fldId='" . $Id . "'";
        $activemsg = $db -> query($active_query_details);
		
		$strDataArr = array('fldSenderid' => $Id, 'fldSenderType' =>'athlete' , 'fldReceiverid' => $_SESSION['Coach_id'], 'fldReceiverType' => 'coach', 'fldStatus' => "Active");        

        

        //Build WhereClause

        $whereClause = "(fldSenderid='" . $Id . "' AND fldSenderType='athlete' AND fldReceiverid='" . $ReceiverID . "' AND fldReceiverType='coach') ";

        $whereClause .= " OR (fldSenderid='" . $_SESSION['Coach_id'] . "' AND fldSenderType='athlete' AND fldReceiverid='" . $Id . "' AND fldReceiverType='coach') ";

        

        //Check if Network Request already exists

        if ($db -> MatchingRec(TBL_NETWORK, $whereClause) > 0) {

            //Request Already Exists

            $msg = 'There is already an Active or Pending Network Request with this user.';

            header("Location: " . $GLOBALPage . "$ReceiverID&errormsg=$msg");

        } else {

            ##INSERT
	        $db -> insertRec(TBL_NETWORK, $strDataArr);
		    ##SENT EMAIL to USER                  
		    $subjectStrek = "College Prospect Network - New Network Request";            
		    #Login Info & Directions              

             $EmailUsername = "";

             $EmailPassword = "";

             $EmailTo = "";

             $EmailUserID =$_SESSION['Coach_id'] ; //Set Email User ID

             $EmailUserType = 'coach'; 
			}
		
		//auto add athlete func start
		$sel="select `tbl_athelete_register`.* from `tbl_athelete_register` where `tbl_athelete_register`.`fldId`='".$Id."'";
				$db2 -> query($sel);
                $db2 -> next_record();
                $approve_coach_id = $func -> output_fun($db2 -> f('fldApproveCoachId'));
				$sport_id = $func -> output_fun($db2 -> f('fldSport'));
				$school_id = $func -> output_fun($db2 -> f('fldSchool'));
				
//			function athlete_autoconnect($SenderID,$sport_id,$school_id,$approve_coach_id)
	//		{
				if($approve_coach_id!='')
				{
				$sel_network="select `tbl_network`.* from `tbl_network` where (`tbl_network`.`fldSenderid` = '".$approve_coach_id."' or `tbl_network`.`fldReceiverid` = '".$approve_coach_id."') AND (`tbl_network`.`fldReceiverType` = 'coach' OR `tbl_network`.`fldReceiverType` = 'athlete') AND (`tbl_network`.`fldSenderType`='athlete' OR `tbl_network`.`fldSenderType`='coach') AND `tbl_network`.`fldStatus`='Active' AND (`tbl_network`.`fldSenderid`!='".$Id."' OR `tbl_network`.`fldReceiverid`!='".$Id."')";
				$db2 -> query($sel_network);
				//echo "<br/>";
				while ($db2 -> next_record())
				{
				$fldStatus = $func -> output_fun($db2 -> f('fldStatus'));
				$ath_Senderid=$func -> output_fun($db2 -> f('fldSenderid'));
				$ath_Receiverid=$func -> output_fun($db2 -> f('fldReceiverid'));
				$ath_SenderType=$func -> output_fun($db2 -> f('fldSenderType'));
				$ath_ReceiverType=$func -> output_fun($db2 -> f('fldReceiverType'));
				}

				$sel_athlete="Select `tbl_athelete_register`.* from `tbl_athelete_register` where `tbl_athelete_register`.`fldSport` like '%".$sport_id."%' and `tbl_athelete_register`.`fldSchool` like '%".$school_id."%' and (`tbl_athelete_register`.`fldApproveCoachId` in ('".$ath_Senderid."') or `tbl_athelete_register`.`fldApproveCoachId` in ('".$ath_Receiverid."')) AND fldId!='".$Id."'";
				$athlet=$db -> query($sel_athlete);
				$cnt_ath=$db ->num_rows();
				if($db ->num_rows()>0)
				{
				  $ath_id=array();
				  while($db -> next_record())
				  {
					$fld_id=$func -> output_fun($db -> f('fldId'));
					$fldApproveCoachId=$func -> output_fun($db -> f('fldApproveCoachId'));
				    $ath_ids[]=$fld_id;
				  }	
					foreach($ath_ids as $ath_id){
							
					 $whereClause = "(fldSenderid='".$ath_id."' AND fldSenderType='athlete' AND fldReceiverid='".$Id."' AND fldReceiverType='athlete')";
			$whereClause .= " OR (fldSenderid='" .$Id."' AND fldSenderType='athlete' AND fldReceiverid='" . $ath_id . "' AND fldReceiverType='athlete') ";	
						//print_r($whereClause);
					  if ($db -> MatchingRec(TBL_NETWORK, $whereClause) > 0) 
						{
							header("Location: ".$GLOBALPage);
						}
						else
						{
					
			$strDataArr = array('fldSenderid' => $ath_id, 'fldSenderType' => 'athlete', 'fldReceiverid' =>$Id,'fldReceiverType' => 'athlete', 'fldStatus' => "Active","fldSendingDate" => date('Y:m:d:h:j:s'));   			
					
					$db -> insertRec(TBL_NETWORK, $strDataArr);		
					//print_r($strDataArr);
						}
					}

				 }
			}
			else
			{
				@header("Location: ".$GLOBALPage);
			}
		//   }
		//auto add athlete func end
		
	
        if (isset($activemsg)) {
            // Send email to athelete for notification
            $athEmail = $_REQUEST['fldEmail'];
            $fullname = $_REQUEST['fullname'];
            $subjectStrek = "College Prospect Network - Your Account has been Approved";
            $bodyStrek = "Congratulations &nbsp;" . $fullname . ",<br /><br />";
            $bodyStrek .= "You're application to College Prospect Network has been approved. <br /><br />You can now edit your profile, upload your stats, 
			post some game tape and start finding college programs. Go to <a href='www.CollegeProspectNetwork.com'>www.CollegeProspectNetwork.com </a> 
			and get started today. <br /><br />";
            
            #Login Info & Directions
            $Loginquery = " Select * from " . TBL_ATHELETE_REGISTER . " where fldId='" . $Id . "'";
            $db2 -> query($Loginquery);
            $db2 -> next_record();
            $AthleteUsername = $func -> output_fun($db2 -> f('fldUsername'));
            $AthletePassword = $func -> output_fun($db2 -> f('fldPassword'));
                            
            $bodyStrek .= "-------------------------------------------------------- <br />";
            $bodyStrek .= "Login: <a href=http://www.collegeprospectnetwork.com/login.php>http://www.collegeprospectnetwork.com/login.php</a><br />";
            $bodyStrek .= "Username: " . $AthleteUsername . "<br />";
            $bodyStrek .= "Password: " . $AthletePassword ."<br />";
            $bodyStrek .= "User Type: Athlete<br />";
            $bodyStrek .= "-------------------------------------------------------- <br />";
            $bodyStrek .= "<br />";                        
                        
            $bodyStrek .= "Please do not respond to this email. If you have any questions, use the Contact Us page on the website.<br /><br />";
            $bodyStrek .= "Thank you,<br />";
            $bodyStrek .= "College Prospect Network";
			
			$mail=SendHTMLMail1($athEmail, $subjectStrek, $bodyStrek, $email);
           // $func -> sendEmail($athEmail, $subjectStrek, $bodyStrek, $email);
            $msg = 1;
            @header("Location: CoachAthCeiling.php?msg=$msg&userID=$Id&mail=$athEmail");
        }
    }
    
    if ($_REQUEST['mode'] == "reject") {
        $Id = $_REQUEST['fldId'];
        $active_query_details = "update " . TBL_ATHELETE_REGISTER . " set fldStatus = 'REJECT' where fldId='" . $Id . "'";
        $activemsg = $db -> query($active_query_details);
        if (isset($activemsg)) {
            $athEmail = $_REQUEST['fldEmail'];
            $fullname = $_REQUEST['fullname'];
            $subjectStrek = "College Prospect Network - Approval Notification";
            $bodyStrek = "Hi" . ucfirst($fullname) . "<br /><br />";
            $bodyStrek .= "At this time we are unable to approve your application to join College Prospect Network. Unfortunately, 
			we cannot provide one-on-one feedback about why you were denied but we invite you to apply again next year if you are still of high school age.<br /><br />";
            $bodyStrek .= "Thank you for your application and good luck with your season,<br />";
            $bodyStrek .= "College Prospect Network";
			$mail=SendHTMLMail1($athEmail, $subjectStrek, $bodyStrek, $email);
            //$func -> sendEmail($athEmail, $subjectStrek, $bodyStrek, $email);
            $msg = 2;
            header("Location: CoachAthapprove.php?msg=$msg");
        }
    }
    
    if ($_REQUEST['mode'] == "deactive") {
        $Id = $_REQUEST['fldId'];
        $active_query_details = "update " . TBL_ATHELETE_REGISTER . " set fldStatus = 'DEACTIVE' where fldId='" . $Id . "'";
        $activemsg = $db -> query($active_query_details);
        if (isset($activemsg)) {
            $_REQUEST['msg'] = "Athlete have been set succesfully to De-Active.";
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>College Prospect Network - Athlete Approval</title>
<META NAME="Keywords" CONTENT="My Account">
<META NAME="Description" CONTENT="My Account">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">
		
function rate_this_athlete(fldAthleteID,isAdded)
{
try
{
if(isAdded == 1)
{
	fldID+="&mode=view";
}
window.open("RatingAthleteApprove.php?fldAthleteID="+fldAthleteID+"&mode=active","windowname1", "width=560, height=560"); 
//return false;
}catch(ex){alert(ex.message);}
}

function activeRequest(fldId, femail, fullname) {
	if(confirm("Are you sure you want to approve this Athlete?")) {
	
		document.frmUsers.action = "?mode=active&fldId=" + fldId + "&fldEmail=" + femail + "&fullname=" + fullname;
		document.frmUsers.submit();
	}
}

function dectiveRequest(fldId, femail, fullname) {
	if(confirm("Are you sure to de-active this Athlete?")) {
		document.frmUsers.action = "?mode=deactive&fldId=" + fldId + "&fldEmail=" + femail + "&fullname=" + fullname;
		document.frmUsers.submit();
	}
}

            function rejectRequest(fldId, femail, fullname) {
                if(confirm("Are you sure to reject this Athlete?")) {
                    document.frmUsers.action = "?mode=reject&fldId=" + fldId + "&fldEmail=" + femail + "&fullname=" + fullname;
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
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
							<h1>Athlete Approval</h1>
							<div class="registerPage">
								<form name="frmUsers" action="" method="post" onsubmit="">
									<?php
                                    if($_REQUEST['msg'] == 1)
                                    {
									?>
									<div class="thankyoumessage">
										<?php
                                            echo "Thank you. The athlete has been approved and a confirmation email has been sent to &nbsp;" . $_REQUEST['mail'];
										?>
									</div>
									<?php
                                        }
                                        else if($_REQUEST['msg'] == 2)
                                        {
									?>
									<div class="thankyoumessage">
										<?php  echo "You have rejected this Athlete and Notification Email send to" . $_REQUEST['mail'];?>
									</div>
									<?php
                                        }                                       
                                                                               
                                        $selquery2 = "select fldSchool from ".TBL_HS_AAU_COACH." where fldId='".$_SESSION['Coach_id']."'";
                                        $db2->query($selquery2);
                                        $db2->next_record();
                                        $fldSchool = $func->output_fun($db2->f('fldSchool'));
                                        $selquery1 = "select fldSportId from ".TBL_HS_AAU_COACH_SPORT_POSITION." where fldCoachNameId='".$_SESSION['Coach_id']."'";
                                        $db1->query($selquery1);
                                        $db1->next_record();
                                        if($db1->num_rows()>0)
                                        {
                                        for ($i=0;$i<$db1->num_rows();$i++)
                                        {
                                        $fldSport .= $func->output_fun($db1->f('fldSportId')).",";
                                        $db1->next_record();
                                        }
                                        }
                                        $fldSport =substr($fldSport,0,-1);
                                        $selquery = "select * from ".TBL_ATHELETE_REGISTER." where  fldSport in ($fldSport) and fldSchool=$fldSchool and fldStatus = 'DEACTIVE'";
                                        $db->query($selquery);
                                        $db->next_record();
                                        if($db->num_rows()>0)
                                        {
                                        $count="1";
                                        echo "<table cellpadding=2 cellspacing=1 width=100% align='center'>";
                                        # <td align="center" class="normalblack_12" width="30%">&nbsp;<strong>Write Comments / Select Division</strong></td>
                                        echo '<tr>
                                        <td align="center" class="normalblack_12" width="60%">&nbsp;<strong>Athlete Name</strong></td>
                                        <td align="center" class="normalblack_12" width="15%"><strong>Approve</strong></td>
                                        <td align="center" class="normalblack_12" width="15%"><strong>Reject</strong></td>
                                        <td align="center" class="normalblack_12" width="10%"><strong>View Profile</strong></td>';
                                        echo '</tr>';
                                        for ($i=0;$i<$db->num_rows();$i++)
                                        {
                                        $fname = $func->output_fun($db->f('fldFirstname'));
                                        $flname = $func->output_fun($db->f('fldLastname'));
                                        $femail = $func->output_fun($db->f('fldEmail'));
                                        $fldId = $func->output_fun($db->f('fldId'));
                                        $status = $func->output_fun($db->f('fldStatus'));
                                        $fullname= ucwords($fname).'&nbsp;'.ucwords($flname);
                                        $pageURL   = "Athcomments.php?fldId=$fldId";
                                        $detailsWindowTitle = "coach comments";
                                        $height="290";
                                        $width="750";
                                        echo '<tr>';
                                        #echo '<td align="left" class="normalblack_12">&nbsp;'.($count).'</td>';
                                        echo '<td align="left" class="normalblack_12" >'.ucwords($fname).'&nbsp;'.ucwords($flname).'</td>';
                                        #echo '<td  class="normalblack_12" align="center">	<a href="javascript:Showcomments(\''.$pageURL.'\',\''.$detailsWindowTitle.'\',\''.$width.'\',\''.$height.'\')">Write Comments / Select Division</a></td>';?>
           <td align="center" class="normalblack_12" >
		<?php $whereClause1 = "fldAthlete_id=" . $fldId;    
			$db12 = new DB;
     		if ($db12 -> MatchingRec(TBL_RATING, $whereClause1) <=0) {
            ?>
			<a href="javascript:rate_this_athlete('<?php echo $fldId; ?>','0')" ><img src="images/star_gold_256.png" border="0" title="Rating" height="25" width="25" style="padding-right:5px;"></a>
			<?php }
			if ($db12 -> MatchingRec(TBL_RATING, $whereClause1) <=0) {
			 ?>
			 				
			<a href="#" onclick="alert('Please Rate First !');" ><img src="images/right.gif" border="0" title="Approve"></a>
			<?php }
			else{ ?>
			<a href="javascript:activeRequest('<?php echo $fldId; ?>','<?php echo $femail;?>','<?php echo $fullname;?>')" ><img src="images/right.gif" border="0" title="Approve"></a>
			<?php }?>
            <?php /*?><a href="javascript:activeRequest(<?php echo $fldId; ?>,<?php echo $femail;?>,<?php echo $fullname?>)"><img src="images/right.gif" border="0" title="Approve"></a><?php */?>
			</td>
										<?php 
                                        echo '<td align="center" class="normalblack_12" ><a href="javascript:rejectRequest(\''.$fldId.'\',\''.$femail.'\',\''.$fullname.'\')">
                                        <img src="images/cross.jpg" border="0" title="Reject"></a></td>';
                                        echo '<td class="normalblack_12" align="center"><a href="ViewAthleteprofile.php?mode=view&fldId='.$fldId.'">
                                        <img src="admin/images/view.gif" border="0" title="View"></a></td>';
                                        echo '</tr>';
                                        $db->next_record();
                                        $count++;
                                        }
                                        }
                                        else
                                        {
                                        if($_REQUEST['msg']!='1' && $_REQUEST['msg']!='2')
                                        {
									?>
									<div class="thankyoumessage">
										<?php echo "You currently have no athletes awaiting approval. Thank you for checking. <a href='/myaccount.php' style='text-decoration:underline;'>Return to My Account</a>"
										?>
									</div>
									<?php
                                        }
                                        }
                                        echo '<tr><td align="right" class="normalblack_12" colspan="11">';
                                        echo '</td></tr>';
                                        echo "</form></table>";
									?>
									
	<p>
                                        <label>&nbsp;</label>
                                        <span>
                                            <INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">
                                        </span>                                    </p>
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