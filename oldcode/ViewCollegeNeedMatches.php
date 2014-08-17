<?phprequire_once 'inc/db.inc.php';$db = new DB;session_start();// authorizes the current userif (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {    header("Location:login.php");}// array of athlete data$a = array();$a['id'] = $_SESSION['Athlete_id'];$query = 'SELECT * FROM ' . TBL_ATHLETE_REGISTER . ' WHERE fldId=' . $a['id'];if (!$db->query($query)) {    die(mysql_error());}$db->next_record();// gets athlete information$a['sport']  = $db->f('fldSport');$a['class']  = $db->f('fldClass');// converts athletes height to inches$height = $db->f('fldHeight');$a['height'] = ((int) substr($height, 0, 1)) * 12             + ((int) substr($height, 2));// gets the min and max from the athlete's weight class rangeswitch (strtolower($db->f('fldWeight'))) {    case 'under140':        $a['minWeight'] = 0;        $a['maxWeight'] = 140;        break;            case 'over260':        $a['minWeight'] = 260;        $a['maxWeight'] = 1000; // no athlete weighs more than 1000 lbs        break;            default:        $a['minWeight'] = substr($db->f('fldWeight'), 0, 3);        $a['maxWeight'] = substr($db->f('fldWeight'), -3);        break;}$a['priPos']   = $db->f('fldPrimaryPosition');$a['secPos']   = $db->f('fldSecondaryPosition');$a['bench']    = intval($db->f('fldBenchPressMax'));$a['squat']    = intval($db->f('fldSquatMax'));$a['dash']     = floatval($db->f('fld40_yardDash'));$a['shuttle']  = floatval($db->f('fldShuttleRun'));$a['vertical'] = intval($db->f('fldVertical'));$a['gpa']      = $db->f('fldGPA');$a['sat']      = $db->f('fldSATScore');$a['rank']     = $db->f('fldClassRank');$a['act']      = $db->f('fldACTScore');$a['clear']    = ($db->f('fldClearinghouseEligible') == 'No') ? 0 : 1;$a['major']    = $db->f('fldIntendedMajor');$a['school']   = $db->f('fldSchool');$a['division'] = $db->f('fldDivision');// gets high school location$query = 'SELECT * FROM ' . TBL_HS_AAU_TEAM . ' WHERE fldId=' . $a['school'];if (!$db->query($query)) {    die(mysql_error());}$db->next_record();$a['city']     = $db->f('fldCity');$a['state']    = $db->f('fldState');// gets athlete sport stats$query = 'SELECT * FROM ' . TBL_ATHLETE_STAT .          ' WHERE fldAtheleteId=' . $a['id'];if (!$db->query($query)) {    die(mysql_error());}$aStats = new stdClass;while ($db->next_record()) {   $aStats->{$db->f('fldLabelname')} = $db->f('fldValue');}// gets needs matching the athlete's characteristics$where = "fldSportId=$a[sport] AND " .          "(fldGradClass IS NULL OR fldGradClass='$a[class]') AND " .         "(fldMinHeight IS NULL OR fldMinHeight<=$a[height]) AND " .         "(fldMaxHeight IS NULL OR fldMaxHeight>=$a[height]) AND " .         "(fldMinWeight IS NULL OR fldMinWeight<=$a[minWeight]) AND " .         "(fldMaxWeight IS NULL OR fldMaxWeight>=$a[maxWeight]) AND " .         "(fldPosition IS NULL OR fldPosition='$a[priPos]' OR fldPosition='$a[secPos]') AND " .         "(fldMinBenchPress IS NULL OR fldMinBenchPress<=$a[bench]) AND " .         "(fldMinSquatMax IS NULL OR fldMinSquatMax<=$a[squat]) AND " .         "(fldMax40YardDash IS NULL OR fldMax40YardDash>=$a[dash]) AND " .         "(fldMaxShuttleRun IS NULL OR fldMaxShuttleRun>=$a[shuttle]) AND " .         "(fldMinVertical IS NULL OR fldMinVertical<=$a[vertical]) AND " .         "(fldCHEligible IS NULL OR fldCHEligible=$a[clear]) AND " .         "(fldIntendedMajor IS NULL OR fldIntendedMajor='$a[major]') AND " .         "(fldHighSchoolIds IS NULL OR $a[school] IN (fldHighSchoolIds)) AND " .         "(fldDivision IS NULL OR fldDivision='$a[division]') AND " .         "(fldCity IS NULL OR fldCity='$a[city]') AND " .         "(fldState IS NULL OR fldState='$a[state]') AND ";// adds all minimum GPA requirements that the athlete would meet$where .= "(fldGPA IS NULL";switch ($a['gpa']) {    case 'Above4.0':        $where .= " OR fldGPA='above4.0'";    case '3.6-4.0':        $where .= " OR fldGPA='3.6-4.0'";    case '3.1-3.5':        $where .= " OR fldGPA='3.1-3.5'";    case '2.6-3.0':        $where .= " OR fldGPA='2.6-3.0'";    case '2.0-2.5':        $where .= " OR fldGPA='2.0-2.5'";    case 'under2.0':        $where .= " OR fldGPA='under2.0'";        break;}$where .= ") AND ";// adds all minimum SAT requirements that the athlete would meet$where .= "(fldSATScore IS NULL";switch ($a['sat']) {    case '2201-2400':        $where .= " OR fldSATScore='2201-2400'";    case '2001-2200':        $where .= " OR fldSATScore='2001-2200'";    case '1801-2000':        $where .= " OR fldSATScore='1801-2000'";    case '1601-1800':        $where .= " OR fldSATScore='1601-1800'";    case '1401-1600':        $where .= " OR fldSATScore='1401-1600'";    case '1201-1400':        $where .= " OR fldSATScore='1201-1400'";    case '1001-1200':        $where .= " OR fldSATScore='1001-1200'";    case '801-1000':        $where .= " OR fldSATScore='801-1000'";    case '601-800':        $where .= " OR fldSATScore='601-800'";    case '400-600':        $where .= " OR fldSATScore='400-600'";        break;}$where .= ") AND ";// adds all minimum class rank requirements that the athlete would meet$where .= "(fldClassRank IS NULL";switch ($a['rank']) {    case 'Top 5% or better':        $where .= " OR fldClassRank='Top 5% or better'";    case 'Top 10% - Top 6%':        $where .= " OR fldClassRank='Top 10% - Top 6%'";    case 'Top 25% - Top 11%':        $where .= " OR fldClassRank='Top 25% - Top 11%'";    case 'Top 50% - Top 26%':        $where .= " OR fldClassRank='Top 50% - Top 26%'";    case 'Not in Top 50% of Class':        $where .= " OR fldClassRank='Not in Top 50% of Class'";        break;}$where .= ") AND ";// adds all minimum ACT requirements that the athlete would meet$where .= "(fldActScore IS NULL";switch ($a['act']) {    case 'Above30':        $where .= " OR fldActScore='Above30'";    case '26-30':        $where .= " OR fldActScore='26-30'";    case '21-25':        $where .= " OR fldActScore='21-25'";    case '16-20':        $where .= " OR fldActScore='16-20'";    case '10-15':        $where .= " OR fldActScore='10-15'";    case 'under10':        $where .= " OR fldActScore='under10'";        break;}$where .= ")";// builds the query for initial need selection$query = 'SELECT fldCollegeId,fldSportStats,fldLastModified ' .          'FROM tbl_college_needs WHERE ' . $where;if (!$db->query($query)) {    die(mysql_error());}// filters needs based on sport stats and adds matching needs to matches$matches = array();while ($db->next_record()) {    // compares athlete stats with need stats, and     // if they don't match, skips this need    $needStats = json_decode($db->f('fldSportStats'));        if ($needStats) {        foreach ($needStats as $label => $value) {            if (property_exists($aStats, $label) &&                 $aStats->$label < $value            ) {                // skips the rest of the foreach loop AND the while loop                continue 2;            }        }    }        // adds the matched need to matches    $match = array();        $db1 = new DB;    $query = 'SELECT fldName FROM ' . TBL_COLLEGE .              ' WHERE fldId=' . $db->f('fldCollegeId');    if (!$db1->query($query)) {        die(mysql_error());    }    $db1->next_record();    $match['id'] = $db->f('fldCollegeId');    $match['name'] = $db1->f('fldName');    $match['lastModified'] = $db->f('fldLastModified');    $match['testCode'] = $db->f('testCode');    $matches[] = $match;}// TODO: Add pagination?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">    <head>        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <title>College Prospect Network - View College Need Matches</title>        <link href="css/style.css" rel="stylesheet" type="text/css" />        <script type="text/javascript" src="javascript/functions.js"></script>    </head>    <body>        <?php include ('header.php'); ?>        <div class="container">            <div class="innerWraper">                <div class="middle-bg">                    <div class="cantener">                        <div class="register-main">                            <div class="registerPage">                                <h1>View College Need Matches</h1>                                <?php if (count($matches) > 0): ?>                                    <div style="display: block; margin-bottom: 5px; text-align: right;"><?php echo count($matches); ?> Total Matches</div>                                    <table cellspacing="2" cellpadding="5" bordercolor="#808080" border="0"                                            width="100%" class="tablePadd" style="border-collapse: collapse;">                                        <tr>                                            <th class="normalblack_12">College</th>                                            <th class="normalblack_12">Last Modified</th>                                        </tr>                                    <?php foreach ($matches as $match): ?>                                        <tr>                                            <td class="normalblack_12">                                                <a href="collegeprofile.php?collegeid=<?php echo $match['id']; ?>">                                                    <?php echo $match['name']; ?>                                                </a>                                            </td>                                            <td class="normalblack_12">                                                <?php echo $match['lastModified']; ?>                                            </td>                                        </tr>                                    <?php endforeach; ?>                                    </table>                                <?php else: ?>                                    <p class="thankyoumessage">                                        You do not match any currently posted college needs.                                    </p>                                <?php endif; ?>                            </div>                        </div>                    </div>                </div>            </div>        </div>        <?php include ('footer.php'); ?>    </body></html>