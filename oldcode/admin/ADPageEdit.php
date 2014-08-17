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
$fldPageId = $_GET['fldPageId'];

if($_GET['mode']=='edit' AND $fldPageId!=""){
	#get the records
	$query =" Select * from ".TBL_PAGE. " where fldPageId = '$fldPageId' ";
	

	$db->query($query);
	$db->next_record();
	if($db->num_rows()>0){
		$db->query($query);
		$db->next_record();
		$fldPageTitle              = $db->f('fldPageTitle');
		$fldPageDescraption        = $db->f('fldPageDescraption');
		$fldPageMetaTitle          = $db->f('fldPageMetaTitle');
		$fldPageMetaDescraption    = $db->f('fldPageMetaDescraption');
		$fldPageMetaKeyword        = $db->f('fldPageMetaKeyword');
		$fldPageStatus             = $db->f('fldPageStatus');

		
	}
}
else {
	    $fldPageTitle              = "";
		$fldPageDescraption        = "";
		$fldPageMetaTitle          = "";
		$fldPageMetaDescraption    = "";
		$fldPageMetaKeyword        = "";
		$fldPageStatus             = "";

}
if($_POST['isSubmit']=='save'){
	
	$where = "fldPageId='".$fldPageId."'";
        			//Update data
		$strDataArr=array(
		    'fldPageDescraption' 			=> $func->input_fun($_POST['fldPageDescraption']),
			'fldPageMetaTitle' 				=> $func->input_fun($_POST['fldPageMetaTitle']),
			'fldPageMetaDescraption' 		=> $func->input_fun($_POST['fldPageMetaDescraption']),
			'fldPageMetaKeyword' 			=> $func->input_fun($_POST['fldPageMetaKeyword']),
			'fldPageAddedDate' 				=> date("d-y-m"),
            'fldPageStatus' 				=> $func->input_fun($_POST['fldPageStatus']));

			$db->updateRec(TBL_PAGE,$strDataArr, $where);
			
			header("Location: ADPageList.php?page=".$_REQUEST['page']."&msg=Page Updated Successfully!");
		
	

	if($error_msg!=""){
		
		$fldPageTitle            = $_REQUEST['fldPageTitle'];
		$fldPageDescraption      = $_REQUEST['fldPageDescraption'];
		$fldPageMetaTitle        = $_REQUEST['fldPageMetaTitle'];
		$fldPageMetaDescraption  = $_REQUEST['fldPageMetaDescraption'];
		$fldPageMetaKeyword      = $_REQUEST['fldPageMetaKeyword'];
		$fldPageStatus           = $_REQUEST['fldPageStatus'];

	}
}



?>

<script language="JavaScript" type="text/JavaScript">

function validate(){
	var error_msg = "";
	//var blnResult = true;

    if(trimString(document.frmPage.fldPageTitle.value) == ""){
		error_msg += "Please Enter Page Title! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmPage.fldPageTitle.value)){
			error_msg += "Enter valid  Page Title! \n";
		}
	}

	if(trimString(document.frmPage.fldPageDescraption.value) == ""){
		error_msg += "Please Enter Page Detail! \n";
	}
	

	if(trimString(document.frmPage.fldPageMetaKeyword.value) == ""){
		error_msg += "Please select status! \n";
	}	
	
	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}





