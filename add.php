<?php

include "config/db.php";

$brands = "SELECT * FROM brands";
$results = $con->query($brands);

$data = $con->real_escape_string($_POST['data']);

$status = '';

while ($row = $results->fetch_row()) {
    if (strtolower($row[1]) == strtolower($data)) {
        $status = 'yes';
    }
}

if ($status === 'yes') {
    $msg = ['status' => 'error', 'msg' => 'Brand is already in the list!'];
    echo json_encode($msg);
} else {

    $sql = "INSERT INTO `brands` (`id`, `brand_name`) VALUES (NULL, '$data');";

    if ($con->query($sql) === TRUE) {
        $last_id = $con->insert_id;

        $msg = ['status' => 'success', 'msg' => 'New Brand Created successfully !!!', 'last_id' => $last_id];
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    echo json_encode($msg);
}


/* 
if ($status != 'yes') {
    print 'll';
       $sql = "INSERT INTO `brands` (`id`, `brand_name`) VALUES (NULL, '$data');";

    if ($con->query($sql) === TRUE) {
        echo "New Brand Created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    } 
} */

$con->close();
