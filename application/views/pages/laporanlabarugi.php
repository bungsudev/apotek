<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 text-center">Laporan Laba Rugi</h1>
    <a href="" class="btn btn-primary mb-3 mt-2 filterButton mr-3" data-toggle="modal" data-target="#filterModal"><i class="fas fa-filter"></i> Filter Tanggal</a>
    <a href="#" class="btn btn-primary mb-3 mt-2 printButton mr-3"><i class="fas fa-print"></i> Cetak Laporan</a>
    <div class="row">
        <?php if ($report) { ?>
            <div class="col-xl-12 col-lg-12">

                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Laporan tanggal <?= date_format(date_create($date1), "d-F-Y") . " s/d " . date_format(date_create($date2), "d-F-Y"); ?></h6>
                    </div>
                    <div class="container p-3">
                        <table class="table table-striped table-bordered" id="dataTable" style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Jenis Transaksi</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
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
                            <tfoot class="bg-primary text-white">
                                <tr>
                                    <th colspan="3"></th>
                                    <th> Rp <?= number_format($totalDebet, 0, ",", ".")  ?> </th>
                                    <th> Rp <?= number_format($totalKredit, 0, ",", ".")  ?> </th>
                                </tr>
                                <tr>
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
                    </div>

                </div>
            </div>
        <?php } else { ?>
            <div class="col-xl-12 col-lg-12">
                <div class="alert alert-warning">
                    Maaf data laba rugi tanggal
                    <?php if (strtotime($date1) && strtotime($date2)) echo date_format(date_create($date1), "d-F-Y") . " s/d " . date_format(date_create($date2), "d-F-Y"); ?> tidak tersedia
                </div>
            </div>
        <?php } ?>
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Laporan Berdasarkan Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tracking_date">Tanggal Mulai</label>
                    <input type="date" id="date1" class="form-control" value="<?= $date1 ?>">
                </div>
                <div class="form-group">
                    <label for="tracking_date">Tanggal Akhir</label>
                    <input type="date" id="date2" class="form-control" value="<?= $date2 ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" data-dismiss="modal" id="filterButton" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#filterButton').click(function() {
            window.location.href = "<?= base_url() ?>laporan/laporanlabarugi/" + $('#date1').val() + "/" + $('#date2').val();
        })

        $('.printButton').click(function() {
            window.location.href = "<?= base_url() ?>laporan/cetaklaporanlabarugi/" + $('#date1').val() + "/" + $('#date2').val();
        })

    })
</script>