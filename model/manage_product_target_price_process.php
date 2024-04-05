<?php
session_start();
error_reporting(0);

include('../config/connect_db_sac.php');
include('../config/lang.php');
include('../util/record_util.php');

if ($_POST["action"] === 'GET_DATA') {
    $id = $_POST["id"];
    $return_arr = array();
    $sql_get = "SELECT * FROM ims_product_price WHERE id = " . $id;
    $statement = $conn_sac->query($sql_get);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        $return_arr[] = array("id" => $result['id'],
            "product_id" => $result['product_id'],
            "name_t" => $result['name_t'],
            "price_year" => $result['price_year'],
            "price_normal" => $result['price_normal'],
            "price_1" => $result['price_1'],
            "price_2" => $result['price_2'],
            "price_3" => $result['price_3'],
            "price_4" => $result['price_4'],
            "price_5" => $result['price_5']);
    }

    echo json_encode($return_arr);

}

if ($_POST["action"] === 'SEARCH') {
    if ($_POST["name_t"] !== '') {
        $name_t = $_POST["name_t"];
        $sql_find = "SELECT * FROM ims_product_price WHERE name_t = '" . $name_t . "'";
        $nRows = $conn_sac->query($sql_find)->fetchColumn();
        if ($nRows > 0) {
            echo 2;
        } else {
            echo 1;
        }
    }
}

if ($_POST["action"] === 'ADD') {
    if ($_POST["name_t"] !== '') {
        $product_id = $_POST["product_id"];
        $name_t = $_POST["name_t"];
        $price_normal = $_POST["price_normal"];
        $price_1 = $_POST["price_1"];
        $price_2 = $_POST["price_2"];
        $price_3 = $_POST["price_3"];
        $price_4 = $_POST["price_4"];
        $price_5 = $_POST["price_5"];
        $sql_find = "SELECT * FROM ims_product_price WHERE name_t = '" . $name_t . "'";

        $nRows = $conn_sac->query($sql_find)->fetchColumn();
        if ($nRows > 0) {
            echo $dup;
        } else {
            $sql = "INSERT INTO ims_product_price(product_id,name_t,price_year,price_1,price_2) 
            VALUES (:product_id,:name_t,:price_year,:price_1,:price_2)";
            $query = $conn_sac->prepare($sql);
            $query->bindParam(':product_id', $product_id, PDO::PARAM_STR);
            $query->bindParam(':name_t', $name_t, PDO::PARAM_STR);
            $query->bindParam(':price_year', $price_year, PDO::PARAM_STR);
            $query->bindParam(':price_1', $price_1, PDO::PARAM_STR);
            $query->bindParam(':price_2', $price_2, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $conn_sac->lastInsertId();

            if ($lastInsertId) {
                echo $save_success;
            } else {
                echo $error;
            }
        }
    }
}


if ($_POST["action"] === 'UPDATE') {
    if ($_POST["product_id"] != '') {
        $id = $_POST["id"];
        $product_id = $_POST["product_id"];
        $name_t = $_POST["name_t"];
        $price_year = $_POST["price_year"];
        $price_normal = $_POST["price_normal"];
        $price_1 = $_POST["price_1"];
        $price_2 = $_POST["price_2"];
        $price_3 = $_POST["price_3"];
        $price_4 = $_POST["price_4"];
        $price_5 = $_POST["price_5"];
        $sql_find = "SELECT * FROM ims_product_price WHERE id = '" . $id . "'";
        $nRows = $conn_sac->query($sql_find)->fetchColumn();
        if ($nRows > 0) {
            $sql_update = "UPDATE ims_product_price SET name_t=:name_t            
            ,price_normal=:price_normal,price_1=:price_1,price_2=:price_2,price_3=:price_3,price_4=:price_4,price_5=:price_5
            WHERE id = :id";
            $query = $conn_sac->prepare($sql_update);
            $query->bindParam(':name_t', $name_t, PDO::PARAM_STR);
            $query->bindParam(':price_normal', $price_normal, PDO::PARAM_STR);
            $query->bindParam(':price_1', $price_1, PDO::PARAM_STR);
            $query->bindParam(':price_2', $price_2, PDO::PARAM_STR);
            $query->bindParam(':price_3', $price_3, PDO::PARAM_STR);
            $query->bindParam(':price_4', $price_4, PDO::PARAM_STR);
            $query->bindParam(':price_5', $price_5, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            echo $save_success;
        }
    }
}


if ($_POST["action"] === 'DELETE') {
    $id = $_POST["id"];
    $sql_find = "SELECT * FROM ims_product_price WHERE id = " . $id;
    $nRows = $conn_sac->query($sql_find)->fetchColumn();
    if ($nRows > 0) {
        try {
            $sql = "DELETE FROM ims_product_price WHERE id = " . $id;
            $query = $conn_sac->prepare($sql);
            $query->execute();
            echo $del_success;
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
}

if ($_POST["action"] === 'GET_PRODUCTS') {

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
        $searchQuery = " AND (product_id LIKE :product_id or
        name_t LIKE :name_t or price_year LIKE :price_year) ";
        $searchArray = array(
            'product_id' => "%$searchValue%",
            'name_t' => "%$searchValue%",
            'price_year' => "%$searchValue%",
        );
    }

## Total number of records without filtering
    $stmt = $conn_sac->prepare("SELECT COUNT(*) AS allcount FROM ims_product_price ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

## Total number of records with filtering
    $stmt = $conn_sac->prepare("SELECT COUNT(*) AS allcount FROM ims_product_price WHERE 1 " . $searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $stmt = $conn_sac->prepare("SELECT * FROM ims_product_price WHERE 1 " . $searchQuery
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
                "product_id" => $row['product_id'],
                "name_t" => $row['name_t'],
                "price_normal" => $row['price_normal'],
                "price_1" => $row['price_1'],
                "price_2" => $row['price_2'],
                "price_3" => $row['price_3'],
                "price_4" => $row['price_4'],
                "price_5" => $row['price_5'],
                "update" => "<button type='button' name='update' id='" . $row['id'] . "' class='btn btn-info btn-xs update' data-toggle='tooltip' title='Update'>Update</button>",
                "delete" => "<button type='button' name='delete' id='" . $row['id'] . "' class='btn btn-danger btn-xs delete' data-toggle='tooltip' title='Delete'>Delete</button>",
                "status" => $row['status'] === 'Active' ? "<div class='text-success'>" . $row['status'] . "</div>" : "<div class='text-muted'> " . $row['status'] . "</div>"
            );
        } else {
            $data[] = array(
                "id" => $row['id'],
                "product_id" => $row['product_id'],
                "name_t" => $row['name_t'],
                "select" => "<button type='button' name='select' id='" . $row['product_id'] . "@" . $row['name_t'] . "' class='btn btn-outline-success btn-xs select' data-toggle='tooltip' title='select'>select <i class='fa fa-check' aria-hidden='true'></i>
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

