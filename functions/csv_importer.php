<?php

set_time_limit(3500);

error_reporting(E_ALL);

include '../config/db.php';

$data = explode(',', $con->real_escape_string($_POST['data']));

$db_data = "SELECT * FROM brands";
$result = $con->query($db_data);

if ($result->num_rows == 0) {
    foreach ($data as $brand) {
        $sql = "INSERT INTO `brands` (`id`, `brand_name`) VALUES (NULL, '$brand');";
        if ($con->query($sql) === TRUE) {
            $msg = ['status' => 'success', 'msg' => 'Import successfully !!!'];
        } else {
            $msg = ['status' => 'error', 'msg' => $con->error];
        }
    }
    echo json_encode($msg);
} else {

    foreach ($data as $brand) {
        $sql = "INSERT IGNORE INTO brands (id, brand_name) VALUES (NULL, '$brand'), (NULL, '$brand');";
        $result = $con->query($sql);

        $msg = ['status' => 'success', 'msg' => 'Import successfully !!!'];
    }

    //  print 'as';
    // print_r($brands);
    echo json_encode($msg);
}
/* 
$sql = "INSERT INTO `brands` (`id`, `brand_name`) VALUES (NULL, '$brand');";
                if ($con->query($sql) === TRUE) {
                    $msg = ['status' => 'success', 'msg' => 'Import successfully !!!'];
                } else {
                    $msg = ['status' => 'error', 'msg' => $con->error];
                } */