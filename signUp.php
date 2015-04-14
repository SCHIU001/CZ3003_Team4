<!DOCTYPE html>
<?php
    require "connect.php";
?>
<html>
<head>
    <title>Sign Up - CMS</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
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
        $_SESSION['usertype'] = '';

    ?>
    <!-- sign up form begins -->
    <div class="container">
    <div class="jumbotron">
    <h1>Sign Up Form</h1>
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="name" placeholder="Enter Name">
            </div>
        </div>
        
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Username:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="username" placeholder="Enter Username">
            </div>
        </div>
        
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password:</label>
            <div class="col-sm-5">
                <input type="password" class="form-control" id="password" placeholder="Enter Passwrod">
            </div>
        </div>
        
        <div class="form-group">
            <label for="cPassword" class="col-sm-2 control-label">Confirm Password:</label>
            <div class="col-sm-5">
                <input type="password" class="form-control" id="cPassword" placeholder="Confirm Password">
            </div>
        </div>
        
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email:</label>
            <div class="col-sm-5">
                <input type="email" class="form-control" id="email" placeholder="Enter Email Address">
            </div>
        </div>
        
        <div class="form-group">
            <label for="contactNo" class="col-sm-2 control-label">Contact Number:</label>
            <div class="col-sm-5">
                <input type="tel" class="form-control" id="contactNo" placeholder="Enter Contact Number">
            </div>
        </div>
        
        <div class="form-group">
            <label for="address" class="col-sm-2 control-label">Address:</label>
            <div class="col-sm-5">
                <textarea rows="4" class="form-control" id="address"></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-9">
                <input type="submit" class="btn btn-primary" value="Sign up!">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </div>
    </form>
    </div>
    </div>
    <!-- sign up form ends -->
    
<?php
    require "footer.php";
?>

</body>
</html>