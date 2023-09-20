<?php
include("api/db.php");

// ตรวจสอบว่ามีการกำหนด f_type ใน URL query string
if (isset($_GET['f_type'])) {
    $selected_f_type = $_GET['f_type'];
    // คำสั่ง SQL สำหรับดึงข้อมูลตาม f_type ที่ระบุ
    $sql = "SELECT * FROM product_foodd WHERE f_type = '$selected_f_type'";
} else {
    // ถ้าไม่ได้ระบุ f_type ใน URL query string ให้ดึงทั้งหมด
    $sql = "SELECT * FROM product_foodd WHERE 1"; // ใส่เงื่อนไข WHERE 1 เพื่อให้สามารถเพิ่มเงื่อนไขค้นหาในภายหลัง
}

// ตรวจสอบคำค้นหา
if (isset($_GET['txtKeyword']) && !empty($_GET['txtKeyword'])) {
    $txtKeyword = $_GET['txtKeyword'];
    // เพิ่มเงื่อนไขใน SQL query เพื่อค้นหา product ตามคำค้นหา
    $sql .= " AND f_name LIKE '%$txtKeyword%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodThai</title>

    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
    a {
        text-decoration: none;
    }
</style>

<body>
    <nav>
        <div class="nav-container">
            <a href="index.php">
                <h3 class="logonav" style="color : white">FOODTHAI</h3>
                <!-- <img src="./imgs/9516468.jpg" class="logonav"> -->
            </a>
            <div class="nav-search">
                <form action="index.php" method="get">
                    <input class="custom-input-search" type="text" id="search" name="txtKeyword" placeholder="ค้นหา...">
                </form>
            </div>

        </div>
    </nav>

    <!-- กล่อง2กล่อง -->
    <div class="container">
        <?php
        // คำสั่ง SQL สำหรับดึงข้อมูล f_type จาก product_foodd โดยใช้ DISTINCT
        $sql1 = "SELECT DISTINCT f_type FROM product_foodd";
        $result1 = $conn->query($sql1);

        ?>
        <div class="sidebar">
            <?php
            if ($result1->num_rows > 0) {
                while ($row1 = $result1->fetch_assoc()) {
                    $ftype = $row1['f_type'];
                    // สร้างลิงก์โดยใช้ค่า f_type จากฐานข้อมูล
                    echo "<a href='index.php?f_type=$ftype' class='sidebar-items'>$ftype</a>";
                }
            } else {
                echo "ไม่พบข้อมูลประเภทอาหาร";
            }
            ?><br>
            <a href="input.php" class="sidebar-items" class="button-input">
                เพิ่มข้อมูล
            </a>
            <a href="byMe.php" class="sidebar-items" class="button-input">
                รายชื่อผู้จัดทำ
            </a>
        </div>

        <div class="product">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="product-items" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-bs-id="<?= $row['f_id'] ?>">
                        <img class="product-img" src="imgs/<?= $row['f_img'] ?>" alt="">
                        <p style="font-size: 1.2vw; color: #51001c; ">
                            <?= $row['f_name'] ?>
                        </p>
                        <!-- <p style="font-size: .9vw;"><?= $row['f_detail'] ?></p> -->
                    </div>
                    <?php
                }
            } else {
                echo "ไม่พบรายการสินค้า";
            }
            ?>
        </div>

        <!-- Modal -->
        <?php
        // ตรวจสอบการคลิกที่ product-items และส่ง ID ไปยังหน้า PHP
        if (isset($_GET['id'])) {
            // รับ ID จากคลิกและสร้างคำสั่ง SQL เพื่อดึงข้อมูลตาม ID
            $productId = $_GET['id'];
            $sql = "SELECT f_name, f_detail, f_img FROM product_foodd WHERE f_id = $productId";

            // ทำการ query และรับข้อมูล
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // แสดงข้อมูลของสินค้าใน Modal
                $row = $result->fetch_assoc();
                $productName = $row['f_name'];
                $productDescription = $row['f_detail'];
                $productImage = $row['f_img'];
            }
        }
        ?>

        <!-- โค้ด HTML ส่วนของ Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTitle" style="color: #51001c"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img class="modaldesc-img" id="modalImage" src="" alt="">
                        </div>
                        <p style="font-size: 1vw; color: #8e113d;" id="modalProductDescription"></p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // เพิ่ม event listener เพื่อเปิด Modal และแสดงข้อมูลตามที่ถูกกด
            var productItems = document.querySelectorAll('.product-items');
            productItems.forEach(function (item) {
                item.addEventListener('click', function () {
                    var productId = this.getAttribute('data-bs-id');

                    // ส่งคำร้องขอ HTTP (AJAX) เพื่อดึงข้อมูลจากฐานข้อมูล
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'get_product_data.php?id=' + productId, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                var productData = response.data;

                                // ตั้งค่าข้อมูลใน Modal
                                document.getElementById('modalTitle').innerText = productData.f_name;
                                document.getElementById('modalProductDescription').innerText = productData.f_detail;
                                document.getElementById('modalImage').src = 'imgs/' + productData.f_img;

                                // เปิด Modal
                                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                                myModal.show();
                            } else {
                                alert('เกิดข้อผิดพลาดในการดึงข้อมูล');
                            }
                        }
                    };
                    xhr.send();
                });
            });
            // เพิ่ม event listener เพื่อปิด Modal เมื่อคลิกที่ปุ่มปิด
            var closeButton = document.querySelector('.btn-close');
            closeButton.addEventListener('click', function () {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.hide();
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"></script>


    </div>
    <!-- Back to top button -->
    <div class="button-top">
        <button type="button" class="btn btn-danger btn-floating " id="btn-back-to-top" style="float: right;">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
    <script>//Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }</script>

        

</body>

</html>