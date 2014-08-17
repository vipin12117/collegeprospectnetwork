<?php



include_once ("inc/common_functions.php");

include_once ("inc/page.inc.php");



$func = new COMMONFUNC;



session_start();



if ($_SESSION['FRONTEND_USER'] == "") {

    header("Location:index.php");

}



// sport for the user

$fldSport = NULL;

// table to query user information

$table = NULL;



// selects table to query user information based on _SESSION['mode']
$_SESSION['mode'];
switch ($_SESSION['mode'])

{

    case 'athlete':

        $table = TBL_ATHLETE_REGISTER;

        break;



    case 'coach':

        $table = TBL_HS_AAU_COACH;

        break;



    default:

        die('Not a valid user type');

        break;

}



// gets information about the user

/*$userInfo = $func->selectTableOrder(

    $table,

    "fldId,fldUsername,fldSchool,fldSport",

    "fldId",

    " WHERE fldUsername='" . $_SESSION['FRONTEND_USER']. "'"

);*/

$collegeuser_id = $_SESSION['FRONTEND_USER'];

// gets the user's sport and makes sure it's not empty

$fldSport = 0;

$network_for = isset($_REQUEST["network_for"])?$_REQUEST["network_for"]:"";



    $ModeType = isset($_REQUEST["mode"])?$_REQUEST["mode"]:"";

	switch ($ModeType)

	{

		case 'athlete':

			//AthleteID

			$UserID =  isset($_SESSION['Athlete_id'])?$_SESSION['Athlete_id']:"";

			$fldSport = $func -> GetValue("tbl_athelete_register","fldSport","fldId",$UserID);

			break;

		case 'coach':

			//HS Coach ID

			$UserID =isset($_SESSION['Coach_id'])?$_SESSION['Coach_id']:"";

			$fldSport = $func -> GetValue("tbl_hs_aau_coach","fldSport","fldId",$UserID);

			break;

		case 'college':

			//College Coach ID

			$UserID = isset($_SESSION['College_Coach_id'])?$_SESSION['College_Coach_id']:"";

			$sport_info = $func -> selectTableOrder(TBL_COLLEGE_COACH_REGISTER, "fldId,fldNeedType", "fldId", "where fldUserName='" . $collegeuser_id . "'");

			$fldSport = $sport_info[0]['fldNeedType'];



			break;

	}

	//echo $fldSport;

//mdify 4-2-13

//if (empty($fldSport)) {

    //die(mysql_error());

//	header('location:myaccount.php');

//}

//echo "abc ".__LINE__;



// query

$select = 'SELECT ' .

          TBL_COLLEGE . '.fldId, ' .

          TBL_COLLEGE . '.fldName, ' .

          TBL_COLLEGE_COACH_REGISTER . '.fldFirstName, ' .

          TBL_COLLEGE_COACH_REGISTER . '.fldLastName ' .

          'FROM ' . TBL_COLLEGE . ' ' .

          'INNER JOIN ' . TBL_COLLEGE_COACH_REGISTER . ' ' .

          'ON ' . TBL_COLLEGE_COACH_REGISTER . '.fldCollegename=' .

          TBL_COLLEGE . '.fldId ';



$where  = 'WHERE ' . TBL_COLLEGE_COACH_REGISTER .

          '.fldSport=' . $fldSport . ' ';



// gets the requested college ID if set

if (isset($_GET['Id']) && is_numeric($_GET['Id'])) {

    $id = mysql_real_escape_string($_GET['Id']);

    $where .= 'AND ' . TBL_COLLEGE . '.fldId=' . $id . ' ';

}



// gets the requested search name if set

if (isset($_GET['searchname'])) {

    $searchName = mysql_real_escape_string($_GET['searchname']);



    if (strlen($searchName) > 0) {

        $where .= 'AND (' . TBL_COLLEGE_COACH_REGISTER . '.fldFirstName ' .

                  "LIKE '%" . $searchName . "%' OR " .

                  TBL_COLLEGE_COACH_REGISTER . '.fldLastName ' .

                  "LIKE '%" . $searchName . "%') ";

    }

}



