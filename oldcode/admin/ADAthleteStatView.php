<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Sanjay Chaudhary
##	Page name	:		ADPageEdit.php
##	Create Date	:		10106/2011
##  Description :		It is use to performe the operation for add/edit/delete for User.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				//for admin login



$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "2";
$error_msg = '';
$flag = 0;
$eventid = $_REQUEST['eventid'];
$athleteid = $_REQUEST['athid'];
?>


<HTML><HEAD><TITLE>View Athlete Stat</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js">
</script>
<script language="Javascript" src="../javascript/functions.js">
</script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" OnLoad="textCounter(document.frmUsers.address,document.frmUsers.remLen2,100)" >
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TR>
<TD height=120>
<?include "include/ADheader.php";?>
</TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TR>
<TD class="heading">
<TABLE cellSpacing=0 cellPadding=1 width="95%" align=center border=0>
<TR>
<TD>
	<TABLE cellSpacing=0 cellPadding=1 width=780 border=0>
	<TR>
	<TD bgColor=#ffffff>
		<TABLE cellSpacing=0 cellPadding=0 width=900 border=0>
		<TR>
		<TD vAlign=top width=20%>
			<?include "include/ADmenu.php";?>
		</TD>
		<TD valign=top width=1%>
		&nbsp;
		</TD>
		<TD width=10><img src="spacer.gif" height="1" width="1">
		</TD>
		<TD valign=top width="" align="center">
<!-- MAin Content Starts From Here -->
			<form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan=3 bgcolor="#808080" align="center">
				<b>View Athlete Athletic Stats</b>
			</td>
			</tr>
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr>
			<td valign="top" colspan=3 align="center" class="normalblack_12">
			<font color="Red"><?=$error_msg?> </font>
			</td>
			</tr>
			<tr>
			<td height="35" colspan="3" align="right" class="normalblack_12"></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			<?php 
			
			$query =" Select * from ".TBL_ATHELETE_STAT." where fldPrograme = ".$eventid." and fldAtheleteId=".$athleteid;  
			$db->query($query);
			$db->next_record();
			$fldPrograme          = $func->output_fun($db->f('fldPrograme'));
			$query1 =" Select *  from ".TBL_EVENT. " where fldEventId ='".$fldPrograme."'";
			$db1->query($query1);
			$db1->next_record();
		    $EventName=$db1->f('fldEventName');
			
			
			
			if ($db->num_rows()>0)
			{
				
				echo'<tr height="20">				
			    <td valign="top" colspan=2 align="center" class="normalblack_12" ><strong>'.ucwords($EventName).'</strong></td>
			    </tr>
			    </tr>
				<tr height="20">				
			    <td valign="top" colspan=2 align="center" class="normalblack_12" >&nbsp;</td>
			    </tr>'; 
				
				echo '<tr>
				<td align="center" class="normalblack_12" width="15%">&nbsp;<strong>Stats Category</strong></td>
				<td align="center" class="normalblack_12" width="15%">&nbsp;<strong>Points</strong></td>
				</tr>
				<tr height="20">				
			    <td valign="top" colspan=2 align="center" class="normalblack_12" >&nbsp;</td>
			    </tr>';
						
				for ($i=0;$i<$db->num_rows();$i++)
						 {
						 	
						 	$Value          = $func->output_fun($db->f('fldValue'));
							$Label          = $func->output_fun($db->f('fldLabelname'));
							
							
			echo '<tr>
			<td valign="top" align="center" class="normalblack_12" width="15%">'.$Label.'</td>
			<td valign="top" align="center" class="normalblack_12" width="15%">'.$Value.'</td>
			</tr>
			<tr height="20">				
			<td valign="top" colspan=2 align="center" class="normalblack_12" >&nbsp;</td>
			</tr>';
							
							
							
							
							$db->next_record();
							$count++;
							
						 }
						 
			} 
			
			else 
			{ 
						echo '<tr><td align="center" class="normalblack_12" colspan="10" height="30">
							       <font color="red">No Records Available.</font></td></tr>';
			}
			
			
			?>		
			
		
			

			
			
			
			
			
			
			
			<!-- Upoad File END-->
			</table>
			</td>
			</tr>
			</table>
			</form>
		 <!--Main Center Content END -->
		</td>
		</tr>
		</table>
	</TD>
	</TR>
	</TABLE>
</TD>
</TR>
</TABLE>
</TD>
</TR>
<?include "include/ADfooter.php";?>
<? unset($func);  unset($db); ?>
</TABLE>
</BODY>
</HTML>