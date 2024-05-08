<?php

$str_query_select=
 " SELECT 
 DOCINFO.DI_REF, 
 FORMAT (DOCINFO.DI_DATE, 'dd/MM/yyyy ') as DI_DATE,
 DOCINFO.DI_CRE_BY,
 APFILE.AP_CODE,
 APFILE.AP_NAME,
 APCAT.APCAT_CODE,
 APCAT.APCAT_NAME,
 APCONDITION.APCD_NAME, 
 APDETAIL.APD_DUE_DA,
 APDETAIL.APD_CHQ_DA,
 TRANSTKH.TRH_SHIP_DATE,
 SHIPBY.SB_NAME,
 DEPTTAB.DEPT_CODE,
 DEPTTAB.DEPT_THAIDESC,
 DEPTTAB.DEPT_ENGDESC,
 PRJTAB.PRJ_CODE,
 PRJTAB.PRJ_NAME,
 TRANSTKD.TRD_SH_CODE,
 TRANSTKD.TRD_SH_NAME, 
 BRAND.BRN_CODE,
 BRAND.BRN_NAME, 
 TRANSTKD.TRD_LOT_NO,
 TRANSTKD.TRD_SERIAL,
 TRANSTKD.TRD_QTY,
 TRANSTKD.TRD_SH_QTY,
 TRANSTKD.TRD_Q_FREE,
 TRANSTKD.TRD_SH_UPRC,
 TRANSTKD.TRD_G_KEYIN,
 TRANSTKD.TRD_DSC_KEYIN,
 TRANSTKD.TRD_DSC_KEYINV,
 TRANSTKD.TRD_TDSC_KEYINV,
 TRANSTKD.TRD_U_PRC,
 TRANSTKD.TRD_G_SELL,
 TRANSTKD.TRD_G_VAT,
 TRANSTKD.TRD_G_AMT,
 TRANSTKD.TRD_B_SELL,
 TRANSTKD.TRD_B_VAT,
 TRANSTKD.TRD_B_AMT,
 TRANSTKD.TRD_VAT_TY,
 TRANSTKD.TRD_UTQNAME,
 TRANSTKD.TRD_UTQQTY,
 TRANSTKD.TRD_VAT_R,
 TRANSTKD.TRD_REFER_REF,
 VATTABLE.VAT_RATE,
 VATTABLE.VAT_REF,
 VATTABLE.VAT_DATE,
 APDETAIL.APD_G_SV,
 APDETAIL.APD_G_SNV,
 APDETAIL.APD_G_VAT,
 APDETAIL.APD_B_SV,
 APDETAIL.APD_B_SNV,
 APDETAIL.APD_B_VAT,
 APDETAIL.APD_B_AMT,
 APDETAIL.APD_G_KEYIN,
 TRANSTKH.TRH_N_QTY,
 TRANSTKH.TRH_N_ITEMS,
 APDETAIL.APD_TDSC_KEYIN,
 APDETAIL.APD_TDSC_KEYINV,
 WAREHOUSE.WH_CODE,
 WAREHOUSE.WH_NAME,
 WARELOCATION.WL_CODE,
 WARELOCATION.WL_NAME,
 TRANSTKD.TRD_SH_REMARK,
  APDETAIL.APD_BIL_DA,
BR_CODE,
DI_ACTIVE ";

$str_query_from =" 
FROM
 DOCINFO,
 DOCTYPE,
 APDETAIL,
 APFILE,
 TRANSTKH,
 TRANSTKD,
 SHIPBY,
 VATTABLE,
 APCONDITION,
 WARELOCATION,
 WAREHOUSE,
 APCAT,
 GOODSMASTER,
 SKUMASTER,
 PRJTAB,
 ICDEPT,
 ICCAT,
 BRAND,
 ICCOLOR,
 ICSIZE,
 SKUALT,
 DEPTTAB,
 BRANCH
 ";

$str_query_where=" 
WHERE
 (DOCINFO.DI_DT=DOCTYPE.DT_KEY) AND
 (DOCTYPE.DT_PROPERTIES=303)  AND
 (DOCINFO.DI_KEY=APDETAIL.APD_DI) AND
 (APDETAIL.APD_AP=APFILE.AP_KEY) AND
 (DOCINFO.DI_KEY=TRANSTKH.TRH_DI) AND
 (TRANSTKH.TRH_KEY=TRANSTKD.TRD_TRH) AND
 (TRANSTKH.TRH_SB=SHIPBY.SB_KEY) AND
 (DOCINFO.DI_KEY=VATTABLE.VAT_DI) AND
 (APDETAIL.APD_APCD=APCONDITION.APCD_KEY) AND
 (TRANSTKD.TRD_WL=WARELOCATION.WL_KEY) AND
 (WARELOCATION.WL_WH=WAREHOUSE.WH_KEY)  AND
 (APFILE.AP_APCAT = APCAT.APCAT_KEY) AND
 (TRANSTKD.TRD_GOODS = GOODSMASTER.GOODS_KEY) AND
 (TRANSTKD.TRD_SKU = SKUMASTER.SKU_KEY) AND
 (TRANSTKH.TRH_PRJ = PRJTAB.PRJ_KEY) AND
 (TRANSTKH.TRH_DEPT = DEPTTAB.DEPT_KEY) AND
 (SKUMASTER.SKU_ICDEPT = ICDEPT.ICDEPT_KEY) AND
 (SKUMASTER.SKU_ICCAT = ICCAT.ICCAT_KEY) AND
 (SKUMASTER.SKU_BRN = BRAND.BRN_KEY) AND
 (SKUMASTER.SKU_ICCOLOR = ICCOLOR.ICCOLOR_KEY) AND
 (SKUMASTER.SKU_ICSIZE = ICSIZE.ICSIZE_KEY) AND
 (SKUMASTER.SKU_SKUALT = SKUALT.SKUALT_KEY) AND
 TRH_BR=BR_KEY ";

$str_query_order=" 
 ORDER BY
 DOCINFO.DI_DATE ASC,	
 DOCINFO.DI_REF ASC,	
 TRANSTKD.TRD_SEQ ASC ";


