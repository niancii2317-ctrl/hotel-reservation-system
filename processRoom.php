<?php

include "projectcon.php";
include "Room.php";
include "checklogin.php";

if(isSet($_POST['addRoomButton'])){
    header('Location: RoomInfoForm.php');
    exit();
}else if(isset($_POST['saveRoomButton'])){
    addNewRoom();
    header("Location: RoomList.php");
    exit();
}else if(isSet($_POST['deleteRoomButton'])){
    deleteRoom();
    echo "<script>";
    echo "alert('Room has been deleted.');
    </script>";
    header( "refresh:1; url=RoomList.php" );
}else if(isSet($_POST['updateRoomButton'])){
    updateRoomInformation();
    header( "refresh:1; url=RoomList.php" );
}
?>
