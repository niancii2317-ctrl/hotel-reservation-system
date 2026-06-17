<?php
include "projectcon.php";
include "checklogin.php";

$username = isset($_GET['username']) ? mysqli_real_escape_string($conn, $_GET['username']) : '';
$reservations = [];
$guest_info = null;

if (isset($_POST['cancel_reservation']) && isset($_POST['reservation_id'])) {
    $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
    
    $delete_sql = "DELETE FROM reservation WHERE ReservationID = '$reservation_id'";
    if (mysqli_query($conn, $delete_sql)) {
        $cancel_message = "reservation #$reservation_id successfully cancelled!";
        $cancel_type = "success";
    } else {
        $cancel_message = "Failed to cancel reservation, please try again.";
        $cancel_type = "error";
    }
}

if (!empty($username)) {
    $sql_guest = "SELECT GuestID, GuestName FROM guest WHERE Username = '$username'";
    $result_guest = mysqli_query($conn, $sql_guest);
    if ($result_guest && mysqli_num_rows($result_guest) > 0) {
        $guest_info = mysqli_fetch_assoc($result_guest);
        $guest_id = $guest_info['GuestID'];
        $sql_res = "SELECT r.ReservationID, r.RoomNo, rm.RoomType, rm.RoomPrice as RoomPrice, 
                           r.CheckInDate, r.CheckOutDate, r.ReservationStatus,
                           DATEDIFF(r.CheckOutDate, r.CheckInDate) as Nights
                    FROM reservation r
                    JOIN room rm ON r.RoomNo = rm.RoomNo
                    WHERE r.GuestID = $guest_id
                    ORDER BY r.CheckInDate DESC";
        $result_res = mysqli_query($conn, $sql_res);
        if ($result_res) {
            $reservations = mysqli_fetch_all($result_res, MYSQLI_ASSOC);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservation Record</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body { font-family: Arial; background-color: #f0f2f5; }
        .container { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; color: #000000; text-align: center; }
        .search-box { margin-bottom: 25px; text-align: center; }
        input[type="text"] { padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .status-confirmed { color: green; font-weight: bold; }
        .status-cancelled { color: red; font-weight: bold; }
        .no-record { text-align: center; color: gray; padding: 30px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .btn-cancel {
            padding: 5px 15px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-cancel:hover {
            background: #c82333;
        }
        .cancel-message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }
        .cancel-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .cancel-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><i class="fa fa-file-text-o" ></i> Search record</h1>
    
    <?php if (isset($cancel_message)): ?>
        <div class="cancel-message <?php echo ($cancel_type == 'success') ? 'cancel-success' : 'cancel-error'; ?>">
            <?php echo $cancel_message; ?>
        </div>
    <?php endif; ?>
    
    <div class="search-box">
        <form method="GET">
            <label>Enter your username to check your record:</label><br><br>
            <input type="text" name="username" placeholder="Enter your username" value="<?php echo htmlspecialchars($username); ?>">
            <button type="submit"><i class="fa fa-search"></i> search</button>
        </form>
    </div>
    
    <?php if (!empty($username) && !$guest_info): ?>
        <div class="no-record"><i class="fa fa-remove"></i> cannot find your record</div>
    <?php elseif ($guest_info): ?>
        
        <?php if (count($reservations) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order number</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Check In Date</th>
                        <th>Check Out Date</th>
                        <th>Day</th>
                        <th>Price (RM)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $res): 
                        $nights = $res['Nights'];
                        $total = $nights * $res['RoomPrice'];
                    ?>
                    <tr>
                        <td><?php echo $res['ReservationID']; ?></td>
                        <td><?php echo $res['RoomNo']; ?></td>
                        <td><?php echo htmlspecialchars($res['RoomType']); ?></td>
                        <td><?php echo $res['CheckInDate']; ?></td>
                        <td><?php echo $res['CheckOutDate']; ?></td>
                        <td><?php echo $nights; ?></td>
                        <td><?php echo $res['RoomPrice']; ?></td>
                        <td class="status-<?php echo strtolower($res['ReservationStatus']); ?>"><?php echo $res['ReservationStatus']; ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel reservation #<?php echo $res['ReservationID']; ?>?');">
                                <input type="hidden" name="reservation_id" value="<?php echo $res['ReservationID']; ?>">
                                <button type="submit" name="cancel_reservation" class="btn-cancel"><i class="fa fa-times"></i> Cancel</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-record">no record</div>
        <?php endif; ?>
    <?php endif; ?>
    <p style="text-align: center; margin-top: 20px;"><a href="checkAvailable.php"><i class="fa fa-home"></i> return to check available room</p >
</div>
</body>
</html>