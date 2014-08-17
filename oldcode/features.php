<?php 

include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	

//for paging
$func = new COMMONFUNC;
$db = new DB;
$flag=0;
session_start();

if(($_SESSION['mode']!="")or($_SESSION['FRONTEND_USER']!=""))
{
	//header("Location:myaccount.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>College Prospect Network - Features | CPN</title>
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>

<script src="/js/jquery-1.6.1.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
                
</head>

<body>

<?php 
include('header.php');
$message = $_REQUEST['msg'];
 ?>

<div class="container">
	<div class="innerWraper">
		<div class="middle-bg">	
		<!--Inner Container -->
		<div class="home-container features">
		
		
		<h1>Features</h1>

		
			<!--1st col-->
			<div class="col" style="height:1015px;position:relative;">
				<h2>College Programs</h2>	
				<a href="http://www.youtube.com/embed/DMDissmRpkA?iframe=true&width=960&height=670" title="College Programs Tour - <a href='/Registration-Type.php'>Signup Now for 5-Day FREE Trial</a>" rel="video"><img src="/img/college-programs.jpg" alt="College Programs Tour" /></a>
				<p>College Prospect Network is the only recruiting website that screens our athletes before allowing them to register. Join today and gain access to our entire database of players who have all been approved and rated by the people who see them play every day, their high school and AAU coaches. </p>
				<p>You can message the athlete and their coach, view the athletes’ stats and see ratings on their intangibles so you can find the perfect fit for your program. </p>
				<p><a href="http://www.youtube.com/embed/DMDissmRpkA?iframe=true&width=960&height=670" title="College Programs Tour - <a href='/Registration-Type.php'>Signup Now for 5-Day FREE Trial</a>" rel="video">Watch the 30-second video</a> for a quick preview then click the button below to join the <b>Free 5-Day Trial</b> today and find your difference-maker. </p>
				<div class="listhead">Features:</div>
				<ul style="margin-bottom:32px;">
					<li>Access to Our Exclusive Database of Prospects</li>
					<li>Direct Messaging to the Athletes and Their Coaches</li>
					<li>Communication System that Follows the NCAA Recruiting Calendar</li>
					<li>View and Request Game Film</li>
                    <li>Easy-to-Use Athlete Search</li>
                    <li>Advertise Your Program</li>
				</ul>			
				<div class="listhead">Pricing Options:</div>
				<div class="pricing" style="margin-bottom:0px;"><span class="price-large">$14.99</span><span class="duration"> / month</span></div>
				<hr class="priceline" />
				<div class="pricing" style="margin-bottom:0px;"><span class="price-or">or</span> <span class="price-med-black">$158.88</span><span class="duration"> / year</span><span class="savings" style="margin-left:45px;">Save $21.00</span></div>
				<hr class="priceline" />
				<div class="pricing"><span class="price-or">or</span> <span class="price-med-black">$359.64</span><span class="duration"> / 3-years</span><span class="savings2">Save $180.00</span></div>
				<div class="box-signup">
                    <div class="signup-btn">
                        <a href="/Registration-Type.php" title="Signup Now for 5-Day FREE Trial"><img src="/img/collegescout-btn.png" /></a>
                    </div>
                </div>
			</div>
			
			<!--2nd col-->
			<div class="col" style="height:1015px;position:relative;">
				<h2>High School & AAU Coaches</h2>
				<a href="http://www.youtube.com/embed/ykBIOoPuByQ?iframe=true&width=960&height=670" rel="video" title="High School & AAU Coaches Tour - <a href='/Registration-Type.php'>Signup Now for FREE</a>"><img src="/img/HSCoaches.jpg" alt="High School & AAU Coaches Tour" /></a>
				<p>College Prospect Network understands that you care about your student-athletes and want to see them succeed. As such, our website was designed to make it as easy as possible for you to help your players connect with a college program that fits their talent level, desire to play and personality. </p>
				<p>The college recruiting world is full of people attempting to exploit young men and women but <b>CPN is 100 percent free for you and your athletes to join</b>. We will never ask for any fees from you or the athlete because we refuse to make economics a barrier to playing college sports. </p>
				<p><a href="http://www.youtube.com/embed/ykBIOoPuByQ?iframe=true&width=960&height=670" rel="video" title="High School & AAU Coaches Tour - <a href='/Registration-Type.php'>Signup Now for FREE</a>">Watch the 30-second video</a> for a quick tour and then register to begin helping your athletes find a great opportunity to continue playing the sport they love. </p>
				<div class="listhead">Features:</div>
				<ul style="margin-bottom:15px;">
					<li>100 Percent Free for You and Your Athletes</li>
					<li>Help Your Athletes Get Recruited</li>
					<li>Interact with College Coaches on All Levels</li>
					<li>Quick and Easy to Use</li>
                    <li>Network with Other High School/AAU Coaches</li>
				</ul>	
				<div class="listhead">Pricing:</div>
	            <div class="pricing" style="margin-bottom:105px;"><span class="price-free">FREE</span></div>
				<div class="box-signup">
                    <div class="signup-btn">
                        <a href="/Registration-Type.php" title="Signup Now for FREE"><img src="/img/hscoach-btn.png" /></a>
                    </div>
                </div>
			</div>
			
			<!--3rd col-->
			<div class="col last" style="height:1015px;position:relative;">
				<h2>Athletes</h2>
				<a href="http://www.youtube.com/embed/Deig0h82ifk?iframe=true&width=960&height=670" rel="video" title="Athlete Tour - <a href='/Registration-Type.php'>Signup Now for FREE</a>"><img src="/img/athletes.jpg" alt="Athlete Tour" /></a>
				<p>Are you talented enough to play college sports but for some reason you are under-recruited? It happens every year to hundreds of athletes all over the country but College Prospect Network is here to help. <b>It is 100 percent free for you to join our site</b>. </p>
				<p>All you have to do is apply by clicking the link below and fill out the application form. Once your application is reviewed to ensure that you are a good fit for the site, you will be notified via email and you can begin finding a great college program where you can excel.  </p>
				<p><a href="http://www.youtube.com/embed/Deig0h82ifk?iframe=true&width=960&height=670" rel="video" title="Athlete Tour - <a href='/Registration-Type.php'>Signup Now for FREE</a>">Watch the 30-second video</a> for a quick tour and then register to find a great opportunity to continue playing the sport you love. </p>
				<div class="listhead">Features:</div>
				<ul style="margin-bottom:85px;">
					<li>100 Percent Free</li>
					<li>Be Found by Colleges at All Levels</li>
					<li>Search for Colleges That Need You</li>
					<li>Direct Messaging to College and High School/AAU Coaches</li>
				</ul>	
				<div class="listhead">Pricing:</div>
                <div class="pricing" style="margin-bottom:106px;"><span class="price-free">FREE</span></div>
				<div class="box-signup">
                    <div class="signup-btn">
                        <a href="/Registration-Type.php" title="Signup Now for FREE"><img src="/img/athlete-btn.png" /></a>
                    </div>
                </div>
            </div>
	
			
			<div class="clear"></div>
			
							
		</div>	
		<!--//end:Inner Container -->
		</div>
	</div>
</div>
	


  <?php include('footer.php'); ?>      

    <script type="text/javascript" charset="utf-8">

  $(document).ready(function(){
  $("a[rel^='video']").prettyPhoto({
        deeplinking: false,
        allow_resize: true,
        autoplay: true
  });
});

</script>
</body>

</html>    