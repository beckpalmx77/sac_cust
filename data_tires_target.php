<?php

include("config/connect_db_sac.php");

$month = "";
$month_name = "";
$year = "";

// $year = $_POST['year'];
$AR_CODE = $_POST['AR_CODE'];
$customer_name = $_POST['cust_name'];

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

/*
$month = $_POST['month'];
$year = $_POST['year'];

$sql_curr_month = " SELECT * FROM ims_month where month = '" . $month . "'";

$stmt_curr_month = $conn->prepare($sql_curr_month);
$stmt_curr_month->execute();
$MonthCurr = $stmt_curr_month->fetchAll();
foreach ($MonthCurr as $row_curr) {
    $month_name = $row_curr["month_name"];
}
*/

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
        แสดงยอดขายยางแต่ละยี่ห้อ <?php echo "[ " . $AR_CODE . " " . $customer_name . " ] วันที่ " . $doc_date_start . " ถึง " . $doc_date_to  ; ?>
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
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>ยี่ห้อ</th>
                <th>เดือน</th>
                <th>ขนาดยาง</th>
                <th>จำนวน (เส้น)</th>
            </tr>
            </tfoot>
            <tbody>

            <?php
            $tires_brand = array("LE", "LL");

            foreach ($tires_brand as $tr_brand) {

                $tires_size = array("R13", "R14", "R15", "R16", "R17", "R18", "R19", "R20", "R21", "R22");

                foreach ($tires_size as $tr_size) {

                    $sql_tires = " SELECT BRN_CODE, '" . $tr_size . "' AS TIRES_SIZE,DI_MONTH_NAME,DI_YEAR As DI_YEAR,SUM(TRD_QTY) as TRD_QTY 
                           FROM ims_product_sale_sac 
                           WHERE AR_CODE = '" . $AR_CODE . "' AND BRN_CODE = '" . $tr_brand . "' AND SKU_NAME LIKE '%" . $tr_size . "%'"
                           . $where_date . "
                           GROUP BY BRN_CODE,DI_MONTH,DI_YEAR 
                           HAVING SUM(TRD_QTY)>0
                           ORDER BY BRN_CODE,CAST(DI_YEAR AS UNSIGNED) DESC , CAST(DI_MONTH AS UNSIGNED) DESC    ";

/*
                    $myfile = fopen("search-qry-tires.txt", "w") or die("Unable to open file!");
                    fwrite($myfile, $sql_tires);
                    fclose($myfile);
*/

                    $statement_tires = $conn_sac->query($sql_tires);
                    $results_tires = $statement_tires->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results_tires as $row_tires) { ?>
                        <tr>
                        <td><?php echo htmlentities($row_tires['BRN_CODE']); ?></td>
                        <td><?php echo htmlentities($row_tires['DI_MONTH_NAME']); ?></td>
                        <td><?php echo htmlentities($row_tires['TIRES_SIZE']); ?></td>
                        <td><?php echo htmlentities(number_format($row_tires['TRD_QTY'], 2)); ?></td>
                    <?php } ?>
                    </tr>

                <?php } ?>
            <?php } ?>

            </tbody>

        </table>
    </div>

</div>


</body>
</html>
