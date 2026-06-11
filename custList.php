<?php
include "projectcon.php";
include "checklogin.php";

if ($_SESSION['role'] != "staff") {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM guest";
$result = mysqli_query($conn,$sql);
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
                text-align: center;
                border: 1px solid black;
            }
            td{
                background-color:white;
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
        </style>
    </head>
    
    <body class="w3-content" style="max-width:1200px">
        <!-- sidebar menu -->
        <nav class="w3-sidebar w3-bar-block w3-sand w3-collapse w3-top w3-animate-opacity" style="z-index:3;width:250px" id="mySidebar">
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

            <!-- !PAGE CONTENT! -->
             <div class="w3-main" style="margin-left:250px">
                <!-- Top header -->
                <header class="w3-container w3-xlarge">
                    <p class="w3-left">Show list of GUEST</p>
                    <p class="w3-right">
                    </p>
                </header>

                <div class="w3-display-container w3-container">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                    <table class="customer-table">
                        <thead style="background-color: AntiqueWhite;">
                            <tr><th>GuestID</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>IC/PassportNo</th>
                            <th>Username</th>
                            <th>Password</th></tr>
                        </thead>

                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <td><?php echo htmlspecialchars($row["GuestID"]); ?></td>
                                <td><?php echo htmlspecialchars($row["GuestName"]); ?></td>
                                <td><?php echo htmlspecialchars($row["PhoneNo"]); ?></td>
                                <td><?php echo htmlspecialchars($row["Email"]); ?></td>
                                <td><?php echo htmlspecialchars($row["IC/PassportNo"]); ?></td>
                                <td><?php echo htmlspecialchars($row["Username"]); ?></td>
                                <td><?php echo htmlspecialchars($row["Password"]); ?></td></tr>
                                <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="noData">
                        No customer data found. Please try add customer first. 
                    </div>
                    <?php endif; ?>

                    <hr>
                </div>
            </div>
    </body>
</html>

<?php mysqli_close($conn); ?>