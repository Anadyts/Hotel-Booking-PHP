<?php
    session_start();
    require('../server.php');

    if(isset($_POST['logout'])){
        session_destroy();
        header('location: /Hotel/');
    }

    if(isset($_POST['delete'])){
        $roomNumber = $_POST['delete'];
        $sql = "DELETE FROM rooms WHERE room_number = $roomNumber";
        $result = $conn->query($sql);
        header('location: /Hotel/booking');
        exit();
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

    <div class="rooms">
        <?php
            require('../server.php');
            $sql = "SELECT * FROM rooms";
            $result = $conn->query($sql);

            while($row = mysqli_fetch_assoc($result)){
                echo "
                    <div class='wrap'>
                        <div class='card'>
                                <div class='pic'>
                                    <img src='../upload/{$row['img_src']}'>
                                </div>
                                <div class='detail'>
                                    <h2>{$row['room_type']}</h2>
                                    <h4>Price/Day: {$row['price']}</h4>
                                    <h4>Room Number: {$row['room_number']}</h4>
                                    <h4>Capacity: {$row['capacity']}</h4>
                                    <h4>Status: {$row['status']}</h4>
                                </div>
                                ";

                                if(isset($_SESSION['username'])){
                                    if($_SESSION['username'] === 'Admin'){
                                        echo "
                                            <div class='adminManager'>
                                                <form action='../edit/index.php' method='post'>
                                                    <button name='edit' value='{$row['room_number']}'>
                                                        <i class='bx bx-edit' ></i>
                                                    </button>
                                                </form>
                                                
                                                <form action='' method='post'>
                                                    <button name='delete' value='{$row['room_number']}'>
                                                        <i class='bx bxs-trash'></i>
                                                    </button>
                                                </form>
                                            </div>
                                        ";
                                    }else{
                                        echo 
                                        "
                                            <form action='../reserve/index.php' method='post'>
                                                <div class='customerManager'>
                                                    <button name='reserve' value='{$row['room_number']}'>Reserve</button>
                                                </div>
                                            </form>
                                        ";
                                    }
                                }
                    echo "
                        </div>
                    </div>
                    ";
            }
        ?>
    </div>
    

</body>
</html>

