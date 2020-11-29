<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medical Report</title>
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
            width:400px;
            height:400px;
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
            display: inline-block;
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
        }


        .button1 {border-radius: 80%;background-color: greenyellow}
        .button2 {border-radius: 80%;background-color: red}
        .button3 {border-radius: 80%;background-color: gray}
        .button4 {border-radius: 80%;background-color: pink}
        .button5 {border-radius: 80%;background-color: deepskyblue}


    </style>
</head>
<body>

    <div class="header">
    <h1>Medical Report</h1>
    </div>

    <div class="navbar">
    <a href="#" class="active">Blah Blah</a>
    <a href="#">Med Summary Report</a>
    <a href="#">Diet Summary Report</a>
    </div>

    <div class="row">
    <div class="side">
    <h2>Patient Info</h2>
    <h5>Patient Name:</h5>

        <img src="../Patients/aged_man.jpg" height="400" width="800">
        <h3>random info </h3>
    </div>
        <div class="main">
    <h2>TITLE HEADING</h2>
    <h5>Description, Nov 29,2020</h5>
    <p>Some text..</p>
    <p>Introduction</p> <br>

            <h2>Summary Sheet</h2>

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

            </table>
            <button class="button button1">G</button>
            <button class="button button2">N</button>
            <button class="button button3">O</button>
            <button class="button button4">M</button>
            <button class="button button5">F</button>

    </div>
    </div>
</body>
</html>
