<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "register";
			
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
				exit;
			}
			if (isset($_GET['CompanyName'])){
				$username = mysqli_real_escape_string($conn, $_GET['CompanyName']);
				$sql = "SELECT image FROM products WHERE CompanyName = '$username'";
				$query = mysqli_query($conn, $sql);
				if ($query === false) {
					die("Query failed: " . mysqli_error($conn));
					exit;
				}
				$imageData = null;
				while($row = mysqli_fetch_assoc($query)){
					$imageData = $row["image"];
				};
				if ($imageData != null) {
					header("content-type: image/jpeg");
					echo $imageData;
				} else {
					echo "Image not found!";
				}
			}
			else{
			
			echo "Error!";
			}



?>
