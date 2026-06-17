<!DOCTYPE html>
<html>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body{
            margin-top:150px;
            background-color:#e6fff2;
            font-family:"Roboto";
            margin:0;
            background-color:#AFEEEE;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        #set{
            margin:auto;
            width:50%;
            text-align:center;
        }

        .overlay{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.45);
        }

        .card{
            position:relative;
            z-index:2;

            width:550px;
            padding:30px;

            background:white;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
        }

        h2{
            text-align:center;
            margin-bottom:25px;
            color:#2e7d32;
        }

        input,select{
            width:100%;
            padding:10px;
            border:1px solid #ccc;
            border-radius:6px;
            box-sizing:border-box;
        }

        .btn-save{
            width:100%;
            padding:12px;
            background:#28a745;
            color:white;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-size:16px;
        }

        .btn-save:hover{
            background:#218838;
        }

        .btn-reset{
            width:100%;
            padding:12px;
            margin-top:10px;
            background:#dc3545;
            color:white;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-size:16px;
        }

        .btn-reset:hover{
            background:#c82333;
        }
    </style>
<?php
include "Reservationfunc.php";
include "checklogin.php";

$ReservationID = $_POST['ReservationIDToUpdate'];

$qry = getReservationInformation($ReservationID);

$row = mysqli_fetch_assoc($qry);

$GuestID = $row['GuestID'];
$RoomNo = $row['RoomNo'];
$StaffID = $row['StaffID'];
$CheckInDate = $row['CheckInDate'];
$CheckOutDate = $row['CheckOutDate'];
$ReservationStatus = $row['ReservationStatus'];
?>
<?php

echo '<div class="overlay"></div>';
echo '<div class="card">';

echo '<h2>Update Reservation Information</h2>';

echo '<form action="Reservation.php" method="POST">';

echo 'Reservation ID:';
echo "<input type='text' name='ReservationID' value='$ReservationID' readonly>";

echo '<br>Guest ID:';
echo "<input type='text' value='$GuestID' readonly>";

echo '<br>Room No:';
echo "<input type='text' value='$RoomNo' readonly>";

echo '<br>Staff ID:';
echo "<input type='text' value='$StaffID' readonly>";

echo '<br>Check In Date:';
echo "<input type='date' name='CheckInDate' value='$CheckInDate'>";

echo '<br>Check Out Date:';
echo "<input type='date' name='CheckOutDate' value='$CheckOutDate'>";

echo '<br>Status:';

showSelectedReservationStatus($ReservationStatus);

echo '<br><br><input type="submit" class="btn-save"
name="updateReservationButton"
value="Save">';

echo '<br>';

echo '<input type="reset"
class="btn-reset"
value="Reset">';

echo '</form>';

echo '</div>';

?>
</html>
<?php

function showSelectedReservationStatus($ReservationStatus)
{
    echo '<select name="ReservationStatus">';

    if($ReservationStatus=="Pending")
        echo "<option value='Pending' selected>Pending</option>";
    else
        echo "<option value='Pending'>Pending</option>";

    if($ReservationStatus=="Confirmed")
        echo "<option value='Confirmed' selected>Confirmed</option>";
    else
        echo "<option value='Confirmed'>Confirmed</option>";

    echo '</select>';
}

?>