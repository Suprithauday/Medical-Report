<!--this is my operations page where all the functions are written and called when necessary-->
<?php
//error_reporting(E_ERROR | E_PARSE);  // Disable ODBC Warnings
function openConnection()
{
    return odbc_connect("project", '', '');
}

function userExists($userName, $password, $conn)
{
    $query = "SELECT * FROM Practitioners";
    $practitioners = odbc_exec($conn, $query) or die("Server Error.");
    if (!odbc_error()) {
        while (odbc_fetch_row($practitioners)) {
            $dbUser = odbc_result($practitioners, "Username");
            $dbPass = odbc_result($practitioners, "Password");
            if ($dbUser == $userName && $dbPass == $password) {
                return true;
            }
        }
    }
    return false;
}

function isAdmin($userName, $conn)
{
    $query = "SELECT * FROM Practitioners WHERE Administrator = true";
    $administrators = odbc_exec($conn, $query) or die("Server Error.");
    if (!odbc_error()) {
        while (odbc_fetch_row($administrators)) {
            $dbUser = odbc_result($administrators, "Username");

            if ($dbUser == $userName) {
                return true;
            }
        }
    }
    return false;
}

function getPracID($conn, $userName)
{
    $query = "SELECT Prac_ID from Practitioners WHERE Username = '$userName'";
    $result = odbc_exec($conn, $query) or die("Server Error.");
    $pracID = null;
    if (!odbc_error()) {
        $pracID = odbc_result($result, "Prac_ID");
    }
    return $pracID;
}

function displayPatients($conn, $isAdmin, $pracID, $searchTerms)
{
    if ($searchTerms == '') {
        if ($isAdmin) {
            $query = "SELECT * FROM Patients ORDER BY Patient_ID";
        } else {
            $query = "SELECT s.Patient_ID, s.FirstName, s.LastName, s.BirthDate, s.Gender 
							FROM Patients s, Connections r 
							WHERE r.Patient_ID = s.Patient_ID 
							AND r.Prac_ID = $pracID
							ORDER BY s.Patient_ID";
        }
    } else {
        if ($isAdmin) {
            $query = "SELECT * FROM Patients 
							WHERE FirstName LIKE '%$searchTerms%'
							OR LastName LIKE '%$searchTerms%'
							OR Patient_ID LIKE '%$searchTerms%'
							ORDER BY Patient_ID";
        } else {
            $query = "SELECT s.Patient_ID, s.FirstName, s.LastName, s.BirthDate, s.Gender 
							FROM Patients s, Connections r 
							WHERE r.Patient_ID = s.Patient_ID 
							AND r.Prac_ID = $pracID
							AND (s.FirstName LIKE '%$searchTerms%'
							OR s.LastName LIKE '%$searchTerms%'
							OR r.Patient_ID LIKE '%$searchTerms%')
							ORDER BY s.Patient_ID";
        }
    }
    $patients = odbc_exec($conn, $query) or die("Server Error.");

    if (!odbc_error()) {
        echo "<table class=\"form-table\">
			<tr>
				<th>Patient ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Birth Date</th>
				<th>Gender</th>
			</tr>";
        while (odbc_fetch_row($patients)) {
            $patientID = odbc_result($patients, "Patient_ID");
            $firstName = odbc_result($patients, "FirstName");
            $lastName = odbc_result($patients, "LastName");
            $birthDate = substr(odbc_result($patients, "BirthDate"), 0, 10);
            $bdYear = substr($birthDate, 0, 4);
            $bdMonth = substr($birthDate, 5, 2);
            $bdDay = substr($birthDate, 8, 2);
            $birthDate = $bdDay . "/" . $bdMonth . "/" . $bdYear;
            $gender = odbc_result($patients, "Gender");

            echo "<tr>
					<td>$patientID</td>
					<td>$firstName</td>
					<td>$lastName</td>
					<td>$birthDate</td>
					<td>$gender</td>
			
					<td><form id=\"editPatient\" method=\"POST\" action=\"../editForm.php\">
							<input type=\"submit\" id=\"editPatientSubmit\" value=\"EDIT\"/>
							<input type=\"hidden\" id=\"formType\" name=\"formType\" value=\"patient\"/>
							<input type=\"hidden\" id=\"patientID\" name=\"patientID\" value=\"$patientID\"/>
							<input type=\"hidden\" id=\"firstName\" name=\"firstName\" value=\"$firstName\"/>
							<input type=\"hidden\" id=\"lastName\" name=\"lastName\" value=\"$lastName\"/>
							<input type=\"hidden\" id=\"birthDate\" name=\"birthDate\" value=\"$birthDate\"/>
							<input type=\"hidden\" id=\"gender\" name=\"gender\" value=\"$gender\"/>
                    </form></td>
					<td><form id=\"editPatient\" method=\"POST\" action=\"../Practitioner/report.php\">	
							<input type=\"submit\" id=\"ViewPatientsSubmit\" value=\"ViewReport\"/>
                        </form>
                    </td>
				  </tr>";
        }
        echo "</table>";
    }
}

