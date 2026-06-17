<?php

function getListOfReservation(){

$conn = mysqli_connect('localhost','root','','project_db');

if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM reservation";

$qry = mysqli_query($conn,$sql);

mysqli_close($conn);

return $qry;
}

function deleteReservation(){

$conn = mysqli_connect('localhost','root','','project_db');

$ReservationID = $_POST['ReservationIDToDelete'];

$sql = "DELETE FROM reservation WHERE ReservationID='$ReservationID'";

$qry = mysqli_query($conn,$sql);

mysqli_close($conn);

return $qry;
}

function updateReservationInformation(){

$conn = mysqli_connect('localhost','root','','project_db');

$ReservationID = $_POST['ReservationID'];

$CheckInDate = $_POST['CheckInDate'];
$CheckOutDate = $_POST['CheckOutDate'];
$ReservationStatus = $_POST['ReservationStatus'];

$sql = "UPDATE reservation SET
CheckInDate='$CheckInDate',
CheckOutDate='$CheckOutDate',
ReservationStatus='$ReservationStatus'
WHERE ReservationID='$ReservationID'";

$qry = mysqli_query($conn,$sql);

mysqli_close($conn);

return $qry;
}

function getReservationInformation($ReservationID)
{
    $conn = mysqli_connect('localhost','root','','project_db');

    $sql = "SELECT *
            FROM reservation
            WHERE ReservationID='$ReservationID'";

    $qry = mysqli_query($conn,$sql);

    return $qry;
}
?>