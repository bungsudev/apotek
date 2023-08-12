<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 text-center">Laporan Pembelian</h1>
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
                                    <th>Id Pembelian</th>
                                    <th>Nama Supplier</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Total Pembelian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $total = 0;
                                    foreach ($report as $row) {
                                        echo '
                                        <tr>
                                        <td>' . $row['id_pembelian'] . '</td>
                                        <td>' . $row['nama_supplier'] . '</td>
                                        <td>' . date("d-F-Y", strtotime($row['tanggal_pembelian'])) . ' ' . $row['jam_pembelian'] . '</td>
                                        <td> Rp.' . number_format($row['total_pembelian'], 0, ",", ".") . '</td>
                                    </tr>
                                        ';
                                        $total += $row['total_pembelian'];
                                    }
                                    ?>
                            </tbody>
                            <tfoot class="bg-primary text-white">
                                <tr>
                                    <th colspan="3">Total Pembelian</th>
                                    <th> Rp <?= number_format($total, 0, ",", ".")  ?> </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        <?php } else { ?>
            <div class="col-xl-12 col-lg-12">
                <div class="alert alert-warning">
                    Maaf data penjualan tanggal
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
            window.location.href = "<?= base_url() ?>laporan/laporanpembelian/" + $('#date1').val() + "/" + $('#date2').val();
        })

        $('.printButton').click(function() {
            window.location.href = "<?= base_url() ?>laporan/cetaklaporanpembelian/" + $('#date1').val() + "/" + $('#date2').val();
        })

    })
</script>