<?php
session_start();
error_reporting(0);

include('../config/connect_db_sac.php');
include('../config/lang.php');
include('../util/record_util.php');

if ($_POST["action"] === 'GET_DATA') {
    $id = $_POST["id"];
    $return_arr = array();
    $sql_get = "SELECT * FROM ims_product_target_point WHERE id = " . $id;
    $statement = $conn_sac->query($sql_get);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        $return_arr[] = array("id" => $result['id'],
            "brn_code" => $result['brn_code'],
            "tires_size" => $result['tires_size'],
            "detail" => $result['detail'],
            "point_1" => $result['point_1'],
            "point_2" => $result['point_2']);
    }

    echo json_encode($return_arr);

}

if ($_POST["action"] === 'SEARCH') {
    if ($_POST["tires_size"] !== '') {
        $tires_size = $_POST["tires_size"];
        $sql_find = "SELECT * FROM ims_product_target_point WHERE tires_size = '" . $tires_size . "'";
        $nRows = $conn_sac->query($sql_find)->fetchColumn();
        if ($nRows > 0) {
            echo 2;
        } else {
            echo 1;
        }
    }
}

if ($_POST["action"] === 'ADD') {
    if ($_POST["tires_size"] !== '') {
        $brn_code = "S-" . sprintf('%04s', LAST_ID($conn_sac, "ims_product_target_point", 'id'));
        $tires_size = $_POST["tires_size"];
        $detail = $_POST["detail"];
        $point_1 = $_POST["point_1"];
        $point_2 = $_POST["point_2"];
        $sql_find = "SELECT * FROM ims_product_target_point WHERE tires_size = '" . $tires_size . "'";

        $nRows = $conn_sac->query($sql_find)->fetchColumn();
        if ($nRows > 0) {
            echo $dup;
        } else {
            $sql = "INSERT INTO ims_product_target_point(brn_code,tires_size,detail,point_1,point_2) 
            VALUES (:brn_code,:tires_size,:detail,:point_1,:point_2)";
            $query = $conn_sac->prepare($sql);
            $query->bindParam(':brn_code', $brn_code, PDO::PARAM_STR);
            $query->bindParam(':tires_size', $tires_size, PDO::PARAM_STR);
            $query->bindParam(':detail', $detail, PDO::PARAM_STR);
            $query->bindParam(':point_1', $point_1, PDO::PARAM_STR);
            $query->bindParam(':point_2', $point_2, PDO::PARAM_STR);
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
    if ($_POST["brn_code"] != '') {
        $id = $_POST["id"];
        $brn_code = $_POST["brn_code"];
        $tires_size = $_POST["tires_size"];
        $detail = $_POST["detail"];
        $point_1 = $_POST["point_1"];
        $point_2 = $_POST["point_2"];
        $sql_find = "SELECT * FROM ims_product_target_point WHERE brn_code = '" . $brn_code . "'";
        $nRows = $conn_sac->query($sql_find)->fetchColumn();
        if ($nRows > 0) {
            $sql_update = "UPDATE ims_product_target_point SET tires_size=:tires_size
            ,detail=:detail,point_1=:point_1,point_2=:point_2
            WHERE id = :id";
            $query = $conn_sac->prepare($sql_update);
            $query->bindParam(':tires_size', $tires_size, PDO::PARAM_STR);
            $query->bindParam(':detail', $detail, PDO::PARAM_STR);
            $query->bindParam(':point_1', $point_1, PDO::PARAM_STR);
            $query->bindParam(':point_2', $point_2, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            echo $save_success;
        }
    }
}


if ($_POST["action"] === 'DELETE') {
    $id = $_POST["id"];
    $sql_find = "SELECT * FROM ims_product_target_point WHERE id = " . $id;
    $nRows = $conn_sac->query($sql_find)->fetchColumn();
    if ($nRows > 0) {
        try {
            $sql = "DELETE FROM ims_product_target_point WHERE id = " . $id;
            $query = $conn_sac->prepare($sql);
            $query->execute();
            echo $del_success;
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
}

if ($_POST["action"] === 'GET_SUPPLIER') {
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
        $searchQuery = " AND (brn_code LIKE :brn_code or
        tires_size LIKE :tires_size or detail LIKE :detail) ";
        $searchArray = array(
            'brn_code' => "%$searchValue%",
            'tires_size' => "%$searchValue%",
            'detail' => "%$searchValue%",
        );
    }

## Total number of records without filtering
    $stmt = $conn_sac->prepare("SELECT COUNT(*) AS allcount FROM ims_product_target_point ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

## Total number of records with filtering
    $stmt = $conn_sac->prepare("SELECT COUNT(*) AS allcount FROM ims_product_target_point WHERE 1 " . $searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

## Fetch records
    $stmt = $conn_sac->prepare("SELECT * FROM ims_product_target_point WHERE 1 " . $searchQuery
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
                "brn_code" => $row['brn_code'],
                "tires_size" => $row['tires_size'],
                "detail" => $row['detail'],
                "point_1" => $row['point_1'],
                "point_2" => $row['point_2'],
                "update" => "<button type='button' name='update' id='" . $row['id'] . "' class='btn btn-info btn-xs update' data-toggle='tooltip' title='Update'>Update</button>",
                "delete" => "<button type='button' name='delete' id='" . $row['id'] . "' class='btn btn-danger btn-xs delete' data-toggle='tooltip' title='Delete'>Delete</button>",
                "status" => $row['status'] === 'Active' ? "<div class='text-success'>" . $row['status'] . "</div>" : "<div class='text-muted'> " . $row['status'] . "</div>"
            );
        } else {
            $data[] = array(
                "id" => $row['id'],
                "brn_code" => $row['brn_code'],
                "tires_size" => $row['tires_size'],
                "select" => "<button type='button' name='select' id='" . $row['brn_code'] . "@" . $row['tires_size'] . "' class='btn btn-outline-success btn-xs select' data-toggle='tooltip' title='select'>select <i class='fa fa-check' aria-hidden='true'></i>
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

