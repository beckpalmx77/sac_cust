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

                                        <!--div class="col-md-12 col-md-offset-2">
                                            <label for="name_t"
                                                   class="control-label"><b>เพิ่ม <?php echo urldecode($_GET['s']) ?></b></label>

                                            <button type='button' name='btnAdd' id='btnAdd'
                                                    class='btn btn-primary btn-xs'>Add
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div-->

                                        <div class="col-md-12 col-md-offset-2">
                                            <table id='TableRecordList' class='display dataTable'>
                                                <thead>
                                                <tr>
                                                    <th>รหัสสินค้า</th>
                                                    <th>รายละเอียด</th>
                                                    <th>ราคา 40 เส้น</th>
                                                    <th>ราคา 60 เส้น</th>
                                                    <th>ราคา 100 เส้น</th>
                                                    <th>ราคา 150 เส้น</th>
                                                    <th>ราคา 200 เส้น</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>รหัสสินค้า</th>
                                                    <th>รายละเอียด</th>
                                                    <th>ราคา 40 เส้น</th>
                                                    <th>ราคา 60 เส้น</th>
                                                    <th>ราคา 100 เส้น</th>
                                                    <th>ราคา 150 เส้น</th>
                                                    <th>ราคา 200 เส้น</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>

                                            <div id="result"></div>

                                        </div>

                                        <div class="modal fade" id="recordModal">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Modal title</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×
                                                        </button>
                                                    </div>
                                                    <form method="post" id="recordForm">
                                                        <div class="modal-body">
                                                            <div class="modal-body">


                                                                <div class="form-group row">
                                                                    <div class="col-sm-4">
                                                                        <label for="product_id" class="control-label">รหัสผู้จำหน่าย</label>
                                                                        <input type="product_id" class="form-control"
                                                                               id="product_id" name="product_id"
                                                                               readonly="true"
                                                                               placeholder="รหัสผู้จำหน่าย">
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <label for="name_t"
                                                                               class="control-label">ชื่อผู้จำหน่าย</label>
                                                                        <input type="text" class="form-control"
                                                                               id="name_t"
                                                                               name="name_t"
                                                                               required="required"
                                                                               placeholder="ชื่อผู้จำหน่าย">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="brand_id"
                                                                           class="control-label">ที่อยู่</label>
                                                                    <input type="brand_id" class="form-control"
                                                                           id="brand_id" name="brand_id"
                                                                           required="required"
                                                                           placeholder="ที่อยู่">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="price_year"
                                                                           class="control-label">โทรศัพท์</label>
                                                                    <input type="text" class="form-control"
                                                                           id="price_year"
                                                                           name="price_year"
                                                                           required="required"
                                                                           placeholder="โทรศัพท์">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="price_normal"
                                                                           class="control-label">price_normal</label>
                                                                    <select id="price_normal" name="price_normal"
                                                                            class="form-control"
                                                                            data-live-search="true"
                                                                            title="Please select">
                                                                        <option>Active</option>
                                                                        <option>Inactive</option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id" id="id"/>
                                                            <input type="hidden" name="action" id="action"
                                                                   value=""/>
                                                            <span class="icon-input-btn">
                                                                <i class="fa fa-check"></i>
                                                            <input type="submit" name="save" id="save"
                                                                   class="btn btn-primary" value="Save"/>
                                                            </span>
                                                            <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Close <i
                                                                        class="fa fa-window-close"></i>
                                                            </button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>


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

        $("#product_id").blur(function () {
            let method = $('#action').val();
            if (method === "ADD") {
                let product_id = $('#product_id').val();
                let formData = {action: "SEARCH", product_id: product_id};
                $.ajax({
                    url: 'model/manage_product_target_price_process.php',
                    method: "POST",
                    data: formData,
                    success: function (data) {
                        if (data == 2) {
                            alert("Duplicate มีข้อมูลนี้แล้วในระบบ กรุณาตรวจสอบ");
                        }
                    }
                })
            }
        });

    </script>

    <script>
        $(document).ready(function () {
            let formData = {action: "GET_PRODUCT_TIRES", sub_action: "GET_MASTER"};
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
                    'url': 'model/manage_product_target_price_process.php',
                    'data': formData
                },
                'columns': [
                    {data: 'product_id'},
                    {data: 'name_t'},
                    {data: 'price_normal'},
                    {data: 'price_1'},
                    {data: 'price_2'},
                    {data: 'price_3'},
                    {data: 'price_4'},
                    {data: 'price_5'},
                    {data: 'update'},
                    {data: 'delete'}
                ]
            });

            <!-- *** FOR SUBMIT FORM *** -->
            $("#recordModal").on('submit', '#recordForm', function (event) {
                event.preventDefault();
                $('#save').attr('disabled', 'disabled');
                let formData = $(this).serialize();
                $.ajax({
                    url: 'model/manage_product_target_price_process.php',
                    method: "POST",
                    data: formData,
                    success: function (data) {
                        alertify.success(data);
                        $('#recordForm')[0].reset();
                        $('#recordModal').modal('hide');
                        $('#save').attr('disabled', false);
                        dataRecords.ajax.reload();
                    }
                })
            });
            <!-- *** FOR SUBMIT FORM *** -->
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#btnAdd").click(function () {
                $('#recordModal').modal('show');
                $('#id').val("");
                $('#product_id').val("");
                $('#name_t').val("");
                $('#brand_id').val("");
                $('#price_year').val("");
                $('#price_normal').val("");
                $('#price_1').val("");
                $('#price_2').val("");
                $('#price_3').val("");
                $('#price_4').val("");
                $('#price_5').val("");
                $('.modal-title').html("<i class='fa fa-plus'></i> ADD Record");
                $('#action').val('ADD');
                $('#save').val('Save');
            });
        });
    </script>

    <script>

        $("#TableRecordList").on('click', '.update', function () {
            let id = $(this).attr("id");
            //alert(id);
            let formData = {action: "GET_DATA", id: id};
            $.ajax({
                type: "POST",
                url: 'model/manage_product_target_price_process.php',
                dataType: "json",
                data: formData,
                success: function (response) {
                    let len = response.length;
                    for (let i = 0; i < len; i++) {
                        let id = response[i].id;
                        let product_id = response[i].product_id;
                        let name_t = response[i].name_t;
                        let brand_id = response[i].brand_id;
                        let price_year = response[i].price_year;
                        let price_normal = response[i].price_normal;
                        let price_1 = response[i].price_1;
                        let price_2 = response[i].price_2;
                        let price_3 = response[i].price_3;
                        let price_4 = response[i].price_4;
                        let price_5 = response[i].price_5;

                        $('#recordModal').modal('show');
                        $('#id').val(id);
                        $('#product_id').val(product_id);
                        $('#name_t').val(name_t);
                        $('#brand_id').val(brand_id);
                        $('#price_year').val(price_year);
                        $('#price_normal').val(price_normal);
                        $('#price_1').val(price_1);
                        $('#price_2').val(price_2);
                        $('#price_3').val(price_3);
                        $('#price_4').val(price_4);
                        $('#price_5').val(price_5);
                        $('.modal-title').html("<i class='fa fa-plus'></i> Edit Record");
                        $('#action').val('UPDATE');
                        $('#save').val('Save');
                    }
                },
                error: function (response) {
                    alertify.error("error : " + response);
                }
            });
        });

    </script>

    <script>

        $("#TableRecordList").on('click', '.delete', function () {
            let id = $(this).attr("id");
            let formData = {action: "GET_DATA", id: id};
            $.ajax({
                type: "POST",
                url: 'model/manage_product_target_price_process.php',
                dataType: "json",
                data: formData,
                success: function (response) {
                    let len = response.length;
                    for (let i = 0; i < len; i++) {
                        let id = response[i].id;
                        let product_id = response[i].product_id;
                        let name_t = response[i].name_t;
                        let brand_id = response[i].brand_id;
                        let price_year = response[i].price_year;
                        let price_normal = response[i].price_normal;
                        let price_1 = response[i].price_1;
                        let price_2 = response[i].price_2;
                        let price_3 = response[i].price_3;
                        let price_4 = response[i].price_4;
                        let price_5 = response[i].price_5;

                        $('#recordModal').modal('show');
                        $('#id').val(id);
                        $('#product_id').val(product_id);
                        $('#name_t').val(name_t);
                        $('#brand_id').val(brand_id);
                        $('#price_year').val(price_year);
                        $('#price_normal').val(price_normal);
                        $('#price_1').val(price_1);
                        $('#price_2').val(price_2);
                        $('#price_3').val(price_3);
                        $('#price_4').val(price_4);
                        $('#price_5').val(price_5);
                        $('.modal-title').html("<i class='fa fa-minus'></i> Delete Record");
                        $('#action').val('DELETE');
                        $('#save').val('Confirm Delete');
                    }
                },
                error: function (response) {
                    alertify.error("error : " + response);
                }
            });
        });

    </script>

    </body>
    </html>

<?php } ?>
