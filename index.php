<?php
include "checklogin.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

    <style>
        body {
            margin: 0;
            height: 700px;
            font-family: Arial;
            background: linear-gradient(-45deg, #74ebd5, #9face6, #f6d365, #fda085);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
        }

        @keyframes gradientBG {
            0% {background-position:0% 50%;}
            50% {background-position:100% 50%;}
            100% {background-position:0% 50%;}
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 700px;
        }

        .card {
            width: 400px;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
        }

        .title {
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="center">

    <div class="w3-card-4 w3-white card">

        <h2 class="title">HOTEL RESERVATION</h2>
        <?php
        if($_SESSION['role']=="staff"){
        echo '<form action="staffCheck.php" method="post" >';
        echo '<button type="submit" name="StaffChecButton" class="w3-button w3-black btn">Check customer by room</button>';
        echo '</form>';
        }
        ?>

        <a href="roomList.php" class="w3-button w3-purple btn">Room List</a>

        <a href="checkAvailable.php" class="w3-button w3-blue btn">Search Available Room</a>

        <a href="reservationList.php" class="w3-button w3-green btn">Search Reservation</a>

        <a href="UpdateCustForm.php" class="w3-button w3-yellow btn">Update Information</a>

        <a href="registrationForm.php" class="w3-button w3-orange btn">Register as Guest</a>

        <hr>

        <form action="logout.php" method="POST">
            <button class="w3-button w3-red btn" type="submit">
                Logout
            </button>
        </form>

    </div>

</div>

</body>
</html>