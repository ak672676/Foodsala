<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
   <script src="bootstrap/js/jquery-3.3.1.min.js" type="text/javascript"></script>
   <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="css/publicstyle.css">
   <title>FoodSala</title>
</head>

<body>
    <div style="height: 10px; background: #27aae1;"></div>
    <nav class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> 
                    <a href="FoodSala.php">
                        <h3 style="color: white;">FoodSala</h3>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav navbar-right" style="margin-left: 60px;font-size: 20px;">
                    
                    <li class="active"><a href="FoodSala.php">FoodSala</a></li>
                    <li><a href="AdminLogin.php">Admin Login</a></li>
                    <li><a href="CustomerLogin.php">Customer Login</a></li>
                    <li><a href="CustomerRegistration.php">Customer Registration</a></li>
                    <li><a href="#">Contact Us</a></li>
                    
                </ul>
                    
                </div>
            </div>
        </nav>
    <div style="height: 10px; background: #27aae1;margin-top: -20px;"></div>
    <div class="container-fluid " id="bgImg">
        <br><br><br>
        <div class="jumbotron" style="opacity:0.7;">
          <h1 class="display-4">FoodSala!!</h1>
          <h2 class="lead">Good Food for Your Everyday</h2>
          <hr class="my-4">
          <p> It’s way better than fast food. It’s FoodSala.</p>
        </div>
    </div>
    <div id="footer">
             © Copyright 2020, All Rights Reserved
    </div>
</body>

</html>