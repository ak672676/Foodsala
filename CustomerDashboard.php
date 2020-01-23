<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php Confirm_Login(); ?>
<?php 

    if(isset($_POST["add_to_cart"])){
        
        if(isset($_SESSION["shopping_cart"])){
		  $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		  if(!in_array($_GET["id"], $item_array_id)){
            
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		  }
            else{
                echo '<script>alert("Item Already Added")</script>';
            }
	   }
	   else{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	   }
    }

    if(isset($_GET["action"]))
    {
        if($_GET["action"] == "delete")
        {
            foreach($_SESSION["shopping_cart"] as $keys => $values)
            {
                if($values["item_id"] == $_GET["id"])
                {
                    unset($_SESSION["shopping_cart"][$keys]);
                    echo '<script>alert("Item Removed")</script>';
                    echo '<script>window.location="CustomerDashboard.php"</script>';
                }
		      }
	   }
    }
    

    if(isset($_GET["action"])){
        
        if($_GET["action"] == "order"){
            
            date_default_timezone_set("Asia/Karachi");
            $CurrentTime=time();
            $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
            $Admin = $_SESSION["Username"];
            $items_array=$_SESSION["shopping_cart"];
            $price=$_SESSION["total_price"];
            
            $serialized_array=serialize($items_array);
            $status='placed';
            global $ConnectingDB;
            
            $Query="INSERT INTO bills(datetime,username,orders,status,price) 
            VALUES('$DateTime','$Admin','$serialized_array','$status','$price')";
            
//            $Query="INSERT INTO customer(datetime,username,password,type) 
//            VALUES('aaaaaaaaaaa','aaaaaaaaaa','aaaaaaaa','aaaaaaa')";
            
            $Execute= mysqli_query($Connection,$Query);
            
            if($Execute){
                unset($_SESSION["shopping_cart"]);
                unset($_SESSION["total_price"]);
                $_SESSION["SuccessMessage"]="Bill Added Successfully";
                Redirect_to("CustomerDashboard.php");
            }else{
                $_SESSION["ErrorMessage"]="Something Went Wrong";
                Redirect_to("CustomerDashboard.php");
//              "Something Went Wrong"  
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
        <div class="row" style="background-color:white;">
            <br />
		      <h3>Order Details</h3>
            <div><?php echo Message(); echo SuccessMessage();?></div>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Item Name</th>
						<th width="10%">Quantity</th>
						<th width="20%">Price</th>
						<th width="15%">Total</th>
						<th width="5%">Action</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
                    
					<tr>
                        
						<td><?php echo $values["item_name"]; ?></td>
						<td><?php echo $values["item_quantity"]; ?></td>
						<td> <?php echo $values["item_price"]; ?></td>
						<td> <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
						<td><a href="CustomerDashboard.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
					</tr>
					<?php
							$total = $total + ((int)$values["item_quantity"]*(int)$values["item_price"]);
                            $_SESSION["total_price"]=$total;
						}
					?>
					<tr>
						<td colspan="3" align="right"><strong>Total</strong></td>
						<td align="right"> <?php echo number_format($total, 2); ?></td>
						<td>
<!--
                            <nav method="post" action="CustomerDashboard.php?action=add&id=<?php echo $ItemId; ?>">
                                <input type="submit" name="place_order" style="margin-top:5px;" class="btn btn-success" value="Order" />
                            </nav>
-->
                            <a href="CustomerDashboard.php?action=order"><span class="btn btn-primary">Order</span></a>
                        </td>
					</tr>
					<?php
                    
					}
					?>
						
				</table>
			</div>
		
        </div>
        <div class="row">
            
            <div class="col-sm-12" style="padding-top:10px;">
                <div class="row">
                <?php 
                        
                    global $ConnectingDB;
                    $ViewQuery="SELECT * FROM items";
                    $Execute= mysqli_query($Connection, $ViewQuery);
                    while($DataRows= mysqli_fetch_array($Execute)){
                        $ItemId=$DataRows["id"];
                        $Image=$DataRows["image"];
                        $ItemName=$DataRows["itemName"];
                        $Description=$DataRows["description"];
                        $Type=$DataRows["type"];
                        $Category=$DataRows["category"];
                        $Price=$DataRows["price"];
                        
                ?>
                    <div class="col-sm-4" style="height:750px;margin-bottom: 10px;">
                    <form method="post" action="CustomerDashboard.php?action=add&id=<?php echo $ItemId; ?>">
                    <div class="card" style="width: auto;background-color:#ebe6e6;padding:5px;height:100%;" >
                    
                        <img src="Upload/<?php echo $Image; ?>" class="thumbnail img-responsive" alt="<?php echo $ItemName; ?>" style="text-align:center;">
                        <div class="card-body">
                            <input type="hidden" name="hidden_name" value="<?php echo $ItemName ?>" />

                             <input type="hidden" name="hidden_price" value="<?php echo $Price ?>" />
                            <h2 class="card-title"><?php echo $ItemName; ?></h2>
                            <p>
                                <span class="badge badge-warning">Price: <?php echo $Price; ?></span>
                                <span class="badge badge-warning"><?php echo $Type ;?></span>
                                <span class="badge badge-success"><?php echo $Category ;?></span>
                            </p>
                            <p class="card-text"><?php echo $Description; ?></p>
                            <input type="text" name="quantity" value="1" class="form-control" />
                            <br>
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
                        </div>
                    </div>
                    </form>
                    </div>
                <?php } ?>
                </div>
            </div> 
        </div>
    </div>
</body>

</html>