<?PHP
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		ADmenu.php
##	Create Date	:		10/06/2011
##  Description :		It is use to as a include file for left navigation in admin panel.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************
?>
<?php 
  $Host   = "external-db.s142079.gridserver.com";  //teknicks
  $Database = "db142079_cpn";	//put the database name here
  $User     = "db142079";	//put the user name here
  $Password = "cpn1048@!353";	//put passwort here
		  $test_new = mysql_connect($Host,$User,$Password,true);
		  mysql_select_db($Database,$test_new);
		$x_Test_Request = hb_get_payment_mode();
		if($x_Test_Request == 'TRUE')
		{
			?>
			<style type="text/css">
				.test_mode
				{
					text-decoration:none;
				}
				.test_mode:hover
				{
					text-decoration:underline;
				}
			</style>
<table style="position:fixed; top:0; left:0; width:100%; background-color:#FF0000">
	<tr>
		<td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:18px; color:#FFFFFF;">Authorize.net payment is in test mode. <a href="make_live.php" class="test_mode">Make It Live</a></td>
	</tr>
</table>
			<?php
		}
		mysql_close($test_new);
?>
<table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#808080">
<tr>
<td>
<TABLE cellSpacing=0 cellPadding=0 bgColor=#CCCCCC border=0>
<TR>
<TD width="15" align=right bgColor=#ffffff class=normalbrown>&nbsp;</TD>
<TD width="180" height=22 align=left bgColor=#ffffff class=normalbrown>

<br><span class="smallgrey_10"><?=date("l, jS M, Y");?></span> </strong>
</TD>
</TR>
<TR bgcolor="#FFFFFF">
<TD height="22" colspan="2" align=middle class=normalbrown></TD>
</TR>

<!--MANAGE Atheletes BEGIN-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Athletes</TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADAthleteList.php" class="linkgrey_12">
<strong>View Athletes</strong></A></TD>
</TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADAtheleteStateList.php" class="linkgrey_12"><strong>View Athlete Stats</strong></A></TD>
</TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADAthleteCatagoryAdd.php" class="linkgrey_12">
<strong>Add Stats Category</strong></A></TD>
</TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADAthleteCatagoryList.php" class="linkgrey_12">
<strong>View Stats Category</strong></A></TD>
</TR>	
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADAthleteClassList.php" class="linkgrey_12">
<strong>View Class Category</strong></A></TD>
</TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADAthleteClassAdd.php" class="linkgrey_12">
<strong>Add Class Category</strong></A></TD>
</TR>
<!--MANAGE Atheletes EMD -->




<!--MANAGE Messageing BEGIN-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Messages System</TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADMessageList.php" class="linkgrey_12">
<strong>View Messages</strong></A></TD>
</TR>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADBlockMessage.php" class="linkgrey_12">
<strong>Add Block Messages</strong></A></TD>
</TR>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADBlockMessageList.php" class="linkgrey_12">
<strong>List Block Messages</strong></A></TD>
</TR>




<!--MANAGE Sport BEGIN-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Sports</TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSportAdd.php" class="linkgrey_12">
<strong>
Add Sports</strong></A></TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSportList.php" class="linkgrey_12"><strong>View Sports</strong></A></TD>
</TR>	
<!--MANAGE sport EMD -->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage HS / AAU Team</TD>
</TR>
<?php if($lnb == 'o') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSchoolAdd.php" class="linkgrey_12">
<strong>
Add HS / AAU Team</strong></A></TD>
</TR>
<?php if($lnb == 'o') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSchoolList.php" class="linkgrey_12"><strong>View HS / AAU Team</strong></A></TD>
</TR>
<?php if($lnb == 'o') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="HsAauOtherList.php" class="linkgrey_12"><strong>View HS / AAU Team Other</strong></A></TD>
</TR>
<!--MANAGE Coach BEGIN-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage HS / AAU Coach </TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADCoachAdd.php" class="linkgrey_12">
<strong>
Add HS / AAU Coach</strong></A></TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADCoachList.php" class="linkgrey_12"><strong>View HS / AAU Coach</strong></A></TD>
</TR>	
<!--MANAGE coach EMD -->


<!--MANAGE School BEGIN-->

<!--MANAGE School EMD -->

