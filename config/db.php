<?php

/*
* Company : Dropskit
* email : support@dropskit.com
*/

/*
evertool_dskit_repricer
X[CNs8YKlSH!
evertool_brand_names
*/


$con = new mysqli("localhost", "root", "", "rruslanb_brand_app");

// Check connection
if ($con->connect_errno) {
    echo "Failed to connect to DataBase: " . $con->connect_error;
    exit();
}
