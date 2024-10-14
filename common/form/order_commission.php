<?php
require "../db.php";
require '../session.php';

$user_id = getId();

// ฟอร์มสำหรับสั่ง commission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $work_type = $conn->real_escape_string($_POST['work_type']);
    $reference_image = $conn->real_escape_string($_POST['reference_image']);
    $description = $conn->real_escape_string($_POST['description']);

    // สร้าง commission ใหม่
    $sql_create_commission = "INSERT INTO commissions (user_id, title, status, price) 
                              VALUES ($user_id, '$title', 'รอจ่ายเงิน', 0)";
    if ($conn->query($sql_create_commission) === TRUE) {
        $commission_id = $conn->insert_id;

        // ใส่รายละเอียด commission
        $sql_create_details = "INSERT INTO commission_details (commission_id, work_type, reference_image_url, description) 
                               VALUES ($commission_id, '$work_type', '$reference_image', '$description')";
        $conn->query($sql_create_details);

        echo "Commission has been ordered successfully!";
    } else {
        echo "Error: " . $sql_create_commission . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Commission</title>
</head>
<body>
<h1>Order Commission</h1>
<form method="POST" action="">
    <label for="title">Commission Title:</label>
    <input type="text" id="title" name="title" required><br>

    <label for="work_type">Work Type:</label>
    <input type="text" id="work_type" name="work_type" required><br>

    <label for="reference_image">Reference Image URL:</label>
    <input type="text" id="reference_image" name="reference_image"><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea><br>

    <button type="submit">Submit Commission</button>
</form>
</body>
</html>
