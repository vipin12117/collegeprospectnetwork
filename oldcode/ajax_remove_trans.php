<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");

$func = new COMMONFUNC;
$db = new DB;
$tbl_transportation_discount='tbl_transportation_discount';
$id=$_REQUEST["fld_id"];
$sel ="Select fldTranscript from ".TBL_SPECIAL_EVENT_REGISTER." where fldId=".$_REQUEST['fld_id'];
$result=$db->query($sel);
$row=mysql_fetch_array($result);
$dfile = $row['fldTranscript'];
	if($dfile != "")
	{
		if(file_exists($dfile))
		{
			unlink($dfile);
		}
		
	}
$del="update ".TBL_SPECIAL_EVENT_REGISTER." set fldTranscript='' where fldId=".$id;	
$res=mysql_query($del);
header('location:Registration-Special-Event.php?fld_id='.$id);
?>	
