<?php
include('../config/connect_db_sac.php');

date_default_timezone_set('Asia/Bangkok');

$where_date = "";
$AR_CODE = $_POST["AR_CODE"];

$point = 0;
$total_point = 0;
$sum_point = 0;
$total_qty = 0;
$total_price = 0;

/*
$my_file = fopen("Sale_D-CUST0.txt", "w") or die("Unable to open file!");
fwrite($my_file, $AR_CODE);
fclose($my_file);
*/

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

/*
$my_file = fopen("Sale_D-CUST1.txt", "w") or die("Unable to open file!");
fwrite($my_file, " myCheck  = " . $doc_date_start);
fclose($my_file);
*/


$filename = "Exp2-Customer-" . $AR_CODE . "-" . date('m/d/Y H:i:s', time()) . ".csv";

@header('Content-type: text/csv; charset=UTF-8');
@header('Content-Encoding: UTF-8');
@header("Content-Disposition: attachment; filename=" . $filename);

$data = $AR_CODE . " - " . $customer_name . " วันที่ " . $_POST['doc_date_start'] . " ถึง " . $_POST['doc_date_to'] . "\n";
$data .= "\n";
$data .= "รหัสลูกค้า,ชื่อลูกค้า,เลขที่เอกสาร,วันที่,เดือน,ปี,ยี่ห้อ,รหัสสินค้า,รายละเอียด,ขนาดยาง,จำนวน,คะแนน (ต่อเส้น),คะแนน (รวม),ราคาต่อหน่วย,ราคารวม\n";

$tires_brand = array("AT", "LE", "LL", "LLIT");

foreach ($tires_brand as $tr_brand) {
    $tires_size = array("R13","R14","R15","R16","R17","R17.5","R18","R19","R19.5","R20","R21","R22","R22.5");
    foreach ($tires_size as $tr_size) {

        if ($tr_size === "R17") {
            $where_tires_size = " AND SKU_NAME LIKE '%R17%' AND SKU_NAME NOT LIKE  '%R17.5%' " ;
        } else if ($tr_size === "R19") {
            $where_tires_size = " AND SKU_NAME LIKE '%R19%' AND SKU_NAME NOT LIKE  '%R19.5%' " ;
        } else if ($tr_size === "R22") {
            $where_tires_size = " AND SKU_NAME LIKE '%R22%' AND SKU_NAME NOT LIKE  '%R22.5%' " ;
        } else {
            $where_tires_size = " AND SKU_NAME LIKE '%" . $tr_size . "%'" ;
        }

        $sql_tires = " SELECT AR_CODE,AR_NAME,DI_REF,DI_DATE,DI_MONTH_NAME,DI_YEAR,BRN_CODE,SKU_CODE,SKU_NAME,'" . $tr_size . "' AS TIRES_SIZE,TRD_QTY,TRD_U_PRC,TRD_G_KEYIN
                       FROM ims_product_sale_sac  
                       WHERE AR_CODE = '" . $AR_CODE . "' AND BRN_CODE = '" . $tr_brand . "'" . $where_tires_size . " AND TRD_QTY > 0"
            . $where_date
            . " ORDER BY BRN_CODE,CAST(DI_YEAR AS UNSIGNED) DESC , CAST(DI_MONTH AS UNSIGNED) ";

/*
        $my_file = fopen("sql_tires.txt", "w") or die("Unable to open file!");
        fwrite($my_file, $sql_tires);
        fclose($my_file);
*/


        $statement_tires = $conn_sac->query($sql_tires);
        $results_tires = $statement_tires->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results_tires as $row_tires) {

            $sql_target = " SELECT * FROM ims_product_target_point 
                                            WHERE brn_code = '" . substr($row_tires['BRN_CODE'], 0, 2) . "'"
                . " AND tires_size = '" . $row_tires['TIRES_SIZE'] . "'";
            $statement_target = $conn_sac->query($sql_target);
            $results_target = $statement_target->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results_target as $row_target) {
                $point = $row_target['point_1'];
                $total_point = ($row_tires['TRD_QTY'] * $point);
                $sum_point = ($sum_point + $total_point);
            }

            $total_qty = $total_qty + $row_tires['TRD_QTY'];
            $total_price = $total_price + $row_tires['TRD_G_KEYIN'];

            $data .= $row_tires['AR_CODE'] . ",";
            $data .= $row_tires['AR_NAME'] . ",";
            $data .= $row_tires['DI_REF'] . ",";
            $data .= $row_tires['DI_DATE'] . ",";
            $data .= $row_tires['DI_MONTH_NAME'] . ",";
            $data .= $row_tires['DI_YEAR'] . ",";
            $data .= $row_tires['BRN_CODE'] . ",";
            $data .= $row_tires['SKU_CODE'] . ",";
            $data .= str_replace(",", "^", $row_tires['SKU_NAME']) . ",";
            $data .= $row_tires['TIRES_SIZE'] . ",";
            $data .= $row_tires['TRD_QTY'] . ",";
            $data .= $point . ",";
            $data .= $total_point . ",";
            $data .= $row_tires['TRD_U_PRC'] . ",";
            $data .= $row_tires['TRD_G_KEYIN'] . "\n";
        }
    }
}

            $data .= ",,,,,,,,,," . $total_qty . ",," . $sum_point . ",," . $total_price . "\n";

// $data = iconv("utf-8", "tis-620", $data);
$data = iconv("utf-8", "windows-874//IGNORE", $data);
echo $data;

exit();