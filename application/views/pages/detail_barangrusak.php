<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Obat Rusak <strong>#<?= $barangrusak['id_barang_rusak'] ?></strong></h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Obat Rusak <strong>#<?= $barangrusak['id_barang_rusak'] ?></strong></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="invoice">
                        <div class="row justify-content-left mb-3">
                            <div class="col-lg-8 col-12 ">
                                <table>
                                    <tr>
                                        <td>Tanggal Transaksi</td>
                                        <td width="10%" align="center">:</td>
                                        <td>
                                            <?= date("d-F-Y", strtotime($barangrusak['tanggal_transaksi'])) ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="card shadow mb-4 col-12 p-0">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">List Obat Rusak</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" id="dataTableObat">
                                        <table class="table  table-bordered" width="100%" cellspacing="0">
                                            <thead class="bg-primary text-light">
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah</th>
                                                    <th>Satuan Obat</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detailJual">
                                                <?php
                                                foreach ($barangrusak_detail as $detail) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $detail['nama_obat'] ?></td>
                                                        <td><?= $detail['jumlah_rusak'] ?></td>
                                                        <td><?= $detail['nama_satuan_obat'] ?></td>
                                                        </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot class="bg-primary text-light">
                                                <tr>
                                                    <th colspan="">Total Obat Rusak</th>
                                                    <th><?= number_format($barangrusak['total_barangrusak'], 0, ",", ".") ?></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-5">
                        <div>
                            <a href="<?= base_url() ?>barangrusak">
                                <button class="btn btn-secondary mr-2">Kembali</button>
                            </a>
                            <a href="<?= base_url() ?>barangrusak/cetak_invoice_barangrusak/<?= $barangrusak['id_barang_rusak'] ?>" target="_blank"><button class="btn btn-primary mr-2" id="simpanPembelian"><i class="fa fa-print"></i> Cetak Invoice</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>