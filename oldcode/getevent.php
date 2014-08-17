<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");


//for paging

$func = new COMMONFUNC;
$db = new DB;
//$flag=1;



          $q=$_GET["q"];
         if($q!='select'){
?><label>Event Name:</label><span>	<input type="text" name="fldEventName" id="fldEventName" value="<?php  echo $_GET['HomeTeam'] . " vs. " . $_GET['AwayTeam'];?>"  style="width:375px;"></span><font color="#0000ff">&nbsp;*</font></span><?php    }    else {?><label>Event Name:</label><span>	<input type="text" name="fldEventName" id="fldEventName" style="width:375px;" readonly></span><font color="#0000ff">&nbsp;*</font></span><?php    }?>              