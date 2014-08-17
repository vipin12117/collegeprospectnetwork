<?php
##******************************************************************
##  Project     :       Sport Social Networking - Admin Panel
##  Done by     :       Sanjay Chaudhary
##  Page name   :       ADPageList.php
##  Create Date :       13/06/2011
##  Description :       It is use to show the listig of Page.
##  Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("inc/common_functions.php");        //for common function
include_once("inc/page.inc.php");                //for paging
#include("include/ADsessionAdmin.php");              // for admin login

$func = new COMMONFUNC; //Create an instance of class COMMONFUNC
$page=new Page();   //Create an instance of class Pate
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
    $srchCond= "AND fldPageTitle like '%".$searchname."%'";
}


##****************Admin Rights Check******************************
/*
$ADMIN_UID = $_SESSION['ADMIN_UID'];
$query =" Select fld_add, fld_edit, fld_delete, fld_view from ".TBL_MODULE_RIGHTS." where fld_module_idFK='2' AND fld_user_idFK='$ADMIN_UID'";
$db1->query($query);
$db1->next_record();
if($db1->num_rows()>0){
$fadd     = $db1->f('fld_add');
$fedit    = $db1->f('fld_edit');
$fdelete  = $db1->f('fld_delete');
$fview    = $db1->f('fld_view');
}
*/
##******************************************************************


