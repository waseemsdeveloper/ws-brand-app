<?php
/*
* Company : Dropskit
* email : support@dropskit.com
*/
error_reporting(E_ALL);

include "../config/db.php";

$action = $con->real_escape_string($_POST['action']);
$data = $con->real_escape_string($_POST['data']);

$sql = "DELETE FROM brands WHERE id = $data";
$result = $con->query($sql);

if ($result == 1) {
    echo "Successfully deleted. . .";
}
