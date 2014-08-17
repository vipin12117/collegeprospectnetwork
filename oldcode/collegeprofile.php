<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    
    session_start();

    if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {
        header("Location:login.php");
    }

    //for paging
    $func = new COMMONFUNC;
    $page = new Page();
    $db = new DB;
    $db2 = new DB;
    $flag = 0;
    
    //Local Variables
    $IsMyProfile = 0;   
    if ($_REQUEST['mode'] == "del") {
        $delete_query_details = "delete from " . TBL_COLLEGE_NEEDS . " where fldId='" . $_REQUEST['fldId'] . "'";
        $delmsg = $db -> query($delete_query_details);
        if (isset($delmsg)) {
            $_REQUEST['msg'] = "Need Type successfully deleted.";
            $count = $func -> totalRows(TBL_NEEDTYPE);
            $offset = $_REQUEST['page'] * 10;
            if ($count <= $offset) {
                $offset = $offset - $count;
                $_REQUEST['page'] = $offset / 10;
            }
        }
    }
    //Detect if this Athlete is Athlete viewing profile                           
    if (($_REQUEST['collegeid'] !='') and ($_SESSION['College_Coach_id']!='') and ($_REQUEST['collegeid'] == $_SESSION['College_Coach_id'])) {
        $IsMyProfile = 1;                                
    }   
    
    #######################################
    ## SEND NETWORK REQUEST
    //Insert, Display Notification, and Email Recipient  
       
   $GLOBALPage = "collegeprofile.php?collegeid=";    
   $GLOBALProfileType = "college";          
   include("inc/NetworkRequest.php");   
   #######################################
   

    #echo $_REQUEST['collegeid'] . "<br />";
    #echo $_SESSION['FRONTEND_USER'] . "<br />";
    if ($_REQUEST['collegeid']) {
	   $query = " Select * from " . TBL_COLLEGE_COACH_REGISTER . " where fldCollegename ='" . $_REQUEST['collegeid'] . "' ";
    } else {
       $query = " Select * from " . TBL_COLLEGE_COACH_REGISTER . " where fldUserName ='" . $_SESSION['FRONTEND_USER'] . "' ";
    }
	if (!$db->query($query)) {
        die(mysql_error());
    }
	$db -> next_record();
    $College_id = $db -> f('fldId');
    $College_UserName = $db -> f('fldUserName');
    $College_FirstName = $db -> f('fldFirstName');
    $College_LastName = $db -> f('fldLastName');
    $Collegename_id = $db -> f('fldCollegename');
    $Collegephone = $db -> f('fldPhone');
    $college_Requare_Position = $db -> f('fldPosition');
    $college_requare_type = $db -> f('fldNeedType');
    #echo "ID: " . $college_Requare_Position . "<br />";
    $query_sport = " Select * from " . TBL_COLLEGE . " where fldId='" . $Collegename_id . "' ";
    if (!$db2->query($query_sport)) {
        die(mysql_error());
    }
    $db2 -> next_record();
    $Collegename = $db2 -> f('fldName');    
    $college_fldAddress = $db2 -> f('fldAddress');
    $college_fldCity = $db2 -> f('fldCity');
    $college_fldState = $db2 -> f('fldState');
    $college_fldZipCode = $db2 -> f('fldZipCode');
    $college_fldDivison = $db2 -> f('fldDivison');

$requests = array();
$query = 'SELECT * FROM ' . TBL_NETWORK . ' WHERE fldReceiverid=' . $College_id;
if (!$db->query($query)) {
    die(mysql_error());
}
while ($db->next_record()) {
    $request = array();
    $request['id'] = $db->f('fldId');
    $request['memberId'] = $db->f('fldSenderid');
    $request['memberType'] = $db->f('fldSenderType');
    $request['status'] = $db->f('fldStatus');
    
    $requests[] = $request;
}

$query = 'SELECT * FROM ' . TBL_NETWORK . ' WHERE fldSenderid=' . $College_id . ' AND fldStatus=\'Active\'';
$db->query($query);
while ($db->next_record()) {
    $request = array();
    $request['id'] = $db->f('fldId');
    $request['memberId'] = $db->f('fldReceiverid');
    $request['memberType'] = $db->f('fldReceiverType');
    $request['status'] = $db->f('fldStatus');
    
    $requests[] = $request;
}
$numRequests = count($requests);

