<!DOCTYPE html>
<?php
    require "connect.php";
?>
<html>
<head>
    <title>Crisis Management System</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="navScript.js"></script>
    <?php
        require "map.php";
    ?>

	<!-- RSS script start -->
	<link href="jquery.zrssfeed.css" rel="stylesheet" type="text/css" />
	<script src="jquery.zrssfeed.js" type="text/javascript"></script>
	<script src="jquery.vticker.js" type="text/javascript"></script>
	<script>
	$(document).ready(function() {
		$('#rssfeed').rssfeed('http://www.haze.gov.sg/data/rss/nea_psi_3hr.xml',{}, function(e) {	
		$(e).find('div.rssBody').vTicker();
		});
	});
	</script>
	<!-- RSS script end -->
</head>

<body id="index">
<?php
    require "navi.php";
?>

<!-- Twitter Script Start -->
<?php
/*
require "twitter/codebird.php";
\Codebird\Codebird::setConsumerKey("LfFIv5xEI5uc0MA702OGi5NGW", "6EWXRBEgZeL9hSdaEiuhutRtJfUEG7gjQy1uegGntcOXi0L8IU");
$cb = \Codebird\Codebird::getInstance();
$cb->setToken("3138607182-BX7i90oZ8IjocClTxtPnI7sNeS3DNe0Q84hw6yJ", "oimG7r7poDmxnMYNKhQdAqm9UUkAXmCjYRTBsVXpVmphS");

$reply = $cb->statuses_update(array(
  "status" => "Put your message here. (Make sure no duplicates). View source to see if there is any errors."
));

echo "Twitter: ".json_encode($reply)."<br\>";	//Prints out error/success message hidden from view
*/
?>
<!-- Twitter Script End -->

<!-- Facebook Script Start -->
<?php
/*
// require Facebook PHP SDK
// see: https://developers.facebook.com/docs/php/gettingstarted/
require "facebook/facebook.php";
 
// initialize Facebook class using your own Facebook App credentials
// see: https://developers.facebook.com/docs/php/gettingstarted/#install
$config = array();
$config['appId'] = "1379860895645727";
$config['secret'] = "e2a6559ea52c30a5bc3cf7f17ea407bc";
$config['fileUpload'] = false; // optional
 
$fb = new Facebook($config);

// define your POST parameters (replace with your own values)
$params = array(
  "access_token" => "CAATmZBeaGQB8BAFKn5t7yZAK8TD196unVY2lZBSb9xI0aUNF6ua1oqG4anbmDyWXSjXRwUGsGThJZCZAK9WWKaZBuWiHYqm9t7tUErEslMCEDPuZBI0bVGwAqqF6utX3FTWA57IJ3YOHXDbppY2x1CXnZCFN03k7cRGszXuI8WGlaWoBrQd16emnBbDEpZCNZB0yUZD", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
  "message" => "This is my message3.",
  //"link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
  //"picture" => "http://i.imgur.com/lHkOsiH.png",
  //"name" => "This is my name.",
  //"caption" => "www.pontikis.net",
  //"description" => "This is my description."
);
 
// post to Facebook
// see: https://developers.facebook.com/docs/reference/php/facebook-api/
try {
  $ret = $fb->api('1422424568063359/feed', 'POST', $params);
  $result = "Successfully posted to facebook.";
} catch(Exception $e) {
  $result = $e->getMessage();
}

echo "\r\nFacebook: ".$result;
*/
?>
<!-- Facebook Script End -->
	
<!-- main body begins -->
<div class="container">
    <div class="jumbotron">
        <!-- Google Map -->
        <div style="float:left; width:auto">
            <div id="map-canvas"></div> 
        </div>
        
        <div class="container">
            <div style="float:left; padding:20px; width:auto">
                <h2>Filter Event View</h2>
                <div class="row" style="padding-left:20px; padding-bottom:5px">
                    <button class="btn btn-default" onclick="toggleHaze()">Toggle Haze</button></div>
                <div class="row" style="padding-left:20px; padding-bottom:5px">
                    <button class="btn btn-default" onclick="toggleDengue()">Toggle Dengue</button></div>
                <!--<div class="row" style="padding-left:20px; padding-bottom:5px">
                    <button class="btn btn-default" onclick="changeGradient()">Change gradient</button></div>
                <div class="row" style="padding-left:20px; padding-bottom:5px">
                    <button class="btn btn-default" onclick="changeRadius()">Change radius</button></div>
                <div class="row" style="padding-left:20px; padding-bottom:5px">
                    <button class="btn btn-default" onclick="changeOpacity()">Change opacity</button></div>-->
            </div>
			
			<div id = "rssfeed" style="float:left; padding-left:30px; width:260px;">
			</div>
			
			<!--<div
			  class="fb-like"
			  data-share="true"
			  data-width="450"
			  data-show-faces="true">
			</div>-->
        </div>
    </div>
</div>
    

<?php
    require "footer.php";
?>
    
<!-- main body ends -->
</body>

</html>