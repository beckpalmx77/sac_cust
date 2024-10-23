<?php
date_default_timezone_set('Asia/Bangkok');

$filename = "Data_Sale_Return-Daily-" . date('m/d/Y H:i:s', time()) . ".csv";

@header('Content-type: text/csv; charset=UTF-8');
@header('Content-Encoding: UTF-8');
@header("Content-Disposition: attachment; filename=" . $filename);

include('../config/connect_sqlserver.php');
include('../cond_file/doc_info_receive_products.php');


if ($_POST['BRN_CODE']==="ALL") {

    $tires_brand_cond =  "'AT','LE','LL','LLIT'";
    $tires_brand = " AND BRAND.BRN_CODE IN (" . $tires_brand_cond . ")";
} else {
    $tires_brand = " AND BRAND.BRN_CODE LIKE '" . $_POST['BRN_CODE'] . "%' " ;
}

$doc_date_start = substr($_POST['doc_date_start'], 6, 4) . "/" . substr($_POST['doc_date_start'], 3, 2) . "/" . substr($_POST['doc_date_start'], 0, 2);
$doc_date_to = substr($_POST['doc_date_to'], 6, 4) . "/" . substr($_POST['doc_date_to'], 3, 2) . "/" . substr($_POST['doc_date_to'], 0, 2);

$String_Sql = $str_query_select . $str_query_from. $str_query_where . " AND DOCINFO.DI_DATE BETWEEN '" . $doc_date_start . "' AND '" . $doc_date_to . "' "
    . $tires_brand
    . $str_query_order;

/*
$my_file = fopen("sql_str1.txt", "w") or die("Unable to open file!");
fwrite($my_file, $String_Sql);
fclose($my_file);
*/

$data = "เลขที่เอกสาร,วันที่,รหัสผู้ขาย,ชื่อผู้ขาย,รหัสสินค้า,รายละเอียดสินค้า,รหัสยี่ห้อ,ชื่อยี่ห้อ,จำนวน,แถม,ราคาต่อหน่วย,จำนวนเงิน,%ส่วนลด,จำนวนเงินส่วนลด,VAT,จำนวนเงิน+VAT\n";

$query = $conn_sqlsvr->prepare($String_Sql);
$query->execute();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

    $data .= $row['DI_REF'] . ",";
    $data .= $row['DI_DATE'] . ",";
    $data .= str_replace(",", "^", $row['AP_CODE']) . ",";
    $data .= str_replace(",", "^", $row['AP_NAME']) . ",";
    $data .= str_replace(",", "^", $row['TRD_SH_CODE']) . ",";
    $data .= str_replace(",", "^", $row['TRD_SH_NAME']) . ",";
    $data .= str_replace(",", "^", $row['BRN_CODE']) . ",";
    $data .= str_replace(",", "^", $row['BRN_NAME']) . ",";
    $data .= str_replace(",", "^", $row['TRD_QTY']) . ",";
    $data .= str_replace(",", "^", $row['TRD_Q_FREE']) . ",";
    $data .= str_replace(",", "^", $row['TRD_U_PRC']) . ",";
    $data .= str_replace(",", "^", $row['TRD_G_KEYIN']) . ",";
    $data .= str_replace(",", "^", $row['APD_TDSC_KEYIN']) . ",";
    $data .= str_replace(",", "^", $row['TRD_B_SELL']) . ",";
    $data .= str_replace(",", "^", $row['TRD_B_VAT']) . ",";
    $data .= str_replace(",", "^", $row['TRD_B_AMT']) . "\n";

}

$data = iconv("utf-8", "windows-874//IGNORE", $data);
echo $data;

exit();