// gets list of posted needs
$query = 'SELECT ' . TBL_COLLEGE_NEEDS . '.*, ' . TBL_SPORTS . '.fldSportsname FROM ' . TBL_COLLEGE_NEEDS . ' INNER JOIN ' . TBL_SPORTS . ' ON ' . TBL_COLLEGE_NEEDS . '.fldSportId=' . TBL_SPORTS . '.fldId ' .'WHERE fldCollegeId=' . $Collegename_id; //$Collegename_id
//echo "hi".__LINE__."";die();
if (!$db->query($query)) {
    die(mysql_error());
}

$fldCollegeNeeds = array();

while ($db->next_record()) {
    $summary = $db->f('fldSportsname');
    
    if (($db->f('fldPosition')) != '') {
        $summary .= ' + ' . $db->f('fldPosition');
    } else {
        $summary .= ' + any position';
    }
    
    if (($db->f('fldGradClass')) != '') {
        $summary .= ' + class of ' . $db->f('fldGradClass');
    } else {
        $summary .= ' + any graduating class';
    }
    
    if (($db->f('fldMinHeight')) != '') {
        $summary .= ' + at least ';
        $summary .= intval($db->f('fldMinHeight')/12) . '-';
        $summary .= intval($db->f('fldMinHeight')%12) . ' tall';
    }
    
    if (($db->f('fldMaxHeight')) != '') {
        $summary .= ' + no more than ';
        $summary .= intval($db->f('fldMaxHeight')/12) . '-';
        $summary .= intval($db->f('fldMaxHeight')%12) . ' tall';
    }
    
    if ($db->f('fldMinHeight') == '' && $db->f('fldMaxHeight') == '') {
        $summary .= ' + any height';
    }
    
    $summary .= '...';
    
    $fldCollegeNeeds[$db->f('fldId')] = $summary;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - College Coach Profile</title>
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

            function deleteRecord(fldId, page) {
                if(confirm("Sure you want to delete this Need Type?")) {
                    document.frmUsers_need.action = "?mode=del&fldId=" + fldId + "&page=" + page;
                    document.frmUsers_need.submit();
                }
            }
		</script>
	</head>
	<body>
		<?php include ('header.php'); ?>
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
									
									<h1 style="float:left;">College Coach Profile</h1>									
									<?php
                                    if (($_REQUEST['collegeid'] != "") and ($IsMyProfile == 0)) {
                                        ############ Network Request  ###########                           
									?>
									<div class="btnclass1" style="float:right;margin-right:20px;">
										<p>
											<span>
												<INPUT TYPE="BUTTON" VALUE="Add To Network" onclick="networkRequest(<?php  echo $_REQUEST['collegeid'];?>); ">
											</span><div class="clear"></div>
										</p>
									</div>
									<div class="btnclass1" style="float:right;margin-right:20px;">
                                        <p>
                                            <span>
                                                <INPUT TYPE="BUTTON" VALUE="Send Message" onclick="window.open('sendmsgtoath.php?id=<?  echo $College_id;?>&usertype=college','windowname1', 'width=665, height=350'); return false;">
                                            </span><div class="clear"></div>
                                        </p>
                                    </div>
									<?php      }?>									
									<div class="clear"></div>
									
									
									<!--START-ROW1-->
									<div style="width: 890px;background#000;">
										<!--START-LEFTCOL-->
										<div style="width: 286px;float:left;background#ccc;">
											<h3>General Information</h3>
											<div class="boxes">
												<p>
                                                    <font class="title">Username:</font> <?php  echo $College_UserName;?>
                                                </p>
                                                <p>
													<font class="title">Name:</font> <?php  echo $College_FirstName . " " . $College_LastName?>
												</p>
												<p>
													<font class="title">Phone:</font> <?php  echo $Collegephone;?>
												</p>
												<p>
													<font class="title">Position:</font> <?php  echo $college_Requare_Position;?>
												</p>
												<?php       $query_sport = " Select * from " . TBL_SPORTS . " where fldId =" . $college_requare_type;
                                                    $db1 -> query($query_sport);
                                                    $db1 -> next_record();
                                                    $type = $db1 -> f('fldSportsname');
												?>
												<p>
													<font class="title">Sport:</font> <?php      echo $type;?>
												</p>
											</div><!--//end-box-->
											<h3>Network</h3>
											<div class="boxes">
												<p>
												<span class="title">Total Users in Network: </span>
												<?php echo count($requests); ?>
												</p>
											</div><!--//end-box-->
										</div>
										<!--//END-LEFTCOL-->
										<!--START-RIGHTCOL-->
										<div style="width: 555px;float:right;background#ff8000;">
											<h3>College Information</h3>
											<div class="boxes">
												<p>
													<font class="title">Name: </font><?php      echo $Collegename;?>
												</p>
												<p>
													<font class="title">Address: </font><?php
                                                        if ($college_fldAddress) { echo $college_fldAddress;
                                                        } else {echo "Not Yet Entered";
                                                        }
													?>
												</p>
												<p>
													<font class="title">City: </font><?php
                                                        if ($college_fldCity) {echo $college_fldCity;
                                                        } else {echo "Not Yet Entered";
                                                        }
													?>
												</p>
												<p>
													<font class="title">State: </font><?php
                                                        if ($college_fldState) {echo $college_fldState;
                                                        } else {echo "Not Yet Entered";
                                                        }
													?>
												</p>
												<p>
													<font class="title">Zip Code: </font><?php
                                                        if ($college_fldZipCode) {echo $college_fldZipCode;
                                                        } else {echo "Not Yet Entered";
                                                        }
													?>
												</p>
												<p>
													<font class="title">Divison: </font>
													<?php
                                                        if ($college_fldDivison) {
                                                            echo $college_fldDivison = str_replace("_", " ", $college_fldDivison);
                                                        } else {
                                                            echo "Not Yet Entered";
                                                        }
													?>
												</p>
											</div><!--//end-boxes-->
											</form>
											
											<h3 style="float:left;">College Coach Needs</h3>
											<form name="frmUsers_need" action="" method="post" onsubmit="">
											<div style="float:right;">
											    <?php if ($_SESSION['mode'] ==  'college'): ?>
											        <a href=
											           "javascript:Showcomments('collegeNeed.php?action=add','collegeNeed','width=1024,height=650')">
											            Add Need
											         </a>
											    <?php endif; ?>
											</div>
											<div class="clear"></div>
											<div class="boxes">
											    <?php if (count($fldCollegeNeeds) == 0): ?>
											        You have not posted any needs. Click "Add Need" to post a need.
											     <?php else: ?>
											        <?php $i = 1; ?>
											        <?php foreach ($fldCollegeNeeds as $id => $summary): ?>
											            <p>
											                <b>
											                    Need #<?php echo $i++; ?> - 
											                    <a href=
											                       "javascript:Showcomments('collegeNeed.php?action=edit&id=<?php echo $id; ?>','collegeNeed','width=1024,height=650')">
											                        Edit
											                     </a> /
											                     <a href="javascript:deleteRecord(<?php echo $id; ?>);">
											                        Delete
											                     </a>
											                 </b>
											                 <br />
											                 <?php echo $summary; ?>
											             </p>
											        <?php endforeach; ?>
											     <?php endif; ?>												
											</div><!--//END-box-->
									
											
										</div>
										<!--//END-RIGHTCOL-->
										<div class="clear"></div>
										<!--//CLEAR-LEFTandRIGHTcols-->
										<!--//END-ROW1-->
									</div>
									<!--START-ROW2-->
									<div style="width: 880px;display:block;">
										<h3>Your Network</h3>
										<div class="boxes" style="width:880px;padding: 8 10px;">
										    
										    <?php if (count($requests) > 0): ?>
											<table cellspacing="2" cellpadding="5" bordercolor="#e7e7e7" border="0" 
											       width="100%" class="tablePadd whitetable" style="border-collapse: collapse;">
											    <thead>
											        <tr>
											            <th class="normalblack_12">
											                User
											            </th>
											            <th class="normalblack_12">
											                Type
											            </th>
											            <th class="normalblack_12">
											                Status
											            </th>
											        </tr>
											    </thead>
											    <tbody>
											    
										        <?php foreach ($requests as $request): ?>
										            <tr>
										                <td class="normalblack_12">
										                    <?php echo $func->GetUserProfileURLbyID($request['memberId'], $request['memberType']); ?>
										                </td>
										                <td class="normalblack_12">
										                    <?php echo $request['memberType']; ?>
										                </td>
										                <td class="normalblack_12">
										                    <?php echo $request['status']; ?>
										                </td>
										            </tr>
										        <?php endforeach; ?>
										        
										        </tbody>
											</table>
											<?php endif; ?>
											
										</div><!--//END-box-->
									</div><!--//END-ROW2-->
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php include ('footer.php'); ?>
	</body>
</html>
