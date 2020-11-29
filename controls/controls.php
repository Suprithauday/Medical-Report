<!--establish the session-->
<?php
include("../operations.php");
session_start();
?>
<!--this is a major control area-->
<!--this leads to the admin/practitioner portal where they can edit based on the requirements-->
<!DOCTYPE html >
<html>
	<head>
		<meta http-equiv="Content-Type"  charset=utf-8" />
		<link rel="stylesheet" href="../style.css">
		<title>Major Controls</title>
	</head>

	<body>
		<header>
			<form id="logout" method="POST" action="../index.php">
				<input type="submit" id="logoutSubmit" value="Log Out"/>
			</form>
		</header>
		<?php

			$conn = openConnection();
			$userName = $_SESSION['userName'];
			echo "<h4>Hi! $userName, Choose an option?</h4>";

			if (isAdmin($userName, $conn)) {
				$_SESSION['isAdmin'] = true;
				include("./Control_Admin.php");
			} else {
				$_SESSION['isAdmin'] = false;
				include("./Control_Prac.php");
			}
		?>
<!--       The practitioner/admin is already been a successful login user-->
	</body>
</html>