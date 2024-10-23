<?php

// Load the database configuration file
include_once 'config/dbConfig.php';

// Include PhpSpreadsheet library autoloader
require_once 'vendor/autoload.php';

$int_row = 0;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['importSubmit'])) {

    // Allowed mime types
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    // Validate whether selected file is a Excel file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)) {

        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {



            $file_str_query = "import_excel_qry_" . date('m/d/Y H:i:s', time());

            // path to admin/
            $this_dir = dirname(__FILE__);

// admin's parent dir path can be represented by admin/..
            $parent_dir = realpath($this_dir . '/..');

// concatenate the target path from the parent dir path
            $target_path = $parent_dir . '/uploads/' . $file_str_query . '.sql';

            $reader = new Xlsx();
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet_arr = $worksheet->toArray();

            $lastRow = $worksheet->getHighestRow();

            // open the file
            $excel_row = "Excel Row = " . $lastRow;
/*
            $my_file = fopen("IExcel.txt", "w") or die("Unable to open file!");
            fwrite($my_file, "Excel Row = " . $lastRow);
            fclose($my_file);
*/

            // Remove header row
            unset($worksheet_arr[0]);

            foreach ($worksheet_arr as $row) {

                if ($row[0] === "" && $row[1] === "" && $row[2] === "" && $row[3] === "" && $row[4] === "" && $row[5] === "") {

                    //echo "null";
                    $null_data = "Null Row = " . $int_row . " * " . $row[0] . " | " . $row[1] . " | " . $row[2] . " | " . $row[3] . " | " . $row[4] . " | " . $row[5];
                    //$my_file = fopen("IExcelNull.txt", "w") or die("Unable to open file!");
                    //fwrite($my_file,$null_data);
                    //fclose($my_file);

                } else {
                    $int_row++;
                    $AR_CODE = trim($row[0]);
                    $AR_NAME = trim($row[1]);
                    $DI_DATE = trim($row[2]);
                    $DI_REF = trim($row[3]);
                    $SKU_CODE = trim($row[4]);
                    $SKU_NAME = str_replace("'", "^", $row[5]);
                    //$SKU_NAME = $row[5];
                    $TRD_QTY = trim($row[6]);
                    $TRD_Q_FREE = trim($row[7]);
                    $TRD_U_PRC = trim($row[8]);
                    $DISCOUNT1 = $row[9];
                    $DISCOUNT2 = $row[10];
                    $TRD_DSC_KEYINV = $row[11];
                    $TAKE_SALE_NAME = $row[12];
                    $SALE_CONDITION = $row[13];
                    $PROD_TYPE = $row[14];
                    $AVG_COST = $row[15];
                    $LOGISTIC = $row[16];
                    $AVG_COST_PRICE = $row[17];
                    $AVG_COST_PRICE_LOGISTIC = $row[18];
                    $TOTAL_PRICE = $row[19];
                    $PROFIT_U_PRICE = $row[20];
                    $GROSS_PROFIT = $row[21];
                    $TOTAL_LOGISTIC = $row[22];
                    $REMARK1 = $row[23];
                    $PROFIT_U_PERCENT = $row[24];
                    $PRICE_CODE = $row[25];
                    $PRICE_BY_CRDR = $row[26];
                    $DIFF_PRICE_SALE = $row[27];
                    $REMARK2 = $row[28];
                    $DIFF_PRICE_SALE_PERCENT = $row[29];
                    $REMARK_ADDITION = $row[30];
                    $BRAND = $row[31];
                    $PRODUCT_TYPE = $row[32];
                    $SALE = $row[33];
                    $TAKE = $row[34];
                    $CREDIT = $row[35];
                    $REAL_PRICE = $row[36];
                    $DISCOUNT_UNIT = $row[37];
                    $TOTAL_DISCOUNT = $row[38];


                    // Check whether member already exists in the database with the same email
                    $prevQuery = "SELECT id FROM ims_product_price_cost WHERE AR_CODE = '" . $AR_CODE
                        . "' AND DI_DATE = '" . $DI_DATE . "' AND DI_REF = '" . $DI_REF . "' AND SKU_CODE = '" . $SKU_CODE
                        . "' AND TRD_QTY = '" . $TRD_QTY
                        . "' AND TRD_U_PRC = '" . $TRD_U_PRC
                        . "' AND TRD_Q_FREE = '" . $TRD_Q_FREE
                        . "' AND ROW_CHK = '" . $int_row . "'";
                    $prevResult = $db->query($prevQuery);

                    if ($prevResult->num_rows > 0) {

                        $Dup_data = $Dup_data . "DUP Row = " . $int_row . " * " . $row[0] . " | " . $row[1] . " | " . $row[2] . " | " . $row[3] . " | " . $row[4] . " | " . $row[5] . "\n\r";
/*
                        $my_file = fopen("IExcelDup.txt", "w") or die("Unable to open file!");
                        fwrite($my_file,$Dup_data );
                        fclose($my_file);
*/

                        // Update member data in the database
                        //$db->query("UPDATE ims_product_price_cost
                        //SET first_name = '".$first_name."', last_name = '".$last_name."', email = '".$email."', phone = '".$phone."', status = '".$status."', modified = NOW() WHERE code_id = '".$code_id."'");

                    } else {

                        if ($DI_REF === "" && $DI_DATE === "" && $SKU_CODE === "" && $AR_NAME === "") {
                            $null_data2 = "Null Row 2 = " . $int_row . " * " . $row[0] . " | " . $row[1] . " | " . $row[2] . " | " . $row[3] . " | " . $row[4] . " | " . $row[5];
                            //$my_file = fopen("IExcelNull2.txt", "w") or die("Unable to open file!");
                            //fwrite($my_file, $null_data2);
                            //fclose($my_file);

                        } else {

                            $qry = "INSERT INTO ims_product_price_cost (ROW_CHK,AR_CODE,AR_NAME,DI_DATE,DI_REF,SKU_CODE,SKU_NAME,TRD_QTY,TRD_Q_FREE,TRD_U_PRC
,DISCOUNT1,DISCOUNT2,TRD_DSC_KEYINV,TAKE_SALE_NAME,SALE_CONDITION,PROD_TYPE,AVG_COST,LOGISTIC,AVG_COST_PRICE
,AVG_COST_PRICE_LOGISTIC,TOTAL_PRICE,PROFIT_U_PRICE,GROSS_PROFIT,TOTAL_LOGISTIC,REMARK1,PROFIT_U_PERCENT
,PRICE_CODE,PRICE_BY_CRDR,DIFF_PRICE_SALE,REMARK2,DIFF_PRICE_SALE_PERCENT,REMARK_ADDITION,BRAND,PRODUCT_TYPE,SALE,TAKE,CREDIT,REAL_PRICE,DISCOUNT_UNIT,TOTAL_DISCOUNT) 
VALUES ('" . $int_row . "','" . $AR_CODE . "','" . $AR_NAME . "', '" . $DI_DATE . "', '" . $DI_REF . "', '" . $SKU_CODE . "', '" . $SKU_NAME . "', '" . $TRD_QTY . "', '" . $TRD_Q_FREE . "', '" . $TRD_U_PRC . "'
, '" . $DISCOUNT1 . "', '" . $DISCOUNT2 . "', '" . $TRD_DSC_KEYINV . "', '" . $TAKE_SALE_NAME . "', '" . $SALE_CONDITION . "', '" . $PROD_TYPE . "', '" . $AVG_COST . "', '" . $LOGISTIC . "', '" . $AVG_COST_PRICE . "'
, '" . $AVG_COST_PRICE_LOGISTIC . "', '" . $TOTAL_PRICE . "', '" . $PROFIT_U_PRICE . "', '" . $GROSS_PROFIT . "', '" . $TOTAL_LOGISTIC . "', '" . $REMARK1 . "', '" . $PROFIT_U_PERCENT . "'
, '" . $PRICE_CODE . "', '" . $PRICE_BY_CRDR . "', '" . $DIFF_PRICE_SALE . "', '" . $REMARK2 . "', '" . $DIFF_PRICE_SALE_PERCENT . "', '" . $REMARK_ADDITION . "', '" . $BRAND . "'
, '" . $PRODUCT_TYPE . "', '" . $SALE . "', '" . $TAKE . "', '" . $CREDIT . "', '" . $REAL_PRICE . "', '" . $DISCOUNT_UNIT . "', '" . $TOTAL_DISCOUNT . "');";

/*
                            $qry_text .= $qry . "\n\r";

                            // open the file
                            $myfile = fopen($target_path, 'w') or die("can't open file");
                            //$myfile = fopen("qry_file_data.txt", "w") or die("Unable to open file!");
                            fwrite($myfile, $qry_text);
                            fclose($myfile);
*/

                            // Insert member data in the database
                            $db->query($qry);
                        }
                    }

                }

            }

            $qstring = '?status=succ';

        } else {
            $qstring = '?status=err';
        }
    } else {
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: import_data_cost_price.php" . $qstring);

?>
