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
                                            <label for="detail"
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
                                                    <th>ยี่ห้อ</th>
                                                    <th>รายละเอียด</th>
                                                    <th>ขนาด</th>
                                                    <th>คะแนนร้านทั่วไป</th>
                                                    <th>คะแนน Shop</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>ยี่ห้อ</th>
                                                    <th>รายละเอียด</th>
                                                    <th>ขนาด</th>
                                                    <th>คะแนนร้านทั่วไป</th>
                                                    <th>คะแนน Shop</th>
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
                                                                        <label for="brn_code" class="control-label">ยี่ห้อ</label>
                                                                        <input type="brn_code" class="form-control"
                                                                               id="brn_code" name="brn_code"
                                                                               readonly="true"
                                                                               placeholder="ยี่ห้อ">
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <label for="detail"
                                                                               class="control-label">รายละเอียด</label>
                                                                        <input type="text" class="form-control"
                                                                               id="detail"
                                                                               name="detail"
                                                                               required="required"
                                                                               placeholder="รายละเอียด">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tires_size"
                                                                           class="control-label">ขนาดยาง</label>
                                                                    <input type="tires_size" class="form-control"
                                                                           id="tires_size" name="tires_size"
                                                                           required="required"
                                                                           placeholder="ขนาดยาง">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="point_1"
                                                                           class="control-label">คะแนนร้านทั่วไป</label>
                                                                    <input type="text" class="form-control"
                                                                           id="point_1"
                                                                           name="point_1"
                                                                           required="required"
                                                                           placeholder="คะแนนร้านทั่วไป">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="point_2"
                                                                           class="control-label">คะแนน Shop</label>
                                                                    <input type="text" class="form-control"
                                                                           id="point_2"
                                                                           name="point_2"
                                                                           required="required"
                                                                           placeholder="คะแนน Shop">
                                                                </div>

                                                                <!--div class="form-group">
                                                                    <label for="s"
                                                                           class="control-label">คะแนน Shop</label>
                                                                    <select id="point_2" name="point_2"
                                                                            class="form-control"
                                                                            data-live-search="true"
                                                                            title="Please select">
                                                                        <option>Active</option>
                                                                        <option>Inactive</option>
                                                                    </select>
                                                                </div-->

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

        $("#brn_code").blur(function () {
            let method = $('#action').val();
            if (method === "ADD") {
                let brn_code = $('#brn_code').val();
                let formData = {action: "SEARCH", brn_code: brn_code};
                $.ajax({
                    url: 'model/manage_product_target_point_process.php',
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
            let formData = {action: "GET_SUPPLIER", sub_action: "GET_MASTER"};
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
                    'url': 'model/manage_product_target_point_process.php',
                    'data': formData
                },
                'columns': [
                    {data: 'brn_code'},
                    {data: 'detail'},
                    {data: 'tires_size'},
                    {data: 'point_1'},
                    {data: 'point_2'},
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
                    url: 'model/manage_product_target_point_process.php',
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
                $('#brn_code').val("");
                $('#detail').val("");
                $('#tires_size').val("");
                $('#point_1').val("");
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
                url: 'model/manage_product_target_point_process.php',
                dataType: "json",
                data: formData,
                success: function (response) {
                    let len = response.length;
                    for (let i = 0; i < len; i++) {
                        let id = response[i].id;
                        let brn_code = response[i].brn_code;
                        let detail = response[i].detail;
                        let tires_size = response[i].tires_size;
                        let point_1 = response[i].point_1;
                        let point_2 = response[i].point_2;

                        $('#recordModal').modal('show');
                        $('#id').val(id);
                        $('#brn_code').val(brn_code);
                        $('#detail').val(detail);
                        $('#tires_size').val(tires_size);
                        $('#point_1').val(point_1);
                        $('#point_2').val(point_2);
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
                url: 'model/manage_product_target_point_process.php',
                dataType: "json",
                data: formData,
                success: function (response) {
                    let len = response.length;
                    for (let i = 0; i < len; i++) {
                        let id = response[i].id;
                        let brn_code = response[i].brn_code;
                        let detail = response[i].detail;
                        let tires_size = response[i].tires_size;
                        let point_1 = response[i].point_1;
                        let point_2 = response[i].point_2;

                        $('#recordModal').modal('show');
                        $('#id').val(id);
                        $('#brn_code').val(brn_code);
                        $('#detail').val(detail);
                        $('#tires_size').val(tires_size);
                        $('#point_1').val(point_1);
                        $('#point_2').val(point_2);
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
