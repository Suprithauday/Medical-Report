
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
            padding: 20px;
            text-align: center;
            background: #000000;
            color: white;
        }

        /* Increase the font size of the heading */
        .header h1 {
            font-size: 40px;}

        .navbar {
            overflow: hidden;
            background-color: #333;
            position: sticky;
            position: -webkit-sticky;
            top: 0;
        }

        /* Style the navigation bar links */
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }


        /* Change color on hover */
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Active/current link */
        .navbar a.active {
            background-color: #666;
            color: white;
        }

        /* Column container */
        .row {
            display: -ms-flexbox; /* IE10 */
            display: flex;
            -ms-flex-wrap: wrap; /* IE10 */
            flex-wrap: wrap;
        }

        /* Sidebar/left column */
        .side {
            -ms-flex: 30%;
            flex: 30%;
            background-color: #f1f1f1;
            padding: 20px;
        }

        /* Main column */
        .main {
            -ms-flex: 70%; /* IE10 */
            flex: 70%;
            background-color: white;
            padding: 20px;
        }

        /*Patient Image */
        img {
            width:200px;
            height:200px;
        }

        @media screen and (max-width: 700px) {
            .row {
                flex-direction: column;
            }
        }

        @media screen and (max-width: 400px) {
            .navbar a {
                float: none;
                width: 100%;
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
        .button{
            text-decoration: none;
            color: #FFF;
            width: 20px;
            height: 20px;
            line-height: 120px;
            border-radius: 50%;
            text-align: center;
            vertical-align: middle;
            overflow: hidden;
            transition: .4s;
            display: block;
        }

        .button1 {border-radius: 80%;background-color: greenyellow}
        .button2 {border-radius: 80%;background-color: red}
        .button3 {border-radius: 80%;background-color: gray}
        .button4 {border-radius: 80%;background-color: pink}
        .button5 {border-radius: 80%;background-color: deepskyblue}

        .legend-scale ul {
            margin: 0;
            margin-bottom: 5px;
            padding: 0;
            float: left;
            list-style: none;
        }
        .legend-scale ul li {
            font-size: 80%;
            list-style: none;
            margin-left: 0;
            line-height: 18px;
            margin-bottom: 2px;
        }
        ul.legend-labels li span {
            display: block;
            float: left;
            height: 16px;
            width: 30px;
            margin-right: 5px;
            margin-left: 0;
            border: 1px solid #999;
        }

    </style>
</head>
<body>
<?php
$conn = odbc_connect("project", "", "");
if()
$patientID = $_POST['patients'];
$Routine = $_POST['MedicationRoutine'];
$RoutineDiet = $_POST['RoutineDiet'];
$DietDate = $_POST['DietDate'];
$MedicationDate = $_POST['MedicationDate'];
$_SESSION["date"] = $MedicationDate;
$_SESSION["DietDate"] = $DietDate;
$_SESSION["patient_ID"] = $patientID;
$_SESSION["routine"] = $Routine;
$_SESSION["DietRoutine"] = $RoutineDiet;

$patientQuery = "SELECT * FROM Patients WHERE Patient_ID=$patientID";

$patient = odbc_exec($conn, $patientQuery);
echo '$patient';
$Q1 = "SELECT * FROM PatMedCon,MedRegime,Patients
                        WHERE PatMedCon.Patient_ID=Patients.Patient_ID
                        AND PatMedCon.Med_ID=MedRegime.Med_ID
                        AND Patients.Patient_ID=$patientID;
                        AND PatMedCon.Date=#$MedicationDate#";
$Q2 = "SELECT * FROM PatDietCon,DietRegime,Patients 
                        WHERE PatDietCon.Patient_ID=Patients.Patient_ID
                        AND PatDietCon.Diet_ID=DietRegime.Diet_ID
                        AND Patients.Patient_ID=$patientID
                        AND PatDietCon.Date=#$DietDate#";
$patient = odbc_exec($conn, $patientQuery);
$MedRegime = odbc_exec($conn, $Q1);
$DietRegime = odbc_exec($conn, $Q2);
echo "$patient";
?>
    <div class="header">
    <h1>Medical Report</h1>
    </div>
    <div class="navbar">
<!--        <form action="MedReport.php" method="post">-->
<!--            <input type="text" name="MedReport"><br>-->
<!--            <input type="text" name="DietReport"><br>-->
<!--            <input type="submit">-->
<!--        </form>-->
    <a href="#" class="active">Home</a>
        <a href="MedReport.php">Patients Medication Report</a></div>
<!--    <a href="DietReport.php">Patient Diet Report</a>-->
    </div>

    <div class="row">
    <div class="side">
    <h2>Patient Info</h2>
    <h5>Patient Name:</h5>

        <img src="../Patients/aged_man.jpg" height="250" width="500">
        <h3>The patient has been suffering from Diabetics. </h3>
    </div>
        <div class="main">
    <h2>Patient Brief</h2>
    <h5>Date:</h5>
        <h3>Brief Summary Sheet</h3>
        <table id="t01">
            <tr>
                <th>Medication Name</th>
                <th>Dosage</th>
                <th>Round</th>
                <th>30th Nov</th>
                <th>01st Dec</th>
                <th>02nd Dec</th>
                <th>03rd Dec</th>
                <th>04th Dec</th>
                <th>05th Dec</th>
                <th>06th Dec</th>
            </tr>
            <tr>
                <td>Betalog 50 mg</td>
                <td>2</td>
                <td>13:00</td>
                <td><button class="button button1">G</button></td>
                <td><button class="button button2">N</button></td>
                <td><button class="button button1">G</button></td>
                <td><button class="button button1">G</button></td>
                <td><button class="button button1">G</button></td>
                <td><button class="button button1">G</button></td>
                <td><button class="button button1">G</button></td>
            </tr>

        </table><br>

<ul>
   <span><button class="button button1">G</button>
    <button class="button button2">N</button>
        <button class="button button3">O</button>
        <button class="button button4">M</button>
       <button class="button button5">F</button></span>
</ul>
    </div>
    </div>
    <p><center> To know more, click on the tabs. </center></p>





</body>
</html>