function displayConnections($conn, $isAdmin, $searchTerms)
{
    if ($searchTerms == '') {
        if ($isAdmin) {
            $query = "SELECT r.Rel_ID, p.Prac_ID, p.FirstName+' '+p.LastName AS Practitioner_Name, s.Patient_ID, s.FirstName +' '+s.LastName AS Patient_Name FROM Connections r, Practitioners p, Patients s
                        WHERE s.Patient_ID = r.Patient_ID
                        AND p.Prac_ID = r.Prac_ID";
        }
    } else {
        if ($isAdmin) {
            $query = "SELECT r.Rel_ID, p.Prac_ID, p.FirstName+' '+p.LastName AS Practitioner_Name, s.Patient_ID, s.FirstName +' '+s.LastName AS Patient_Name FROM Connections r, Practitioners p, Patients s
							WHERE s.Patient_ID = r.Patient_ID
							AND p.Prac_ID = r.Prac_ID
							AND (p.FirstName LIKE '%$searchTerms%'
								OR p.LastName LIKE '%$searchTerms%'
								OR s.FirstName LIKE '%$searchTerms%'
								OR s.LastName LIKE '%$searchTerms%'
								OR p.Prac_ID LIKE '%$searchTerms%'
								OR s.Patient_ID LIKE '%$searchTerms%')
							ORDER BY r.Rel_ID";
        }
    }
    $connections = odbc_exec($conn, $query) or die("Server Error.");

    if (!odbc_error()) {
        echo "<table class=\"form-table\">
			<tr>
				<th>Connection ID</th>
				<th>Practitioner ID</th>
				<th>Practitioner Name</th>
				<th>Patient ID</th>
				<th>Patient Name</th>
			</tr>";
        while (odbc_fetch_row($connections)) {
            $connectionID = odbc_result($connections, "Rel_ID");
            $pracID = odbc_result($connections, "Prac_ID");
            $pracName = odbc_result($connections, "Practitioner_Name");
            $patientID = odbc_result($connections, "Patient_ID");
            $patientName = odbc_result($connections, "Patient_Name");

            echo "<tr>
					<td>$connectionID</td>
					<td>$pracID</td>
					<td>$pracName</td>
					<td>$patientID</td>
					<td>$patientName</td>
					<td><form id=\"deleteConnection\" onSubmit=\"return confirm('Are you sure?');\" method=\"POST\" action=\"./DelCon.php\">
							<input type=\"hidden\" id=\"pracID\" name=\"pracID\" value=\"$pracID\"/>
							<input type=\"hidden\" id=\"patientID\" name=\"patientID\" value=\"$patientID\"/>
							<input type=\"submit\" id=\"deleteConnectionSubmit\" value=\"Delete\"/></td>
						</form></td>
				  </tr>";
        }
        echo "</table>";
    }
}

function displayPractitioners($conn, $isAdmin, $searchTerms)
{
    if ($searchTerms == '') {
        if ($isAdmin) {
            $query = "SELECT * FROM Practitioners";
        }
    } else {
        if ($isAdmin) {
            $query = "SELECT * FROM Practitioners
							WHERE FirstName LIKE '%$searchTerms%'
							OR LastName LIKE '%$searchTerms%'
							OR Username LIKE '%$searchTerms%'
							OR Prac_ID LIKE '%$searchTerms%'";
        }
    }
    $practitioners = odbc_exec($conn, $query) or die("Server Error.");

    if (!odbc_error()) {
        echo "<table class=\"form-table\">
			<tr>
				<th>Practitioner ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Username</th>
				<th>Password</th>
				<th>Administrator?</th>
			</tr>";

        while (odbc_fetch_row($practitioners)) {
            $pracID = odbc_result($practitioners, "Prac_ID");
            $firstName = odbc_result($practitioners, "FirstName");
            $lastName = odbc_result($practitioners, "LastName");
            $userName = odbc_result($practitioners, "Username");
            $password = odbc_result($practitioners, "Password");
            $administrator = odbc_result($practitioners, "Administrator");

            if ($administrator) {
                $administratorString = "Yes";
            } else {
                $administratorString = "No";
            }

            echo "<tr>
					<td>$pracID</td>
					<td>$firstName</td>
					<td>$lastName</td>
					<td>$userName</td>
					<td>$password</td>
					<td>$administratorString</td>
					<td><form id=\"editPractitioner\" method=\"POST\" action=\"../editForm.php\">
							<input type=\"submit\" id=\"editPractitionerSubmit\" value=\"Edit\"/>
							<input type=\"hidden\" id=\"formType\" name=\"formType\" value=\"practitioner\"/>
							<input type=\"hidden\" id=\"pracID\" name=\"pracID\" value=\"$pracID\"/>
							<input type=\"hidden\" id=\"firstName\" name=\"firstName\" value=\"$firstName\"/>
							<input type=\"hidden\" id=\"lastName\" name=\"lastName\" value=\"$lastName\"/>
							<input type=\"hidden\" id=\"userName\" name=\"userName\" value=\"$userName\"/>
							<input type=\"hidden\" id=\"password\" name=\"password\" value=\"$password\"/>
							<input type=\"hidden\" id=\"administrator\" name=\"administrator\" value=\"$administrator\"/>
						</form></td>
				  </tr>";
        }
        echo "</table>";
    }
}

