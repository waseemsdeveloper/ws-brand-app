<?php

include "config/db.php";

$sql = 'SELECT * FROM brands';
$results = mysqli_query($con, $sql);

//echo json_encode($brand);
$keyword = strtolower($_GET['q']);

while ($row = $results->fetch_row()) {
    if ($keyword == strtolower($row[1])) {
        $msg = ['status' => 'error', 'msg' => 'Brand is already in the list.'];
        break;
    } else {
        $msg = ['status' => 'success', 'msg' => 'Brand is not in the list.'];
    }
}

echo json_encode($msg);
/* close connection */
$con->close();
