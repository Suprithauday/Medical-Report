<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" charset=utf-8"/>
    <link rel="stylesheet" href="style.css">
    <script>
        function ValidMedication() {
            var Med = document.getElementById('Medications');
            if (Med.value !== "") {
                return true;
            } else {
                return false;
            }
        }

        function MedStatus() {
            var MedSta = document.getElementById('MedicationStatus');
            if (MedSta.value !== "") {
                return true;
            } else {
                return false;
            }
        }

        function Diet() {
            var Dieta = document.getElementById('Diet');
            if (Dieta.value !== "") {
                return true;
            } else {
                return false;
            }
        }

        function DietStatus() {
            var DietStatus = document.getElementById('DietStatus');
            if (DietStatus.value !== "") {
                return true;
            } else {
                return false;
            }
        }

        function ValidEditDispenseformMed() {
            console.log(ValidMedication())
            console.log(MedStatus())
            if (!(ValidMedication() && MedStatus())) {
                alert("Please fix any errors ");
                return false;
            } else {
                return true;
            }
        }

        function ValidEditDispenseformDiet() {
            if (!(DietStatus() && Diet())) {
                alert("Please fix any errors ");
                return false;
            } else  {
                return true;
            }
        }

    </script>
    <title>BIOM 9450: A Web-Based Medication and Diet Regime Management System </title>
</head>
<body>
<form id="logout" method="POST" action="./index.php">
    <input type="submit" id="logoutSubmit" value="Log Out"/>
</form>

<form id="backToControlPanel" method="POST" action="DispenseMed.php">
    <input type="submit" id="backToControlsSubmit" value="Back"/>
</form>
<?php
//error_reporting(E_ERROR | E_PARSE);  // Disable ODBC Warnings
if (session_id() == '') {
    session_start();
}
$patientID = $_SESSION['patient_ID'];
$Routine = $_SESSION['routine'];
$Date = $_SESSION['date'];
$RoutineDiet = $_SESSION['DietRoutine'];
$DietDate = $_SESSION['DietDate'];
$patientName = $_SESSION["patient_name"];
$conn = odbc_connect("project", "", "");
if (!($patientID && $Routine && $Date && $RoutineDiet && $DietDate && $patientName)) {
    echo "Please go back to Dispense Medication and select patient and routines.";
} else {
//function disMed($firstname,$lastname, $conn) {
    $query = "SELECT * FROM MedRegime";
    $medication = odbc_exec($conn, $query);
    $query2 = "SELECT * FROM DietRegime";
    $Diet = odbc_exec($conn, $query2);
    $html = '<p>Patient Name : ' . $patientName . '</p>
            <form method="POST" onsubmit="return ValidEditDispenseformMed()" action="EditDispense.php"> 
            <h3> Select a Medication for ' . $Date . ' ' . $Routine . ': </h3> 
            <select id="Medications" name="Medication" onchange="ValidMedication()">
                <option value="">Please select an option</option>';
    while (odbc_fetch_row($medication)) {
        $med = odbc_result($medication, "Medication");
        $MEDID = odbc_result($medication, "Med_ID");
        $html .= '<option value=' . $MEDID . '>' . $med . '</option>';
    }
    $html .= '</select>
                <select id="MedicationStatus" name="MedicationStatus" onchange="MedStatus()">
                    <option value="">status</option>
                    <option value="given">given</option>
                    <option value="nostock">no stock</option>
                    <option value="fasting">fasting</option>
                    <option value="refused">refused</option>
                    <option value="ceased">Ceased</option>
                </select>
                <input type="submit" name="SubmitMedication">
                </form>';
    echo $html;

    $htm = '<form method = "POST" onsubmit="return ValidEditDispenseformDiet()" action="EditDispense.php"> 
            <h3> Select a Diet Regime for ' . $DietDate . ' ' . $RoutineDiet . ': </h3> 
            <select id="Diet" name="Diet" onchange="Diet()">
                <option value="">Please select an option</option>';

    while (odbc_fetch_row($Diet)) {
        $diet = odbc_result($Diet, "Description");
        $DietID = odbc_result($Diet, "Diet_ID");
//    $dosage = odbc_result($dosage,"Dosage");
        $htm .= '<option value=' . $DietID . '>' . $diet . '</option>';
    }

    $htm .= '</select>
            <select id="DietStatus" name="DietStatus" onchange="DietStatus()">
                <option value="">status</option>
                <option value="given">given</option>
                <option value="nostock">no stock</option>
                <option value="fasting">fasting</option>
                <option value="refused">refused</option>
                <option value="ceased">Ceased</option>
            <input type="submit" name="SubmitDiet">
            </form>';
    echo $htm;
}

if (isset($_POST['SubmitMedication'])) {
    $medication = $_POST['Medication'];
    $MedicationStatus = $_POST['MedicationStatus'];
    $query1 = "UPDATE PatMedCon SET Med_ID = $medication, Status='$MedicationStatus'
                WHERE Patient_ID = $patientID
                AND Routine = '$Routine'
                AND Date = #$Date#";
    $Medication = odbc_exec($conn, $query1) or die("Server Error. Failed to Update.");
    if(!odbc_error()){
        echo "Medication has been updated successfully";
    }
}

//Diet Regime
if (isset($_POST['SubmitDiet'])) {
    $Diet = $_POST['Diet'];
    $DietStatus = $_POST['DietStatus'];
    $query3 = "UPDATE PatDietCon SET Diet_ID = $Diet, Status = '$DietStatus'
                WHERE Patient_ID = $patientID
                AND Routine = '$RoutineDiet'
                AND Date = #$DietDate#";
    $Diet = odbc_exec($conn, $query3) or die("Server Error. Failed to Update.");
    if(!odbc_error()){
        echo "Diet Regime has been updated successfully";
    }
}

?>
</body>
</html>
