<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pembelian</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Buat Pembelian</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-6 col-12 ">
                            <table>
                                <tr class="mb-2">
                                    <td width="30%">Nama Pemasok</td>
                                    <td width="10%" align="center">:</td>
                                    <td width="60%">
                                        <select class="form-control selectpicker" data-live-search="true" name="id_supplier" id="id_supplier">
                                            <?php
                                            foreach ($listSupplier as $supplier) {
                                                ?>
                                                <option value="<?= $supplier['id_supplier'] . "|" . $supplier['nama_supplier'] ?>"><?= $supplier['nama_supplier'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Penjual / Kasir</td>
                                    <td width="10%" align="center">:</td>
                                    <td width="70%">
                                        <input type="text" name="nama_pembeli" class="form-control" id="nama_pembeli" value="<?= $_SESSION['apotek_username'] ?>" placeholder="Nama Penjual" readonly required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pembelian</td>
                                    <td width="10%" align="center">:</td>
                                    <td>
                                        <div class="input-group">

                                            <input type="date" class="form-control" name="tanggal_pembelian" id="tanggal_pembelian" value="<?= date("Y-m-d") ?>">
                                            <!-- <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar-alt" for="tanggal_pembelian"></i></span>
                                            </div> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jam Pembelian</td>
                                    <td width="10%" align="center">:</td>
                                    <td>
                                        <div class="input-group">

                                            <input type="time" class="form-control" name="jam_pembelian" id="jam_pembelian" value="<?= date("h:i:s") ?>">
                                            <!-- <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar-alt" for="tanggal_penjualan"></i></span>
                                            </div> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        <a href="#" data-toggle="modal" data-target="#ObatModal" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mt-3"><i class="fas fa-plus fa-sm text-white "></i> Tambah Pembelian Obat</a>
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
                                                <th>Jumlah Barang (Dalam Satuan Obat)</th>
                                                <th>Satuan Obat</th>
                                                <th>Nomor Batch</th>
                                                <th>Expired Date</th>
                                                <th>Harga Beli</th>
                                                <th>Diskon</th>
                                                <th>PPN</th>
                                                <th>Sub Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailBeli">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row justify-content-center mt-5">
                                    <div>
                                        <button class="btn btn-danger mr-2">Batal</button>
                                        <button class="btn btn-primary mr-2" id="simpanPembelian">Simpan Pembelian</button>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ObatModalLabel">Tambah Pembelian Obat</h5>
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
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="menu">Satuan Obat</label>
                            <input type="text" readonly name="satuan_obat" class="form-control" id="satuan_obat" placeholder="Pilih obat" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="menu">Stok Obat Sekarang</label>
                            <input type="text" readonly name="current_stok" class="form-control" id="current_stok" placeholder="Pilih obat" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="menu">Nomor Batch Obat</label>
                            <input type="text" max_length="20" name="nomor_batch" class="form-control" id="nomor_batch" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="menu">Expired Date</label>
                            <input type="date" value="<?= date('Y-m-d') ?>" name="expired_date" class="form-control" id="expired_date" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="menu">Jumlah Obat (Dalam satuan obat terkecil)</label>
                            <input type="number" name="jumlah_beli" class="form-control" id="jumlah_beli" placeholder="Cth : 10" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="menu">Harga Beli (Harga sebelum diskon)</label>
                            <input type="number" name="harga_beli" class="form-control" id="harga_beli" placeholder="Cth : 10.000" required>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="menu">Diskon (jika tidak ada isi dengan 0)</label>
                        <input type="number" name="diskon" class="form-control" id="diskon" placeholder="Cth : 10.000" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">PPN (jika tidak ada isi dengan 0)</label>
                        <input type="number" name="ppn" class="form-control" id="ppn" placeholder="Cth : 10.000" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="menu" class="text-primary">Total Harga Obat</label>
                        <input type="text" name="total_obat" class="form-control border-primary bg-primary text-light" id="total_obat" required readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addToKeranjang">Tambah Pembelian </button>
                    </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getListPembelian()

        function getListPembelian() {
            var keranjang_pembelian = JSON.parse(localStorage.getItem('keranjang_pembelian'));
            var list = '';
            var grandTotal = 0;
            if (keranjang_pembelian != null) {
                keranjang_pembelian.forEach(item => {
                    list += `
                        <tr>
                            <td>` + item['nama_obat'] + `</td>
                            <td>` + item['jumlah_beli'] + `</td>
                            <td>` + item['satuan_obat'] + `</td>
                            <td>` + item['nomor_batch'] + `</td>
                            <td>` + item['expired_date'] + `</td>
                            <td>` + formatRupiah(parseInt(item['harga_beli'])) + `</td>
                            <td> -` + formatRupiah(parseInt(item['diskon'])) + `</td>
                            <td>` + formatRupiah(parseInt(item['ppn'])) + `</td>
                            <td>` + formatRupiah(parseInt(item['ppn']) + parseInt(item['harga_beli']) - parseInt(item['diskon'])) + `</td>
                            <td><button class="btn btn-danger deleteItemCart" data-id_obat ="` + item['id_obat'] + `" data-nama_obat ="` + item['nama_obat'] + `" data-nama_satuan_obat ="` + item['satuan_obat'] + `" data-stok ="` + item['stok'] + `" data-jumlah_beli ="` + item['jumlah_beli'] + `" data-expired_date ="` + item['expired_date'] + `">Hapus</button></td>
                        </tr>
                    `
                    var current_obat = item['id_obat'] + "|" + item['nama_obat'] + "|" + item['satuan_obat'] + "|" + item['stok'];
                    grandTotal += parseInt(item['ppn']) + parseInt(item['harga_beli']) - parseInt(item['diskon']);

                });
                list += `
                        <tr class="bg-primary text-light">
                            <td  colspan="8">Total Pembelian</td>
                            <td>` + formatRupiah(grandTotal) + `</td><td></td></tr>`;
                $('#detailBeli').html(list)
                $('.selectpicker').selectpicker('refresh')
            } else {
                $('#detailBeli').html('<tr><td colspan="9" align="center">Item pembelian kosong</td></tr>')
            }
            // Set satuan obat
            if ($("#id_obat").val() != null) {
                let currentObat = $("#id_obat").val().split("|");
                $('#satuan_obat').val(currentObat[2])
                $('#current_stok').val(currentObat[3])
            }


        }
        $(document).on('change', "#id_obat", function() {
            let currentObat = $(this).val().split("|");
            $('#satuan_obat').val(currentObat[2])
            $('#current_stok').val(currentObat[3])
        })
        $(document).on('change', "#id_obat", function() {
            let currentObat = $(this).val().split("|");
            $('#satuan_obat').val(currentObat[2])
            $('#current_stok').val(currentObat[3])
            $('#harga_beli').val(currentObat[4])
            $('#sample_harga_beli').val(formatRupiah(currentObat[4]))
        })
        $(document).on('keyup', "#harga_beli", function() {
            var diskon = $('#diskon').val()
            if (diskon == '') {
                diskon = 0
            }
            var ppn = $('#ppn').val()
            if (ppn == '') {
                ppn = 0
            }
            var total = parseInt($('#harga_beli').val()) + parseInt(ppn) - parseInt(diskon)
            $('#total_obat').val(formatRupiah(total))
        })
        $(document).on('keyup', "#diskon", function() {
            var diskon = $('#diskon').val()
            if (diskon == '') {
                diskon = 0
            }
            var ppn = $('#ppn').val()
            if (ppn == '') {
                ppn = 0
            }
            var total = parseInt($('#harga_beli').val()) + parseInt(ppn) - parseInt(diskon)
            $('#total_obat').val(formatRupiah(total))
        })
        $(document).on('keyup', "#ppn", function() {
            var diskon = $('#diskon').val()
            if (diskon == '') {
                diskon = 0
            }
            var ppn = $('#ppn').val()
            if (ppn == '') {
                ppn = 0
            }
            var total = parseInt($('#harga_beli').val()) + parseInt(ppn) - parseInt(diskon)
            $('#total_obat').val(formatRupiah(total))
        })
        $(document).on('click', "#addToKeranjang", function() {

            obat = $('#id_obat').val().split("|")
            if ($('#harga_beli').val() == '') {
                swalError('Pembelian', 'Harga tidak boleh kosong')
            } else if ($('#jumlah_beli').val() == '') {
                swalError('Pembelian', 'Jumlah beli tidak boleh kosong')

            } else {
                if ($('#diskon').val() == '') {
                    $('#diskon').val('0')
                }
                if ($('#ppn').val() == '') {
                    $('#ppn').val('0')
                }
                var data = {
                    id_obat: obat[0],
                    nama_obat: obat[1],
                    satuan_obat: obat[2],
                    stok: obat[3],
                    harga_beli: $('#harga_beli').val(),
                    expired_date: $('#expired_date').val(),
                    nomor_batch: $('#nomor_batch').val(),
                    jumlah_beli: $('#jumlah_beli').val(),
                    ppn: $('#ppn').val(),
                    diskon: $('#diskon').val(),
                }
                var a;
                var newData = [];
                a = JSON.parse(localStorage.getItem('keranjang_pembelian'));
                if (a) {
                    a.forEach(itm => {
                        newData.push(itm)
                    });
                }
                newData.push(data)
                window.localStorage.setItem('keranjang_pembelian', JSON.stringify(newData));
                getListPembelian()
                $('#harga_beli').val(0)
                $('#jumlah_beli').val(0)
                $('#ppn').val(0)
                $('#ObatModal').modal('toggle')
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
            const jumlah_beli = $(this).data('jumlah_beli');
            const expired_date = $(this).data('expired_date');

            Swal.fire({
                title: "Are you sure?",
                text: 'Obat akan dihapus dari pembelian apabila anda menekan tombol konfirmasi.',
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
                    var keranjang_pembelian = JSON.parse(localStorage.getItem('keranjang_pembelian'));
                    if (keranjang_pembelian) {
                        keranjang_pembelian.forEach(item => {
                            if (item['id_obat'] != id_obat || item['jumlah_beli'] != jumlah_beli || item['expired_date'] != expired_date) {
                                newData.push(item)
                            }
                        })
                    }
                    window.localStorage.setItem('keranjang_pembelian', JSON.stringify(newData));

                    $("#id_obat").append("<option value='" + id_obat + "|" + nama_obat + "|" + nama_satuan_obat + "|" + stok + "'>" + nama_obat + "</option>");
                    $('.selectpicker').selectpicker('refresh')
                    $('.loading').hide()
                    getListPembelian()
                }
            })
        })

        $(document).on('click', "#simpanPembelian", function() {
            var supplier = $('#id_supplier').val().split("|")
            var tanggal_pembelian = $('#tanggal_pembelian').val()
            var jam_pembelian = $('#jam_pembelian').val()
            var nama_pembeli = $('#nama_pembeli').val()
            var keranjang_pembelian = JSON.parse(localStorage.getItem('keranjang_pembelian'));
            grandTotal = 0;
            if (keranjang_pembelian.length > 0) {
                keranjang_pembelian.forEach(item => {
                    grandTotal += parseInt(item['ppn']) + parseInt(item['harga_beli']) - parseInt(item['diskon']);
                });
            }
		console.log(grandTotal)
console.log(nama_pembeli)
            Swal.fire({
                title: "Apakah anda yakin menambah pembelian ini?",
                html: 'Pembelian akan memperbaharui stok barang anda, Tekan confirm jika data sudah benar.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>pembelian/add_pembelian_action',
                        data: {
                            supplier: supplier,
                            tanggal_pembelian: tanggal_pembelian,
                            
                            nama_pembeli: nama_pembeli,
                            jam_pembelian: jam_pembelian,
                            total_pembelian: grandTotal,
keranjang_pembelian: keranjang_pembelian,
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            console.log(data)
                            <!-- 
				swalSuccess('Success', 'Berhasil membuat pembelian')
                            window.localStorage.removeItem('keranjang_pembelian');
                            setTimeout(function() {
                                window.open("<?= base_url() ?>pembelian/cetak_invoice_pembelian/" + data, '_blank');

                                window.location.href = "<?= base_url() ?>pembelian/cetak_invoice_pembelian/" + data;
                            }, 2000);
                            getListPembelian() 
				-->
                        },
                        error(e) {
                            console.log(e)
                            $('.loading').hide()
                        }
                    })
                }
            })
        })
    })
</script>