<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php Confirm_Login(); ?>
<?php
    if(isset($_POST["Submit"])){
        $ItemName= mysqli_real_escape_string($Connection, $_POST['ItemName']);
        $Category= mysqli_real_escape_string($Connection, $_POST['Category']);
        $Type= mysqli_real_escape_string($Connection, $_POST['Type']);
        $Description= mysqli_real_escape_string($Connection, $_POST['Description']);
        $Price= mysqli_real_escape_string($Connection, $_POST['Price']);
        
        date_default_timezone_set("Asia/Karachi");
        $CurrentTime=time();
        $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
        $Admin = $_SESSION["Username"];
        $Image=$_FILES["Image"]["name"];
        $Target="Upload/".basename($_FILES["Image"]["name"]);
        if(empty($ItemName)){
            $_SESSION["ErroeMessage"]="ItemName can't be empty";
            Redirect_to("AddItem.php");
        }
        else if(strlen($ItemName)<2){
            $_SESSION["ErroeMessage"]="ItemName should be of atleast two characters";
            Redirect_to("AddItem.php");
        }
        else{
            global $ConnectingDB;
            $Query="INSERT INTO items(datetime,image,addedBy,itemName,description,type,category,price) VALUES('$DateTime','$Image','$Admin','$ItemName','$Description','$Type','$Category','$Price')";
            $Execute= mysqli_query($Connection,$Query);
            move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
            if($Execute){
//                $_SESSION["SuccessMessage"]="Item Added Successfully";
                Redirect_to("ManagerDashboard.php");
//                header("ManagerDashboard.php");
            }else{
                $_SESSION["ErroeMessage"]="Something Went Wrong";
                Redirect_to("AddItem.php");
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
                    <li ><a href="AddManager.php"><span class="glyphicon glyphicon-user"> </span>&nbsp;Add Manager</a></li>
                    <br>
                    <li class="active"><a href="AddItem.php"><span class="glyphicon glyphicon-shopping-cart"> </span>&nbsp;Add Item</a></li>
                    <br>
                    <li><a href="PendingBills.php"><span class="glyphicon glyphicon-list"> </span>&nbsp;Pending Bills</a></li>
                    <br>
                    <li><a href="LogOut.php"><span class="glyphicon glyphicon-log-out"> </span>&nbsp;Log Out</a></li>
                </ul>
            </div>
            <div class="col-sm-10" style="padding-top:5px;">
                <div><?php echo Message(); echo SuccessMessage();?></div>
               
                <form action="AddItem.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="itemname"><span class="FieldInfo">Item Name:</span></label>
                            <input class="form-control" type="text" name="ItemName" id="itemname" placeholder="Item Name">
                        </div>
                        <div class="form-group">
                            <label for="description"><span class="FieldInfo">Description:</span></label>
                            <textarea class="form-control" name="Description" id="description"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="type"><span class="FieldInfo">Type</span></label>
                            <select class="form-control" id="type" name="Type">
                                <option>Veg</option>
                                <option>Non-Veg</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category"><span class="FieldInfo">Category</span></label>
                            <select class="form-control" id="category" name="Category">
                                <option>Drink</option>
                                <option>Breakfast</option>
                                <option>Snacks</option>
                                <option>Lunch</option>
                                <option>Dinner</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price"><span class="FieldInfo">Price:</span></label>
                            <input class="form-control" type="text" name="Price" id="price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                            <input type="File" class="form-control" name="Image" id="imageselect">
                        </div>
                        
                        <br>
                        <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Item">
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