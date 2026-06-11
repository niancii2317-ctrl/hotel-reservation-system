<?php
session_start();
include "projectcon.php";
?>
<?php
if(isset($_POST['login']))
{
    $user = $_POST['user'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM ADMIN WHERE AdminID='$user' AND Password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result); 
        $_SESSION['role'] = "admin";
        $_SESSION['user'] = $user;
        $_SESSION['AdminID'] = $row['AdminID'];
        header("Location: RoomList.php");
        exit();
    }
    
    $sql2 = "SELECT * FROM GUEST WHERE Username='$user' AND Password='$password'";

    $result2 = mysqli_query($conn,$sql2);

    if(mysqli_num_rows($result2) > 0)
    {
        $row = mysqli_fetch_assoc($result2); 
        $_SESSION['role'] = "guest";
        $_SESSION['user'] = $user;
        $_SESSION['GuestID'] = $row['GuestID'];
        header("Location: index.php");
        exit();
    }

    $sql3 = "SELECT * FROM hotel_staff WHERE StaffID='$user' AND Password='$password'";

    $result3 = mysqli_query($conn,$sql3);

    if(mysqli_num_rows($result3) > 0)
    {
        $row = mysqli_fetch_assoc($result3);

        $_SESSION['role'] = "staff";
        $_SESSION['user'] = $user;
        $_SESSION['StaffID'] = $row['StaffID'];
        header("Location: index.php");
        exit();
    }
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>

body{
    margin: 0;
    font-family: Arial;


    background-image: url("image/backg2.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    height: 700px;

    display: flex;
    justify-content: center;
    align-items: center;
}
h2{
    text-align: center;
    margin-bottom: 20px;
}

input{
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.card{
    position: relative;
    z-index: 2;

    width: 320px;
    padding: 25px;

    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}
button{
    width: 100%;
    padding: 10px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
}
button:hover{
    background: #218838;
}

.overlay{
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            top: 0;
            left: 0;
}

</style>
</head>
<body>
<div class="overlay"></div>

<div class="card">
    <h2>LOGIN</h2>
    <form method="POST">
        Username/ID(Admin/Staff): <input type="text" name="user" required><br>
        Password: <input type="password" name="password" required><br><br>
    <button type="submit" name="login">Login</button>
    </form>
</div>
</body>
</html>