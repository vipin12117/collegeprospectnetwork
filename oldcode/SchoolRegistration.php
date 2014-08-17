<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");				//for paging
session_start();
$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
$lnb = "10";
$error_msg = '';
$flag = 0;

 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }


if($_POST['isSubmit']=='save'){
        //Edit the user info
		$fldSchoolname        = $func->input_fun($_POST['fldSchoolname']);
		$fldUserName       = $func->input_fun($_POST['fldUserName']);
		//$city        = $func->input_fun($_POST['city']);

		$whereClause = "fldUserName='".$fldUserName."'";

		if($db->MatchingRec(TBL_HS_AAU_TEAM,$whereClause)>0) {    #user Username already exists
			$error_msg = 'This School User Name Already Exists!';
			$flag++;
			}
	
        if($flag==0)
        {
        	 define ("MAX_SIZE","400");
        	 $errors=0;

          	///////////
        	    
        	    $image=$_FILES['fldLogo']['name'];
				if ($image) 
				{
				
				$filename = stripslashes($_FILES['fldLogo']['name']);
				
				$extension = getExtension($filename);
				$extension = strtolower($extension);
				
				if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
				{
				echo '<h1>Unknown extension!</h1>';
				$errors=1;
				}
				else
				{
				
				$size=filesize($_FILES['fldLogo']['tmp_name']);
				
				if ($size > MAX_SIZE*1024)
				{
				 echo "You have exceeded the size limit";
				 $errors=1;
				}

				
				
				$image_name=time().'.'.$extension;
				
				$newname="logo/".$image_name;
				
				$copied = copy($_FILES['fldLogo']['tmp_name'], $newname);
				}
				}
        	////////////
        	
			//Insert data
				$strDataArr=array(
				'fldUserName' 				=> $func->input_fun($_POST['fldUserName']),
				'fldPassword' 				    => $func->input_fun($_POST['fldPassword']),
				'fldSchoolname' 			    => $func->input_fun($_POST['fldSchoolname']),
				'fldAddress' 			        => $func->input_fun($_POST['fldAddress']),
				'fldCity' 					    => $func->input_fun($_POST['fldCity']),
				'fldState' 				        => $func->input_fun($_POST['fldState']),
				'fldZipcode' 					=> $func->input_fun($_POST['fldZipcode']),
				'fldLogo' 				        => $image_name,
				'fldSport' 				        => $func->input_fun($_POST['fldSport']),
				'fldCoachname' 				    => $func->input_fun($_POST['fldCoachname']),
				'fldStatus' 			        => "ACTIVE",
				'fldEmail'						=> $func->input_fun($_POST['fldEmail']),
				'fldAthleteUrl'                 => $func->input_fun($_POST['fldAthleteUrl'])
			);

//$s=$_POST;	
//print_r($s);	

	
			 




             $selquery = 'SHOW TABLE STATUS LIKE "'.TBL_HS_AAU_TEAM.'"';
		     $objQuery = mysql_query($selquery);
		     $resquery = mysql_fetch_array($objQuery);
		     $next_id= $resquery['Auto_increment'];
		     
		       
	

		     for($n=0;$n<$_POST['currentrow'];$n++)
		     {
		     	   if($n==0)
		     	   
		     	   {
					     	$strDataArrw=array(
							'schoolid' 				=> $next_id,
							'sportid' 			    => $func->input_fun($_POST['fldSport']),
							'coachnameid' 		    => $func->input_fun($_POST['fldCoachname'])
						       );
		     	   }
		     	   
		     	   else 
		     	   {
					     	$strDataArrw=array(
							'schoolid' 				=> $next_id,
							'sportid' 			    => $func->input_fun($_POST['fldSport'.$n]),
							'coachnameid' 		    => $func->input_fun($_POST['fldCoachname'.$n])
						       );
						         
		     	   }
			                    
	           	$db->insertRec(TBL_HS_AAU_TEAM_COACH,$strDataArrw);
		     	
		     }
		     
		        
		     
		     
		     
			if($db->insertRec(TBL_HS_AAU_TEAM,$strDataArr))
			{
				
				
				$_SESSION['FRONTEND_USER'] = $_POST['fldUserName'];
				 $_SESSION['mode']='school';
				header("Location: myaccount.php?msg=Thank you for High School Registration, ");
			}
		     
	
		     
		       
			#redirect to listing page on successfull updation
			//header("Location: ADUserList.php");
			
		}
		
		
	//this section is use to filup the value after erro message.

	if($error_msg!=""){
		$fldUserName		= $_REQUEST['fldUserName'];
		$fldPassword		= $_REQUEST['fldPassword'];
		$fldSchoolname		= $_REQUEST['fldSchoolname'];
		$fldAddress		    = $_REQUEST['fldAddress'];
		$fldCity		    = $_REQUEST['fldCity'];
		$fldState			= $_REQUEST['fldState'];
		$fldZipcode		    = $_REQUEST['fldZipcode'];
		$fldLogo			= $_REQUEST['fldLogo'];
		$fldSport		    = $_REQUEST['fldSport'];
		$fldCoachname		= $_REQUEST['fldCoachname'];
		$fldEmail			= $_REQUEST['fldEmail'];
		$fldAthleteUrl		= $_REQUEST['fldAthleteUrl'];
		//$fldStatus          = "ACTIVE";
	 
	}


} //END if submit


