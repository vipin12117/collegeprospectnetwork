<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script><base href="http://localhost/collegeprospectnetwork/oldcode/" target="_blank">
<?$no_popup = 'yes';
if($no_popup != "yes")
{
?>
<style>
		.black_overlay{
			display: none;
			position: fixed;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			top: 7%;
			left: 27%;
			width: 600px;
			height: 400px;;
			padding: 16px;
			border: 2px solid #999999;
			background-color: white;
			z-index:1002;
			overflow: auto;
			padding:10px 10px 10px 10px;
		}
		
		.subnav {
		color:#4B4B4B;
		}
		.subnav:hover {
		color:#34A4B9;
		}
	</style>

<div id="light" class="white_content" style="background-color: #FFFFFF; border: 1px solid #B9B9B9; border-radius: 9px 9px 9px 9px; box-shadow: 3px 3px 4px 0 rgba(2, 2, 2, 0.5);" >				
<div style="float:left; text-align:center; padding-top:15px; font-size:16px;"> 
<img width="161" height="86" src="images/logo.jpg"><br />
<br />

	We are currently overhauling our website in preparation for the 2014 7-on-7 and AAU basketball season. The website will be down for a few weeks, but the upgrades and improvements will be worth the delay. Please check back periodically to see when we are up and running again. <br />
<br />


In the meantime, follow us on Twitter (@cpnsports) or email us at <a href="mailto:jharris@collegeprospectnetwork.com">jharris@collegeprospectnetwork.com</a>
</div>
</div>
<div id="fade" class="black_overlay"></div>

<script language="javascript">
function aaa()
{
	$(document.getElementById("light")).slideToggle(500);
	
	$(document.getElementById('fade')).fadeIn(200);
} 

aaa();
</script>
<?
}
?>
<div class="header-main">
    <div class="header-link">
	<?
    if($_SESSION['FRONTEND_USER']=="")
    {
	?>
	
		<ul>
			<li style="background:url(images/home-ico.jpg) no-repeat;">
				<a href="/" title="Home">Home</a><span>&nbsp;</span>
			</li>
			<li style="background:url(images/ico-2.jpg) no-repeat;">
				<a href="/features.php" title="Features">Features</a>
			</li>
			<!--<li style="background:url(images/ico-2.jpg) no-repeat;">
                <a href="http://collegeprospectnetwork.com/events" title="Events">Events</a>
				<!--<a href="Registration-Special-Event.php" title="Events">Events</a>
            </li>-->
			<li style="background:url(images/ico-2.jpg) no-repeat;">
                <a href="/page.php?page_name=about" title="About Us">About Us</a>
            </li>
			<li style="background:url(images/ico-3.jpg) no-repeat;">
				<a href="/page.php?page_name=contactus" title="Contact">Contact</a>
			</li>
			<li style="background:url(images/ico-4.jpg) no-repeat;">
				<a href="/login.php" title="Login">Login</a>
			</li>
		</ul>	
	      
	
	<?
        } else  {
	?>

		<ul>
			<li style="background:url(images/home-ico.jpg) no-repeat;">
				<a href="/myaccount.php" title="Home">Home</a><span>&nbsp;</span>
			</li>
			<li style="background:url(images/ico-2.jpg) no-repeat;">
				<a href="/features.php" title="Features">Features</a>
			</li>
			<li style="background:url(images/ico-2.jpg) no-repeat;">
                <a href="/page.php?page_name=about" title="About Us">About</a>
            </li>
			<li style="background:url(images/ico-3.jpg) no-repeat;">
				<a href="/page.php?page_name=contactus" title="Contact">Contact</a>
			</li>
			<li style="background:url(images/ico-4.jpg) no-repeat;">
				<a href="/myaccount.php" title="My Account">My Account</a>
			</li>
			<li style="background:url(images/ico-4.jpg) no-repeat;">
				<a href="/logout.php" title="Logout">Logout</a>
			</li>
		</ul>
	
	<?
      }
	?>
	
	<div class="social">
        <a href="https://www.facebook.com/pages/College-Prospect-Network/232206396857124" target="_blank" title="Follow us on Facebook"><img src="/img/social/facebook_24.png" alt="Follow us on Facebook" /></a>
        <a href="https://twitter.com/cpnsports" target="_blank" title="Follow @CPNSports on Twitter"><img src="/img/social/twitter_24.png" alt="Follow @CPNSports on Twitter" /></a>
        <a href="http://www.youtube.com/user/CollegeProspectNetwk" target="_blank" title="Follow us on Youtube"><img src="/img/social/youtube_24.png" alt="Follow us on Youtube" /></a>
        <a href="https://plus.google.com/101534417841883214590/posts" target="_blank" title="Follow us on Google+"><img src="/img/social/google_plus_24.png" alt="Follow us on Google+" style="position:relative;top:1px;"/></a>
    </div>
            
</div><!--//end:header-link-->
	
	
	<!--header link ends from here -->
	<div class="clr"></div>
	<!--Header starts from here -->
	<div>
		<div class="logo">
			<?
if($_SESSION['FRONTEND_USER']=="")
{
			?>
			<a href="/"><img src="images/logo.jpg" width="161" height="86" /></a>
			<?
                }
                else
                {
			?>
			<a href="/myaccount.php"><img src="images/logo.jpg" width="161" height="86" /></a>
			<?
                }
			?>
		</div>
		<div class="h-right" style="width:260px;">
			<?
if($_SESSION['FRONTEND_USER']=="")
{
			?>
			<p class="l-text">
				New User?
			</p>
			<p class="button">
				<a href="/Registration-Type.php"><img src="images/create-acc.jpg" /></a>
			</p>
			<?   }elseif($_SESSION['FRONTEND_USER']!=""){?>
			<p class="l-text">
				Welcome <?   echo $_SESSION['FRONTEND_USER'];?>
			</p>
			<p class="button">
				<a href="/myaccount.php" class="bluelarge" title="My Account">My Account</a>
				<?
if ($_SESSION['mode'] == "athlete") {
				?>
				&nbsp; | &nbsp; <a href="/ViewAthleteprofile.php" class="bluelarge" title="View Profile">View Profile</a>
				<?
                    }
				?>
				<?
if ($_SESSION['mode'] == "coach") {
				?>
				&nbsp; | &nbsp; <a href="/HsAauCoachProfile.php" class="bluelarge" title="View Profile">View Profile</a>
				<?
                    }
				?>
				<?
if ($_SESSION['mode'] == "college") {
				?>
				&nbsp; | &nbsp; <a href="/collegeprofile.php" class="bluelarge" title="View Profile">View Profile</a>
				<?
                    }
				?>
			</p>
			<?
                }
			?>
			<p style="float:right;margin-top:-33px;">
			
			<a href="http://collegeprospectnetwork.com/events"><img src="images/events.png" /></a>
			
			</p>
		</div>
		<div class="clr"></div>
	</div>
</div>
