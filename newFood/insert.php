<?php
include("api/db.php");
$namefood = $_POST["name_food"];
$typefood = $_POST["type_food"];
$detailfood = $_POST["detail_food"];
$imagefood = 'noimg.png';

// ตรวจสอบว่ามีการอัพโหลดไฟล์รูปภาพ
if(isset($_FILES["image_food"]) && $_FILES["image_food"]["error"] == 0) {
    $target_dir = "imgs/";
    $target_file = $target_dir . basename($_FILES["image_food"]["name"]);

    if(move_uploaded_file($_FILES["image_food"]["tmp_name"], $target_file)) {
        echo "Upload รูปภาพสำเร็จ<br>";

        // เตรียมคำสั่ง SQL สำหรับการ insert ข้อมูลรูปภาพลงในตาราง
        $sql = "INSERT INTO product_foodd (f_name, f_type, f_detail,f_img) 
                VALUES (?, ?, ?, ?)";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $namefood, $typefood, $detailfood, $_FILES["image_food"]["name"]);
            
            if ($stmt->execute()) {
                echo "เพิ่มข้อมูลสำเร็จ";

                header("Location: index.php");
            } else {
                echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . implode(" ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $e->getMessage();
        }
    } else {
        echo "เกิดข้อผิดพลาดในการอัพโหลดไฟล์";
    }
} else {
    echo "ไม่มีไฟล์รูปภาพที่อัพโหลดหรือเกิดข้อผิดพลาดในการอัพโหลด";
}

$db = null;


?>