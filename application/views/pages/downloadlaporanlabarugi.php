<html>

<head>
    <title>Laporan Laba Rugi</title>

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


            <td align="center" style=""> <span class="font1" style="font-weight : bold; text-align:center "> <b>Laporan Laba Rugi </b><br>
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
                <p class="font4">Laporan Laba Rugi
                    <br>Tanggal <?= date_format(date_create($date1), "d-F-Y") . " s/d " . date_format(date_create($date2), "d-F-Y"); ?></p>
            </td>
        </tr>

    </table>
    <br>
    <table class="border" style="width: 100%;border:1px solid black;" cellspacing="0">
        <thead>
            <tr style="border:1px solid black;background-color: #521746;color:#fff;width:100%">
                <th style="width:20%">Jenis Transaksi</th>
                <th style="width:20%">Keterangan</th>
                <th style="width:20%">Tanggal Transaksi</th>
                <th style="width:20%">Debit</th>
                <th style="width:20%">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $totalDebet = 0;
            $totalKredit = 0;
            foreach ($report as $row) {
                echo '
                                        <tr>
                                        <td>' . $row['jenis_transaksi'] . '</td>
                                        <td>' . wordwrap($row['keterangan'], 30, "<br />\n") . '</td>
                                        <td>' . date("d-F-Y", strtotime($row['tanggal'])) . '</td>
                                        <td>Rp ' . number_format($row['debit'], 0, ",", ".") . '</td>
                                        <td>Rp ' . number_format($row['kredit'], 0, ",", ".") . '</td>
                                    </tr>
                                        ';
                $totalDebet += $row['debit'];
                $totalKredit += $row['kredit'];
                if ($row['jenis_transaksi'] == 'Pembelian') {

                    $total += $row['sub_total'];
                } else {

                    $total -= $row['sub_total'];
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr style="border:1px solid black;background-color: #521746;color:#fff">
                <th colspan="3"></th>
                <th> Rp <?= number_format($totalDebet, 0, ",", ".")  ?> </th>
                <th> Rp <?= number_format($totalKredit, 0, ",", ".")  ?> </th>
            </tr>
            <tr style="border:1px solid black;background-color: #521746;color:#fff">
            <th colspan="3">Total <?php
                                                                $align = "";
                                                                if ($totalDebet > $totalKredit) {
                                                                    echo "Laba";
                                                                    $align = "left";
                                                                } else {
                                                                    echo "Rugi";
                                                                    $align = "right";
                                                                }
                                                                ?></th>
                                    <?php
                                        $align = "";
                                        if ($totalDebet > $totalKredit) {
                                            ?>
                                        <th style="text-align:left"> Rp <?= number_format($totalDebet - $totalKredit, 0, ",", ".")  ?> </th>
                                        <th></th>
                                    <?php
                                        } else {
                                            ?>
                                        <th></th>
                                        <th style="text-align:left"> Rp <?= number_format($totalKredit - $totalDebet, 0, ",", ".")  ?> </th>
                                    <?php
                                        }
                                        ?>
            </tr>
        </tfoot>
    </table>
    <page_footer>
        <table style="width: 100%; ">
            <tr>
                <td style="text-align: left;    width: 50%">Laporan Laba Rugi</td>
                <td style="text-align: right;    width: 50%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
</body>

</html>