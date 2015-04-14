<!-- Start of navigation -->
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"><IMG src="media/CMS_logo.png" width="100px" height="30"/></a>
        </div>
        <div>
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <?php 
                if($_SESSION['usertype'] == 'admin') {
                    echo '<li><a href="report.php">Report Event</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Manage<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="manage_event.php">Manage Event</a></li>
                        </ul>
                    </li>';
                }
                if($_SESSION['usertype'] == 'superuser') {
                    echo '<li><a href="report.php">Report Event</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Manage<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="manage_event.php">Manage Event</a></li>
                            <li><a href="manage_crisis.php">Manage Crisis</a></li>
                        </ul>
                    </li>';
                }
                ?>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if($_SESSION['usertype'] == '' ) {
                        echo '<li><a data-toggle="modal" href="#myModal">
                            <span class="glyphicon glyphicon-log-in"></span> Login
                            </a>
                        </li>';
                    }
                    else {
                        echo '<li><a href="logout.php">
                            <span class="glyphicon glyphicon-log-out"></span> Logout
                            </a>
                        </li>';
                    }
                ?>
                
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Log In</h4>
                            </div><div class="container"></div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="post">
                                    <div class="form-group">
                                        <label for="username" class="col-sm-2 control-label">Username:</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">Password:</label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-xs-offset-2 col-xs-9">
                                            <input type="submit" name="login" class="btn btn-primary" value="Log In!">
                                            <input type="reset" class="btn btn-default" value="Reset">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
            
        </div>
    </div>
</nav>
<!-- End of navigation -->

<!-- user authentication option -->
<?php
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $db->query('SELECT * FROM table_user WHERE username="' . $username . '"');
    if($result) {
        $row = $result->fetch_assoc();
        $dbpwd = $row['passwd'];
        if($password == $dbpwd) {
            $_SESSION['usertype'] = $username;
            if($_SESSION['usertype'] == 'admin')
                //echo 'here';
                header("location:report.php");
            else
                //echo 'not here';
                header("location:manage_event.php");
        }
        else {
            echo 'failed!';
        }
    }
    else {
        echo 'no user found';   
    }
    // check file existence
    /*if(file_exists('passfile.txt')) {
        // open file
        if($file_ptr = fopen('passfile.txt', 'r')) {
            // get password in file
            $pass = fread($file_ptr,8);
            fclose($file_ptr);
            // compare password
            if($_POST['password'] == $pass) {
                $_SESSION['usertype'] = 'Admin';
                header("location:manage_event.php");   
            } else {
                echo "Password does not match";   
            }
        } else {
            echo "fail to open file";   
        }
    } else {
        echo "passfile does not exist";   
    }*/
}
?>