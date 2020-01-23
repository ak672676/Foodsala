<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php Confirm_Login(); ?>
<?php 

    if(isset($_GET["action"])){
        
        if($_GET["action"] == "dispach"){
            
//            date_default_timezone_set("Asia/Karachi");
//            $CurrentTime=time();
//            $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
//            $Admin = $_SESSION["Username"];
//            $items_array=$_SESSION["shopping_cart"];
//            $price=$_SESSION["total_price"];
//            
//            $serialized_array=serialize($items_array);
//            $status='placed';
            
            $BillId=(int)$_GET["billId"];
            global $ConnectingDB;
            
            $Query="UPDATE bills SET status='dispach' WHERE id= $BillId";
            
            $Execute= mysqli_query($Connection,$Query);
            
            if($Execute){
                $_SESSION["SuccessMessage"]="Bill Updated Successfully";
                Redirect_to("PendingBills.php");
            }else{
                $_SESSION["ErrorMessage"]="Something Went Wrong";
                Redirect_to("PendingBills.php");

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
                    <li><a href="AddManager.php"><span class="glyphicon glyphicon-user"> </span>&nbsp;Add Manager</a></li>
                    <br>
                    <li><a href="AddItem.php"><span class="glyphicon glyphicon-shopping-cart"> </span>&nbsp;Add Item</a></li>
                    <br>
                    <li class="active"><a href="PendingBills.php"><span class="glyphicon glyphicon-list"> </span>&nbsp;Pending Bills</a></li>
                    <br>
                    <li><a href="LogOut.php"><span class="glyphicon glyphicon-log-out"> </span>&nbsp;Log Out</a></li>
                </ul>
            </div>
            <div class="col-sm-10" style="padding-top:5px;">
                <div class="row">
                    <h3>Pending Bills</h3>
                    <div><?php echo Message(); echo SuccessMessage();?></div>
                    
                    <div id="accordion">
                        
                        <?php 
                        
                            global $ConnectingDB;
                            $ViewQuery="SELECT * FROM bills WHERE status='placed'";
                            $Execute= mysqli_query($Connection, $ViewQuery);
                            while($DataRows= mysqli_fetch_array($Execute)){
                                $BillId=$DataRows["id"];
                                $Datetime=$DataRows["datetime"];
                                $Username=$DataRows["username"];
                                $Price=$DataRows["price"];
                                $Status=$DataRows["status"];
                                $Orders=$DataRows["orders"];

                        ?>
                      <div class="card">
                        <div class="card-header" id="heading<?php echo $BillId; ?>">
                          <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#<?php echo $BillId; ?>" aria-expanded="false" aria-controls="<?php echo $BillId; ?>">
                              BillId: <?php echo $BillId; ?>
                            </button>
                            <span class="badge badge-secondary"><?php echo $Datetime; ?></span>
                          </h5>
                        </div>
                        <div id="<?php echo $BillId; ?>" class="collapse" aria-labelledby="heading<?php echo $BillId; ?>" data-parent="#accordion">
                          <div class="card-body">
                                <div class="alert alert-info" role="alert">
                                    <p><strong>Order PlacedBy:</strong> <?php echo $Username; ?></p>
                                    <p><strong>Amount:</strong> <?php echo $Price; ?></p>
                                </div>
                              <div>
                                <?php 
                                    $OrdersResolved = unserialize($Orders);
                                ?>
                            <table class="table">
                              <thead class="thead-light">
                                <tr>
<!--                                  <th scope="col">#</th>-->
                                  <th scope="col">Item-Id</th>
                                  <th scope="col">Item Name</th>
                                  <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                </tr>
                              </thead>
                                <tbody>
                                    <?php 
                                        foreach ($OrdersResolved as $item) {
                                    ?>
                                    <tr>
<!--                                      <th scope="row">1</th>-->
                                      <td><?php echo $item['item_id']; ?></td>
                                      <td><?php echo $item['item_name']; ?></td>
                                      <td><?php echo $item['item_quantity']; ?></td>
                                        <td><?php echo $item['item_price']; ?></td>
                                        
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                            </table>
                            <div>
                                <a href="PendingBills.php?action=dispach&billId=<?php echo $BillId; ?>"><span class="btn btn-danger ml-2">Dispach</span></a>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                        <?php } ?>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
             © Copyright 2020, All Rights Reserved
    </div>
</body>

</html>