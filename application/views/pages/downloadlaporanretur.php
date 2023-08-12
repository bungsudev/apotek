<html>

<head>
    <title>Laporan Retur Obat</title>

    <style type="text/css">
        body {
            font-size: 12px !important;
        }

        .font1 {
            font-family: times;
            font-size: 12pt;
        }

        .font2 {
            font-family: times;
            font-size: 16pt;
        }

        .font3 {
            font-family: times;
            font-size: 10pt;
        }

        .font4 {
            font-family: times;
            font-size: 12pt;
        }

        .font5 {
            font-family: times;
            font-size: 10pt;
        }

        table {
            width: 100%;
        }

        tr:nth-child(even) {
            background-color: #CCC
        }

        th,
        td {
            padding: 5px;
        }

        #tglcetak {
            text-align: right;
            float: right;
        }

        img {
            width: 100px;
            margin-left: 50%;
        }

        .border th,
        .border td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
    <!-- Sweet Alert -->
    <script src="./assets/js/sweetalert2.js"></script>
    <link href="./assets/css/sweetalert2.css" rel="stylesheet">

    <!-- Sweet Alert Function -->
    <script src="./assets/js/function.js"></script>
</head>

<body>
    <?php
    // Load file koneksi.php
    date_default_timezone_set('Asia/Jakarta');
    ?>
    <table style="width: 100%; ">
        <tr>
            <td style="width:30%;text-align:center;padding-right:35px" rowspan="1"><img style="width:140px" src="./assets/profil/<?= $profil['image'] ?>"></td>

            <td align="center" style=""> <span class="font1" style="font-weight : bold; text-align:center "> <b>Laporan Retur Obat </b><br>
                    <b><?= $profil['nama_apotek'] ?></b></span> <br>
                <span class="font1" style="font-weight : bold; "><?= $profil['alamat_apotek'] ?></span>
                <span class="font3" style="font-weight : bold;"><br>TELP : <u> <?= $profil['no_hp'] ?></u></span></td>
        </tr>
    </table>
    <hr>
    <table style="width: 100%; ">
        <tr>
            <td style="text-align: center;    width: 100%"> </td>
        </tr>
    </table>
    <table style="width: 100%; border:none !important">
        <tr>
            <td style="text-align: center;    width: 100%">
                <p class="font4">Laporan Retur Obat
                    <br>Tanggal <?= date_format(date_create($date1), "d-F-Y") . " s/d " . date_format(date_create($date2), "d-F-Y"); ?></p>
            </td>
        </tr>

    </table>
    <br>
    <table class="border" style="width: 100%;border:1px solid black;" cellspacing="0">
        <thead>
            <tr style="border:1px solid black;background-color: #521746;color:#fff;width:100%">
                <th style="width:30%">Keterangan</th>
                <th style="width:30%">Nama Obat</th>
                <th style="width:20%">Tanggal Transaksi</th>
                <th style="width:20%">Jumlah Obat</th>
            </tr>
        </thead>
        <tbody>
            <?php
                                                                                                                                    $total = 0;
                                                                                                                                    foreach ($report as $row) {
                                                                                                                                        echo '
                    <tr>
                                            <td>' . $row['jenis'] . '</td>
                                            <td>' . $row['nama_obat'] . '</td>
                                            <td>' . date("d-F-Y", strtotime($row['tanggal_retur'])) . ' ' . $row['jam_retur'] . '</td>
                                            <td style="text-align:right">' . number_format($row['jumlah_retur'], 0, ",", ".") . ' ' . $row['nama_satuan_obat'] . '</td>
                                            
                                        </tr>
                    ';
                                                                                                                                        $total += 1;
                                                                                                                                    }
            ?>
        </tbody>
        <tfoot>
            <tr style="border:1px solid black;background-color: #521746;color:#fff">
                <th colspan="3">Total Retur Obat</th>
                <th style="text-align:right"> <?= number_format($total, 0, ",", ".")  ?> </th>
            </tr>
        </tfoot>
    </table>
    <page_footer>
        <table style="width: 100%; ">
            <tr>
                <td style="text-align: left;    width: 50%">Laporan Retur Obat</td>
                <td style="text-align: right;    width: 50%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
</body>

</html>