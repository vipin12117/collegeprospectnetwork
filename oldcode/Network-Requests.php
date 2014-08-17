<?php

    ##******************************************************************

    ##  Project		:		Sport Social Networking - Admin Panel

    ##  Done by		:		Narendra Singh

    ##	Page name	:		Collnetrequest.php

    ##	Create Date	:		23/07/2011

    ##  Description :		This file is used to college receive network request from athlete.

    ##	Copyright   :       Synapse Communications Private Limited.

    ## *****************************************************************

    include_once ("inc/common_functions.php");

    include_once ("inc/page.inc.php");



    session_start();

    $func = new COMMONFUNC;

    $db = new DB;

    $db3 = new DB;

    $flag = 0;

    

    //Global Vars
    $UserID = "";
    $UserType = $_SESSION['mode'];
    $fldUserName = $_SESSION['FRONTEND_USER'];
     switch ($UserType) {

        case 'athlete':

            //AthleteID

            $UserID = $_SESSION['Athlete_id'];

            break;

        case 'coach':

            //HS Coach ID

            $UserID = $_SESSION['Coach_id']; 

            break;

        case 'college':

            //College Coach ID

            $UserID = $_SESSION['College_Coach_id'];   

            break;

    }   



   

    if ($_REQUEST['mode'] == "del") {

        

        //Detect if requested rowID is user's

        $isMine = $func->IsMyRequest($_REQUEST['Id'], $UserID);

        $_REQUEST['msg'] = "Delete RowID: " . $_REQUEST['Id'] . " | IsMyRow: " . $isMine;

                          

        if ($isMine == 1) {

            $delete_query_details = "delete from " . TBL_NETWORK . " where fldId='" . $_REQUEST['Id'] . "'";

            $delmsg = $db -> query($delete_query_details);

            if (isset($delmsg)) {

                $_REQUEST['msg'] = "Network Request successfully deleted.";

            }            

        } //end isMine test            

    }

    

    if ($_REQUEST['mode'] == "active") {

        $Id = $_REQUEST['Id'];

        $active_query_details = "update " . TBL_NETWORK . " set fldStatus = 'Active' where fldId='" . $Id . "'";
		$activemsg = $db -> query($active_query_details);
		if (isset($activemsg)) {

            $_REQUEST['msg'] = "Network Request Aapproved. User has been sent a nofication.";

        }

        //Send Email

    }

    if ($_REQUEST['mode'] == "deactive") {

        $Id = $_REQUEST['Id'];

        $active_query_details = "update " . TBL_NETWORK . " set fldStatus = 'Pending' where fldId='" . $Id . "'";

        $activemsg = $db -> query($active_query_details);

        if (isset($activemsg)) {

            $_REQUEST['msg'] = "Network Link successfully de-activated";

        }

        //Send Email

    }



$requests = array();

$SendRequests = array();

$query = 'SELECT * FROM ' . TBL_NETWORK . ' WHERE fldStatus=\'Pending\' AND fldReceiverid=' . $UserID;

$db->query($query);

while ($db->next_record()) {

    $request = array();

    $request['id'] = $db->f('fldId');

    $request['memberId'] = $db->f('fldSenderid');

    $request['memberType'] = $db->f('fldSenderType');

    $request['status'] = $db->f('fldStatus');

    

    $requests[] = $request;

}



$query = 'SELECT * FROM ' . TBL_NETWORK . ' WHERE fldStatus=\'Pending\'  AND  fldSenderid=' . $UserID ;

$db->query($query);

while ($db->next_record()) {

    $request = array();

    $request['id'] = $db->f('fldId');

    $request['memberId'] = $db->f('fldReceiverid');

    $request['memberType'] = $db->f('fldReceiverType');

    $request['status'] = $db->f('fldStatus');

    

    $SendRequests[] = $request;

}



$numRequests = count($requests);

$numSendRequests = count($SendRequests);



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

		<script language="JavaScript" type="text/JavaScript">

		

		function deleteRequest(Id) {

                if(confirm("Are you sure you want to delete this Network Request? This cannot be undone")) {

                    /*var request = document.createElement('form');

                    request.method = "post";

                    request.action = "?mode=del&Id=" + Id;

                    request.submit();*/

					document.myform.action ="?mode=del&Id=" + Id;

					document.myform.submit();

                }

            }

            

            function activeRequest(Id) {

			

                if(confirm("Are you sure you want to approve this user's Network Request?")) {

                    /*var request = document.createElement('form');

                    request.method = "post";

                    request.action = "?mode=active&Id=" + Id;

                    request.submit();*/

					

					

					document.myform.action ="?mode=active&Id=" + Id;

					document.myform.submit();

                }

            }

			function rate_this_athlete(fldID,fldAthleteID,isAdded)

			{

				try

				{

					if(isAdded == 1)

					{

						fldID+="&mode=view";

					}

					window.open("RatingAthleteApproval.php?fldAthleteID="+fldAthleteID+"&mode=active&fldId="+fldID,"windowname1", "width=560, height=560"); 

					//return false;

				}catch(ex){alert(ex.message);}

			}

		</script>

	</head>

	<body>

