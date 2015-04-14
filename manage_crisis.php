<!DOCTYPE html>
<?php
    require "connect.php";
?>
<html>
<head>
    <title>Manage Crisis - CMS</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="table_filter.js"></script>
    <script src="navScript.js"></script>
    <style type="text/css">
        h1{
            padding: 0 200px 15px 0;
            border-bottom: 1px solid #E5E5E5;
        }
        th {
            font-family: Verdana, Times New Roman;
			background-color: #aaaaaa;
        }
        table, td, th {
            padding: 5px;   
        }
        table {
            width: 100%;
            padding: 10px;
        }
        th.sortable {
            color: #666;
            cursor: pointer;
            text-decoration: underline;
        }
        th.sortable:hover { color: black; }
        th.sorted-asc, th.sorted-desc  { color: black; }

        td {
            background-color: white;
        }
        td.odd {
            background-color: #666;
            color: white;
        }
        td.hovered {
          background-color: lightblue;
          color: #666;
        }
    </style>
	
	<?php
		if($_SESSION['usertype'] != 'superuser') {
			//header('Location: ./index.php');
			echo "You are not authorized to do so!";
			die();
		}
	?>
</head>
    
<body>
<?php
    require "navi.php";
?>
    <div class="container">
    <div class="jumbotron">
        <h1>Manage Crisis</h1>
        <input type="text" name="filter" id="filter" class="light-table-filter" data-table="order-table" placeholder="Filter">
        <br>
		<h3>Crisis: Dengue</h3>
        <table class="order-table" id="resultTable" border="1">
            <thead>
            <tr>
                <th>
                    eventID
                </th>
                <th>
                    Date
                </th>
                <th>
                    Type
                </th>
                <th>
                    Postal Code
                </th>
                <th>
                    Status
                </th>
                <th>
                    Occurrence
                </th>
            </tr>
            </thead>
            
            <tbody>
            <?php
                if($result = $db->query("SELECT eventID, DATE_FORMAT(time, '%d/%m/%Y') as date, type, postcode, status, COUNT(postcode) as occurrence
											FROM table_event
											WHERE time >= DATE_SUB(SYSDATE(), INTERVAL 30 DAY) and type = 2
											GROUP BY postcode
											HAVING COUNT(postcode) >= 10")) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['eventID'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['postcode'] . "</td>";
						echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['occurrence'] . "</td>";
                        echo "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>
		<br>
		<h3>Crisis: Haze</h3>
		<table class="order-table" id="resultTable" border="1">
            <thead>
            <tr>
                <th>
                    eventID
                </th>
                <th>
                    Date
                </th>
                <th>
                    Type
                </th>
                <th>
                    Postal Code
                </th>
                <th>
                    Status
                </th>
                <th>
                    Occurrence
                </th>
            </tr>
            </thead>
            
            <tbody>
            <?php
                if($result = $db->query("SELECT eventID, DATE_FORMAT(time, '%d/%m/%Y') as date, type, postcode, status, COUNT(postcode) as occurrence
											FROM table_event
											WHERE time >= DATE_SUB(SYSDATE(), INTERVAL 30 DAY) and type = 3
											GROUP BY postcode
											HAVING COUNT(postcode) >= 10")) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['eventID'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['postcode'] . "</td>";
						echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['occurrence'] . "</td>";
                        echo "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>
		
    </div>
    </div>
<?php
    require "footer.php";
?> 
</body>
</html>