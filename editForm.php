<!DOCTYPE html>
<html >
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css">
		<script src="FormVerify.js"></script>
		<?php 
			include("operations.php");
			session_start();
			$formType = $_POST['formType'];
		if ($formType == "patient") {
			echo "<title>Edit Patients</title>";
		} else if ($formType == "practitioner") {
			echo "<title>Edit Practitioners</title>";
		}
		?>
	</head>

	<body>
<header>
			<form id="logout" method="POST" action="./index.php">
				<input type="submit" id="logoutSubmit" value="Log Out"/>
			</form>
            <form id="backToControlPanel" method="POST" action="./controls/controls.php">
				<input type="submit" id="backToControlsSubmit" value="Back"/>
			</form>
			<hr>
		</header>
		</body>
		<?php 
			if ($formType == "patient") {
				include("./Patients/EditPatients.php");
			} else if ($formType == "practitioner") {
				include("./Practitioner/EditPrac.php");
			}
		?>
	</body>

</html>


<!--not working check the form type..god knows what crap you gave-->