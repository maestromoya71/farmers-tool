<?php
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

// Check if the cart is empty
if ($_SESSION["total"] == 0) {
    ?>
    <script type="text/javascript">
        alert("Your Cart is Empty");
        window.location.href = "cart.php";
    </script>
    <?php
}

// Handle form submission
if (isset($_POST["orderProduct"])) {
    $id = $_SESSION["orderid"];
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $mobile = mysqli_real_escape_string($conn, $_POST["mobile"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $near = mysqli_real_escape_string($conn, $_POST["near"]);
    $state = mysqli_real_escape_string($conn, $_POST["state"]);
    $city = mysqli_real_escape_string($conn, $_POST["city"]);

    // Validate state selection
    if ($state == "Select Town/City") {
        ?>
        <script type="text/javascript">
            alert("Please Select a Town/City");
        </script>
        <?php
    } else {
        $payment = 2000 + $_SESSION["total"];

        // Insert into the delivery table
        $sql = "INSERT INTO delivery (id, firstname, lastname, mobile, address, city, near, price, state, status) 
                VALUES ('$id', '$fname', '$lname', '$mobile', '$address', '$city', '$near', '$payment', '$state', 'PENDING')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            ?>
            <script type="text/javascript">
                alert("Successful Order");
                window.location.href = "buyerProfile.php";
            </script>
            <?php
        } else {
            echo "Error: " . mysqli_error($conn); // Display the MySQL error message
        }
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
    <!-- Custom CSS -->
    <link href="css/heroic-features.css" rel="stylesheet">
</head>
<body style="padding-top: 30px;">
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
                    <li><a href="register.php"><strong>Register</strong></a></li>
                    <li><a href="login.php"><strong>Buy Farm Products</strong></a></li>
                    <li><a href="logout.php"><strong>Logout</strong></a></li>
                </ul>
            </div>
        </div>
    </nav>
    </br>
    </br>
    </br>

    <div class="container">
        <div class="row text-center" style="border: outset;">
            <div style="padding: 20px;">
                <h1 align="left">Checkout</h1>
                <div style="border-top: ridge; border-bottom: ridge; width: 95%;">
                    <div style="border-bottom: ridge;">
                        <h3 align="left" style="color: purple;">Add Delivery Address <b style="color: #ffbe58;">(Pay On Delivery)</b></h3>
                        <p style="float: right; color: grey;"><i>Your delivery address determines delivery charges</i></p><br/>
                    </div>
                    <br/>
                    <div style="width: 65%; padding-left: 30px;">
                        <form method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" minlength="3" placeholder="Firstname" name="fname" required>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" minlength="6" placeholder="Lastname" name="lname" required>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" minlength="11" placeholder="Mobile Number" name="mobile" required>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" minlength="10" placeholder="Street Address" name="address" required>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" minlength="5" placeholder="City" name="city" required>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" minlength="10" placeholder="Opposite, Next to, Near By..." name="near" required>
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="form-group">
                                <select name="state" style="width: 100%;" required>
                                    <option>Select Town/City</option>
                                    <option>Kabarak</option>
                                    <option>Nakuru</option>
                                    <option>Nairobi</option>
                                    <option>Thika</option>
                                    <option>Naivasha</option>
                                    <option>Kirinyaga</option>
                                    <option>Kakamega</option>
                                    <option>Busia</option>
                                    <option>Kisumu</option>
                                    <option>Bungoma</option>
                                    <option>Kisii</option>
                                    <option>Mombasa</option>
                                    <option>Kilifi</option>
                                    <option>Kwale</option>
                                    <option>Bamba</option>
                                    <option>Nyamira</option>
                                    <option>Kitale</option>
                                    <option>Eldoret</option>
                                    <option>Kapsabet</option>
                                    <option>Karatina</option>
                                    <option>Kampi ya moto</option>
                                    <option>Nandi</option>
                                    <option>Nyandarua</option>
                                    <option>Nyeri</option>
                                    <option>Sugoi</option>
                                    <option>Turbo</option>
                                    <option>Laikipia</option>
                                    <option>Rafiki</option>
                                    <option>Machakos</option>
                                    <option>Kiambu</option>
                                    <option>Mumias</option>
                                    <option>Shinyalu</option>
                                    <option>Murhanda</option>
                                    <option>Khayega</option>
                                    <option>Masiakali</option>
                                    <option>Keroka</option>
                                    <option>Kitui</option>
                                </select>
                                <i class="fa fa-user"></i>
                            </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive" id="tbl_cart" style="width: 75%; padding: 30px;">
                <h1 align="left">Items In Cart</h1>
                <table class="table table-bordered">
                    <tr>
                        <th width="10%">Item</th>
                        <th width="20%">Item Name</th>
                        <th width="5%">Quantity</th>
                        <th width="20%">Price</th>
                        <th width="10%">Seller</th>
                    </tr>
                    <?php
                    $sql = "SELECT `order`.category, `order`.quantity, `order`.price, products.image, products.CompanyName 
                            FROM `order`, `products` 
                            WHERE `order`.Buyer = '$_SESSION[username]' 
                            AND `order`.orderid = '$_SESSION[orderid]' 
                            AND products.id = `order`.productid";
                    $run_user = mysqli_query($conn, $sql);

                    $check_user = mysqli_num_rows($run_user);

                    if ($check_user > 0) {
                        while ($row = mysqli_fetch_array($run_user)) {
                            ?>
                            <tr>
                                <th width="10%"><?php echo '<img style="border-radius: 10px; height: 45px; width: 45px;" src="data:image/jpeg;base64,' . base64_encode($row["image"]) . '">'; ?></th>
                                <th width="20%"><?php echo $row["category"]; ?></th>
                                <th width="5%"><?php echo $row["quantity"]; ?></th>
                                <th width="20%"><?php echo $row["price"]; ?></th>
                                <th width="20%" style="color: purple;"><?php echo $row["CompanyName"]; ?></th>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <br/>
        <br/>

        <!-- jQuery -->
        <script src="js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <div class="order" style="height: 200px; background: #333; opacity: 0.7; filter:alpha(opacity=70); padding-left: 50px; padding-right: 50px; padding-top: 20px;">
            <div style="float: left; width: 40%; border: 2px solid #fff; border-radius: 5px; padding-left: 10px; padding-right: 10px; margin-bottom: 20px;">
                <h3 style="color: #ff8400;">Order Summary</h3>
                <p style="color: #fff;">
                    Purchase Bill: KSH<?php echo number_format($_SESSION["total"], 2); ?><br/>
                    Delivery Charges: KSH<?php $d = 200; echo number_format($d, 2); ?><br/><br/>
                    TOTAL: KSH<?php echo number_format($d + $_SESSION["total"], 2); ?>
                </p>
            </div>
            <div style="float: right; color: #fff; width: 50%;" align="right">
                <p>
                    <h3 style="color: #ff8400;"><strong>KSH<?php echo number_format($d + $_SESSION["total"], 2); ?></strong></h3>
                    <button name="orderProduct" type="submit" class="btn btn-primary" style="text-shadow: none; height: 50px; color: #fff; font-size: 20px; border-radius: 5px; background: #333;">Order Now</button>
                </p>
            </div>
        </div>
        </form>
    </div>

    <div style="padding: 1em 0 2em 0;">
        <footer id="footer" class="container" style="background: #008000; color: black; width: 100%;">
            <hr style="border-top: 1px solid #ccc;"><br/><br/><br/>
            <p align="center">Contact Us: 079979808 &copy; FarmLink. All rights reserved</p>
        </footer>
    </div>
</body>
</html>