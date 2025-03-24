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

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
    <style>
        .col-md-4:hover img {
            transform: scale(1.0);
            transition: all 0.5s ease-in;
            filter: blur(2px) brightness(85%);
            position: relative;
            box-shadow: 0 0 16px cyan;
        }
        .hint {
            position: absolute;
            z-index: 1;
            align: center;
            top: 30%;
            left: 40%;
            color: #fff;
            text-decoration: bold;
            opacity: 0;
            transition: 2s;
        }
        .col-md-4:hover :not(img) {
            opacity: 1;
        }
    </style>
</head>
<body style="padding-top: 0px; padding-bottom: 0px;">
    <!-- Navigation -->
    <header class="jumbotron hero-spacer" style="background: url(assets/img/background.jpeg); margin-top: 0px; background-size: cover; height: 400px;">
        <nav class="navbar navbar-inverse navbar-fixed-top" style="opacity: 0.7; filter:alpha(opacity=70);" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php" style="padding-right: 100px; font-size: 25px;"><strong>FarmLink.com</strong></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="register.php" style="font-weight: bold; padding-right: 80px;">Register</a></li>
                        <li><a href="login.php" style="font-weight: bold; padding-right: 80px;">Buy Farm Products</a></li>
                        <li><a href="loginfarmers.php" style="font-weight: bold; padding-right: 80px;">Login As Farmer</a></li>
                        <li><a href="#" style="font-weight: bold; padding-right: 50px;">How it Works</a></li>
                        <li><a class="cart" href="#" style="color: #f9a023;"><strong>Cart</strong><i class="fa fa-cart-plus" style="color:#f9a023; height: 30%;"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <h1 align="center" style="padding-top: 80px; color: #fff;"><strong>Taking Agriculture to Another Level</strong></h1>
        <p align="center" style="color: #fff;">A commercial platform to expand the customer scale for farmers and ease purchase for buyers online.</p>
        <div class="container">
            <form method="post" action="searchresult.php" style="width: 45%; margin: auto;">
                <input type="text" name="searchvalue" placeholder="What do you need?" maxlength="20" style="margin-left: 80px; width: 300px; padding:7px; border:1px solid blue; border-radius-top-left: 5px; border-radius-bottom-left: 5px;">
                <input class="btn" type="submit" name="search" value="Search" style="padding: 7px; background: blue; border: 2px solid blue; color: white; margin-left: -5px;">
            </form>
        </div>
    </header>

    <div class="container">
        <div class="row text-center">
            <h1 align="center"><strong>Explore Our Marketplace</strong></h1><br/><br/>
            <?php
            // Fetch products from the database
            $sql = "SELECT * FROM products LIMIT 9"; // Adjust the query as needed
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row['id'];
                    $product_name = htmlspecialchars($row['Category']);
                    $product_image = $row['image'];
                    $product_description = htmlspecialchars($row['Description']);
                    $product_price = htmlspecialchars($row['Price']);
            ?>
                    <div class="col-md-4">
                        <div class="thumbnail" align="center">
                            <a href="product_details.php?id=<?php echo $product_id; ?>">
                                <span class="hint"><strong>Click to view</strong></span>
                                <?php
                                if (!empty($product_image)) {
                                    echo '<img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($product_image) . '" alt="Product Image">';
                                } else {
                                    echo '<img class="img-responsive" src="assets/img/placeholder.png" alt="Placeholder Image">';
                                }
                                ?>
                            </a>
                            <h4 class="text-info"><strong><?php echo $product_name; ?></strong></h4>
                            <p><?php echo $product_description; ?></p>
                            <p><strong>Price: $<?php echo $product_price; ?></strong></p>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer id="footer" class="container" style="background: #008000; color: black; width: 100%;">
        <hr style="border-top: 1px solid #ccc;"><br/><br/><br/>
        <p align="center">&copy; FarmLink.@2025 All rights reserved</p>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>