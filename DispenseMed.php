<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" charset=utf-8" />
    <link rel="stylesheet" href="style.css">
    <script>

        // function validRoutine() {
        //     var routine = document.getElementById('RoutineDiet');
        //     console.log("routine is " + routine.value);
        //     if (routine.value === 'Morning' || routine.value === 'Afternoon' || routine.value === 'night') {
        //         document.getElementById('RoutineDietError').innerHTML = '';
        //         return true;
        //     } else {
        //         document.getElementById('RoutineDietError').innerHTML = 'Please make a choice for Male or Female.';
        //         document.getElementById('RoutineDietError').style.color = 'red';
        //         return false;
        //     }
        // }
        // function validMedRoutine() {
        //     var Medroutine = document.getElementById('RoutineMed');
        //     console.log("Medroutine is " + Medroutine.value);
        //     if (Medroutine.value === 'Morning' || Medroutine.value === 'Afternoon' || Medroutine.value === 'night') {
        //         document.getElementById('RoutineMedError').innerHTML = '';
        //         return true;
        //     } else {
        //         document.getElementById('RoutineMedError').innerHTML = 'Please make a choice for Male or Female.';
        //         document.getElementById('RoutineMedError').style.color = 'red';
        //         return false;
        //     }
        // }
        function validPat()
        {
            var pat = document.getElementById('patients');
            console.log("pat is "+pat.value);
            if (pat.value === "")
            {
                document.getElementById('patients').innerHTML = '';
                return true;
            } else {
                document.getElementById('patients').innerHTML = 'Please make a choice.';
                document.getElementById('patients').style.color = 'red';
                return false;
            }
        }
        function validDate()
        {
            var date = document.getElementById('DietDate');
            console.log("date is "+date.value);
            if (date.value === "null")
            {
                document.getElementById('DietDate').innerHTML = 'null';
                return true;
            } else {
                document.getElementById('DietDate').innerHTML = 'Please make a choice.';
                document.getElementById('DietDate').style.color = 'red';
                return false;
            }
        }

        function validMedDate()
        {
            var Meddate = document.getElementById('MedicationDate');
            console.log("Meddate is "+Meddate.value);
            if (Meddate.value === "")
            {
                document.getElementById('MedicationDate').innerHTML = '';
                return true;
            } else {
                document.getElementById('MedicationDate').innerHTML = 'Please make a choice.';
                document.getElementById('MedicationDate').style.color = 'red';
                return false;
            }
        }

        function validDispenseform() {
            console.log('check')
            if (!(validPat()  && validDate() && validMedDate())){
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
$conn = odbc_connect("project","","");

    $query = "SELECT * FROM Patients";
    $patients = odbc_exec($conn,$query);
        $html = ' <form name="Dform" method="POST" onsubmit="return validDispenseform()" action="DispenseMed.php"> 
                    <h4> Select a Patient: </h4> 
                    <select id="patients" name="patients" onchange="ValidPat()">
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
  <select name="DietRoutine" id="RoutineDiet" onchange="ValidRoutine()">
  <option value="Morning">Morning</option>
  <option value="Afternoon">Afternoon</option>
  <option value="night">Night</option>
</select>
  <label for="DietDate"></label>
  <p>Diet Date:</p>
  <input type="date" id="DietDate" name="DietDate" onchange="ValidDate()">

<label for="Routine"><p>Choose a Medication Routine:</p></label>
<select name="MedicationRoutine" id="Routine" onchange="ValidMedRoutine()">
  <option value="Morning">Morning</option>
  <option value="Afternoon">Afternoon</option>
  <option value="night">Night</option>
</select>

  <label for="MedicationDate"><p>Medication Date:</p></label>
  <input type="date" id="MedicationDate" name="MedicationDate" onchange="ValidMedDate()">
  <input type="submit" name="submit">
</form>';
 echo $html;

 if(isset($_POST['submit']))
 {
     $patientID=$_POST['patients'];
     $Routine = $_POST['MedicationRoutine'];
     $RoutineDiet = $_POST['DietRoutine'];
     $MedicationDate = date_format(date_create($_POST['MedicationDate']),"d/m/Y");
     $DietDate = date_format(date_create($_POST['DietDate']),"d/m/Y");
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