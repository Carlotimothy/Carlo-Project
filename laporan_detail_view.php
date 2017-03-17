<!-- COMPANY PROFILE VISTA HANDAL SEJAHTERA -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="CyberITs">

    <title>Dusky & Noble | Laporan Detail</title>

    <!-- Favicon -->


    <!-- BOOTSTRAP CORE CSS -->
    <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet">

    <!-- PLUGIN CSS -->
    <link href="<?php echo base_url();?>css/plugin/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/plugin/simple-sidebar.css" rel="stylesheet"> <!-- https://github.com/BlackrockDigital/startbootstrap-simple-sidebar -->
    <link href="<?php echo base_url();?>css/plugin/chartist.min.css" rel="stylesheet"> <!-- http://gionkunz.github.io/chartist-js/index.html -->

    <!-- CUSTOM CSS -->
    <link href="<?php echo base_url();?>css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/main.css" rel="stylesheet">

    <!-- CUSTOM FONTS -->
    <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>


    <style>
        #data-laporan {
            margin-top: 30px;
        }
        .ct-series-a .ct-line,
        .ct-series-a .ct-point {
          stroke: blue;
        }

        .ct-series-b .ct-line,
        .ct-series-b .ct-point {
          stroke: green;
        }
    </style>

</head>

<body>



    <!-- SIDEBAR -->
    <section>
        <?php 
        $this->load->view('include/sidebar_view');
        ?>
    </section>
    <!-- END SIDEBAR -->


    <header>
    </header>
    <main>


        <div id="wrapper">

            <section id ="main_section">

                
                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div id = "bagian_namauser" class="row">
                            <div class="col-lg-12 text-right">
                                Hello, <?php echo $namaUser; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">

                                <!-- 
                                <div class = "panel panel-default">
                                    <div class="panel-body">
                                        <a href="<?=base_url()?>form-produk-baru"><button class = "btn btn-primary">Buat Produk baru</button></a>
                                    </div>
                                </div>
                                -->


                                <div class = "panel panel-default">
                                    <div class="panel-head">
                                        <div class = "text-center page-header">
                                            <h2><b>Laporan Transaksi Detail</b></h2>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class = "row">
                                            <div id = "form-search-laporan" class="col-lg-6 col-lg-offset-3">
                                                <form action="<?=base_url()?>laporan-transaksi-detail" method="post">
                                                    <div class="form-group">
                                                        <label for="search_tanggal_awal">Tanggal Awal</label>
                                                        <div class="input-group tanggal_search_js" id="search_tanggal_awal">
                                                            <input name = "search_tanggal_awal" type="text" class="form-control">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-th"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="search_tanggal_akhir">Tanggal Akhir</label>
                                                        <div class="input-group tanggal_search_js" id="search_tanggal_akhir">
                                                            <input name = "search_tanggal_akhir" type="text" class="form-control">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-th"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class = "pull-right">
                                                        <button name="button_submit" type="submit" class="btn btn-default" value = "export">Export</button>
                                                        <button name="button_submit" type="submit" class="btn btn-default" value = "submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>



                                        <?php
                                        if($data_laporan) {
                                        ?>
                                        <br>
                                        <div class = "row">
                                            <div class = "col-lg-12">
                                                <div class="panel panel-default">

                                                    <div class="panel-body">
                                                        <div class = "row">
                                                            <div class = "col-lg-12">
                                                                <div id = "chart_detail" class="ct-chart">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if($data_laporan) {
                                        ?>
                                        <div id = "data-laporan" class = "row">
                                            <div class = "col-lg-12">
                                                <table class = "table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td class = "text-center"><b>Nomor</b></td>
                                                            <td class = "text-center"><b>Data Transaksi</b></td>
                                                            <td class = "text-center"><b>Data Barang</b></td>
                                                            <td class = "text-center"><b>Data Pembeli</b></td>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        foreach ($data_laporan as $key => $value) {
                                                            if(!isset($data_chart[$value['pid']."-".$value['productName']])) {
                                                                $data_chart[$value['pid']."-".$value['productName']] = 1;
                                                            }
                                                            else {
                                                                $data_chart[$value['pid']."-".$value['productName']]++;
                                                            }
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    echo $key+1;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    echo "Kode : ".$value['trid']."<br>";
                                                                    echo "Tanggal Transaksi : ".$value['dateOrder']."<br>";
                                                                    echo "Deskripsi : ".$value['transactionDescriptive']."<br>";
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    echo "Kode : ".$value['pid']."<br>";
                                                                    echo "Nama : ".$value['productName']."<br>";
                                                                    echo "Harga : ".$value['tr_price']."<br>";
                                                                    echo "Deskripsi : ".$value['productDescriptive']."<br>";
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    echo "Nama : ".$value['buyerName']."<br>";
                                                                    echo "Telepon : ".$value['buyerPhone']."<br>";
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>

                                    </div>


                                    

                                </div>

                            </div>
                        </div>
                    </div>
                </div>



            </section>












        </div>
    </main>


    <!-- 
    <footer>
        ini footer
    </footer>
    -->



    <!-- JQUERY -->
    <script src="<?php echo base_url();?>js/jquery.js"></script>

    <!-- BOOTSTRAP CORE JAVASCRIPT -->
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>

    <!-- PLUGIN JAVASCRIPT -->
    <script src="<?php echo base_url();?>js/wow.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>js/chartist.min.js"></script><!-- http://gionkunz.github.io/chartist-js/index.html -->


    <!-- SCRIPT AKTIVASI WOW JS -->
    <script>
        new WOW().init();
    </script>


    <!-- START CHART -->
    <script>
        var data_laporan_js = <?php echo json_encode($data_chart); ?>;
        for (var key in data_laporan_js) {
            if (! data_tanggal){
                var data_tanggal = [key];
                var data_value = [data_laporan_js[key]];
            } else {
                data_tanggal.push(key);
                data_value.push(data_laporan_js[key]);
            }
        }

        var data = {
          // A labels array that can contain any sort of values
          labels: data_tanggal,
          // Our series array that contains series objects or in this case series data arrays
          series: [
            data_value
          ]
        };
        // As options we currently only set a static size of 300x200 px. We can also omit this and use aspect ratio containers
        // as you saw in the previous example
        var options = {
            stretch: true,
            height: 350,
            low: 0,
        };
        // Create a new line chart object where as first parameter we pass in a selector
        // that is resolving to our chart container element. The Second parameter
        // is the actual data object. As a third parameter we pass in our custom options.
        new Chartist.Bar('.ct-chart', data, options);
    </script>
    <!-- END CHART -->



    <script>
        // DATEPICKER
        $('.tanggal_search_js input').datepicker({
            format: "dd/MM/yyyy",
            orientation: "bottom auto",
            autoclose: "true",
            todayHighlight: "true",
            daysOfWeekHighlighted: "0",
        });
    </script>

    <script>


        $(".button_tambah_js").click(function() {
            var td_pid = $(this).closest("tr").find(".td_pid").text();
            var td_productName = $(this).closest("tr").find(".td_productName").text();
            $('#edit_kode_produk').val(td_pid);
            $('#edit_nama_produk').val(td_productName);
        });


        // FORM STATE
        var form_state = <?php echo json_encode($form_state); ?>;
        var form_start_date = form_state['form_data_awal'];
        var form_data_akhir = form_state['form_data_akhir'];
        if (form_start_date != "") {
            $("#search_tanggal_awal input").val(form_start_date);
        };
        if (form_data_akhir != "") {
            $("#search_tanggal_akhir input").val(form_data_akhir);
        };
    </script>

</body>
</html>