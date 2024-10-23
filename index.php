<?php
    session_start();
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

    <div class="wrapPic">
        <img src="hotel.jpeg" alt="" width="1895">
    </div>
    
    <div class="quote-container">
        <div class="quote" id="quote">Loading...</div>
    </div>

    <footer>
        <h2>Cozy Haven</h2>
        <div class="footer-container">
            
            
            <div class="footer-section">
                <h3>CONTACT</h3>
                <p>โทรศัพท์: 055-512345</p>
                <p>อีเมล: <a href="mailto:info@cozyhaven.com">info@cozyhaven.com</a></p>
                <p>เวลาเปิดทำการ: 24 ชั่วโมง</p>
            </div>

            <div class="footer-section">
                <h3>LOCATION</h3>
                <p>ที่อยู่: 123 ถนนสุขสันต์, เขตเมืองสบาย, ประเทศ</p>
                <p><a href="#">ดูแผนที่</a></p>
            </div>

            <div class="footer-section">
                <h3>TRANSPORTATION</h3>
                <p>รถแท็กซี่: สะดวกและรวดเร็ว</p>
                <p>รถบัส: สถานีใกล้ที่สุด นครชัยแอร์</p>
                <p>บริการรถรับส่ง: สอบถามเพิ่มเติมที่แผนกต้อนรับ</p>
            </div>

            <div class="footer-section">
                <h3>FOLLOW US</h3>
                <p><a href="#">Facebook</a></p>
                <p><a href="#">Instagram</a></p>
                <p><a href="#">Twitter</a></p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>Copyright © 2024 Cozy Haven. All rights reserved.</p>
            <p><a href="#">นโยบายความเป็นส่วนตัว</a> | <a href="#">ข้อกำหนดการใช้บริการ</a></p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>

<?php
    require('server.php');

    if(isset($_POST['logout'])){
        session_destroy();
        header('location: /Hotel/');
    }
?>