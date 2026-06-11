<?php
include "projectcon.php";
include "checklogin.php";

if ($_SESSION['role'] != "guest"){
    header("Location: index.php");
    exit();
}

function generateGuestId() {
    global $conn;
    $sql = "SELECT MAX(CAST(GuestID AS UNSIGNED)) AS max_id FROM guest";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nextId = $row['max_id'] + 1;
    return $nextId;
}

$registration_success = false;
$generated_guest_id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerButton'])) {
    $GuestID = generateGuestId();
    $GuestName = $_POST['GuestName'];
    $PhoneNo = $_POST['PhoneNo'];
    $Email = $_POST['Email'];
    $guestIc = $_POST['guestIc'];
    $userName = $_POST['userName'];
    $userPassword = $_POST['userPassword'];

    $checkSql = "SELECT * FROM guest WHERE Username = '$userName'";
    $checkResult = mysqli_query($conn, $checkSql);
    
    if (mysqli_num_rows($checkResult) > 0) {
        $error_message = "Username already exists! Please choose another.";
    } else {
        $sql = "INSERT INTO `guest` (`GuestName`, `PhoneNo`, `Email`, `IC/PassportNo`, `Username`, `Password`,`StaffID`)
                VALUES ('$GuestName', '$PhoneNo', '$Email', '$guestIc', '$userName', '$userPassword',9001)";
        
        $qry = mysqli_query($conn, $sql);
        
        if ($qry){
            $registration_success = true;
        }else{
            $error_message = "Registration failed: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Customer Registration - Hotel Reservation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <style>
            body, h1, h2, h3{
                font-family: "Montserrat", sans-serif;
                
            }
            body{
                background-color:darkseagreen;
            }
            .register-container{
                max-width: 500px;
                margin: 50px auto;
                padding: 30px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background-color: #F0FFF0;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            
            .register-container h2{
                text-align: center;
                color: #4CAF50;
                margin-bottom: 10px;
            }
            
            .register-container p{
                text-align: center;
                color: #666;
                margin-bottom: 30px;
            }
            
            .register-btn{
                background-color: #4CAF50;
                color: white;
                border: none;
                padding: 12px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                width: 100%;
            }
            
            .register-btn:hover{
                background-color: #45a049;
            }
            
            input[type="text"],
            input[type="email"],
            input[type="password"]{
                width: 100%;
                padding: 10px;
                margin: 8px 0 20px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            
            label {
                font-weight: bold;
                color: #333;
            }
            
            .required:after{
                content: " *";
                color: red;
            }
            
            .success-box{
                background-color: #d4edda;
                border: 1px solid #c3e6cb;
                color: #155724;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
                text-align: center;
            }
            
            .error-box{
                background-color: #f8d7da;
                border: 1px solid #f5c6cb;
                color: #721c24;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
                text-align: center;
            }
        </style>
    </head>
    
    <body>
        <div class="register-container">
            <h2><i class="fa fa-user-plus"></i> Customer Registration</h2>
            <p>Create your account to book facilities </p>
            
            <?php if ($registration_success): ?>
            <div class="success-box">
                <i class="fa fa-check-circle" style="font-size: 24px;"></i>
                <h3>Registration Successful!</h3>
                <a href="login.php" class="w3-button w3-green" style="margin-top: 10px;">Back to login page</a>
            </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
            <div class="error-box">
                <i class="fa fa-exclamation-triangle"></i>
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>
            
            <?php if (!$registration_success): ?>
            <form method="POST" action="">
                
                <label class="required">Full Name</label>
                <input type="text" name="GuestName" placeholder="Enter your full name" required>
                
                <label class="required">IC / Passport No</label>
                <input type="text" name="guestIc" placeholder="e.g., 001234-56-7890" required>
                
                <label class="required">Phone Number</label>
                <input type="text" name="PhoneNo" placeholder="e.g., 012-3456789" required>
                
                <label class="required">Email</label>
                <input type="email" name="Email" placeholder="your@email.com" required>
                
                <label class="required">Username</label>
                <input type="text" name="userName" placeholder="Choose a username" required>
                
                <label class="required">Password</label>
                <input type="password" name="userPassword" placeholder="Choose a password (min 4 characters)" required>
                
                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm your password" required>
                
                <button type="submit" name="registerButton" class="register-btn">
                    <i class="fa fa-check"></i> Register
                </button>
            </form>
            
            <?php endif; ?>
        </div>
    </body>
</html>