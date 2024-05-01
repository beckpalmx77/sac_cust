<?php
// Load the database configuration file
include_once 'config/dbConfig.php';

// Get status message
if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Data has been imported successfully.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Something went wrong, please try again.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload a valid Excel file.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <?php include('includes/Header.php'); ?>
    <meta charset="utf-8">
    <title>นำข้อมูลเข้าระบบด้วย Excel สงวนออโต้คาร์ | SANGUAN AUTO CAR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link href="img/logo/logo.png" rel="icon">

    <!-- Bootstrap library -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Stylesheet file -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">


    <!-- Show/hide Excel file upload form -->
    <script>
        function formToggle(ID) {
            let element = document.getElementById(ID);
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
    </script>
</head>
<body id="page-top">
<div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid" id="container-wrapper">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <div class="row"></div>
                    <h1 class="h3 mb-0 text-gray-800"><?php echo urldecode($_GET['s']) ?></h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item"><?php echo urldecode($_GET['m']) ?></li>
                        <li class="breadcrumb-item active"
                            aria-current="page"><?php echo urldecode($_GET['s']) ?></li>
                    </ol>
                </div>
                <!-- Display status message -->
                <?php if (!empty($statusMsg)) { ?>
                    <div class="col-xs-12 p-3">
                        <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
                    </div>
                <?php } ?>

                <div class="row p-3">
                    <!-- Import link -->
                    <div class="col-md-12 head">
                        <div class="float-end">
                            <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i
                                        class="plus"></i> Import Excel</a>
                        </div>
                    </div>
                    <!-- Excel file upload form -->
                    <div class="col-md-12" id="importFrm" style="display: none;">
                        <form class="row g-3" action="importCostData.php" method="post" enctype="multipart/form-data">
                            <div class="col-auto">
                                <label for="fileInput" class="visually-hidden">File</label>
                                <input type="file" class="form-control" name="file" id="fileInput"/>
                            </div>
                            <div class="col-auto">
                                <input type="submit" class="btn btn-primary mb-3" name="importSubmit" value="Import">
                            </div>
                        </form>
                    </div>

                    <!-- Data list table -->
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>เดือน</th>
                            <th>ปี</th>
                            <th>จำนวนข้อมูล Record</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Get member rows
                        $result = $db->query(" SELECT imonth , iyear ,COUNT(AR_CODE) AS Records FROM v_ims_product_price_cost GROUP BY  imonth , iyear ORDER BY iyear desc , imonth desc ; ");
                        if ($result->num_rows > 0) {
                            $i = 0;
                            while ($row = $result->fetch_assoc()) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['imonth']; ?></td>
                                    <td><?php echo $row['iyear']; ?></td>
                                    <td><?php echo $row['Records']; ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="7">No member(s) found...</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>