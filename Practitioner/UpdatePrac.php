<!--Establish a session-->
<?php
include("../operations.php");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" charset=utf-8" />
    <link rel="stylesheet" href="../style.css">
    <script src="../FormVerify.js"></script>

    <title>BIOM 9450: A Web-Based Medication and Diet Regime Management System </title>
</head>

	<body>
		<header>
						<form id="logout" method="POST" action="../index.php">
				<input type="submit" id="logoutSubmit" value="Log Out"/>
			</form>
            <form id="backToControlPanel" method="POST" action="../controls/controls.php">
				<input type="submit" id="backToControlPanelSubmit" value="Back"/>
			</form>

		</header>
		<?php
			if (isset($_SESSION['userName']) && $_SESSION['isAdmin']) {
				$conn = openConnection();
				$pracID = $_POST['pracID'];
				$firstName = $_POST['firstName'];
				$lastName = $_POST['lastName'];
				$userName = $_POST['userName'];
				$password = $_POST['password'];
				$administrator = $_POST['administrator'];
//

				$updateQuery = "UPDATE Practitioners SET FirstName = '$firstName', LastName = '$lastName', Username = '$userName', Password = '$password', Administrator = $boolAdmin WHERE Prac_ID = $pracID";
				$result = odbc_exec($conn,$updateQuery);

				echo "<h1>Practitioner edited successfully!</h1>
				<h2>Details:</h2>";
				echo "<strong>Name: </strong>" . $firstName . " " . $lastName . "<br>" .
				"<strong>userName: </strong>" . $userName . "<br>" .
				"<strong>password </strong>" . $password . "<br>" .
				"<strong>admin? </strong>" . $administrator;
				
				echo "<table class=\"form-table\">
				<tr><form id=\"viewPractitioners\" method=\"POST\" action=\"../Practitioner/ViewPrac.php\">
				<td><input type=\"submit\" id=\"viewPractitionersSubmit\" value=\"View Practitioners\"/></td>
				<td>View data for all practitioners.</td>
				</tr></form></table>";
				
			} else {
				echo "You are not authorised to view this page. Please log in as an administrator.";
				echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
				</form>';
			}
		?>
	</body>
</html>