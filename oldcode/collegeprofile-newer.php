<?php    include_once ("inc/common_functions.php");    //for common function    include_once ("inc/page.inc.php");    session_start();    if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {        header("Location:index.php");    }    //for paging    $func = new COMMONFUNC;    $page = new Page();    $db = new DB;    $flag = 0;    if ($_REQUEST['mode'] == "del") {        $delete_query_details = "delete from " . TBL_NEEDTYPE . " where fldId='" . $_REQUEST['fldId'] . "'";        $delmsg = $db -> query($delete_query_details);        if (isset($delmsg)) {            $_REQUEST['msg'] = "Need Type Deleted Successfully!";            $count = $func -> totalRows(TBL_NEEDTYPE);            $offset = $_REQUEST['page'] * 10;            if ($count <= $offset) {                $offset = $offset - $count;                $_REQUEST['page'] = $offset / 10;            }        }    }    if ($_REQUEST['mode'] == "request") {        $collegeid = $_REQUEST['fldId'];        $ath_name = $func -> selectTableOrder(TBL_ATHELETE_REGISTER, "fldFirstname,fldLastname", "fldId", "where fldId='" . $_SESSION['Athlete_id'] . "' and fldStatus ='ACTIVE'");        $name = ucfirst($ath_name[0]['fldFirstname']) . ' ' . ucfirst($ath_name[0]['fldLastname']);        $strDataArr = array(                'collegeid' => $collegeid,                'athleteid' => $_SESSION['Athlete_id'],                'athname' => $name,                'status' => "DEACTIVE"        );        $whereClause = "athleteid='" . $_SESSION['Athlete_id'] . "' and collegeid = '" . $collegeid . "'";        if ($db -> MatchingRec(TBL_ADDTONETWORK_REQUEST, $whereClause) > 0) {            $msg = 'You Have Already Send the Request!';            header("Location: collegeprofile.php?collegeid=$collegeid&msg=$msg");        }        else {            $db -> insertRec(TBL_ADDTONETWORK_REQUEST, $strDataArr);            $msg = "Your Add to Network Request has been sent! Wait for Approval";            header("Location: collegeprofile.php?collegeid=$collegeid&msg=$msg");        }    }    if ($_REQUEST['collegeid']) {        $query = " Select * from " . TBL_COLLEGE_COACH_REGISTER . " where fldId ='" . $_REQUEST['collegeid'] . "'";    }    else {        $query = " Select * from " . TBL_COLLEGE_COACH_REGISTER . " where fldUserName ='" . $_SESSION['FRONTEND_USER'] . "'";    }    $db -> query($query);    $db -> next_record();    $College_id = $db -> f('fldId');    $Collegename_id = $db -> f('fldCollegename');    $Collegephone = $db -> f('fldPhone');    $college_Requare_Position = $db -> f('fldPosition');    $college_requare_type = $db -> f('fldNeedType');    $query_sport = " Select * from " . TBL_COLLEGE . " where fldId =" . $Collegename_id;    $db2 -> query($query_sport);    $db2 -> next_record();    $Collegename = $db2 -> f('fldName');    $college_fldAddress = $db2 -> f('fldAddress');    $college_fldCity = $db2 -> f('fldCity');    $college_fldState = $db2 -> f('fldState');    $college_fldZipCode = $db2 -> f('fldZipCode');    $college_fldDivison = $db2 -> f('fldDivison');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">	<head>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>My Account</title>		<META NAME="Keywords" CONTENT="My Account">		<META NAME="Description" CONTENT="My Account">		<link href="css/style.css" rel="stylesheet" type="text/css" />		<script language="Javascript" src="javascript/functions.js"></script>		<script language="JavaScript" type="text/JavaScript">            function networkRequest(fldId) {                if(confirm("Are you sure to send the Network Request?")) {                    document.frmUsers.action = "?mode=request&fldId=" + fldId;                    document.frmUsers.submit();                }            }            function deleteRecord(fldId, page) {                if(confirm("Are you sure to delete this Need Type?")) {                    document.frmUsers_need.action = "?mode=del&fldId=" + fldId + "&page=" + page;                    document.frmUsers_need.submit();                }            }		</script>	</head>	<body>		<?php            include ('header.php');		?>		<!--middle panel starts from here -->		<!--content panel starts from here -->		<div class="container">			<div class="innerWraper">				<div class="middle-bg">					<div class="cantener">						<div class="register-main">							<div class="registerPage">								<form name="frmUsers" action="" method="post" onsubmit="">									<h1 style="margin-bottom:5px;"">College Coach Profile</h1>									<?php									if ($_REQUEST['msg']) {									?>									<div class="thankyoumessage"><?php  echo $_REQUEST['msg'];?></div>									<?php                                        }                                        if ($_SESSION['mode'] != 'college') {									?>									<p><span style="float:right;"><INPUT TYPE="BUTTON" VALUE="Add Network" onclick="networkRequest(<?php  echo $_REQUEST['collegeid'];?>); "></span></p>									<?php  }?>									<p></p>									<p></p>									<div style="background: none repeat scroll 0 0 #FFFFFF;									border: 0px solid #DBDBDB;									min-height: 124px;									margin: 0;									width: 890px;">									<div style="background: none repeat scroll 0 0 #FFFFFF;									border: 1px solid #DBDBDB;									min-height: 134px;									margin-bottom:10px;									width: 286px;float:left;">									<span class="gernal">General Information</span>									<p></p>									<p><font class="title">Name:</font> <?php  echo $Collegename;?></p>									<p><font class="title">Phone:</font> <?php  echo $Collegephone;?></p>									<p><font class="title">Position:</font> <?php  echo $college_Requare_Position;?></p>									<?php                                        $query_sport = " Select * from " . TBL_SPORTS . " where fldId =" . $college_requare_type;                                        $db1 -> query($query_sport);                                        $db1 -> next_record();                                        $type = $db1 -> f('fldSportsname');									?>									<p><font class="title">Sport:</font> <?php  echo $type;?></p>									</div>									<div style="background: none repeat scroll 0 0 #FFFFFF;									border: 1px solid #DBDBDB;									min-height: 134px;									margin: 0;									width: 567px;float:right">									<span class="gernal">College Information</span>									<p></p>									<p><font class="title">Name: </font><?php  echo $Collegename;?></p>									<p><font class="title">Address:</font> <?php    if ($college_fldAddress) {        echo $college_fldAddress;    }    else {        echo "Not Yet Entered";    } ?></p>									<p><font class="title">City: </font><?php    if ($college_fldCity) {        echo $college_fldCity;    }    else {        echo "Not Yet Entered";    } ?></p>									<p><font class="title">State: </font><?php    if ($college_fldState) {        echo $college_fldState;    }    else {        echo "Not Yet Entered";    } ?></p>									<p><font class="title">Zip Code: </font><?php    if ($college_fldZipCode) {        echo $college_fldZipCode;    }    else {        echo "Not Yet Entered";    } ?></p>									<p><font class="title">Divison: </font>									<?php                                        if ($college_fldDivison) {                                            echo $college_fldDivison = str_replace("_", " ", $college_fldDivison);                                        }                                        else {                                            echo "Not Yet Entered";                                        }									?></p>									</div>									</div>									<div style="background: none repeat scroll 0 0 #FFFFFF;									border: 0px solid #DBDBDB;									min-height: 130px;									width: 890px;">									<div style="background: none repeat scroll 0 0 #FFFFFF;									border: 1px solid #DBDBDB;									min-height: 167px;									width: 286px;float:left;">									<span class="gernal">Network</span>									<p></p>									<span>									<table cellspacing="2" cellpadding="5"  border="0" width="100%" class="tablePadd">									<?php                                        if ($_REQUEST['collegeid'] == '') {                                            $selquery2 = "select count(*) as count from " . TBL_NETWORK . " where fldSenderid= " . $_SESSION['College_Coach_id'] . " and fldType = 'college' and fldStatus='ACTIVE'";                                        }                                        else {                                            $selquery2 = "select count(*) as count from " . TBL_NETWORK . " where fldSenderid= " . $_REQUEST['collegeid'] . " and fldType = 'college' and fldStatus='ACTIVE'";                                        }                                        $db2 -> query($selquery2);                                        $db2 -> next_record();									?>									<p><font class="title">Total Users in Network: </font>(1)<!--<?php echo $func->output_fun($db2->f('count')); ?>--></p>									<?php                                        if ($_REQUEST['collegeid'] == '') {                                            $selquery = "select * from " . TBL_NETWORK . " where fldSenderid= " . $_SESSION['College_Coach_id'] . " and  fldType = 'college' and fldStatus='ACTIVE' order by fldId DESC limit 0,4";                                        }                                        else {                                            $selquery = "select * from " . TBL_NETWORK . " where fldSenderid= " . $_REQUEST['collegeid'] . " and  fldType = 'college' and fldStatus='ACTIVE' order by fldId DESC limit 0,4";                                        }                                        $db -> query($selquery);                                        $db -> next_record();									?>									<?php                                        if ($db -> num_rows() > 0) {#check for record availability                                            echo '<tr>';                                            echo '<td align="left" class="normalblack_12" width="8%">&nbsp;<strong>S.No.</strong></td>';                                            echo '<td class="normalblack_12" width="25%" align="center"><strong>Athlete Name</strong></td>';                                            echo '</tr>';                                            $count = "1";                                            for ($i = 0; $i < $db -> num_rows(); $i++) {                                                $Atid = $func -> output_fun($db -> f('fldReceiverid'));                                                $query = "SELECT * from " . TBL_ATHELETE_REGISTER . "  WHERE fldId=" . $Atid;                                                $db1 -> query($query);                                                $db1 -> next_record();                                                $fname = $func -> output_fun($db1 -> f('fldFirstname'));                                                $lname = $func -> output_fun($db1 -> f('fldLastname'));                                                echo '<tr>';                                                echo '<td align="left" class="normalblack_12">&nbsp;' . ($count + ($_REQUEST['page'] * 10)) . '</td>';                                                echo '<td align="center" class="normalblack_12" >' . wordwrap($fname . '&nbsp;' . $lname, 50, "\n", true) . '</td>';                                                echo '</tr>';                                                $db -> next_record();                                                $count++;                                            }                                            #show pagination                                            echo '<tr><td align="right" class="normalblack_12x" colspan="5">';                                            echo '</td></tr>';                                        }                                        echo '</form></table></span>';									?>									</div>									<div style="background: none repeat scroll 0 0 #FFFFFF;									border: 1px solid #DBDBDB;									min-height: 120px;									margin-top:11px;									width: 567px;float:right">									<form name="frmUsers_need" action="" method="post" onsubmit="">									<span class="gernal">Coach's Needs</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br /><br />									<?php									if ($_REQUEST['page'] == '') {									$pageno = '0';									} else {									$pageno = $_REQUEST['page'];									}									if ($_SESSION['mode'] == 'college') {									?>									<a href="#" onclick="window.open('collegeneed.php','windowname1', 'width=665, height=650'); return false;">Add Needs</a>									<?php                                        }									?>									<table cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" width="100%" class="tablePadd" style="border-collapse: collapse;">									<?									if ($_REQUEST['collegeid'] == '') {									$selquery1 = "select * from " . TBL_NEEDTYPE . " where fldCollegeCoachId= " . $_SESSION['College_Coach_id'] . " order by fldId";									} else {									$selquery1 = "select * from " . TBL_NEEDTYPE . " where fldCollegeCoachId= " . $_REQUEST['collegeid'] . " order by fldId";									}									$db3->query($selquery1);									$db3->next_record();									if ($db3->num_rows() > 0) {#check for record availability									$count = "1";									for ($i = 0; $i < $db3->num_rows(); $i++) {									$fldId = $func->output_fun($db3->f('fldId'));									echo '<tr>';									echo '<td align="left" class="normalblack_12_need_type">&nbsp;<b>#   ' . ($count + ($_REQUEST['page'] * 10)) . '- </b>';									?>									<?php    if ($db3 -> f('fldPosition')) {        echo $db3 -> f('fldPosition') . ", ";    } ?>									<?php                                        if ($db3 -> f('fldMinHeight') and $db3 -> f('fldMaxHeight')) {                                            $maxheight = explode('-', $db3 -> f('fldMaxHeight'));                                            $minheight = explode('-', $db3 -> f('fldMinHeight'));                                            echo " Height Between " . $minheight[0] . "'" . $minheight[1] . '" and ' . $maxheight[0] . "'" . $maxheight[1] . '"' . ", ";                                        }                                        else                                        if (($db3 -> f('fldMinHeight')) and (!$db3 -> f('fldMaxHeight'))) {                                            $maxheight = explode('-', $db3 -> f('fldMaxHeight'));                                            $minheight = explode('-', $db3 -> f('fldMinHeight'));                                            echo " Height > " . $minheight[0] . "'" . $minheight[1] . '"' . ", ";                                        }                                        else                                        if ((!$db3 -> f('fldMinHeight')) and ($db3 -> f('fldMaxHeight'))) {                                            $maxheight = explode('-', $db3 -> f('fldMaxHeight'));                                            $minheight = explode('-', $db3 -> f('fldMinHeight'));                                            echo " Height < " . $maxheight[0] . "' " . $maxheight[1] . '"' . ", ";                                        }                                        if ($db3 -> f('fldMinWeight') and $db3 -> f('fldMaxWeight')) {                                            echo " Weight Between " . $db3 -> f('fldMinWeight') . " and " . $db3 -> f('fldMaxWeight') . ", ";                                        }                                        else                                        if (($db3 -> f('fldMinWeight')) and (!$db3 -> f('fldMaxWeight'))) {                                            echo " Weight > " . $db3 -> f('fldMinWeight') . ", ";                                        }                                        else                                        if ((!$db3 -> f('fldMinWeight')) and ($db3 -> f('fldMaxWeight'))) {                                            echo " Weight < " . $db3 -> f('fldMaxWeight') . ", ";                                        }									?>									<?php									//if ($db3->f('fldDistance')) {									//echo "within " . $db3->f('fldDistance') . " miles of " . $db3->f('fldZipCode') . "  " . $db3->f('fldCity') . " " . $db3->f('fldState') . " ";									//}									if ($_SESSION['mode'] == "college") {									?> <a href="#" onclick="window.open('collegeNeedEdit.php?&fldId= <?php  echo $fldId;?>','windowname1', 'width=665, height=650'); return false;">edit</a> <?php                                        echo '<a href="javascript:deleteRecord(\'' . $fldId . '\',' . $pageno . ')">Delete</a>';									?> <?php                                        }									?>									</td><?php                                        echo '</tr>';                                        $db3 -> next_record();                                        $count++;                                        }                                        } else { #no record message comes here                                        echo '<tr><td align="center" class="normalblack_12xx" colspan="1" height="30">                                        This user has not yet posted any needs.</td></tr>';                                        }                                        echo '</form></table></span>';									?>							</div>						</div>						<div style="background: none repeat scroll 0 0 #FFFFFF;						border: 1px solid #DBDBDB;						min-height: 174px;						margin: 0;						width: 890px;						margin-top: 85px;">							<span class="gernal">Athletes Matching Coach's Needs</span>							<span style=" margin: 5px;">								<table cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" width="100%" class="tablePadd" style="border-collapse: collapse;">									<?                                        if (!$searchname) {                                            $query_athlete = " Select * from " . TBL_ATHELETE_REGISTER . " where fldStatus= 'ACTIVE' and fldSport ='" . $college_requare_type . "' order by fldId ";                                        }                                        else {                                            $query = "Select * from " . TBL_ATHELETE_REGISTER . " where 1=1 " . $srchCond . " order by fldId ";                                        }                                        $db -> query($query_athlete);                                        $db -> next_record();                                        $totalPages = $db -> num_rows();                                        #Code for paging                                        $page -> set_page_data('', $db -> num_rows(), 10, 5, true, false, true);                                        $page -> set_qry_string($queryString);                                        $query_athlete = $page -> get_limit_query($query_athlete);                                        //return the query with limits                                        $db -> query($query_athlete);                                        $db -> next_record();                                        if ($db -> num_rows() > 0) {#check for record availability                                            echo '									<tr>										';                                            echo '<td align="left" class="normalblack_12" width="8%">&nbsp;<strong>S.No.</strong></td>';                                            echo '<td align="left" class="normalblack_12" width="21%">&nbsp;<strong>Athlete Name</strong></td>';                                            echo '<td align="left" class="normalblack_12" width="21%">&nbsp;<strong>Email</strong></td>';                                            echo '<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>Sport</strong></td>';                                            echo '<td class="normalblack_12" width="15%" align="center"><strong>View Profile</strong></td>';                                            echo '									</tr>									';                                            $count = "1";                                            for ($i = 0; $i < $db -> num_rows(); $i++) {                                                $fldId = $func -> output_fun($db -> f('fldId'));                                                $fldFirstname = $func -> output_fun($db -> f('fldFirstname'));                                                $fldEmail = $func -> output_fun($db -> f('fldEmail'));                                                $fldSport = $func -> output_fun($db -> f('fldSport'));                                                $query = "SELECT fldSportsname  from " . TBL_SPORTS . "  WHERE fldId='$fldSport'";                                                $db1 -> query($query);                                                $db1 -> next_record();                                                $fldSportsname = $func -> output_fun($db1 -> f('fldSportsname'));                                                echo '									<tr>										';                                                echo '<td align="left" class="normalblack_12">&nbsp;' . ($count + ($_REQUEST['page'] * 10)) . '</td>';                                                echo '<td align="left" class="normalblack_12" >' . wordwrap($fldFirstname, 17, "\n", true) . '</td>';                                                echo '<td align="left" class="normalblack_12" >' . wordwrap($fldEmail, 17, "\n", true) . '</td>';                                                echo '<td align="left" class="normalblack_12" >' . wordwrap($fldSportsname, 17, "\n", true) . '</td>';                                                echo '<td class="normalblack_12" align="center"><a href="ViewAthleteprofile.php?mode=view&fldId=' . $fldId . '"> <img src="admin/images/view.gif" border="0" title="View"></a></td>';                                                echo '									</tr>									';                                                $db -> next_record();                                                $count++;                                            }                                            #show pagination                                            echo '									<tr>										<td align="right" class="normalblack_12" colspan="5">';                                            $page -> set_qry_string("collegeid=" . $_REQUEST['collegeid']);                                            $page -> get_page_nav();                                            echo '&nbsp;</td>									</tr>									';                                        }                                        else {#no record message comes here                                            echo '									<tr>										<td align="center" class="normalblack_12" colspan="5" height="30"><font color="red">No Records Available.</font></td>									</tr>									';                                        }                                        echo '</form>								</table></span>';							?>						</div>					</div>				</div>			</div>		</div>		</div>		</div>		</div></div>		<?php            include ('footer.php');		?>	</body></html>