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
$conn = odbc_connect("project","","");

    $query = "SELECT * FROM Patients";
    $patients = odbc_exec($conn,$query);
        $html = ' <form method = "POST" action="DispenseMed.php"> 
                    <h4> Select a Patient: </h4> 
                    <select id="patients" name="patients" >
                        <option value="">Please select an option</option>';
    while(odbc_fetch_row($patients)) {
            $firstName = odbc_result($patients,"FirstName");
            $lastName = odbc_result($patients,"LastName");
            $patientID = odbc_result($patients,"Patient_ID");
        $html .= '<option value='.$patientID.'>'.$firstName.' '.$lastName.'</option>';
        }

$html .= '</select>
  <label for="RoutineDiet"></label>
  <p>Choose a Diet Routine:</p>
  <select name="DietRoutine" id="RoutineDiet">
  <option value="Morning">Morning</option>
  <option value="Afternoon">Afternoon</option>
  <option value="night">Night</option>
</select>
  <label for="DietDate"></label>
  <p>Diet Date:</p>
  <input type="date" id="Dietdate" name="Dietdate">

<label for="Routine"><p>Choose a Medication Routine:</p></label>
<select name="MedicationRoutine" id="Routine">
  <option value="Morning">Morning</option>
  <option value="Afternoon">Afternoon</option>
  <option value="night">Night</option>
</select>

  <label for="MedicationDate"><p>Medication Date:</p></label>
  <input type="date" id="Medicationdate" name="Medicationdate">
  <input type="submit" name="submit">
</form>';
 echo $html;

 if(isset($_POST['submit']))
 {
     $patientID=$_POST['patients'];
     $Routine = $_POST['MedicationRoutine'];
     $RoutineDiet = $_POST['DietRoutine'];
     $MedicationDate = date_format(date_create($_POST['Medicationdate']),"d/m/Y");
     $DietDate = date_format(date_create($_POST['Dietdate']),"d/m/Y");
     $_SESSION["patient_id"] = $patientID;
     $_SESSION["routine"] = $Routine;
     $_SESSION["date"] = $MedicationDate;
     $_SESSION["DietRoutine"] = $RoutineDiet;
     $_SESSION["DietDate"] = $DietDate;

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
//     echo $query1;
$MedRegime = odbc_exec($conn,$query1);
$DietRegime = odbc_exec($conn,$query);


while (odbc_fetch_row($MedRegime)) {
    $Patient_ID = odbc_result($MedRegime, "Patient_ID");
    $Med_ID = odbc_result($MedRegime, "Med_ID");
    $date = odbc_result($MedRegime, "Date");
    $day = odbc_result($MedRegime, "Day");
    $routine = odbc_result($MedRegime, "Routine");
    $status = odbc_result($MedRegime, "Status");
    $Medication = odbc_result($MedRegime, "Medication");
    echo $Patient_ID . ' ' . $Med_ID . ' ' . $date . ' ' . $day . ' ' . $routine . ' ' . $status. ' '.$Medication;
}

     while (odbc_fetch_row($DietRegime)) {
     $Patient_ID = odbc_result($DietRegime, "Patient_ID");
     $Diet_ID = odbc_result($DietRegime, "Diet_ID");
     $date = odbc_result($DietRegime, "Date");
     $day = odbc_result($DietRegime, "Day");
     $routine = odbc_result($DietRegime, "Routine");
     $status = odbc_result($DietRegime, "Status");
         $description = odbc_result($DietRegime, "Description");
     echo $Patient_ID . ' ' . $Diet_ID . ' ' . $date . ' ' . $day . ' ' . $routine . ' ' . $status.' '.$description;
 }
}

echo'<center><a href="EditDispense.php"><button>EDIT DISPENSE</button></a></center>'

?>
</body>
</html>