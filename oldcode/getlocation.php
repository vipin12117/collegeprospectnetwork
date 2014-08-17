<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");


//for paging

$func = new COMMONFUNC;
$db = new DB;




          $q=$_GET["q"];
         if($q!='select'){
?><label>Location:</label><?php  $query = "Select * from " . TBL_HS_AAU_TEAM . " where fldId =" . $q;    $db -> query($query);    $db -> next_record();    $address = $db -> f('fldAddress');    $city = $db -> f('fldCity');    $state = $db -> f('fldState');    $zipcode = $db -> f('fldZipcode');                                                        $location = $address . "\r\n" . $city . ", " . $state . " " . $zipcode;?><span>	<textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="15"    ><?php    if ($location) {echo $location;    }?></textarea></span><font color="#0000ff">*</font></span><?php    }    else {?><label>Location:</label><span>	<textarea name="fldEventLocation" id="fldEventLocation" rows="4" cols="15"    ><?php    if ($location) {echo $location;    }?></textarea></span><font color="#0000ff">*</font></span><?php    }?>                             