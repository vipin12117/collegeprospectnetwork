<?php

require_once 'anet_php_sdk/AuthorizeNet.php';
require_once 'AuthorizeNetMerchantAccount.php';



<!-- TODO: move all this to subscription_cancel.php -->                                  
<?php if ($fldSubscribe == 1): ?>
<?php if($text=='I00001') {
$qyery_san="
UPDATE `".TBL_COLLEGE_COACH_REGISTER."` SET `fldStatus` = 'ACTIVE',
`fldSubscribe` = '0',
`fldtransectionId` = '',
`fldCancelCount` = '".$fldCancelCount."',
`fldCancelDate` = DATE_ADD(DATE(NOW()), INTERVAL ".$fldCancelCount." MONTH),
`fldReason` = '".$_POST['fldReason']."',
`fldOtherReason` = '".$_POST['other']."' WHERE `fldCollegename` =$fldCollegename;
";
$db->query($qyery_san);
?>
<script type="text/javascript">
alert("Your Subscripation Has Been Cancel");

</script>
<?php
echo '<script>document.location.href="logout.php";</script>';
}
?>
