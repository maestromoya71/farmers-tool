<?php
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

include_once "resource/session.php";

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["buy"])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_cat"],
                'item_price' => floatval($_POST["hidden_price"]), // Ensure numeric value
                'item_quantity' => intval($_POST["quantity"]) // Ensure numeric value
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
            ?>
            <script type="text/javascript">
                alert('Items in Cart: ' + <?php echo $count + 1; ?>);
            </script>
            <?php
        } else {
            echo '<script>alert("Item Added to Basket")</script>';
            echo '<script>window.location = "cart.php"</script>';
        }
    } else {
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_cat"],
            'item_price' => floatval($_POST["hidden_price"]), // Ensure numeric value
            'item_quantity' => intval($_POST["quantity"]) // Ensure numeric value
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location = "cart.php"</script>';
            }
        }
    }
}

if (isset($_POST["checkout"])) {
    if (isset($_SESSION["shopping_cart"])) {
        echo '<script>window.location = "checkout.php"</script>';
        $orderid = uniqid();
    } else {
        ?>
        <script type="text/javascript">
            alert("Nothing in the Cart");
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>FarmLink: Buy and Sell Raw Product Online</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font-Awesome Icons -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/heroic-features.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="padding-right:100px;"><strong>FarmLink</strong></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="buyerProfile.php" style="padding-right: 100px;"><strong>View Profile</strong></a></li>
                    <li><a href="logout.php" style="padding-right: 391px;">Logout</a></li>
                    <li>
                        <?php
                        if (!isset($_SESSION["shopping_cart"])) {
                            $count = 0;
                        } else {
                            $count = count($_SESSION["shopping_cart"]);
                        }
                        ?>
                        <a id="viewcart" class="cart" style="cursor: pointer; color: #f9a023;">
                            <i class="fa fa-cart-plus" style="color:#f9a023; height: 30%;"></i> <strong><?php echo $count; ?> Item(s)</strong>
                        </a>
                    </li>
                    <li style="padding-top: 10px;">
                        <form method="post">
                            <button name="checkout" class="btn" style="float: right; background: #f9a023;"><strong>Proceed to CheckOut</strong></button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <header class="jumbotron hero-spacer" style="background: url(img/background.jpeg); margin-top: 0px; background-size: cover; height: 200px;">
            <h1 align="center" style="color: white; margin-bottom: 0px;"><?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?></h1>
            <?php
            $sql = "SELECT * FROM Users WHERE `username` = '$_SESSION[username]'";
            $run_user = mysqli_query($conn, $sql);

            if (!$run_user) {
                die("Error in SQL query: " . mysqli_error($conn));
            }

            $check_user = mysqli_num_rows($run_user);

            if ($check_user > 0) {
                while ($row = mysqli_fetch_array($run_user)) {
                    ?>
                    <h3 align="center" style="color: white; margin-top: 0px;"><?php echo $row["email"]; ?></h3>
                    <?php
                }
            }
            ?>
        </header>

        <div class="row text-center">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl_cart" style="display: none;">
                    <tr>
                        <th width="20%">Item Name</th>
                        <th width="10%">Quantity</th>
                        <th width="20%">Price</th>
                        <th width="15%">Total</th>
                        <th width="5%">Action</th>
                    </tr>
                    <?php
                    $total = 0;
                    if (!empty($_SESSION["shopping_cart"])) {
                        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                            $quantity = intval($values["item_quantity"]); // Ensure numeric value
                            $price = floatval($values["item_price"]); // Ensure numeric value
                            $subtotal = $quantity * $price;
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo $values["item_name"]; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td># <?php echo $price; ?></td>
                                <td># <?php echo number_format($subtotal, 2); ?></td>
                                <td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                            </tr>
                            <?php
                        }
                        $_SESSION["total"] = $total;
                    }
                    ?>
                    <tr>
                        <td colspan="3" align="right"><strong>Total</strong></td>
                        <td><strong># <?php echo number_format($total, 2); ?></strong></td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <h1 align="center"><strong>Explore Our Marketplace</strong></h1>
            <?php
            $page = $_GET["page"] ?? 1;
            $count = "SELECT COUNT(*) FROM products";
            $countquery = mysqli_query($conn, $count);
            $c = mysqli_fetch_row($countquery)[0];
            $rand = rand(6, $c) - 6;

            if ($page == "" || $page == "1") {
                $page1 = 0;
            } else {
                $page1 = ($page * 5) - 5;
            }

            $sql = "SELECT * FROM products WHERE id > '$rand' LIMIT $page1, 6";
            $run_user = mysqli_query($conn, $sql);
            $check_user = mysqli_num_rows($run_user);

            if ($check_user > 0) {
                while ($row = mysqli_fetch_array($run_user)) {
                    ?>
                    <div class="col-md-4">
                        <div class="thumbnail" align="center">
                            <form method="post" action="cart.php?page=<?php echo $page; ?>&action=add&id=<?php echo $row["id"]; ?>">
                                <img class="img-responsive" src="data:image/jpeg;base64,<?php echo base64_encode($row[8]); ?>">
                                <div align="center">
                                    <h4 class="text-info"><strong><?php echo $row["Category"]; ?></strong></h4>
                                    <h4 class="text-info"><strong>Seller: </strong><?php echo $row["CompanyName"]; ?></h4>
                                    <h4 class="text-danger">Price: #<?php echo $row["Price"]; ?></h4>
                                    <input type="hidden" name="hidden_cat" value="<?php echo $row["Category"]; ?>" />
                                    <input type="hidden" name="hidden_price" value="<?php echo $row["Price"]; ?>" />
                                    <input type="hidden" name="hidden_name" value="<?php echo $row["CompanyName"]; ?>" />
                                    <input type="number" style="width: 120px;" name="quantity" class="form-control" placeholder="Enter Quantity" /><br>
                                    <input style="background: green;" type="submit" id="buythis" name="buy" class="btn btn-primary" value="Buy Now!" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                $no_of_pages = ceil($c / 9);
                for ($i = 1; $i <= $no_of_pages; $i++) {
                    ?><a href="cart.php?page=<?php echo $i; ?>"><?php echo $i . " "; ?></a><?php
                }
            }
            ?>
        </div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/showhide.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <div style="padding: 1em 0 2em 0;">
        <footer id="footer" class="container" style="background: #008000; color: black; width: 100%;">
            <hr style="border-top: 1px solid #ccc;"><br/><br/><br/>
            <p align="center">Contact Us: 0799979808 &copy; FarmLink. All rights reserved</p>
        </footer>
    </div>
</body>
</html>