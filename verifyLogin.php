<!--This code is for verify login and establish connection to the database.-->
<!--Verify Username and Password from database-->

<!DOCTYPE html>
<html >
	<head>
		<meta http-equiv="Content-Type" charset=utf-8" />
		<link rel="stylesheet" href="style.css">
		<script src="FormVerify.js"></script>
		<?php include("operations.php"); ?>
        <title>BIOM9450: A Web-Based Medication and Diet Regime Management System </title>
	</head>

	<body>
<!--    establishment of connection-->
		<?php
			$conn = openConnection();

			$userName = $_POST['userName'];
			$password = $_POST['password'];

			if (userExists($userName, $password, $conn)) {
				session_start();
				$_SESSION['userName'] = $userName;
				$_SESSION['pracID'] = getPracID($conn, $userName);				
				header("Location: ./controls/controls.php");
			} else {
				echo "<p>Your entered details are incorrect. Please enter a correct username and password to log in.</p>";
				include("index.php");
//				if the connection is wrong returns back to the page
			}
		?>
	</body>

</html>