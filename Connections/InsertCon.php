<?php // Insert options as Practitioner/patient name, but actual value as their IDs.
	//include("../operations.php");
	
	if(session_id() == '') {
		session_start();
	}
	
	if (isset($_SESSION['userName']) && $_SESSION['isAdmin']) {
		$conn = openConnection();
		
		echo '<h3>Insert Relationships</h3>
		<h4>Please select the practitioner and patient for whom you would like to create a relationship for.</h4>
		<form id="relationshipForm" onSubmit="return validRelationshipInfo()" method="POST" action="../Connections/AddCon.php">
			<table class="form-table">
		        <tr>
		            <td>Practitioner:</td>
		            <td><select id="practitionerDropdown" name="practitionerDropdown" onChange="validPractitioner()">
		            		<option value="">Please select an option</option>';
		            		printPractitionerOptions($conn);
		echo '            	</select></td>
		            <td id="practitionerError"></td>
		        </tr>
		        <tr>
		            <td>Patient:</td>
		            <td><select id="patientDropdown" name="patientDropdown" onChange="validPatient()">
		            		<option value="">Please select an option</option>';
		            		printPatientOptions($conn);
		echo '            	</select></td>
		            <td id="patientError"></td>
		        </tr>
		        <tr>
	        		<td><input type="submit" id="submit" value="Insert Relationship"/></td>
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