$query = $select . $where;



if (!$db->query($query)) {

    die(mysql_error());

}



// sets the number of results to display per page

$display = 20;



// gets the total number of pages

$totalPages = ceil($db->num_rows() / $display);



// gets the current page, setting the current page to 1 by default

$page = 1;



if (isset($_GET['p']) && is_numeric($_GET['p'])) {



    // checks that the requested page is a valid page number

    switch ($_GET['p']) {

        // sets page to the total number of pages if the requested

        // page is greater than the total number of pages

        case ($_GET['p'] > $totalPages):

            $page = $totalPages;

            break;



        // sets page to 1 if the requested page is less than 1

        case ($_GET['p'] < 1):

            $page = 1;

            break;



        // sets page to the requested page number

        default:

            $page = intval($_GET['p']);

            break;

    }

}



// calculates the offset based on the current requested page

$offset = ($page - 1) * $display;



$query .= ' LIMIT ' . $offset . ', ' . $display;



if (!$db->query($query)) {

    die(mysql_error());

}



// creates the next and previous link URLs

$next = 'ViewCollegeCoach.php?p=' . ($page + 1);

$prev = 'ViewCollegeCoach.php?p=' . ($page - 1);



if (isset($_GET['Id'])) {

    $next .= '&Id=' . $_GET['Id'];

    $prev .= '&Id=' . $_GET['Id'];

}



if (isset($_GET['searchname'])) {

    $next .= '&searchname=' . $_GET['searchname'];

    $prev .= '&searchname=' . $_GET['searchname'];

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>College Prospect Network - HS / AAU Coach Listing</title>

		<META NAME="Keywords" CONTENT="">

		<META NAME="Description" CONTENT="">

		<link href="css/style.css" rel="stylesheet" type="text/css" />

		<script language="Javascript" src="javascript/functions.js"></script>

	</head>

	<body>

        <?php include ('header.php'); ?>

        <!--middle panel starts from here -->

        <!--content panel starts from here -->

        <div class="container">

        <div class="innerWraper">

        <div class="middle-bg">

        <div class="cantener">

        <div class="register-main">

        <div class="registerPage">

            <h1>Browse All Colleges</h1>

            <?php if ($db->num_rows() == 0): ?>

                <p class="thankyoumessage">

                    No colleges match the search criteria.

                </p>

            <?php else: ?>

                <table cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" width="100%" class="tablePadd" style="border-collapse: collapse;">

                <!-- <form name="frmCatagory" action="" method="post" onsubmit=""> -->

                    <tr>

                        <td class="normalblack_12" align="left"><strong>College Name</strong></td>

                        <td class="normalblack_12" align="left"><strong>Name</strong></td>

                        <td class="normalblack_12" align="center"><strong>View</strong></td>

                    </tr>

                    <?php while ($db->next_record()): ?>

                        <tr>

                            <td class="normalblack_12" align="left">

                                <?php echo $db->f('fldName'); ?>

                            </td>

                            <td class="normalblack_12" align="left">

                                <?php echo $db->f('fldFirstName') . ' ' . $db->f('fldLastName'); ?>

                            </td>

                            <td class="normalblack_12" align="center">

                                <a href="collegeprofile.php?collegeid=<?php echo $db->f('fldId'); ?>" style="text-decoration:none">

                                    <img src="admin/images/view.gif" border="0" title="View College Profile">

                                </a>

                            </td>

                        </td>

                    <?php endwhile; ?>

                </table>

                <?php if ($page < $totalPages): ?>

                <div style="float: right">

                    <a href="<?php echo $next; ?>">

                        Next &gt;

                    </a>

                </div>

                <?php endif; ?>

                <?php if ($page > 1): ?>

                <div>

                    <a href="<?php echo $prev; ?>">

                        &lt; Previous

                    </a>

                </div>

                <?php endif; ?>

            <?php endif; ?>

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

		<?php include ('footer.php'); ?>

	</body>

</html>

