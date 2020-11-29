<?php
include("operations.php");
session_start();
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" charset=utf-8" />
        <link rel="stylesheet" href="style.css">
        <script src="FormVerify.js"></script>

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
if(session_id() == '') {
    session_start();
}

$conn = odbc_connect("project","","");
//function disMed($firstname,$lastname, $conn) {
$query = "SELECT * FROM MedRegime";
$medication = odbc_exec($conn,$query);
$query2 = "SELECT * FROM DietRegime";
$Diet = odbc_exec($conn,$query2);
$html = '<form method = "POST" action="EditDispense.php"> 
                    <p> Select a Medication: </p> 
                    <select id="Medications" name="Medication" >
                        <option value="">Please select an option</option>';
while(odbc_fetch_row($medication)) {
    $med = odbc_result($medication,"Medication");
    $MEDID = odbc_result($medication,"Med_ID");
//    $dosage = odbc_result($dosage,"Dosage");
    $html .= '<option value='.$MEDID.'>'.$med.'</option>';
}

$html .= '</select>
    <select id="MedicationStatus" name="MedicationStatus">
    <option value="">status</option>
                        <option value="">given</option>
                        <option value="">no stock</option>
                          <option value="">fasting</option>
                            <option value="">refused</option>
                            <option value="">Ceased</option>
    </select>
 <input type="submit" name="SubmitMedication">
</form>';
echo $html;

$htm = '<form method = "POST" action="EditDispense.php"> 
                    <p> Select a Diet Regime: </p> 
                    <select id="Diet" name="Diet" >
                        <option value="">Please select an option</option>';

while(odbc_fetch_row($Diet)) {
    $diet = odbc_result($Diet,"Description");
    $DietID = odbc_result($Diet,"Diet_ID");
//    $dosage = odbc_result($dosage,"Dosage");
    $htm .= '<option value='.$DietID.'>'.$diet.'</option>';
}

$htm.= '</select>
<select id="DietStatus" name="DietStatus">
<option value="">status</option>
                        <option value="">given</option>
                        <option value="">no stock</option>
                          <option value="">fasting</option>
                            <option value="">refused</option>
                            <option value="">Ceased</option>
 <input type="submit" name="SubmitDiet">
</form>';
echo $htm;

if (isset($_POST['SubmitMedication'])) {
    $medication = $_POST['Medication'];
    $MedicationStatus = $_POST['MedicationStatus'];
    $patientID = $_SESSION['patient_id'];
    $Routine = $_SESSION['routine'];
    $Date = $_SESSION['date'];
    $query1 = "UPDATE PatMedCon SET Med_ID = $medication && Status='$MedicationStatus'
                WHERE Patient_ID = $patientID
                AND Routine = '$Routine'
                AND Date = #$Date#";
    echo $query1;
    $Medication = odbc_exec($conn,$query1);
    }

//Diet Regime
if (isset($_POST['SubmitDiet'])) {
    $Diet = $_POST['Diet'];
    $patientID = $_SESSION['patient_id'];
    $DietStatus = $_POST['DietStatus'];
    $RoutineDiet = $_SESSION['DietRoutine'];
    $Date = $_SESSION['DietDate'];
    $query3 = "UPDATE PatDietCon SET Diet_ID = $Diet && Status = '$DietStatus'
                WHERE Patient_ID = $patientID
                AND Routine = '$RoutineDiet'
                AND Date = #$Date#";
    echo $query3;
    $Diet = odbc_exec($conn,$query3);
}

?>
</body>
</html>
