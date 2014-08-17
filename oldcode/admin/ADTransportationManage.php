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
$tbl_transportation_discount='tbl_transportation_discount';
$event_id=$_REQUEST['fldEventId'];
$id=$_REQUEST['id'];
$srchCond='';
/*if(!$searchname){
$searchname=$_REQUEST['searchname'];
}
$searchname = addslashes($searchname);
if(strlen($searchname)>0)
{   $queryString="searchname=$searchname";
	$srchCond= "AND fldEventName like '%".$searchname."%'";
}
*/




if($_REQUEST['mode']=="del")
{
	$id=$_REQUEST['id'];
	$delete_query_details = "delete from ".$tbl_transportation_discount." where id=".$id;
	$delmsg = $db->query($delete_query_details);
	if(isset($delmsg)){
		$_REQUEST['msg']= "Transportation Discount Deleted Successfully!";
		$count=$func->totalRows($tbl_transportation_discount);
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
	
		
	 $delete_query_details = "delete from ".$tbl_transportation_discount." where id=".$_POST['check_delete'][$i];
		$delmsg = $db->query($delete_query_details);
	}
	if(isset($delmsg)){
		$_REQUEST['msg']= "Transportation Discount Deleted Successfully!";
		$count=$func->totalRows($tbl_transportation_discount);
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
<HTML><HEAD><TITLE>Transportation Discount Listing</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

function deleteRecord(fldEventId,page) {
	
	if( confirm("Are you sure to delete the Transportation Discount?")) {
		document.frmCatagory.action="?mode=del&id="+fldEventId+"&page="+page;
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
		if( confirm("Are you sure to delete the selected Transportation Discount?")) {
			document.frmCatagory.action="?mode=delAll";
			document.frmCatagory.submit();
			return true;
		}
		return false;
	}else{
		alert("Please select at least one Transportation Discount to delete");
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
				<?php include "include/ADmenu.php";?>
				</TD>
				<TD valign=top width=1%>&nbsp;
				
				</TD>
				<TD width=10><img src="spacer.gif" height="1" width="1"></TD>
				<TD valign=top width="">
				
 				
				<!--Main Center Content BEGIN -->
						
						<table border="1" cellpadding="1" cellspacing="0" width="100%" bordercolor="#808080" style="border-collapse:collapse" class="tablePadd"> 
							<tr><td align="center" class="normalwhite_14"  colspan="10" bgcolor="#808080">
							<strong>Transportation Discount Detail Listing</strong> </td></tr>
							
							<tr><td align='center' class='normalblack_12'  colspan='10' height='30' valign='middle'><font color='red'><? if($_REQUEST['msg']!=""){echo $_REQUEST['msg'];}else { echo " ";}?></font></td></tr>
							<!--<tr><td align='center' class='normalblack_12'  colspan='10' height='30' valign='middle'><form name="searchFrm" id="searchFrm" action="<? echo $PHP_SELF;?>"  method="POST">
				
				<input type="hidden" name="page" id="page" value="0">
							<input type="text" name="searchname" id="searchname">
							<input type="submit"  name="search" id="search" style="width:180px" value="Search Event by name">
							</form></td></tr>-->
						<form name="frmCatagory" action="" method="post" onSubmit="">
						<?php
						/*if(!$searchname){
						$query =" Select * from ".; }else{*/
						if(isset($event_id) && $event_id!="")
						{
						$query ="Select * from ".$tbl_transportation_discount." where id='".$event_id."'";
						}
						else
						{
						$query ="Select * from ".$tbl_transportation_discount."";
						}
						//}
						
						$db->query($query);
						$db->next_record();

						$totalPages = $db->num_rows();
						if($totalPages>0){
						
								?>
								<tr> <td align="left" style="padding-left:7px;"colspan="10"><input type="checkbox" id="check_all" name="check_all" value="" onClick="javascript:checkAll();"> <b>Check All</b>&nbsp; &nbsp;<input type="button" name="delete" value="Delete Selected" onClick="return submitDeleteAll();"></td></tr>
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
									<td align="left" class="normalblack_12" width="35%">&nbsp;<strong>Departure City</strong></td>
									<td align="left" class="normalblack_12" width="10%">&nbsp;<strong>Departure Time</strong></td>
									<td align="left" class="normalblack_12" width="10%">&nbsp;<strong>Transportation Charge</strong></td>';
							   		
									 
							   		echo '<td class="normalblack_12" width="5%" align="center"><strong>Edit</strong></td>';
									
							   		echo '<td class="normalblack_12" width="7%" align="center"><strong>Delete</strong></td>';	
							   	/*	echo '<td class="normalblack_12" width="7%" align="center"><strong>Details</strong></td>';*/
									
									
									
									echo '</tr>';
						$count="1";
						for ($i=0;$i<$db->num_rows();$i++) {
							
							

							$id               	= $func->output_fun($db->f('id'));
							$Event_id         	= $func->output_fun($db->f('Event_id'));
							$Diparture_City  	= $func->output_fun($db->f('Diparture_City'));
							$Departure_Time  	= $func->output_fun($db->f('Departure_Time'));
							$Transportation_charge = $func->output_fun($db->f('Transportation_charge'));		
							$status 			= $func->output_fun($db->f('status'));							
							$pageURL            = "ADTransportation.php?id=$id";
							$detailsWindowTitle = "Admin Transportation Discount";


							echo '<tr><td align="center" class="normalblack_12">&nbsp;';
									
									echo '<input type="checkbox" id="check_delete[]" name="check_delete[]" value="'.$id.'" onclick="return checkItSelf();">';
									
									echo '<td align="left" class="normalblack_12">&nbsp;'.($count+($_REQUEST['page']*10)).'</td>';
									echo '
									
									
									<td align="left" class="normalblack_12" >'.wordwrap($Diparture_City,17,"\n",true).'</td>
									<td align="left" class="normalblack_12" >'.wordwrap($Departure_Time,17,"\n",true).'</td>
									<td align="left" class="normalblack_12" >'.wordwrap($Transportation_charge,17,"\n",true).'</td>';
							   		
							   		echo '<td class="normalblack_12" align="center"><a href="ADTransportationEdit.php?mode=edit&id='.$id.'&page='.$pageno.'"><img src="images/b_edit.png" border="0" title="Edit"></a></td>';
									
							   		echo ' <td  class="normalblack_12" align="center"><a href="javascript:deleteRecord(\''.$id.'\','.$pageno.')"><img src="images/b_drop.png" border="0" title="Delete"></a></td>';
									
							   /*	echo '<td  class="normalblack_12" align="center"><a href="javascript:ShowDetails(\''.$pageURL.'\',\''.$detailsWindowTitle.'\')">View</a></td>';	*/								
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
						echo '';
							?>
							</form></table>
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