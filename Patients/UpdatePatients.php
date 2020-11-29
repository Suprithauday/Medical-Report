<!--establish a session-->
<?php
include("../operations.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" charset=utf-8"/>
    <link rel="stylesheet" href="../style.css">
    <script src="../FormVerify.js"></script>
    <title>BIOM9450: A Web-Based Medication and Diet Regime Management System </title>
</head>
<body>
<form id="logout" method="POST" action="../index.php">
    <input type="submit" id="logoutSubmit" value="Log Out"/>
</form>
<form id="backToControlPanel" method="POST" action="../controls/controls.php">
    <input type="submit" id="backToControlPanelSubmit" value="Back"/>
</form>

<?php
if (isset($_SESSION['userName'])) {
    $conn = openConnection();
    $patientID = $_POST['patientID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $gender = $_POST['patientGender'];
//update the SQL DB
    $updateQuery = "UPDATE Patients SET FirstName = '$firstName', LastName = '$lastName', BirthDate = '$dateOfBirth', Gender = '$gender' WHERE Patient_ID = $patientID";
    $result = odbc_exec($conn, $updateQuery);

    echo "<h1>Successful Patient Editing!</h1>
				<h2>Details:</h2>";
    echo "<strong>Name: </strong>" . $firstName . " " . $lastName . "<br>" .
        "<strong>Date of Birth: </strong>" . $dateOfBirth . "<br>" .
        "<strong>Gender: </strong>" . $gender . "<br>";

    echo "<table class=\"form-table\">
				<tr><form id=\"viewPatients\" method=\"POST\" action=\"../Patients/ViewPatients.php\">
				<td><input type=\"submit\" id=\"viewPatientsSubmit\" value=\"View Patients\"/></td>
				<td>View data for all patients.</td>
				</tr></form></table>";

} else {
    echo "You are not authorised to view this page. Please log in.";
    echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
				</form>';
}
?>
</body>
</html>