?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>College Prospect Network</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>

<script language="JavaScript" type="text/JavaScript">

function addfields() {
	
	var currentrow	= parseInt(document.frmUsers.currentrow.value);
	
	document.getElementById('trs_'+currentrow).style.display= "";
	document.getElementById('trc_'+currentrow).style.display= "";
	//document.getElementById('trsb_'+currentrow).style.display= "";
	//document.getElementById('trcb_'+currentrow).style.display= "";
	document.getElementById('currentrow').value=currentrow + 1;
	if(document.getElementById('currentrow').value >= 1)
	{
		
		document.getElementById('remfield').style.display= "";
		
    }
   
}	


function removefields() {
	
	var currentrow	= parseInt(document.frmUsers.currentrow.value);
	//alert(currentrow);
	document.getElementById('trs_'+currentrow).style.display= "none";
	document.getElementById('trc_'+currentrow).style.display= "none";
	//document.getElementById('trsb_'+currentrow).style.display= "none";
	//document.getElementById('trcb_'+currentrow).style.display= "none";
	
	if(document.getElementById('currentrow').value == 1)
	{
		document.getElementById('remfield').style.display= "none";
		document.getElementById('currentrow').value=currentrow;
    } 
    else 
    {
    	document.getElementById('currentrow').value=currentrow-1;	
    }

}   



	function validate(){
	var error_msg = "";
	var blnResult = true;
	
	
	if(trimString(document.frmUsers.fldUserName.value) == ""){
		error_msg += "Please Enter User Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldUserName.value)){
			error_msg += "Enter Enter valid User Name! \n";
		}
	}
	
	
	
	
	
	if(trimString(document.frmUsers.fldPassword.value) == ""){
		error_msg += "Please Enter Password! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldPassword.value)){
			error_msg += "Enter Enter Password! \n";
		}
	}
	
	
	if (document.frmUsers.fldPassword.value != document.frmUsers.fldCPassword.value){
		error_msg += "Your Confirm Password Does not Match! \n";
	}
	
	
	
	if(trimString(document.frmUsers.fldSchoolname.value) == ""){
		error_msg += "Please Enter schoolname! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldSchoolname.value)){
			error_msg += "Enter schoolname with no SpecialCharaters! \n";
		}
	}
	
	
		if(trimString(document.frmUsers.fldAddress.value) == ""){
		error_msg += "Please Enter address! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldAddress.value)){
			error_msg += "Enter address! \n";
		}
	}
	
	if(trimString(document.frmUsers.fldEmail.value) == ""){
		error_msg += "Please Enter Email. \n";
	}
	else{
		if(!isValid(document.frmUsers.fldEmail.value)){
			error_msg += "Enter Valid Email. \n";
		}
	}
	
	
	
	
	
	
	if(trimString(document.frmUsers.fldCity.value) == ""){
		error_msg += "Please Enter city Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldCity.value)){
			error_msg += "Enter city Name! \n";
		}
	}
	
	if(trimString(document.frmUsers.fldState.value) == ""){
		error_msg += "Please Enter state Name! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldState.value)){
			error_msg += "Enter state Name! \n";
		}
	}
	
	
	
	if(trimString(document.frmUsers.fldZipcode.value) == ""){
	error_msg += "Please Enter Zipcode! \n";
	}
	else{
	
	if(trimString(document.frmUsers.fldZipcode.value) != ""){

		if(!isNumeric(document.frmUsers.fldZipcode.value)){
			error_msg += "Please Enter numeric Zipcode! \n";
		}
		if(document.frmUsers.fldZipcode.value.length > 15){
			error_msg += "Zipcode should be less then 16 characters! \n";
		}
	}
	}
	

	
	
	if(trimString(document.frmUsers.fldLogo.value) == ""){
		error_msg += "Please Upload  SchoolLogo! \n";
	}
	else{
		if(trimString(document.frmUsers.fldLogo.value) == ""){
			error_msg += "Upload  SchoolLogo! \n";
		}
	}
	
	
	
	
	if(trimString(document.frmUsers.fldSport.value) == ""){
		error_msg += "Please Select the Sport! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldSport.value)){
			error_msg += "Please Select the Sport! \n";
		}
	}
	
	
	if(trimString(document.frmUsers.fldCoachname.value) == ""){
		error_msg += "Please Select the coachname! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldCoachname.value)){
			error_msg += "Please Select the coachname! \n";
		}
	}
	

	/*if(trimString(document.frmUsers.fldStatus.value) == ""){
		error_msg += "Please Enter status! \n";
	}
	else{
		if(hasSpecialCharaters(document.frmUsers.fldStatus.value)){
			error_msg += "Enter valid status! \n";
		}
	}*/
	
	
	
	///////////////////////////////////
	
	if(error_msg!=''){
		alert(error_msg);
		return false;
	}else{
		return true;
	}

}




    

