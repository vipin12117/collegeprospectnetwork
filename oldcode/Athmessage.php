<?php
    ##******************************************************************
    ##  Project		:		Sport Social Networking - Admin Panel
    ##  Done by		:		Narendra Singh
    ##	Page name	:		Athmessage.php(Internal messaging Systems)
    ##	Create Date	:		17/07/2011
    ##  Description :		It is use to send,recieve,delete the  Messages.
    ##	Copyright   :       Synapse Communications Private Limited.
    ## *****************************************************************
    session_start();
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    //for paging
    include_once ("inc/config.inc.php");
    if ($_SESSION['FRONTEND_USER'] == "") {
        header("Location:login.php");
    }
    $func = new COMMONFUNC;
    $func2 = new COMMONFUNC;
    $db = new DB;
    $db3 = new DB;
    $page = new Page();
    

    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Messaging</title>
		<META NAME="Keywords" CONTENT="My Account">
		<META NAME="Description" CONTENT="My Account">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script type="text/javascript" src="javascript/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript">
           function setFocus() {
                  var replyForm = document.getElementById("replyfocus");
                  if (replyForm) {
                    replyForm["message"].focus();
                  }
                }
                
           function confirmDelete() {
               var agree = confirm("Are you sure you want to Send this message to trash?");
               if (agree) {
                    return true;                    
               }  
               else {
                   return false;
               }
           }
               
         function confirmDeletePermanent() {
               var agree = confirm("Are you sure you want to Permanently Delete this message? this cannot be undone.");
               if (agree) {
                    return true;                    
               }  
               else {
                   return false;
               }
           }
                
           function validate() {
                var error_msg = "";    
                
                //Check Values
                if(trimString(document.messageform.subject.value) == "") {
                    error_msg += "Please Enter Subject. \n";
                } else {
                    if(hasSpecialChars(document.messageform.subject.value)) {
                        error_msg += "Your Subject has special characters.  Please remove: ^, {, }, <, > \n";
                    }
                }              
                if(trimString(document.messageform.message.value) == "") {
                    error_msg += "Please Enter Message. \n";
                } else {
                    if(hasSpecialChars(document.messageform.message.value)) {
                        error_msg += "Your Message has special characters.  Please remove: ^, {, }, <, > \n";
                    }
                }
                               
                //Display Error
                if(error_msg != '') {
                    alert(error_msg);
                    return false;
                } else {
                    return true;
                }
            } 
            
		</script>
	</head>
	<body onload="setFocus();">
		<?php
            include ('header.php');
		?>
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
							<h1>Messaging</h1>
							<div class="registerPage messaging">
								<?php
                                    $username = $_SESSION['FRONTEND_USER'];
								?>
								<?php
                                    $query = "SELECT COUNT(*) as count from " . TBL_MAIL . "  WHERE UserTo='$username' and status='unread' and visible='ACTIVE'";
                                    $db -> query($query);
                                    $db -> next_record();
                                    $count = $func -> output_fun($db -> f('count'));
								?>
								<div style="margin-bottom:15px;" class="messagecenter">
									<?php
                                    if($count>0)
                                    {
									?>
									   <a href="Athmessage.php?action=inbox" <?php echo ($_REQUEST['action']== 'inbox' || $_REQUEST['action']=='' ? 'class="active"' : '') ?>>Inbox&nbsp;(<?php  echo $count;?>)</a>
									<?php
                                    }
                                    else
                                    {
									?>
									   <a href="Athmessage.php?action=inbox" <?php echo ($_REQUEST['action']== 'inbox' || $_REQUEST['action']=='' ? 'class="active"' : '') ?>>Inbox</a>																	
									<?
                                        }
									?>
									<a href="Athmessage.php?action=sentmessage" <?php echo ($_REQUEST['action']== 'sentmessage' ? 'class="active"' : '') ?>>Sent</a>
                                    <a href="Athmessage.php?action=trash" <?php echo ($_REQUEST['action']== 'trash' ? 'class="active"' : '') ?>>Trash</a>  
								</div>
								<?php if($_REQUEST['msg']) {
								?>
								<div class="thankyoumessage" style="margin-top:10px;">
									<?php  echo $_REQUEST['msg'];?>
								</div>
								<?php   }?>
								<?php
                            ////////////////////////////Beginning Compose/Recompose///////////////////////////////
                            $action    = $_REQUEST['action'];
                            $mail_id   = $_REQUEST['mail_id'];
                            $subject   = $_REQUEST['subject'];
                            $to        = $_REQUEST['to'];
                            $message   = str_replace('<p>',"",$_REQUEST['message']);
                            $message   = str_replace('</p>',"",$message);
                            $id        = $_REQUEST['id'];

                            if($_REQUEST['Usertypefrom']!='')
                            {
                            $value = $_REQUEST['Usertypefrom'];
                            }
                            else
                            {
                            $value     = $_REQUEST['value'];
                            }

                            ################# RESTORE #################
                            
                            
                            if($action==restore)
                            {
                                $curmailID = $_REQUEST['mailID'];
                                $rs = mysql_query("UPDATE ".TBL_MAIL." SET status='read' WHERE mail_id='$curmailID'");
                                $msg="Message successfully Moved to Inbox.";
                                echo "<script>document.location.href ='Athmessage.php?action=trash&msg=".$msg."';</script>";
                            }               
                            
                            ################# COMPOSE #################
                            if($action==compose)
                            {
                                
                            ##---SAVE MESSAGE---##
                            if($_POST['isSubmit']=='save')
                            {
                            if ($to=="")
                            {
                            $errmsg[]="Please select the Receiver (To)";
                            }
                            if($subject=="")
                            {
                            $errmsg[]="Please enter the Subject";
                            }
                            if($message=="")
                            {
                            $errmsg[]="Please enter the Message";
                            }
                            if (count($errmsg)>0)
                            {
                            foreach($errmsg as $key=>$value)
                            {
								?>
								<div class="thankyoumessage">
									<?php  echo $value . "<br>";?>
								</div>
								<?
                                    }
                                    }
                                    else
                                    {
                                    $date = date(YmdHis);
                                    $strDataArrw=array(
                                    'UserTo'        => $to,
                                    'UserFrom'      => $username,
                                    'Subject'       => $subject,
                                    'Message'       => $message,
                                    'SentDate'      => $date,
                                    'status'        => 'unread',
                                    'visible'       => 'ACTIVE',
                                    'Usertypeto'    => $value,
                                    'Usertypefrom'  => $_SESSION['mode']
                                    );
                                    $db->insertRec(TBL_MAIL,$strDataArrw);
								?>
								<div align="center">
									<?php
                                        $msg = "Message successfully sent.";
                                        echo "<script>document.location.href='Athmessage.php?action=inbox&msg=$msg'</script>";
									?>
								</div>
								<?php
                                    }
                                    }
                                    ### ---//END SAVE NEW MESSAGE//---###
                                    
                                    
                                    // BLOCK ATHLETE
                                    $date = date("Y-m-d");
                                    $athleteid = array();
                                    $query1 = "select * from ".TBL_BLOCK_MESSAGE." where fldFrom='".$_SESSION['mode']."' and fldTo = 'athlete'
                                    and fldStartDate <= '".$date."' and fldEndDate >= '".$date."'";
                                    $db1->query($query1);
                                    $db1->next_record();
                                    if ($db1->num_rows()>0)
                                    {
                                    for ($i=0;$i<$db1->num_rows();$i++)
                                    {
                                    $fldSportid = $func->output_fun($db1->f('fldSport'));
                                    $query = "select * from ".TBL_ATHELETE_REGISTER." where fldSport='".$fldSportid."'";
                                    $db->query($query);
                                    $db->next_record();
                                    if ($db->num_rows()>0)
                                    {
                                    for ($j=0;$j<$db->num_rows();$j++)
                                    {
                                    $athleteid[] = $func->output_fun($db->f('fldId'));
                                    $db->next_record();
                                    }
                                    }
                                    $db1->next_record();
                                    }
                                    }
                                    ///////////////////////////////////////////////////////////////////////////////////////////////////
                                    // BLOCK COACHES
                                    $date = date("Y-m-d");
                                    $coachid = array();
                                    $query3 = "select * from ".TBL_BLOCK_MESSAGE." where fldFrom='".$_SESSION['mode']."' and fldTo = 'coach'
                                    and fldStartDate <= '".$date."' and fldEndDate >= '".$date."'";
                                    $db->query($query3);
                                    $db->next_record();
                                    if ($db->num_rows()>0)
                                    {
                                    for ($i=0;$i<$db->num_rows();$i++)
                                    {
                                    $fldSportid = $func->output_fun($db->f('fldSport'));
                                    $query4 = "select * from tbl_hs_aau_coach where fldSport='".$fldSportid."'";
                                    $db1->query($query4);
                                    $db1->next_record();
                                    if ($db1->num_rows()>0)
                                    {
                                    for ($j=0;$j<$db1->num_rows();$j++)
                                    {
                                    $coachid[] = $func->output_fun($db1->f('fldId'));
                                    $db1->next_record();
                                    }
                                    }
                                    $db->next_record();
                                    }
                                    }
                                    
                                    
                                    ################# COMPOSE (reply and maybe forward, new) #############
                                    if($_REQUEST['to']!='')
                                    {
                                        
                                        ### INCLUDE Previous Email if applicable ###
                                        
                                        If ($_REQUEST['mailID']) {
                                            $mailid = $_REQUEST['mailID'];
                                            $selquery = "select Message from ". TBL_MAIL ." where mail_id='" . $mailid . "' ";        
                                            $db->query($selquery);
                                            $db->next_record();    
                                            $oldMessage = $func->output_fun($db->f('Message'));
                                            
                                           $message = "---------------------------------------------------------------<br>"; 
                                           $message = $message . $oldMessage;
                                        }
                                        $message = str_replace("<br>", "\n", $message); 
                                        $message = "\n\n\n" . $message;
                                        
                                        $too=str_replace("%"," ",$_REQUEST['to']);
                                        $to =  $_REQUEST['newfrom'];
                                        $subject=str_replace("%"," ",$_REQUEST['subject']);
                                        If ($_REQUEST['mailID']) {
                                            echo "<form name='messageform' id='replyfocus' action='' method=post onsubmit='return validate()'>";
                                        }
                                        else {
                                            echo "<form name='messageform' action='' method=post onsubmit='return validate()'>";
                                        }
                                        
                                        echo "<p><label>To:</label><span><input type=text name=too size=40 value='$too' class='displaynormal'><input type=hidden name=to size=40 value=$to></span></p>";
                                        echo "<p><label>Subject:</label><span><input type=text name=subject size=40 value='$subject'></span></p>";
                                        echo "<p><label>Message:</label><span><textarea name=message class=ta2>$message</textarea></span></p>";
                                        echo "<input type='hidden' name='isSubmit' value='save'>";
                                        echo "<p><label>&nbsp;</label><span><button type=submit onsubmit='' class='btn'>Send Message</button></span></p>";
                                        echo "</form>";                                       
                                    
                                    }
                                    else
                                    {
                                        
                                        
                                    if($_REQUEST['value']=='coach')
                                    {
                                        ##TO HS COACH##
                                    $query1 ="SELECT fldSport from ".TBL_ATHELETE_REGISTER."  WHERE fldUsername='".$username."'";
                                    $db1->query($query1);
                                    $db1->next_record();
                                    $fldSport = $func->output_fun($db1->f('fldSport'));
                                    
                                    if($_SESSION['mode']=='coach' || $_SESSION['mode']=='college' )
                                    {
                                    echo "<h2 style='padding-left:160px;'>Send Message to HS/AAU Coach</h2><br><form name='messageform' action='' method=post onsubmit='return validate()'>";
                                    echo "<p><label>To:</label><span>";
                                    echo $strcombo = '<select name="to" style="width:276px">';
                                    echo $strcombo = '<option value="">----- Please Select -----</option>';
                                   $coachlist=$func->selectTableOrder(TBL_HS_AAU_COACH,"fldId,fldName,fldLastName,fldUsername","fldLastName");
                                    }
                                    else
                                    {
                                    echo "<h2 style='padding-left:160px;'>Send Message to HS/AAU Coach</h2><br><form name='messageform' action='' method=post onsubmit='return validate()'>";
                                    echo "<p><label>To:</label><span>";
                                    echo $strcombo = '<select name="to" style="width:276px">';
                                    echo $strcombo = '<option value = "">----- Please Select -----</option>';
                                    $coachlist=$func->selectTableOrdergroupby("tbl_hs_aau_coach_sportposition cs, tbl_hs_aau_coach ac","fldId,fldName,fldLastName,fldUsername","ac.fldLastName","where ac.fldId = cs.fldCoachNameId and cs.fldSportId = ".$fldSport);
                                    }
                                    
                                    for ($i=0;$i<count($coachlist);$i++)
                                    {
                                    if(!in_array($coachlist[$i]['fldId'],$coachid))
                                    {
                                    if($_REQUEST['to'] == $coachlist[$i]['fldUsername'])
                                    {
                                    echo '<option value ="'.$coachlist[$i]['fldUsername'].'" selected="selected" >'.ucfirst($coachlist[$i]['fldLastName']).', '.ucfirst($coachlist[$i]['fldName']).'</option>';
                                    }
                                    else
                                    {
                                    echo '<option value ="'.$coachlist[$i]['fldUsername'].'">'.ucfirst($coachlist[$i]['fldLastName']).', '.ucfirst($coachlist[$i]['fldName']).'</option>';
                                    }
                                    }
                                    }
                                    echo $strcombo = '</select>';
                                    }
                                    else if($_REQUEST['value']=='athlete')
                                    {
                                        ##TO ATHLETE##
                                    echo "<h2 style='padding-left:160px;'>Send Message to an Athlete</h2><br><form name='messageform' action='' method=post onsubmit='return validate()'>";
                                    echo "<p><label>To:</label><span>";
                                    echo $strcombo = '<select name="to" style="width:276px">';
                                    echo $strcombo = '<option value = "">----- Please Select -----</option>';
                                    $categorylist=$func->selectTableOrder(tbl_athelete_register,"fldId,fldUsername,fldFirstname,fldLastname","fldLastname");
                                    for ($i=0;$i<count($categorylist);$i++)
                                    {
                                    if(!in_array($categorylist[$i]['fldId'],$athleteid))
                                    {
                                    if($_REQUEST['to'] == $categorylist[$i]['fldUsername'])
                                    {
                                    echo '<option value ="'.$categorylist[$i]['fldUsername'].'"selected="selected" >'.ucfirst($categorylist[$i]['fldLastname']).
                                    ', '.ucfirst($categorylist[$i]['fldFirstname']).'</option>';
                                    }
                                    else
                                    {
                                    echo '<option value ="'.$categorylist[$i]['fldUsername'].'" >'.ucfirst($categorylist[$i]['fldLastname']).
                                    ', '.ucfirst($categorylist[$i]['fldFirstname']).'</option>';
                                    }
                                    }
                                    }
                                    echo $strcombo = '</select>';
                                    }
                                    else if($_REQUEST['value']=='college')
                                    {
                                        ##TO COLLEGE##
                                    echo "<h2 style='padding-left:160px;'>Send Message to College Coach</h2><br><form name='messageform' action='' method=post onsubmit='return validate()'>";
                                    echo "<p><label>To:</label><span>";
                                    echo $strcombo = '<select name="to" style="width:276px">';
                                    echo $strcombo = '<option value = "">----- Please Select -----</option>';
                                    $collegelist=$func->selectTableOrder(TBL_COLLEGE_COACH_REGISTER,"fldId,fldFirstName,fldLastName,fldUserName","fldLastname","");
                                    for ($i=0;$i<count($collegelist);$i++)
                                    {
                                    if($_REQUEST['to'] == $collegelist[$i]['fldUserName'])
                                    {
                                    echo '<option value ="'.$collegelist[$i]['fldUserName'].'" selected="selected" >'.ucfirst($collegelist[$i]['fldLastName']).', '.ucfirst($collegelist[$i]['fldFirstName']).'</option>';
                                    }
                                    else
                                    {
                                    echo '<option value ="'.$collegelist[$i]['fldUserName'].'" >'.ucfirst($collegelist[$i]['fldLastName']).', '.ucfirst($collegelist[$i]['fldFirstName']).'</option>';
                                    }
                                    }
                                    echo $strcombo = '</select>';
                                    }
                                    
                                      ##TO FIELDS##
                                    echo "</span></p>";
                                    echo "<p><label>Subject:</label><span><input type=text name=subject size=40 value='$subject'></span></p>";
                                    echo "<p><label>Message:</label><span><textarea name=message class=ta2>$message</textarea></span></p>";
                                    echo "<input type='hidden' name='isSubmit' value='save'>";
                                    echo "<p><label>&nbsp;</label><span><button type=submit onsubmit='' class='btn'>Send Message</button></span></p>";
                                    echo "</form>";
                                    }
                                    
                                    
                                    }
                                    /////////////////////////////Compose/Recompose///////////////////////////////
                                    
                                    ////////////////////////////Biginning Trash///////////////////////////////
                                    if($action==trash)
                                    {
                                    $selquery = "select * from ".TBL_MAIL." where (UserTo='$username' or UserFrom='$username') and status = 'delete' and visible = 'ACTIVE' order by mail_id DESC";
                                    $db->query($selquery);
                                    $db->next_record();
                                    if($db->num_rows()=='0')
                                    {
                                    if ($_REQUEST['msg']=='')
                                    {
								?>
								<div class="thankyoumessage">
									You have no Messages in your Trash
								</div>
								<?
                                    }
                                    }
                                    else
                                    {
                                    #echo "<h3 class='black'>Trash</h3>";    
                                    echo "<table cellpadding=2 cellspacing=1 width=100% valign=top align='center'>";
                                    echo '<tr>
                                    <td align="left" class="normalblack_12" width="10%"><strong>Date</strong></td>
                                    <td align="left" class="normalblack_12" width="80%"><strong>Subject</strong></td>
                                    <td class="normalblack_12" width="10%" align="center" style="text-align:center;"><strong>Delete</strong></td>';
                                    echo '</tr>';
                                    $count="1";
                                    for ($i=0;$i<$db->num_rows();$i++)
                                    {
                                    $mail_id = $func->output_fun($db->f('mail_id'));
                                    $Subject = $func->output_fun($db->f('Subject'));
                                    //Date Format
                                    $sentdate = $func->output_fun($db->f('SentDate'));
                                    $sentdate  = date ( 'm-j-Y' , strtotime($sentdate));
                                    echo '<tr>';
                                    echo '<td align="left" class="normalblack_12" >'.$sentdate.'</td>';   
                                    echo '<td align="left" class="normalblack_12" ><a href=Athmessage.php?action=veiwtrash&mail_id='.$mail_id.'>'.$Subject.'</a></td>';
                                    echo '<td align="center" class="normalblack_12" style="text-align:center;"><a href="Athmessage.php?action=deleteconfirm&id='.$mail_id.'" onclick="return confirm(\'Are you sure you want to Permanently Delete Message? This cannot be undone.\')"><img src="images/b_drop.png" border="0" title="Delete"></a></td>';
                                    echo '</tr>';
                                    $db->next_record();
                                    $count++;
                                    }
                                    echo "</table>";
                                    }
                                    }
                                    //////////////////////////// Trash///////////////////////////////
                                    
                                    ///////////////////////////Beginning sentmessage////////////////////////////////
                                    if($action==sentmessage)
                                    {
                                    $selquery = "select * from ".TBL_MAIL." where UserFrom='$username' and status!= 'delete' order by mail_id DESC";
                                    $db->query($selquery);
                                    $db->next_record();
                                    if($db->num_rows()=='0')
                                    {
                                    if($_REQUEST['msg']=='')
                                    {
								?>
								<div class="thankyoumessage">
									You have not Sent any messages
								</div>
								<?php
                                    }
                                    }
                                    else
                                    {
                                    #echo "<h3 class='black'>Sent</h3>";   
                                    echo "<table cellpadding=2 cellspacing=1 width=100% valign=top align='center'>";
                                    
                                    // echo '<tr>
                                    // <td align="left" class="normalblack_12" width="80%"><strong>Subject</strong></td>
                                    // <td class="normalblack_12" width="5%" align="center" style="text-align:center;"><strong>Delete</strong></td>';
                                    // echo '</tr>';                                    
                                    echo '<tr>                
                                    <td align="left" class="normalblack_12" width="10%"><strong>Date</strong></td>                    
                                    <td align="left" class="normalblack_12" width="65%"><strong>Subject</strong></td>
                                    <td align="left" class="normalblack_12" width="35%"><strong>To User</strong></td>';
                                    #<td class="normalblack_12" width="5%" align="center" style="text-align:center;"><strong>Delete</strong></td>';
                                    echo '</tr>';
                                                                        
                                    $count="1";
                                    for ($i=0;$i<$db->num_rows();$i++)
                                    {
                                    $mail_id = $func->output_fun($db->f('mail_id'));
                                    $Subject = $func->output_fun($db->f('Subject'));
                                    //Date Format
                                    $sentdate = $func->output_fun($db->f('SentDate'));
                                    $sentdate  = date ( 'm-j-Y' , strtotime($sentdate));
                                    #Inbox - From
                                    $varUserTo = $func->output_fun($db->f('UserTo'));
                                    $varUserTypeTo = $func->output_fun($db->f('Usertypeto'));                                    
                                    $urlUserTo = $func2->GetUserProfileURL($varUserTo, $varUserTypeTo);     
                                    
                                    // echo '<tr>';
                                    // echo '<td align="left" class="normalblack_12" ><a href=Athmessage.php?action=veiwsent&mail_id='.$mail_id.'>'.$Subject.'</a></td>';
                                    // echo '<td align="center" class="normalblack_12" style="text-align:center;"><a href="Athmessage.php?action=deletesentconfirm&id='.$mail_id.'"><img src="images/b_drop.png" border="0" title="Delete"></a></td>';
                                    // echo '</tr>';
                                    
                                    echo '<tr>';                                
                                    echo '<td align="left" class="normalblack_12" >'.$sentdate.'</td>';       
                                    echo '<td align="left" class="normalblack_12" ><a href="Athmessage.php?action=veiwsent&mail_id='.$mail_id.'" title="Read Message">'.$Subject.'</a></td>';
                                    echo '<td align="left" class="normalblack_12" >'.$urlUserTo.' - ('.$varUserTypeTo.')</td>';
                                    #echo '<td align="center" class="normalblack_12" style="text-align:center;"><a href="Athmessage.php?action=deletesentconfirm&id='.$mail_id.'" onclick="return confirm(\'Are you sure you want to Permanently Delete Message? This cannot be undone.\')"><img src="images/b_drop.png" border="0" title="Delete"></a></td>';
                                    echo '</tr>';
                                                                                                            
                                    $db->next_record();
                                    $count++;
                                    }
                                    echo "</table>";
                                    }
                                    }
                                    //////////////////////////sentmessage//////////////////////////////////////////////
                                    
                                    ////////////////////////////Biginning ViewSent///////////////////////////////
                                    if($action==veiwsent)
                                    {
                                    $result="select * from ".TBL_MAIL." where UserFrom='$username' and mail_id='$mail_id' order by mail_id DESC";
                                    $db->query($result);
                                    $db->next_record();
                                    $UserTo = $func->output_fun($db->f('UserTo'));
                                    $mail_id = $func->output_fun($db->f('mail_id'));
                                    $UserFrom = $func->output_fun($db->f('UserFrom'));
                                    $Subject = $func->output_fun($db->f('Subject'));
                                    $Message = $func->output_fun($db->f('Message'));
                                    $Message = str_replace("\n", "<br>", $Message); 
                                    $Usertypeto=$func->output_fun($db->f('Usertypeto'));
                                    $Usertypefrom=$func->output_fun($db->f('Usertypefrom'));
                                    if($Usertypeto=='athlete')
                                    {
                                    $getname=$func->selectTableOrder(TBL_ATHELETE_REGISTER,"fldFirstname,fldLastname,fldId","fldId","where fldUsername='".$UserTo."'");
                                    for ($i=0;$i<count($getname);$i++)
                                    {
                                    $fname=$getname[$i]['fldFirstname'];
                                    $lname=$getname[$i]['fldLastname'];
                                    $fullname = ucfirst($fname).'&nbsp;'.ucfirst($lname);
                                    }
                                    }
                                    if($Usertypeto=='coach')
                                    {
                                   $getname=$func->selectTableOrder(TBL_HS_AAU_COACH,"fldName,fldLastName,fldId","fldId","where fldUsername='".$UserTo."'");
                                    for ($i=0;$i<count($getname);$i++)
                                    {
                                    $fname=$getname[$i]['fldName'];
                                    $lname=$getname[$i]['fldLastName'];
                                    $fullname = ucfirst($fname).'&nbsp;'.ucfirst($lname);
                                    }
                                    }
                                    if($Usertypeto=='college')
                                    {
                                    $getname=$func->selectTableOrder(TBL_COLLEGE_COACH_REGISTER,"fldFirstName,fldLastName,fldId","fldId","where fldUserName='".$UserTo."'");
                                    for ($i=0;$i<count($getname);$i++)
                                    {
                                    $fname=$getname[$i]['fldFirstName'];
                                    $lname=$getname[$i]['fldLastName'];
                                    $fullname = ucfirst($fname).'&nbsp;'.ucfirst($lname);
                                    }
                                    }
                                    if($UserFrom==$username)
                                    {
                                    }
                                    else
                                    {
                                    echo "<font face=verdana><b>This isn't your mail!";
                                    exit;
                                    }
                                    echo "<p><label></label><span></span></p>";
                                    echo "<p><label>To: </label><span>$fullname</span></p>";
                                    echo "<p><label>Subject:</label><span>$Subject</span></p>";
                                    echo "<p><label>Message:</label><span style='line-height:18px;'>$Message</span></p>";
                                    $Subjectnew = str_replace(" ","%",$Subject);
                                    echo "<p style='padding-top:10px;height:50px;line-height:18px;display:none;'><a href=Athmessage.php?action=compose&to=$fullname&subject=RE: $Subjectnew&Usertypefrom=$Usertypefrom&newfrom=$UserTo class='mailaction'>Forward Message</a></p>";
                                    }
                                    ////////////////////////////Viewssent///////////////////////////////
                                    
                                    ////////////////////////////Biginning Inbox///////////////////////////////
                                    if($action==inbox || $action =='')
                                    {
                                    $selquery = "select * from ".TBL_MAIL." where UserTo='$username' and status!='delete' and visible = 'ACTIVE' order by mail_id DESC";
                                    $db->query($selquery);
                                    $db->next_record();
                                    $totalPages = $db->num_rows();
                                    #Code for paging
                                    $page->set_page_data('',$db->num_rows(),20,5,true,false,true);
                                    $page->set_qry_string($selquery);
                                    $selquery = $page->get_limit_query($selquery); //return the query with limits
                                    $db->query($selquery);
                                    $db->next_record();
                                    if($db->num_rows()=='0')
                                    {
                                    if($_REQUEST['msg']=='')
                                    {
                                    echo '<div class="thankyoumessage">Your Inbox is Empty!</div>';
                                    }
                                    }
                                    else
                                    {
                                    #echo "<h3 class='black'>Inbox</h3>";   
                                    echo "<table cellpadding=2 cellspacing=1 width='100%'  align='center'>";
                                    echo '<tr>                                    
                                    <td align="left" class="normalblack_12" width="10%"><strong>Date</strong></td>
                                    <td align="left" class="normalblack_12" width="45%"><strong>Subject</strong></td>
                                    <td align="left" class="normalblack_12" width="30%"><strong>From User</strong></td>
                                    <td class="normalblack_12" width="15%" align="center" style="text-align:center;"><strong>Send to Trash</strong></td>';
                                    echo '</tr>';
                                    $count="1";
                                    for ($i=0;$i<$db->num_rows();$i++)
                                    {
                                    $Subject = $func->output_fun($db->f('Subject'));
                                    $mail_id = $func->output_fun($db->f('mail_id'));
                                    $status = $func->output_fun($db->f('status'));
                                    //Date Format
                                    $sentdate = $func->output_fun($db->f('SentDate'));
                                    $sentdate  = date ( 'm-j-Y' , strtotime($sentdate));
                                    #Inbox - From
                                    $varUserFrom = $func->output_fun($db->f('UserFrom'));
                                    $varUserTypeFrom = $func->output_fun($db->f('Usertypefrom'));                                    
                                    $urlUserFrom = $func2->GetUserProfileURL($varUserFrom, $varUserTypeFrom);                                  
                                
                                    $classStatus = "";
                                    if($status == 'unread')
                                    {                                                                    
                                        $classStatus = 'class="unread"';
                                    }                                  

                                    echo '<tr>';    
                                    echo '<td align="left" class="normalblack_12" >'.$sentdate.'</td>';   
                                    echo '<td align="left" class="normalblack_12" ><a href="Athmessage.php?action=veiw&mail_id='.$mail_id.'" '.$classStatus.' title="Read Message">'.$Subject.'</a></td>';
                                    echo '<td align="left" class="normalblack_12" >'.$urlUserFrom.' - ('.$varUserTypeFrom.')</td>';
                                    echo '<td align="center" class="normalblack_12" style="text-align:center;"><a href="Athmessage.php?action=delete&id='.$mail_id.'" onclick="return confirm(\'Are you sure you want to Send Message to Trash?\')"><img src="images/trash_16x16.gif" border="0" title="Delete"></a></td>';
                                    echo '</tr>';
                                    
                                    $db->next_record();
                                    $count++;
                                    }
                                    echo '<tr><td align="right" class="normalblack_12" colspan="10">';
                                    $page->get_page_nav();
                                    echo '</td></tr>';
                                    echo "</table>";
                                    }
                                    }
                                    ////////////////////////////Inbox///////////////////////////////
                                    
                                    ////////////////////////////Biginning View///////////////////////////////
                                    if($action==veiw)
                                    {
                                    $result="select * from ".TBL_MAIL." where UserTo='$username' and mail_id='$mail_id' and visible = 'ACTIVE' order by mail_id DESC";
                                    $db->query($result);
                                    $db->next_record();
                                    $UserTo = $func->output_fun($db->f('UserTo'));
                                    $mail_id = $func->output_fun($db->f('mail_id'));
                                    $UserFrom = $func->output_fun($db->f('UserFrom'));
                                    $Subject = $func->output_fun($db->f('Subject'));
                                    $Message = $func->output_fun($db->f('Message'));
                                    $Message = str_replace("\n", "<br>", $Message); 
                                    $Usertypeto=$func->output_fun($db->f('Usertypeto'));
                                    $Usertypefrom=$func->output_fun($db->f('Usertypefrom'));
                                    $Subjectnew = str_replace(" ","%",$Subject);
                                    $fullname = str_replace(" ","%",$fullname);
                                    if($Usertypefrom=='athlete')
                                    {
                                    $getname=$func->selectTableOrder(TBL_ATHELETE_REGISTER,"fldFirstname,fldLastname,fldId","fldId","where fldUsername='".$UserFrom."'");
                                    for ($i=0;$i<count($getname);$i++)
                                    { 
                                    $fname=$getname[$i]['fldFirstname'];
                                    $lname=$getname[$i]['fldLastname'];
                                    $fullname = ucfirst($fname).'&nbsp;'.ucfirst($lname);
                                    }
                                    }
                                    if($Usertypefrom=='coach')
                                    {//tbl_hs_aau_coach
                                    $getname=$func->selectTableOrder(TBL_HS_AAU_COACH,"fldName,fldLastName,fldId","fldId","where fldUsername='".$UserFrom."'");
                                    for ($i=0;$i<count($getname);$i++)
                                    {
                                    $fname=$getname[$i]['fldName'];
                                    $lname=$getname[$i]['fldLastName'];
                                    $fullname = ucfirst($fname).'&nbsp;'.ucfirst($lname);
                                    }
                                    }
                                    if($Usertypefrom=='college')
                                    {
                                    $getname=$func->selectTableOrder(TBL_COLLEGE_COACH_REGISTER,"fldFirstName,fldLastName,fldId","fldId","where fldUserName='".$UserFrom."'");
                                    for ($i=0;$i<count($getname);$i++)
                                    {
                                    $fname=$getname[$i]['fldFirstName'];
                                    $lname=$getname[$i]['fldLastName'];
                                    $fullname = ucfirst($fname).'&nbsp;'.ucfirst($lname);
                                    }
                                    }
                                    if($UserTo==$username)
                                    {
                                    }
                                    else
                                    {
                                    echo "<font face=verdana><b>This isn't your mail!";
                                    exit;
                                    }
                                    $selquery="select status from ".TBL_MAIL." where  mail_id='$mail_id'";
                                    $objquery = mysql_query($selquery);
                                    $numquery = mysql_num_rows($objquery);
                                    $resquery=mysql_fetch_array($objquery);
                                    $status = $resquery['status'];
                                    if($status == 'unread')
                                    {
                                    echo "<script>window.location.reload(true);</script>";
                                    }
                                    $query="UPDATE ".TBL_MAIL." SET status='read' WHERE UserTo='$username' AND mail_id='$mail_id'";
                                    $query or die("An error occurred,  this message has not been marked as read.");
                                    echo "<p><label></label><span></span></p>";
                                    echo "<p><label>From: </label><span>$fullname</span></p>";
                                    echo "<p><label>Subject:</label><span>$Subject</span></p>";
                                    echo "<p><label>Message:</label><span style='line-height:18px;'>$Message</span></p>";
                                    echo '<p style="padding-top:20px;height:50px;line-height:18px;"><label>&nbsp;</label><span><a href="Athmessage.php?action=compose&mailID='.$mail_id.'&to='.$fullname.'&subject=RE: '.$Subjectnew.'&Usertypefrom='.$Usertypefrom.'&newfrom='.$UserFrom.'" class="mailaction">Reply to Message</a></span></p>';
                                    $rs = mysql_query("UPDATE ".TBL_MAIL." SET status='read' WHERE mail_id='$mail_id'");
                                    }
                                    ////////////////////////////view///////////////////////////////
                                    
                                    ////////////////////////////Biginning ViewTrash///////////////////////////////
                                    if($action==veiwtrash)
                                    {
                                    $result="select * from ".TBL_MAIL." where UserTo='$username' and mail_id='$mail_id' and visible = 'ACTIVE' order by mail_id DESC";
                                    $db->query($result);
                                    $db->next_record();
                                    $UserTo = $func->output_fun($db->f('UserTo'));
                                    $mail_id = $func->output_fun($db->f('mail_id'));
                                    $UserFrom = $func->output_fun($db->f('UserFrom'));
                                    $Subject = $func->output_fun($db->f('Subject'));
                                    $Message = $func->output_fun($db->f('Message'));
                                    $Message = str_replace("\n", "<br>", $Message); 
                                    if($UserTo==$username)
                                    {
                                    }
                                    else
                                    {
                                    echo "<font face=verdana><b>This isn't your mail!";
                                    exit;
                                    }
                                    echo "<p><label></label><span></span></p>";
                                    echo "<p><label>From: </label><span>$UserFrom</span></p>";
                                    echo "<p><label>Subject:</label><span>$Subject</span></p>";
                                    echo "<p><label>Message:</label><span style='line-height:18px;'>$Message</span></p>";
                                    echo "<p style='padding-top:20px;height:50px;line-height:18px;'><label>&nbsp;</label><span><a href='Athmessage.php?action=restore&mailID=$mail_id' class='mailaction'>Move to Inbox</a></span></p>";                                 
                                    }
                                    ////////////////////////////ViewTrash///////////////////////////////
                                    
                                    ////////////////////////////Biginning Delete///////////////////////////////
                                    if($action==delete)
                                    {
                                    $result = "update  ".TBL_MAIL." set status = 'delete' WHERE mail_id='$id' LIMIT 1";
                                    $db->query($result);
                                    $db->next_record();
                                    if($result)
                                    {
                                    $msg="Message successfully sent to trash.";
                                    echo "<script>document.location.href ='Athmessage.php?action=inbox&msg=".$msg."';</script>";
                                    }
                                    else
                                    {
                                    echo "The message wasnt deleted.";
                                    }
                                    }
                                    ////////////////////////////Delete///////////////////////////////
                                    
                                    ////////////////////////////Biginning Confirmdelete///////////////////////////////
                                    if($action==deleteconfirm)
                                    {
                                    $result = "DELETE FROM ".TBL_MAIL." WHERE mail_id='$id' LIMIT 1";
                                    $db->query($result);
                                    $db->next_record();
                                    if($result)
                                    {
                                    $msg="Message successfully deleted (permanently).";
                                    echo "<script>document.location.href ='Athmessage.php?action=trash&msg=".$msg."';</script>";
                                    }
                                    else
                                    {
                                    echo "The message wasnt deleted.";
                                    }
                                    }
                                    ////////////////////////////confirm delete///////////////////////////////
                                    
                                    ////////////////////////////Biginning deletesentconfirm//////////////////////////////
                                    if($action==deletesentconfirm)
                                    {
                                    #$result = "update  ".TBL_MAIL." set status = 'delete' WHERE mail_id='$id' LIMIT 1";
                                    $result = "DELETE FROM ".TBL_MAIL." WHERE mail_id='$id' LIMIT 1";
                                    $db->query($result);
                                    $db->next_record();
                                    if($result)
                                    {
                                    $msg="Message successfully deleted (permanently).";
                                    echo "<script>document.location.href ='Athmessage.php?action=sentmessage&msg=".$msg."';</script>";
                                    }
                                    else
                                    {
                                    echo "The message wasn't deleted.";
                                    }
                                    }
                                    ////////////////////////////deletesentconfirm delete///////////////////////////////
                                    
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
            include ('footer.php');
		?>
	</body>
</html>