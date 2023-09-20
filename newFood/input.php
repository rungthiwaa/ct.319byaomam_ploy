<?php

require_once('api/db.php');

?>
<!doctype html>
<html lang="th" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มข้อมูล</title>
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="input.css">
</head>
<style>
    a {
        text-decoration: none;
    }
</style>
<body class="d-flex flex-column h-100">
    <nav>
        <div class="nav-container">
            <a href="index.php">
                <h3 class="logonav" style="color : white">FOODTHAI</h3>
                <!-- <img src="./imgs/9516468.jpg" class="logonav"> -->
            </a>
        </div>
    </nav>

    <main class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5">เพิ่มข้อมูล</h1>
            <!-- <div class="mt-4">
                <a href="index.php" class="btn btn-warning">รายการข้อมูลอาหาร</a>
            </div> -->
            <!-- ฟอร์มเพิ่มข้อมูล -->
            <form action="insert.php" id="form_input" method="post" class="needs-validation"
                enctype="multipart/form-data" novalidate>
                <div class="row">
                    <div class="col-md-9">
                        <!-- ข้อมูลเนื้อหา -->
                        <div class="row mt-4">
                            <!-- แถวที่ 1 -->
                            <div class="col-md-4 mt-3">
                                <label for="name_food" class="form-label">ชื่ออาหาร <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="name_food" name="name_food" class="form-control" required>
                            </div>

                            <!-- แถวที่ 2 -->
                            <div class="col-md-4 mt-3">
                                <label for="c_prefix" class="form-label">ประเภทอาหาร <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="type_food" list="list_type" name="type_food" class="form-control"
                                    required>
                                <datalist id="list_type">
                                    <option value="อาหารกลาง">
                                    <option value="อาหารเหนือ">
                                    <option value="อาหารอีสาน">
                                    <option value="อาหารใต้">
                                </datalist>
                            </div>
                            <!-- แถวที่ 3 -->
                            <div class="col-md-12 mt-3">
                                <label for="detail_food" class="form-label">ข้อมูลรายละเอียด <span
                                        class="text-danger">*</span></label>
                                <textarea name="detail_food" id="detail_food" class="form-control" rows="8" required
                                    rows="40" cols="40"></textarea>
                            </div>

                        </div>
                    </div>
                    <duv class="col-md-3">
                        <!-- ข้อมูลรูปภาพ -->
                        <div class="row mt-4">
                            <div class="col-md-12 mt-3">
                                <label for="image_food" class="form-label">รูปภาพ</label>
                                <input class="form-control" id="image_food" name="image_food" type="file"
                                    onchange="loadFile(event)">
                            </div>
                            <div class="col-md-12 mt-3">
                                <img src="./imgs/noimg.png" class="img-thumbnail" id="image_food_preview" />
                            </div>
                        </div>
                    </duv>
                    <!-- ปุ่มบันทึก -->
                    <div class="col-md-12 mt-3">
                        <button type="submit" name="btn_insert" class="btn btn-success btn-lg" >บันทึก</button>
                        <button type="reset" class="btn btn-light btn-lg">ล้างค่า</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/script.js"></script>
    <script>
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('image_food_preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>