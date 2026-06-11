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
include "Room.php";
include "checklogin.php";
$RoomNo = $_POST['RoomNoToUpdate'];
$qry = getRoomInformation($RoomNo);
$row = mysqli_fetch_assoc($qry);
$RoomType = $row['RoomType'];
$RoomPrice = $row['RoomPrice'];
$RoomCapacity = $row['RoomCapacity'];
$RoomStatus = $row['RoomStatus'];
$RoomLocation = $row['RoomLocation'];
$RoomWing = $row['RoomWing'];
$RoomFloor = $row['RoomFloor'];


echo '<div class="overlay"></div>';
echo '<div class="card">';
echo '<h2>Update Room Information</h2>';
echo '<form action="processRoom.php" method="POST">';
echo 'Room No:'; 
echo "<input type='text' name='RoomNo' value='$RoomNo' readonly>"; 
echo '<br>RoomType:'; 
showSelectedRoomType($RoomType);
echo '<br>Room Price:'; 
echo "<input type='number' name='RoomPrice' value='$RoomPrice'>"; 
echo '<br>Room Capacity:'; 
echo "<input type='number' name='RoomCapacity' value='$RoomCapacity'>"; 
echo '<br>Room Status:'; 
echo "<input type='text' name='RoomStatus' value='$RoomStatus'>"; 
echo '<br>Room Location:'; 
echo "<input type='text' name='RoomLocation' value='$RoomLocation'>"; 
echo '<br>Room Wing:'; 
echo "<input type='text' name='RoomWing' value='$RoomWing'>"; 
echo '<br>Room Floor:'; 
echo "<input type='text' name='RoomFloor' value='$RoomFloor'>"; 
echo '<br><input type="submit" class="btn-save" name="updateRoomButton" value="Save"><br>'; 
echo '<input type ="reset" class="btn-reset" name="resetButton" value="reset">';  
echo '</form>'; 
echo '</div>'; 
?>
</html>
<?php 
function showSelectedRoomType($RoomType ){ 
    echo ' <select name = "RoomType">'; 
    if($RoomType == 'Deluxe') 
        echo "<option value='Deluxe' selected>Deluxe</option>"; 
    else 
        echo "<option value='Deluxe'>Deluxe</option>"; 
    if($RoomType == 'Standard') 
        echo "<option value='Standard' selected>Standard</option>"; 
    else 
        echo "<option value='Standard'>Standard</option>"; 
    if($RoomType =='Executive') 
        echo "<option value='Executive' selected>Executive</option>"; 
    else echo "<option value='Executive'>Executive</option>";  
    echo '</select>'; 
} 
?>