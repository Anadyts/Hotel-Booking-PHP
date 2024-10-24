<?php
    session_start();
    require('../server.php');

    if(!isset($_SESSION['username'])){
        header('location: /Hotel/');
    }

    if(isset($_POST['logout'])){
        session_destroy();
        header('location: /Hotel/');
    }

    if(isset($_POST['profile'])){
        header('location: /Hotel/profile');
    }
    if(isset($_POST['history'])){
        header('location: /Hotel/history');
    }

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>
<body>
    <nav>
        <i class='bx bxs-landmark'></i>
        <ul>
            <li><a href="/Hotel">Home</a></li>
            <li><a href="/Hotel/booking">Booking</a></li>
            <li><a href="/Hotel/register">Register</a></li>
            <li><a href="/Hotel/login">Login</a></li>
            <?php
                if(isset($_SESSION['username'])){
                    if($_SESSION['username'] === 'Admin'){
                        echo "<li><a href='/Hotel/dashboard'>Dashboard</a></li>";
                        echo "<li><a href='/Hotel/upload'>Upload</a></li>";
                    }
                }
            ?>
        </ul>
        
        <div class="userProfile">
            <?php
                if(isset($_SESSION['username'])){
                    echo '<h2>'.$_SESSION['username'].'<h2/>';
                    echo "<i class='bx bxs-user-circle' ></i>";
                    echo "<div class='dropdown'>
                            <form action='' method='post'>
                                <button name='profile'>Profile</button>
                                <button name='history'>History</button>
                                <button name='logout'>Logout</button>
                            </form>
                        </div>";
                }
            ?>
        </div>
    </nav>
    <div class="container">
        
    <?php
$sql = "SELECT * FROM user_db WHERE username = '{$_SESSION['username']}'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id = $row['id'];

$sql = "SELECT * FROM reserve ";
$result = $conn->query($sql);

// เช็คว่ามีการจองหรือไม่
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookingId = $row['booking_id'];
        $roomNumber = $row['room_number'];
        $checkIn = $row['check_in_date'];
        $checkOut = $row['check_out_date'];

        $sql = "SELECT * FROM rooms WHERE room_number = '$roomNumber'";
        $roomResult = $conn->query($sql);
        $roomRow = $roomResult->fetch_assoc();
        
        $roomType = $roomRow['room_type'];
        $price = $roomRow['price'];
        $capacity = $roomRow['capacity'];
        
        if(isset($_POST['delete'])){
            $sql = "DELETE FROM reserve WHERE booking_id = $bookingId";
            $result = $conn->query($sql);
            header('location: /Hotel/dashboard');
        }
        
        echo 
        "
        <div class='card'>
            <div class='title'>
                <h3>#{$bookingId}</h3>
                <h4>Room Number: {$roomNumber}</h4>
                <h4>Check-In Date: {$checkIn}</h4>
                <h4>Check-Out Date: {$checkOut}</h4>
                <h4>Room Type: {$roomType}</h4>
                <h4>Capacity: {$capacity}</h4>
                <h4>Price: {$price}</h4>
            </div>
            <div class='adminManager'>
                <form action='' method='post'>
                    <button name='delete' value='{$bookingId}'>
                        <i class='bx bxs-trash'></i>
                    </button>
                </form>
            </div>
        </div>
        ";
    }
}


?>

        
        
    </div>
</body>
</html>

