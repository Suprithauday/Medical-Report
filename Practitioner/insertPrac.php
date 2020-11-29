<?php
	if(session_id() == '') {
		session_start();
	}
	
	if (isset($_SESSION['userName']) && $_SESSION['isAdmin']) {
		echo '<h3>Insert Practitioners</h3>
		<h4>Please enter the details of the practitioner you would like to insert.</h4>

		<form id="practitionerForm" onSubmit="return validPractitionerInfo()" method="POST" action="../Practitioner/AddPrac.php">
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
		            <td>Username:</td>
		            <td><input type="text" id="userName" name="userName" placeholder="Username" onChange="validUsername()"></td>
		            <td id="userNameError"></td>
		        </tr>
		        <tr>
		            <td>Password:</td>
		            <td><input type="password" id="password" name="password" placeholder="Password" onChange="validPassword()"></td>
		            <td id="passwordError"></td>
		        </tr>
		        <tr>
		            <td>Administrator?</td>
		            <td><input type="radio" id="administrator" name="administrator" value="true">Yes</td>
		            <td><input type="radio" id="administrator" name="administrator" value="false" checked>No</td>
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