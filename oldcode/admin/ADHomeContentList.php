<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Sanjay Chaudhary
##	Page name	:		ADPageList.php
##	Create Date	:		13/06/2011
##  Description :		It is use to show the listig of Page.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("../inc/common_functions.php");		//for common function
include_once("../inc/page.inc.php");				//for paging
include("include/ADsessionAdmin.php");				// for admin login

$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$page=new Page();	//Create an instance of class Pate
$lnb = "2";
$error_msg = '';

//$searchname=$_REQUEST['hidVal'];
$srchCond='';
if(!$searchname){
$searchname=$_REQUEST['searchname'];
}
$searchname = addslashes($searchname);
if(strlen($searchname)>0)
{   $queryString="searchname=$searchname";
	$srchCond= "AND fldTitle like '%".$searchname."%'";
}




if($_REQUEST['mode']=="del")
{
	$fldId=$_REQUEST['fldId'];
	$delete_query_details = "delete from ".TBL_HOME_CONTENT." where fldId='".$fldId."'";
	$delmsg = $db->query($delete_query_details);
	if(isset($delmsg)){
		$_REQUEST['msg']= "Content Deleted Successfully!";
		$count=$func->totalRows(TBL_HOME_CONTENT);
		$offset=$_REQUEST['page']*10;
		if($count<=$offset)
		{
			$offset=$offset-$count;
			$_REQUEST['page'] =$offset/10;
		}
	}
}

if($_REQUEST['mode']=="delAll"){
	
	for($i=0;$i<count($_POST['check_delete']);$i++)
		
		
	$delete_query_details = "delete from ".TBL_HOME_CONTENT." where fldId='".$_POST['check_delete'][$i]."'";
		$delmsg = $db->query($delete_query_details);
	
	if(isset($delmsg)){
		$_REQUEST['msg']= "Content Deleted Successfully!";
		$count=$func->totalRows(TBL_HOME_CONTENT);
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
<HTML><HEAD><TITLE>Home Page Content</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

function deleteRecord(fldId,page) {
	
	if( confirm("Are you sure to delete the Content?")) {
		document.frmPage.action="?mode=del&fldId="+fldId+"&page="+page;
		document.frmPage.submit();
	}
}

function changeStatus(toStatus,id,page){

	document.frmPage.action="?mode=changeStatus&st="+toStatus+"&fldId="+fldId+"&page="+page;
	document.frmPage.submit();
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
		if( confirm("Are you sure to delete the selected Content?")) {
			document.frmPage.action="?mode=delAll";
			document.frmPage.submit();
			return true;
		}
		return false;
	}else{
		alert("Please select at least one Content to delete");
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
							<tr><td align="center" class="normalwhite_14"  colspan="10" bgcolor="#808080">
							<strong>Home Page Content</strong> </td></tr>
							
							<tr><td align='center' class='normalblack_12'  colspan='10' height='30' valign='middle'><font color='red'><? if($_REQUEST['msg']!=""){echo $_REQUEST['msg'];}else { echo " ";}?></font></td></tr>
							
							<form name="frmPage" action="" method="post" onsubmit="">
						<?
						if(!$searchname){
						$query =" Select * from ".TBL_HOME_CONTENT; }else{
						$query ="Select * from ".TBL_HOME_CONTENT." where 1=1 ".$srchCond;
						}
						
						$db->query($query);
						$db->next_record();

						$totalPages = $db->num_rows();
						if($totalPages>0){
						
							
						}

						#Code for paging
						$page->set_page_data('',$db->num_rows(),100,5,true,false,true);
						$page->set_qry_string($queryString);
						
						$query = $page->get_limit_query($query); //return the query with limits
						
						$db->query($query);
						$db->next_record();


						if ($db->num_rows()>0) {#check for record availability

						echo '<tr>
							   		<td align="left" class="normalblack_12" width="8%">&nbsp;<strong>S.No.</strong></td>
							   		
							   		
									<td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Title</strong></td>
                                   ';
							   		
									 
							   		echo '<td class="normalblack_12" width="5%" align="center"><strong>Edit</strong></td>';
									
							   		//echo '<td class="normalblack_12" width="7%" align="center"><strong>Delete</strong></td>';	
								//echo '<td class="normalblack_12" width="7%" align="center"><strong>View</strong></td>';		
									
									
									echo '</tr>';
						$count="1";
						for ($i=0;$i<$db->num_rows();$i++) {
							
							

							$fldId               = $func->output_fun($db->f('fldId'));
							$fldTitle           = $func->output_fun($db->f('fldTitle'));
														
							$pageURL            = "ADHomeContentDetails.php?fldId=$fldId";
							$detailsWindowTitle = "Home Page Content";

							echo '<tr>';
									
									
									
									echo '<td align="left" class="normalblack_12">&nbsp;'.($count+($_REQUEST['page']*10)).'</td>';
									echo '
									
									
									<td align="left" class="normalblack_12" >'.wordwrap($fldTitle,17,"\n",true).'</td>
									';
							   		
							   		echo '<td class="normalblack_12" align="center"><a href="ADHomeContentEdit.php?mode=edit&fldId='.$db->f('fldId').'&page='.$pageno.'"><img src="images/b_edit.png" border="0" title="Edit"></a></td>';
									
							   		
							   										
							   		echo '</tr>';
                            $db->next_record();
							$count++;
						}
						#show pagination
						echo '<tr><td align="right" class="normalblack_12" colspan="10">';
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