<?php include ('header.php'); ?>

<div class="container">

<div class="innerWraper">

<div class="middle-bg">

<div class="cantener">

<div class="register-main">

	<div class="registerPage">

		<h1>Network Requests</h1>

	<form name="myform" id="myform" method="post">

		 <?php if ($numRequests > 0): ?>

		  <div style="display: block; margin-bottom: 5px; text-align: right;"><?php echo count($requests); ?> Total Records</div>

		<table cellpadding=2 cellspacing=1 width="100%" align="center">

			<thead>

				<tr>

					<th colspan="4" class="normalblack_12" style="text-align:center; background-color:#79B1D2; color:#FFFFFF;">Requests Pending My Approval</th>

				</tr>

				<tr style="background-color:#C9DFED;">

					<th width="38%" class="normalblack_12">User</th>

					<th width="19%" class="normalblack_12">Type</th>

					<th width="19%" class="normalblack_12">Status</th>

					<th width="24%" class="normalblack_12">Action</th>

				</tr>

			</thead>

			<tbody>

				<?php foreach ($requests as $request): ?>

				<tr>

					<td class="normalblack_12">

						<?php echo $func->GetUserProfileURLbyID($request['memberId'], $request['memberType']);?>

					</td>

					<td class="normalblack_12"><?php echo ucfirst(strtolower($request['memberType'])); ?></td>

					<td class="normalblack_12"><?php echo ucfirst(strtolower($request['status'])); ?></td>

					<td class="normalblack_12">

				<?php if (strtolower($request['status']) === 'pending'): 

						if(isset($_SESSION['Coach_id']) && $_SESSION['Coach_id']!="" && $_SESSION['Coach_id']!=0){ 
	 $whereClause1 = "fldAthlete_id=" . $request['id'];    
	 $db12 = new DB;
     if ($db12 -> MatchingRec(TBL_RATING, $whereClause1) > 0) {
            ?>
							<a href="javascript:rate_this_athlete('<?php echo $request['id']; ?>',<?php echo $request['memberId']; ?>,'0')">Approve</a>
							<?php }else{?>				
								<a href="javascript:activeRequest('<?php echo $request['id']; ?>')">Approve</a>
								<?php } }else{ ?>

				<a href="javascript:activeRequest('<?php echo $request['id']; ?>')">Approve</a>

				<?php 

						}echo "&nbsp;/&nbsp;";

				 endif; ?>

				<a href="javascript:deleteRequest(<?php echo $request['id']; ?>)">Delete</a>

					</td>

				</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

		 <?php else: ?>

		  <div class="thankyoumessage">

			You have no pending network Requests.

		</div>

		  <?php endif; ?>

		<br />

		<?php if ($numSendRequests > 0): ?>

		 <div style="display: block; margin-bottom: 5px; text-align: right;"><?php echo count($SendRequests); ?> Total Records</div>

		<table cellpadding=2 cellspacing=1 width="100%" align="center">

			<thead>

			<tr>

					<th colspan="4" class="normalblack_12" style="text-align:center; background-color:#79B1D2; color:#FFFFFF;">My Sent Requests</th>

			 </tr>

			

				<tr style="background-color:#C9DFED;">

					<th width="38%" class="normalblack_12">User</th>

					<th width="19%" class="normalblack_12">Type</th>

					<th width="19%" class="normalblack_12">Status</th>

					<th width="24%" class="normalblack_12">Action</th>

				</tr>

			</thead>

			<tbody>

				<?php foreach ($SendRequests as $request):  ?>

				<tr>

					<td class="normalblack_12">

						<?php echo $func->GetUserProfileURLbyID($request['memberId'], $request['memberType']);?>

					</td>

					<td class="normalblack_12"><?php echo ucfirst(strtolower($request['memberType'])); ?></td>

					<td class="normalblack_12"><?php echo ucfirst(strtolower($request['status'])); ?></td>

					<td class="normalblack_12">

						<a href="javascript:deleteRequest(<?php echo $request['id']; ?>)">Delete</a>

					</td>

				</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

		<?php else: ?>

		  <div class="thankyoumessage">

			You have not send any Requests.

		</div>

		  <?php endif; ?>

		</form>

	   

	   

	   <br />

		<p>

			<label>&nbsp;</label>

			<span>

				<input type="button" value="Back" onclick="javascript:window.open('myaccount.php', '_self');">

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

