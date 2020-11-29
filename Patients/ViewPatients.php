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
			<hr>
		</header>
		<?php

//        to view patients
			if (isset($_SESSION['userName'])) {
			    
				echo '<h3>View Patients</h3>
				<form id="insertPatients" method="POST" action="../insertForm.php">
					<input type="submit" id="insertPatientSubmit" value="Insert Patient"/>
					<input type="hidden" id="formType" name="formType" value="patient"/>
			  	</form><br>';
				echo '<form id="searchPatients" method="POST" action="../Patients/ViewPatients.php">
						<input type="text" id="patientSearch" name="patientSearch" placeholder="search"></td>
						<input type="submit" id="searchPatientSubmit" value="Search Patients"/>
					</form>';

				$isAdmin = $_SESSION['isAdmin'];
				$pracID = $_SESSION['pracID'];
				$conn = openConnection();
				
				if (isset($_POST['patientSearch'])) {
					$searchTerms = $_POST['patientSearch'];
				} else {
					$searchTerms = '';
				}
				displayPatients($conn, $isAdmin, $pracID, $searchTerms);
			} else {
				echo "You are not authorised to view this page. Please log in.";
				echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
				</form>';
			}
		?>
		
	</body>

</html>