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
            echo "<title>Insert Patients</title>";
        } else if ($formType == "relationship") {
            echo "<title>Insert Relationships</title>";
        } else if ($formType == "practitioner") {
            echo "<title>Insert Practitioners</title>";
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
		</header>

		<?php 
			// Serve different dynamic pages depending on which hidden field was provided
			if ($formType == "patient") {
				include("./Patients/InsertPatients.php");
			} else if ($formType == "relationship") {
				include("./Connections/InsertCon.php");
			} else if ($formType == "practitioner") {
				include("./Practitioner/insertPrac.php");
			}
		?>
	</body>
</html>