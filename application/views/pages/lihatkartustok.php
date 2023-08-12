<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 text-center">Kartu Stok "<?= $obat['nama_obat'] ?>"</h1>
    <input type="hidden" value="<?= $obat['id_obat'] ?>" name="id_obat" id="id_obat">
    <table style="width: 100%; border:none !important">
        <tr>
            <td style="text-align: center;    width: 100%">
                <p class="font4">
                    <br>Tanggal <?= date_format(date_create($date1), "d-F-Y") . " s/d " . date_format(date_create($date2), "d-F-Y"); ?></p>
            </td>
        </tr>

    </table>
    <a href="#" class="btn btn-primary mb-3 mt-2 printButton mr-3"><i class="fas fa-print"></i> Cetak Kartu Stok</a>
    <div class="row">
        <?php if ($report) { ?>
            <div class="col-xl-12 col-lg-12">

                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <div class="container p-3">
                        <table class="table table-striped table-bordered" id="table" style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Sisa</th>
                                    <th>Kasir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // echo var_dump($report);
                                $sisa = 0;
                                // echo var_dump(array_multi_subsort($report,'tanggal'));
                                foreach ($report as $row) {
                                    $beforesisa = $sisa;
                                    if( $row['masuk'] != 0){
                                        $sisa = $sisa +  $row['masuk'];
                                    }
                                    if( $row['keluar'] != 0){
                                        $sisa =  $sisa - $row['keluar'];
                                    }
                                    echo '
                                        <tr>
                                            <td>' . date_format(date_create($row['tanggal']), "d-m-Y h:i:s") . '</td>
                                            <td>' . wordwrap($row['keterangan'], 30, "<br />\n") ." - ".$row['masuk']."-".(int )$row['keluar']. '</td>
                                            <td> ' . number_format($row['masuk'], 0, ",", ".") . ' ' . $obat['nama_satuan_obat'] . '</td>
                                            <td> ' . number_format($row['keluar'], 0, ",", ".") . ' ' . $obat['nama_satuan_obat'] . '</td>
                                            <td> ' . number_format($sisa, 0, ",", ".") . ' ' . $obat['nama_satuan_obat'] . '</td>
                                            <td>' . $row['kasir'] . '</td>
                                            </tr>
                                        ';
                                }
                                ?>
                            </tbody>
                            <tfoot class="bg-primary text-white">
                                <tr style="border:1px solid black;background-color: #521746;color:#fff">
                                    <th colspan="5">Sisa Stok Per Tanggal <?= date_format(date_create($date2), "d-F-Y"); ?></th>
                                    <th> <?= number_format($sisa, 0, ",", ".") ?> <?= $obat['nama_satuan_obat'] ?> </th>
                                </tr>
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
        // $('#table').DataTable( {
        //     "order": [[ 0, "asc" ]]
        // } );
        $('#filterButton').click(function() {
            window.location.href = "<?= base_url() ?>kartustok/laporanlabarugi/" + $('#date1').val() + "/" + $('#date2').val();
        })

        $('.printButton').click(function() {
            window.location.href = "<?= base_url() ?>kartustok/cetakkartustok/" + $('#id_obat').val() + "/" + $('#date1').val() + "/" + $('#date2').val();

        })
    })
</script>