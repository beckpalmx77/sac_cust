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
$searchByName1 = $_POST['searchByName1'];
$searchByName2 = $_POST['searchByName2'];
$searchByName3 = $_POST['searchByName3'];
$searchByNameBrn = $_POST['searchByNameBrn'];

/*
$myfile = fopen("search-qry-param.txt", "w") or die("Unable to open file!");
fwrite($myfile, $searchByName1 . " | " . $searchByName2 . " | " . $searchByName3 . " > " . $searchValue);
fclose($myfile);
*/

## Search 

$searchQuery = " ";

if ($searchByName1 != '') {
    $searchQuery .= " and (name_t  like '%" . $searchByName1 . "%') ";
}
if ($searchByName2 != '') {
    $searchQuery .= " and (name_t  like '%" . $searchByName2 . "%') ";
}
if ($searchByName3 != '') {
    $searchQuery .= " and (name_t  like '%" . $searchByName3 . "%') ";
}
if ($searchByNameBrn != '') {
    $searchQuery .= " and (brand_id  like '%" . $searchByNameBrn . "%') ";
}

if ($searchValue != '') {
    $searchQuery .= " and product_id like '%" . $searchValue . "%' or name_t like '%" . $searchValue . "%' or brand_id like '%" . $searchValue . "%' ) ";
}

/*
$myfile = fopen("search-qry-cond.txt", "w") or die("Unable to open file!");
fwrite($myfile, $searchValue . " | " . $searchQuery);
fclose($myfile);
*/


## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as allcount from ims_product_price");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con, "select count(*) as allcount from ims_product_price WHERE 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from ims_product_price WHERE 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

/*
$myfile = fopen("search-qry.txt", "w") or die("Unable to open file!");
fwrite($myfile, $empQuery);
fclose($myfile);
*/

while ($row = mysqli_fetch_assoc($empRecords)) {
    $price_special = $row['price_1'];
    $data[] = array(
        "product_id" => $row['product_id'],
        "name_t" => $row['name_t'],
        "brand_id" => $row['brand_id'],
        "price_year" => $row['price_year'],
        "price_normal" => $row['price_normal'],
        "price_special1" => $row['price_1'],
        "price_special2" => $row['price_2'],
        "price_special3" => $row['price_3'],
        "price_special4" => $row['price_4'],
        "price_special5" => $row['price_5']
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
