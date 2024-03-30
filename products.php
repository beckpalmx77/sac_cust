<?php
include('includes/Header.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    ?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Datatable CSS -->
    <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- jQuery Library -->
    <script src="jquery-3.3.1.min.js"></script>

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
   
</head>

<body >

    <div class="container">
        <br>
        <h4>รายการสินค้า (ยางรถยนต์)</h4>
        <!-- Custom Filter -->
        <table Style="width:50%; padding:10px;">
            <tr> <th> หน้ากว้างยาง </th><th> แก้มยาง </th><th> ขนาดกระทะล้อ </th></tr>
			<tr>
                <td>
                    <select id='searchByName1' class="form-control ">
                        <option value="">All</option>
                        <option value="165"> 165 </option>
                        <option value="175"> 175 </option>
                        <option value="185"> 185 </option>
                        <option value="195"> 195 </option>

                    </select>
                </td>
                <td>
                    <!--input type='text' id="searchByName1"  class="form-control " placeholder='Enter R'></td><td-->
                    <select id="searchByName2" class="form-control " required="">
                        <option value="">All</option>
                        <option value="50"> 50 </option>
                        <option value="55"> 55 </option>
                        <option value="60"> 60 </option>
                        <option value="65"> 65 </option>
                        <option value="75"> 75 </option>
                        <option value="85"> 85 </option>
                    </select>
                </td>
                <td>
                    <select id='searchByName3' class="form-control ">

                        <option value="">All</option>
                        <option value="14"> 14 </option>
                        <option value="15"> 15 </option>
                        <option value="16"> 16 </option>
                        <option value="17"> 17 </option>
                        <option value="18"> 18 </option>
                        <option value="19"> 19 </option>
                        <option value="20"> 20 </option>
                        <option value="20"> 21 </option>
                        <option value="22"> 22 </option>
                       
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
                    <th>รหัสสินค้า</th>
                    <th>รายละเอียด</th>
                    <th>ยี่ห้อ</th>
                    <th>ปียาง</th>
                    <th>ราคาปกติ</th>
                    <th>ราคาพิเศษ</th>
                    <th>สถานะ</th>
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
                "lengthMenu": [[5,10, 25, 50, 100,500,1000], [5,10, 25, 50,100,500,1000]],
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
"processing": "<img style='width:300px; height:200px;' src='load.gif' />",
},
                
                'ajax': {
                    'url': 'products/products.php',
                    'data': function (data) {
                        
                        let searchByName3 = $('#searchByName3').val();
                        let searchByName2 = $('#searchByName2').val();
						let searchByName1=$('#searchByName1').val();

                       
                        data.searchByName3 = searchByName3;
                        data.searchByName2 = searchByName2;
						data.searchByName1 = searchByName1;
                    }
                },
                'columns': [
                    { data: 'product_id' },
                    { data: 'name_t' },
                    { data: 'brand_id' },
                    { data: 'price_year' },
                    { data: 'price_normal' },
                    { data: 'price_special' },
                    { data: 'status' },
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
    
</body>

</html>

<?PHP } ?>