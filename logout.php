<!DOCTYPE html>
<?php
    session_start();
    $_SESSION['usertype'] = '';
    echo 'You have successfully logged out!';
    header( "refresh:2;url=index.php" );
?>
<html>
<head>
    <title>Crisis Management System</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="navScript.js"></script>
</head>
    
<body id="index">
<?php
    require "navi.php";
?>
    
    <!-- main body begins -->
<div class="container">
    <div class="jumbotron" align="center">
        <p>You have successfully logged out.<br><a href='index.php'>Click Here</a> if the page doesn't automatically redirect you</p>
    </div>
</div>
    

<?php
    require "footer.php";
?>
    
<!-- main body ends -->
</body>

</html>