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
            if(isset($_POST['reserve'])){
                $reserveNumber = $_POST['reserve'];
                $sql = "SELECT * FROM rooms WHERE room_number = '$reserveNumber'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                
                $room_number = $row['room_number'];
                $room_type = $row['room_type'];
                $price = $row['price'];
                $capacity = $row['capacity'];
                $status = $row['status'];
                $img_src = $row['img_src'];

                $_SESSION['room_number_reserve'] = $room_number;
                
                

                echo 
                "
                <div class='mid'>
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
                            </div>
                    </div>
                </div>
                <div class='mid'>
                    <div class='reserveForm'>
                        <form action= '../confirmation/index.php' method='post'>
                            <div class='date'>
                                <input type='date' name='checkIn' id='checkIn'>
                            </div>
                            
                            <div class='date'>
                                <input type='date' name='checkOut' id='checkOut'>
                            </div>
                            
                            <div class='searchButton'>
                            <button name='reserve' id='reserveButton'>Reserve</button>
                            </div>
                        </form>
                    </div>
                </div>
                ";
            }

            $sql = "SELECT check_in_date, check_out_date FROM reserve WHERE room_number = '{$_SESSION['room_number_reserve']}'";
            $result = $conn->query($sql);
            $bookedDates = [];

            while($row = $result->fetch_assoc()) {
                $bookedDates[] = [
                    'check_in' => $row['check_in_date'],
                    'check_out' => $row['check_out_date']
                ];
            }
        ?>
    </div>
    <script src='script.js'></script>
</body>
</html>



<script>
const bookedDates = <?php echo json_encode($bookedDates); ?>;

function checkDates() {
    const checkInInput = document.getElementById('checkIn');
    const checkOutInput = document.getElementById('checkOut');
    const reserveButton = document.getElementById('reserveButton');
    
    const checkInDate = new Date(checkInInput.value);
    const checkOutDate = new Date(checkOutInput.value);

    // ฟังก์ชันสำหรับตรวจสอบวันจอง
    const isDateBooked = (date) => {
        return bookedDates.some(({ check_in, check_out }) => {
            const checkIn = new Date(check_in);
            const checkOut = new Date(check_out);
            return date >= checkIn && date <= checkOut;
        });
    };

    // ตรวจสอบวันที่เช็คอินและเช็คเอาท์
    if (checkInInput.value && checkOutInput.value) {
        // ตรวจสอบว่า checkOut อยู่ก่อน checkIn หรือไม่
        if (checkOutDate < checkInDate) {
            reserveButton.disabled = true; // ปิดปุ่มเมื่อวันที่ checkout ก่อน checkin
            return;
        }

        const allDatesBooked = [];
        for (let d = checkInDate; d <= checkOutDate; d.setDate(d.getDate() + 1)) {
            if (isDateBooked(new Date(d))) {
                allDatesBooked.push(true);
            } else {
                allDatesBooked.push(false);
            }
        }
        
        // ปิดการทำงานของปุ่มจองถ้ามีวันที่ถูกจองในช่วง
        reserveButton.disabled = allDatesBooked.includes(true);
    } else {
        reserveButton.disabled = true; // ปิดปุ่มเมื่อวันที่ยังไม่ได้เลือก
    }
}

// เพิ่ม event listener ให้กับ input
document.getElementById('checkIn').addEventListener('change', checkDates);
document.getElementById('checkOut').addEventListener('change', checkDates);

</script>
