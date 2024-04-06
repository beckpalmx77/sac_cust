<?php

include("config/connect_db_sac.php");

$month = "";
$month_name = "";
$year = "";

$point = 0;
$total_point = 0;
$sum_point = 0;

// $year = $_POST['year'];
$AR_CODE = $_POST['AR_CODE'];

//$doc_date = substr($_POST['doc_date'], 6, 4) . "/" . substr($_POST['doc_date'], 3, 2) . "/" . substr($_POST['doc_date'], 0, 2);

$doc_date_start = substr($_POST['doc_date_start'], 6, 4) . "-" . substr($_POST['doc_date_start'], 3, 2) . "-" . substr($_POST['doc_date_start'], 0, 2);
$doc_date_to = substr($_POST['doc_date_to'], 6, 4) . "-" . substr($_POST['doc_date_to'], 3, 2) . "-" . substr($_POST['doc_date_to'], 0, 2);

if ($doc_date_start !== "" && $doc_date_to !== "") {
    $where_date = " AND STR_TO_DATE(DI_DATE, '%d/%m/%Y') BETWEEN '" . $doc_date_start . "' AND '" . $doc_date_to . "'";
}

/*
$myfile = fopen("search-qry-tires.txt", "w") or die("Unable to open file!");
fwrite($myfile, $doc_date_start . " | " . $doc_date_to);
fclose($myfile);
*/


$sql_customer_name = " SELECT AR_NAME FROM ims_customer_arcode where AR_CODE = '" . $AR_CODE . "'";

$stmt_customer_name = $conn_sac->prepare($sql_customer_name);
$stmt_customer_name->execute();
$row_customer = $stmt_customer_name->fetchAll();
foreach ($row_customer as $row_customers) {
    $customer_name = $row_customers["AR_NAME"];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta date="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/chartjs-2.9.0.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.css">
    <title>สงวนออโต้คาร์</title>
    <style>

        body {
            width: 1024px;
            margin: 3rem auto;
        }

        #chart-container {
            width: 100%;
            height: auto;
        }
    </style>

    <style>
        p.number {
            text-align-last: right;
        }
    </style>
</head>


<div class="card">
    <div class="card-header bg-success text-white">
        <i class="fa fa-bar-chart" aria-hidden="true"></i>
        แสดงยอดขายยางแต่ละยี่ห้อ <?php echo "[ " . $AR_CODE . " " . $customer_name . " ] วันที่ " . $doc_date_start . " ถึง " . $doc_date_to; ?>
    </div>
    <input type="hidden" name="month" id="month" value="<?php echo $month; ?>">
    <!--input type="hidden" name="year" id="year" value="<?php echo $year; ?>"-->
    <div class="card-body">
        <div id="chart-container">
        </div>
    </div>

    <div class="card-body">
        <table id="example" class="display table table-striped table-bordered"
               cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>ยี่ห้อ</th>
                <th>เดือน</th>
                <th>ขนาดยาง</th>
                <th>จำนวน (เส้น)</th>
                <th>คะแนน (ต่อเส้น)</th>
                <th>คะแนน (รวม)</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>ยี่ห้อ</th>
                <th>เดือน</th>
                <th>ขนาดยาง</th>
                <th>จำนวน (เส้น)</th>
                <th>คะแนน (ต่อเส้น)</th>
                <th>คะแนน (รวม)</th>
            </tr>
            </tfoot>
            <tbody>

            <?php
            $tires_brand = array("AT","LE","LL","LLIT");

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


                    $sql_tires = " SELECT BRN_CODE, '" . $tr_size . "' AS TIRES_SIZE,DI_MONTH_NAME,DI_YEAR As DI_YEAR,SUM(TRD_QTY) as TRD_QTY 
                           FROM ims_product_sale_sac 
                           WHERE AR_CODE = '" . $AR_CODE . "' AND BRN_CODE = '" . $tr_brand . "'" . $where_tires_size
                        . $where_date . "
                           GROUP BY BRN_CODE,DI_MONTH,DI_YEAR 
                           HAVING SUM(TRD_QTY)>0
                           ORDER BY BRN_CODE,CAST(DI_YEAR AS UNSIGNED) DESC , CAST(DI_MONTH AS UNSIGNED) DESC    ";

                    /*
                                        $sql_tires_chk .= $sql_tires . "\n\r";
                                        $myfile = fopen("search-qry-tires.txt", "w") or die("Unable to open file!");
                                        fwrite($myfile, $sql_tires);
                                        fclose($myfile);
                    */

                    $statement_tires = $conn_sac->query($sql_tires);
                    $results_tires = $statement_tires->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results_tires as $row_tires) { ?>

                        <?php

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

                        ?>

                        <tr>
                        <td><?php echo htmlentities($row_tires['BRN_CODE']); ?></td>
                        <td><?php echo htmlentities($row_tires['DI_MONTH_NAME']); ?></td>
                        <td><?php echo htmlentities($row_tires['TIRES_SIZE']); ?></td>
                        <td><?php echo htmlentities(number_format($row_tires['TRD_QTY'], 2)); ?></td>
                        <td><?php echo htmlentities($point); ?></td>
                        <td><?php echo htmlentities($total_point); ?></td>
                    <?php } ?>
                    </tr>

                <?php } ?>
            <?php } ?>

            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>รวมคะแนน</th>
                <th><?php echo $sum_point ?></th>
            </tr>

            </tbody>

        </table>
    </div>

</div>


</body>
</html>
