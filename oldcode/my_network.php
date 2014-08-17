<?php
   
    include_once ("inc/common_functions.php");
    include_once ("inc/page.inc.php");

    session_start();
    $func = new COMMONFUNC;
    $db = new DB;
    $db3 = new DB;
	$page = new Page();
    //Create an instance of class Pate
    $lnb = "2";
    $error_msg = '';
    $flag = 0;
    $network_for = isset($_REQUEST["network_for"])?$_REQUEST["network_for"]:"";
    $ModeType = isset($_REQUEST["mode"])?$_REQUEST["mode"]:"";
	$mode_1 = isset($_REQUEST["mode_1"])?$_REQUEST["mode_1"]:"";
	$Id = isset($_REQUEST["Id"])?$_REQUEST["Id"]:0;
	$fldUserName = isset($_SESSION['FRONTEND_USER'])?$_SESSION['FRONTEND_USER']:"";
    //Global Vars
    $UserID = "";
   $PageTitle ="";
  $displayMessage = "";
  $fld_Sport = "";
     switch ($ModeType) {
        case 'athlete':
            //AthleteID
            $UserID =  isset($_SESSION['Athlete_id'])?$_SESSION['Athlete_id']:"";
			$fld_Sport = $func -> GetValue("tbl_athelete_register","fldSport","fldId",$UserID);
            break;
        case 'coach':
            //HS Coach ID
            $UserID =isset($_SESSION['Coach_id'])?$_SESSION['Coach_id']:"";
			$fld_Sport = $func -> GetValue("tbl_hs_aau_coach","fldSport","fldId",$UserID);
            break;
        case 'college':
            //College Coach ID
            $UserID = isset($_SESSION['College_Coach_id'])?$_SESSION['College_Coach_id']:"";
			$sport_info = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId,fldNeedType", "fldId", "where fldUserName='" . $fldUserName . "'");
			$fld_Sport = $sport_info[0]['fldNeedType'];
            break;
    }   
	switch ($network_for) {
        case 'athlete':
            $PageTitle = "My Athletes";
			$displayMessage = "You have not added any members to your network yet. <a href='athleteSearch_all.php?network_for=".$network_for."&mode=".$ModeType."'>Click here</a> to get started.";
            break;
        case 'coach':
            $PageTitle = "My HS/AAU Coach";
			$displayMessage = "You have not added any members to your network yet. <a href='ViewAllHsAau.php?network_for=".$network_for."&mode=".$ModeType."'>Click here</a> to get started.";
            break;
        case 'college':
            $PageTitle = "My College Coach";
			$displayMessage = "You have not added any members to your network yet. <a href='ViewCollegeCoach.php?network_for=".$network_for."&mode=".$ModeType."'>Click here</a> to get started.";
            break;
    }  
   
    if ($mode_1 == "del") {
        
        //Detect if requested rowID is user's
        $isMine = $func->IsMyRequest($Id, $UserID);
        $_REQUEST['msg'] = "Delete RowID: " . $Id . " | IsMyRow: " . $isMine;
                          
        if ($isMine == 1) {
            $delete_query_details = "delete from " . TBL_NETWORK . " where fldId='" . $Id . "'";
            $delmsg = $db -> query($delete_query_details);
            if (isset($delmsg)) {
                $_REQUEST['msg'] = "Network Request successfully deleted.";
            }            
        } //end isMine test            
    }
    
    if ($mode_1 == "active") {
       
        $active_query_details = "update " . TBL_NETWORK . " set fldStatus = 'Active' where fldId='" . $Id . "'";
        $activemsg = $db -> query($active_query_details);
        if (isset($activemsg)) {
            $_REQUEST['msg'] = "Network Request Aapproved. User has been sent a nofication.";
        }
        //Send Email
    }
    if ($mode_1 == "deactive") {

        $active_query_details = "update " . TBL_NETWORK . " set fldStatus = 'Pending' where fldId='" . $Id . "'";
        $activemsg = $db -> query($active_query_details);
        if (isset($activemsg)) {
            $_REQUEST['msg'] = "Network Link successfully de-activated";
        }
        //Send Email
    }

