<!--establish a session-->
<?php
if(session_id() == '') {
    session_start();
}

if (isset($_SESSION['userName'])) {
    $initialID = $_POST['patientID'];
    $initialFirst = $_POST['firstName'];
    $initialLast = $_POST['lastName'];
    $initialBirth = $_POST['birthDate'];
    $initialGender = $_POST['gender'];

// the initial symbolises the previous values stored in the form of the patients.
    echo "<h3>Edit Patient</h3>
		<h4>Please enter the details of the patient you would like to edit.</h4>

		<form id=\"patientForm\" onSubmit=\"return validPatientInfo()\" method=\"POST\" action=\"./Patients/UpdatePatients.php\">
			<input type=\"hidden\" id=\"patientID\" name=\"patientID\" value=\"$initialID\"/>
			<table class=\"form-table\">
				<tr>
					<td>First Name:</td>
					<td><input type=\"text\" id=\"firstName\" name=\"firstName\" value=\"$initialFirst\" onChange=\"validFirstName()\"></td>
					<td id=\"firstNameError\"></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type=\"text\" id=\"lastName\" name=\"lastName\" value=\"$initialLast\" onChange=\"validLastName()\"></td>
					<td id=\"lastNameError\"></td>
				</tr>
				<tr>
					<td>Date of Birth:</td>
					<td><input type=\"text\" id=\"dateOfBirth\" name=\"dateOfBirth\" value=\"$initialBirth\" onChange=\"validDOB()\"></td>
					<td id=\"dobError\"></td>
				</tr>
				<tr>
					<td>Gender:</td>
					<td><select id=\"patientGender\" name=\"patientGender\" onChange=\"validGender()\">";
    if ($initialGender == "m") {
        echo "<option value=\"m\">Male</option>
				  <option value=\"f\">Female</option>";
    } else {
        echo "<option value=\"f\">Female</option>
				  <option value=\"m\">Male</option>";
    }
    echo " </select></td>
					<td id=\"genderError\"></td>
				</tr>
				<tr>
					<td><input type=\"submit\" id=\"submit\" value=\"Save\"/></td>
				</tr>
			</table>
		</form>";
} else {
    echo "You are not authorised to view this page. Please log in.";
    echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
			</form>';
}
?>