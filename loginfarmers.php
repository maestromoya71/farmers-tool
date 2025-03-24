<?php
    include_once "resource/session.php";
    include_once "resource/Database.php"; // Ensure this file contains the database connection logic
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
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
  <div class="login-form" style="margin-top: 75px;">
    <div class="thumbnail" style="width: 50%; margin:auto;">
      <form method="POST" style="width:80%; margin: auto;">
        <h1>Farmer's Sign In</h1>
        <?php
        if(isset($_POST["loginBtn"])){
          $username = $_POST["username"];
          $password = $_POST["pass"];
          
          // Establish database connection
          $servername = "localhost";
          $dbusername = "root"; // Replace with your database username
          $dbpassword = ""; // Replace with your database password
          $dbname = "register"; // Database name

          // Create connection
          $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Prepare the SQL statement to fetch data from the `farmers` table
          $stmt = $conn->prepare("SELECT * FROM farmers WHERE Company_Name = ?");
          if (!$stmt) {
              die("Prepare failed: " . $conn->error);
          }

          // Bind parameters and execute the query
          $stmt->bind_param("s", $username);
          $stmt->execute();
          $result = $stmt->get_result();

          // Check if a matching record is found
          if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              // Verify the password
              if (password_verify($password, $row['password'])) {
                  // Set session variable and redirect
                  $_SESSION['Company_Name'] = $username;
                  echo "<script>window.open('FarmerProfile.php', '_self')</script>";
              } else {
                  // Display error message if password is invalid
                  echo "<p style='padding: 20px; color: red; line-height: 1.5;'>Invalid password or username</p>";
              }
          } else {
              // Display error message if username is invalid
              echo "<p style='padding: 20px; color: red; line-height: 1.5;'>Invalid password or username</p>";
          }

          // Close the statement and connection
          $stmt->close();
          $conn->close();
        }
        ?>
        <div class="form-group">
          <input type="text" class="form-control" id="UserName" name="username" placeholder="Username" value="">
          <i class="fa fa-user"></i>
        </div>
        <div class="form-group log-status">
          <input type="password" class="form-control" placeholder="Password" id="Passwod" name="pass">
          <i class="fa fa-lock"></i>
        </div>
        <a class="link" style="float: left; padding-left: 20px;" href="register.php">Register Here</a>
        <a class="link" style="float: right; padding-right: 20px;" href="forgot_passfarmer.php">Lost your password?</a></br>
        </br>
        <div align="center">
          <button style="width: 45%;" name="loginBtn" type="submit" class="btn btn-primary"><strong>SIGN IN</strong></button>
        </br>
        </br>
        </div>
      </form>
    </div>
  </div>
</body>
</html>