</script>
</head>

<body>
<!--header link starts from here -->
<?php include('header.php'); ?>
    <!--Header ends from here -->
    <!--middle panel starts from here -->
<!--content panel starts from here -->
<div class="container">
  <div class="innerWraper">
    <div class="middle-bg">
    <div class="cantener">
  <div class="register-main">
  <h1>High School Registration</h1>
  <?php 
if (count(@$error_msg)>0){
	
 
 	?>
 	<div class="msg-error"> <?php echo $error_msg. "<br>";?> </div>
 <?

 }
 ?>
 <span class="msg"><font color="#0000ff">*</font> Fields are Mandatory.</span>
  <div class="registerPage">
  <form name="frmUsers" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">
  
                            	  <p>
                                	<label>User Name:</label>
                                    <span><input type="text" name="fldUserName" id="fldCollegecode" value="<?=$fldSchoolcode?>"  ></span><font color="#0000ff">*</font>
                                </p>
                                <p>
                                	<label>Password :</label>
                                    <span><input type="password" name="fldPassword" id="fldPassword" 
            ></span><font color="#0000ff" >*</font>
                                </p>
                                 <p>
                                	<label>Confirm Password :</label>
                                    <span><input type="password" name="fldCPassword" id="fldCPassword" 
            ></span><font color="#0000ff" >*</font>
                                </p>

                                 <p>
                                	<label>School Name:</label>
                                    <span><input type="text" name="fldSchoolname" id="fldCollegename" value="<?=$fldSchoolname?>" 
            >
</span><font color="#0000ff">*</font>
                                </p>
                                <p>
                                	<label>Address:</label>
                                    <span><textarea name="fldAddress" id="fldAddress" rows="5" cols="9"><?php echo $fldAddress; ?></textarea>
</span><font color="#0000ff">*</font>
                                </p>
                                  <p>
                                	<label>Email Address:</label>
                                    <span><input type="text" name="fldEmail" id="fldEmail" value="<?=$fldEmail?>" 
            >
