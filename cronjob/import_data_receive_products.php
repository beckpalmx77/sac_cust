<?php

ini_set('display_errors', 1);
error_reporting(~0);

include("../config/connect_sqlserver.php");
include("../config/connect_db.php");

include('../cond_file/doc_info_sale_daily_cp.php');
include('../util/month_util.php');

$str_doc1 = array("30", "CS4", "CS5", "DS4", "IS3", "IS4", "ISC3", "ISC4");
$str_doc2 = array("CS.8", "CS.9", "IC.3", "IC.4", "IS.3", "IS.4", "S.5", "S.6");
$str_doc3 = array("CS.6", "CS.7", "IC.1", "IC.2", "IS.1", "IS.2", "S.1", "S.2");
$str_doc4 = array("CS.2", "CS.3", "IC.5", "IC.6", "IS.5", "IS.6", "S.3", "S.4");

//$group1 = "6SAC08 2SAC01 2SAC09 2SAC11 2SAC02 2SAC06 2SAC05 2SAC04 2SAC03 2SAC12 2SAC07 2SAC08 2SAC10 2SAC13 2SAC14 2SAC15 3SAC03 1SAC10";
//$group2 = "5SAC02 8SAC11 5SAC01 TA01-001 8SAC09 TA01-003 8CPA01-002 8BTCA01-002 8CPA01-001 8BTCA01-001";
//$group3 = "9SA01 999-13 999-07 999-08 TATA-004";
//$group4 = "TATA-003 SAC08 10SAC12";

$str_group1 = array("6SAC08","2SAC01","2SAC09","2SAC11","2SAC02","2SAC06","2SAC05","2SAC04","2SAC03","2SAC12","2SAC07","2SAC08","2SAC10","2SAC13","2SAC14","2SAC15","3SAC03","1SAC10");
$str_group2 = array("5SAC02","8SAC11","5SAC01","TA01-001","8SAC09","TA01-003","8CPA01-002","8BTCA01-002","8CPA01-001","8BTCA01-001");
$str_group3 = array("9SA01","999-13","999-07","999-08","TATA-004");
$str_group4 = array("TATA-003","SAC08","10SAC12");

echo "Today is " . date("Y/m/d");
echo "\n\r" . date("Y/m/d", strtotime("yesterday"));

$query_daily_cond_ext = " AND (DOCTYPE.DT_DOCCODE in ('30','CS4','CS5','DS4','IS3','IS4','ISC3','ISC4','CS.8','CS.9','IC.3','IC.4','IS.3','IS.4','S.5','S.6','CS.6','CS.7','IC.1','IC.2','IS.1','IS.2','S.1','S.2','CS.2','CS.3','IC.5','IC.6','IS.5','IS.6','S.3','S.4')) ";

$query_year = " AND DI_DATE BETWEEN '" . date("Y/m/d", strtotime("yesterday")) . "' AND '" . date("Y/m/d") . "'";
//$query_year = " AND DI_DATE BETWEEN '2017/01/01' AND '2021/12/31'";
//$query_year = " AND DI_DATE BETWEEN '2022/05/15' AND '" . date("Y/m/d") . "'";

$sql_sqlsvr = $select_query_daily . $select_query_daily_cond . $query_daily_cond_ext . $query_year . $select_query_daily_order;

echo $sql_sqlsvr;

//$myfile = fopen("qry_file_mssql_server.txt", "w") or die("Unable to open file!");
//fwrite($myfile, $sql_sqlsvr);
//fclose($myfile);

$insert_data = "";
$update_data = "";

$res = "";

$stmt_sqlsvr = $conn_sqlsvr->prepare($sql_sqlsvr);
$stmt_sqlsvr->execute();

$return_arr = array();

