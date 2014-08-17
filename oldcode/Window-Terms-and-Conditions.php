<?php
include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
require_once('zipcode.class.php');
session_start();
	$z = new zipcode_class;
	
$func = new COMMONFUNC;
$db = new DB;
$flag=0;

$college_info =$func->selectTableOrder(TBL_COLLEGE,'fldId,fldAddress,fldCity,fldState,fldZipCode',"fldId","where fldId=".$_GET['fldid']);
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
    
    		
    var	address="<?php echo $college_info[0]['fldAddress'].", ".$college_info[0]['fldCity'].", ".$college_info[0]['fldState']." ,".$college_info[0]['fldZipCode'];?>"
    
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

  <body onload="initialize()">
   
      <div id="map_canvas" style="width: 500px; height: 300px"></div>
   
  </body>
</html>