</span><font color="#0000ff">*</font>
                                </p>
                                
                                
                                <p>
                                	<label>City :</label>
                                    <span><input type="text" name="fldCity" id="fldCity" value="<?=$fldCity?>" ></span><font color="#0000ff">*</font>
                                </p>
                                
                                
                                  <p>
                                	<label>State:</label>
                                    <span><input type="text" name="fldState" id="fldState" value="<?=$fldState?>" 
             ></span><font color="#0000ff">*</font>
                                </p>
                                <p>
                                	<label>Zip Code :</label>
                                    <span><input type="text" name="fldZipcode" id="fldZipcode" value="<?=$fldState?>" 
             ></span><font color="#0000ff">*</font>
                                </p>
                                 <p>
                                	<label>School Logo  :</label>
                                    <span>
                                    <input type="file" name="fldLogo" value="<?=$fldLogo?>" size="28" ><font color="#0000ff">*</font>
             </span>
                                </p>
                                
                                                              <?php
                                                             
			$whrecon1 ="schoolid ='".$fldId."'";
			$sportslist=$func->selectTableCon(TBL_HS_AAU_TEAM_COACH,"sportid,coachnameid",$whrecon1);
			$sportscount=1;
			for ($k=0;$k<$sportscount;$k++)
		     { 
		    		    	  			     	
		    ?>

                                 
                                 <?php 
                                  if ($k==0)
		    {
		   
                                 ?><p>
                                	<label>Sport:</label>
                                	 
			<?php } else {
				
				?><p><label>Sport<?php echo $k ;?></label> <?php 
			} 
			?>
                                    <span><?php
			 if ($k==0)
			 {
			echo $strcombo = '<select name="fldSport" >';
			 }
			 else 
			 {
			 echo $strcombo = '<select name="fldSport'.$k.'" >';
			 }
			
			
			echo $strcombo = '<option value = "">Select Sport</option>';
			$categorylist=$func->selectTableOrder(tbl_sports,"fldId,fldSportsname","fldId");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
	   				
	   			if ($sportslist[$k]['sportid'] == $categorylist[$i]['fldId'] ) 
	   			{	
	  		    echo '<option value ="'.$categorylist[$i]['fldId'].'" selected="selected" >'.$categorylist[$i]['fldSportsname'].'</option>';
	   			}
   			
	   			else 
	   			{
	   			echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldSportsname'].'</option>';
	   			}
  		    
            }
			echo $strcombo = '</select>';
				
				
				
				
				
				
			
		     ?></span><font color="#0000ff">*</font>
                                </p>
                                <?php 
		     
		  if ($k==0)
		    {  			     	
		    ?>
		
                                 <p>
                                	<label>Coach:</label>
                                	
                                	
                                	<?php }
                                	
                                	else 
			{ 
			?><p><label>Coach<?php echo $k ;?> :</label><?php 
			}
			
                                	?>
                                	
                                    <span><?php 
			
			if ($k==0)
			{
				echo $strcombo = '<select name="fldCoachname" >';
			}
			else {
				echo $strcombo = '<select name="fldCoachname'.$k.'" >';
			}
	
			
			echo $strcombo = '<option value = "">Select Coach</option>';
			$categorylist=$func->selectTableOrder(TBL_HS_AAU_COACH,"fldId,fldName","fldId");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
   				
	   			if($sportslist[$k]['coachnameid'] == $categorylist[$i]['fldId'])	
	   			{
	  		    echo '<option value ="'.$categorylist[$i]['fldId'].'" selected="selected" >'.$categorylist[$i]['fldName'].'</option>';
	   			}
   			
   			else 
   			
	   			{
	   			echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldName'].'</option>';
	   			}
   			
            }
			echo $strcombo = '</select>';
			
			?>
			</span><font color="#0000ff">*</font>
                                </p>
                             <?php }?> <?php
                             for ($k=$sportscount;$k<=25;$k++)
		{ ?>
			<p style="display:none" id="trs_<?php echo $k ;?>">
			<label>Sport <?php echo $k ;?> :</label>
			<span>

			<?php  
			echo $strcombo = '<select name="fldSport'.$k.'">';
			echo $strcombo = '<option value = "">Select Sport</option>';
			$categorylist=$func->selectTableOrder(tbl_sports,"fldId,fldSportsname","fldId");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
  		    echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldSportsname'].'</option>';
            }
			echo $strcombo = '</select>';
			?>
			</span>
			
			</p>
		
			<p style="display:none" id="trc_<?php echo $k ;?>">
			<label>Coach <?php echo $k ;?> :</label>
			<span>
			<?php  
			echo $strcombo = '<select name="fldCoachname'.$k.'" >';
			echo $strcombo = '<option value = "">Select Coach</option>';
			$categorylist=$func->selectTableOrder(TBL_HS_AAU_COACH,"fldId,fldName","fldId");
			for ($i=0;$i<count($categorylist);$i++) 
   			{
  		    echo '<option value ="'.$categorylist[$i]['fldId'].'" >'.$categorylist[$i]['fldName'].'</option>';
            }
			echo $strcombo = '</select>';
			?>
			
			</span>
		</p>
				
		<?php
		 }
		 
		 ?>

        
                                <p>
                                	<label>&nbsp;</label>
                                    <span><input type="hidden" name="currentrow" value="<?php echo $sportscount; ?>" id="currentrow">
			<input type="hidden" name="totalcount" value="25" id="totalcount">

			<a href="#" onclick="javascript:addfields()" style="text-decoration: none"> Add Fields  </a>
			<span id="remfield" style="display:none"><a href="#" onclick="javascript:removefields()" style="text-decoration: none"> Remove Fields  </a></span>
			</span>
                                </p>
                                
                               
								 <p>
                                	<label>Athlete Url :</label>
                                    <span><input type="text" name="fldAthleteUrl" id="fldAthleteUrl" value="<?=$fldAthleteUrl?>" >
                                </p>
								
								                           
                                
                                
                                                                                                                     
                                
                                
                                
                                
                                 
                                <p>
                                	<label>&nbsp;</label>
                                    <span><input type="hidden" name="userType" value="<?=($userType!="")?$userType:""?>">
			<input type="hidden" name="oldcode" value="<?=($oldcode)?$oldcode:$code?>">
			<input type="hidden" name="isSubmit" value="save">
			
		<? /*	<input type="hidden" name="oldName" value="<?=$userOldName?>">
			<input type="hidden" name="oldEmail" value="<?=$userOldEmail?>"> */ ?>
		<input type="submit" name="submit" value="Submit">
		<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="history.go(-1)">
		</span>
                                </p>
                         <!--   <p style="margin:auto; padding:10px 248px;">Log in | <a href="#" style="color:#086AA8;">Lost your password?</a></p>-->
                            </form>
                            </div>
  </div>
  
  </div>
    </div>
  </div>
</div>


<?php include('footer.php'); ?>
</body>
</html>


