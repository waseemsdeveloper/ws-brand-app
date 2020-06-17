<?php

/*
* Company : Dropskit
* email : support@dropskit.com
*/

include "../config/db.php";

function csv_exporter($data)
{
    global $con;

    $array = explode(',', $data);
    $result_data = array();

    foreach ($array as $vl) {

        $sql = "SELECT * FROM brands where id = $vl";
        $result = $con->query($sql);

        while ($row = $result->fetch_row()) {
            /* $brand = ["id" => $row[0], "brand_name" => $row[1]];
            array_push($result_data, $brand); */
            array_push($result_data, $row[1]);
        }
    }

    echo implode(',', $result_data);
}

$action = $con->real_escape_string($_POST['action']);
$data = $con->real_escape_string($_POST['data']);

if ($action === 'exportToSelected') {
    csv_exporter($data);
} elseif ($action === 'exportToCurrent') {
    csv_exporter($data);
} elseif ($action === 'exportToAll') {

    $result_data = array();

    $sql = "SELECT * FROM brands";
    $result = $con->query($sql);

    while ($row = $result->fetch_row()) {
        /* $brand = ["id" => $row[0], "brand_name" => $row[1]];
            array_push($result_data, $brand);  */
        array_push($result_data, $row[1]);
    }


    echo implode(',', $result_data);
}
