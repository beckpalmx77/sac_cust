<?php
include('includes/Header.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    ?>

    <!DOCTYPE html>
    <html lang="th">
    <body id="page-top">
    <div id="wrapper">
        <?php
        include('includes/Side-Bar.php');
        ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php
                include('includes/Top-Bar.php');
                ?>
                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php echo urldecode($_GET['s']) ?></h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $_SESSION['dashboard_page']?>">Home</a></li>
                            <li class="breadcrumb-item"><?php echo urldecode($_GET['m']) ?></li>
                            <li class="breadcrumb-item active"
                                aria-current="page"><?php echo urldecode($_GET['s']) ?></li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-12">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                </div>
                                <div class="card-body">
                                    <section class="container-fluid">

                                        <div class="col-md-12 col-md-offset-2">
                                            <table id='TableRecordList' class='display dataTable'>
                                                <thead>
                                                <tr>
                                                    <th>รหัสลูกค้า</th>
                                                    <th>ชื่อลูกค้า</th>
                                                    <th>วันที่</th>
                                                    <th>เลขที่เอกสาร</th>
                                                    <th>รหัสสินค้า</th>
                                                    <th>ขนาดยาง/ดอกยาง</th>
                                                    <th>จำนวนเส้น</th>
                                                    <th>แถม</th>
                                                    <th>ราคาขายต่อเส้น</th>
                                                    <th>ส่วนลดบัตรโลตัส</th>
                                                    <th>มูลค่าบัตรโลตัส</th>
                                                    <th>ราคาขายต่อเส้นหลังหักส่วนลด</th>
                                                    <th>ทุนเฉลี่ย</th>
                                                    <th>ค่าขนส่ง</th>
                                                    <th>ราคาทุนเฉลี่ย</th>
                                                    <th>ราคาทุนเฉลี่ยรวมขนส่ง</th>
                                                    <th>ยอดขายรวม</th>
                                                    <th>กำไรต่อเส้น(บิลขาย-ทุนเฉลี่ย</th>
                                                    <th>ผลตอบแทนรวม</th>
                                                    <th>ค่าขนส่งรวม</th>
                                                    <th>%กำไรต่อเส้น(บิลขาย-ราคาขาย)</th>
                                                    <th>ราคาตามใบขาย(เครดิต/เงินสด)</th>
                                                    <th>ส่วนต่างบิลขาย-ใบราคา</th>
                                                    <th>หมายเหตุ(2)</th>
                                                    <th>%ส่วนต่าง(บิลขาย-ใบราคา)</th>
                                                    <th>ยี่ห้อ</th>
                                                    <th>ประเภท</th>
                                                    <th>เครดิต</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
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
                                                </tfoot>
                                            </table>

                                            <div id="result"></div>

                                        </div>



                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    include('includes/Modal-Logout.php');
    include('includes/Footer.php');
    ?>


    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/myadmin.min.js"></script>

    <!-- Page level plugins -->

    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css"/-->

    <script src="vendor/datatables/v11/bootbox.min.js"></script>
    <script src="vendor/datatables/v11/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="vendor/datatables/v11/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="vendor/datatables/v11/buttons.dataTables.min.css"/>

    <style>

        .icon-input-btn {
            display: inline-block;
            position: relative;
        }

        .icon-input-btn input[type="submit"] {
            padding-left: 2em;
        }

        .icon-input-btn .fa {
            display: inline-block;
            position: absolute;
            left: 0.65em;
            top: 30%;
        }
    </style>
    <script>
        $(document).ready(function () {
            $(".icon-input-btn").each(function () {
                let btnFont = $(this).find(".btn").css("font-size");
                let btnColor = $(this).find(".btn").css("color");
                $(this).find(".fa").css({'font-size': btnFont, 'color': btnColor});
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            let formData = {action: "GET_COST", sub_action: "GET_MASTER"};
            let dataRecords = $('#TableRecordList').DataTable({
                'lengthMenu': [[5, 10, 20, 50, 100,1000], [5, 10, 20, 50, 100,1000]],
                'language': {
                    search: 'ค้นหา', lengthMenu: 'แสดง _MENU_ รายการ',
                    info: 'หน้าที่ _PAGE_ จาก _PAGES_',
                    infoEmpty: 'ไม่มีข้อมูล',
                    zeroRecords: "ไม่มีข้อมูลตามเงื่อนไข",
                    infoFiltered: '(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)',
                    paginate: {
                        previous: 'ก่อนหน้า',
                        last: 'สุดท้าย',
                        next: 'ต่อไป'
                    }
                },
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'autoWidth': true,
                <?php  if ($_SESSION['deviceType']!=='xxx') {
                    echo "'scrollX': true,";
                    echo "'scrollY': 480,";
                }?>
                'ajax': {
                    'url': 'model/manage_price_cost_process.php',
                    'data': formData
                },
                'columns': [
                    {data: 'AR_CODE'},
                    {data: 'AR_NAME'},
                    {data: 'DI_DATE'},
                    {data: 'DI_REF'},
                    {data: 'SKU_CODE'},
                    {data: 'SKU_NAME'},
                    {data: 'TRD_QTY'},
                    {data: 'TRD_Q_FREE'},
                    {data: 'TRD_U_PRC'},
                    {data: 'DISCOUNT1'},
                    {data: 'DISCOUNT2'},
                    {data: 'TRD_DSC_KEYINV'},
                    {data: 'AVG_COST'},
                    {data: 'LOGISTIC'},
                    {data: 'VG_COST_PRICE'},
                    {data: 'AVG_COST_PRICE_LOGISTIC'},
                    {data: 'TOTAL_PRICE'},
                    {data: 'PROFIT_U_PRICE'},
                    {data: 'GROSS_PROFIT'},
                    {data: 'TOTAL_LOGISTIC'},
                    {data: 'PROFIT_U_PERCENT'},
                    {data: 'PRICE_BY_CRDR'},
                    {data: 'DIFF_PRICE_SALE'},
                    {data: 'REMARK2'},
                    {data: 'DIFF_PRICE_SALE_PERCENT'},
                    {data: 'BRAND'},
                    {data: 'PRODUCT_TYPE'},
                    {data: 'CREDIT'}
                ]
            });


        });
    </script>

    <!--script>
        $(document).ready(function () {
            let formData = {action: "GET_COST", sub_action: "GET_MASTER"};
            let dataRecords = $('#TableRecordList').DataTable({
                'lengthMenu': [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                    search: 'ค้นหา', lengthMenu: 'แสดง _MENU_ รายการ',
                    info: 'หน้าที่ _PAGE_ จาก _PAGES_',
                    infoEmpty: 'ไม่มีข้อมูล',
                    zeroRecords: "ไม่มีข้อมูลตามเงื่อนไข",
                    infoFiltered: '(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)',
                    paginate: {
                        previous: 'ก่อนหน้า',
                        last: 'สุดท้าย',
                        next: 'ต่อไป'
                    }
                },
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'model/manage_price_cost_process.php',
                    'data': formData
                },
                'columns': [
                    {data: 'AR_CODE'},
                    {data: 'AR_NAME'},
                    {data: 'DI_DATE'},
                    {data: 'DI_REF'},
                    {data: 'SKU_CODE'},
                    {data: 'SKU_NAME'},
                    {data: 'TRD_QTY'},
                    {data: 'TRD_Q_FREE'},
                    {data: 'TRD_U_PRC'},
                    {data: 'DISCOUNT1'},
                    {data: 'DISCOUNT2'},
                    {data: 'TRD_DSC_KEYINV'},
                    {data: 'TAKE_SALE_NAME'},
                    {data: 'SALE_CONDITION'},
                    {data: 'PROD_TYPE'},
                    {data: 'AVG_COST'},
                    {data: 'LOGISTIC'},
                    {data: 'VG_COST_PRICE'},
                    {data: 'AVG_COST_PRICE_LOGISTIC'},
                    {data: 'TOTAL_PRICE'},
                    {data: 'PROFIT_U_PRICE}
                ]
            });

        });
    </script-->

    </body>
    </html>

<?php } ?>