<?php

require_once '../inc/db.inc.php';

$db = new DB;

$sport = $_POST['sport'];

if (empty($sport)) {
    return;
}

// there are no stats stored for women's basketball, just men's
if ($sport == 12) {
    $sport = 11;
}
$query = 'SELECT fldName FROM ' . TBL_ATHLETE_STATS_CATEGORY . ' WHERE fldParentId=' . $sport;
error_log($query);
if (!$db->query($query)) {
    die(mysql_error());
}

$stats = array();

while ($db->next_record()) {
    $stats[] = $db->f('fldName');
}

echo json_encode($stats);
