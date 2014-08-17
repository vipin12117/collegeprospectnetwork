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


$srchCond='';
if(!$searchname){
$searchname=$_REQUEST['searchname'];
}
$searchname = addslashes($searchname);
if(strlen($searchname)>0)
{   $queryString="searchname=$searchname";
	$srchCond= "AND fldName like '%".$searchname."%'";
}




if($_REQUEST['mode']=="del")
{
	$fldId=$_REQUEST['fldId'];
	$query_child =" Select * from ".TBL_ATHLETE_STATS_CATAGORY. " where fldParentId =".$fldId;
	$db1->query($query_child);
	$db1->next_record();
	$db1->num_rows();
	if($db->num_rows()==0)
	{
	$delete_query_details = "delete from ".TBL_ATHLETE_STATS_CATAGORY." where fldId=".$fldId;
	
	$delmsg = $db1->query($delete_query_details);
	}
	else {
		?>
		<script type="text/javascript">
		alert("You have to delete its Subcategory first");
		</script>
		<?php
	}
	if(isset($delmsg)){
		$_REQUEST['msg']= "Category Deleted Successfully!";
		$count=$func->totalRows(TBL_ATHLETE_STATS_CATAGORY);
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
	{
		
	$query_child =" Select * from ".TBL_ATHLETE_STATS_CATAGORY. " where fldParentId =".$_POST['check_delete'][$i];
	$db1->query($query_child);
	$db1->next_record();
	$db1->num_rows();
	if($db1->num_rows()==0)
	{
	$delete_query_details = "delete from ".TBL_ATHLETE_STATS_CATAGORY." where fldId=".$_POST['check_delete'][$i];
	 $delmsg = $db1->query($delete_query_details);
	}
	else {
		?>
		<script type="text/javascript">
		alert("You have to delete <?php echo  $db1->f('fldName')."'s";?> Subcategory first ");
		</script>
		<?php
	}	
	 
	}
	if(isset($delmsg)){
		$_REQUEST['msg']= "Category Deleted Successfully!";
		$count=$func->totalRows(TBL_ATHLETE_STATS_CATAGORY);
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
<HTML><HEAD><TITLE>Catagories Listing</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

function deleteRecord(fldId,page) {
	
	if( confirm("Are you sure to delete the Stats Category? If any athletes use this category, Site will throw Errors for those users.  **YOU HAVE BEEN WARNED**")) {
		document.frmCatagory.action="?mode=del&fldId="+fldId+"&page="+page;
		document.frmCatagory.submit();
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
		if( confirm("Are you sure to delete the selected Category?")) {
			document.frmCatagory.action="?mode=delAll";
			document.frmCatagory.submit();
			return true;
		}
		return false;
	}else{
		alert("Please select at least one Category to delete");
		return false;
	}

}
function searchTxt(){
		
	
	document.searchFrm.submit();
	
}
function formsubmit(param)
	{
		window.location="ADAthleteCatagoryList.php?sportid="+param;
		
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
							<strong>Athlete Stats Categories Listing</strong> </td></tr>
							
							<tr><td align='center' class='normalblack_12'  colspan='10' height='30' valign='middle'><font color='red'><? if($_REQUEST['msg']!=""){echo $_REQUEST['msg'];}else { echo " ";}?></font></td></tr>
							<tr><td align='center' class='normalblack_12'  colspan='10' height='30' valign='middle'><form name="searchFrm" id="searchFrm" action="<? echo $PHP_SELF;?>"  method="POST">
				
				<input type="hidden" name="page" id="page" value="0">
							<input type="text" name="searchname" id="searchname">
							<input type="submit"  name="search" id="search" style="width:180px" value="Search Category By Name">
							</form></td></tr>
							<form name="frmCatagory" action="" method="post" onsubmit="">
						<?
						if(!$searchname){
						$query =" Select * from ".TBL_ATHLETE_STATS_CATAGORY." where fldStatus=1"; }else{
						$query ="Select * from ".TBL_ATHLETE_STATS_CATAGORY." where fldStatus=1  ".$srchCond;
						}
						if($_REQUEST['sportid']!=''){
						$srchCond1="AND fldParentId = ".$_REQUEST['sportid'];
						$query ="Select * from ".TBL_ATHLETE_STATS_CATAGORY." where 1=1 ".$srchCond1." ORDER BY fldName";
						}
						
						$db1->query($query);
						$db1->next_record();

						$totalPages = $db1->num_rows();
						if($totalPages>0){
						
								?>
								<tr> <td align="left" style="padding-left:7px;"colspan="10"><input type="checkbox" id="check_all" name="check_all" value="" onclick="javascript:checkAll();"> <b>Check All</b>&nbsp; &nbsp;<input type="button" name="delete" value="Delete Selected" onclick="return submitDeleteAll();"><?php echo '<select name="fldParentId" style="width:220px" onChange="javascript:return formsubmit(this.value);" ><option value="">Select Sport</option>';
									
										$sport_list=$func->selectTableOrder(TBL_SPORTS,"fldId,fldSportsname","fldId");
								for ($i=0;$i<count($sport_list);$i++) 
								{
									if($_REQUEST['sportid']==$sport_list[$i]['fldId'])	
									 	{
								echo '<option value ="'.$sport_list[$i]['fldId'].'" selected = "selected" >'.$sport_list[$i]['fldSportsname'].'</option>';
									 	}
									 	else
									 	{
									 		echo '<option value ="'.$sport_list[$i]['fldId'].'"  >'.$sport_list[$i]['fldSportsname'].'</option>';
									 	}
								}
								
								echo $strcombo = '</select>';
								?> 
								
								&nbsp;&nbsp;<a href="ADAthleteCatagoryAdd.php">Add New</a>
								
								</td>
								
								</tr>
								<?php
						}

						#Code for paging
						$page->set_page_data('',$db1->num_rows(),100,5,true,false,true);
						$page->set_qry_string($queryString);
						
						$query = $page->get_limit_query($query); //return the query with limits
						
						$db1->query($query);
						$db1->next_record();


						if ($db1->num_rows()>0) {#check for record availability

						echo '<tr><td align="center" class="normalblack_12" width="4%">&nbsp;</td>
							   		<td align="left" class="normalblack_12" width="8%">&nbsp;<strong>S.No.</strong></td>
									<td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Category Name</strong></td>
                                    <td align="left" class="normalblack_12" width="15%">&nbsp;<strong>Category (Initials)</strong></td>
                                   ';
							   		
									 
							   		echo '<td class="normalblack_12" width="5%" align="center"><strong>Edit</strong></td>';
									
							   		echo '<td class="normalblack_12" width="7%" align="center"><strong>Delete</strong></td>';	
							   		echo '<td class="normalblack_12" width="7%" align="center"><strong>View</strong></td>';	
									
									
									
									echo '</tr>';
						$count="1";
						for ($i=0;$i<$db1->num_rows();$i++) {
							
							

							$fldId               = $func->output_fun($db1->f('fldId'));
							$fldNameint           = $func->output_fun($db1->f('fldNameint'));
							$fldName           = $func->output_fun($db1->f('fldName'));
														
							$pageURL            = "ADAthleteCategoryDetails.php?fldId=$fldId";
							$detailsWindowTitle = "Details";

														echo '<tr><td align="center" class="normalblack_12">&nbsp;';
									
									echo '<input type="checkbox" id="check_delete[]" name="check_delete[]" value="'.$fldId.'" onclick="return checkItSelf();">';
									
									echo '<td align="left" class="normalblack_12">&nbsp;'.($count+($_REQUEST['page']*10)).'</td>';
									echo '
									<td align="left" class="normalblack_12" >'.wordwrap($fldName,17,"\n",true).'</td>
									
									<td align="left" class="normalblack_12" >'.wordwrap($fldNameint,17,"\n",true).'</td>
									';
							   		
							   		echo '<td class="normalblack_12" align="center"><a href="ADAthleteCatagoryEdit.php?mode=edit&fldId='.$db1->f('fldId').'&page='.$pageno.'"><img src="images/b_edit.png" border="0" title="Edit"></a></td>';
									
							   		echo ' <td  class="normalblack_12" align="center"><a href="javascript:deleteRecord(\''.$fldId.'\','.$pageno.')"><img src="images/b_drop.png" border="0" title="Delete"></a></td>';
									echo '<td class="normalblack_12" align="center"><a href="javascript:ShowDetailssmall(\''.$pageURL.'\',\''.$detailsWindowTitle.'\')">View</a></td>';
							   										
							   		echo '</tr>';
                            $db1->next_record();
							$count++;
						}
						#show pagination
						echo '<tr><td align="right" class="normalblack_12" colspan="10">';
						
						if($_REQUEST['sportid']!='')
						{
						$page->set_qry_string("sportid=".$_REQUEST['sportid']);
						
						}
						
							$page->get_page_nav();
						
						echo '&nbsp;</td></tr>';

						} else { #no record message comes here
						?>
						<tr> <td align="left" style="padding-left:7px;"colspan="10"><input type="checkbox" id="check_all" name="check_all" value="" onclick="javascript:checkAll();"> <b>Check All</b>&nbsp; &nbsp;<input type="button" name="delete" value="Delete Selected" onclick="return submitDeleteAll();"><?php echo '<select name="fldParentId" style="width:220px" onChange="javascript:return formsubmit(this.value);" ><option value="">Select Sport</option>';
									
										$sport_list=$func->selectTableOrder(TBL_SPORTS,"fldId,fldSportsname","fldId");
								for ($i=0;$i<count($sport_list);$i++) 
								{
									if($_REQUEST['sportid']==$sport_list[$i]['fldId'])	
									 	{
								echo '<option value ="'.$sport_list[$i]['fldId'].'" selected = "selected" >'.$sport_list[$i]['fldSportsname'].'</option>';
									 	}
									 	else
									 	{
									 		echo '<option value ="'.$sport_list[$i]['fldId'].'"  >'.$sport_list[$i]['fldSportsname'].'</option>';
									 	}
								}
								
								echo $strcombo = '</select>';
								?> </td>
								
								</tr>
						<?php
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
<? unset($func);  unset($page);   unset($db1); ?>
</TABLE>
</BODY>
</HTML>