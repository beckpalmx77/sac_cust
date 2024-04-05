<?php
include('../config/connect_db_sac.php');

date_default_timezone_set('Asia/Bangkok');

$where_date = "";
$AR_CODE = $_POST["AR_CODE"];


$my_file = fopen("Sale_D-CUST.txt", "w") or die("Unable to open file!");
fwrite($my_file, $AR_CODE);
fclose($my_file);

//$year = $_POST["year"];

$doc_date_start = substr($_POST['doc_date_start'], 6, 4) . "-" . substr($_POST['doc_date_start'], 3, 2) . "-" . substr($_POST['doc_date_start'], 0, 2);
$doc_date_to = substr($_POST['doc_date_to'], 6, 4) . "-" . substr($_POST['doc_date_to'], 3, 2) . "-" . substr($_POST['doc_date_to'], 0, 2);

if ($doc_date_start !== "" && $doc_date_to !== "") {
    $where_date = " AND STR_TO_DATE(DI_DATE, '%d/%m/%Y') BETWEEN '" . $doc_date_start . "' AND '" . $doc_date_to . "'";
}

$sql_customer_name = " SELECT AR_NAME FROM ims_customer_arcode where AR_CODE = '" . $AR_CODE . "'";

$stmt_customer_name = $conn_sac->prepare($sql_customer_name);
$stmt_customer_name->execute();
$row_customer = $stmt_customer_name->fetchAll();
foreach ($row_customer as $row_customers) {
    $customer_name = $row_customers["AR_NAME"];
}


$my_file = fopen("Sale_D-CUST.txt", "w") or die("Unable to open file!");
fwrite($my_file, $branch . "-" .$month . "-" .$year . " myCheck  = " . $doc_date_start);
fclose($my_file);


$filename = "Customer-" . $AR_CODE . "-" . date('m/d/Y H:i:s', time()) . ".csv";

@header('Content-type: text/csv; charset=UTF-8');
@header('Content-Encoding: UTF-8');
@header("Content-Disposition: attachment; filename=" . $filename);

$data = $AR_CODE . " - " . $customer_name . " วันที่ " . $_POST['doc_date_start'] . " ถึง " . $_POST['doc_date_to'] . "\n";
$data .= "\n";
$data .= "เลขที่เอกสาร,วันที่,เดือน,ปี,ยี่ห้อ,รหัสสินค้า,รายละเอียด,ขนาดยาง,จำนวน,ราคาต่อหน่วย,ราคารวม\n";

$tires_brand = array("AT", "LE", "LL", "LLIT");

foreach ($tires_brand as $tr_brand) {
    $tires_size = array("R13", "R14", "R15", "R16", "R17", "R18", "R19", "R20", "R21", "R22");
    foreach ($tires_size as $tr_size) {

        $sql_tires = " SELECT DI_REF,DI_DATE,DI_MONTH_NAME,DI_YEAR,BRN_CODE,SKU_CODE,SKU_NAME,'" . $tr_size . "' AS TIRES_SIZE,TRD_QTY,TRD_U_PRC,TRD_G_KEYIN
                       FROM ims_product_sale_sac  
                       WHERE TRD_QTY > 0 AND AR_CODE = '" . $AR_CODE . "' AND BRN_CODE = '" . $tr_brand . "' AND SKU_NAME LIKE '%" . $tr_size . "%'"
            . $where_date
            . " ORDER BY BRN_CODE,CAST(DI_YEAR AS UNSIGNED) DESC , CAST(DI_MONTH AS UNSIGNED) ";

/*
        $my_file = fopen("Sale_D-CP.txt", "w") or die("Unable to open file!");
        fwrite($my_file, $sql_tires);
        fclose($my_file);
*/

        $statement_tires = $conn_sac->query($sql_tires);
        $results_tires = $statement_tires->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results_tires as $row_tires) {
            $data .= $row_tires['DI_REF'] . ",";
            $data .= $row_tires['DI_DATE'] . ",";
            $data .= $row_tires['DI_MONTH_NAME'] . ",";
            $data .= $row_tires['DI_YEAR'] . ",";
            $data .= $row_tires['BRN_CODE'] . ",";
            $data .= $row_tires['SKU_CODE'] . ",";
            $data .= str_replace(",", "^", $row_tires['SKU_NAME']) . ",";
            $data .= $row_tires['TIRES_SIZE'] . ",";
            $data .= $row_tires['TRD_QTY'] . ",";
            $data .= $row_tires['TRD_U_PRC'] . ",";
            $data .= $row_tires['TRD_G_KEYIN'] . "\n";
        }
    }
}

// $data = iconv("utf-8", "tis-620", $data);
$data = iconv("utf-8", "windows-874//IGNORE", $data);
echo $data;

exit();