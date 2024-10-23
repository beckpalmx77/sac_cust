<?php
// Load the database configuration file
include_once 'config/dbConfig.php';

// Get status message
if(!empty($_GET['status'])){
    switch($_GET['status']){
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
<html lang="en">
<head>
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
        function formToggle(ID){
            let element = document.getElementById(ID);
            if(element.style.display === "none"){
                element.style.display = "block";
            }else{
                element.style.display = "none";
            }
        }
    </script>
</head>
<body>

<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
    <div class="col-xs-12 p-3">
        <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
    </div>
<?php } ?>

<div class="row p-3">
    <!-- Import link -->
    <div class="col-md-12 head">
        <div class="float-end">
            <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import Excel</a>
        </div>
    </div>
    <!-- Excel file upload form -->
    <div class="col-md-12" id="importFrm" style="display: none;">
        <form class="row g-3" action="importCostData.php" method="post" enctype="multipart/form-data">
            <div class="col-auto">
                <label for="fileInput" class="visually-hidden">File</label>
                <input type="file" class="form-control" name="file" id="fileInput" />
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
            <th>AR_CODE</th>
            <th>AR_NAME</th>
            <th>DI_DATE</th>
            <th>DI_REF</th>
            <th>SKU_CODE</th>
            <th>SKU_NAME</th>
            <th>TRD_QTY</th>
            <th>TRD_Q_FREE</th>
            <th>TRD_U_PRC</th>
            <th>DISCOUNT1</th>
            <th>DISCOUNT2</th>
            <th>TRD_DSC_KEYINV</th>
            <th>AVG_COST</th>
            <th>LOGISTIC</th>
            <th>VG_COST_PRICE</th>
            <th>AVG_COST_PRICE_LOGISTIC</th>
            <th>TOTAL_PRICE</th>
            <th>PROFIT_U_PRICE</th>
            <th>GROSS_PROFIT</th>
            <th>TOTAL_LOGISTIC</th>
            <th>PROFIT_U_PERCENT</th>
            <th>PRICE_BY_CRDR</th>
            <th>DIFF_PRICE_SALE</th>
            <th>REMARK2</th>
            <th>DIFF_PRICE_SALE_PERCENT</th>
            <th>BRAND</th>
            <th>PRODUCT_TYPE</th>
            <th>CREDIT</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Get member rows
        $result = $db->query("SELECT count(AR_CODE) as FROM ims_product_price_cost");
        if($result->num_rows > 0){ $i=0;
            while($row = $result->fetch_assoc()){ $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['AR_CODE']; ?></td>
                    <td><?php echo $row['AR_NAME']; ?></td>
                    <td><?php echo $row['DI_DATE']; ?></td>
                    <td><?php echo $row['DI_REF']; ?></td>
                    <td><?php echo $row['SKU_CODE']; ?></td>
                    <td><?php echo $row['SKU_NAME']; ?></td>
                    <td><?php echo $row['TRD_QTY']; ?></td>
                    <td><?php echo $row['TRD_Q_FREE']; ?></td>
                    <td><?php echo $row['TRD_U_PRC']; ?></td>
                    <td><?php echo $row['DISCOUNT1']; ?></td>
                    <td><?php echo $row['DISCOUNT2']; ?></td>
                    <td><?php echo $row['TRD_DSC_KEYINV']; ?></td>
                    <td><?php echo $row['AVG_COST']; ?></td>
                    <td><?php echo $row['LOGISTIC']; ?></td>
                    <td><?php echo $row['AVG_COST_PRICE']; ?></td>
                    <td><?php echo $row['AVG_COST_PRICE_LOGISTIC']; ?></td>
                    <td><?php echo $row['TOTAL_PRICE']; ?></td>
                    <td><?php echo $row['PROFIT_U_PRICE']; ?></td>
                    <td><?php echo $row['GROSS_PROFIT']; ?></td>
                    <td><?php echo $row['TOTAL_LOGISTIC']; ?></td>
                    <td><?php echo $row['PROFIT_U_PERCENT']; ?></td>
                    <td><?php echo $row['PRICE_BY_CRDR']; ?></td>
                    <td><?php echo $row['DIFF_PRICE_SALE']; ?></td>
                    <td><?php echo $row['REMARK2']; ?></td>
                    <td><?php echo $row['DIFF_PRICE_SALE_PERCENT']; ?></td>
                    <td><?php echo $row['BRAND']; ?></td>
                    <td><?php echo $row['PRODUCT_TYPE']; ?></td>
                    <td><?php echo $row['CREDIT']; ?></td>

                </tr>
            <?php } }else{ ?>
            <tr><td colspan="7">No member(s) found...</td></tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>