<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pembelian <strong>#<?= $pembelian['id_pembelian'] ?></strong></h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Pembelian <strong>#<?= $pembelian['id_pembelian'] ?></strong></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row justify-content-left mb-3">
                        <div class="col-lg-12 col-12 ">
                            <table>
                                <tr>
                                    <td width="50%">Nama Pemasok</td>
                                    <td width="10%" align="center">:</td>
                                    <td width="40%">
                                        <?= $pembelian['nama_supplier'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pembelian</td>
                                    <td width="10%" align="center">:</td>
                                    <td>
                                        <?= date("d-F-Y", strtotime($pembelian['tanggal_pembelian'])) . ' ' . $pembelian['jam_pembelian'] ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="card shadow mb-4 col-12 p-0">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">List Pembelian Obat</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="dataTableObat">
                                    <table class="table  table-bordered" width="100%" cellspacing="0">
                                        <thead class="bg-primary text-light">
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Jumlah Beli</th>
                                                <th>Satuan Obat</th>
                                                <th>Harga Beli</th>
                                                <th>Nomor Batch</th>
                                                <th>Expired Date</th>
                                                <th>Diskon</th>
                                                <th>PPN</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailBeli">
                                            <?php
                                            foreach ($pembelian_detail as $detail) {
                                                ?>
                                                <tr>
                                                    <td><?= $detail['nama_obat'] ?></td>
                                                    <td><?= $detail['jumlah_beli'] ?></td>
                                                    <td><?= $detail['nama_satuan_obat'] ?></td>
                                                    <td>Rp. <?= number_format($detail['harga_beli']) ?></td>
                                                    <td><?= $detail['nomor_batch'] ?></td>
                                                    <td><?= date("d-F-Y", strtotime($detail['expired_date'])) ?></td>
                                                    <td>Rp. <?= number_format($detail['diskon']) ?></td>
                                                    <td>Rp. <?= number_format($detail['ppn']) ?></td>
                                                    <td>Rp. <?= number_format($detail['ppn'] + $detail['harga_beli'] - $detail['diskon'], 0, ",", ".") ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot class="bg-primary text-light">
                                            <tr>
                                                <th colspan="8">Total Pembelian</th>
                                                <th>Rp. <?= number_format($pembelian['total_pembelian']) ?></th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="row justify-content-center mt-5">
                                    <div>
                                        <a href="<?= base_url() ?>pembelian">
                                            <button class="btn btn-secondary mr-2">Kembali</button>
                                        </a>
                                        <a href="<?= base_url() ?>pembelian/cetak_invoice_pembelian/<?= $pembelian['id_pembelian'] ?>" target="_blank"><button class="btn btn-primary mr-2" id="simpanPembelian"><i class="fa fa-print"></i> Cetak Invoice</button></a>
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