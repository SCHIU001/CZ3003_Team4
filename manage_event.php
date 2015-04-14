<!DOCTYPE html>
<?php
    require "connect.php";
?>
<html>
<head>
    <title>Manage Event - CMS</title>
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
		if($_SESSION['usertype'] != 'superuser' && $_SESSION['usertype'] != 'admin') {
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
        <h1>Manage Events</h1>
        <input type="text" name="filter" id="filter" class="light-table-filter" data-table="order-table" placeholder="Filter">
        <br><br>
        <table class="order-table" id="resultTable" border="1">
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Type
                </th>
                <th>
                    Address
                </th>
                <th>
                    Reporter Name
                </th>
                <th>
                    Reporter ID
                </th>
                <th>
                    Reporter Contact
                </th>
                <th>
                    Description
                </th>
                <th>
                    Time Reported
                </th>
                <th>
                    Status
                </th>
                <th>
                    Ongoing
                </th>
            </tr>
            </thead>
            
            <tbody>
            <?php
                if($result = $db->query("SELECT * FROM table_event 
                                        JOIN table_event_status ON table_event_status.id=table_event.status 
                                        JOIN table_event_type ON table_event_type.id=table_event.type")) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['eventID'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['blockNo'] . " " . $row['street'] . ", S(" . $row['postcode'] . ")</td>";
                        echo "<td>" . $row['reporterName'] . "</td>";
                        echo "<td>" . $row['reporterIC'] . "</td>";
                        echo "<td>" . $row['reporterContact'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['time'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        //echo "<td>" . $row['active'] . "</td>";
                        if($row['active'] == 1) 
                        echo "<td>Active</td>";
                        else
                        echo "<td>Inactive</td>";
                        echo "<td><a href='edit_event.php?id=" . $row['eventID'] . "' style=\"text-decoration: none\">Edit</a></td>";
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