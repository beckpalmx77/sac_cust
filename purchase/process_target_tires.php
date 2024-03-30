<?php
include 'connect_mysql.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
$account_type = $_POST['account_type'];
$customer_id = $_POST['customer_id'];
$di_year = $_POST['di_year'];
$searchByName1 = $_POST['searchByName1'];
$searchByName2 = $_POST['searchByName2'];
$searchByName3 = $_POST['searchByName3'];

## Search 

$searchQuery = " ";

if($searchByName1 != ''){
    $searchQuery .= " and (SKU_NAME  like '%".$searchByName1."%') ";
}
if($searchByName2 != ''){
    $searchQuery .= " and (SKU_NAME  like '%".$searchByName2."%') ";
}
if($searchByName3 != ''){
    $searchQuery .= " and (SKU_NAME  like '%".$searchByName3."%') ";
}

if ($account_type == "customer") {
    $searchQuery .= " and (AR_CODE  = '". $customer_id ."') ";
}

if($di_year != ''){
    $searchQuery .= " and (DI_YEAR  like '%".$di_year."%') ";
}

if($searchValue != ''){
	$searchQuery .= " and SKU_CODE like '%".$searchValue."%' or 
    SKU_NAME like '%".$searchValue."%' or    
    ICCAT_NAME like '%".$searchValue."%' or    
    BRN_NAME like'%".$searchValue."%' ) ";
}

/*
$myfile = fopen("search-qry-cond.txt", "w") or die("Unable to open file!");
fwrite($myfile, $searchQuery);
fclose($myfile);
*/

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from ims_product_sale_sac");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from ims_product_sale_sac WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records

if ($columnName=='DI_DATE') {
    $columnName = " DI_YEAR desc , DI_MONTH desc , SUBSTR(DI_DATE,1,2) desc ";
    $columnSortOrder = " ";
}

$order_by = " order by ".$columnName." ".$columnSortOrder;

$empQuery = "select * from ims_product_sale_sac WHERE 1 ".$searchQuery. $order_by ." limit ".$row.",".$rowperpage;

$empRecords = mysqli_query($con, $empQuery);
$data = array();

/*
$myfile = fopen("search-qry.txt", "w") or die("Unable to open file!");
fwrite($myfile, $empQuery . " / " . $columnSortOrder);
fclose($myfile);
*/

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
            "DI_DATE"=>$row['DI_DATE'],
    		"SKU_CODE"=>$row['SKU_CODE'],
    		"SKU_NAME"=>$row['SKU_NAME'],
    		"TRD_QTY"=>$row['TRD_QTY'],
    		"TRD_U_PRC"=>$row['TRD_U_PRC'],
    		"TRD_G_KEYIN"=>$row['TRD_G_KEYIN']
    	);
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
