<?php
include "projectcon.php";
include "checklogin.php";

if ($_SESSION['role'] != "staff") {
    header("Location: index.php");
    exit();
}
if(isset($_POST['searchByGuestID'])){
    $searchValue = $_POST['searchValue'];
    $sql = "SELECT * FROM guest WHERE GuestID = '$searchValue'";
}elseif (isset($_POST['searchByName'])){
    $searchValue = $_POST['searchValue'];
    $sql = "SELECT * FROM guest WHERE GuestName LIKE '%$searchValue%'";
}elseif(isset($_POST['searchByPhoneNo'])){
    $searchValue = $_POST['searchValue'];
    $sql = "SELECT * FROM guest WHERE PhoneNo LIKE '%$searchValue%'";
}elseif(isset($_POST['searchByIC'])){
    $searchValue = $_POST['searchValue'];
    $sql = "SELECT * FROM guest WHERE `IC/PassportNo` LIKE '$searchValue%'";
}else{
    $sql = "SELECT * FROM guest";
}

$result = mysqli_query($conn, $sql);
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
            body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif; background-color: #F5E6C8;}

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
            .search-box { 
                border: 1px solid #ddd; 
                padding: 20px; 
                width: 110%; 
                margin-bottom: 20px;
                background-color: #f9f9f9;
            }
            table { 
                border-collapse: collapse; 
                width: 100%; 
            }
            th, td { 
                background-color:white;
                border: 1px solid #ddd; 
                padding: 10px; 
                text-align: left; 
            }
            th { 
                background-color: #4CAF50; 
                color: white; 
            }
            input[type="text"] {
                padding: 8px;
                width: 200px;
                margin-right: 10px;
            }
            input[type="submit"] {
                padding: 8px 15px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
                margin: 5px;
            }
            input[type="submit"]:hover {
                background-color: #45a049;
            }
            .noData {
                text-align: center;
                padding: 40px;
                color: grey;
            }
        </style>
    </head>
    
    <body class="w3-content" style="max-width:1200px">

        <nav class="w3-sidebar w3-bar-block w3-sand w3-collapse w3-top" style="z-index:3;width:250px;" id="mySidebar">
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
                    <p class="w3-left">Search Guest</p>
                    <p class="w3-right">
                    </p>
                </header>

                <div class="w3-display-container w3-container">
                    <div class="search-box">
                        <fieldset>
                            <legend><b>Search option</b></legend>
                            <form action="" method="POST">
                                <table>
                                    <tr><td>Search Value: </td><td><input type="text" name="searchValue" placeholder="Enter keyword..."></td></tr>
                                    <tr><td>Search By: 
                                            <input type="submit" name="searchByGuestID" value="Guest ID">
                                            <input type="submit" name="searchByName" value="Name">
                                            <input type="submit" name="searchByPhoneNo" value="Phone">
                                            <input type="submit" name="searchByIC" value="IC/PassportNo">
                                            <input type="submit" name="displayAll" value="Display All">
                                        </tr></td>
                                </table>
                            </form>
                        </fieldset>
                    </div>
                    
                    <h1>Guest List</h1>
                    <p>Total customer found: <?php echo mysqli_num_rows($result); ?></p>

                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Guest ID</th>
                                    <th>Name</th>
                                    <th>IC/PassportNo</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)): 
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($row['GuestID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['GuestName']); ?></td>
                                    <td><?php echo htmlspecialchars($row['PhoneNo']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['IC/PassportNo']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Username']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="noData">
                            No customer data found. 
                        </div>
                        <?php endif; ?>
                </div>
    </body>
</html>
<?php mysqli_close($conn); ?>