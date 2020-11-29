<!--starting the session-->

<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html >
	<head>
		<meta http-equiv="Content-Type" charset=utf-8" />
		<link rel="stylesheet" href="style.css">
		<script src="FormVerify.js"></script>

		<title>Data Sup Management System</title>
	</head>
	<body>
		<h4> Hello!!! Please login below if you are a practitioner or administrator. </h4>

<!--        Main page login form-->
        <?php
        echo "<div class=\"login-form\">
		<form id=\"registrationForm\" onSubmit=\"return validLoginInfo()\" method=\"POST\" action=\"./verifyLogin.php\">
			<table class=\"form-table\">
		        <tr>
		            <td>Username:</td>
		            <td><input type=\"text\" id=\"userName\" name=\"userName\" placeholder=\"Username\" onChange=\"validUsername()\"></td>
		            <td id=\"userNameError\"></td>
		        </tr>
		        <tr>
		            <td>Password:</td>
		            <td><input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Password\" onChange=\"validPassword()\"></td>
		            <td id=\"passwordError\"></td>
		        </tr>
		        <tr>
	        		<td><input type=\"submit\" id=\"submit\" value=\"Login\"/></td>
	        	</tr>
		    </table>
		</form>
	</div>";
        ?>

	</body>
</html>
