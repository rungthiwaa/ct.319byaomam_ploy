<?php
// เชื่อมต่อกับฐานข้อมูล
include("api/db.php");

// ตรวจสอบว่ามีค่า ID ที่ถูกส่งมาผ่าน GET
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // คำสั่ง SQL สำหรับดึงข้อมูลสินค้าตาม ID
    $sql = "SELECT f_name, f_detail, f_img FROM product_foodd WHERE f_id = ?";
    
    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);

    // รันคำสั่ง SQL
    if ($stmt->execute()) {
        // ดึงข้อมูลจากคำสั่ง SQL
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $productData = $result->fetch_assoc();

            // ส่งข้อมูลในรูปแบบ JSON
            echo json_encode(array('success' => true, 'data' => $productData));
            exit;
        } else {
            // ถ้าไม่พบข้อมูลสินค้า
            echo json_encode(array('success' => false));
            exit;
        }
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt->close();
$conn->close();
?>
