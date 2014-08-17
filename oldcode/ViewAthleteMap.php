<?php

include_once("inc/common_functions.php");		//for common function

include_once("inc/page.inc.php");	

require_once('zipcode.class.php');

session_start();

	$z = new zipcode_class;

	

if(($_SESSION['mode']=="")or($_SESSION['FRONTEND_USER']==""))

{

	header("Location:index.php");

}

$func = new COMMONFUNC;

$db = new DB;

$flag=0;



$college_info =$func->selectTableOrder(TBL_ATHELETE_REGISTER,'fldId,fldSchool',"fldId","where fldId=".$_GET['fldId']);

$team_info=$func->selectTableOrder(TBL_HS_AAU_TEAM,'fldId,fldAddress,fldSchoolname,fldCity,fldState,fldZipcode',"fldId","where fldId=".$_GET['fldId']);

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8" />

    <title>Google Maps For view Location</title>

    <script src="//maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?php echo MAPS_APIKEY; ?>" type="text/javascript"></script>

    <script type="text/javascript">



    var map = null;

    var geocoder = null;



    function initialize() {

      if (GBrowserIsCompatible()) {

        map = new GMap2(document.getElementById("map_canvas"));

        map.setCenter(new GLatLng(37.4419, -122.1419), 13);

        geocoder = new GClientGeocoder();

      }

     showAddress();

      

    }



    function showAddress() {

    

    		

    var	address="<?php echo $team_info[0]['fldSchoolname'].",".$team_info[0]['fldAddress'].", ".$team_info[0]['fldCity'].", ".$team_info[0]['fldState']." ,".$team_info[0]['fldZipcode'];?>"

    

      if (geocoder) {

        geocoder.getLatLng(

          address,

          function(point) {

            if (!point) {

              alert(address + " not found");

            } else {

              map.setCenter(point, 13);

              var marker = new GMarker(point);

              map.addOverlay(marker);



              // As this is user-generated content, we display it as

              // text rather than HTML to reduce XSS vulnerabilities.

              marker.openInfoWindow(document.createTextNode(address));

            }

          }

        );

      }

    }

    </script>

  </head>



  <body onLoad="initialize()">

   

   

      <div id="map_canvas" style="width: 500px; height: 300px"></div>

   

  </body>

</html>