$requests = array();
$limit = 10; 
$query = 'SELECT * FROM ' . TBL_NETWORK . ' WHERE ((fldReceiverid='. $UserID.' AND fldSenderType=\''.$network_for.'\') OR (fldSenderid=' . $UserID.' AND fldReceiverType=\''.$network_for.'\')) AND fldStatus = \'Active\'';

$queryString = "network_for=".$network_for."&mode=".$ModeType;
$db->query($query);
	// $db -> next_record();
$totalPages = $db -> num_rows();
#Code for paging
if($network_for != "coach" && ($ModeType == "athlete" || $ModeType == "coach" || $ModeType == "college"))
{
	$page -> set_page_data('', $totalPages, 10, 5, true, false, true);
	$page -> set_qry_string($queryString);
	$query = $page -> get_limit_query($query);
	//return the query with limits
	$db -> query($query);
}
//$db -> next_record();
//require("inc/class.pager.php"); 
while ($db->next_record()) {
    $request = array();
    $request['id'] = $db->f('fldId');
	$User_ID = $db->f('fldSenderid');
	if($db->f('fldSenderid') != $UserID)
	{
		$userMode = $db->f('fldSenderType');
		$fldSport = "";
		switch ($userMode) 
		{
			case 'athlete':
				//AthleteID
				$fldSport = $func -> GetValue("tbl_athelete_register","fldSport","fldId",$User_ID);	
				
				break;
			case 'coach':
				//HS Coach ID
				$fldSport = $func -> GetValue("tbl_hs_aau_coach","fldSport","fldId",$User_ID);
				
				break;
			case 'college':
				//College Coach ID
				$collegeuser_id = $func -> GetValue("tbl_college_coach_register","fldUserName","fldId",$User_ID);
				$sport_info = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId,fldNeedType", "fldId", "where fldUserName='" . $collegeuser_id . "'");
	 
				$fldSport = $sport_info[0]['fldNeedType'];
				break;
		}  
    	$request['memberId'] = $User_ID;
    	$request['memberType'] = $userMode;
		$request['memberSport'] = $fldSport;
    }
	else
	{
		$userMode = $db->f('fldReceiverType');
		$fldSport = "";
		$User_ID = $db->f('fldReceiverid');
		switch ($userMode) 
		{
			case 'athlete':
				//AthleteID
				$fldSport = $func -> GetValue("tbl_athelete_register","fldSport","fldId",$User_ID);	
				
				break;
			case 'coach':
				//HS Coach ID
				$fldSport = $func -> GetValue("tbl_hs_aau_coach","fldSport","fldId",$User_ID);
				
				break;
			case 'college':
				//College Coach ID
				$collegeuser_id = $func ->GetValue("tbl_college_coach_register","fldUserName","fldId",$User_ID);
				$sport_info = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId,fldNeedType", "fldId", "where fldUserName='" . $collegeuser_id . "'");
	 
				$fldSport = $sport_info[0]['fldNeedType'];
				break;
		}  
	 	$request['memberId'] = $User_ID;
   	 	$request['memberType'] = $userMode;
		$request['memberSport'] = $fldSport;
	}
	$request['status'] = $db->f('fldStatus');
  //  $db -> next_record();
    $requests[] = $request;
}


/******/

 

