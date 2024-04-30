<?php
include('../config/connect_db_sac.php');

date_default_timezone_set('Asia/Bangkok');

$where_date = "";
$AR_CODE = $_POST["AR_CODE"];

$doc_date_start = substr($_POST['doc_date_start'], 6, 4) . "-" . substr($_POST['doc_date_start'], 3, 2) . "-" . substr($_POST['doc_date_start'], 0, 2);
$doc_date_to = substr($_POST['doc_date_to'], 6, 4) . "-" . substr($_POST['doc_date_to'], 3, 2) . "-" . substr($_POST['doc_date_to'], 0, 2);

if ($doc_date_start !== "" && $doc_date_to !== "") {
    $where_date = " AND STR_TO_DATE(DI_DATE, '%d/%m/%Y') BETWEEN '" . $doc_date_start . "' AND '" . $doc_date_to . "'";
}

if ($AR_CODE=="-") {
    $AR_CODE = "ALL";
    $customer_name = "ALL";
} else {
    $where_ar_code = " AND AR_CODE = '" . $AR_CODE . "'";
    $sql_customer_name = " SELECT AR_NAME FROM ims_customer_arcode where AR_CODE = '" . $AR_CODE . "'";
    $stmt_customer_name = $conn_sac->prepare($sql_customer_name);
    $stmt_customer_name->execute();
    $row_customer = $stmt_customer_name->fetchAll();
    foreach ($row_customer as $row_customers) {
        $customer_name = $row_customers["AR_NAME"];
    }
}

$String_Sql = " SELECT * FROM ims_product_price_cost WHERE 1 " . $where_date  . $where_ar_code;

//$my_file = fopen("Sale_D-CP.txt", "w") or die("Unable to open file!");
//fwrite($my_file, $branch . "-" .$month . "-" .$year . " myCheck  = " . $myCheck);
//fclose($my_file);


$filename = "Customer-" . $AR_CODE . "-" . date('m/d/Y H:i:s', time()) . ".csv";

@header('Content-type: text/csv; charset=UTF-8');
@header('Content-Encoding: UTF-8');
@header("Content-Disposition: attachment; filename=" . $filename);

$data = $AR_CODE . " - " . $customer_name . " วันที่ " . $_POST['doc_date_start'] . " ถึง " . $_POST['doc_date_to'] . "\n";
$data .= "\n";
$data .= "ยี่ห้อ,ปี,เดือน,ขนาดยาง,จำนวน (เส้น),คะแนน (ต่อเส้น),คะแนน (รวม)\n";

$query = $conn->prepare($String_Sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() >= 1) {
    foreach ($results as $result) {

        $data .= " " . $result['BRN_CODE'] . ",";
        $data .= " " . $result['DI_YEAR'] . ",";
        $data .= " " . $result['DI_MONTH_NAME'] . ",";
        $data .= " " . $result['TIRES_SIZE'] . ",";
        $data .= " " . $result['TIRES_SIZE'] . ",";
        $data .= " " . $result['TIRES_SIZE'] . ",";
        $data .= " " . $result['TIRES_SIZE'] . ",";
        $data .= " " . $total_point . "\n";

    }

}


// $data = iconv("utf-8", "tis-620", $data);
$data = iconv("utf-8", "windows-874//IGNORE", $data);
echo $data;

exit();