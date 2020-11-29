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
				echo '<h3>View Practitioners</h3>
				<form id="insertPractioners" method="POST" action="../insertForm.php">
					<input type="submit" id="insertPractitionerSubmit" value="Insert Practitioner"/>
					<input type="hidden" id="formType" name="formType" value="practitioner"/>
			  	</form><br>';
				echo '<form id="searchPractitioners" method="POST" action="ViewPrac.php">
						<input type="text" id="pracSearch" name="pracSearch" placeholder="search"></td>
						<input type="submit" id="searchPractitionerSubmit" value="Search Practitioners"/>
					</form>';

				$isAdmin = $_SESSION['isAdmin'];
				$conn = openConnection();

				if (isset($_POST['pracSearch'])) {
					$searchTerms = $_POST['pracSearch'];
				} else {
					$searchTerms = '';
				}
				displayPractitioners($conn, $isAdmin, $searchTerms);
			} else {
				echo "You are not authorised to view this page. Please log in.";
				echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
				</form>';
			}
		?>
		
	</body>

</html>