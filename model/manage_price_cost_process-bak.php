<?php
session_start();
error_reporting(0);

include('../config/connect_db_sac.php');
include('../config/lang.php');
include('../util/record_util.php');



if ($_POST["action"] === 'GET_COST') {

/*
    $my_file = fopen("IExcel.txt", "w") or die("Unable to open file!");
    fwrite($my_file, "get = " . $_POST["action"]);
    fclose($my_file);
*/

    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = $_POST['search']['value']; // Search value

    $searchArray = array();

## Search
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " AND (AR_CODE LIKE :AR_CODE OR
        AR_NAME LIKE :AR_NAME OR SKU_CODE LIKE :SKU_CODE OR SKU_NAME LIKE :SKU_NAME) ";
        $searchArray = array(
            'AR_CODE' => "%$searchValue%",
            'AR_NAME' => "%$searchValue%",
            'SKU_CODE' => "%$searchValue%",
            'SKU_NAME' => "%$searchValue%",
        );
    }

## Total number of records without filtering
    $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM ims_product_price_cost ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

## Total number of records with filtering
    $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM ims_product_price_cost WHERE 1 " . $searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $stmt = $conn->prepare("SELECT * FROM ims_product_price_cost WHERE 1 " . $searchQuery
        . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

// Bind values
    foreach ($searchArray as $key => $search) {
        $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
    $stmt->execute();
    $empRecords = $stmt->fetchAll();
    $data = array();

    foreach ($empRecords as $row) {

        if ($_POST['sub_action'] === "GET_MASTER") {
            $data[] = array(
                "id" => $row['id'],
                "AR_CODE" => $row['AR_CODE'],
                "AR_NAME" => $row['AR_NAME'],
                "DI_DATE" => $row['DI_DATE'],
                "DI_REF" => $row['DI_REF'],
                "SKU_CODE" => $row['SKU_CODE'],
                "SKU_NAME" => $row['SKU_NAME'],
                "TRD_QTY" => $row['TRD_QTY'],
                "TRD_Q_FREE" => $row['TRD_Q_FREE'],
                "TRD_U_PRC" => $row['TRD_U_PRC'],
                "DISCOUNT1" => $row['DISCOUNT1'],
                "DISCOUNT2" => $row['DISCOUNT2'],
                "TRD_DSC_KEYINV" => $row['TRD_DSC_KEYINV'],
                "TAKE_SALE_NAME" => $row['TAKE_SALE_NAME'],
                "SALE_CONDITION" => $row['SALE_CONDITION'],
                "PROD_TYPE" => $row['PROD_TYPE'],
                "AVG_COST" => $row['AVG_COST'],
                "LOGISTIC" => $row['LOGISTIC'],
                "VG_COST_PRICE" => $row['VG_COST_PRICE'],
                "AVG_COST_PRICE_LOGISTIC" => $row['AVG_COST_PRICE_LOGISTIC'],
                "TOTAL_PRICE" => $row['TOTAL_PRICE'],
                "PROFIT_U_PRICE" => $row['PROFIT_U_PRICE']

            );
        } else {
            $data[] = array(
                "id" => $row['id'],
                "AR_CODE" => $row['AR_CODE'],
                "AR_NAME" => $row['AR_NAME'],
                "select" => "<button type='button' name='select' id='" . $row['AR_CODE'] . "@" . $row['AR_NAME'] . "' class='btn btn-outline-success btn-xs select' data-toggle='tooltip' title='select'>select <i class='fa fa-check' aria-hidden='true'></i>
</button>",
            );
        }

    }

## Response Return Value
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);


}
