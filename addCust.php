<?php
include "projectcon.php";
include "checklogin.php";

if ($_SESSION['role'] != "staff") {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $GuestID = $_POST["GuestID"];
    $GuestName = $_POST["GuestName"];
    $PhoneNo = $_POST["PhoneNo"];
    $Email = $_POST["Email"];
    $guestIc = $_POST["guestIc"];
    $userName = $_POST["userName"];
    $userPassword = $_POST["userPassword"];

$sql = "INSERT INTO guest(`GuestID`, `GuestName`, `PhoneNo`, `Email`, `IC/PassportNo`, `Username`, `Password`,`StaffID`)
        VALUES ('$GuestID', '$GuestName', '$PhoneNo', '$Email', '$guestIc', '$userName', '$userPassword',9001)";
$qry = mysqli_query($conn, $sql);
if ($qry){
    echo "<script> alert('Customer added successfully!');
                    window.location.href = 'custList.php';
                    </script>";
}else{
    echo "<script> alert('Customer added fail.');
                    window.location.href = 'custList.php';
                    </script>".mysqli_error($conn);
}
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Customer List</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            .sidebarA{font-family: "Roboto", sans-serif}
            body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif; background-color:#F5E6C8;}

            .customer-table th,td{
                padding: 12px 15px;
                text-align: left;
                border: 1px solid black;
            }
            .noData{
                text-align: center;
                padding: 40px;
                color: grey;
            }
            .btnContainer{
                margin-top: 20px;
                text-align: center;
            }
            .btn{
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                font-size: 14px;
                cursor: pointer;
            }
            .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            }
        </style>
    </head>
    
    <body class="w3-content" style="max-width:1200px">
        <nav class="w3-sidebar w3-bar-block w3-sand w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
            <div class="w3-container w3-display-container w3-padding-16">
                <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
                <h3 class="w3-wide"><b>HOTEL RESERVATION</b></h3>
            </div>

            <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
                <a href="custList.php" class="w3-bar-item w3-button">SHOW LIST OF GUEST</a>
                <a href="addCust.php" class="w3-bar-item w3-button">ADD FACILITY GUEST</a>
                <a href="delCust.php" class="w3-bar-item w3-button">DELETE GUEST</a>
                <a href="updateCust.php" class="w3-bar-item w3-button">UPDATE GUEST</a>
                <a href="search.php" class="w3-bar-item w3-button">SEARCH GUEST</a>
                <a href="index.php" class="w3-bar-item w3-button">HOME</a>
            </div>
        </nav>
             <div class="w3-main" style="margin-left:250px">
                <header class="w3-container w3-xlarge">
                    <p class="w3-left">Add facility Guest</p>
                    <p class="w3-right">
                    </p>

                    <p class="w3-container w3-xlarge">
                        <h2 class="w3-center" style="color: #4CAF50">Add Facility Customer</h2>
                            <form class="w3-container w3-section" style="margin: 40px; font-size: 15px" method="POST">
                                <label for="GuestID"><b>Guest ID</b></label>
                                <input type="text" name="GuestID" class="w3-input w3-border w3-round">

                                <label for="GuestName"><b>Name</b></label>
                                <input type="text" name="GuestName" class="w3-input w3-border w3-round" >

                                <label for="PhoneNo"><b>Phone Number</b></label>
                                <input type="text" name="PhoneNo" class="w3-input w3-border w3-round" required>

                                <label for="Email"><b>Email</b></label>
                                <input type="text" name="Email" class="w3-input w3-border w3-round" required>

                                <label for="guestIc"><b>IC/PassportNo</b></label>
                                <input type="text" name="guestIc" class="w3-input w3-border w3-round" required>

                                <label for="userName"><b>Username</b></label>
                                <input type="text" name="userName" class="w3-input w3-border w3-round" required>

                                <label for="userPassword"><b>Password</b></label>
                                <input type="text" name="userPassword" class="w3-input w3-border w3-round" required>

                                <br><br>

                                <button class="w3-button w3-block w3-round w3-hoverable" type="submit" style="background-color: #4CAF50;text-decoration: none"><i class="fa fa-plus-square"></i> ADD</button>
                            </form>
                    </p>
                </header>
            </div>
    </body>
</html>