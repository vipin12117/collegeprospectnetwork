<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		ADMessageList.php
##	Create Date	:		19/07/2011
##  Description :		It is use to show the listig of Messages.
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

if(($_POST['fldStartdate']!='Please Select Start Date') and ($_POST['fldEndDate']!='Please Select End Date') )
{
	if($_POST['fldcontent']!='Search By Content')
{
	$srchCond="and ((Message like '%".$_POST['fldcontent']."%') and (date(SentDate)>= '".$_POST['fldStartdate']."') and (date(SentDate) <= '".$_POST['fldEndDate']."') )";
}
	else if($_POST['fldcontent']=='Search By Content')
	{
	$srchCond="and ((Message like '%".$_POST['fldcontent']."%') or (date(SentDate)>= '".$_POST['fldStartdate']."') and (date(SentDate) <= '".$_POST['fldEndDate']."') )";
	}
	else if($_POST['fldcontent']=='')
	{
		$srchCond="and ((Message like '%".$_POST['fldcontent']."%') or (date(SentDate)>= '".$_POST['fldStartdate']."') and (date(SentDate) <= '".$_POST['fldEndDate']."') )";
	}
	}
if($_POST['search']=='Search')
{
	$fldStartdate =$_POST['fldStartdate'];
	$fldEndDate   =$_POST['fldEndDate'];
	$fldcontent   =$_POST['fldcontent'];
}

if($_REQUEST['mode']=="delAll"){
	foreach ($_REQUEST['check_delete'] as $k=>$mail_id)
	{
	$delete_query_details = "delete from ".TBL_MAIL." where mail_id='$mail_id'";
	$delmsg = $db->query($delete_query_details);
	}
	if(isset($delmsg)){
		$_REQUEST['msg']= "Message Deleted Successfully!";
		$count=$func->totalRows(TBL_MAIL);
		$offset=$_REQUEST['page']*10;
		if($count<=$offset)
		{
			$offset=$offset-$count;
			$_REQUEST['page'] =$offset/10;
		}
	}
}

if($_REQUEST['mode']=="dective")
{
	$mail_id=$_REQUEST['mail_id'];
	$active_query_details = "update ".TBL_MAIL." set visible = 'DECTIVE' where mail_id='".$mail_id."'";
	$activemsg = $db->query($active_query_details);
	if(isset($activemsg)){
		$_REQUEST['msg']= "Message De-Active Successfully!";	
	}
}


if($_REQUEST['mode']=="active")
{
	$mail_id=$_REQUEST['mail_id'];
	$active_query_details = "update ".TBL_MAIL." set visible = 'ACTIVE' where mail_id='".$mail_id."'";
	$activemsg = $db->query($active_query_details);
	if(isset($activemsg)){
		$_REQUEST['msg']= "Message Active Successfully!";	
	}
}





if($_REQUEST['page']==''){$pageno='0';}else{$pageno=$_REQUEST['page'];}
?>
<HTML><HEAD><TITLE>Member Listing</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
<script type='text/javascript' src='../javascript/zapatec/utils/zapatec.js'></script>
		<script type="text/javascript" src="../javascript/zapatec/zpcal/src/calendar.js"></script>
		<script type="text/javascript" src="../javascript/zapatec/zpcal/lang/calendar-en.js"></script>
		<link href="../javascript/zapatec/zpcal/themes/aqua.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">





function dectiveMessage(mail_id)
{
	if( confirm("Are you sure to deactive this Message?")) {
		document.frmUsers.action="?mode=dective&mail_id="+mail_id;
		document.frmUsers.submit();
	}
}

