<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Room</title>
</head>
<body>
    <h1>Add Room Details</h1>
    <form action="" method="post" enctype="multipart/form-data">

        <label for="room_number">Room Number:</label>
        <input type="text" name="room_number" required><br>

        <label for="room_type">Room Type:</label>
        <input type="text" name="room_type" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" required step="0.01"><br>

        <label for="capacity">Capacity:</label>
        <input type="number" name="capacity" required><br>

        <label for="status">Status:</label>
        <input type="text" name="status" required><br>

        <label for="img">Image:</label>
        <input type="file" name="img" required><br>

        <input type="submit" name='submit' value="Add Room">
    </form>
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
            echo "The file " . htmlspecialchars(basename($_FILES["img"]["name"])) . " has been uploaded.";

            
            $img_src = $target_file;
            $sql = "INSERT INTO rooms (room_number, room_type, price, capacity, status, img_src)
            VALUES ('$room_number', '$room_type', '$price', '$capacity', '$status', '$img_src')";

            if ($conn->query($sql) === TRUE) {
                echo "New room added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, your file was not uploaded.";
    }
    $conn->close();
    }
?>
    



