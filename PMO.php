<?php
require "connect.php";

//$to      = 'zpek001@e.ntu.edu.sg';

date_default_timezone_set("Asia/Singapore"); 
$cur_time = date('d/m/Y h:i:s A');
$subject = '30 Minutes Report: '.$cur_time;

$dengue_str = '';
if($result = $db->query("SELECT eventID, DATE_FORMAT(time, '%d/%m/%Y') as date, postcode, COUNT(postcode) as occurrence
						FROM table_event
						WHERE time >= DATE_SUB(SYSDATE(), INTERVAL 30 DAY) and type = 2
						GROUP BY postcode
						HAVING COUNT(postcode) >= 10")) {
	while ($row = $result->fetch_assoc()) {
		$dengue_str .= "<tr><td>" . $row['eventID'] . "</td><td>" . $row['date'] . "</td><td>" . $row['postcode'] . "</td><td>" . $row['occurrence'] . "</td></tr>";
	}
}

$haze_str = '';
if($result = $db->query("SELECT eventID, DATE_FORMAT(time, '%d/%m/%Y') as date, postcode, COUNT(postcode) as occurrence
						FROM table_event
						WHERE time >= DATE_SUB(SYSDATE(), INTERVAL 30 DAY) and type = 3
						GROUP BY postcode
						HAVING COUNT(postcode) >= 10")) {
	while ($row = $result->fetch_assoc()) {
		$haze_str .= "<tr><td>" . $row['eventID'] . "</td><td>" . $row['date'] . "</td><td>" . $row['postcode'] . "</td><td>" . $row['occurrence'] . "</td></tr>";
	}
}

//echo $dengue_str;
//echo $haze_str;

$message = "
			<html>
			<head>
			<title>30 Minutes Report to PMO</title>
			
			<style>
			#infotable {
				border-collapse: collapse;
				border-width: 5px;
				border-style: inset;
				border-color: #5a5143;
				/*box-shadow: 0px 0px 50px 0px rgba(255, 255, 255, 1), 0px 0px 200px 5px rgba(0, 200, 255, .65), inset 0px 0px 5px 5px rgba(255, 255, 255, .7);
				*/
				background-color:rgba(255, 255, 255, 0.9);
			}

			#infotable th, td {
				border: 1px solid black;
				text-align: left;
			}
			</style>
			
			</head>
			<body>
			<h2>Time: ".$cur_time."</h2>
			<h3>Crisis: Dengue</h3>
			
			<table id = \"infotable\">
			<thead>
            <tr>
                <th>
                    eventID
                </th>
                <th>
                    Date
                </th>
                <th>
                    Postal Code
                </th>
                <th>
                    Occurrence
                </th>
            </tr>
            </thead>
			
			<tbody>".$dengue_str."
			</tbody>
			</table>
			
			<h3>Crisis: Haze</h3>
			
			<table id = \"infotable\">
			<thead>
            <tr>
                <th>
                    eventID
                </th>
                <th>
                    Date
                </th>
                <th>
                    Postal Code
                </th>
                <th>
                    Occurrence
                </th>
            </tr>
            </thead>
			
			<tbody>".$haze_str."
			</tbody>
			</table>
			</body>
			</html>
			";
				
$headers = 'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                    'From: cz3003@arbalestx.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
					
//mail('C130157@e.ntu.edu.sg', $subject, $message, $headers);
//mail('jtan106@e.ntu.edu.sg', $subject, $message, $headers);

echo $message;
?>