function activeMessage(mail_id)
{
	if( confirm("Are you sure to active this Message?")) {
		document.frmUsers.action="?mode=active&mail_id="+mail_id;
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
		if( confirm("Are you sure to delete the selected Message?")) {
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
							<strong>Message Listing</strong> </td></tr>
							
							<tr><td align='center' class='normalblack_12'  colspan='11' height='30' valign='middle'><font color='red'><? if($_REQUEST['msg']!=""){echo $_REQUEST['msg'];}else { echo " ";}?></font></td></tr>
							<tr><td align='center' class='normalblack_12'  colspan='11' height='30' valign='middle'>
						
							
							</td></tr>
							<tr><td align='center' class='normalblack_12'  colspan='11' height='30' valign='middle'>
							<form name="searchFrm" id="searchFrm" action="<? echo $PHP_SELF;?>"  method="POST">
				
				            <input type="hidden" name="page" id="page" value="0">
				            <input type="text" name="fldcontent" id="fldcontent" value="<?php if($fldcontent) {echo $fldcontent;}else {?>Search By Content<?php } ?>">
							<input type="text"  style="float: left;width:200px;" class="input_L"  id="fldStartdate" name="fldStartdate" autocomplete="off" value="<?php  if($fldStartdate) {echo $fldStartdate;}else{echo "Please Select Start Date";}?>">
            <img style="float: left; padding-right: 5px; margin-top: -2px;" alt="" src="images/icon-calender.png" name="button2" id="button2">
				<script type="text/javascript">
					var cal = new Zapatec.Calendar.setup({
					
					inputField     :    "fldStartdate",     // id of the input field
					singleClick    :     true,     // require two clicks to submit
					ifFormat       :    '%Y-%m-%d',     // format of the input field
					showsTime      :     true,     // show time as well as date
					button         :    "button2"  // trigger button 
					});
				</script>
				<input type="text"  style="float: left;width:200px;" class="input_L"  id="fldEndDate" name="fldEndDate" autocomplete="off" value="<?php  if($fldEndDate) {echo $fldEndDate;}else{echo "Please Select End Date";}?>">
           <img style="float: left; padding-right: 5px; margin-top: -2px;" alt="" src="images/icon-calender.png" name="button3" id="button3">
				<script type="text/javascript">
					var cal = new Zapatec.Calendar.setup({
					
					inputField     :    "fldEndDate",     // id of the input field
					singleClick    :     true,     // require two clicks to submit
					ifFormat       :    '%Y-%m-%d',     // format of the input field
					showsTime      :     true,     // show time as well as date
					button         :    "button3"  // trigger button 
					});
				</script>
							<input type="submit"  name="search" id="search"  value="Search">
							</form></td></tr>
							<form name="frmUsers" action="" method="post" onsubmit="">
						<?php
						if($_POST['search']=='Search')
						{
							
  if(($_POST['fldStartdate']!='Please Select Start Date') and ($_POST['fldEndDate']!='Please Select End Date') )
  {
  	
 $query ="Select UserTo,UserFrom, Subject, Message, status,SentDate,mail_id,visible from ".TBL_MAIL." where 1=1 ".$srchCond."order by mail_id DESC ";
   }
   else  
   {
  $srchCond="and (Message like '%".$_POST['fldcontent']."%')"; 
  if($_POST['fldcontent']!='Search By Content')
{
	$srchCond="and (Message like '%".$_POST['fldcontent']."%')"; 
}
	else if($_POST['fldcontent']=='Search By Content')
	{
	$srchCond="and (Message like '%".$_POST['fldcontent']."%')"; 
	}
	else if($_POST['fldcontent']=='')
	{
		$srchCond=""; 
	}	
 $query =" Select * from ".TBL_MAIL." where 1=1 ".$srchCond." order by mail_id DESC ";
						
   }
						}
						else {
							$query =" Select * from ".TBL_MAIL." order by mail_id DESC ";
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
						//echo $query;
						//echo $queryString;
						$db->query($query);
						$db->next_record();


if ($db->num_rows()>0) {#check for record availability

echo '<tr><td align="center" class="normalblack_12" width="4%">&nbsp;</td>
<td align="left" class="normalblack_12" width="8%">&nbsp;<strong>S.No.</strong></td>
<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>UserTo</strong></td>
<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>UserFrom</strong></td>
<td align="left" class="normalblack_12" width="15%">&nbsp;<strong>Subject</strong></td>
<td align="left" class="normalblack_12" width="10%">&nbsp;<strong>SentDate</strong></td>';
echo '<td class="normalblack_12" width="5%" align="center"><strong>Status</strong></td>';
echo '<td class="normalblack_12" width="5%" align="center"><strong>View Message</strong></td>';


echo '</tr>';
						$count="1";
						for ($i=0;$i<$db->num_rows();$i++) {
						
						$UserTo                    = $func->output_fun($db->f('UserTo'));
						$UserFrom                  = $func->output_fun($db->f('UserFrom'));
						$Subject                   = $func->output_fun($db->f('Subject'));
						$SentDate                  = $func->output_fun($db->f('SentDate'));
						$visible                   = $func->output_fun($db->f('visible'));
						$mail_id                   = $func->output_fun($db->f('mail_id'));
                        $Message                   = $func->output_fun($db->f('Message'));
                        $Usertypeto                = $func->output_fun($db->f('Usertypeto'));
                        $Usertypefrom              = $func->output_fun($db->f('Usertypefrom'));
                        
                        if($Usertypeto == 'coach')
                        {
                        	$Usertypeto = 'Hs-AAu-Coach';
                        }
                        else if ($Usertypeto == 'college')
                        {
                         	$Usertypeto = 'College-Coach';
                        }
                        else 
                        {
                        	$Usertypeto = 'Athlete';
                        }
                        
                        
                        if($Usertypefrom == 'coach')
                        {
                        	$Usertypefrom = 'Hs-AAu-Coach';
                        }
                        else if ($Usertypefrom == 'college')
                        {
                         	$Usertypefrom = 'College-Coach';
                        }
                        else 
                        {
                        	$Usertypefrom = 'Athlete';
                        }

	

echo '<tr><td align="center" class="normalblack_12">&nbsp;';

echo '<input type="checkbox" id="check_delete[]" name="check_delete[]" value="'.$mail_id.'" onclick="return checkItSelf();">';

echo '<td align="left" class="normalblack_12">&nbsp;'.($count+($_REQUEST['page']*10)).'</td>

<td align="left" class="normalblack_12" >'.ucfirst(wordwrap($UserTo,25,"\n",true)).'&nbsp;('.$Usertypeto.')</td>
<td align="left" class="normalblack_12" >'.ucfirst(wordwrap($UserFrom,24,"\n",true)).'&nbsp;('.$Usertypefrom.')</td>
<td align="left" class="normalblack_12">'.wordwrap($Subject,50,"\n",true).'</td>
<td align="left" class="normalblack_12">'.wordwrap($SentDate,25,"\n",true).'</td>';

?>
<?php

if($visible=='ACTIVE')
{
echo ' <td  class="normalblack_12" align="center"><a href="javascript:dectiveMessage(\''.$mail_id.'\')">
<img src="images/green-point.gif" border="0" title="Active"></a></td>';
}
else 
{
echo ' <td  class="normalblack_12" align="center"><a href="javascript:activeMessage(\''.$mail_id.'\')">
<img src="images/red-point.gif" border="0" title="Dective"></a></td>';	
}
             $pageURL                 = "ADMessageDetails.php?mail_id=$mail_id";
			 $detailsWindowTitle      = "MessageDetails";
echo '<td  class="normalblack_12" align="center"><a href="javascript:ShowDetails(\''.$pageURL.'\',\''.$detailsWindowTitle.'\')">View</a></td>';



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