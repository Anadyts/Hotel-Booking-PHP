<?php
    session_start();
    if(isset($_SESSION['username'])){
        if($_SESSION['username'] !== 'Admin'){
            header('location: /Hotel/');
        }
    }else{
        header('location: /Hotel/');
    }

    if(isset($_POST['profile'])){
        header('location: /Hotel/profile');
    }
    if(isset($_POST['history'])){
        header('location: /Hotel/history');
    }

    if(isset($_POST['logout'])){
        session_destroy();
        header('location: /Hotel/');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Room</title>
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
    <div class="wrapForm">
        <form action="" method="post" enctype="multipart/form-data">
            
            <div class="inputWrap">
                <input type="text" name="room_number" placeholder="Room Number"required><br>
            </div>
            
            <div class="inputWrap">
                <input type="text" name="room_type" placeholder="Room Type"required><br>
            </div>
            
            <div class="inputWrap">
                <input type="number" name="price" placeholder="Price"required step="0.01"><br>
            </div>
            
            <div class="inputWrap">
                <input type="number" name="capacity" placeholder="Capacity"required><br>
            </div>

            <div class="inputWrap">
                <input type="text" name="status" placeholder="Status"required><br>
            </div>
            
            <div class="inputFileWrap">
                <input type="file" class="custom-file-input" id="fileInput" name="img" required>
                <label class="custom-file-label" for="fileInput">Choose File</label>
            </div>
            
            <div class="buttonWrap">
                <button name="submit">Add Room</button>
            </div>

        </form>
    </div>
</body>
</html>

<?php

require('../server.php');


if(isset($_POST['submit'])){
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];
    $target_dir = "uploads/"; 
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["img"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }


    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }


    if ($_FILES["img"]["size"] > 50000000000) { 
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            

            
            $img_src = $target_file;
            $sql = "INSERT INTO rooms (room_number, room_type, price, capacity, status, img_src)
            VALUES ('$room_number', '$room_type', '$price', '$capacity', '$status', '$img_src')";

            if ($conn->query($sql) === TRUE) {
                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    $conn->close();
    }
?>
    



