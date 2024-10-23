<?php
    session_start();

    if(isset($_SESSION['username'])){
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
        </ul>
    </nav>

    <div class="wrap">
        <form action="" method="post">
            <i class='bx bxs-user-rectangle'></i>
            <div class="inputWrap">
                <input type="text" placeholder="Username" name="username" required> 
            </div>

            <div class="inputWrap">
                <input type="password" placeholder="Password" name="password" required> 
            </div>

            <div class="inputWrap">
                <input type="password" placeholder="Confirm Password" name="confirmPassword" required> 
            </div>

            <div class="buttonWrap">
                <button name="submit">Submit</button>
            </div>

            <div class="errorMessage">
                <?php
                    if(isset($_SESSION['error'])){
                        echo "<h3> {$_SESSION['error']}</h3>";
                        unset($_SESSION['error']);
                    }
                ?>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    
    require('../server.php');

    if(isset($_POST['submit'])){
        $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST,'confirmPassword',FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "SELECT * FROM user_db WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        if(isset($row['username'])){
            $_SESSION['error'] = 'This username is already used';
            header('location: /Hotel/register');

        }elseif($password !== $confirmPassword){
            $_SESSION['error'] = 'Password does not match';
            header('location: /Hotel/register');
            
        }elseif($password === $confirmPassword ){
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user_db(username, password) VALUES('$username', '$hashPassword')";
            $result = mysqli_query($conn, $sql);
            header('location: /Hotel/login');
        }
    }
    
?>