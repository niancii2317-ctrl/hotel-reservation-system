<?php
include "projectcon.php";
include "checklogin.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body{
            background-color:#E6FFF2;
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
    </head>
    <body>
        <h2 style="text-align: center"> Room Information Form </h2>
        <form class="w3-container" name="RoomInfoForm" action="processRoom.php" onsubmit="return ValidationForm()" method="POST" class="w3docs">

        <div>
            <label for="RoomNo">Room No:</label>
            <input class="w3-input" type="text" id="RoomNo" size="30" name="RoomNo">
        </div>

        <div>
            <label for="RoomType">Room Type:</label>
            <select class="w3-select" type="text" value="" id="RoomType" name="RoomType">
            <option></option>
            <option value="Deluxe">Deluxe</option>
            <option value="Standard">Standard</option>
            <option value="Executive">Executive</option>
            </select>
        </div>

        <div>
            <label for="RoomPrice">Room Price(RM):</label>
            <input class="w3-input" type="number" id="price" step="0.01" name="RoomPrice">
        </div>

        <div>
            <label for="RoomCapacity">Room Capacity:</label>
            <input class="w3-input" type="number" id="RoomCapacity" size="30" name="RoomCapacity">
        </div>

        <div>
            <label for="RoomStatus">Room Status:</label>
            <input class="w3-input" type="text" id="RoomStatus" size="30" name="RoomStatus">
        </div>

        <div>
            <label>Room Location:</label>
            <input class="w3-input" type="text" value="" name="RoomLocation">
        </div>

        <div>
            <label>Room Wing:</label>
            <input class="w3-input" type="text" value="" name="RoomWing">
        </div>

        <div>
            <label>Room Floor:</label>
            <input class="w3-input" type="number" value="" name="RoomFloor">
        </div>


        <br>
        <div class="buttons">
            <input type="submit" class="btn-save" value="Save" name="saveRoomButton">
            <input type="reset" class="btn-reset" value="Reset" name="Reset">
        </div>
        </form>

    </body>
    <script>
    function ValidationForm(){
    var RoomNo = document.forms["RoomInfoForm"]["RoomNo"];
    var RoomType = document.forms["RoomInfoForm"]["RoomType"];

    if(RoomNo.value == ""){
    alert("Please enter Room No.");
    RoomNo.focus();
    return false;
    }

    if(RoomType.value == ""){
    alert("Please enter a valid room type.");
    RoomType.focus();
    return false;
    }

    return true;
    }
    </script>
</html>
