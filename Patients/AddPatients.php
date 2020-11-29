<!--add patients-->

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" charset=utf-8" />
    <link rel="stylesheet" href="../style.css">
    <script src="../FormVerify.js"></script>
    <?php
    include("../operations.php");
    session_start();
    ?>
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
<!--establish a connection with the database-->

		<?php
			if (isset($_SESSION['userName'])) {
				$conn = openConnection();
				$firstName = $_POST['firstName'];
				$lastName = $_POST['lastName'];
				$dateOfBirth = $_POST['dateOfBirth'];
				$gender = $_POST['patientGender'];
// if the patient exits then a message is alerted else acees from the database using SQL and inserted in to the DB

				if (patientAlreadyExists($firstName, $lastName, $dateOfBirth, $gender, $conn)) {
					echo "<h1>This patient already exists! Please insert a new unique patient.</h1>";
					include("./InsertPatients.php");
				} else {
					$patientID = getLastPatientID($conn) + 1;

					$sqlQuery = "INSERT INTO Patients (Patient_ID, FirstName, LastName, BirthDate, Gender) VALUES ('$patientID', '$firstName', '$lastName', '$dateOfBirth', '$gender')";
					$result = odbc_exec($conn,$sqlQuery);
					
					if (!$_SESSION['isAdmin']) {
						$pracID = $_SESSION['pracID'];
						$sqlQuery = "INSERT INTO Relationships (Prac_ID, Patient_ID) VALUES ('$pracID', '$patientID')";
						$result = odbc_exec($conn,$sqlQuery);
					}

					echo "<h1>Patient added successfully!</h1>
					<h2>Details:</h2>";
					echo "<strong>Name: </strong>" . $firstName . " " . $lastName . "<br>" .
					"<strong>Date of Birth: </strong>" . $dateOfBirth . "<br>" .
					"<strong>Gender: </strong>" . $gender . "<br>";
					
					echo "<table class=\"form-table\">
					<tr><form id=\"viewPatients\" method=\"POST\" action=\"../Patients/ViewPatients.php\">
					<td><input type=\"submit\" id=\"viewPatientSubmit\" value=\"View Patients\"/></td>
					<td>View data for all patients.</td>
			  		</tr></form></table>";
				}
			} else {
				echo "You are not authorised to view this page. Please log in.";
				echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
				</form>';
			}
		?>
	</body>

</html>