<?php

include "projectcon.php";
include "checklogin.php";

if ($_SESSION['role'] != "guest") {
    header("Location: index.php");
    exit();
}
$RoomNo = isset($_GET['RoomNo']) ? $_GET['RoomNo'] : '';

$user = $_SESSION['user'];
$sql_get_guest = "SELECT GuestID FROM guest WHERE Username = '$user'";
$result_get_guest = mysqli_query($conn, $sql_get_guest);
if ($row = mysqli_fetch_assoc($result_get_guest)) {
    $GuestID = $row['GuestID'];
} else {
    die("Guest not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookButton'])) {
    $CheckInDate = $_POST['CheckInDate'];
    $CheckOutDate = $_POST['CheckOutDate'];
    $RoomNo = $_POST['RoomNo'];
    
    if ($CheckOutDate <= $CheckInDate) {
        $error = "Check out date must after check in date";
    } else {
        $sql_check = "SELECT * FROM reservation 
                      WHERE RoomNo = '$RoomNo' 
                      AND ReservationStatus != 'cancelled'
                      AND (CheckInDate <= '$CheckOutDate' AND CheckOutDate >= '$CheckInDate')";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = "This room already has reservation";
        } else {
            $ReservationDate = date('Y-m-d');
            $sql_book = "INSERT INTO reservation (GuestID, StaffID, RoomNo, CheckInDate, CheckOutDate, ReservationDate, ReservationStatus) 
                         VALUES ('$GuestID', 9001, '$RoomNo', '$CheckInDate', '$CheckOutDate', '$ReservationDate', 'confirmed')";
            
            if (mysqli_query($conn, $sql_book)) {
                $success = "booking success";
            } else {
                $error = "failed to booking: " . mysqli_error($con);
            }
        }
    }
}

$room_info = null;
if (!empty($RoomNo)) {
    $sql_room = "SELECT * FROM room WHERE RoomNo = '$RoomNo'";
    $result_room = mysqli_query($conn, $sql_room);
    $room_info = mysqli_fetch_assoc($result_room);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>RESERVATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial; max-width: 500px; margin: 40px auto; padding: 20px; background-color:#E0FFFF; }
        .container { background: white; padding: 25px; }
        h2 { margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, button { width: 100%; padding: 10px; border: 1px solid #ccc; }
        button { background: #28a745; color: white; border: none; cursor: pointer; font-size: 16px; }
        .success { background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; }
        .room-info { background: #e9ecef; padding: 10px; margin-bottom: 20px; }
    </style>
    <script>
        function validateDates() {
            let checkIn = document.getElementById('check_in').value;
            let checkOut = document.getElementById('check_out').value;
            if (checkIn && checkOut && checkOut <= checkIn) {
                alert('Check out date must after check in date');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Room Reservation</h2>
    
    <?php if (isset($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($room_info): ?>
        <div class="room-info">
            <strong>Room <?php echo $room_info['RoomNo']; ?> - <?php echo $room_info['RoomType']; ?></strong><br>
            Price: RM <?php echo $room_info['RoomPrice']; ?> / day<br>
            Capacity: <?php echo $room_info['RoomCapacity']; ?> person
        </div>
    <?php endif; ?>
    
    <form method="POST" onsubmit="return validateDates()">
        <input type="hidden" name="RoomNo" value="<?php echo $RoomNo; ?>">
        
        <div class="form-group">
            <label>Room Number:</label>
            <input type="text" value="<?php echo $RoomNo; ?>" readonly>
        </div>
        
        <div class="form-group">
            <label>Check in Date:</label>
            <input type="date" id="check_in" name="CheckInDate" required>
        </div>
        
        <div class="form-group">
            <label>Check out Date:</label>
            <input type="date" id="check_out" name="CheckOutDate" required>
        </div>
        
        <button type="submit" name="bookButton">Confirm booking</button>
    </form>
    
    <p style="margin-top: 20px;"><a href="roomlist.php">Return to room list</a></p>
</div>
</body>
</html>