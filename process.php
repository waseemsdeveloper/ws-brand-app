<?php

/*
* developer : Waseem Sajjadh
* email : wsajjadh@gmail.com 
*/


include "config/db.php";

$sql = 'SELECT * FROM brands ORDER BY id DESC';
$results = mysqli_query($con, $sql);


//echo json_encode($brand);

if ($_GET['data'] = 'padu') {
	$data = array();

	while ($row = $results->fetch_row()) {
		$brand = ["id" => $row[0], "brand_name" => $row[1]];
		array_push($data, $brand);
	}

	echo json_encode($data);
}


/* close connection */
$con->close();
