
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medical Report</title>2
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }

        .header {
            padding: 25px;
            text-align: center;
            background: #000000;
            color: white;
        }

        /* Increase the font size of the heading */
        .header h1 {
            font-size: 40px;}

        /* Column container */
        .row {
            display: -ms-flexbox; /* IE10 */
            display: flex;
        }

        /* Sidebar/left column */
        .side {
            -ms-flex: 20%;
            flex: 20%;
            background-color: #f1f1f1;
            padding: 20px;
        }

        /* Main column */
        .main {
            -ms-flex: 100%; /* IE10 */
            flex: 100%;
            background-color: white;
            padding: 30px;
        }

        /*Patient Image */
        img {
            width:200px;
            height:200px;
        }

        @media screen and (max-width: 900px) {
            .row {
                flex-direction: column;
            }
        }

        table {
            width:100%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        table tr:nth-child(even) {
            background-color: #eee;
        }
        table tr:nth-child(odd) {
            background-color: #fff;
        }
        table th {
            background-color: black;
            color: white;
        }


    </style>
</head>
<body>

<?php
$conn = odbc_connect("project", "", "");
if(isset($_POST['ViewReport'])) {

    $patientID = $_POST['patient_ID'];
    $_SESSION["patient_ID"] = $patientID;
    $patientQuery = "SELECT * FROM Patients WHERE Patient_ID=$patientID";
    $patient = odbc_exec($conn, $patientQuery);

    //page 1
    $start_date = date_format(date_sub(date_create(),date_interval_create_from_date_string('8 days')), "Y-m-d");
    $end_date = date_format(date_sub(date_create(),date_interval_create_from_date_string('1 day')), "Y-m-d");;
    //page 2
    $start_date2 = date_format(date_create(), "Y-m-d");
    $end_date2 = date_format(date_add(date_create(),date_interval_create_from_date_string('7 days')), "Y-m-d");

    $Q1 = "SELECT * FROM PatMedCon,MedRegime,Patients
                        WHERE PatMedCon.Patient_ID=Patients.Patient_ID
                        AND PatMedCon.Med_ID=MedRegime.Med_ID
                        AND Patients.Patient_ID=$patientID
                        AND PatMedCon.Date between #$start_date# and #$end_date#";

    $Q2 = "SELECT * FROM PatMedCon,MedRegime,Patients
                        WHERE PatMedCon.Patient_ID=Patients.Patient_ID
                        AND PatMedCon.Med_ID=MedRegime.Med_ID
                        AND Patients.Patient_ID=$patientID
                        AND PatMedCon.Date between #$start_date2# and #$end_date2#";
    $Q3 = "SELECT * FROM PatDietCon,DietRegime,Patients
                        WHERE PatDietCon.Patient_ID=Patients.Patient_ID
                        AND PatDietCon.Diet_ID=DietRegime.Diet_ID
                        AND Patients.Patient_ID=$patientID
                        AND PatDietCon.Date between #$start_date# and #$end_date#";
    $Q4 = "SELECT * FROM PatDietCon,DietRegime,Patients
                        WHERE PatDietCon.Patient_ID=Patients.Patient_ID
                        AND PatDietCon.Diet_ID=DietRegime.Diet_ID
                        AND Patients.Patient_ID=$patientID
                        AND PatDietCon.Date between #$start_date2# and #$end_date2#";

    $patient = odbc_exec($conn, $patientQuery);
    $patient_name = '';
    $patient_image = '';
    while(odbc_fetch_row($patient)){
        $patient_name = odbc_result($patient, "FirstName").' '.odbc_result($patient, "LastName");
        $patient_image = odbc_result($patient, "ProfilePhoto");

        $patient_bday = date_format(date_create_from_format('Y-m-d h:i:s',odbc_result($patient, "BirthDate")), "d/m/Y" );
        $patient_gender = odbc_result($patient, "Gender");
        $patient_room = odbc_result($patient, "RoomNumber");

    }

    $MedRegime = odbc_exec($conn, $Q1);
    $MedRegimeNext = odbc_exec($conn, $Q2);
    $DietRegime = odbc_exec($conn, $Q3);
    $DietRegimeNext = odbc_exec($conn, $Q4);

    echo '<div class="header">';
    echo '<h1>Medical Report</h1>
    </div>
   
    <div class="row">
    <div class="side">
    <h2>Patient Info</h2>';
    echo '<h2>' . $patient_name . '</h2>';

    echo ' <img src="'.$patient_image.'" height="250" width="500">
        <h3>VIP patient.</h3>
        <p> Date of Birth :'.$patient_bday.'</p>
        <p>Gender: '.$patient_gender.'</p>
        <p> Room Number: '.$patient_room.'</p>
        
    </div>
    
        <div class="main">
    <h2>Patient Brief</h2>
    <h5>Date:</h5>
        <h3>Brief Summary Sheet</h3>
        <h3>Medication Details for past week starting from '.$start_date.' and '.$end_date.'</h3>
        <table id="t01">
            <tr>
                <th>Medication Name</th>
                <th>Dosage</th>
                <th>Date</th>
                <th>Routine</th>
                <th>Status</th>
            </tr>';

        $rows = '';
        while(odbc_fetch_row($MedRegime)) {
        $medName = odbc_result($MedRegime,"Medication");
        $dosage = odbc_result($MedRegime,"Dosage");
        $date = date_format(date_create_from_format('Y-m-d h:i:s',odbc_result($MedRegime, "Date")), "d/m/Y");
        $routine = odbc_result($MedRegime, "Routine");
        $status = odbc_result($MedRegime, "Status");

        $rows .='<tr>
                <td>'.$medName.'</td>
                <td>'.$dosage.'</td>
                <td>'.$date.'</td>
                <td>'.$routine.'</td>
                <td>'.$status.'</td>
            </tr>';
    }

        echo $rows.'</table><br>';
        echo '<h3>Medication for next week starting from '.$start_date2.' and '.$end_date2.'</h3>
        <table id="t01">
            <tr>
                <th>Medication Name</th>
                <th>Dosage</th>
                <th>Date</th>
                <th>Routine</th>
                <th>Status</th>
            </tr>';
        $rows = '';

    while(odbc_fetch_row($MedRegimeNext)) {
        $medName = odbc_result($MedRegimeNext,"Medication");
        $dosage = odbc_result($MedRegimeNext,"Dosage");
        $date = date_format(date_create_from_format('Y-m-d h:i:s',odbc_result($MedRegimeNext, "Date")), "d/m/Y");
        $routine = odbc_result($MedRegimeNext, "Routine");
        $status = odbc_result($MedRegimeNext, "Status");

        $rows .='<tr>
                <td>'.$medName.'</td>
                <td>'.$dosage.'</td>
                <td>'.$date.'</td>
                <td>'.$routine.'</td>
                <td>'.$status.'</td>
            </tr>';
    }
        echo $rows.'</table><br>';
echo '</div>
    </div>';

    echo'<div class="main">';
   echo'<h3>Diet Details for past week starting from '.$start_date.' and '.$end_date.'</h3>
        <table id="t01">
            <tr>
                <th>Diet</th>
                <th>Date</th>
                <th>Routine</th>
                <th>Status</th>
            </tr>';
    $rows = '';
    while(odbc_fetch_row($DietRegime)) {
        $diet = odbc_result($DietRegime,"Description");
        $date = date_format(date_create_from_format('Y-m-d h:i:s',odbc_result($DietRegime, "Date")), "d/m/Y");
        $routine = odbc_result($DietRegime, "Routine");
        $status = odbc_result($DietRegime, "Status");
        $rows .='<tr>
               <td>'.$diet.'</td>
                <td>'.$date.'</td>
                <td>'.$routine.'</td>
                <td>'.$status.'</td>
            </tr>';
    }
    echo $rows.'</table><br>';
    echo '</div>';
    echo'<div class="main">';
    echo '<h3>Diet for next week starting from '.$start_date2.' and '.$end_date2.'</h3>
        <table id="t01">
            <tr>
               <th>Diet</th>
                <th>Date</th>
                <th>Routine</th>
                <th>Status</th>
            </tr>';
    $rows = '';
    while(odbc_fetch_row($DietRegimeNext)) {
        $medName = odbc_result($DietRegimeNext,"Description");
        $date = date_format(date_create_from_format('Y-m-d h:i:s',odbc_result($DietRegimeNext, "Date")), "d/m/Y");
        $routine = odbc_result($DietRegimeNext, "Routine");
        $status = odbc_result($DietRegimeNext, "Status");

        $rows .='<tr>
                 <td>'.$diet.'</td>
                <td>'.$date.'</td>
                <td>'.$routine.'</td>
                <td>'.$status.'</td>
            </tr>';
    }
    echo $rows.'</table><br>';
    echo '</div>';
}

?>
</body>
</html>