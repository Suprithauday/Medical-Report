<!--Establish a Session-->
<?php
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
<?php
	if(session_id() == '') {
		session_start();
	}
//Insert a new patient
	if (isset($_SESSION['userName'])) {
		echo '<h3>Insert Patients</h3>
		<h4>Please enter the details of the patient you would like to insert.</h4>

		<form id="patientForm" onSubmit="return validPatientInfo()" method="POST" action="AddPatients.php">
			<table class="form-table">
		        <tr>
		            <td>First Name:</td>
		            <td><input type="text" id="firstName" name="firstName" placeholder="First Name" onChange="validFirstName()"></td>
		            <td id="firstNameError"></td>
		        </tr>
		        <tr>
		            <td>Last Name:</td>
		            <td><input type="text" id="lastName" name="lastName" placeholder="Last Name" onChange="validLastName()"></td>
		            <td id="lastNameError"></td>
		        </tr>
		        <tr>
		            <td>Date of Birth:</td>
		            <td><input type="text" id="dateOfBirth" name="dateOfBirth" placeholder="Date of Birth" onChange="validDOB()"></td>
		            <td id="dobError"></td>
		        </tr>
		        <tr>
		            <td>Gender:</td>
		            <td><select id="patientGender" name="patientGender" onChange="validGender()">
		            		<option value="">Please select an option</option>
		            		<option value="m">Female</option>
		            		<option value="f">Male</option>
		            	</select></td>
		            <td id="genderError"></td>
		        </tr>
		        <tr>
	        		<td><input type="submit" id="submit" value="Insert Patient"/></td>
	        	</tr>
		    </table>
		</form>';
	} else {
		echo "You are not authorised to view this page. Please log in.";
		echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
			</form>';
	}
?>