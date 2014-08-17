<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		sendmsgtoath.php
##	Create Date	:		19/07/2011
##  Description :		It is use to send the message to athlete.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************
session_start();
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");				//for paging
$func = new COMMONFUNC;
$db = new DB;
$flag=0;



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
<script language="JavaScript" type="text/JavaScript">
</script>

<script language="JavaScript">
<!--
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
  window.close();
}
</script>
</head>
<body>

    <!--middle panel starts from here -->
<!--content panel starts from here -->
<div class="container">
<div class="innerWraper">
<div class="middle-bg">
<div class="cantener">
<div class="register-main">
<h1>Edit Needs</h1>
<div class="registerPage">
<?php
               $sessionid = $_SESSION['College_Coach_id'];

               if($_POST['isSubmit']=='save')
               {
               	
               	         
               	$strDataArrw=array('fldDivision'=>$_POST['fldDivision'],
										'fldClass'=>$_POST['fldClass'],
										'fldMaxHeight'=>$_POST['fldMaxHeight'],
										'fldMinHeight'=>$_POST['fldMinHeight'],
			          					'fldMinWeight'=>$_POST['fldMinWeight'],
			          					'fldMaxWeight'=>$_POST['fldMaxWeight'],
			          					'fldPosition'=>$_POST['fldPosition'],
										'fldSchool'=>$_POST['fldSchool'],
			          					'fldCity'=>$_POST['fldCity'],
			          					'fldState'=>$_POST['fldState'],
			          					'fldZipCode'=>$_POST['fldZipCode'],
			          					'fldDistance'=>$_POST['fldDistance'],
			          					
			          	);
		  
			      $Result=  $db->updateRec(TBL_NEEDTYPE,$strDataArrw," fldId=".$_REQUEST['fldId']);  	
				$flag++;
			
               }
               if($_REQUEST['fldId'])
{
	 $query =" Select * from ".TBL_NEEDTYPE. " where fldId = '".$_REQUEST['fldId']."' ";
	
	$db->query($query);
	$db->next_record();
	$fldDivision=$db->f('fldDivision');
	$fldClass=$db->f('fldClass');
	$fldMaxHeight=$db->f('fldMaxHeight');
	$fldMinHeight=$db->f('fldMinHeight');
	
	$fldMinWeight=$db->f('fldMinWeight');
	$fldMaxWeight=$db->f('fldMaxWeight');
	$fldPosition=$db->f('fldPosition');
	$fldSchool=$db->f('fldSchool');
	$fldCity=$db->f('fldCity');
	$fldState=$db->f('fldState');
	$fldZipCode=$db->f('fldZipCode');	
	$fldDistance=$db->f('fldDistance');
	
}
		    
			          			              	 	
			          	if($flag==1)
			          	{
	
									     ?>
									    <br><div class="thankyoumessage" style="margin-right:29px;"><?php echo "You have succesfully updated your needs."; ?></div><br>
									     <?
									     
			                 }
               	     

           
                     
                   ?>
	
		 <form action="" method="post" name="needtype" onsubmit="return validate();">
		 
		  
	   		    <p>
								  <label>Division :</label>
								  <span>
								  <select name="fldDivision"><option value="">Select Division</option>
								  <option value="DivisionI" <?php if($fldDivision=='DivisionI'){?>selected<?php } ?>>Division I</option>
								  <option value="DivisionII" <?php if($fldDivision=='DivisionII'){?>selected<?php } ?>>Division II</option>
								  <option value="DivisionIII" <?php if($fldDivision=='DivisionIII'){?>selected<?php } ?>>Division III</option>
								  <option value="NAIA" <?php if($fldDivision=='NAIA'){?>selected<?php } ?>>NAIA</option>
								  <option value="JUCO" <?php if($fldDivision=='JUCO'){?>selected<?php } ?>>JUCO</option>
								  </select>
								  </span>
								</p>
                                
                                
                                 <p>
                                	<label>Class :</label>
                                    <span>
                                    <?php echo '<select name="fldClass"><option value="">Select Class</option>';
									$classlist=$func->selectTableOrder(TBL_CLASS,"fldId,fldClass","fldId");
								for ($i=0;$i<count($classlist);$i++) 
								{
									if($fldClass==$classlist[$i]['fldClass'])
									{
								echo '<option value ="'.$classlist[$i]['fldClass'].'" selected>'.$classlist[$i]['fldClass'].'</option>';
									}
									else 
									{
										echo '<option value ="'.$classlist[$i]['fldClass'].'">'.$classlist[$i]['fldClass'].'</option>';
									}
								}
								
								echo $strcombo = '</select>';
								?>

                                    </span>
                                </p>
                                
 <p>
                                	<label>Min Height :</label>
                                    <span>
                                    <?php echo '<select name="fldMinHeight"><option value="">Select Height</option>';
									for ($i=5; $i<7;$i++)
									 {	
									 	for($j=0; $j<12;$j++)
									 	{	
									 		if($fldMinHeight==$i."-".$j)
									 		{
									    echo '<option value="'.$i."-".$j.'"';
									    echo ' selected >'.$i."' ".$j.'</option>'; 
									 		}
									 		else {
									 			echo '<option value="'.$i."-".$j.'"';
									    echo '  >'.$i."' ".$j.'</option>'; 
									 		}
									 	}
									}
									for($kcount=0; $kcount<3;$kcount++)
									 	{	
									 		if($fldMinHeight=="7"."-".$kcount)
									 		{
									    echo '<option value="'."7"."-".$kcount.'"';
									    echo ' selected >'."7"."' ".$kcount.'</option>'; 
									 		}
									 		else {
									 			echo '<option value="'."7"."-".$kcount.'"';
									    echo '>'."7"."' ".$kcount.'</option>';
									 		}
									 	}
										echo '</select>';
									?>
                                    </span>
                                </p>
 <p>
                                	<label>Max Height :</label>
                                    <span>
                                    <?php echo '<select name="fldMaxHeight"><option value="">Select Height</option>';
									for ($i=5; $i<7;$i++)
									 {	
									 	for($j=0; $j<12;$j++)
									 	{	
									    if($fldMaxHeight==$i."-".$j)
									    {
									 		echo '<option value="'.$i."-".$j.'"';
									    echo ' selected >'.$i."' ".$j.'</option>'; 
									    }
									    else {
									    	echo '<option value="'.$i."-".$j.'"';
									    echo '>'.$i."' ".$j.'</option>'; 
									    	
									    }
									 	}
									}
									for($kcount=0; $kcount<3;$kcount++)
									 	{	
 if($fldMaxHeight=="7"."-".$kcount)
									    {
									 		echo '<option value="'."7"."-".$kcount.'"';
									    echo ' selected >'."7"."' ".$kcount.'</option>'; 
									    }
									    else 
									    {
									    	echo '<option value="'."7"."-".$kcount.'"';
									    echo ' >'."7"."' ".$kcount.'</option>'; 
									    }
									 	}
										echo '</select>';
									?>
                                    </span>
                                </p>
                                
                                
                                 <p>
                                	<label>Min Weight :</label>
                                    <span>
                                     <?php 
									echo '<select name="fldMinWeight"><option value="">Select Weight</option>';
									echo '<option value="under140">Under 140</option>';
									for ($i=127; $i<245;$i++)
									 {	
									 		$i =$i+14;
									 		$j = $i+14;
									 		if($fldMinWeight==$i."-".$j)
									 		{	
									 		echo '<option value="'.$i."-".$j.'"';
											echo 'selected >'.$i."-".$j.'</option>'; 
									 		}
									 	else {
									 			echo '<option value="'.$i."-".$j.'"';
											echo '>'.$i."-".$j.'</option>'; 
									 	}
									}
									echo '<option value="Over260">Over 260</option>';
									echo '</select>';
								?>

                                    </span>
                                    
                                </p>
                                <p>
                                	<label>Max Weight :</label>
                                    <span>
                                     <?php 
									echo '<select name="fldMaxWeight"><option value="">Select Weight</option>';
									echo '<option value="under140">Under 140</option>';
									for ($i=127; $i<245;$i++)
									 {	
									 		$i =$i+14;
									 		$j = $i+14;
									 		if($fldMaxWeight==$i."-".$j)
									 		{	
									 		echo '<option value="'.$i."-".$j.'"';
											echo 'selected >'.$i."-".$j.'</option>'; 
									 		}
									 	else {
									 			echo '<option value="'.$i."-".$j.'"';
											echo '>'.$i."-".$j.'</option>'; 
									 	}
									}
									echo '<option value="Over260">Over 260</option>';
									echo '</select>';
								?>

                                    </span>
                                    
                                </p>
                                  <p>
                                	<label>Position :</label>
                                    <span>
                                   
                                 <select name="fldPosition" ><option value="">Please Select</option>
                                   
								<option value="Point Guard" <?php if($fldPosition=="Point Guard"){echo "selected";} ?>>Point Guard</option>
									<option value="Shooting Guard" <?php if($fldPosition=="Shooting Guard"){echo "selected";} ?>>Shooting Guard</option>
									<option value="Small Forward" <?php if($fldPosition=="Small Forward"){echo "selected";} ?>>Small Forward</option>
									<option value="Power Forward" <?php if($fldPosition=="Power Forward"){echo "selected";} ?>>Power Forward</option>
									<option value="Center" <?php if($fldPosition=="Center"){echo "selected";} ?>>Center</option>
			</select>
                                    </span>
                                </p> 
                                
	       <p>
                               <label>HS/AAU Team :</label>
                               <span>
                                <?php  
                                
								echo $strcombo = '<select name="fldSchool" style="width:276px" >';
								echo $strcombo = '<option value = 0>Select HS / AAU Team</option>';
								$categorylist=$func->selectTableOrder(TBL_HS_AAU_TEAM,"fldId,fldSchoolname","fldId");
								for ($i=0;$i<count($categorylist);$i++) 
								{
									if($fldSchool==$categorylist[$i]['fldId'])
									{
								echo '<option value ="'.$categorylist[$i]['fldId'].'" selected>'.$categorylist[$i]['fldSchoolname'].'</option>';
									}
									else {
										echo '<option value ="'.$categorylist[$i]['fldId'].'">'.$categorylist[$i]['fldSchoolname'].'</option>';
									}
								}
								
								echo $strcombo = '</select>';
								?></span>
								</p>
								<p>
								<label>City :</label>
                               <span>
                               <input type="text" name="fldCity" value="<?php echo $fldCity;?>">
								</span>
								</p>
