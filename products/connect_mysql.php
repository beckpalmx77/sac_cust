<?php

date_default_timezone_set("Asia/Bangkok");
$host = "192.168.88.7"; /* Host name */
$port = "3307"; /* Port */
$user = "myadmin"; /* User */
$password = "myadmin"; /* Password */
$dbname = "sac_cust"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname,$port);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}