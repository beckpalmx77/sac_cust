<?php
session_start();
error_reporting(0);
include '../config/connect_db_sac.php';

// Number of records fetch
$numberofrecords = 500000;


$search = $_POST['searchTerm'];// Search text

// Fetch records
$sql_search = "SELECT * FROM ims_product_price_cost WHERE AR_CODE LIKE '%'" . " AND AR_NAME like :AR_NAME GROUP BY AR_CODE,AR_NAME LIMIT :limit";

/*
$myfile = fopen("search-qry-condition.txt", "w") or die("Unable to open file!");
fwrite($myfile, $sql_search);
fclose($myfile);
*/

$stmt = $conn_sac->prepare($sql_search);
$stmt->bindValue(':AR_NAME', '%'.$search.'%', PDO::PARAM_STR);
$stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
$stmt->execute();
$custsList = $stmt->fetchAll();

$response = array();

// Read Data
foreach($custsList as $cust){
    $response[] = array(
        "id" => $cust['AR_CODE'],
        "text" => $cust['AR_NAME'] . " [" . $cust['AR_CODE'] . "]"
    );
}

echo json_encode($response);
exit();
