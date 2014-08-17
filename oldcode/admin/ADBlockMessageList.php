<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		ADUserList.php
##	Create Date	:		10/06/2011
##  Description :		It is use to show the listig of Registered Users.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				// for admin login

$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$page=new Page();	//Create an instance of class Pate
$lnb = "2";
$error_msg = '';


$srchCond='';






if($_REQUEST['mode']=="del")
{
	$fldId=$_REQUEST['fldId'];
	$delete_query_details = "delete from ".TBL_BLOCK_MESSAGE." where fldId='".$fldId."'";
	$delmsg = $db->query($delete_query_details);
	if(isset($delmsg)){
		$_REQUEST['msg']= "Message Block Deleted Successfully!";
		$count=$func->totalRows(TBL_BLOCK_MESSAGE);
		$offset=$_REQUEST['page']*10;
		if($count<=$offset)
		{
			$offset=$offset-$count;
			$_REQUEST['page'] =$offset/10;
		}
	}
}



if($_REQUEST['mode']=="delAll"){
	foreach ($_REQUEST['check_delete'] as $k=>$fldId)
	{
	$delete_query_details = "delete from ".TBL_BLOCK_MESSAGE." where fldId='$fldId'";
	$delmsg = $db->query($delete_query_details);
	}
	if(isset($delmsg)){
		$_REQUEST['msg']= "Message Block Deleted Successfully!";
		$count=$func->totalRows(TBL_BLOCK_MESSAGE);
		$offset=$_REQUEST['page']*10;
		if($count<=$offset)
		{
			$offset=$offset-$count;
			$_REQUEST['page'] =$offset/10;
		}
	}
}



if($_REQUEST['page']==''){$pageno='0';}else{$pageno=$_REQUEST['page'];}
?>
<HTML><HEAD><TITLE>Member Listing</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

function deleteRecord(fldId,page) {
	
	if( confirm("Are you sure to delete the Message?")) {
		document.frmUsers.action="?mode=del&fldId="+fldId+"&page="+page;
		document.frmUsers.submit();
	}
}



function submitDeleteAll(){
	var countChecked = 0;
	var checkBox = document.getElementsByName('check_delete[]');
	var totalCheckboxes = document.getElementsByName('check_delete[]').length;

	if(totalCheckboxes!=0){

		for(var i=0; i<totalCheckboxes; i++){
			if(checkBox[i].checked == true){

				countChecked = countChecked+1;

			}
		}

	}

	if(countChecked!=0){
		if( confirm("Are you sure to delete the Message?")) {
			document.frmUsers.action="?mode=delAll";
			document.frmUsers.submit();
			return true;
		}
		return false;
	}else{
		alert("Please select at least one Message to delete");
		return false;
	}

}
function searchTxt(){
		
	
	document.searchFrm.submit();
	
}
</script>

</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TR>
<TD height=120>
<?include "include/ADheader.php";?>
</TD>
</TR>

<TR>
<TD>&nbsp;</TD>
</TR>
<!-- #####################  CENTER CONTENT STARTS HERE (Left Menu and Center Content)  ##############################-->
<TR>
<TD class="heading">
 <TABLE cellSpacing=0 cellPadding=1 width="95%" align=center border=0>
	 <TR>
	 <TD>
		<TABLE cellSpacing=0 cellPadding=1 width=780 border=0>
			<TR>
			<TD bgColor=#ffffff>
				<TABLE cellSpacing=0 cellPadding=0 width="900" border=0>
				<TR>
				<TD vAlign=top width=20%>
				<?include "include/ADmenu.php";?>
				</TD>
				<TD valign=top width=1%>
				&nbsp;
				</TD>
				<TD width=10><img src="spacer.gif" height="1" width="1"></TD>
				<TD valign=top width="">
				
 				
				<!--Main Center Content BEGIN -->
						
						<table border="1" cellpadding="1" cellspacing="0" width="100%" bordercolor="#808080" style="border-collapse:collapse" class="tablePadd"> 
							<tr><td align="center" class="normalwhite_14"  colspan="11" bgcolor="#808080">
							<strong>Block Messaging Listing</strong> </td></tr>
							
							<tr><td align='center' class='normalblack_12'  colspan='11' height='30' valign='middle'><font color='red'><? if($_REQUEST['msg']!=""){echo $_REQUEST['msg'];}else { echo " ";}?></font></td></tr>
							
							<form name="frmUsers" action="" method="post" onsubmit="">
						<?
  if(!$searchname)
  {
 $query =" Select fldId,fldFrom, fldSport, fldTo, fldStartdate,fldEndDate,fldStatus from ".TBL_BLOCK_MESSAGE." order by fldId DESC ";
   }
   else
   {
$query ="Select fldId,fldFrom, fldSport, fldTo, fldStartdate,fldEndDate,fldStatus  from ".TBL_BLOCK_MESSAGE." where 1=1 order by fldId DESC ".$srchCond;
						
   }
						
						$db->query($query);
						$db->next_record();

						$totalUsers = $db->num_rows();
						if($totalUsers>0){
						
						?>
								<tr> <td align="left" style="padding-left:7px;"colspan="11"><input type="checkbox" id="check_all" name="check_all" value="" onclick="javascript:checkAll();"> <b>Check All</b>&nbsp; &nbsp;<input type="button" name="delete" value="Delete Selected" onclick="return submitDeleteAll();"></td></tr>
						<?php
						}

						#Code for paging
						$page->set_page_data('',$db->num_rows(),100,5,true,false,true);
						$page->set_qry_string($queryString);
						
						$query = $page->get_limit_query($query); //return the query with limits
						
						$db->query($query);
						$db->next_record();


