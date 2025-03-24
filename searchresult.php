<?php
include_once "resource/session.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Create connection using mysqli
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
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
                <a class="navbar-brand" href="index.php"><strong>FarmLink</strong></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="register.php"><strong>Register</strong></a>
                    </li>
                    <li>
                        <a href="login.php"><strong>Buy Farm Products</strong></a>
                    </li>
                    <li>
                        <a href="loginfarmers.php"><strong>Login As Farmer</strong></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </br>

    </br>
    </br>
    <div class="container">
        <div class="row text-center">
            <?php
            if (isset($_POST["search"])) {
                $valuetosearch = mysqli_real_escape_string($conn, trim($_POST["searchvalue"]));

                $sql = "SELECT * FROM `products` WHERE `Description` LIKE '%$valuetosearch%' OR `type_product` LIKE '%$valuetosearch%'";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }

                $c = mysqli_num_rows($result);
            ?><h2 style="text-align: left;"><?php echo $c ?> Product Found</h2><br /><?php

                while ($row = mysqli_fetch_array($result)) {
            ?>
                    <div class="col-md-4">
                        <div class="thumbnail" align="center">
                            <form method="post" action="cart.php?action=add&id=<?php echo $row["id"]; ?>">
                                <a href="#"><img class="img-responsive" <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row[8]) . '">'; ?>></a>
                                <h4 class="text-info"><?php echo $row["Category"]; ?></h4>
                                <h4 class="text-info" style="color: green;"><strong>Seller: </strong><?php echo $row["CompanyName"]; ?></h4>
                                <h4 class="text-danger"># <?php echo $row[5]; ?></h4>
                            </form>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <div style="padding: 1em 0 2em 0;">
            <footer id="footer" class="container" style="background: #008000; color: black; width: 100%;">
                <hr style="border-top: 1px solid #ccc;"><br /><br /><br />
                <p align="center">Contact Us: 079979808 &copy; FarmLink. All rights reserved</p>
            </footer>
        </div>
    </div>
</body>

</html>