function patientAlreadyExists($firstName, $lastName, $dateOfBirth, $gender, $conn)
{
    $query = "SELECT * FROM Patients";
    $patients = odbc_exec($conn, $query) or die("Server Error.");

    if (!odbc_error()) {
        while (odbc_fetch_row($patients)) {
            $dbFirst = strtolower(odbc_result($patients, "FirstName"));
            $dbLast = strtolower(odbc_result($patients, "LastName"));
            $dbBirthDate = strtolower(odbc_result($patients, "BirthDate"));
            $bdYear = substr($dbBirthDate, 0, 4);
            $bdMonth = substr($dbBirthDate, 5, 2);
            $bdDay = substr($dbBirthDate, 8, 2);
            $dbBirthDate = $bdDay . "/" . $bdMonth . "/" . $bdYear;
            $dbGender = odbc_result($patients, "Gender");

            if ($dbFirst == strtolower($firstName) &&
                $dbLast == strtolower($lastName) &&
                $dbBirthDate == strtolower($dateOfBirth) &&
                $dbGender == strtolower($gender)) {
                return true;
            }
        }
    }
    return false;
}

function connectionAlreadyExists($practitioner, $patient, $conn)
{
    $query = "SELECT * FROM Connections";
    $results = odbc_exec($conn, $query) or die("Server Error.");

    if (!odbc_error()) {
        while (odbc_fetch_row($results)) {
            $dbPractitioner = odbc_result($results, "Prac_ID");
            $dbPatient = odbc_result($results, "Patient_ID");

            if ($dbPractitioner == $practitioner &&
                $dbPatient == $patient) {

                return true;
            }
        }
    }
    return false;
}

function practitionerAlreadyExists($firstName, $lastName, $userName, $conn)
{
    $query = "SELECT * FROM Practitioners";
    $practitioners = odbc_exec($conn, $query) or die("Server Error.");

    if (!odbc_error()) {
        while (odbc_fetch_row($practitioners)) {
            $dbFirst = strtolower(odbc_result($practitioners, "FirstName"));
            $dbLast = strtolower(odbc_result($practitioners, "LastName"));
            $dbUserName = odbc_result($practitioners, "Username");

            if ($dbFirst == strtolower($firstName) && $dbLast == strtolower($lastName) && $dbUserName == $userName) {
                return true;
            }
        }
    }
    return false;
}

function getLastPatientID($conn)
{
    $query = "SELECT TOP 1 Patient_ID AS ID FROM Patients ORDER BY Patient_ID DESC";
    $result = odbc_exec($conn, $query) or die("Server Error.");
    $lastID = null;
    if (!odbc_error()) {
        $lastID = odbc_result($result, "ID");
    }
    return $lastID;
}

function printPractitionerOptions($conn)
{
    $query = "SELECT * FROM Practitioners";
    $practitioners = odbc_exec($conn, $query) or die("Server Error.");
    if (!odbc_error()) {
        while (odbc_fetch_row($practitioners)) {
            $pracID = odbc_result($practitioners, "Prac_ID");
            $firstName = odbc_result($practitioners, "FirstName");
            $lastName = odbc_result($practitioners, "LastName");
            $fullName = $firstName . " " . $lastName;

            echo "<option value=\"$pracID\">$fullName</option>";
        }
    }
}

function printPatientOptions($conn)
{
    $query = "SELECT * FROM Patients";
    $patients = odbc_exec($conn, $query) or die("Server Error.");
    if (!odbc_error()) {
        while (odbc_fetch_row($patients)) {
            $patientID = odbc_result($patients, "Patient_ID");
            $firstName = odbc_result($patients, "FirstName");
            $lastName = odbc_result($patients, "LastName");
            $fullName = $firstName . " " . $lastName;

            echo "<option value=\"$patientID\">$fullName</option>";
        }
    }
}
?>