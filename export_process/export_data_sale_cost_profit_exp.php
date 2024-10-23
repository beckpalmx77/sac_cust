<?php
include('../config/connect_db_sac.php');

date_default_timezone_set('Asia/Bangkok');

$where_date = "";
$where_ar_code = "";
$AR_CODE = $_POST["AR_CODE"];

$TRD_QTY = 0;
$ALL_TRD_QTY = 0;

$TRD_Q_FREE = 0;
$ALL_TRD_Q_FREE = 0;

$TOTAL_PRICE = 0;
$ALL_TOTAL_PRICE = 0;

$PROFIT_U_PRICE = 0;
$ALL_PROFIT_U_PRICE = 0;

$GROSS_PROFIT = 0;
$ALL_GROSS_PROFIT = 0;

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

/*
$my_file = fopen("sql_str_file.txt", "w") or die("Unable to open file!");
fwrite($my_file, $AR_CODE . " sql  = " . $String_Sql);
fclose($my_file);
*/

$filename = "Customer-" . $AR_CODE . "-" . date('m/d/Y H:i:s', time()) . ".csv";

@header('Content-type: text/csv; charset=UTF-8');
@header('Content-Encoding: UTF-8');
@header("Content-Disposition: attachment; filename=" . $filename);

$data = $AR_CODE . " - " . $customer_name . " วันที่ " . $_POST['doc_date_start'] . " ถึง " . $_POST['doc_date_to'] . "\n";
$data .= "รหัสลูกค้า,ชื่อลูกค้า,วันที่,เลขที่เอกสาร,รหัสสินค้า,ขนาดยาง/ดอกยาง,จำนวนเส้น,แถม,ราคาขายต่อเส้น,ส่วนลดบัตรโลตัส,มูลค่าบัตรโลตัส,ราคาขายต่อเส้นหลังหักส่วนลด,ทุนเฉลี่ย,ค่าขนส่ง,ราคาทุนเฉลี่ย,ราคาทุนเฉลี่ยรวมขนส่ง,ยอดขายรวม,กำไรต่อเส้น(บิลขาย-ทุนเฉลี่ย,ผลตอบแทนรวม,ค่าขนส่งรวม,%กำไรต่อเส้น(บิลขาย-ราคาขาย),ราคาตามใบขาย(เครดิต/เงินสด),ส่วนต่างบิลขาย-ใบราคา,หมายเหตุ(2),%ส่วนต่าง(บิลขาย-ใบราคา),ยี่ห้อ,ประเภท,เครดิต\n";

/*
$my_file = fopen("sql_str_file.txt", "w") or die("Unable to open file!");
fwrite($my_file, $data . " sql  = " . $String_Sql);
fclose($my_file);
*/


$query = $conn_sac->prepare($String_Sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

//if ($query->rowCount() >= 1) {
    foreach ($results as $result) {

        $TRD_QTY = (double)str_replace(",", "", $result->TRD_QTY);
        $ALL_TRD_QTY = $ALL_TRD_QTY + (double)str_replace(",", "", $result->TRD_QTY);

        $TRD_Q_FREE = (double)str_replace(",", "", $result->TRD_Q_FREE);
        $ALL_TRD_Q_FREE = $ALL_TRD_Q_FREE + (double)str_replace(",", "", $result->TRD_Q_FREE);

        $TOTAL_PRICE = (double)str_replace(",", "", $result->TOTAL_PRICE);
        $ALL_TOTAL_PRICE = $ALL_TOTAL_PRICE + (double)str_replace(",", "", $result->TOTAL_PRICE);

        $PROFIT_U_PRICE = (double)str_replace(",", "", $result->PROFIT_U_PRICE);
        $ALL_PROFIT_U_PRICE = $ALL_PROFIT_U_PRICE + (double)str_replace(",", "", $result->PROFIT_U_PRICE);

        $GROSS_PROFIT = (double)str_replace(",", "", $result->GROSS_PROFIT);
        $ALL_GROSS_PROFIT = $ALL_GROSS_PROFIT + (double)str_replace(",", "", $result->GROSS_PROFIT);

        $data .= $result->AR_CODE . ",";
        $data .= str_replace(",", "", $result->AR_NAME) . ",";
        $data .= $result->DI_DATE . ",";
        $data .= $result->DI_REF . ",";
        $data .= str_replace(",", "", $result->SKU_CODE) . ",";
        $data .= str_replace(",", "", $result->SKU_NAME) . ",";
        $data .= $TRD_QTY . ",";
        $data .= $TRD_Q_FREE . ",";
        $data .= str_replace(",", "", $result->TRD_U_PRC) . ",";
        $data .= str_replace(",", "", $result->DISCOUNT1) . ",";
        $data .= str_replace(",", "", $result->DISCOUNT2) . ",";
        $data .= str_replace(",", "", $result->TRD_DSC_KEYINV) . ",";
        $data .= str_replace(",", "", $result->AVG_COST) . ",";
        $data .= str_replace(",", "", $result->LOGISTIC) . ",";
        $data .= str_replace(",", "", $result->AVG_COST_PRICE) . ",";
        $data .= str_replace(",", "", $result->AVG_COST_PRICE_LOGISTIC) . ",";
        $data .= $TOTAL_PRICE . ",";
        $data .= $PROFIT_U_PRICE . ",";
        $data .= $GROSS_PROFIT . ",";
        $data .= str_replace(",", "", $result->TOTAL_LOGISTIC) . ",";
        $data .= str_replace(",", "", $result->PROFIT_U_PERCENT) . ",";
        $data .= str_replace(",", "", $result->PRICE_BY_CRDR) . ",";
        $data .= str_replace(",", "", $result->DIFF_PRICE_SALE) . ",";
        $data .= str_replace(",", "", $result->REMARK2) . ",";
        $data .= str_replace(",", "", $result->DIFF_PRICE_SALE_PERCENT) . ",";
        $data .= str_replace(",", "", $result->BRAND) . ",";
        $data .= str_replace(",", "", $result->PRODUCT_TYPE) . ",";
        $data .= str_replace(",", "", $result->CREDIT) . "\n";

    //}

}

        $data .= ",,,,,," . $ALL_TRD_QTY . "," . $ALL_TRD_Q_FREE . ",,,,,,,,," . $ALL_TOTAL_PRICE . "," . $ALL_PROFIT_U_PRICE . "," . $ALL_GROSS_PROFIT . "\n";

// $data = iconv("utf-8", "tis-620", $data);
$data = iconv("utf-8", "windows-874//IGNORE", $data);
echo $data;

exit();