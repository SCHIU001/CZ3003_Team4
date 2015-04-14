<!DOCTYPE html>
<?php
    require "connect.php";
?>
<html>
<head>
    <title>Edit Event - CMS</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <style type="text/css">
        h1{
            padding: 0 200px 15px 0;
            border-bottom: 1px solid #E5E5E5;
        }
    </style>
</head>
    
<body>  
<?php
    require "navi.php";
?>
    <?php
        $id = $_GET['id'];
        $result = $db->query("SELECT reportID FROM table_dispatch
                                    WHERE eventID=" . $id . " LIMIT 1");
        $row = $result->fetch_assoc();
        $reportID =  $row['reportID'];

        if($_POST) {
            $status = $_POST['status'];
            $active = $_POST['active'];
            $dispatcher = $_POST['dispatcher'];
            $incharge = $_POST['incharge'];
            $dispatchdesc = $_POST['dispatchdesc'];
            
            $result = $db->query("SELECT * from table_dispatch WHERE reportID=" . $reportID);
            if($result){
                $result = $db->query("UPDATE table_event SET status='". $status . "',active='" . $active . "' WHERE eventID=" . $id);
                $result2 = $db->query("UPDATE table_dispatch SET dispatcher='" . $dispatcher . "',incharge='" . $incharge . "',description='" . $dispatchdesc . "' WHERE reportID=" . $reportID);
                if($result && $result2) {
                    $to      = 'zpek001@e.ntu.edu.sg';
                    $subject = 'Event Updated!';
                    $message = '
                    <html>
                    <head>
                    <title>Event Update!</title>
                    </head>
                    <body>
                    <h3>An update has been made to reportID ' . $reportID . '</h3>
                    <p>Status: ' . $status . '</p>
                    <p>Ongoing status: ' . $active . '</p>
                    <p>Person In Charge: ' . $incharge . '</p>
                    <p>Dispatch Description: ' . $dispatchdesc . '</p>
                    </body>
                    </html>
                    ';
                    $headers = 'MIME-Version: 1.0' . "\r\n" .
                        'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                        'From: cz3003@arbalestx.com' . "\r\n" .
                        'Reply-To: webmaster@example.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    if(mail($to, $subject, $message, $headers)) {
                        // Successfully sent email  
                    }
                    else {
                        echo "failed to send email";
                    }   
                }
                else {
                    /*echo "1";
                    echo "UPDATE table_event SET status='". $status . "',active='" . $active . "' WHERE eventID=" . $id;
                    echo "<br>";
                    echo "INSERT INTO table_dispatch (eventid, dispatcher,incharge,description) VALUES ('" . $id . "','" . $dispatcher . "','" . $incharge . "','" . $dispatchdesc . "')";
                    echo "Failed"; */  
                }
            }
            else {
                $result = $db->query("UPDATE table_event SET status='". $status . "',active='" . $active . "' WHERE eventID=" . $id);
                $result2 = $db->query("INSERT INTO table_dispatch (eventid, dispatcher,incharge,description) VALUES ('" . $id . "','" . $dispatcher . "','" . $incharge . "','" . $dispatchdesc . "')");
                if($result && $result2) {
                    $to      = 'zpek001@e.ntu.edu.sg';
                    $subject = 'Event Updated!';
                    $message = '
                    <html>
                    <head>
                    <title>Event Update!</title>
                    </head>
                    <body>
                    <h3>An update has been made to reportID ' . $reportIDMail . '</h3>
                    <p>Status: ' . $status . '</p>
                    <p>Ongoing status: ' . $active . '</p>
                    <p>Person In Charge: ' . $incharge . '</p>
                    <p>Dispatch Description: ' . $dispatchdesc . '</p>
                    </body>
                    </html>
                    ';
                    $headers = 'MIME-Version: 1.0' . "\r\n" .
                        'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                        'From: cz3003@arbalestx.com' . "\r\n" .
                        'Reply-To: webmaster@example.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    if(mail($to, $subject, $message, $headers)) {
                        // Successfully sent email  
                    }
                    else {
                        echo "failed to send email";
                    }  
                }
                else {
                    /*echo "UPDATE table_event SET status='". $status . "',active='" . $active . "' WHERE eventID=" . $id;
                    echo "<br>";
                    echo "INSERT INTO table_dispatch (eventid, dispatcher,incharge,description) VALUES ('" . $id . "','" . $dispatcher . "','" . $incharge . "','" . $dispatchdesc . "') WHERE eventID=" . $id;
                    echo "Failed";   */
                }
            }
        }

        if($result = $db->query("SELECT * FROM table_event 
                            JOIN table_event_status ON table_event.status=table_event_status.id 
                            JOIN table_event_type ON table_event_type.id=table_event.type
                            WHERE eventID=" . $id)) {
            $row = $result->fetch_assoc();
            $reporterName = $row['reporterName'];
            $reporterIC = $row['reporterIC'];
            $reporterContact = $row['reporterContact'];
            $block = $row['blockNo'];
            $street = $row['street'];
            $postcode = $row['postcode'];
            $type = $row['type'];
            $description = $row['description'];
            $status = $row['status'];
            $active = $row['active'];
    }

    ?>
    <div class="container">
    <div class="jumbotron">
        <h1>Event Details</h1>
        <form class="form-horizontal" role="form" method="post">
        <div class="form-group">
            <label for="reporterNRIC" class="col-sm-2 control-label">Reporter NRIC:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" readonly="true" name="reporterNRIC" value=<?php echo $reporterIC; ?> />
            </div>
        </div>
		
		 <div class="form-group">
            <label for="reporterName" class="col-sm-2 control-label">Reporter Name:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="reporterName" readonly="true" value=<?php echo $reporterName; ?> />
            </div>
        </div>
        
		<div class="form-group">
            <label for="contactNo" class="col-sm-2 control-label">Contact No.:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="contactNo" readonly="true" value=<?php echo $reporterContact; ?> />
            </div>
        </div>
        
		<div class="form-group">
            <label for="streetName" class="col-sm-2 control-label">Address:</label>
            <div class="col-sm-1">
                <input type="text" name="block" class="form-control" id="postal" readonly="true" value=<?php echo $block; ?> />
            </div>
            <div class="col-sm-4">
                <input type="text" name="streetname" class="form-control" id="postal" readonly="true" value=<?php echo $street; ?> />
            </div>
        </div>
        <div class="form-group">
            <label for="postcode" class="col-sm-2 control-label">Postal Code:</label>
            <div class="col-sm-5">
                <input type="text" name="postcode" class="form-control" id="postal" readonly="true" value=<?php echo $postcode; ?> />
            </div>
        </div>
        
        <div class="form-group">
            <label for="type" class="col-sm-2 control-label">Type:</label>
            <div class="col-sm-5">
                <input type="text" name="type" class="form-control" readonly="true" value=<?php echo $type; ?> />
            </div>
        </div>
        
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description:</label>
            <div class="col-sm-5">
                <textarea rows="5" class="form-control" name="description" readonly="true" value=><?php echo $description; ?></textarea>
            </div>
        </div>
            
        <h1>Event Status</h1>
        
        <div class="form-group">
            <label for="status" class="col-sm-2 control-label">Status:</label>
            <div class="col-sm-5">
                <select class="form-control" name="status">
                <?php
                    $result = $db->query("SELECT * FROM table_event_status");
                    if($result) {
                        $i = 1;
                            $statusresult = $db->query("SELECT status FROM table_event WHERE eventID=" . $id);
                            $eventstatus = $statusresult->fetch_assoc();
                        while ($row = $result->fetch_assoc()) {
                            if($eventstatus['status'] == $i) {
                                echo "<option value='" . $i++ . "' selected='selected'>" . $row['status'] . "</option>";
                            }
                            else {
                                echo "<option value='" . $i++ . "'>" . $row['status'] . "</option>";
                            }
                        }
                    }
                ?>
                </select>
            </div>  
        </div>    
            
        <div class="form-group">
            <label for="active" class="col-sm-2 control-label">Active:</label>
            <div class="col-sm-5">
                <select class="form-control" name="active">
                    <?php
                        if($active) {
                            echo "<option value='1' selected='selected'>Active</option>"; 
                            echo "<option value='0'>Inactive</option>";  
                        }
                        else {
                            echo "<option value='0' selected='selected' readonly='true'>Inactive</option>"; 
                            echo "<option value='1'>Active</option>";  
                        }
                    ?>
                </select>
            </div>
        </div>
        
        <!-- display dispatch details -->
        <?php
            if($reportID) {
                $result = $db->query("SELECT * FROM table_dispatch
                                        WHERE reportID=" . $reportID);
                $reportIDMail = $reportID;
                if($result) {
                    $row = $result->fetch_assoc();
                    $dispatcher = $row['dispatcher'];
                    $incharge = $row['incharge'];
                    $dispatchtime = $row['dispatchtime'];
                    $dispatchdesc = $row['description'];
                }
                else {
                    $result = $db->query("SELECT reportID FROM table_dispatch ORDER BY reportID DESC LIMIT 1");
                    $row = $result->fetch_assoc();
                    $reportID = $row['reportID'] + 1;
                    $reportIDMail = $reportID;
                    $dispatcher = 0;
                    $incharge = 0;
                    $dispatchtime = "";
                    $dispatchdesc = "";
                }
            }
            else {
                $result = $db->query("SELECT reportID FROM table_dispatch ORDER BY reportID DESC LIMIT 1");
                $row = $result->fetch_assoc();
                $reportID = $row['reportID'] + 1;
                $reportIDMail = $reportID;
                $dispatcher = 0;
                $incharge = 0;
                $dispatchtime = "";
                $dispatchdesc = ""; 
            }
        ?>
        <div class="form-group">
            <label for="reportID" class="col-sm-2 control-label">Report ID:</label>
            <div class="col-sm-5">
                <input type="text" name="type" class="form-control" readonly="true" value=<?php echo $reportID; ?> />
            </div>
        </div>
            
        <div class="form-group">
            <label for="dispatcher" class="col-sm-2 control-label">Dispatcher:</label>
            <div class="col-sm-5">
                <select class="form-control" name="dispatcher">
                <?php 
                    if($dispatcher == "") {
                        echo '<option value="moh">Minstry of Health (MOH)</option>';
                        echo '<option value="nea">National Environmental Agency (NEA)</option>';
                    }
                    else {
                        if($dispatcher == "moh"){
                            echo '<option value="moh">Minstry of Health (MOH)</option>';
                            echo '<option value="nea">National Environmental Agency (NEA)</option>';
                        }
                        else {
                            echo '<option value="nea" selected="selected">National Environmental Agency (NEA)</option>';
                            echo '<option value="moh">Minstry of Health (MOH)</option>';
                        }
                    }
                ?>
                </select>
            </div>
        </div>
            
        <div class="form-group">
            <label for="incharge" class="col-sm-2 control-label">Person-In-Charge:</label>
            <div class="col-sm-5">
                <input type="text" name="incharge" class="form-control" readonly="true" value=<?php echo $_SESSION['usertype']; ?> />
            </div>
        </div>
            
        <div class="form-group">
            <label for="dispatchtime" class="col-sm-2 control-label">Time Dispatched:</label>
            <div class="col-sm-5">
                <input type="text" name="dispatchtime" class="form-control" readonly="true" value="<?php if($dispatchtime != "") echo $dispatchtime; ?>"/>
            </div>
        </div>
            
        <div class="form-group">
            <label for="dispatchdesc" class="col-sm-2 control-label">Description:</label>
            <div class="col-sm-5">
                <textarea rows="5" class="form-control" name="dispatchdesc" placeholder="Please input description"><?php if($dispatchdesc != "") echo $dispatchdesc; ?></textarea>
            </div>
        </div>
            
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-9">
                <input type="submit" name= "submit" class="btn btn-primary" value="Submit">
                <input type="reset" name="reset" class="btn btn-default" value="Reset">
            </div>
        </div>
    </form>
    </div>
    </div>
    
<?php
    require "footer.php";
?>

    
</body>
</html>