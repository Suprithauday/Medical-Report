<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" charset=utf-8"/>
    <link rel="stylesheet" href="style.css">
    <script>


        function validPat() {
            var pat = document.getElementById('patients');
            console.log("pat is " + pat.value);
            if (pat.value !== "") {
                return true;
            } else {
                return false;
            }
        }

        function validDate() {
            var date = document.getElementById('DietDate');
            console.log("date is " + date.value);
            if (date.value !== "") {
                return true;
            } else {
                return false;
            }
        }

        function validMedDate() {
            var Meddate = document.getElementById('MedicationDate');
            console.log("Meddate is " + Meddate.value);
            if (Meddate.value !== "") {
                return true;
            } else {
                return false;
            }
        }

        function validDispenseform() {
            console.log('check')
            if (!(validPat() && validDate() && validMedDate())) {
                alert("Please fix any errors ");
                return false;
            } else {
                return true;
            }
        }

        // function ValidLoginInfo()
        // {
        //     var empt = document.forms["Dform"].value;
        //     if (empt == null)
        //     {
        //         alert("Please input a Value");
        //         return false;
        //     }
        //     else
        //     {
        //         alert('Already entered');
        //         return true;
        //     }
        // }

    </script>

    <title>BIOM 9450: A Web-Based Medication and Diet Regime Management System </title>
</head>
<body>

<form id="logout" method="POST" action="./index.php">
    <input type="submit" id="logoutSubmit" value="Log Out"/>
</form>
<form id="backToControlPanel" method="POST" action="./controls/controls.php">
    <input type="submit" id="backToControlsSubmit" value="Back"/>
</form>
<?php
error_reporting(E_ERROR | E_PARSE);  // Disable ODBC Warnings
$conn = odbc_connect("project", "", "");

$query = "SELECT * FROM Patients";
$patients = odbc_exec($conn, $query);
if (odbc_error()) {
    echo "Server Error";
} else {
    $html = ' <form name="Dform" method="POST" onsubmit="return validDispenseform()" action="DispenseMed.php"> 
                        <h4> Select a Patient: </h4> 
                        <select id="patients" name="patients" onchange="ValidPat()">
                            <option value="">Please select an option</option>';

    while (odbc_fetch_row($patients)) {
        $firstName = odbc_result($patients, "FirstName");
        $lastName = odbc_result($patients, "LastName");
        $patientID = odbc_result($patients, "Patient_ID");
        $html .= '<option value=' . $patientID . '>' . $firstName . ' ' . $lastName . '</option>';
    }
    $html .= '</select>
                <p>Medication:</p>
                <input type="date" id="MedicationDate" name="MedicationDate" onchange="ValidMedDate()">
                <select name="MedicationRoutine" id="Routine" onchange="ValidMedRoutine()">
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="night">Night</option>
                </select>
                
                <p>Diet Regime:</p> 
                <input type="date" id="DietDate" name="DietDate" onchange="ValidDate()">
                <select name="DietRoutine" id="RoutineDiet" onchange="ValidRoutine()">
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="night">Night</option>
                </select>
                <br/>
                <input type="submit" name="submit">
    </form>';
    echo $html;

    if (isset($_POST['submit'])) {
        $patientID = $_POST['patients'];
        $Routine = $_POST['MedicationRoutine'];
        $RoutineDiet = $_POST['DietRoutine'];
        $MedicationDate = date_format(date_create($_POST['MedicationDate']), "d/m/Y");
        $DietDate = date_format(date_create($_POST['DietDate']), "d/m/Y");
        $_SESSION["patient_ID"] = $patientID;
        $_SESSION["routine"] = $Routine;
        $_SESSION["date"] = $MedicationDate;
        $_SESSION["DietRoutine"] = $RoutineDiet;
        $_SESSION["DietDate"] = $DietDate;
        $patientQuery = "SELECT * FROM Patients WHERE Patient_ID=$patientID";
        $query1 = "SELECT * FROM PatMedCon,MedRegime,Patients 
                        WHERE PatMedCon.Patient_ID=Patients.Patient_ID
                        AND PatMedCon.Med_ID=MedRegime.Med_ID
                        AND Patients.Patient_ID=$patientID
                        AND PatMedCon.Routine='$Routine'
                        AND PatMedCon.Date=#$MedicationDate#";

        $query = "SELECT * FROM PatDietCon,DietRegime,Patients 
                        WHERE PatDietCon.Patient_ID=Patients.Patient_ID
                        AND PatDietCon.Diet_ID=DietRegime.Diet_ID
                        AND Patients.Patient_ID=$patientID
                        AND PatDietCon.Routine='$RoutineDiet'
                        AND PatDietCon.Date=#$DietDate#";
        global $conn;
        $patient = odbc_exec($conn, $patientQuery) or die("Server Error");
        $MedRegime = odbc_exec($conn, $query1) or die("Server Error");
        $DietRegime = odbc_exec($conn, $query) or die("Server Error");

        if (!odbc_error()) {
            $patient_name = odbc_result($patient, "FirstName").' '.odbc_result($patient, "LastName");
            $_SESSION["patient_name"] = $patient_name;
            $found = false;
            $medHtml = "<p><h3>Medications</h3> for patient $patient_name on $MedicationDate $Routine</p>
                        <table>
                        <tr>
                            <th>Medication</th>
                            <th>Status</th>
                        </tr>";
            while (odbc_fetch_row($MedRegime)) {
                $found = true;
                $Patient_ID = odbc_result($MedRegime, "Patient_ID");
                $Med_ID = odbc_result($MedRegime, "Med_ID");
                $date = odbc_result($MedRegime, "Date");
                $day = odbc_result($MedRegime, "Day");
                $routine = odbc_result($MedRegime, "Routine");
                $status = odbc_result($MedRegime, "Status");
                $Medication = odbc_result($MedRegime, "Medication");
                $medHtml .= "<tr>
                                <td>$Medication</td>
                                <td>$status</td>
                            </tr>";
            }
            $medHtml .= "</table>";
            if (!$found) {
                echo "No Medication Data found on $MedicationDate $Routine for patient $patient_name.\n";
            }else{
                echo $medHtml;
            }
            $found = false;
            $dietHtml = "<p><h3>Diet Regime</h3> for patient $patient_name on $DietDate $RoutineDiet</p>
                        <table>
                        <tr>
                            <th>Diet Regime</th>
                            <th>Status</th>
                        </tr>";
            while (odbc_fetch_row($DietRegime)) {
                $found = true;
                $Patient_ID = odbc_result($DietRegime, "Patient_ID");
                $Diet_ID = odbc_result($DietRegime, "Diet_ID");
                $date = odbc_result($DietRegime, "Date");
                $day = odbc_result($DietRegime, "Day");
                $routine = odbc_result($DietRegime, "Routine");
                $status = odbc_result($DietRegime, "Status");
                $description = odbc_result($DietRegime, "Description");
                $dietHtml .= "<tr>
                                <td>$description</td>
                                <td>$status</td>
                            </tr>";
            }
            $dietHtml .= "</table>";
            if (!$found) {
                echo "No Diet Regime Data found on $DietDate $RoutineDiet for patient $patient_name.";
            }else{
                echo $dietHtml;
            }
        } else {
            echo "Server Error";
        }
        echo '<center><a href="EditDispense.php"><button>EDIT DISPENSE</button></a></center>';
    }
}


?>
</body>
</html>