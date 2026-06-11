<?php
include "projectcon.php";
include "checklogin.php";
?>
<!DOCTYPE html>
<html>
    <head><title>Room List</title>
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
      body{
        background-image: url("image/backg3.jpg");
        background-size: cover;
        background-repeat: no-repeat;
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
      input[name="addRoomButton"] {
        background: #28a745;
        color: white;
      }

      button[name="deleteRoomButton"] {
        background-color: #dc3545;
        color: white;
        order: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        border:none;
      }

      button[name="updateRoomButton"] {
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
          <a href="" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Room List</a>
          <a href="logout.php" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Log Out</a>
        </div>
      </nav>

      <span class="w3-button w3-top w3-white w3-xxlarge w3-text-grey w3-hover-text-black" style="width:auto;left:0;" onclick="openNav()">
        <i class="fa fa-bars"></i></span>

      <?php
      include "Room.php";
      echo '<dic class=show>';
      echo '<h1>List of Room</h1>';

      displaySearchOption();

      if(isSet($_POST['searchByRoomNo'])){
        $qry = searchByRoomNo();
      }else if(isSet($_POST['searchByRoomType'])){
        $qry = searchByRoomType();
      }else if(isSet($_POST['searchByRoomCapacity'])){
        $qry = searchByRoomCapacity();
      }else if(isSet($_POST['searchByRoomStatus'])){
        $qry =searchByRoomStatus();
      }else{
        $qry = getListOfRoom();
      }

      
      if($_SESSION['role']=="admin"){
        echo '<form action="processRoom.php" method="POST">';
        echo '<div class=btn>';
        echo '<br><input type="submit" name="addRoomButton" value="Add New Room">';
        echo '</form>';
        echo '</div>';
      }

      echo '<br><div class=a>';
      $roomList = getListOfRoom();

      echo "No of Room: " . mysqli_num_rows($roomList);
      echo '</div>';

      echo '<table border="1">';

      echo '<tr><td>No</td><td>Room No.</td><td>Room Type</td><td>Room Price(RM)</td><td>Room Capacity</td><td>Room Status</td>
      <td>Room Location</td><td>Room Wing</td><td>Room Floor</td>';

      if($_SESSION['role']=="admin"){
        echo "<td>Delete</td><td>Update</td></tr>";
      }
      
      if($_SESSION['role']=="guest"){
        echo "<td>Reservation</td></tr>";
      }

      $i=1;

      $count=1;

      while($row=mysqli_fetch_assoc($qry)){

      echo '<tr>';
      echo '<td>'.$i.'</td>';
      echo '<td>'.$row['RoomNo'].'</td>';
      echo '<td>'.$row['RoomType'].'</td>';
      echo '<td>'.$row['RoomPrice'].'</td>';
      echo '<td>'.$row['RoomCapacity'].'</td>';
      echo '<td>'.$row['RoomStatus'].'</td>';
      echo '<td>'.$row['RoomLocation'].'</td>';
      echo '<td>'.$row['RoomWing'].'</td>';
      echo '<td>'.$row['RoomFloor'].'</td>';
      $RoomNo = $row['RoomNo'];
      echo '<td>';

      if($_SESSION['role']=="guest"){
        echo '<form action="bookReservation.php" method="GET">';
        echo "<input type='hidden' value='$RoomNo' name='RoomNo'>";
        echo '<button type="submit">Book Now</button>';
        echo '</form>';
        echo '</td>';

      }

      if($_SESSION['role']=="admin"){
      echo '<form action="processRoom.php" method="post" >';
      echo "<input type='hidden' value='$RoomNo' name='RoomNoToDelete'>";
      echo '<button type="submit" name="deleteRoomButton"><i class="fa fa-trash"></i> Delete</button>';
      echo '</form>';
      echo '</td>';
      
      echo '<td>';
      echo '<form action="updateRoomForm.php" method="post" >';
      echo "<input type='hidden' value='$RoomNo' name='RoomNoToUpdate'>";
      echo '<button type="submit" name="updateRoomButton"><i class="fa fa-arrow-circle-up"></i> Update</button>';
      echo '</form>';
      echo '</td>';
      }

      echo '</tr>';

      $i++;
      }

      echo '</table>';
      echo '</div>';

      ?>
    </body>
</html>
<?php
function displaySearchOption(){

echo '<form action="" method="post">

<br>
<fieldset style ="width:70%; margin-left:225px;"><legend>Search Option</legend>

<table border=1>

<tr><td> No/Type/Capacity/Status: </td><td><input type=text name=searchValue><br></td></tr>

<td></td><td><input type=submit name = searchByRoomNo value="By RoomNo">

<input type=submit name = searchByRoomType value="By RoomType">

<input type=submit name = searchByRoomCapacity value="By RoomCapacity">

<input type=submit name = searchByRoomStatus value="By RoomStatus">

<input type=submit name = displayAll value="Display All"></td>

</table>

</fieldset>

</form>';

}

?>
