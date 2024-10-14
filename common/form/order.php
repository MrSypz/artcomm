<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <style>
        /* จัดการพื้นหลังและการตั้งค่าสีหลัก */
        body {
            background-color: #f39c12; /* พื้นหลังสีส้ม */
            color: white; /* ข้อความสีขาว */
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* กรอบกล่องแสดงข้อมูล */
        .order-container {
            background-color: rgba(255, 255, 255, 0.1); /* สีพื้นหลังของกล่องแบบโปร่งใส */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* เงา */
            text-align: center;
        }

        /* สไตล์สำหรับข้อความ */
        h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        /* ปุ่มสั่ง Commission */
        button {
            background-color: #fff;
            color: #f39c12;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        button:hover {
            background-color: #e67e22;
            color: white;
        }

        /* ข้อความเมื่อเกินจำนวน */
        p {
            font-size: 1.2rem;
            font-style: italic;
        }

        /* ลิงก์ */
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="order-container">
    <?php
    // ส่วนของ PHP ที่จะแสดงข้อมูล (รวมจากโค้ดเดิม)
    require "../db.php";
    require '../session.php';

    $user_id = getId();
    // ดึงจำนวน commissions ของผู้ใช้
    $sql_commissions = "SELECT COUNT(*) AS total_commissions FROM commissions WHERE user_id = $user_id";
    $result_commissions = $conn->query($sql_commissions);
    $row_commissions = $result_commissions->fetch_assoc();

    // ดึงจำนวนคอมมิชชั่นที่ยังสั่งได้ (จำกัด 3 ต่อผู้ใช้)
    $max_commissions = 3;
    $available_commissions = $max_commissions - $row_commissions['total_commissions'];

    // แสดงข้อมูล n/m
    echo "<h3>Your Orders: " . $row_commissions['total_commissions'] . "/" . $max_commissions . "</h3>";

    // ปุ่มสั่ง commission
    if ($available_commissions > 0) {
        echo "<a href='order_commission.php'><button>Order Commission</button></a>";
    } else {
        echo "<p>You have reached the maximum number of commissions allowed.</p>";
    }

    $conn->close();
    ?>
</div>
</body>
</html>
