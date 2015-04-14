<!DOCTYPE html>
<?php
    require "connect.php";
	date_default_timezone_set("Asia/Singapore");
?>
<html>
<head>
    <title>Report Event - CMS</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="navScript.js"></script>
    <style type="text/css">
        h1{
            padding: 0 200px 15px 0;
            border-bottom: 1px solid #E5E5E5;
        }
        
    </style>
	
	<?php
		if($_SESSION['usertype'] != 'superuser' && $_SESSION['usertype'] != 'admin') {
			//header('Location: ./index.php');
			echo "You are not authorized to do so!";
			die();
		}
	?>
</head>
    
<body id="reportEvent">
<?php
    require "navi.php";
	
	//Twitter Header
	require "twitter/codebird.php";
	\Codebird\Codebird::setConsumerKey("LfFIv5xEI5uc0MA702OGi5NGW", "6EWXRBEgZeL9hSdaEiuhutRtJfUEG7gjQy1uegGntcOXi0L8IU");
	$cb = \Codebird\Codebird::getInstance();
	$cb->setToken("3138607182-BX7i90oZ8IjocClTxtPnI7sNeS3DNe0Q84hw6yJ", "oimG7r7poDmxnMYNKhQdAqm9UUkAXmCjYRTBsVXpVmphS");
	
	// require Facebook PHP SDK
	// see: https://developers.facebook.com/docs/php/gettingstarted/
	require "facebook/facebook.php";
	 
	// initialize Facebook class using your own Facebook App credentials
	// see: https://developers.facebook.com/docs/php/gettingstarted/#install
	$config = array();
	$config['appId'] = "1379860895645727";
	$config['secret'] = "e2a6559ea52c30a5bc3cf7f17ea407bc";
	$config['fileUpload'] = false; // optional
	
	$fb_accesstoken = "CAATmZBeaGQB8BACvQdmiwEEYDdKdDqIkvgtwgsLZBNmxVQMt1SZAp6AUCUlRTTlpg28ijO0nxZB7OoVyOpZC7wUF9LO531stdB6BHkMDVled5nPWkRH6hEYKfM7Ni4GqprXZBtMP4zfH09BKZAgzsCCaZCRleWpVq3V8Brycn5hFe2X8bIFxtuNXwRBdOtetC4zvIhcYxD4IzcXwYwnz6ZAnst8fDmrvnRqkZD";
?>
    
<!-- POST function -->
<?php
	//Global Declaration
	$receiver = 'zpek001@e.ntu.edu.sg';
	
    if($_POST){
        $postcode = $_POST['postcode'];
        $nric = $_POST['reporterNRIC'];
        $name = $_POST['reporterName'];
        $contact = $_POST['contactNo'];
        $street = $_POST['streetname'];
        $blockno = $_POST['block'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        
		if($type == 1)
		{
			$type_str = 'To be confirmed';
		}
		else if ($type == 2)
		{
			$type_str = 'Dengue';
		}
		else if($type == 3)
		{
			$type_str = 'Haze';
		}
		else{
			$type_str = 'Unknown';
		}
			
        // Save details into database
        $result = $db->query("INSERT INTO table_event (type, postcode, street, description, reporterName, reporterIC, reporterContact, blockNo) VALUES (" . $type . "," . $postcode . ",'" . $street . "','" . $description . "','" . $name . "','" . $nric . "','" . $contact . "','" . $blockno . "')");
        if($result){
            // Search database see if geocode already exists
            // If exists, dont need to save into database
            $result = $db->query("SELECT * FROM table_geocode WHERE postcode=" . $postcode);
            //if($result->num_rows) {
			if(true) { //Skip geocode
                // Successfully retrieve from database. Not sure what to do here :/
                $to      = $receiver; //'zpek001@e.ntu.edu.sg';
                $subject = 'New Event Reported!';
                $message = '
                <html>
                <head>
                <title>New Event!</title>
                </head>
                <body>
                <h3>New Event Reported @ ' . $blockno . ' ' . $street . ', S(' . $postcode . ')</h3>
				<p>Time: '.date('d/m/Y h:i:s A').'</p>
                <p>Name of Reporter: ' . $name . '</p>
                <p>Contact of Reporter: ' . $contact . '</p>
                <p>Type: ' . $type_str. '</p>
                <p>Description: ' . $description . '</p>
                </body>
                </html>
                ';
                $headers = 'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                    'From: cz3003@arbalestx.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                if(mail($to, $subject, $message, $headers)) {
                    //echo 'success!';   
                }
                else {
                    echo "failed to send email";
                }   
            }
            // Convert to geocode location and save into database
            else {
                // get latitude, longitude and formatted address
                $data_arr = geocode($_POST['postcode']);

                // if able to geocode the address
                if($data_arr){
                    $latitude = $data_arr[0];
                    $longitude = $data_arr[1];
                    $formatted_address = $data_arr[2];   
                    if($result = $db->query("INSERT INTO table_geocode VALUES ('" . $postcode . "','" . $latitude . "','" . $longitude . "')")) {
                        $to      = $receiver; //'zpek001@e.ntu.edu.sg'
                        $subject = 'New Event Reported!';
                        $message = '
                        <html>
                        <head>
                        <title>New Event!</title>
                        </head>
                        <body>
                        <h3>New Event Reported @ ' . $blockno . ' ' . $street . ', S(' . $postcode . ')</h3>
						<p>Time: '.date('Y-m-d').'</p>
                        <p>Name of Reporter: ' . $name . '</p>
                        <p>Contact of Reporter: ' . $contact . '</p>
                        <p>Type: ' . $type_str. '</p>
                        <p>Description: ' . $description . '</p>
                        </body>
                        </html>
                        ';
                        $headers = 'MIME-Version: 1.0' . "\r\n" .
                            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                            'From: cz3003@arbalestx.com' . "\r\n" .
                            'Reply-To: webmaster@example.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                        if(mail($to, $subject, $message, $headers)) {
                            // Successfully send email
                            //echo 'success!';
                        }
                        else {
                            echo "failed to send email";
                        }   
                    }
                    else {
                        echo "Sorry, we failed to log the location. Please try again.";   
                    }
                }
                else {
                    echo "We are experiencing problems in retrieving your location. Please try again later.";   
                }
            }
			
			
			//Finally, post to twitter
			$msg = date('d/m/Y h:i:s A').' - '.$type_str.' @ ' . $blockno . ' ' . $street . ', S(' . $postcode . ')';
			$reply = $cb->statuses_update(array(
			  "status" => $msg
			));

			//echo "Twitter: ".json_encode($reply)."<br\>";	//Prints out error/success message hidden from view
			
			// post to Facebook
			$fb = new Facebook($config);

			// define your POST parameters (replace with your own values)
			$params = array(
			  "access_token" => $fb_accesstoken, // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
			  "message" => $msg //,
			  //"link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
			  //"picture" => "http://i.imgur.com/lHkOsiH.png",
			  //"name" => "This is my name.",
			  //"caption" => "www.pontikis.net",
			  //"description" => "This is my description."
			);
			// see: https://developers.facebook.com/docs/reference/php/facebook-api/
			try {
			  $ret = $fb->api('1422424568063359/feed', 'POST', $params);
			  $result = "Success";
			} catch(Exception $e) {
			  $result = $e->getMessage();
			}

			if(result != "Success") //Error
			{
				echo "\r\nFacebook: ".$result;
			}
        }
        else {
            echo "error: " . mysqli_error($db);   
        }
    }
