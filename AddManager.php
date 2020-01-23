<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php Confirm_Login(); ?>
<?php
    if(isset($_POST["Submit"])){
        $Username= mysqli_real_escape_string($Connection, $_POST['Username']);
        $Password= mysqli_real_escape_string($Connection, $_POST['Password']);
        $ConfirmPassword= mysqli_real_escape_string($Connection, $_POST['ConfirmPassword']);
        date_default_timezone_set("Asia/Karachi");
        $CurrentTime=time();
        $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
        $Admin = $_SESSION["Username"];
        if(empty($Username)||empty($Password)||empty($ConfirmPassword)){
            $_SESSION["ErrorMessage"]="All Fields must be filled";
            Redirect_to("AddManager.php");
        }
        else if(strlen($Password)<6){
            $_SESSION["ErrorMessage"]="Atleast 6 characters required";
            Redirect_to("AddManager.php");
        }
        else if($Password!==$ConfirmPassword){
            $_SESSION["ErrorMessage"]="Password not matching";
            Redirect_to("AddManager.php");
        }
        else{
            global $ConnectingDB;
            $Query="INSERT INTO manager(datetime,username,password,addedby) VALUES('$DateTime','$Username','$Password','$Admin')";
            $Execute= mysqli_query($Connection,$Query);
            if($Execute){
                $_SESSION["SuccessMessage"]="Admin Added Successfully";
                Redirect_to("ManagerDashboard.php");
            }else{
                $_SESSION["ErrorMessage"]="Something Went Wrong";
                Redirect_to("AddManager.php");
            }
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
   <script src="bootstrap/js/jquery-3.3.1.min.js" type="text/javascript"></script>
   <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
   <title>FoodSala</title>
</head>

<body >
 
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
                    
                    <li><a href="LogOut.php"><span class="glyphicon glyphicon-log-out"> </span>&nbsp;Log Out</a></li>
                    
                </ul>
                    
                </div>
            </div>
        </nav>
    <div style="height: 10px; background: #27aae1;margin-top: -20px;"></div>
    <div class="container-fluid" id="bgImg" >
        <div class="row">
            <div class="col-sm-2" style="background-color:white; height: 90vh;padding-top:5px;">
                <ul id="side-menu" class="nav nav-pills nav-stacked">
                    <li ><a href="ManagerDashboard.php"><span class="glyphicon glyphicon-th"> </span>&nbsp;Dashboard</a></li>
                    <br>
                    <li class="active"><a href="AddManager.php"><span class="glyphicon glyphicon-user"> </span>&nbsp;Add Manager</a></li>
                    <br>
                    <li><a href="AddItem.php"><span class="glyphicon glyphicon-shopping-cart"> </span>&nbsp;Add Item</a></li>
                    <br>
                    <li><a href="PendingBills.php"><span class="glyphicon glyphicon-list"> </span>&nbsp;Pending Bills</a></li>
                    <br>
                    <li><a href="LogOut.php"><span class="glyphicon glyphicon-log-out"> </span>&nbsp;Log Out</a></li>
                </ul>
            </div>
            <div class="col-sm-10" style="padding-top:5px;">
                <div><?php echo Message(); echo SuccessMessage();?></div>
                <form action="AddManager.php" method="post">
                    <fieldset>
                        <div class="form-group">
                            <label for="Username"><span class="FieldInfo">UserName:</span></label>
                            <input class="form-control"type="text" name="Username" id="Username" placeholder="Username">
                         </div>
                        <div class="form-group">
                            <label for="Password"><span class="FieldInfo">Password:</span></label>
                            <input class="form-control"type="password" name="Password" id="Password" placeholder="Password">
                         </div>
                        <div class="form-group">
                            <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
                            <input class="form-control"type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Re-type same password">
                         </div>
                        <br>
                        <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Admin">
                        <br>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div id="footer">
             © Copyright 2020, All Rights Reserved
    </div>
</body>

</html>