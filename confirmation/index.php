<?php
    session_start();
    if(empty($_SESSION['username'])){
        header('location: /Hotel/');
    }

    if(isset($_POST['profile'])){
        header('location: /Hotel/profile');
    }
    if(isset($_POST['history'])){
        header('location: /Hotel/history');
    }

    require('../server.php');

    if(isset($_POST['logout'])){
        session_destroy();
        header('location: /Hotel/');
    }
    
    if(isset($_POST['reserve'])){
        $_SESSION['checkIn'] = $_POST['checkIn'];
        $_SESSION['checkOut'] = $_POST['checkOut'];
    }
    
    if(isset($_POST['confirm'])){
        $checkIn = $_SESSION['checkIn'];
        $checkOut = $_SESSION['checkOut'];
        $username = $_SESSION['username'];
        $room_number_reserve = $_SESSION['room_number_reserve'];

        $sql = "SELECT * FROM user_db WHERE username = '$username'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        $sql = "INSERT INTO reserve(room_number, check_in_date, check_out_date, user_id)
                VALUES('$room_number_reserve', '$checkIn', '$checkOut', '$user_id')
        ";
        $result = $conn->query($sql);
        if($result){
            $_SESSION['success'] = 'Success';
        }
    }

    if(isset($_POST['cancel'])){
        header('location: /Hotel/booking');
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

    <div class='wrapConfirm'>
        <?php
            if(isset($_POST['reserve'])){
                $sql = "SELECT * FROM rooms WHERE room_number = {$_SESSION['room_number_reserve']}";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                
                echo 
                "
                <form action='' method='post'>
                    <div class='mid'>
                        <div class='detail'>
                            <h2>{$row['room_type']}</h2>
                            <h4>Price/Day: {$row['price']}</h4>
                            <h4>Room Number: {$row['room_number']}</h4>
                            <h4>Capacity: {$row['capacity']}</h4>
                            <h4>Status: {$row['status']}</h4>
                        </div>
                    </div>
                    <div class='buttonWrap'>
                        <button name='cancel' class='cancel'>Cancel</button>
                        <button name='confirm' class='confirm'>Confirm</button>
                    </div>
                </form>
                
                ";
            }
        ?>
    </div>
</body>
</html>

