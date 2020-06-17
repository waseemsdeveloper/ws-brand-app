<?php

/*
* Company : Dropskit
* email : support@dropskit.com
*/

error_reporting(E_ALL);

include "../config/db.php";

$action = $con->real_escape_string($_POST['action']);
$data = $con->real_escape_string($_POST['data']);

if ($action == 'deleteSelected') {
    delete_brand($data);
} elseif ($action == 'deleteAll') {

    $sql = "DELETE FROM brands";
    $result = $con->query($sql);

    if ($result === TRUE) {
        $msg = ['status' => 'success', 'msg' => 'All brands successfully deleted. . .'];
    } else {
        $msg = ['status' => 'error', 'msg' => "Error in deleting brands"];
    }

    echo json_encode($msg);
}

function delete_brand($brands)
{
    global $con;

    $array = explode(',', $brands);

    if (empty($array) || empty($array[0])) {
        $msg = ['status' => 'error', 'msg' => "Please select at least 2 brands to delete."];
    } else {
        foreach ($array as $id) {
            $sql = "DELETE FROM brands WHERE id = $id";
            $result = $con->query($sql);

            if ($result === TRUE) {
                $msg = ['status' => 'success', 'msg' => 'Selected brands successfully deleted. . .'];
            } else {
                $msg = ['status' => 'error', 'msg' => "Error in deleting brands"];
            }
        }
    }

    echo json_encode($msg);
}

$con->close();