if($_REQUEST['mode']=="del")
{
    $fldId=$_REQUEST['fldId'];
    $delete_query_details = "delete from ".TBL_ATHELETE_STAT." where fldId='".$fldId."'";
    $delmsg = $db->query($delete_query_details);
    if(isset($delmsg)){
        $_REQUEST['msg']= "Athlete Stat Deleted Successfully!";
        $count=$func->totalRows(TBL_ATHELETE_STAT);
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
        //print_r($fldPageId);
//print_r($k);
{
    $delete_query_details = "delete from ".TBL_ATHELETE_STAT." where fldId='".$_POST['check_delete'][$i]."'";
        $delmsg = $db->query($delete_query_details);
    
    if(isset($delmsg)){
        $_REQUEST['msg']= "Athlete Stat Deleted Successfully!";
        $count=$func->totalRows(TBL_ATHELETE_STAT);
        $offset=$_REQUEST['page']*10;
        if($count<=$offset)
        {
            $offset=$offset-$count;
            $_REQUEST['page'] =$offset/10;
        }
    }
}
}

/*if($_REQUEST['mode']=="changeStatus"){
    if($_REQUEST['st']=='A'){
        $userId = $_REQUEST['userId'];
        $where = "fld_user_idPK='$userId'";
        $strDataArr=array(
        'fld_user_status'        => 'A'
        );
        $actmsg = $db->updateRec(TBL_USER_PROFILE,$strDataArr, $where);

        if(isset($actmsg)){
            $_REQUEST['msg']= "User Activated Successfully!";
        }
    }
    if($_REQUEST['st']=='D'){
        $userId = $_REQUEST['userId'];
        $where = "fld_user_idPK='$userId'";
        $strDataArr=array(
        'fld_user_status'        => 'D'
        );
        $actmsg = $db->updateRec(TBL_USER_PROFILE,$strDataArr, $where);

        if(isset($actmsg)){
            $_REQUEST['msg']= "User Deactivated Successfully!";
        }
    }
}
*/


if($_REQUEST['page']==''){$pageno='0';}else{$pageno=$_REQUEST['page'];}
?>
<HTML><HEAD><TITLE>Page Listing</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="Javascript" src="../javascript/functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

function deleteRecord(fldId,page) {
    
    if( confirm("Are you sure to delete the Athlete Stat?")) {
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
        if( confirm("Are you sure to delete the selected Athlete Stat?")) {
            document.frmPage.action="?mode=delAll";
            document.frmPage.submit();
            return true;
        }
        return false;
    }else{
        alert("Please select at least one Athlete to delete");
        return false;
    }

}
function searchTxt(){
        
    //var searchVal=document.getElementById('keyword').value;
    
    //document.getElementById('searchname').value=searchVal;
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
                            <strong>Athlete Stat Listing</strong> </td></tr>
                            
                            <tr><td align='center' class='normalblack_12'  colspan='10' height='30' valign='middle'><font color='red'><? if($_REQUEST['msg']!=""){echo $_REQUEST['msg'];}else { echo " ";}?></font></td></tr>
                            
                            <form name="frmPage" action="" method="post" onsubmit="">
                        <?
                        
                        $query =" Select * from ".TBL_ATHELETE_STAT; 
                        $db->query($query);
                        $db->next_record();

                        $totalPages = $db->num_rows();
                        if($totalPages>0){
                        
                                ?>
                                <tr> <td align="left" style="padding-left:7px;"colspan="10"><input type="checkbox" id="check_all" name="check_all" value="" onclick="javascript:checkAll();"> <b>Check All</b>&nbsp; &nbsp;<input type="button" name="delete" value="Delete Selected" onclick="return submitDeleteAll();"></td></tr>
                                <?php
                        }

                        #Code for paging
                        $page->set_page_data('',$db->num_rows(),10,5,true,false,true);
                        $page->set_qry_string($queryString);
                        
                        $query = $page->get_limit_query($query); //return the query with limits
                        //echo $query;
                        //echo $queryString;
                        $db->query($query);
                        $db->next_record();


                        if ($db->num_rows()>0) {#check for record availability

                        echo '<tr><td align="center" class="normalblack_12" width="4%">&nbsp;</td>
                                    <td align="left" class="normalblack_12" width="8%">&nbsp;<strong>S.No.</strong></td>
                                    
                                    
                                    <td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Athelete Name</strong></td>
                                    <td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Programe Name</strong></td>
                                    <td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Stat type</strong></td>
                                    <td align="left" class="normalblack_12" width="25%">&nbsp;<strong>Status</strong></td>
                                   ';
                                    
                                     
                                    echo '<td class="normalblack_12" width="5%" align="center"><strong>Edit</strong></td>';
                                    
                                    echo '<td class="normalblack_12" width="7%" align="center"><strong>Delete</strong></td>';   
                                    
                                    
                                    
                                    echo '</tr>';
                        $count="1";
                        
                        for ($i=0;$i<$db->num_rows();$i++) {
                            
                            

                            $fldId               = $func->output_fun($db->f('fldId'));
                            $fldAtheleteId       = $func->output_fun($db->f('fldAtheleteId'));
                            $fldPerformanceType=$func->output_fun($db->f('fldPerformanceType'));
                            $fldPrograme=$db->f('fldPrograme');
                            $fldStatus=$db->f('fldStatus');
                            $query_Athlete1 =" Select * from ".TBL_ATHELETE_REGISTER. " where fldId ='".$fldAtheleteId."'";
                            $db1->query($query_Athlete1);
                            
                            $db1->next_record();
                            
                            $db2->query(" Select * from ".TBL_EVENT. " where fldEventId ='".$fldPrograme."'");
                            $db2->next_record();
                            $fldEventName=$db2->f('fldEventName');
                             $fldAthleteName           = $db1->f('fldUsername');                        
                                                        
                            $pageURL            = "ADAthleteStatDetails.php?fldId=$fldId";
                            $detailsWindowTitle = "AdminPageDetails";

                            /*if($userType=='H')     { $userType1='Hotel';}
                            elseif($userType=='T') { $userType1='Tourism';}
                            elseif($userType=='U') { $userType1='User';}
                            elseif($userType=='M') { $userType1='Moderator';}

                            if($regcode!='')     { $regcode1='Yes';} else { $regcode1='No'; }*/

                            echo '<tr><td align="center" class="normalblack_12">&nbsp;';
                                    
                                    echo '<input type="checkbox" id="check_delete[]" name="check_delete[]" value="'.$fldId.'">';
                                    
                                    echo '<td align="left" class="normalblack_12">&nbsp;'.($count+($_REQUEST['page']*10)).'</td>';
                                    echo '<td align="left" class="normalblack_12" >'.wordwrap($fldAthleteName,17,"\n",true).'</td>
                                    <td align="left" class="normalblack_12" >'.wordwrap($fldEventName,17,"\n",true).'</td>
                                    <td align="left" class="normalblack_12" >'.wordwrap($fldPerformanceType,17,"\n",true).'</td>
                                    ';
                                    if($fldStatus==1)
                                    {
                                        
                                    echo '<td align="left" class="normalblack_12" >Approve</td>
                                    ';
                                    }
                                    else
                                    {
                                        echo '<td align="left" class="normalblack_12" >Pending</td>
                                    ';
                                    }
                                    echo '<td class="normalblack_12" align="center"><a href="ADAthleteStatEdit.php?mode=edit&fldId='.$db->f('fldId').'&page='.$pageno.'"><img src="images/b_edit.png" border="0" title="Edit"></a></td>';
                                    
                                    echo ' <td  class="normalblack_12" align="center"><a href="javascript:deleteRecord(\''.$fldId.'\','.$pageno.')"><img src="images/b_drop.png" border="0" title="Delete"></a></td>';
                                    
                                                                    
                                    echo '</tr>';
                            $db->next_record();
                            $count++;
                        }
                        #show pagination
                        echo '<tr><td align="right" class="normalblack_12" colspan="10">';
                        $page->get_page_nav();
                        echo '</td></tr>';

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