</script>
<HTML><HEAD><TITLE>Add User Info</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js">
</script>
<script language="Javascript" src="../javascript/functions.js">
</script>
<script type="text/javascript" src="../javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        // General options
		        

        mode : "textareas",
        theme : "advanced",
        editor_selector :"txt",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect",
        
        theme_advanced_buttons2 : ",fontsizeselect,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo|link,unlink,anchor,image,cleanup,help,code",
         theme_advanced_buttons3 : "|,insertdate,inserttime,preview,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,visualaid",
         theme_advanced_buttons4 : "sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons5 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
       

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }

});
</script>
<script type="text/css">
.txt{
	
}
</script>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginheight="0" marginwidth="0"  >
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
			<form name="frmPage" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#808080" style="border-collapse:collapse"> 
			<tr height="20">
			<td align="center" class="normalblack_12" width="90%" valign="top" >
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
			<!-- Display the message on heading of the page -->
			<td valign="top" class="normalwhite_14" colspan="4" bgcolor="#808080" align="center">
				<b>Edit Content For Static Page</b>
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
			<td height="35" colspan="3" align="right" class="normalblack_12"><FONT color="Red">Fields marked with * are mandatory&nbsp;</FONT></td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>		
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="20%">Page Title<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > :&nbsp; </td>
			<td valign="top" align="left" class="normalblack_12"  colspan=2> 
			
			<input type="text" name="fldPageTitle" id="fldPageTitle" value="<?=$fldPageTitle?>" maxlength="10" style="width: 220px;" readonly>
			</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=4 align="center">
			&nbsp;
			</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="20%">Page Detail<font color="red">*</font> </td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<textarea name="fldPageDescraption" id="fldPageDescraption" value="<?=$fldPageDescraption?>" rows="10" cols="15"  style="width: 220px;" class="txt">
             <?=$fldPageDescraption?></textarea>
            
             </td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
						</tr>
						<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="20%">Status<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <select name="fldPageStatus" style="width: 220px;font-size:12px;">
			<option value="" <?if($fldPageStatus==''){ echo "selected"; }?>>---Select---</option>
			<option value=1 <?if($fldPageStatus==1){ echo "selected"; }?>>ACTIVE</option>
			<option value=0 <?if($fldPageStatus==0){ echo "selected"; }?>>DE-ACTIVE</option>
			</select></td>
			</tr>
				<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
						</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="20%">Meta Title<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 
			<input type="text" name="fldPageMetaTitle" value="<?=$fldPageMetaTitle?>" maxlength="1000" style="width: 220px;">
			
</td>
			</tr>
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="20%">Meta Descraption<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> 			<textarea name="fldPageMetaDescraption" id="fldPageMetaDescraption" value="<?=$fldPageMetaDescraption?>" rows="5" cols="15"  style="width: 220px;"
             onKeyDown="textCounter(document.frmPage.fldPageMetaDescraption,document.frmPage.remLen2,100000)"
             onKeyUp="textCounter(document.frmPage.fldPageMetaDescraption,document.frmPage.remLen2,100000)"><?=$func->output_fun($fldPageMetaDescraption);?></textarea>
             
			</td>
			</tr>
			<tr height="20">
			<td align="center" valign="top" colspan="3" class="normalwhite_14">
			&nbsp;
			</td>
			</tr>	
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="20%">Meta Keyword<font color="red"></font></td>
			<td valign="top"  align="center" class="normalblack_12" > : </td>
			<td valign="top" align="left" class="normalblack_12"> <input type="text" name="fldPageMetaKeyword" value="<?=$fldPageMetaKeyword?>" maxlength="1000" style="width: 220px;"></td>
			</tr>
			
			
			<tr height="20">
			<td align="center" valign="top" colspan="3" class="normalwhite_14">
			&nbsp;
			</td>
			</tr>	
			
			<tr height="20">
			<td valign="top" class="normalwhite_14" colspan=3 align="center">
			&nbsp;
			</td>
			</tr>
			
			
			
			
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" > &nbsp;</td>
			</tr>
			
			<tr height="20">
			<td valign="top" align="right" class="normalblack_12" width="20%">&nbsp</td>
			<td valign="top"  align="center" class="normalblack_12" > &nbsp</td>
			<td valign="top" align="left" class="normalblack_12">
			<input type="hidden" name="isSubmit" value="save">
			<input type="submit" name="submit" value="Submit">&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"></td>
			</tr>
			
			<tr height="20">				
			<td valign="top" colspan=3 align="center" class="normalblack_12" > &nbsp;</td>
			</tr>
			
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