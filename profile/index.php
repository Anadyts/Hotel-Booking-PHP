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
    <?php
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM user_db WHERE username = '$username'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        $id = $row['id'];
        $_SESSION['id'] = $id;

        $sql = "SELECT * FROM profile WHERE id = '$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            
            while($row = $result->fetch_assoc()){
                echo 
            "
            <div class='wrapForm'>
                <form action='' method='post'>
                    <h1>Profile</h1>
                    <div class='inputWrap'>
                        <input type='text' name='name' placeholder='Name' value = '{$row['name']}' disabled>
                    </div>
                    
                    <div class='inputWrapRad'>
                        <label>{$row['gender']}</label>
                        
                    </div>

                    <div class='inputWrap'>
                        <input type='tel' name='tel' placeholder='Telephone Number' value = '{$row['tel']}' disabled>
                    </div>

                    <div class='inputWrap'>
                        <input type='email' name='email' placeholder='Email' value = '{$row['email']}' disabled>
                    </div>

                    <div class='buttonWrap'>
                        <button name='edit'>Edit</button>
                    </div>
                </form>
            </div>
            
            ";
            }
        }else{
            echo 
            "
            <div class='wrapForm'>
                <form action='' method='post'>
                    <h1>Profile</h1>
                    <div class='inputWrap'>
                        <input type='text' name='name' placeholder='Name' required>
                    </div>
                    
                    <div class='inputWrapRad'>
                        <div class='rad'>
                            <input type='radio' name='gender' id='1' value='Male'> <label for='gender'>Male</label>
                        </div>
                        
                        <div class='rad'>
                            <input type='radio' name='gender' id='2' value='Female'> <label for='gender'>Female</label>
                        </div>
                        
                    </div>

                    <div class='inputWrap'>
                        <input type='tel' name='tel' placeholder='Telephone Number' required>
                    </div>

                    <div class='inputWrap'>
                        <input type='email' name='email' placeholder='Email' required>
                    </div>

                    <div class='buttonWrap'>
                        <button name='submit'>Save</button>
                    </div>
                </form>
            </div>
            
            ";
        }
    
    ?>

    
</body>
</html>

<?php
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];

        $sql = "INSERT INTO profile(id, name, gender, tel, email) VALUES('{$_SESSION['id']}', '$name', '$gender', '$tel', '$email')"; 
        $result = $conn->query($sql);
        header('location: /Hotel/profile');
        
    }

    if(isset($_POST['edit'])){
        header('location: /Hotel/editProfile');
    }

?>