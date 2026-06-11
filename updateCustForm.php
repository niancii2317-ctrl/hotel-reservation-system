<?php
include "projectcon.php";
include "checklogin.php";

if($_SESSION['role']=="guest"){
    $GuestID = $_SESSION['GuestID'];
}else{
    if (!isset($_POST['GuestID']) || empty($_POST['GuestID'])) {
        echo "<script>alert('No customer selected! Please go back to customer list.'); window.location.href='custList.php';</script>";
        exit();
    }
    $GuestID = $_POST['GuestID'];
}
if (empty($GuestID)) {
    echo "<script>alert('Invalid customer ID!'); window.location.href='custList.php';</script>";
    exit();
}

$sql = "SELECT * FROM guest WHERE GuestID = '$GuestID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Customer not found!'); window.location.href='custList.php';</script>";
    exit();
}

if (isset($_POST['updateCustomerButton'])) {
    $GuestID = $_POST['GuestID'];
    $GuestName = $_POST['GuestName'];
    $PhoneNo = $_POST['PhoneNo'];
    $Email = $_POST['Email'];
    $guestIc = $_POST['guestIc'];
    $userName = $_POST['userName'];
    $userPassword = $_POST['userPassword'];

   $sql = "UPDATE guest SET 
            `GuestName` = '$GuestName',
            `PhoneNo` = '$PhoneNo',
            `Email` = '$Email',
            `IC/PassportNo` = '$guestIc',
            `Username` = '$userName',
            `Password` = '$userPassword'
            WHERE `GuestID` = '$GuestID'";
    
    $qry = mysqli_query($conn, $sql);
    
    if ($qry) {
        echo "<script>";
        echo " alert('Customer updated successfully!');";
        echo " window.location.href = 'custList.php';";
        echo "</script>";
    } else {
        echo "<script>";
        echo " alert('Update failed: " . mysqli_error($conn) . "');";
        echo " window.location.href = 'custList.php';";
        echo "</script>";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Update Customer</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            .sidebarA{font-family: "Roboto", sans-serif}
            body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif; background-color: #F5E6C8;}

            .form-container {
                max-width: 500px;
                margin: auto;
                padding: 20px;
            }
            .update-btn {
                background-color: #4CAF50;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }
            .reset-btn {
                background-color: #f44336;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
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
                <a href="custList.php" class="w3-bar-item w3-button">SHOW LIST OF CUSTOMER</a>
                <a href="addCust.php" class="w3-bar-item w3-button">ADD CUSTOMER</a>
                <a href="delCust.php" class="w3-bar-item w3-button">DELETE CUSTOMER</a>
                <a href="updateCustForm.php" class="w3-bar-item w3-button">UPDATE CUSTOMER</a>
                <a href="search.php" class="w3-bar-item w3-button">SEARCH GUEST</a>
                <a href="index.php" class="w3-bar-item w3-button">HOME</a>
            </div>
        </nav>


        <div class="w3-main" style="margin-left:250px">
            <header class="w3-container w3-xlarge">
                <p class="w3-left">Update Customer</p>
                <p class="w3-right">
                </p>
            </header>

            <div class="w3-container w3-xlarge">
                <h2 class="w3-center" style="color: #4CAF50">Update Customer Information</h2>
                
                <form method="POST" action="" class="w3-container w3-section" style="margin: 40px; font-size: 15px">
                    <label for="GuestID"><b>Guest ID</b></label>
                    <input type="text" name="GuestID" class="w3-input w3-border w3-round" value="<?php echo $row['GuestID']; ?>" readonly>

                    <label for="GuestName"><b>Name</b></label>
                    <input type="text" name="GuestName" class="w3-input w3-border w3-round" value="<?php echo $row['GuestName']; ?>" required>

                    <label for="PhoneNo"><b>Phone Number</b></label>
                    <input type="text" name="PhoneNo" class="w3-input w3-border w3-round" value="<?php echo $row['PhoneNo']; ?>" required>

                    <label for="Email"><b>Email</b></label>
                    <input type="email" name="Email" class="w3-input w3-border w3-round" value="<?php echo $row['Email']; ?>" required>

                    <label for="guestIc"><b>IC/PassportNo</b></label>
                    <input type="text" name="guestIc" class="w3-input w3-border w3-round" value="<?php echo $row['IC/PassportNo']; ?>" required>

                    <label for="userName"><b>Username</b></label>
                    <input type="text" name="userName" class="w3-input w3-border w3-round" value="<?php echo $row['Username']; ?>" required>

                    <label for="userPassword"><b>Password</b></label>
                    <input type="text" name="userPassword" class="w3-input w3-border w3-round" value="<?php echo $row['Password']; ?>" required>

                    <br><br>

                    <button type="submit" name="updateCustomerButton" class="update-btn">
                        <i class="fa fa-save"></i> UPDATE
                    </button>
                    <button type="reset" class="reset-btn">
                        <i class="fa fa-undo"></i> RESET
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>

<?php mysqli_close($conn); ?>