<p>
								<label>State :</label>
                              
                               <span>
                               <input type="text" name="fldState" value="<?php echo $fldState;?>">
								</span>
		</p>
								<p>						
								
<label>Zip Code :</label>
                              
                               <span>
                               <input type="text" name="fldZipCode" value="<?php echo $fldZipCode;?>">
								</span>
								</p>
								<p>
                                	<label>Distance:</label>
                                    <span>
                                     <select name="fldDistance" >
                                    <option value="select">select</option>
 
	<option value="25" <?php if($fldDistance=="25"){echo "selected";} ?>>25</option>
<option value="50" <?php if($fldDistance=="50"){echo "selected";} ?>>50</option>
<option value="100" <?php if($fldDistance=="100"){echo "selected";} ?> >100</option>
<option value="250" <?php if($fldDistance=="250"){echo "selected";} ?>>250</option>
<option value="500" <?php if($fldDistance=="500"){echo "selected";} ?>>500</option>
<option value="any" <?php if($fldDistance=="any"){echo "selected";} ?>><?php  echo "Any";?></option>
</select> In Miles

							   
							    
							 
								</span>
								
                                   
                                </p>
	     <p><label>&nbsp;</label><span><input type="hidden" name="isSubmit" value="save">
	     <button type="submit">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;
  	        
	     
	     <button type=submit onclick="javascript:refreshParent();">Close</button></span></p>
	     
	     
	     
	     
	     
         </form>
	     	
		


</div>
</div>
</div>
</div>
</div>
</div>


</body>
</html>