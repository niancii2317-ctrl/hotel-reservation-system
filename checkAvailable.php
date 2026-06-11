<?php

include "projectcon.php";
include "checklogin.php";

if ($_SESSION['role'] != "guest") {
    header("Location: index.php");
    exit();
}

$available_rooms = [];
$check_in = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';
$room_type = $_GET['room_type'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $check_in && $check_out) {
    $check_in = mysqli_real_escape_string($conn, $check_in);
    $check_out = mysqli_real_escape_string($conn, $check_out);
    $room_type = mysqli_real_escape_string($conn, $room_type);

    $sql = "SELECT * FROM room WHERE RoomNo NOT IN (
                SELECT RoomNo FROM reservation 
                WHERE ReservationStatus != 'cancelled'
                AND (CheckInDate <= '$check_out' AND CheckOutDate >= '$check_in')
            )";
    if (!empty($room_type)) $sql .= " AND RoomType = '$room_type'";
    
    $result = mysqli_query($conn, $sql);
    if ($result) $available_rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head><title>Check Available Room</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body{font-family:Arial;max-width:1200px;margin:30px auto;padding:20px;background-color:#f0f2f5;}
.search-form{background:white;padding:20px;margin-bottom:30px}
.form-group{display:inline-block;margin-right:20px}
label{display:block;font-weight:bold}
input,select{padding:8px;width:180px}
button{padding:8px 25px;background:#007bff;color:white;border:none;cursor:pointer}
.room-card{background:white;padding:15px;margin-bottom:15px;display:flex;justify-content:space-between;align-items:center}
.book-btn{background:#28a745;padding:10px 25px;color:white;text-decoration:none}
</style>
<script>
function validateDates(){
    let ci=document.getElementById('check_in').value;
    let co=document.getElementById('check_out').value;
    if(ci&&co&&co<=ci){alert('check out date must after check in date');return false;}
    return true;
}
</script>
</head>
<body>
<h1>Check available room <i class="fa fa-hotel"></i></h1>
<div class="search-form">
<form method="GET" onsubmit="return validateDates()">
<div class="form-group"><label>check in date:</label><input type="date" name="check_in" id="check_in" value="<?=htmlspecialchars($check_in)?>" 
required></div>
<div class="form-group"><label>check out date:</label><input type="date" name="check_out" id="check_out" value="<?=htmlspecialchars($check_out)?>" 
required></div>
<div class="form-group"><label>room type:</label>
<select name="room_type"><option value="">all</option>
<option value="Standard" <?=$room_type=='Standard'?'selected':''?>>Standard</option>
<option value="Deluxe" <?=$room_type=='Deluxe'?'selected':''?>>Deluxe</option>
<option value="Executive" <?=$room_type=='Executive'?'selected':''?>>Executive</option>
</select></div>
<button>find</button>
<a href="reservationList.php" style="display:inline-block;padding:8px 25px;background:#28a745;color:white;text-decoration:none;margin-left:10px">reservation list</a>
</form>
</div>
<?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && $check_in && $check_out): ?>
<h2>available room(<?=date('Y-m-d',strtotime($check_in))?> to <?=date('Y-m-d',strtotime($check_out))?>)</h2>
<?php if(count($available_rooms)>0): foreach($available_rooms as $room): ?>
<div class="room-card"><div><h3>room <?=htmlspecialchars($room['RoomNo'])?> - <?=htmlspecialchars($room['RoomType'])?></h3>
<p>price: RM <?=number_format($room['RoomPrice'],2)?> / day</p>
<p>room capacity: <?=$room['RoomCapacity']?> people</p>
<p>location: <?=htmlspecialchars($room['RoomLocation'])?> - <?=htmlspecialchars($room['RoomWing'])?> wing - <?=$room['RoomFloor']?> floor</p>
</div><a href="bookReservation.php?RoomNo=<?=$room['RoomNo']?>&check_in=<?=urlencode($check_in)?>&check_out=<?=urlencode($check_out)?>" class="book-btn">Book Now</a></div>
<?php endforeach; else: ?>
<p>No available rooms.</p>
<?php endif; endif; ?>
</body>
</html>