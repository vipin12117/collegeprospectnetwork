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
<title>College Prospect Network - Home | CPN</title>
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" src="javascript/functions.js"></script>

<script src="/js/jquery-1.6.1.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
                
</head>

<body onload="">

<?php 
include('header.php');
$message = $_REQUEST['msg'];
 ?>

<div class="container">
	<div class="innerWraper">
		<div class="middle-bg">	
		<!--Inner Container -->
		<div class="home-container">
		
		
			<!--Banner-->
			<p style="margin-bottom:25px;">
			<img src="/img/home-banner.jpg" style="border-radius: 0px;" alt="No Athlete Left Unscouted - Linking Athletes with College Scouts | College Prospect Network" title="No Athlete Left Unscouted - Linking Athletes with College Scouts | College Prospect Network" />
			</p>
			<!--//end Banner-->
		
			<!--1st col-->
			<div class="col" style="height:760px;position:relative;">
				<h2>College Programs</h2>	
				<a href="http://www.youtube.com/embed/DMDissmRpkA?iframe=true&width=960&height=670" title="College Programs Tour - <a href='/Registration-Type.php'>Signup Now for 5-Day FREE Trial</a>" rel="video"><img src="/img/college-programs.jpg" alt="College Programs Tour" /></a>
				<p>College Prospect Network is the only recruiting website that screens our athletes before allowing them to register. Join today and gain access to our entire database of players who have all been approved and rated by the people who see them play every day. <a href="/features.php" title="Features">Read More</a></p>
				<div class="listhead">Features:</div>
				<ul style="margin-bottom:14px;">
					<li>Access to Our Exclusive Database of Prospects</li>
					<li>Direct Messaging to the Athletes and Their Coaches</li>
					<li>Communication System that Follows the NCAA Recruiting Calendar</li>
					<li>View and Request Game Film</li>
                    <li>Easy-to-Use Athlete Search</li>
                    <li>Advertise Your Program</li>
				</ul>			
				<div class="listhead">Pricing:</div>
                <div class="pricing"><span class="price-large">$14.99</span><span class="duration"> / month</span></div>

                <div class="box-signup">
                    <a href="/features.php" title="View All High School & AAU Coaches Features" class="bluelarge">View All Features</a>
                    <div class="signup-btn">
                        <a href="/Registration-Type.php" title="Signup Now for 5-Day FREE Trial"><img src="/img/collegescout-btn.png" /></a>
                    </div>
                </div>
			</div>
			
			<!--2nd col-->
			<div class="col" style="height:760px;position:relative;">
				<h2>High School & AAU Coaches</h2>
				<a href="http://www.youtube.com/embed/ykBIOoPuByQ?iframe=true&width=960&height=670" rel="video" title="High School & AAU Coaches Tour - <a href='/Registration-Type.php'>Signup Now for FREE</a>"><img src="/img/HSCoaches.jpg" alt="High School & AAU Coaches Tour" /></a>
				<p>College Prospect Network understands that you care about your student-athletes and want to see them succeed. As such, our website is designed to make it as easy as possible for you to help your players connect with a college program that fits their talent level and personality. <a href="/features.php" title="Features">Read More</a></p>
				<div class="listhead">Features:</div>
				<ul style="margin-bottom:64px;">
					<li>100 Percent Free for You and Your Athletes</li>
					<li>Help Your Athletes Get Recruited</li>
					<li>Interact with College Coaches on All Levels</li>
					<li>Quick and Easy to Use</li>
                    <li>Network with Other High School/AAU Coaches</li>
				</ul>	
				<div class="listhead">Pricing:</div>
	            <div class="pricing"><span class="price-free">FREE</span></div>
				<div class="box-signup">
				    <a href="/features.php" title="View All High School & AAU Coaches Features" class="bluelarge">View All Features</a>
                    <div class="signup-btn">
                        <a href="/Registration-Type.php" title="Signup Now for FREE"><img src="/img/hscoach-btn.png" /></a>
                    </div>                    
                </div>
			</div>
			
			<!--3rd col-->
			<div class="col last" style="height:760px;position:relative;">
				<h2>Athletes</h2>
				<a href="http://www.youtube.com/embed/Deig0h82ifk?iframe=true&width=960&height=670" rel="video" title="Athlete Tour - <a href='/Registration-Type.php'>Signup Now for FREE</a>"><img src="/img/athletes.jpg" alt="Athlete Tour" /></a>
				<p>Are you talented enough to play college sports but for some reason you are under-recruited? It happens every year to thousands of athletes all over the country but College Prospect Network is here to help. It is 100 percent free for you to join our site. <a href="/features.php" title="Features">Read More</a></p>
				<div class="listhead">Features:</div>
				<ul style="margin-bottom:84px;">
					<li>100 Percent Free</li>
					<li>Be Found by Colleges at All Levels</li>
					<li>Search for Colleges That Need You</li>
					<li>Direct Messaging to College and High School/AAU Coaches</li>
				</ul>	
				<div class="listhead">Pricing:</div>
                <div class="pricing"><span class="price-free">FREE</span></div>
				<div class="box-signup">
				    <a href="/features.php" title="View All Athletes Features" class="bluelarge">View All Features</a>
                    <div class="signup-btn">
                        <a href="/Registration-Type.php" title="Signup Now for FREE"><img src="/img/athlete-btn.png" /></a>
                    </div>                    
                </div>
			</div>
			
			<div class="clear"></div>
			
			<hr class="homedivider"/>

			
			<!--2nd row-->
			
			<div class="col-1">
				<h2 style="margin-bottom:15px;">Testimonials</h2>
				
				<p style="margin-bottom:6px;font-size:14px;">"This is a great site and innovative idea. I'm excited about the ways it's going to make it easy for me to help my kids gain exposure." </p>
				<p style="margin-bottom:0px;text-align:right;font-size:13px;font-weight:bold;color:#222;">Matt Conklin</p>
                                                                          <p style="margin-bottom:0px;text-align:right;font-weight:normal;color:#222;font-style:italic;">Boys Basketball</p>
				<p style="margin-bottom:0px;text-align:right;">St John Vianney High School, NJ</p>				
				<hr style="border-top: 1px solid #ddd"/>
				
				<p style="margin-bottom:10px;font-size:14px;">"During season coaches don't have a lot of extra time but this site is really quick and easy to use. I have several athletes who deserve more attention than they're currently receiving so CPN is a perfect fit for my program."  </p>
				<p style="margin-bottom:0px;text-align:right;font-size:13px;font-weight:bold;color:#222;">Norbert Herriott</p>
                                                                          <p style="margin-bottom:0px;text-align:right;font-weight:normal;color:#222;font-style:italic;">Football</p>
				<p style="margin-bottom:0px;text-align:right;">Booker T Washington High School, FL</p>			
		
				
			</div>
			
                                                        <div class="col-2 last">
                                                            <h2>Supported By</h2>
                                                            
                                                            <!--Logo Grid-->
                                                            <div class="hslogos">
                                                                <div class="row">
                                                                    <img src="/img/HS-Logos/St_John_Vianney_NJ.jpg" alt="St John's Vianney High School, NJ" title="St John's Vianney High School, NJ" />
                                                                    <img src="/img/HS-Logos/Grand_Lake_High_School_Louisiana.jpg" alt="Grand Lake Hight School, LA" title="Grand Lake Hight School, LA" />
                                                                    <img src="/img/HS-Logos/South_Houston_High_School.jpg" alt="South Houston High School, TX" title="South Houston High School, TX" class="last" />    
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <img src="/img/HS-Logos/Booker_T_Washington_High_Miami.jpg" alt="Booker T. Washington High School, FL" title="Booker T. Washington High School, FL" />
                                                                    <img src="/img/HS-Logos/Detroit_Cass_Tech_High_School.jpg" alt="Detroit Cass Tech High School" title="Detroit Cass Tech High School, MI" />
                                                                    <img src="/img/HS-Logos/Lake_Charles_Lady_Lions.jpg" alt="Lake Charles Lady Lions" title="Lake Charles Lady Lions, LA"  class="last" />
                                                                    <div class="clear"></div>
                                                                </div>
                                                            </div>
                                                            <!--//End: Logo Grid-->
                                            
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