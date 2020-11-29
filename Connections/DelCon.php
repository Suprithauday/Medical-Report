<?php
	include("../operations.php");
	session_start(); 
	
	if (isset($_SESSION['userName']) && $_SESSION['isAdmin']) {
		$conn = openConnection();

		$practitioner = $_POST['pracID'];
		$patient = $_POST['patientID'];

		$sqlQuery = "DELETE FROM Relationships WHERE Prac_ID = $practitioner AND Patient_ID = $patient";
		$result = odbc_exec($conn,$sqlQuery);
		
		header('Location: ./ViewCon.php');
	} else {
		echo "You are not authorised to view this page. Please log in.";
		echo '<form id="login" method="POST" action="../index.php">
		<input type="submit" id="loginSubmit" value="Log In"/></td>
		</form>';
	}
?>