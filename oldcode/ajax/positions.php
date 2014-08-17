<?php

require_once '../inc/db.inc.php';

$db = new DB;

$sport = $_POST['sport'];

if (empty($sport)) {
    return;
}

$tbl = NULL;

switch ($sport) {
    case 10:
        $tbl = TBL_POSITION_FOOTBALL;
        break;
        
    case 11:
    case 12:
        $tbl = TBL_POSITION_BASKETBALL;
        break;
}

$query = 'SELECT ID,Position FROM ' . $tbl;

if (!$db->query($query)) {
    return;
}

$positions = array();

while ($db->next_record()) {
    $positions[$db->f('ID')] = $db->f('Position');
}

echo json_encode($positions);

