<?php

// gets the name and address of the athlete's high school
$teaminfo = $func->selectTableOrder(
    TBL_HS_AAU_TEAM, 
    'fldSchoolname,fldAddress', 
    'fldSchoolname', 
    "where fldId='" . $fldSchool . "'"
);

$qgTeam = !empty($teaminfo[0]['fldSchoolname']) ?
          $teaminfo[0]['fldSchoolname'] : 'N/A';

$qgTeamAddress = !empty($teaminfo[0]['fldAddress']) ?
                 $teaminfo[0]['fldAddress'] : 'N/A';

// gets the name, phone, and profile URL of all coaches at the athlete's school
$coaches = $func->selectTableOrder(
    TBL_HS_AAU_COACH, 
    'fldId,fldName,fldLastName,fldPhone', 
    'fldId', 
    'WHERE fldSchool=' . $fldSchool
);

$numCoaches = count($coaches);

// finds the approving coach in coaches and separates it from the list if found
$approveCoach = NULL;

for ($i = 0; $i < $numCoaches; $i++) {
    if ($coaches[$i]['fldId'] == $fldApproveCoachId) {
        $approveCoach = $coaches[$i];
        unset($coaches[$i]);
    }
}

?>

<table width="100%" cellspacing="2" cellpadding="5" bordercolor="#808080" border="0" style="border-collapse: collapse;" class="tablePadd">
    <?php if ($numCoaches > 0): ?>
        <tr>
            <td valign="middle"  align="left" class="normalblack_12_stat">
                <b>Coach Name:</b>
            </td>
            <td valign="middle"  align="left" class="normalblack_12_stat">
                <b>Coach Phone:</b>
            </td>
        </tr>
        <?php if ($approveCoach): ?>
        <tr>
            <td valign="middle"  align="left" class="normalblack_12_stat">
                <a href="HsAauCoachProfile.php?mode=view&fldId=<?php echo $approveCoach['fldId']; ?>" title="View HS/AAU Coach Profile">
                    <?php echo $approveCoach['fldName'] . ' ' . $approveCoach['fldLastName']; ?>
                </a>
            </td>
            <td valign="middle"  align="left" class="normalblack_12_stat">
                <?php echo $func->formatPhone($approveCoach['fldPhone']); ?>
            </td>
        </tr>
        <?php endif; ?>
        <?php foreach ($coaches as $coach): ?>
        <tr>
            <td valign="middle"  align="left" class="normalblack_12_stat">
                <a href="HsAauCoachProfile.php?mode=view&fldId=<?php echo $coach['fldId']; ?>" title="View HS/AAU Coach Profile">
                    <?php echo $coach['fldName'] . ' ' . $coach['fldLastName']; ?>
                </a>
            </td>
            <td valign="middle"  align="left" class="normalblack_12_stat">
                <?php echo $coach['fldPhone']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    <tr>
        <td valign="middle"  align="left" class="normalblack_12_stat">
            <b>HS/AAU Team:</b>
            <br />
            <?php echo $qgTeam; ?>
        </td>
        <td valign="middle"  align="left" class="normalblack_12_stat" >
            <b>Team Address:</b>
            <br />
            <?php echo $qgTeamAddress; ?>
        </td>
    </tr>
</table>
