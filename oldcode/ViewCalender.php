<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    
    session_start();
    if ($_SESSION['FRONTEND_USER'] == "") {
        header("Location:index.php");
    }
    //for paging
    $func = new COMMONFUNC;
    //Create an instance of class COMMONFUNC
    $page = new Page();
    //Create an instance of class Pate
    $lnb = "2";
    $error_msg = '';
    $srchCond = '';
    if ($_SESSION['mode'] == "athlete") {
        $athlete_info = $func -> selectTableOrder(TBL_ATHELETE_REGISTER, "fldId,fldUsername,fldSchool,fldSport", "fldId", " where fldUsername='" . $_SESSION['FRONTEND_USER'] . "'");
    }
    if (!$searchname) {
        $searchname = $_REQUEST['searchname'];
    }
    $searchname = addslashes($searchname);
    if (strlen($searchname) > 0) {   $queryString = "searchname=$searchname";
        $srchCond = "AND fldEventName like '%" . $searchname . "%'";
    }
    if ($_REQUEST['mode'] == "del") {
        $fldEventId = $_REQUEST['fldEventId'];
        $delete_query_details = "delete from " . TBL_EVENT . " where fldEventId=" . $fldEventId;
        $delmsg = $db -> query($delete_query_details);
        if (isset($delmsg)) {
            $_REQUEST['msg'] = "Event successfully deleted.";
            $count = $func -> totalRows(TBL_EVENT);
            $offset = $_REQUEST['page'] * 10;
            if ($count <= $offset) {
                $offset = $offset - $count;
                $_REQUEST['page'] = $offset / 10;
            }
        }
    }
    if ($_REQUEST['mode'] == "delAll") {
        for ($i = 0; $i < count($_POST['check_delete']); $i++) {
            $delete_query_details = "delete from " . TBL_EVENT . " where fldEventId=" . $_POST['check_delete'][$i];
            $delmsg = $db -> query($delete_query_details);
        }
        if (isset($delmsg)) {
            $_REQUEST['msg'] = "Event successfully deleted.";
            $count = $func -> totalRows(TBL_EVENT);
            $offset = $_REQUEST['page'] * 10;
            if ($count <= $offset) {
                $offset = $offset - $count;
                $_REQUEST['page'] = $offset / 10;
            }
        }
    }
    if ($_REQUEST['page'] == '') {$pageno = '0';
    } else {$pageno = $_REQUEST['page'];
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title></title>
		<META NAME="Keywords" CONTENT="">
		<META NAME="Description" CONTENT="">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script language="JavaScript" type="text/JavaScript">
            function deleteRecord(fldEventId, page, fldUserName) {
                if(confirm("Are you sure to delete the Event?")) {
                    document.frmCatagory.action = "?mode=del&fldEventId=" + fldEventId + "&page=" + page;
                    document.frmCatagory.submit();
                }
            }

            function searchTxt() {
                document.searchFrm.submit();
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
							<div class="registerPage">
								<h1>My Games & Events</h1>
								<?php if(($_SESSION['mode']=='athlete')or($_SESSION['mode']=='school')){
								?>
								<?
                                    if ($_REQUEST['msg'] != "") {echo '<font class="thankyoumessage">' . $_REQUEST['msg'] . '</font>';
                                    }
								?>
								<table cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" width="100%" class="tablePadd" style="border-collapse: collapse;">
									<tr>
										<td align="right"   colspan='1' height='30' valign='middle'>
										<form name="searchFrm" id="searchFrm" action="<? echo $PHP_SELF;?>"  method="POST" class="searchform">
											<input type="hidden" name="page" id="page" value="0">
											<input type="text" name="searchname" id="searchname">
											<input type="submit"  name="search" id="search"  value="Search">
										</form></td>
										<td colspan='5' style="text-align:right;"><a href="addevent.php" class="bluelarge">Add New Game / Event</a></td>
									</tr>					
									<form name="frmCatagory" action="" method="post" onsubmit="">
										<?
if(!$searchname)
{
$query =" Select * from ".TBL_EVENT." where  fldSport = '".$athlete_info[0]['fldSport']."' AND ( `fld_UserType` = 'admin'
OR `fld_UserType` = 'athlete' ) AND `fldEventStatus` =1 AND (`fldHomeTeam` = '".$athlete_info[0]['fldSchool']."' OR `fldAwayTeam` = '".$athlete_info[0]['fldSchool']."') ";
}
else
{
$query ="Select * from ".TBL_EVENT." where  fldSport = '".$athlete_info[0]['fldSport']."' AND ( `fld_UserType` = 'admin'
OR `fld_UserType` = 'athlete' ) AND `fldEventStatus` =1  AND (`fldHomeTeam` = '".$athlete_info[0]['fldSchool']."' OR `fldAwayTeam` = '".$athlete_info[0]['fldSchool']."') ".$srchCond;
}
$db->query($query);
$db->next_record();
$totalPages = $db->num_rows();
if($totalPages>0){
										?>
										<tr>
											<td align="left" style="padding-bottom: 5px;" colspan="4">
										</tr>
										<?php
                                            }
                                            #Code for paging
                                            $page->set_page_data('',$db->num_rows(),10,5,true,false,true);
                                            $page->set_qry_string($queryString);
                                            $query = $page->get_limit_query($query); //return the query with limits
                                            //echo $query;
                                            //echo $queryString;
                                            $db->query($query);
                                            $db->next_record();
                                            if ($db->num_rows()>0) {#check for record availability
                                            echo '<tr>
                                            <td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Event Name</strong></td>
                                            <td align="left" class="normalblack_12" width="12%">&nbsp;<strong>Event date</strong></td>';
                                            echo '<td class="normalblack_12" width="4%" align="center" style="text-align:center;"><strong>Edit</strong></td>';
                                            echo '<td class="normalblack_12" width="4%" align="center" style="text-align:center;"><strong>View</strong></td>';
                                            echo '<td class="normalblack_12" width="8%" align="center" style="text-align:center;"><strong>Upload Stats</strong></td>';
                                            echo '<td class="normalblack_12" width="5%" align="center" style="text-align:center;"><strong>Delete</strong></td>';
                                            echo '</tr>';
                                            $count="1";
                                            for ($i=0;$i<$db->num_rows();$i++) {
                                            if(($func->output_fun($db->f('fld_UserType')=='athlete')and($func->output_fun($db->f('fldUserName'))==$_SESSION['FRONTEND_USER']))
                                            or ($func->output_fun($db->f('fld_UserType'))=='admin')){
                                            $fldEventId               = $func->output_fun($db->f('fldEventId'));
                                            $fldEventName             = $func->output_fun($db->f('fldEventName'));
                                            $pageURL            = "ViewEventDetail.php?fldEventId=$fldEventId";
                                            $detailsWindowTitle = "ViewEventDetail";
                                            $past_db=strtotime( $func->output_fun($db->f('fldEventEndDate')));
                                            $past_courrent=time();
                                            echo '<tr>';
                                            echo '<td align="left" class="normalblack_12">'.$fldEventName.'</td>';
                                            echo '<td align="left" class="normalblack_12">'.$db->f('fldEventStartDate').'</td>';
                                            if(($func->output_fun($db->f('fld_UserType'))=='athlete')and($func->output_fun($db->f('fldUserName'))==$_SESSION['FRONTEND_USER']))
                                            {
                                            echo '<td class="normalblack_12" align="center" style="text-align:center;"><a href="editevent.php?mode=edit&fldEventId='.$db->f('fldEventId').'&page='.$pageno.'"><img src="images/b_edit.png" border="0" title="Edit"></a></td>';
                                            }
                                            else
                                            {
                                            echo '<td  class="normalblack_12" align="center" style="text-align:center;">Not Allowed</td>';
                                            }
                                            echo '<td  class="normalblack_12" align="center" style="text-align:center;"><a href="javascript:ShowDetails(\''.$pageURL.'\',\''.$detailsWindowTitle.'\')"><img src="admin/images/view.gif" border="0" title="View"></a></td>';
                                            
#                                            if (($func->output_fun($db->f('fld_UserType')) == 'athlete')
#                                                and ($past_courrent > $past_db)) {
                                            if ($past_courrent > $past_db) {
                                            ?>
                                            
                                            <td class="normalblack_12" align="center" style="text-align: center;">
                                                <a href="AtheleteStat.php?mode=add&fldEventId=<?php echo $db->f('fldEventId'); ?>&page=<?php echo $pageno; ?>">
                                                    Add Game Stats
                                                </a>
                                            </td>
                                            
                                            <?php
                                            } else {
                                            ?>
                                                <td class="normalblack_12" align="center" style="text-align: center;">Upcoming Game</td>
                                            <?php
                                            }
                                            
                                            if(($func->output_fun($db->f('fld_UserType'))=='athlete')and($func->output_fun($db->f('fldUserName'))==$_SESSION['FRONTEND_USER']))
                                            {
                                            echo ' <td  class="normalblack_12" align="center" style="text-align:center;"><a href="javascript:deleteRecord(\''.$fldEventId.'\','.$pageno.",'".$db->f('fldUserName')."'".')"><img src="images/b_drop.png" border="0" title="Delete"></a></td>';
                                            }
                                            else
                                            {
                                            echo ' <td  class="normalblack_12" align="center" style="text-align:center;">Not Allowed</td>';
                                            }
                                            }
                                            echo '</tr>';
                                            $db->next_record();
                                            $count++;
                                            }
                                            #show pagination
                                            echo '<tr><td align="right" class="normalblack_12" colspan="7">';
                                            $page->get_page_nav();
                                            echo '</td></tr>';
                                            } else { #no record message comes here
                                            echo '<tr><td align="center" class="normalblack_12" colspan="10" height="50" style="padding:20px;">
                                            <span class="large">No Records Available, please <a href="addevent.php" class="bluelargest">Add New Game / Event</a> </span></td></tr>';
                                            }
                                            echo '</form></table>';
										?>
										<?php  }
                                            else
                                            {
										?><p><font color="#0000ff" style="font:14px Arial bold;"><b>Access Denied</b></font></p><?php
                                            }
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
