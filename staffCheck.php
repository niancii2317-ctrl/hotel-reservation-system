<?php
include "projectcon.php";
include "checklogin.php";

if ($_SESSION['role'] != "staff") {
    header("Location: index.php");
    exit();
}
$selected_room = isset($_POST['RoomNo']) ? $_POST['RoomNo'] : '';
$customers = [];

if (!empty($selected_room)) {
    $selected_room = mysqli_real_escape_string($conn, $selected_room);
    
    $sql = "SELECT r.ReservationID, r.CheckInDate, r.CheckOutDate, r.ReservationStatus,
                   g.GuestName, g.PhoneNo, g.Email,g.`IC/PassportNo`
            FROM reservation r
            JOIN guest g ON r.GuestID = g.GuestID
            WHERE r.RoomNo = '$selected_room'
            ORDER BY r.CheckInDate DESC";
    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
$room_list = [];
$sql_rooms = "SELECT RoomNo, RoomType FROM room ORDER BY RoomNo";
$result_rooms = mysqli_query($conn, $sql_rooms);
if ($result_rooms) {
    $room_list = mysqli_fetch_all($result_rooms, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff - View Customer by Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 30px auto; padding: 20px; background: #f0f2f5; }
        .container { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        .form-group { margin-bottom: 20px; text-align: center; }
        select, button { padding: 10px; font-size: 16px; border-radius: 5px; }
        select { width: 200px; margin-right: 10px; }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .no-record { text-align: center; color: gray; padding: 30px; }
        .back-link {display:block; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h1><i class="fa fa-home"></i> Staff - View Customer by Room</h1>
    
    <form method="POST">
        <div class="form-group">
            <label>Select Room Number:</label>
            <select name="RoomNo" required>
                <option value="">-- Select Room --</option>
                <?php foreach ($room_list as $room): ?>
                    <option value="<?php echo $room['RoomNo']; ?>" <?php echo ($selected_room == $room['RoomNo']) ? 'selected' : ''; ?>>
                        <?php echo $room['RoomNo']; ?> - <?php echo $room['RoomType']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit"><i class="fa fa-search"></i> Search</button>
        </div>
    </form>
    
    <?php if (!empty($selected_room)): ?>
        <h3><i class="fa fa-hotel"></i> Room <?php echo $selected_room; ?> - Customer List</h3>
        <?php if (count($customers) > 0): ?>
            <table>
                <thead>
                    <tr><th>Reservation ID</th><th>Customer Name</th><th>Phone</th><th>Email</th><th>IC/PassportNo</th><th>Check In</th><th>Check Out</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['ReservationID']; ?> </td>
                            <td><?php echo htmlspecialchars($customer['GuestName']); ?> </td>
                            <td><?php echo $customer['PhoneNo']; ?> </td>
                            <td><?php echo $customer['Email']; ?> </td>
                            <td><?php echo $customer['IC/PassportNo']; ?> </td>
                            <td><?php echo $customer['CheckInDate']; ?> </td>
                            <td><?php echo $customer['CheckOutDate']; ?> </td>
                            <td class="status-<?php echo strtolower($customer['ReservationStatus']); ?>"><?php echo $customer['ReservationStatus']; ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-record">No booking record found for this room.</div>
        <?php endif; ?>
    <?php endif; ?>
    
    <div class="back-link">
        <a href="index.php">← Back to Home</a>
    </div>
</div>
</body>
</html>