/******/
$numRequests = count($requests);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network - Users In My Network</title>
		<META NAME="Keywords" CONTENT="My Account">
		<META NAME="Description" CONTENT="My Account">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		 <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
		<script language="JavaScript" type="text/JavaScript">
		
		function deleteRequest(Id,qstr) {
                if(confirm("Are you sure you want to delete this Network Request? This cannot be undone")) {
                    /*var request = document.createElement('form');
                    request.method = "post";
                    request.action = "?mode=del&Id=" + Id;
                    request.submit();*/
					
					document.myform.action ="?mode_1=del&Id=" + Id+"&"+qstr;
					document.myform.submit();
                }
            }
            
            function activeRequest(Id,qstr) {
			
                if(confirm("Are you sure you want to approve this user's Network Request?")) {
                    /*var request = document.createElement('form');
                    request.method = "post";
                    request.action = "?mode=active&Id=" + Id;
                    request.submit();*/
					
					
					document.myform.action ="?mode_1=active&Id=" + Id+"&"+qstr;
					document.myform.submit();
                }
            }
		</script>
		<style type="text/css">
		.box_list ul,li{ list-style:none;float:left;}
		</style>
	</head>
	<body>
		<?php include ('header.php'); ?>
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
							<div class="registerPage">
							    <h1><?php echo $PageTitle;?></h1>
								<?php //echo $displayMessage;?>
							    <?php if ($numRequests > 0): ?>
							    <div style="display: block; margin-bottom: 5px; text-align: right;"><?php echo count($requests); ?> Total Records</div>
								<form name="myform" id="myform" method="post">
								<?php if($network_for == "athlete" && ($ModeType == "athlete" || $ModeType == "coach" || $ModeType == "college")):?>
									<ul class="box_list">
										 <?php foreach ($requests as $request): ?>
										 <li>
										 	 <?php $ProfileFields = $func->get_User_ProfileDetail($request['memberId'], $request['memberType']);  ?>
										 	<table cellpadding="2" cellspacing="2" class="table_main">
												<tr>
													<td class="table_main_td1">
														<table cellpadding="2" cellspacing="2" class="table_main_first">
															<tr>
																<td>
																<center>
																<div class="viewhim_" id="viewhim_<?php echo $request['id']; ?>">
																<a href="<?php echo $ProfileFields["ProfileURl"]; ?>" title="<?php echo $ProfileFields["ProfileName"]; ?>">
																	<img src="<?php echo $ProfileFields["ProfileImageURl"]; ?>" title="<?php  echo $ProfileFields["ProfileName"]; ?>" style="margin:5px 5px 1px 5px;" width="88px" height="119px"/>
																</a>
																<div class="view_" id="view_<?php echo $request['id']; ?>">
																  <?php
												    if($_SESSION['fldSubscribe'] == 2) {         
														echo '<a href="javascript:void(0);" onclick="alert(\'Sorry, this feature is disabled in Trial Mode, please purchase a Subscription. \');">Send Message</a>';
                                                    } else {                                      
												    ?>
													<a href="javascript:void(0);" onclick="window.open('sendmsgtoath.php?id=<?php echo $request['memberId'];?>&usertype=athlete','windowname1', 'width=665, height=350'); return false;">Send Message</a>
													
													<?php
													 }
                                                    ?>
															</div><div><img src="images/Coins.png" width="20px" height="20px" style="margin:0px 5px 0px 5px;float:left;"/><div class="totpoint" style="color:#0066CC;"><?php echo $ProfileFields["fldTotal_points"]; ?></div></div>
																</div>
																</center>
																</td>
																
															</tr>
														</table>
													</td>
													<td class="table_main_td2">
														<div class="showbutton_" id="showbutton_<?php echo $request["id"]; ?>">
														<table cellpadding="2" border="0" cellspacing="2" class="table_second">											<tr>
																<td>
																	<div class="td_div">
																	<label class="lbl_name">Athlete Name:</label>
																	<label class="lbl_value">
																	<a href="<?php echo $ProfileFields["ProfileURl"]; ?>" title="<?php echo $ProfileFields["ProfileName"]; ?>"><?php echo $ProfileFields["ProfileName"]; ?></a>
													 </label>
													 </div>
																</td>
															</tr>
															<tr>
																<td>
																	<div class="td_div">
																	<label class="lbl_name">Athlete Team:</label>
																	<label class="lbl_value"><?php echo $ProfileFields["ProfileTeam"]; ?></label>
														</div>
													
																</td>
															</tr>
															<tr>
																<td>
																	<div class="td_div">
																	<label class="lbl_name">Sport:</label>
																	<label class="lbl_value"><?php echo $ProfileFields["ProfileSport"]; ?></label>
																	</div>
													 
																</td>
															</tr>
															<tr>
																<td>
																	<div class="td_div">
																	<label class="lbl_name">Athlete Height:</label>
																	<label class="lbl_value"><?php echo $ProfileFields["ProfileHeight"]; ?></label>
																	</div>
													
																</td>
															</tr>
															<tr>
																<td>
																	<div class="td_div">
																	<label class="lbl_name">Primary Position:</label>
																	<label class="lbl_value"><?php echo $ProfileFields["ProfilePrimaryPos"]; ?></label>
																	</div>
													
																</td>
															</tr>
															<tr>
																<td>
																	<div class="td_div">
																	<label class="lbl_name">Secondary Position:</label>
																	<label class="lbl_value"><?php echo $ProfileFields["ProfileSecondaryPos"]; ?></label>
																	<div id="showbox_<?php echo $request['id']; ?>" class="showbox_">
													<a href="javascript:void(0);" onclick="deleteRequest(<?php echo $request['id']; ?>,'<?php echo $queryString;?>')">Remove</a>
															</div>
																	</div>
													
																</td>
															</tr>
														</table>
														</div>
													</td>
												</tr>
											</table>	
											 <script language="javascript" type="text/javascript">
											try
											{
												/******* For Send Message Function ********/
												$('#viewhim_<?php echo $request['id']; ?>').hover(function() {
													$(this).find("img").animate(
													{opacity:"0.5"},
													{duration:300}
												  );
													$("#view_<?php echo $request['id']; ?>").fadeIn(100);
												}, function() {
													 $(this).find("img").animate(
														{opacity:"1"},
														{duration:300}
													  );
													$("#view_<?php echo $request['id']; ?>").fadeOut(100);
												});
												/******* For Send Message Function ********/
												
												/******* For Send Request Function ********/
												$('#showbutton_<?php echo $request['id']; ?>').hover(function() {
													$("#showbox_<?php echo $request['id']; ?>").fadeIn(100);
												}, function() {
													$("#showbox_<?php echo $request['id']; ?>").fadeOut(100);
												});
												/******* For Send Request Function ********/
											}
											catch(ex)
											{
												alert(ex.message);
											}
										</script>	
										 </li>
										 <?php endforeach; ?>
									</ul>
								<?php //else: ?>
								<?php elseif($network_for == "coach" && ($ModeType == "athlete" || $ModeType == "coach" || $ModeType == "college")):?>
							<table cellpadding=2 cellspacing=1 width="100%" align="center">
							        <thead>
									<tr>
							                <th colspan="4" class="normalblack_12" style="text-align:center; background-color:#79B1D2; color:#FFFFFF;">My High School and AAU Coaches</th>
							         </tr>
							            <tr style="background-color:#C9DFED;">
							                 <th width="55%" class="normalblack_12">Profile Name</th>
							                <th width="15%" class="normalblack_12">Type</th>
							                <th width="15%" class="normalblack_12">Status</th>
							                <th width="15%" class="normalblack_12">Action</th>
							            </tr>
							        </thead>
							        <tbody>
							            <?php $jk = 0; foreach ($requests as $request): ?>
										    <?php $ProfileFields = $func->get_User_ProfileDetail($request['memberId'], $request['memberType']); 
											
											if($request['memberSport'] == $fld_Sport):
											?>
							            <tr>
							                <td class="normalblack_12">
							            
												 <a href="<?php echo $ProfileFields["ProfileURl"]; ?>" title="<?php echo $ProfileFields["ProfileName"]; ?>" style="text-decoration:none; color:#003366;">
												 	<?php echo $ProfileFields["ProfileName"]." ".$request['memberSport']; ?>
												 </a>
					                        </td>
							                <td class="normalblack_12"><?php echo ucfirst(strtolower($request['memberType'])); ?></td>
							                <td class="normalblack_12"><?php echo ucfirst(strtolower($request['status'])); ?></td>
							                <td class="normalblack_12">
							                    <?php if (strtolower($request['status']) === 'pending'): ?>
							                    <a href="javascript:activeRequest(<?php echo $request['id']; ?>,'<?php echo $queryString;?>')">Approve</a> / 
							                    <?php endif; ?>
							                    <a href="javascript:deleteRequest(<?php echo $request['id']; ?>,'<?php echo $queryString;?>')">Delete</a>
							                </td>
							            </tr>
								<?php 
									  endif; 
								 endforeach; ?>
							        </tbody>
							    </table>
								<br /><br />
								<table cellpadding=2 cellspacing=1 width="100%" align="center">
									
							        <thead>
									<tr>
							                <th colspan="4" class="normalblack_12" style="text-align:center; background-color:#79B1D2; color:#FFFFFF;">Other Coaches in My Network</th>
							         </tr>
							            <tr style="background-color:#C9DFED;">
							                <th width="55%" class="normalblack_12">Profile Name </th>
							                <th width="15%" class="normalblack_12">Type</th>
							                <th width="15%" class="normalblack_12">Status</th>
							                <th width="15%" class="normalblack_12">Action</th>
							            </tr>
							        </thead>
									<tbody>
							   <?php $ik = 0; foreach ($requests as $request): ?>
							   
										<?php $ProfileFields = $func->get_User_ProfileDetail($request['memberId'], $request['memberType']); 
											if($request['memberSport'] != $fld_Sport):
										
											?>
							            <tr>
							                <td class="normalblack_12">
							                
												 <a href="<?php echo $ProfileFields["ProfileURl"]; ?>" title="<?php echo $ProfileFields["ProfileName"]; ?>" style="text-decoration:none; color:#003366;">
												 	<?php echo $ProfileFields["ProfileName"]; ?>
												 </a>
					                        </td>
							                <td class="normalblack_12"><?php echo ucfirst(strtolower($request['memberType'])); ?></td>
							                <td class="normalblack_12"><?php echo ucfirst(strtolower($request['status'])); ?></td>
							                <td class="normalblack_12">
							                    <?php if (strtolower($request['status']) === 'pending'): ?>
							                    <a href="javascript:activeRequest(<?php echo $request['id']; ?>,'<?php echo $queryString;?>')">Approve</a> / 
							                    <?php endif; ?>
							                    <a href="javascript:deleteRequest(<?php echo $request['id']; ?>,'<?php echo $queryString;?>')">Delete</a>
							                </td>
							            </tr>
										  <?php 
										  	
									  endif; 
								 endforeach; ?>
							        </tbody>
							    </table>
								
								<?php else: ?>
								
								<table cellpadding=2 cellspacing=1 width="100%" align="center">
							        <thead>
									<tr>
							                <th colspan="4" class="normalblack_12" style="text-align:center; background-color:#79B1D2; color:#FFFFFF;">Other Coaches in My Network</th>
							            <tr >
							                <th width="49%" class="normalblack_12">Profile Name</th>
							                <th width="17%" class="normalblack_12">Type</th>
							                <th width="15%" class="normalblack_12">Status</th>
							                <th width="19%" class="normalblack_12">Action</th>
							            </tr>
							        </thead>
							        <tbody>
							            <?php foreach ($requests as $request): ?>
							            <tr>
							                <td class="normalblack_12">
							                <?php $ProfileFields = $func->get_User_ProfileDetail($request['memberId'], $request['memberType']); ?>
												 <a href="<?php echo $ProfileFields["ProfileURl"]; ?>" title="<?php echo $ProfileFields["ProfileName"]; ?>" style="text-decoration:none; color:#003366;">
												 	<?php echo $ProfileFields["ProfileName"]; ?>
												 </a>
					                        </td>
							                <td class="normalblack_12"><?php echo ucfirst(strtolower($request['memberType'])); ?></td>
							                <td class="normalblack_12"><?php echo ucfirst(strtolower($request['status'])); ?></td>
							                <td class="normalblack_12">
							                    <?php if (strtolower($request['status']) === 'pending'): ?>
							                    <a href="javascript:activeRequest(<?php echo $request['id']; ?>,'<?php echo $queryString;?>')">Approve</a> / 
							                    <?php endif; ?>
							                    <a href="javascript:deleteRequest(<?php echo $request['id']; ?>,'<?php echo $queryString;?>')">Delete</a>
							                </td>
							            </tr>
							            <?php endforeach; ?>
							        </tbody>
							    </table>
								 <?php endif; ?>
								</form>
							    <?php else: ?>
							    <div class="thankyoumessage">
                                    <?php echo $displayMessage;?>
                                </div>
							    <?php endif; ?>
								
								<div style="clear:both;"></div>
								<?php if($network_for != "coach" && ($ModeType == "athlete" || $ModeType == "coach" || $ModeType == "college")):?>
								<?php echo $page -> get_page_nav();?>
								<?php endif; ?>
                                <p>
                                    <label>&nbsp;</label>
                                    <br />
                                    <span>
                                        <input type="button" value="Back" onclick="window.open('myaccount.php', '_self');">
										<?php if($network_for == "athlete"): ?>
										<input type="button" value="Search Athlete" style="width:130px;" onclick="window.open('athleteSearch_all.php?<?php echo $queryString;?>','_self');">
										<?php endif; ?>
                                    </span>
                                </p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include ('footer.php'); ?>
	</body>
</html>
