<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		ADmain.php
##	Create Date	:		10/06/2011
##  Description :		It is welcome page of admin are.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************
session_start();
include_once("../inc/common_functions.php");	//for common function
include("include/ADsessionAdmin.php");	// for admin login


?>
<HTML><HEAD><TITLE><?=ADMIN_SITE_TITLE?></TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
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
	<TD valign=top width=1%>&nbsp;
	
	</TD>
	<TD width=10><img src="spacer.gif" height="1" width="1"></TD>
	<TD valign=top width="">
		<!-- Main Center Table Starts Here -->
		<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
		<tr>
		<td align="center" class="normalblack_12" width="100%" colspan="2">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<td align="center" class="normalblack_12"><br>
			<strong>Welcome to the Admin Panel</strong><br> </td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
			</table>
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
</TABLE>
</TD>
</TR>
<?include "include/ADfooter.php";?>
</TABLE>
</BODY>
</HTML>