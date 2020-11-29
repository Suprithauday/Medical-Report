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

    <title>BIOM 9450: A Web-Based Medication and Diet Regime Management System </title>
</head>

<body>
<header>
    <form id="logout" method="POST" action="../index.php">
        <input type="submit" id="logoutSubmit" value="LogOut"/>
    </form>
    <form id="backToControlPanel" method="POST" action="../controls/controls.php">
        <input type="submit" id="backToControlSubmit" value="Back"/>
    </form>
</header>

<?php
if (isset($_SESSION['userName']) && $_SESSION['isAdmin']) {
    $conn = openConnection();

    $practitioner = $_POST['practitionerDropdown'];
    $patient = $_POST['patientDropdown'];

    if (relationshipAlreadyExists($practitioner, $patient, $conn)) {
        echo "<h1>This relationship already exists! Please select a new unique relationship to be created.</h1>";
        include("./InsertCon.php");
    } else {
        $sqlQuery = "INSERT INTO Relationships (Prac_ID, Patient_ID) VALUES ('$practitioner', '$patient')";
        $result = odbc_exec($conn, $sqlQuery);

        $patientQuery = "SELECT * FROM Patients WHERE Patient_ID = $patient";
        $patients = odbc_exec($conn, $patientQuery);
        odbc_fetch_row($patients);
        $patientName = odbc_result($patients, "FirstName") . " " . odbc_result($patients, "LastName");

        $practQuery = "SELECT * FROM Practitioners WHERE Prac_ID = $practitioner";
        $practitioners = odbc_exec($conn, $practQuery);
        odbc_fetch_row($practitioners);
        $practitionerName = odbc_result($practitioners, "FirstName") . " " . odbc_result($practitioners, "LastName");

        echo "<h1>Relationship added successfully!</h1>
					<h2>Details:</h2>";
        echo "<strong>Practitioner: </strong>" . $practitionerName . "<br>" .
              "<strong>Patient: </strong>" . $patientName . "<br>";

        echo "<table class=\"form-table\">
					<tr><form id=\"viewRelationships\" method=\"POST\" action=\"../Connections/ViewCon.php\">
					<td><input type=\"submit\" id=\"viewRelationshipsSubmit\" value=\"View Relationships\"/></td>
					<td>View relationships between patients and practitioners.</td>
			  		</tr></form></table>";
    }
} else {
    echo "You are not authorised to view this page. Please log in.";
    echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
				</form>';
}
?>
</body>
</html>