<?php
include('../includes/Header.php');

include("../config/connect_db_sac.php");

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

    $sql_year = " SELECT DISTINCT(DI_YEAR) AS DI_YEAR
    FROM ims_product_sale_sac WHERE DI_YEAR >= 2000
    order by DI_YEAR desc ";
    $stmt_year = $conn_sac->prepare($sql_year);
    $stmt_year->execute();
    $YearRecords = $stmt_year->fetchAll();

    ?>
    <!DOCTYPE html>
    <html lang="th">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Datatable CSS -->
    <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- jQuery Library -->
    <script src="jquery-3.3.1.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/myadmin.css" rel="stylesheet">

    <!-- Datatable JS -->
    <script src="DataTables/datatables.min.js"></script>
    <script src='https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js'></script>
    <script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js'></script>
    <script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js'></script>

    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link href="../img/logo/logo.png" rel="icon">
    <title>สงวนออโต้คาร์ | SANGUAN AUTO CAR</title>

    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: 'Prompt', sans-serif !important;
        }
    </style>

    <style>

        th {

        }

    </style>


    <body class="bg-gradient-login">
    <!-- Login Content -->
    <input type="hidden" id="account_type" name="account_type" value="<?php echo $_SESSION['account_type'] ?>">
    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $_SESSION['customer_id'] ?>">
    <input type="hidden" id="customer_name" name="customer_name" value="<?php echo $_SESSION['customer_name'] ?>">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-12 col-md-12">
                <div class="card shadow-sm my-6">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <br>
                                    <div id="content-wrapper" class="d-flex flex-column">
                                        <div id="content">
                                            <img src="img/logo/logo text-01.png" width="200" height="79"/>
                                            <nav class="navbar navbar-light bg-light">
                                                <form class="form-inline">
                                                    <!--button class="btn btn-outline-info" id='BtnBack' name='BtnBack'
                                                            type="button">กลับหน้าหลัก
                                                    </button-->
                                                    <button class="btn btn-outline-danger" id='BtnExit'
                                                            name='BtnExit'
                                                            type="button">ปิดหน้าต่าง
                                                    </button>
                                                </form>
                                            </nav>
                                        </div>
                                    </div>

                                    <div class="container">
                                        <br>
                                        <h4>รายการสั่งซื้อสินค้า <?php if ($_SESSION['account_type'] == "customer") {
                                                echo " [" . $_SESSION['customer_name'] . "] ";
                                            } ?> </h4>
                                        <!-- Custom Filter -->
                                        <table Style="width:50%; padding:10px;">
                                            <tr>
                                                <!--th> หน้ากว้างยาง</th-->
                                                <th> ปี</th>
                                                <th> ขนาดกระทะล้อ</th>
                                            </tr>
                                            <tr>
                                                <!--td>
                                                    <select id='searchByName1' name='searchByName1'
                                                            class="form-control ">
                                                        <option value="">All</option>
                                                        <option value="155"> 155</option>
                                                        <option value="165"> 165</option>
                                                        <option value="175"> 175</option>
                                                        <option value="185"> 185</option>
                                                        <option value="195"> 195</option>
                                                        <option value="205"> 205</option>
                                                        <option value="215"> 215</option>
                                                        <option value="225"> 225</option>
                                                        <option value="235"> 235</option>
                                                        <option value="245"> 245</option>
                                                        <option value="255"> 255</option>
                                                        <option value="265"> 265</option>
                                                        <option value="275"> 275</option>
                                                        <option value="285"> 285</option>
                                                        <option value="295"> 295</option>
                                                        <option value="305"> 305</option>
                                                        <option value="315"> 315</option>
                                                        <option value="325"> 325</option>
                                                        <option value="345"> 345</option>
                                                        <option value="365"> 365</option>
                                                    </select>
                                                </td-->
                                                <!--td>
                                                    <select id="searchByName2" name='searchByName2'
                                                            class="form-control " required="">
                                                        <option value="">All</option>
                                                        <option value="45"> 45</option>
                                                        <option value="50"> 50</option>
                                                        <option value="55"> 55</option>
                                                        <option value="60"> 60</option>
                                                        <option value="65"> 65</option>
                                                        <option value="70"> 70</option>
                                                        <option value="75"> 75</option>
                                                        <option value="80"> 80</option>
                                                        <option value="85"> 85</option>
                                                    </select>
                                                </td-->

                                                <td>
                                                    <select name="year" id="year" class="form-control"
                                                            required>
                                                        <?php foreach ($YearRecords as $row) { ?>
                                                            <option value="<?php echo $row["DI_YEAR"]; ?>">
                                                                <?php echo $row["DI_YEAR"]; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </td>


                                                <input type='hidden' id="searchByName1" class="form-control "
                                                       placeholder=''>
                                                <input type='hidden' id="searchByName2" class="form-control "
                                                       placeholder=''>

                                                <td>
                                                    <select id='searchByName3' name='searchByName3'
                                                            class="form-control ">
                                                        <option value="">All</option>
                                                        <option value="R13"> R13</option>
                                                        <option value="R14"> R14</option>
                                                        <option value="R15"> R15</option>
                                                        <option value="R16"> R16</option>
                                                        <option value="R17"> R17</option>
                                                        <option value="R18"> R18</option>
                                                        <option value="R19"> R19</option>
                                                        <option value="R20"> R20</option>
                                                        <option value="R20"> R21</option>
                                                        <option value="R22"> R22</option>
                                                        <option value="R24"> R24</option>
                                                        <option value="R26"> R26</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <br/>
                                        <div id="buttons"></div>

                                        <!-- Table -->
                                        <table id='product' class='display dataTable hoverable  table-striped'>
                                            <thead>
                                            <tr>
                                                <th>วันที่เอกสาร</th>
                                                <th>รหัสสินค้า</th>
                                                <th>รายละเอียด</th>
                                                <th>จำนวน</th>
                                                <th>ราคาต่อหน่วย</th>
                                                <th>ราคารวม</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>

                                    <!-- Script -->
                                    <script>
                                        $(document).ready(function () {
                                            let dataTable = $('#product').DataTable({
                                                'processing': true,
                                                'serverSide': true,
                                                'bFilter': false,
                                                'serverMethod': 'post',
                                                "lengthMenu": [[5, 10, 25, 50, 100, 500, 1000], [5, 10, 25, 50, 100, 500, 1000]],
                                                'dom': 'Blfrtip',
                                                'buttons': [

                                                    {
                                                        "extend": 'pdf',
                                                        "text": 'Export PDF',
                                                        "className": 'btn btn-primary btn-sm ml-1'
                                                    },
                                                    {
                                                        "extend": 'csv',
                                                        "text": 'Export CSV',
                                                        "className": 'btn btn-primary btn-sm ml-1'
                                                    },


                                                    {
                                                        'extend': 'excel',
                                                        "text": 'Export  Excel',
                                                        'className': 'btn btn-primary btn-sm ml-1'
                                                    }, {
                                                        'extend': 'print',
                                                        "text": 'Print',
                                                        'className': 'btn btn-primary btn-sm ml-1'
                                                    }

                                                ], "language":
                                                    {
                                                        "processing": "<img style='width:65px; height:65px;' src='load.gif' />",
                                                    },

                                                'ajax': {
                                                    'url': 'process_target_tires.php',
                                                    'data': function (data) {

                                                        let searchByName3 = $('#searchByName3').val();
                                                        let searchByName2 = $('#searchByName2').val();
                                                        let searchByName1 = $('#searchByName1').val();
                                                        let account_type = $('#account_type').val();
                                                        let customer_id = $('#customer_id').val();

                                                        data.searchByName3 = searchByName3;
                                                        data.searchByName2 = searchByName2;
                                                        data.searchByName1 = searchByName1;
                                                        data.account_type = account_type;
                                                        data.customer_id = customer_id;
                                                    }
                                                },
                                                'columns': [
                                                    {data: 'DI_DATE'},
                                                    {data: 'SKU_CODE'},
                                                    {data: 'SKU_NAME'},
                                                    {data: 'TRD_QTY'},
                                                    {data: 'TRD_U_PRC'},
                                                    {data: 'TRD_G_KEYIN'},
                                                ]

                                            });

                                            //$('#searchByName1').keyup(function () {
                                            //dataTable.draw();
                                            //});

                                            $('#searchByName1').change(function () {
                                                dataTable.draw();
                                            });

                                            $('#searchByName2').change(function () {
                                                dataTable.draw();
                                            });
                                            $('#searchByName3').change(function () {
                                                dataTable.draw();
                                            });
                                        });

                                    </script>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#BtnBack").click(function () {
            back();
        });
    </script>

    <script>
        $("#BtnExit").click(function () {
            Exit();
        });
    </script>

    <script>
        function back() {
            let url = '<?php echo "../" . $_SESSION['dashboard_page'] ?>';
            window.location = url;
        }
    </script>

    <!--script>
        function Exit() {
            window.location = "../login";
        }
    </script-->

    <script>
        function Exit() {
            window.close();
        }
    </script>

    </body>
    </html>

<?php } ?>
