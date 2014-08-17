<?php
    include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    include_once ("inc/config.inc.php");
    //for paging
    session_start();
    $func = new COMMONFUNC;
    $func2 = new COMMONFUNC;
    $db = new DB;
    //$flag=1;
    $lnb = "2";
    $error_msg = '';
    $flag = 0;
    $debugstep = 0;
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script language="Javascript" src="javascript/functions.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
        <script language="javascript" type="text/javascript">
 
       //jQuery AJAX Calls     
        $(document).ready(function(){
            
            $("#fldSchool").change(function(){
                var ddlval=$("#fldSchool").val();
                
                if(ddlval == "") {
                    $("#AjaxResponse").html('');   
                    return;
                }
                //alert('ya');
                
                if(ddlval == "others") {
                    $("#txtschoolothers").show();
                    //document.getElementById("txtschoolothers").style.display = "";
                } else if(ddlval == "") {
                    $("#txtschoolothers").hide();
                    //document.getElementById("txtschoolothers").style.display = "none";
                    $.ajax({
                      url: 'addcollage-new.php?q='+ddlval,
                      success: function(data) {
                       $("#AjaxResponse").html(data);       
                      }
                    });
                } else {
                    $("#txtschoolothers").hide();
                    //document.getElementById("txtschoolothers").style.display = "none";
                    $.ajax({
                      url: 'addcollage-new.php?q='+ddlval,
                      success: function(data) {
                       $("#AjaxResponse").html(data);       
                      }
                    });
                }               
   
            });//dropdown change
            
        }); //document.ready
        
		</script>
	</head>
	<body>
		<!--header link starts from here -->
		<?php
            include ('header.php');
		?>
		<!--Header ends from here -->
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main" style="height:629px;">
							<h1>Event Registration</h1>
							<?php
							$error_msg=$_REQUEST['error'];
                            if ($error_msg=="full"){?>
							<span style="font-size:22px;margin-top:200px;color:#666666;text-decoration:none;text-align:center;">We're sorry, but this event is currently Full.Please use <a href="page.php?page_name=contactus" rel="" style="font-size:22px;">Contact Us</a> page to put your name on the waiting list.</span><?php } ?>
							<?php
							$error_msg=$_REQUEST['error'];
                            if ($error_msg=="145"){?>
							<span style="font-size:22px;margin-top:200px;color:#666666;text-decoration:none;text-align:center;">There are no upcoming events scheduled at this time. Please check back regularly or use the <a href="page.php?page_name=contactus" rel="" style="font-size:22px;">Contact Us</a> page to request an event in your city.	</span><?php } ?><br />
							<!--<div style="float:right;padding:40px;"><a href="page.php?page_name=contactus" rel="" style="font-size:20px;color:#FF0000;text-decoration:none;text-align:right;">Go To Contatus</a></div>-->
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