<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Retur Obat Invoice <strong>#<?= $pembelian['id_pembelian'] ?></strong></h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Retur Obat Invoice<strong>#<?= $pembelian['id_pembelian'] ?></strong></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row justify-content-left mb-3">
                        <div class="col-lg-8 col-12 ">
                            <table>
                                <tr>
                                    <td width="50%">Nama Pemasok</td>
                                    <td width="10%" align="center">:</td>
                                    <td width="70%">
                                        <?= $pembelian['nama_supplier'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pembelian</td>
                                    <td width="10%" align="center">:</td>
                                    <td>
                                        <?= date("d-F-Y", strtotime($pembelian['tanggal_pembelian'])) ?>
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
                                                <th>Jumlah Barang yg Dibeli Sebelumnya</th>
                                                <th>Jumlah Barang yg Sudah Diretur</th>
                                                <th>Satuan Obat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailBeli">
                                            <?php
                                            foreach ($pembelian_detail as $detail) {
                                                $retur = $this->db->query("SELECT sum(jumlah_retur) as retur FROM retur_pembelian WHERE id_pembelian_detail = '".$detail['id_pembelian_detail']."' AND id_obat = '".$detail['id_obat']."'")->row_array();
                                                $total_retur = 0;
                                                if($retur['retur']){
                                                    $total_retur = $retur['retur'];
                                                }
                                                
                                            ?>
                                                <tr>
                                                    <td><?= $detail['nama_obat'] ?></td>
                                                    <td><?= $detail['jumlah_beli'] ?></td>
                                                    <td><?= $total_retur ?></td>
                                                    <td><?= $detail['nama_satuan_obat'] ?></td>
                                                    <td><button class="btn btn-sm btn-warning returObat" data-id_pembelian_detail="<?= $detail['id_pembelian_detail'] ?>" data-id_pembelian="<?= $pembelian['id_pembelian'] ?>">Retur Obat</button></td>
                                                </tr>
                                            <?php
                                                                                                                                                                                            }
                                            ?>
                                        </tbody>
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
<div class="modal fade" id="returModal" tabindex="-1" role="dialog" aria-labelledby="returModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returModalLabel">Retur Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formObat" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_kategori">Nama Obat</label>
                        <input type="hidden" class="form-control" readonly name="id_pembelian" id="id_pembelian">
                        <input type="hidden" class="form-control" readonly name="id_pembelian_detail" id="id_pembelian_detail">
                        <input type="hidden" class="form-control" readonly name="id_obat" id="id_obat">
                        <input type="text" class="form-control" readonly name="nama_obat" id="nama_obat">
                    </div>
                    <div class="form-group">
                        <label for="menu">Stok Obat Sekarang</label>
                        <input type="text" readonly name="current_stok" class="form-control" id="current_stok" required>
                        <input type="hidden" readonly name="stok" class="form-control" id="stok" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Jumlah Obat yg Dibeli Sebelumnya</label>
                        <input type="text" name="jumlah_beli" class="form-control" id="jumlah_beli" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Jumlah Obat yang Diretur (Dalam satuan terkecil obat)</label>
                        <input type="number" name="jumlah_retur" class="form-control" id="jumlah_retur" placeholder="Cth : 10" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Tanggal Retur</label>
                        <input type="date" name="tanggal_retur" class="form-control" id="tanggal_retur" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Jam Retur</label>
                        <input type="time" name="jam_retur" class="form-control" id="jam_retur" value="<?= date('h:i:s') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Keterangan Tambahan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="4">

                        </textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="returSubmit">Retur Obat </button>
                    </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', ".returObat", function() {
            const id_pembelian_detail = $(this).data('id_pembelian_detail');
            $.ajax({
                url: '<?= base_url() ?>pembelian/pembelian_detail_selected',
                data: {
                    id_pembelian_detail: id_pembelian_detail
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $('#id_pembelian_detail').val(data['id_pembelian_detail'])
                    $('#id_pembelian').val(data['id_pembelian'])
                    $('#nama_obat').val(data['nama_obat'])
                    $('#id_obat').val(data['id_obat'])
                    $('#current_stok').val(data['stok'] + ' ' + data['nama_satuan_obat'])
                    $('#stok').val(data['stok'])
                    $('#jumlah_beli').val(data['jumlah_beli'] + ' ' + data['nama_satuan_obat'])
                    $('#returModal').modal('show');
                    setTimeout(function() {
                        $('input[name="retur"]').focus()
                    }, 1000);

                },
                err(e) {
                    console.log(e)
                }
            })
        })
        $(document).on('click', "#returSubmit", function(e) {
            var id_pembelian_detail = $('#id_pembelian_detail').val()
            var id_pembelian = $('#id_pembelian').val()
            var id_obat = $('#id_obat').val()
            var current_stok = parseInt($('#current_stok').val())
            var stok = parseInt($('#stok').val())
            var jumlah_beli = parseInt($('#jumlah_beli').val())
            var jumlah_retur = parseInt($('#jumlah_retur').val())
            var keterangan = $('#keterangan').val()
            var tanggal_retur = $('#tanggal_retur').val()
            var jam_retur = $('#jam_retur').val()
            var retur = (jumlah_beli - jumlah_retur)
            if (jumlah_retur > stok) {
                swalError('Retur Pembelian', 'Jumlah barang yang diretur melebihi stok yang tersedia')
            }else if(jumlah_retur > jumlah_beli){
                swalError('Retur Pembelian', 'Jumlah barang yang diretur melebihi jumlah barang yang dibeli')
            }else{
                    
                if (jumlah_retur == '') {
                    swalError('Retur Pembelian', 'Jumlah barang yang baru tidak boleh kosong')
                } else {
                    $('#returModal').modal('hide');
                    Swal.fire({
                        title: "Apakah anda yakin meretur obat sebanyak " + jumlah_retur + "?",
                        html: 'Retur obat akan memperbaharui stok barang anda, Tekan confirm jika data sudah benar.',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Confirm!"
                    }).then((result) => {
                        if (result.value) {
                            $('.loading').show()
                            $.ajax({
                                url: '<?= base_url() ?>pembelian/retur_action',
                                data: {
                                    id_obat: id_obat,
                                    id_pembelian: id_pembelian,
                                    id_pembelian_detail: id_pembelian_detail,
                                    jumlah_retur: jumlah_retur,
                                    tanggal_retur: tanggal_retur,
                                    jam_retur: jam_retur,
                                    keterangan: keterangan
                                },
                                method: 'POST',
                                dataType: 'json',
                                success: function(data) {
                                    $('.loading').hide()
                                    console.log(data)
                                    swalSuccess('Success', 'Berhasil meretur obat')
                                    setTimeout(function() {
                                        window.location.href = "<?= base_url() ?>pembelian/";
                                    }, 2000);
                                },
                                err(e) {
                                    console.log(e)
                                    $('.loading').hide()
                                }
                            })
                        }

                    })
                }
            }

        })
    })
</script>