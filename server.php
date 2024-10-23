<?php
    $conn = mysqli_connect('localhost', 'root', '', 'hotel');

    if(!$conn){
        die(mysqli_connect_error());
    }

?>