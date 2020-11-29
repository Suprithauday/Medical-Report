<!--establish a session-->

<?php
if(session_id() == '') {
	session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['isAdmin']) {
	echo "<h3>Administrator</h3>";
	echo "<table class=\"form-table\">";

	// Same display of patients like Practitioner
	echo "<tr><form id=\"viewPatients\" method=\"POST\" action=\"../Patients/ViewPatients.php\">
				<td><input type=\"submit\" id=\"viewPatientsSubmit\" value=\"View Patients\"/></td>
				<td>View Patients.</td>
		  </tr></form>";

	// Insert Patients
	echo "<tr><form id=\"insertPatients\" method=\"POST\" action=\"../insertForm.php\">
				<td><input type=\"submit\" id=\"insertPatientSubmit\" value=\"Insert Patient\"/></td>
				<td>Insert New Patient.</td>
				<input type=\"hidden\" id=\"formType\" name=\"formType\" value=\"patient\"/>
		  </tr></form>";

	// Control to search for a practitioner / add a relationship to a practitioner / delete a relationship to a practitioner.
	echo "<tr><form id=\"viewRelationships\" method=\"POST\" action=\"../Connections/ViewCon.php\">
				<td><input type=\"submit\" id=\"viewRelationshipsSubmit\" value=\"View Relationships\"/></td>
				<td>View Patients-Practioners relationships </td>
		  </tr></form>";
		
	// insert relationship
	echo "<tr><form id=\"insertRelationship\" method=\"POST\" action=\"../insertForm.php\">
				<td><input type=\"submit\" id=\"insertRelationshipSubmit\" value=\"Insert Relationship\"/></td>
				<td>Insert a new Patients-Practioners relationships </td>
				<input type=\"hidden\" id=\"formType\" name=\"formType\" value=\"relationship\"/>
		  </tr></form>";

	// controls to search/edit/add practitioner data
	echo "<tr><form id=\"viewPractitioners\" method=\"POST\" action=\"../Practitioner/ViewPrac.php\">
				<td><input type=\"submit\" id=\"viewPractitionersSubmit\" value=\"View Practitioners\"/></td>
				<td>View all practitioners.</td>
		  </tr></form>";
		
	// insert practitioner
	echo "<tr><form id=\"insertPractitioner\" method=\"POST\" action=\"../insertForm.php\">
				<td><input type=\"submit\" id=\"insertPractitionerSubmit\" value=\"Insert Practitioner\"/></td>
				<td>Insert data for a new practitioner.</td>
				<input type=\"hidden\" id=\"formType\" name=\"formType\" value=\"practitioner\"/>
		  </tr></form>";
// dispense med
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
