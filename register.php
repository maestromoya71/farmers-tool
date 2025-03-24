<?php
// Include session and database connection
include_once "resource/session.php";
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

// Database Connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "register"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['signUpbtn'])) {
    $category = $_POST['category'] ?? '';
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmpassword']);

    // Validate form data
    if (!empty($category) && !empty($email) && !empty($username) && !empty($password)) {
        if ($password === $confirmPassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert into the appropriate table based on the selected category
            if ($category == 'farmer') {
                // Insert into the `farmers` table
                $sql = "INSERT INTO farmers (Company_Name, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $email, $hashedPassword);
            } else {
                // Insert into the `users` table (for buyers)
                $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $email, $hashedPassword);
            }

            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful'); window.location.href = 'loginfarmers.php';</script>";
            } else {
                echo "<script>alert('Error: Could not register user');</script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>alert('Passwords do not match'); window.location.href = 'register.php';</script>";
        }
    } else {
        echo "<script>alert('Please complete the form'); window.location.href = 'register.php';</script>";
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
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
                <a class="navbar-brand" href="index.php" style="padding-right: 45px;"><strong>FarmLink</strong></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Buy Farm Products</a></li>
                    <li><a href="loginfarmers.php">Login As Farmer</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="login-form">
        <div class="thumbnail" style="width: 65%; margin:auto;">
            <form method="POST" enctype="multipart/form-data" style="width:70%; margin: auto;">
                <h1>Registration Form</h1>
                <p style='padding-left:5px; margin-bottom: 0px;color: #808080;'>Please select category</p>
                <div name="select-cat" style="padding-right: 50px; color: #808080;">
                    <input name="category" type="radio" <?php if(isset($category) && $category=="buyer") echo "checked";?> value="buyer">Buyer
                    <input name="category" type="radio" <?php if(isset($category) && $category=="farmer") echo "checked";?> value="farmer">Farmer
                </div>
                <div class="form-group" style="position:relative;">
                    <input type="text" style="padding-left: 25px;" class="form-control" minlength="8" placeholder="Username or Company Name" id="UserName" name="username"/>
                    <i class="fa fa-user" style="position: absolute; left: 0; top:2px; padding: 9px 8px; color: #aaa"></i>
                </div>
                <div class="form-group" style="position:relative;">
                    <input type="email" style="padding-left: 25px;" class="form-control" placeholder="Email" id="Email" name="email">
                    <i class="fa fa-envelope" style="position: absolute; left: 0; top:2px; padding: 9px 8px; color: #aaa"></i>
                </div>
                <div class="form-group log-status" style="position:relative;">
                    <input type="password" style="padding-left: 25px;" class="form-control" placeholder="Password" minlength="8" id="Passwod" name="password">
                    <i class="fa fa-lock" style="position: absolute; left: 0; top:2px; padding: 9px 8px; color: #aaa"></i>
                </div>
                <div class="form-group log-status" style="position:relative;">
                    <input type="password" style="padding-left: 25px;" class="form-control" placeholder="Confirm Password" minlength="8" id="Passwod" name="confirmpassword">
                    <i class="fa fa-lock" style="position: absolute; left: 0; top:2px; padding: 9px 8px; color: #aaa"></i>
                </div>
                <div align="center">
                    <button align="center" style="width: 50%; margin-bottom: 50px;" name="signUpbtn" type="submit" class="btn btn-primary"><strong>Register</strong></button>
                </div>
            </form>
        </div>
    </div>

    <footer id="footer" class="container" style="background: #008000; color: black; width: 100%;">
        <hr style="border-top: 1px solid #ccc;"><br/><br/><br/>
        <p align="center">Contact Us: 079979808 &copy; FarmLink. All rights reserved</p>
    </footer>
</body>
</html>