<!--MANAGE School BEGIN-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage College Coach</TD>
</TR>
<?php if($lnb == 'o') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>


<?php if($lnb == 'o') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADCollegeCoachList.php" class="linkgrey_12"><strong>View Colleges Coach</strong></A></TD>
</TR>
<!--MANAGE School EMD -->


<!--MANAGE TEAM BEGIN-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage College </TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADCollege.php" class="linkgrey_12">
<strong>
Add College </strong></A></TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADListCollege.php" class="linkgrey_12"><strong>View College </strong></A></TD>
</TR>	
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADListOther.php" class="linkgrey_12"><strong>View Other College List </strong></A></TD>
</TR>	

<!--MANAGE TEAM EMD -->
<!--MANAGE Event BEGIN-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Event</TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADEvent.php" class="linkgrey_12">
<strong>
Add Event</strong></A></TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADEventList.php" class="linkgrey_12"><strong>View Event</strong></A></TD>
</TR>	
<!-- START SPECIAL EVENT -->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Special Event</TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSpecialEvent.php" class="linkgrey_12">
<strong>
Add Special Event</strong></A></TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSpecialEventList.php" class="linkgrey_12"><strong>View Special Event</strong></A></TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSpecialEventRegisterList.php" class="linkgrey_12"><strong>View Special Event Registration</strong></A></TD>
</TR>
<!--transportation-->
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADTransportation.php" class="linkgrey_12"><strong>Add Transportation</strong></A></TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADTransportationManage.php" class="linkgrey_12"><strong>View Transportation</strong></A></TD>
</TR>
<!--coupon-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Coupon</TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADCoupon.php" class="linkgrey_12">
<strong>
Add Coupon</strong></A></TD>
</TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADCouponManage.php" class="linkgrey_12">
<strong>
View Coupon</strong></A></TD>
</TR>

<!--end coupon-->
<!-- END SPECIAL EVENT -->

<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Subsription</TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>

<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSubsription.php" class="linkgrey_12">
<strong>
Add Subsription</strong></A></TD>
</TR>
<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADSubsriptionList.php" class="linkgrey_12"><strong>View Subsription</strong></A></TD>
</TR>	

<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Static Page</TD>
</TR>

<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADPage.php" class="linkgrey_12"><strong>Add Static Page</strong></A></TD>
</TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADPageList.php" class="linkgrey_12"><strong>View Static Page</strong></A></TD>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADHomeContentList.php" class="linkgrey_12"><strong>View Home Content</strong></A></TD>
</TR>
</TR>
<!--
Manage Home page Conten-->

<!--Mange Banner-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Banner</TD>
</TR>

<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADBanner.php" class="linkgrey_12"><strong>Add Banner</strong></A></TD>
</TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADBannerList.php" class="linkgrey_12"><strong>View Banner</strong></A></TD>
</TR>

<!--Mange Notes-->
<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Manage Notes</TD>
</TR>

<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADNotes.php" class="linkgrey_12"><strong>Add Notes</strong></A></TD>
</TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADNotesList.php" class="linkgrey_12"><strong>View Notes</strong></A></TD>
</TR>

<TR>
<TD align="center" bgColor=#808080 class=normalwhite_12>&nbsp;</TD>
<TD height=22 align="left" bgColor=#808080 class=normalwhite_12>Miscellaneous</TD>
</TR>

<?php if($lnb == '0') $s_image = "images/spacer.gif"; else $s_image = "images/spacer.gif"; ?>
<TR>
<TD bgColor=#ffffff class="normalwhite_12" align=right><img src="<?=$s_image?>" width="5" height="9" border="0"></img></TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADChangePassword.php" class="linkgrey_12"><strong>Change Password</strong></A></TD>
</TR>
<TR bgColor=#ffffff class="normalwhite_12"><TD>&nbsp;</TD><td><hr size="1"></TD></TR>
<TR>
<TD bgColor=#ffffff class="normalwhite_12">&nbsp;</TD>
<TD height=22 bgColor=#ffffff class="normalwhite_12"><A href="ADlogout.php" class="linkgrey_12"><img src="images/spacer.gif" border="0"></img><strong> Logout</strong></A></TD>
</TR>


<!--MANAGE MICELLANEOUS EMD -->
</TABLE>
</td>
</tr>
</table>