while ($result_sqlsvr = $stmt_sqlsvr->fetch(PDO::FETCH_ASSOC)) {

    $ICCAT_CODE = "";

    $DT_DOCCODE = $result_sqlsvr["DT_DOCCODE"];
    $ICCAT_CODE = $result_sqlsvr["ICCAT_CODE"];

    $branch = "";

    if (in_array($DT_DOCCODE, $str_doc1)) {
        $branch = "CP-340";
    }

    if (in_array($DT_DOCCODE, $str_doc2)) {
        $branch = "CP-BY";
    }

    if (in_array($DT_DOCCODE, $str_doc3)) {
        $branch = "CP-RP";
    }

    if (in_array($DT_DOCCODE, $str_doc4)) {
        $branch = "CP-BB";
    }

    echo "[ " . $DT_DOCCODE . " | " . $branch . " ]" . "\n\r";

    $res = $res . $result_sqlsvr["DI_REF"] . "  *** " . $result_sqlsvr["DT_DOCCODE"] . " *** " . "\n\r";

    //$myfile = fopen("sql_get_DATA.txt", "w") or die("Unable to open file!");
    //fwrite($myfile, "[" . $res) ;
    //fclose($myfile);


    $p_group = "";

    /*
        if (strpos($group1, $ICCAT_CODE) !== false) {
            $p_group = "P1";
        }

        if (strpos($group2, $ICCAT_CODE) !== false) {
            $p_group = "P2";
        }

        if (strpos($group3, $ICCAT_CODE) !== false) {
            $p_group = "P3";
        }

        if (strpos($group4, $ICCAT_CODE) !== false) {
            $p_group = "P4";
        }
    */

    if (in_array($ICCAT_CODE, $str_group1)) {
        $p_group = "P1";
    }

    if (in_array($ICCAT_CODE, $str_group2)) {
        $p_group = "P2";
    }

    if (in_array($ICCAT_CODE, $str_group3)) {
        $p_group = "P3";
    }

    if (in_array($ICCAT_CODE, $str_group4)) {
        $p_group = "P4";
    }

    $sql_find = "SELECT * FROM ims_product_sale_cockpit "
        . " WHERE DI_KEY = '" . $result_sqlsvr["DI_KEY"]
        . "' AND DI_REF = '" . $result_sqlsvr["DI_REF"]
        . "' AND DI_DATE = '" . $result_sqlsvr["DI_DATE"]
        . "' AND DT_DOCCODE = '" . $result_sqlsvr["DT_DOCCODE"]
        . "' AND TRD_SEQ = '" . $result_sqlsvr["TRD_SEQ"] . "'";

    //echo $sql_find . "\n\r";

    $nRows = $conn->query($sql_find)->fetchColumn();
    if ($nRows > 0) {

        $sql_update = " UPDATE ims_product_sale_cockpit  SET AR_CODE=:AR_CODE,AR_NAME=:AR_NAME,SLMN_CODE=:SLMN_CODE,SLMN_NAME=:SLMN_NAME
,SKU_CODE=:SKU_CODE,SKU_NAME=:SKU_NAME,SKU_CAT=:SKU_CAT,ICCAT_CODE=:ICCAT_CODE,ICCAT_NAME=:ICCAT_NAME,TRD_QTY=:TRD_QTY,TRD_U_PRC=:TRD_U_PRC
,TRD_DSC_KEYINV=:TRD_DSC_KEYINV,TRD_B_SELL=:TRD_B_SELL
,TRD_B_VAT=:TRD_B_VAT,TRD_G_KEYIN=:TRD_G_KEYIN,WL_CODE=:WL_CODE,BRANCH=:BRANCH,BRN_CODE=:BRN_CODE
,BRN_NAME=:BRN_NAME,DI_TIME_CHK=:DI_TIME_CHK,PGROUP=:PGROUP  
        WHERE DI_KEY = :DI_KEY         
        AND DI_REF  = :DI_REF
        AND DI_DATE = :DI_DATE
        AND DT_DOCCODE = :DT_DOCCODE
        AND TRD_SEQ = :TRD_SEQ ";

        $query = $conn->prepare($sql_update);

        $query->bindParam(':DI_REF ', $result_sqlsvr["DI_REF "],  PDO::PARAM_STR);
        $query->bindParam(':DI_DATE', $result_sqlsvr["DI_DATE"],  PDO::PARAM_STR);
        $query->bindParam(':DI_CRE_BY', $result_sqlsvr["DI_CRE_BY"],  PDO::PARAM_STR);
        $query->bindParam(':AP_CODE', $result_sqlsvr["AP_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':AP_NAME', $result_sqlsvr["AP_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':APCAT_CODE', $result_sqlsvr["APCAT_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':APCAT_NAME', $result_sqlsvr["APCAT_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':APCD_NAME ', $result_sqlsvr["APCD_NAME "],  PDO::PARAM_STR);
        $query->bindParam(':APD_DUE_DA', $result_sqlsvr["APD_DUE_DA"],  PDO::PARAM_STR);
        $query->bindParam(':APD_CHQ_DA', $result_sqlsvr["APD_CHQ_DA"],  PDO::PARAM_STR);
        $query->bindParam(':TRH_SHIP_DATE', $result_sqlsvr["TRH_SHIP_DATE"],  PDO::PARAM_STR);
        $query->bindParam(':SB_NAME', $result_sqlsvr["SB_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':DEPT_CODE', $result_sqlsvr["DEPT_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':DEPT_THAIDESC', $result_sqlsvr["DEPT_THAIDESC"],  PDO::PARAM_STR);
        $query->bindParam(':DEPT_ENGDESC', $result_sqlsvr["DEPT_ENGDESC"],  PDO::PARAM_STR);
        $query->bindParam(':PRJ_CODE', $result_sqlsvr["PRJ_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':PRJ_NAME', $result_sqlsvr["PRJ_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_CODE', $result_sqlsvr["TRD_SH_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_NAME ', $result_sqlsvr["TRD_SH_NAME "],  PDO::PARAM_STR);
        $query->bindParam(':BRN_CODE', $result_sqlsvr["BRN_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':BRN_NAME ', $result_sqlsvr["BRN_NAME "],  PDO::PARAM_STR);
        $query->bindParam(':TRD_LOT_NO', $result_sqlsvr["TRD_LOT_NO"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SERIAL', $result_sqlsvr["TRD_SERIAL"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_QTY', $result_sqlsvr["TRD_QTY"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_QTY', $result_sqlsvr["TRD_SH_QTY"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_Q_FREE', $result_sqlsvr["TRD_Q_FREE"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_UPRC', $result_sqlsvr["TRD_SH_UPRC"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_G_KEYIN', $result_sqlsvr["TRD_G_KEYIN"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_DSC_KEYIN', $result_sqlsvr["TRD_DSC_KEYIN"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_DSC_KEYINV', $result_sqlsvr["TRD_DSC_KEYINV"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_TDSC_KEYINV', $result_sqlsvr["TRD_TDSC_KEYINV"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_U_PRC', $result_sqlsvr["TRD_U_PRC"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_G_SELL', $result_sqlsvr["TRD_G_SELL"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_G_VAT', $result_sqlsvr["TRD_G_VAT"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_G_AMT', $result_sqlsvr["TRD_G_AMT"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_B_SELL', $result_sqlsvr["TRD_B_SELL"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_B_VAT', $result_sqlsvr["TRD_B_VAT"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_B_AMT', $result_sqlsvr["TRD_B_AMT"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_VAT_TY', $result_sqlsvr["TRD_VAT_TY"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_UTQNAME', $result_sqlsvr["TRD_UTQNAME"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_UTQQTY', $result_sqlsvr["TRD_UTQQTY"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_VAT_R', $result_sqlsvr["TRD_VAT_R"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_REFER_REF', $result_sqlsvr["TRD_REFER_REF"],  PDO::PARAM_STR);
        $query->bindParam(':VAT_RATE', $result_sqlsvr["VAT_RATE"],  PDO::PARAM_STR);
        $query->bindParam(':VAT_REF', $result_sqlsvr["VAT_REF"],  PDO::PARAM_STR);
        $query->bindParam(':VAT_DATE', $result_sqlsvr["VAT_DATE"],  PDO::PARAM_STR);
        $query->bindParam(':APD_G_SV', $result_sqlsvr["APD_G_SV"],  PDO::PARAM_STR);
        $query->bindParam(':APD_G_SNV', $result_sqlsvr["APD_G_SNV"],  PDO::PARAM_STR);
        $query->bindParam(':APD_G_VAT', $result_sqlsvr["APD_G_VAT"],  PDO::PARAM_STR);
        $query->bindParam(':APD_B_SV', $result_sqlsvr["APD_B_SV"],  PDO::PARAM_STR);
        $query->bindParam(':APD_B_SNV', $result_sqlsvr["APD_B_SNV"],  PDO::PARAM_STR);
        $query->bindParam(':APD_B_VAT', $result_sqlsvr["APD_B_VAT"],  PDO::PARAM_STR);
        $query->bindParam(':APD_B_AMT', $result_sqlsvr["APD_B_AMT"],  PDO::PARAM_STR);
        $query->bindParam(':APD_G_KEYIN', $result_sqlsvr["APD_G_KEYIN"],  PDO::PARAM_STR);
        $query->bindParam(':TRH_N_QTY', $result_sqlsvr["TRH_N_QTY"],  PDO::PARAM_STR);
        $query->bindParam(':TRH_N_ITEMS', $result_sqlsvr["TRH_N_ITEMS"],  PDO::PARAM_STR);
        $query->bindParam(':APD_TDSC_KEYIN', $result_sqlsvr["APD_TDSC_KEYIN"],  PDO::PARAM_STR);
        $query->bindParam(':APD_TDSC_KEYINV', $result_sqlsvr["APD_TDSC_KEYINV"],  PDO::PARAM_STR);
        $query->bindParam(':WH_CODE', $result_sqlsvr["WH_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':WH_NAME', $result_sqlsvr["WH_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':WL_CODE', $result_sqlsvr["WL_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':WL_NAME', $result_sqlsvr["WL_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_REMARK', $result_sqlsvr["TRD_SH_REMARK"],  PDO::PARAM_STR);
        $query->bindParam(':APD_BIL_DA', $result_sqlsvr["APD_BIL_DA"],  PDO::PARAM_STR);
        $query->bindParam(':BR_CODE', $result_sqlsvr["BR_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':DI_ACTIVE', $result_sqlsvr["DI_ACTIVE"],  PDO::PARAM_STR);



        $query->execute();

        $update_data .= $result_sqlsvr["DI_DATE"] . ":" . $result_sqlsvr["DI_REF"] . " |- " . $result_sqlsvr["ICCAT_CODE"] . "\n\r";

        echo " UPDATE DATA " . $update_data;

        //$myfile = fopen("update_chk.txt", "w") or die("Unable to open file!");
        //fwrite($myfile, $update_data);
        //fclose($myfile);

    } else {

        $sql = " INSERT INTO ims_product_sale_cockpit (DI_KEY,DI_REF,DI_DATE,DI_MONTH,DI_MONTH_NAME,DI_YEAR
        ,AR_CODE,AR_NAME,SLMN_CODE,SLMN_NAME,SKU_CODE,SKU_NAME,SKU_CAT,ICCAT_CODE,ICCAT_NAME,TRD_QTY,TRD_U_PRC
        ,TRD_DSC_KEYINV,TRD_B_SELL,TRD_B_VAT,TRD_G_KEYIN,WL_CODE,BRANCH,DT_DOCCODE,TRD_SEQ,BRN_CODE,BRN_NAME,DI_TIME_CHK,PGROUP)
        VALUES (:DI_KEY,:DI_REF,:DI_DATE,:DI_MONTH,:DI_MONTH_NAME,:DI_YEAR,:AR_CODE,:AR_NAME,:SLMN_CODE,:SLMN_NAME,:SKU_CODE,:SKU_NAME,:SKU_CAT
        ,:ICCAT_CODE,:ICCAT_NAME,:TRD_QTY,:TRD_U_PRC,:TRD_DSC_KEYINV,:TRD_B_SELL,:TRD_B_VAT,:TRD_G_KEYIN
        ,:WL_CODE,:BRANCH,:DT_DOCCODE,:TRD_SEQ,:BRN_CODE,:BRN_NAME,:DI_TIME_CHK,:PGROUP) ";
        $query = $conn->prepare($sql);


        $query->bindParam(':DI_REF ', $result_sqlsvr["DI_REF "],  PDO::PARAM_STR);
        $query->bindParam(':DI_DATE', $result_sqlsvr["DI_DATE"],  PDO::PARAM_STR);
        $query->bindParam(':DI_CRE_BY', $result_sqlsvr["DI_CRE_BY"],  PDO::PARAM_STR);
        $query->bindParam(':AP_CODE', $result_sqlsvr["AP_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':AP_NAME', $result_sqlsvr["AP_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':APCAT_CODE', $result_sqlsvr["APCAT_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':APCAT_NAME', $result_sqlsvr["APCAT_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':APCD_NAME ', $result_sqlsvr["APCD_NAME "],  PDO::PARAM_STR);
        $query->bindParam(':APD_DUE_DA', $result_sqlsvr["APD_DUE_DA"],  PDO::PARAM_STR);
        $query->bindParam(':APD_CHQ_DA', $result_sqlsvr["APD_CHQ_DA"],  PDO::PARAM_STR);
        $query->bindParam(':TRH_SHIP_DATE', $result_sqlsvr["TRH_SHIP_DATE"],  PDO::PARAM_STR);
        $query->bindParam(':SB_NAME', $result_sqlsvr["SB_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':DEPT_CODE', $result_sqlsvr["DEPT_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':DEPT_THAIDESC', $result_sqlsvr["DEPT_THAIDESC"],  PDO::PARAM_STR);
        $query->bindParam(':DEPT_ENGDESC', $result_sqlsvr["DEPT_ENGDESC"],  PDO::PARAM_STR);
        $query->bindParam(':PRJ_CODE', $result_sqlsvr["PRJ_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':PRJ_NAME', $result_sqlsvr["PRJ_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_CODE', $result_sqlsvr["TRD_SH_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_NAME ', $result_sqlsvr["TRD_SH_NAME "],  PDO::PARAM_STR);
        $query->bindParam(':BRN_CODE', $result_sqlsvr["BRN_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':BRN_NAME ', $result_sqlsvr["BRN_NAME "],  PDO::PARAM_STR);
        $query->bindParam(':TRD_LOT_NO', $result_sqlsvr["TRD_LOT_NO"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SERIAL', $result_sqlsvr["TRD_SERIAL"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_QTY', $result_sqlsvr["TRD_QTY"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_QTY', $result_sqlsvr["TRD_SH_QTY"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_Q_FREE', $result_sqlsvr["TRD_Q_FREE"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_UPRC', $result_sqlsvr["TRD_SH_UPRC"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_G_KEYIN', $result_sqlsvr["TRD_G_KEYIN"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_DSC_KEYIN', $result_sqlsvr["TRD_DSC_KEYIN"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_DSC_KEYINV', $result_sqlsvr["TRD_DSC_KEYINV"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_TDSC_KEYINV', $result_sqlsvr["TRD_TDSC_KEYINV"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_U_PRC', $result_sqlsvr["TRD_U_PRC"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_G_SELL', $result_sqlsvr["TRD_G_SELL"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_G_VAT', $result_sqlsvr["TRD_G_VAT"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_G_AMT', $result_sqlsvr["TRD_G_AMT"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_B_SELL', $result_sqlsvr["TRD_B_SELL"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_B_VAT', $result_sqlsvr["TRD_B_VAT"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_B_AMT', $result_sqlsvr["TRD_B_AMT"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_VAT_TY', $result_sqlsvr["TRD_VAT_TY"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_UTQNAME', $result_sqlsvr["TRD_UTQNAME"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_UTQQTY', $result_sqlsvr["TRD_UTQQTY"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_VAT_R', $result_sqlsvr["TRD_VAT_R"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_REFER_REF', $result_sqlsvr["TRD_REFER_REF"],  PDO::PARAM_STR);
        $query->bindParam(':VAT_RATE', $result_sqlsvr["VAT_RATE"],  PDO::PARAM_STR);
        $query->bindParam(':VAT_REF', $result_sqlsvr["VAT_REF"],  PDO::PARAM_STR);
        $query->bindParam(':VAT_DATE', $result_sqlsvr["VAT_DATE"],  PDO::PARAM_STR);
        $query->bindParam(':APD_G_SV', $result_sqlsvr["APD_G_SV"],  PDO::PARAM_STR);
        $query->bindParam(':APD_G_SNV', $result_sqlsvr["APD_G_SNV"],  PDO::PARAM_STR);
        $query->bindParam(':APD_G_VAT', $result_sqlsvr["APD_G_VAT"],  PDO::PARAM_STR);
        $query->bindParam(':APD_B_SV', $result_sqlsvr["APD_B_SV"],  PDO::PARAM_STR);
        $query->bindParam(':APD_B_SNV', $result_sqlsvr["APD_B_SNV"],  PDO::PARAM_STR);
        $query->bindParam(':APD_B_VAT', $result_sqlsvr["APD_B_VAT"],  PDO::PARAM_STR);
        $query->bindParam(':APD_B_AMT', $result_sqlsvr["APD_B_AMT"],  PDO::PARAM_STR);
        $query->bindParam(':APD_G_KEYIN', $result_sqlsvr["APD_G_KEYIN"],  PDO::PARAM_STR);
        $query->bindParam(':TRH_N_QTY', $result_sqlsvr["TRH_N_QTY"],  PDO::PARAM_STR);
        $query->bindParam(':TRH_N_ITEMS', $result_sqlsvr["TRH_N_ITEMS"],  PDO::PARAM_STR);
        $query->bindParam(':APD_TDSC_KEYIN', $result_sqlsvr["APD_TDSC_KEYIN"],  PDO::PARAM_STR);
        $query->bindParam(':APD_TDSC_KEYINV', $result_sqlsvr["APD_TDSC_KEYINV"],  PDO::PARAM_STR);
        $query->bindParam(':WH_CODE', $result_sqlsvr["WH_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':WH_NAME', $result_sqlsvr["WH_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':WL_CODE', $result_sqlsvr["WL_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':WL_NAME', $result_sqlsvr["WL_NAME"],  PDO::PARAM_STR);
        $query->bindParam(':TRD_SH_REMARK', $result_sqlsvr["TRD_SH_REMARK"],  PDO::PARAM_STR);
        $query->bindParam(':APD_BIL_DA', $result_sqlsvr["APD_BIL_DA"],  PDO::PARAM_STR);
        $query->bindParam(':BR_CODE', $result_sqlsvr["BR_CODE"],  PDO::PARAM_STR);
        $query->bindParam(':DI_ACTIVE', $result_sqlsvr["DI_ACTIVE"],  PDO::PARAM_STR);



        $query->execute();

        $lastInsertId = $conn->lastInsertId();

        if ($lastInsertId) {
            $insert_data .= $result_sqlsvr["DI_DATE"] . ":" . $result_sqlsvr["DI_REF"] . " | ";
            echo " Save OK " . $insert_data;
        } else {
            echo " Error ";
        }

    }

}

$conn_sqlsvr = null;

