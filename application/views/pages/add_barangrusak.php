<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Barang Rusak</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Input Barang Rusak</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-5 col-12 ">
                            <table>
                                <tr>
                                    <td>Tanggal Transaksi</td>
                                    <td width="10%" align="center">:</td>
                                    <td>
                                        <div class="input-group">

                                            <input type="date" class="form-control" name="tanggal_transaksi" id="tanggal_transaksi" value="<?= date("Y-m-d") ?>">
                                            <!-- <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar-alt" for="tanggal_transaksi"></i></span>
                                            </div> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jam Transaksi</td>
                                    <td width="10%" align="center">:</td>
                                    <td>
                                        <div class="input-group">

                                            <input type="time" class="form-control" name="jam_transaksi" id="jam_transaksi" value="<?= date("h:i:s") ?>">
                                            <!-- <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar-alt" for="tanggal_transaksi"></i></span>
                                            </div> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        <a href="#" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mt-3"><i class="fas fa-plus fa-sm text-white "></i> Input Obat Rusak</a>
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
                                                <th>Jumlah Obat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailJual">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row justify-content-center mt-5">
                                    <div>
                                        <a href="<?=base_url()?>barangrusak" class="btn btn-danger mr-2">Batal</a>
                                        <button class="btn btn-primary mr-2" id="simpanBarangRusak">Simpan</button>
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
<div class="modal fade" id="ObatModal" tabindex="-1" role="dialog" aria-labelledby="ObatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ObatModalLabel">Tambah Obat Rusak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formObat" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_kategori">Pilih Obat</label>
                        <select name="id_obat" id="id_obat" class="form-control selectpicker" data-live-search="true">
                            <?php
                                                                                                                                            foreach ($listObat as $obat) {
                            ?>
                                <option value="<?= $obat['id_obat'] . "|" . $obat['nama_obat'] . "|" . $obat['nama_satuan_obat'] . "|" . $obat['stok'] ?>"><?= $obat['nama_obat'] ?></option>
                            <?php
                                                                                                                                                        }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="menu">Satuan Obat</label>
                        <input type="text" readonly name="satuan_obat" class="form-control" id="satuan_obat" placeholder="Pilih obat" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Stok Obat</label>
                        <input type="text" readonly name="current_stok" class="form-control" id="current_stok" placeholder="Pilih obat" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Jumlah Obat (Dalam satuan obat yang dipilih)</label>
                        <input type="number" name="jumlah_obat" class="form-control" id="jumlah_obat" placeholder="Cth : 10" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="addToKeranjang">Tambah Obat Rusak </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getListBarangRusak()

        $('#buttonAddNew').click(function(e) {
            $('#jumlah_obat').val(0)
            $('#ObatModal').modal('show')
        })

        function getListBarangRusak() {
            var keranjang_obat_rusak = JSON.parse(localStorage.getItem('keranjang_obat_rusak'));
            var list = '';
            var grandTotal = 0;
            if (keranjang_obat_rusak != null) {
                keranjang_obat_rusak.forEach(item => {
                    list += `
                        <tr>
                            <td>` + item['nama_obat'] + `</td>
                            <td>` + item['jumlah_obat'] + ' ' + item['satuan_obat'] + `</td>
                            <td><button class="btn btn-danger deleteItemCart" data-id_obat ="` + item['id_obat'] + `" data-nama_obat ="` + item['nama_obat'] + `" data-nama_satuan_obat ="` + item['satuan_obat'] + `" data-stok ="` + item['stok'] + `" data-harga_jual ="` + item['harga_jual'] + `" data-jumlah_obat ="` + item['jumlah_obat'] + `">Hapus</button></td>
                        </tr>
                    `
                    var current_obat = item['id_obat'] + "|" + item['nama_obat'] + "|" + item['satuan_obat'] + "|" + item['stok'];
                    grandTotal += parseInt(item['jumlah_obat']);
                });
                list += `
                        <tr class="bg-primary text-light">
                            <td >Total Barang Rusak</td>
                            <td>` + grandTotal + `</td><td></td></tr>`;
                $('#detailJual').html(list)
                $('.selectpicker').selectpicker('refresh')
            } else {
                $('#detailJual').html('<tr><td colspan="3" align="center">Item barang rusak kosong</td></tr>')
            }
            // Set satuan obat
            if ($("#id_obat").val() != null) {
                let currentObat = $("#id_obat").val().split("|");
                $('#satuan_obat').val(currentObat[2])
                $('#current_stok').val(currentObat[3])
                $('#harga_jual').val(currentObat[4])
            }


        }
        $(document).on('change', "#id_obat", function() {
            let currentObat = $(this).val().split("|");
            $('#satuan_obat').val(currentObat[2])
            $('#current_stok').val(currentObat[3])
            $('#harga_jual').val(currentObat[4])
        })
        $(document).on('click', "#addToKeranjang", function() {

            obat = $('#id_obat').val().split("|")
            console.log(obat)
            if ($('#jumlah_obat').val() == '') {
                swalError('Barang Rusak', 'Jumlah obat tidak boleh kosong')

            } else if (parseInt($('#jumlah_obat').val()) > parseInt($('#current_stok').val())) {
                swalError('Barang Rusak', 'Jumlah barang rusak melebihi stok yang tersedia')

            } else {
                var data = {
                    id_obat: obat[0],
                    nama_obat: obat[1],
                    satuan_obat: obat[2],
                    stok: obat[3],
                    harga_jual: $('#harga_jual').val(),
                    jumlah_obat: $('#jumlah_obat').val(),
                }
                var a;
                var newData = [];
                a = JSON.parse(localStorage.getItem('keranjang_obat_rusak'));
                if (a) {
                    a.forEach(itm => {
                        newData.push(itm)
                    });
                }
                newData.push(data)
                window.localStorage.setItem('keranjang_obat_rusak', JSON.stringify(newData));
                getListBarangRusak()
            }

        })
        /* Fungsi formatRupiah */
        function formatRupiah(angka) {
            var number_string = angka.toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }
            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return "Rp. " + rupiah;
        }
        $(document).on('click', ".deleteItemCart", function() {
            const id_obat = $(this).data('id_obat');
            const nama_obat = $(this).data('nama_obat');
            const nama_satuan_obat = $(this).data('nama_satuan_obat');
            const stok = $(this).data('stok');
            const harga_jual = $(this).data('harga_jual');
            const jumlah_obat = $(this).data('jumlah_obat');
            Swal.fire({
                title: "Are you sure?",
                text: 'Obat akan dihapus dari barang rusak apabila anda menekan tombol konfirmasi.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    // delete from cart
                    var newData = [];
                    var keranjang_obat_rusak = JSON.parse(localStorage.getItem('keranjang_obat_rusak'));
                    if (keranjang_obat_rusak) {
                        keranjang_obat_rusak.forEach(item => {
                            if (item['id_obat'] != id_obat || item['jumlah_obat'] != jumlah_obat) {
                                newData.push(item)
                            }
                        })
                    }
                    window.localStorage.setItem('keranjang_obat_rusak', JSON.stringify(newData));

                    $("#id_obat").append("<option value='" + id_obat + "|" + nama_obat + "|" + nama_satuan_obat + "|" + stok + "|" + harga_jual + "'>" + nama_obat + "</option>");
                    $('.selectpicker').selectpicker('refresh')
                    $('.loading').hide()
                    getListBarangRusak()
                }
            })
        })

        $(document).on('click', "#simpanBarangRusak", function() {

            var tanggal_transaksi = $('#tanggal_transaksi').val()
            var jam_transaksi = $('#jam_transaksi').val()
            var keranjang_obat_rusak = JSON.parse(localStorage.getItem('keranjang_obat_rusak'));
            grandTotal = 0;
            if (keranjang_obat_rusak.length > 0) {
                keranjang_obat_rusak.forEach(item => {
                    grandTotal += parseInt(item['jumlah_obat']);
                });
            } else {
                swalError('Barang Rusak', 'Keranjang kosong, masukkan item obat untuk melakukan input barang rusak ');
            }
            Swal.fire({
                title: "Apakah anda yakin menambah transaksi barang ini?",
                html: 'Transaksi barang rusak akan memperbaharui stok barang anda, Tekan confirm jika data sudah benar.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>barangrusak/add_barangrusak_action',
                        data: {
                            tanggal_transaksi: tanggal_transaksi,
                            jam_transaksi: jam_transaksi,
                            keranjang_obat_rusak: keranjang_obat_rusak,
                            total_barangrusak: grandTotal
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            console.log(data)
                            swalSuccess('Success', 'Berhasil membuat transaksi barang rusak')
                            window.localStorage.removeItem('keranjang_obat_rusak');
                            setTimeout(function() {
                                window.open('<?= base_url() ?>barangrusak/cetak_invoice_barangrusak/' + data, '_blank');
                                window.location.href = "<?= base_url() ?>barangrusak/";
                            }, 2000);
                            getListBarangRusak()
                        },
                        err(e) {
                            console.log(e)
                            $('.loading').hide()
                        }
                    })
                }
            })

        })
    })
</script>