<?php
include_once ("inc/common_functions.php");
include_once ("inc/page.inc.php");

session_start();

$func = new COMMONFUNC;
$db = new DB;
$flag = 0;

/*
 * checks users who have a free trial and ends the trial if 5 days have passed
 */

$college_subscription_query = "select * from tbl_college_coach_register where date(fldAddDate)<= (DATE_SUB(now(), INTERVAL 5 day)) and fldSubscribe=2";
$db -> query($college_subscription_query);
$db -> next_record();

for ($k = 0; $k < $db -> num_rows(); $k++) {
    $arr_info[$k]['fldCollegename'] = $db -> f('fldCollegename');
    $arr_info[$k]['fldStatus'] = $db -> f('fldStatus');
    $arr_info[$k]['fldSubscribe'] = $db -> f('fldSubscribe');
    $db -> next_record();
}

for ($kj = 0; $kj < count($arr_info); $kj++) {
    $sql1 = "update  " . TBL_COLLEGE_COACH_REGISTER . "  set   fldSubscribe='0' where fldCollegename='" . $arr_info[$kj]['fldCollegename'] . "'";
    $db -> query($sql1);
}

/*
 * Not sure what this does, but setting up a section for it
 */

$college_subscription_complet_query = "select * from tbl_college_coach_register where date(fldCancelDate) = now() and fldCancelCount !=0";
$db1 -> query($college_subscription_query);
$db1 -> next_record();

if ($db1 -> num_rows() > 0) {
    for ($k = 0; $k < $db1 -> num_rows(); $k++) {
        $arr_info[$k]['fldCollegename'] = $db1 -> f('fldCollegename');
        $arr_info[$k]['fldStatus'] = $db1 -> f('fldStatus');
        $arr_info[$k]['fldSubscribe'] = $db1 -> f('fldSubscribe');
        $db1 -> next_record();
    }
    
    if (count($arr_info) > 0) {
        for ($kj = 0; $kj < count($arr_info); $kj++) {
        $sql_cancel = "update  " . TBL_COLLEGE_COACH_REGISTER . "  set  fldStatus='ACTIVE', fldSubscribe='0'  where fldCollegename='" . $arr_info[$kj]['fldCollegename'] . "'";
        $db2 -> query($sql_cancel);
        }
    }
}

/*
 * checks all active subscriptions in the database
 * to see if they need to be billed again
 */
include_once 'cronAuthorizeNet.php';