if ($db->num_rows()>0) {#check for record availability

						echo '<tr><td align="center" class="normalblack_12" width="4%">&nbsp;</td>
						<td align="left" class="normalblack_12" width="8%">&nbsp;<strong>S.No.</strong></td>
						<td align="left" class="normalblack_12" width="20%">&nbsp;<strong>From</strong></td>
						<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>Sport</strong></td>
						<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>To</strong></td>
						<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>StartDate</strong></td>
						<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>EndDate</strong></td>';
						echo '<td class="normalblack_12" width="5%" align="center"><strong>Status</strong></td>';
						echo '<td class="normalblack_12" width="7%" align="center"><strong>Delete</strong></td>';	
						echo '</tr>';
						
						$count="1";
						for ($i=0;$i<$db->num_rows();$i++) {
							
							
						$fldId           = $func->output_fun($db->f('fldId'));
						$fldFrom         = $func->output_fun($db->f('fldFrom'));
						$fldSport        = $func->output_fun($db->f('fldSport'));
						$fldTo           = $func->output_fun($db->f('fldTo'));
						$fldStartdate    = $func->output_fun($db->f('fldStartdate'));
						$fldEndDate      = $func->output_fun($db->f('fldEndDate'));
						$fldStatus       = $func->output_fun($db->f('fldStatus'));
						
		
						 
						 
						 $query = "select fldSportsname from ".TBL_SPORTS." where fldId='".$fldSport."'";
					     $db2->query($query);
						 $db2->next_record();
						 $sportname = $func->output_fun($db2->f('fldSportsname'));
					    
		     if($fldFrom=='college')
		     {
		     	$fldFrom="College Coach";
		     }
		     
		     else 
		     {
		     	$fldFrom="Hs/AAu Coach";
		     }
		     
		     if($fldTo == 'athlete')
		     {
		     	$fldTo = "Athlete";
		     }
		     
						
						echo '<tr><td align="center" class="normalblack_12">&nbsp;';
						echo '<input type="checkbox" id="check_delete[]" name="check_delete[]" value="'.$fldId.'" onclick="return checkItSelf();">';
						echo '<td align="left" class="normalblack_12">&nbsp;'.($count+($_REQUEST['page']*10)).'</td>
						<td align="left" class="normalblack_12" >'.wordwrap($fldFrom,14,"\n",true).'</td>
						<td align="left" class="normalblack_12" >'.wordwrap($sportname,24,"\n",true).'</td>
						<td align="left" class="normalblack_12">'.wordwrap($fldTo,15,"\n",true).'</td>
						<td align="left" class="normalblack_12">'.wordwrap($fldStartdate,15,"\n",true).'</td>
						<td align="left" class="normalblack_12">'.wordwrap($fldEndDate,15,"\n",true).'</td>
						<td align="left" class="normalblack_12">'.wordwrap($fldStatus,15,"\n",true).'</td>';		
	
							
					echo ' <td  class="normalblack_12" align="center"><a href="javascript:deleteRecord(\''.$fldId.'\','.$pageno.')"><img src="images/b_drop.png" border="0" title="Delete"></a></td>';



echo '</tr>';
$db->next_record();
$count++;
}
#show pagination
echo '<tr><td align="right" class="normalblack_12" colspan="11">';
$page->get_page_nav();
echo '&nbsp;</td></tr>';

} else { #no record message comes here
echo '<tr><td align="center" class="normalblack_12" colspan="10" height="30">
<font color="red">No Records Available.</font></td></tr>';
}
echo '</form></table>';
							?>
		<!--Main Center Content END -->
			    </TD>
			    </TR>
		       </TABLE>
		   </TD>
		   </TR>
	   </TABLE>
	 </TD>
	 </TR>
 </TABLE>
</TD>
</TR>
<!-- #####################  CENTER CONTENT ENDS HERE (Left Menu and Center Content)  ##############################-->
<?include "include/ADfooter.php";?>
<? unset($func);  unset($page);   unset($db); ?>
</TABLE>
</BODY>
</HTML>