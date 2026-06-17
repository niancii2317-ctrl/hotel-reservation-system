<?php
include "projectcon.php";
include "checklogin.php";
?>
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
?>
<!DOCTYPE html>
<html>
    <head><title>Reservation List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <script>
      function openNav() {
        document.getElementById("mySidebar").style.width = "60%";
        document.getElementById("mySidebar").style.display = "block";
      }
      function closeNav() {
       document.getElementById("mySidebar").style.display = "none";
      }
    </script>
    <style>
      h1{
        font-family:"Merriweather", serif;
        text-align:center;
        margin-bottom: 20px;
        color: #333;
      }
      table{
        width: 90%;
        margin: auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
      }
      .btn{
        margin-left:700px;
      }
      .a{
        margin-left:715px;
      }
      input[type=submit] {
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
      button[type=submit] {
        background: #28a745;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
      button[name="deleteReservationButton"] {
        background-color: #dc3545;
        color: white;
        order: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        border:none;
      }

      button[name="updateReservationButton"] {
        background: #007bff;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
      }

      input[type=submit]:hover {
        opacity: 0.85;
      }
    </style>
    <body>
      <nav class="w3-sidebar w3-white w3-animate-left w3-xxlarge" style="display:none;padding-top:150px;left:0;z-index:2" id="mySidebar">
        <a href="javascript:void(0)" onclick="closeNav()" class="w3-button w3-white w3-xxxlarge w3-display-topright" style="padding:0 12px;">
          <i class="fa fa-remove"></i>
        </a>
        <div class="w3-bar-block w3-center">
          <a href="index.php" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Home</a>
          <a href="RoomList.php" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Room List</a>
          <a href="logout.php" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Log Out</a>
        </div>
      </nav>

      <span class="w3-button w3-top w3-white w3-xxlarge w3-text-grey w3-hover-text-black" style="width:auto;left:0;" onclick="openNav()">
        <i class="fa fa-bars"></i></span>

      <?php
      echo '<dic class=show>';
      echo '<h1>List of Reservation</h1>';

        if(isset($_POST['updateReservationButton'])){
            updateReservationInformation();
        }

        if(isset($_POST['deleteReservationButton'])){
            deleteReservation();
        }

      $qry= getListOfReservation();


      echo '<br><div class=a>';
      $reservationList = getListOfReservation();

      echo "No of Reservation: " . mysqli_num_rows($reservationList);
      echo '</div>';

      echo '<table border="1">';

      echo '<tr><td>No</td><td>Reservation ID</td><td>Guest ID</td><td>Room No</td><td>Staff ID</td>
      <td>Reservation Date</td><td>Check In</td><td>Check Out</td><td>Status</td><td>Delete</td><td>Update</td></tr>';
      
      $i=1;

      $count=1;

      while($row=mysqli_fetch_assoc($qry)){

      echo '<tr>';
      echo '<td>'.$i.'</td>';
      echo '<td>'.$row['ReservationID'].'</td>';
      echo '<td>'.$row['GuestID'].'</td>';
      echo '<td>'.$row['RoomNo'].'</td>';
      echo '<td>'.$row['StaffID'].'</td>';
      echo '<td>'.$row['ReservationDate'].'</td>';
      echo '<td>'.$row['CheckInDate'].'</td>';
      echo '<td>'.$row['CheckOutDate'].'</td>';
      echo '<td>'.$row['ReservationStatus'].'</td>';
      $ReservationID = $row['ReservationID'];

      echo '<td>';
      echo '<form method="post" >';
      echo "<input type='hidden' value='$ReservationID' name='ReservationIDToDelete'>";
      echo '<button type="submit" name="deleteReservationButton"><i class="fa fa-trash"></i> Delete</button>';
      echo '</form>';
      echo '</td>';
      
      echo '<td>';
      echo '<form action="updateReservation.php" method="post" >';
      echo "<input type='hidden' value='$ReservationID' name='ReservationIDToUpdate'>";
      echo '<button type="submit" name="updateReservationButton"><i class="fa fa-arrow-circle-up"></i> Update</button>';
      echo '</form>';
      echo '</td>';

      $i++;

      }

      echo '</tr>';


      echo '</table>';
      echo '</div>';

      ?>
    </body>
</html>
