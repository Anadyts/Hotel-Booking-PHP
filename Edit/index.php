<?php
    session_start();
    if(isset($_SESSION['username'])){
        if($_SESSION['username'] !== 'Admin'){
            header('location: /Hotel/');
        }
    }else{
        header('location: /Hotel/');
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

    <?php
        require('../server.php');
        if(isset($_POST['edit'])){
            $roomNumber = $_POST['edit'];
            $_SESSION['oldRoomNumber'] = $roomNumber;

            $sql = "SELECT * FROM rooms WHERE room_number = $roomNumber";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            echo 
            "
                <div class='wrap'>
                    <div class='wrapPic'>
                        <img src='../upload/{$row['img_src']}'>
                    </div>
                    <div class='wrapForm'>
                        <form action='' method='post'>
                            
                            <div class='inputWrap'>
                                <input type='text' name='room_number' placeholder='Room Number' value='{$row['room_number']}'required><br>
                            </div>
                            
                            <div class='inputWrap'>
                                <input type='text' name='room_type' placeholder='Room Type' value='{$row['room_type']}' required><br>
                            </div>
                            
                            <div class='inputWrap'>
                                <input type='number' name='price' placeholder='Price' value='{$row['price']}' required step='0.01'><br>
                            </div>
                            
                            <div class='inputWrap'>
                                <input type='number' name='capacity' placeholder='Capacity' value='{$row['capacity']}' required><br>
                            </div>

                            <div class='inputWrap'>
                                <input type='text' name='status' placeholder='Status' value='{$row['status']}' required><br>
                            </div>
                            
                            <div class='buttonWrap'>
                                <button name='submit'>Edit</button>
                            </div>

                        </form>
                    </div>
                </div>
            
            
            ";
        }
    ?>
</body>
</html>

<?php
    require('../server.php');
    
    if(isset($_POST['logout'])){
        session_destroy();
        header('location: /Hotel/');
    }

    if(isset($_POST['submit'])){
        $newRoom_number = $_POST['room_number'];
        $room_type = $_POST['room_type'];
        $price = $_POST['price'];
        $capacity = $_POST['capacity'];
        $status = $_POST['status'];


        
        $sql = "SELECT * FROM rooms WHERE room_number = '{$_SESSION['oldRoomNumber']}'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $room_id = $row['room_id'];

        $sql = "UPDATE rooms 
                SET room_number = '$newRoom_number', room_type = '$room_type',
                price = '$price', capacity = '$capacity' , status = '$status'
                WHERE room_id = '$room_id'";

        $result = $conn->query($sql);
        if($result){
            header('location: /Hotel/booking');
        }
    }
?>