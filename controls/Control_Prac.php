<!--Establish the session-->

<?php
if(session_id() == '') {
	session_start();
}

// This is Practitioner control page where he/she can control the following:
if (isset($_SESSION['userName'])) {
	echo "<h3>Practitioner</h3>";
	echo "<table class=\"form-table\">";

	// Search/edit/add patient along with all patients

	echo "<tr><form id=\"viewPatients\" method=\"POST\" action=\"../Patients/ViewPatients.php\">
				<td><input type=\"submit\" id=\"viewPatientsSubmit\" value=\"View Patients\"/></td>
				<td>View Patients data.</td>
		  </tr></form>";
		
	// Add a new patients
	echo "<tr><form id=\"insertPatients\" method=\"POST\" action=\"../insertForm.php\">
				<td><input type=\"submit\" id=\"insertPatientSubmit\" value=\"Insert Patient\"/></td>
				<td>Insert patient.</td>
				<input type=\"hidden\" id=\"formType\" name=\"formType\" value=\"patient\"/>
		  </tr></form>";
	echo "</table>";
    echo "<tr><form id=\"DispenseMed\" method=\"POST\" action=\"../DispenseMed.php\">
				<td><input type=\"submit\" id=\"dispenseMedSubmit\" value=\"Dispense Medication\"/></td>
				<td>Dispense medications.</td>
				<input type=\"hidden\" id=\"formType\" name=\"formType\" value=\"subject\"/>
		  </tr></form>";
    echo "</table>";
} else {
	echo "You are not authorised to view this page. Please log in.";
	echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
			</form>';
}

?>