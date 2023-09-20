<?php
// require_once('./db.php');
include_once 'db.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $object = new stdClass();

        $stmt = $db->prepare('select * from product_foodd order by f_id desc');

        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {

                $object->Result = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    // $items = array(
                    //     "thisisname" => $f_name,
                    //     "thisisdetail" => $f_detail
                    // );
                    // array_push($object->Result, $items);
                    array_push($object->Result, $row);
                }
                $object->RespCode = 200;
                $object->RespMessage = 'success';
                http_response_code(200);
            } else {
                $object->RespCode = 400;
                $object->Log = 0;
                $object->RespMessage = 'bad : not found data';
                http_response_code(400);
            }
            echo json_encode($object);

        } else {
            $object->RespCode = 500;
            $object->Log = 1;
            $object->RespMessage = 'bad : sql';
            http_response_code(400);

        }
    } else {
        http_response_code(405);
    }
} catch (PDOException $se) {
    http_response_code(500);
    echo $se->getMessage();
}
?>