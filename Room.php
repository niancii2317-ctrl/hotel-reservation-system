<?php

function getListOfRoom(){

$con = mysqli_connect('localhost','root', '','project_db');

if (!$con) {
die("Connection failed: " . mysqli_connect_error());
}

$sql = "select * from room";

$qry=mysqli_query($con,$sql);

mysqli_close($con);

return $qry;
}

function addNewRoom(){

$RoomNo = $_POST['RoomNo'];

$RoomType = $_POST['RoomType'];

$RoomPrice = $_POST['RoomPrice'];

$RoomCapacity = $_POST['RoomCapacity'];

$RoomStatus = $_POST['RoomStatus'];

$RoomLocation = $_POST['RoomLocation'];

$RoomWing = $_POST['RoomWing'];

$RoomFloor = $_POST['RoomFloor'];

$AdminID = $_SESSION['user'];

$con = mysqli_connect('localhost','root','','project_db');

if (mysqli_connect_errno()){

echo "Failed to connect to MySQL: " . mysqli_connect_error();

}
$sql="INSERT INTO ROOM(RoomNo, RoomType, RoomPrice, RoomCapacity, RoomStatus,
RoomLocation,RoomWing, RoomFloor, AdminID)VALUES ('$RoomNo', '$RoomType', '$RoomPrice', '$RoomCapacity' ,'$RoomStatus',
'$RoomLocation', '$RoomWing','$RoomFloor','$AdminID')";

$qry = mysqli_query($con,$sql);

mysqli_close($con);

if(!$qry)

return false;

else

return true;
}

function deleteRoom()

{

$con = mysqli_connect('localhost','root','','project_db');

if(!$con){

die("Connection failed: " . mysqli_connect_error());

}

echo 'connected';

$RoomNoToDelete = $_POST['RoomNoToDelete'];

$sqlStr = "delete from room where RoomNo ='".$RoomNoToDelete."'";

$qry = mysqli_query($con,$sqlStr);

mysqli_close($con);

}

function searchByRoomNo()

{

$con = mysqli_connect('localhost','root','','project_db');

if(!$con){

die("Connection failed: " .

mysqli_connect_error());

}

$RoomNoToFind = $_POST['searchValue'];

$sqlStr = "select * from room where RoomNo ='$RoomNoToFind'";



$qry = mysqli_query($con,$sqlStr);

mysqli_close($con);

return $qry;

}

function searchByRoomType()

{

$con = mysqli_connect('localhost','root','','project_db');

if(!$con){
die("Connection failed: " .mysqli_connect_error());
}


$RoomTypeToFind = $_POST['searchValue'];

$sqlStr = "select * from room where RoomType ='$RoomTypeToFind'";

$qry = mysqli_query($con,$sqlStr);

mysqli_close($con);

return $qry;

}

function searchByRoomCapacity()

{

$con = mysqli_connect('localhost','root','','project_db');

if(!$con){
die("Connection failed: " .mysqli_connect_error());
}


$RoomCapacityToFind = $_POST['searchValue'];

$sqlStr = "select * from room where RoomCapacity ='$RoomCapacityToFind'";

$qry = mysqli_query($con,$sqlStr);

mysqli_close($con);

return $qry;

}

function searchByRoomStatus()

{

$con = mysqli_connect('localhost','root','','project_db');

if(!$con){
die("Connection failed: " .mysqli_connect_error());
}


$RoomStatusToFind = $_POST['searchValue'];

$sqlStr = "select * from room where RoomStatus ='$RoomStatusToFind'";

$qry = mysqli_query($con,$sqlStr);

mysqli_close($con);

return $qry;

}


function updateRoomInformation(){


$con = mysqli_connect('localhost','root','','project_db');

if(!$con)

{
echo mysqli_connect_error();

exit;
}

$RoomNo = $_POST['RoomNo'];

$RoomType = $_POST['RoomType'];

$RoomPrice = $_POST['RoomPrice'];

$RoomCapacity = $_POST['RoomCapacity'];

$RoomStatus = $_POST['RoomStatus'];

$RoomLocation = $_POST['RoomLocation'];

$RoomWing = $_POST['RoomWing'];

$RoomFloor = $_POST['RoomFloor'];



$sql = "update room SET RoomType = '$RoomType', RoomPrice = '$RoomPrice', RoomCapacity='$RoomCapacity', RoomStatus = '$RoomStatus',
 RoomLocation= '$RoomLocation', RoomWing='$RoomWing', RoomFloor='$RoomFloor' WHERE RoomNo ='$RoomNo' ";

echo $sql;

$qry = mysqli_query($con,$sql);

return $qry;

}

function getRoomInformation($RoomNo)
{
    $con = mysqli_connect('localhost','root','','project_db');

    $sql = "SELECT * FROM room
            WHERE RoomNo='$RoomNo'";

    $qry = mysqli_query($con,$sql);

    return $qry;
}

?>