?>
<!-- End POST -->
    
    
    <!-- report event form begins -->
    <div class="container">
    <div class="jumbotron">
	
    <h1>Report Event</h1>
    <form class="form-horizontal" role="form" method="post">
        <div class="form-group">
            <label for="reporterNRIC" class="col-sm-2 control-label">Reporter NRIC:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="reporterNRIC" placeholder="Enter NRIC">
            </div>
        </div>
		
		 <div class="form-group">
            <label for="reporterName" class="col-sm-2 control-label">Reporter Name:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="reporterName" placeholder="Name">
            </div>
        </div>
        
		<div class="form-group">
            <label for="contactNo" class="col-sm-2 control-label">Contact No.:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="contactNo" placeholder="Contact Number">
            </div>
        </div>
        
		<div class="form-group">
            <label for="streetName" class="col-sm-2 control-label">Address:</label>
            <div class="col-sm-1">
                <input type="text" name="block" class="form-control" id="postal" placeholder="Blk">
            </div>
            <div class="col-sm-4">
                <input type="text" name="streetname" class="form-control" id="postal" placeholder="Street Name">
            </div>
        </div>
		
        <div class="form-group">
            <label for="postcode" class="col-sm-2 control-label">Postal Code:</label>
            <div class="col-sm-5">
                <input type="text" name="postcode" class="form-control" id="postal" placeholder="Postal Code">
            </div>
        </div>
        
        <div class="form-group">
            <label for="type" class="col-sm-2 control-label">Type:</label>
            <div class="col-sm-5">
                <select class="form-control" name="type">
                    <option value="1">To Be Confirmed</option>
                    <option value="2">Dengue</option>
                    <option value="3">Haze</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description:</label>
            <div class="col-sm-5">
                <textarea rows="5" class="form-control" name="description" placeholder="Enter Description of Event"></textarea>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-9">
                <input type="submit" name= "submit" class="btn btn-primary" value="Submit">
                <input type="reset" name="reset" class="btn btn-default" value="Reset">
            </div>
        </div>
    </form>
    </div>
    </div>
    <!-- report event form ends -->
    
<?php
    // function to geocode address, it will return false if unable to geocode address
    function geocode($address){

        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address={$address}";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address 
        if($resp['status']='OK'){
            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];

            // verify if data is complete
            if($lati && $longi && $formatted_address){

                // put the data in the array
                $data_arr = array();            

                array_push(
                    $data_arr, 
                        $lati, 
                        $longi, 
                        $formatted_address
                    );
                return $data_arr;

            }
            else{
                return false;
            }

        }
        else{
            return false;
        }
    }
?>
<?php
    require "footer.php";
?>

    
</body>
</html>