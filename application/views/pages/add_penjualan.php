<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Penjualan</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Buat Penjualan</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-8 col-12 ">
                            <table>
                                <tr>
                                    <td>Nama Penjual / Kasir</td>
                                    <td width="10%" align="center">:</td>
                                    <td width="70%">
                                        <input type="text" name="nama_pembeli" class="form-control" id="nama_pembeli" value="<?= $_SESSION['apotek_username'] ?>" placeholder="Nama Penjual" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Penjualan</td>
                                    <td width="10%" align="center">:</td>
                                    <td>
                                        <div class="input-group">

                                            <input type="date" class="form-control" name="tanggal_penjualan" id="tanggal_penjualan" value="<?= date("Y-m-d") ?>">
                                            <!-- <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar-alt" for="tanggal_penjualan"></i></span>
                                            </div> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jam Penjualan</td>
                                    <td width="10%" align="center">:</td>
                                    <td>
                                        <div class="input-group">

                                            <input type="time" class="form-control" name="jam_penjualan" id="jam_penjualan" value="<?= date("h:i:s") ?>">
                                            <!-- <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar-alt" for="tanggal_penjualan"></i></span>
                                            </div> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        <a href="#" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mt-3"><i class="fas fa-plus fa-sm text-white "></i> Tambah Penjualan Obat</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="card shadow mb-4 col-12 p-0">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">List Penjualan Obat</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="dataTableObat">
                                    <table class="table  table-bordered" id="list_keranjang" width="100%" cellspacing="0">
                                        <thead class="bg-primary text-light">
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Jumlah Jual</th>
                                                <th>Harga Jual</th>
                                                <th>Harga Obat</th>
                                                <th>Diskon</th>
                                                <th>PPN</th>
                                                <th>Sub Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailJual">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row justify-content-center mt-5">
                                    <div>
                                        <button class="btn btn-danger mr-2">Batal</button>
                                        <button class="btn btn-primary mr-2" id="simpanPenjualan">Simpan Penjualan</button>
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
                <h5 class="modal-title" id="ObatModalLabel">Tambah Penjualan Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formObat" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-1 pt-3">
                            <span id="color_obat" class="p-3 float-right mt-3" style="margin-top:auto;background:blue;width:40px;height:40px;border-radius:50%" >&nbsp;</span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="id_kategori">Pilih Obat</label>
                            <select name="id_obat" id="id_obat" class="form-control selectpicker" data-live-search="true">
                                <option value="">-- Pilih Obat --</option>
                                <?php
                                                                                                                                            foreach ($listObat as $obat) {
                                ?>
                                    <option value="<?= $obat['id_obat'] . "|" . $obat['nama_obat'] . "|" . $obat['nama_satuan_obat'] . "|" . $obat['stok']. "|" . $obat['tipe_obat']  ?>"><?= $obat['nama_obat'] ?></option>
                                <?php
                                                                                                                                                            }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="menu">Stok Obat</label>
                            <input type="text" readonly name="stok" class="form-control" id="stok">
                            <input type="text" hidden readonly name="current_stok" class="form-control" id="current_stok">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="id_satuan">Satuan Obat</label>
                            <select name="id_satuan" id="id_satuan" class="form-control selectpicker" data-live-search="true">
                                <option value="">--Pilih Satuan Obat--</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="menu">Jumlah Obat (Dalam satuan obat yang dipilih)</label>
                            <input type="number" name="jumlah_jual" class="form-control" id="jumlah_jual" placeholder="Cth : 10">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="menu">Harga Jual</label>
                        <input type="text" name="sample_harga_jual" class="form-control" id="sample_harga_jual" placeholder="Cth : 10.000" readonly>
                        <input type="hidden" name="harga_jual" class="form-control" id="harga_jual" placeholder="Cth : 10.000" readonly>
                    </div>

                    <div class="form-group">
                        <label for="menu">Diskon (jika tidak ada isi dengan 0)</label>
                        <input type="number" name="diskon" class="form-control" id="diskon" placeholder="Cth : 10.000" value="0">
                    </div>
                    <div class="form-group">
                        <label for="menu">PPN (jika tidak ada isi dengan 0)</label>
                        <input type="number" name="ppn" class="form-control" id="ppn" placeholder="Cth : 10.000" value="0">
                    </div>
                    <div class="form-group">
                        <label for="menu" class="text-primary">Total Harga Obat</label>
                        <input type="text" name="total_obat" class="form-control border-primary bg-primary text-light" id="total_obat" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="addToKeranjang">Tambah Penjualan </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        
        function hitungTotal() {
            var diskon = $('#diskon').val()
            if (diskon == '') {
                diskon = 0
            }
            var ppn = $('#ppn').val()
            if (ppn == '') {
                ppn = 0
            }
            var jumlah_jual = parseInt($('#jumlah_jual').val())
            if (jumlah_jual == '') {
                jumlah_jual = 0
            }
            var harga_jual = parseInt($('#harga_jual').val())
            if (harga_jual == '') {
                harga_jual = 0
            }

            var total = (jumlah_jual * harga_jual) + parseInt(ppn) - parseInt(diskon)
            $('#total_obat').val(formatRupiah(total))
        }

        getListPenjualan()

        $('#buttonAddNew').click(function(e) {
            $('#jumlah_jual').val(0)
            $('#diskon').val(0)
            $('#ppn').val(0)
            $('#total_obat').val(0)
            $('#ObatModal').modal('show')
        })

        function getListPenjualan() {
            var list = '';
            var grandTotal = 0;
            var keranjang_penjualan = JSON.parse(localStorage.getItem('keranjang_penjualan'));

            if (keranjang_penjualan != null) {
                keranjang_penjualan.forEach(item => {
                        var tipe = ' <span   style="margin-top:auto;color:blue;font-weight:bold;" >'+item['nama_obat']+'</span>';
                        if(item['tipe_obat'] == 'Obat Bebas Terbatas'){
                            tipe = ' <span   style="margin-top:auto;color:greenfont-weight:bold;;" >'+item['nama_obat']+'</span>';
                        }else if(item['tipe_obat'] == 'Obat Keras'){
                            tipe = ' <span   style="margin-top:auto;color:red;wfont-weight:bold;" >'+item['nama_obat']+'</span>';
                        }
                    list += `
                        <tr>
                            <td>` +tipe + `</td>
                            <td>` + item['jumlah_jual'] + ' ' + item['satuan_obat'] + `</td>
                            <td>` + formatRupiah(parseInt(item['harga_jual'])) + `</td>
                            <td>` + formatRupiah(parseInt(item['harga_jual'] * item['jumlah_jual'])) + `</td>
                            <td> -` + formatRupiah(parseInt(item['diskon'])) + `</td>
                            <td>` + formatRupiah(parseInt(item['ppn'])) + `</td>
                            <td>` + formatRupiah(parseInt(item['ppn']) + parseInt(item['harga_jual'] * item['jumlah_jual']) - parseInt(item['diskon'])) + `</td>
                            <td><button class="btn btn-danger deleteItemCart" data-id_obat ="` + item['id_obat'] + `" data-nama_obat ="` + item['nama_obat'] + `" data-nama_satuan_obat ="` + item['satuan_obat'] + `" data-stok ="` + item['stok'] + `" data-id_satuan ="` + item['id_satuan'] + `" data-harga_jual ="` + item['harga_jual'] + `" data-jumlah_jual ="` + item['jumlah_jual'] + `" data-diskon ="` + item['diskon'] + `" data-ppn ="` + item['ppn'] + `">Hapus</button></td>
                        </tr>
                    `
                    var current_obat = item['id_obat'] + "|" + item['nama_obat'] + "|" + item['satuan_obat'] + "|" + item['stok'];
                    console.log(current_obat)
                    grandTotal += parseInt(item['ppn']) + (parseInt(item['harga_jual']) * parseInt(item['jumlah_jual'])) - parseInt(item['diskon']);
                    // $("#id_obat option[value='" + current_obat + "']").remove();
                    // $('.selectpicker').selectpicker('refresh')

                });
                list += `
                        <tr class="bg-primary text-light">
                            <td  colspan="6">Total Penjualan</td>
                            <td>` + formatRupiah(grandTotal) + `</td><td></td></tr>`;
                $('#detailJual').html(list)
                
                $('.selectpicker').selectpicker('refresh')
            } else {
                $('#detailJual').html('<tr><td colspan="9" align="center">Item penjualan kosong</td></tr>')
            }
            
            // Set satuan obat
            if ($("#id_obat").val() != null && $('#id_obat').val() != '') {
                let currentObat = $("#id_obat").val().split("|");
                $('#satuan_obat').val(currentObat[2])
                $('#current_stok').val(currentObat[3])
                var keranjang_penjualan = JSON.parse(localStorage.getItem('keranjang_penjualan'));
                if (keranjang_penjualan != null) {
                    keranjang_penjualan.forEach(item => {

                    })
                }
                $('#stok').val(currentObat[3] + " " + currentObat[2])
                $('#harga_jual').val(0)
                $('#sample_harga_jual').val(formatRupiah(0))

                $.ajax({
                    url: '<?= base_url() ?>penjualan/get_satuan_by_obat',
                    data: {
                        id_obat: currentObat[0]
                    },
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#id_satuan').html(data)
                        $('.selectpicker').selectpicker('refresh')

                    },
                    error(e) {
                        console.log(e)
                    }
                })
            } else {
                $('#satuan_obat').val('')
                $('#current_stok').val('')
                $('#stok').val('')
            }


        }

        // Munculkan Satuan yang tersedia

        $(document).on('change', "#id_obat", function() {
            let currentObat = $(this).val().split("|");
            $('#satuan_obat').val(currentObat[2])
            $('#harga_jual').val(0)
            $('#jumlah_jual').val(0)
            $('#total_obat').val(0)
            $('#ppn').val(0)
            $('#diskon').val(0)
            $('#sample_harga_jual').val(formatRupiah(0))
            if ($('#id_obat').val() != '') {
                $.ajax({
                    url: '<?= base_url() ?>penjualan/get_satuan_by_obat',
                    data: {
                        id_obat: currentObat[0]
                    },
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#id_satuan').html(data)
                        $('.selectpicker').selectpicker('refresh')

                    },
                    error(e) {
                        console.log(e)
                    }
                })
                $.ajax({
                    url: '<?= base_url() ?>obat/obat_selected',
                    data: {
                        id_obat: currentObat[0]
                    },
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        $('#current_stok').val(data['stok'])
                        $('#stok').val(data['stok'] + " " + currentObat[2])
                    }
                })
            } else {
                $('#satuan_obat').val('')
                $('#current_stok').val('')
                $('#stok').val('')
            }

        })

        $(document).on('change', "#id_satuan", function() {
            let currentObat = $('#id_obat').val().split("|");
            splitSatuan = $('#id_satuan').val().split("|")
            let satuanObat = splitSatuan[0];
            let jumlah = $('#jumlah_jual').val()
            console.log(jumlah)
            if (parseInt(jumlah) > 0) {
                $.ajax({
                    url: '<?= base_url() ?>penjualan/getHargaObat',
                    data: {
                        id_obat: currentObat[0],
                        id_satuan: satuanObat,
                        jumlah: jumlah
                    },
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        if(data){
                            $('#harga_jual').val(parseInt(data['harga']))
                            $('#sample_harga_jual').val(formatRupiah($('#harga_jual').val()))
                            $('#jumlah_jual').val(0)
                            $('#total_obat').val(0)
                            $('#ppn').val(0)
                            $('#diskon').val(0)
                        }else{
                            swalError("Error","Harga obat belum diinput")
                            $('#id_obat').val('')
                            $('#id_satuan').val('')
                            $('.selectpicker').selectpicker('refresh')
                        }
                    },
                    error(e) {
                        console.log(e)
                    }
                })
            } else {
                $('#harga_jual').val(0)
                $('#sample_harga_jual').val(formatRupiah(0))

            }

        })

        $(document).on('keyup change', "#jumlah_jual", function() {


            let currentObat = $('#id_obat').val().split("|");
            splitSatuan = $('#id_satuan').val().split("|")
            let satuanObat = splitSatuan[0];
            let jumlah = $('#jumlah_jual').val()
            console.log(jumlah)
            if (parseInt(jumlah) > 0) {
                $.ajax({
                    url: '<?= base_url() ?>penjualan/getHargaObat',
                    data: {
                        id_obat: currentObat[0],
                        id_satuan: satuanObat,
                        jumlah: jumlah
                    },
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        if(data){
                            $('#harga_jual').val(parseInt(data['harga']))
                            $('#sample_harga_jual').val(formatRupiah($('#harga_jual').val()))
                            // $('#jumlah_jual').val(0)
                            // $('#total_obat').val(0)
                            // $('#ppn').val(0)
                            // $('#diskon').val(0)
                        }else{
                            

                            swalError("Error","Harga obat belum diinput")
                            $('#id_obat').val('')
                            $('#id_satuan').val('')
                            $('.selectpicker').selectpicker('refresh')
                        }
                    },
                    error(e) {
                        console.log(e)
                    }
                })
                hitungTotal()

            } else {
                $('#harga_jual').val(0)
                $('#sample_harga_jual').val(formatRupiah(0))
                hitungTotal()
            }

        })
        $(document).on('keyup change', "#diskon", function() {
            hitungTotal()
        })
        $(document).on('keyup change', "#ppn", function() {
            hitungTotal()
        })
        $(document).on('click', "#addToKeranjang", function() {

            obat = $('#id_obat').val().split("|")
            splitSatuan = $('#id_satuan').val().split("|")
            let satuanObat = splitSatuan[0];
            // get total in satuan
            realStok = 0;
            var keranjang_penjualan = JSON.parse(localStorage.getItem('keranjang_penjualan'));
            if (keranjang_penjualan) {
                keranjang_penjualan.forEach(item => {
                    $.ajax({
                        url: '<?= base_url() ?>obat/obat_selected',
                        data: {
                            id_obat: item['id_obat']
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            if (data['id_satuan_konversi_1'] == satuanObat) {
                                realStok = (parseInt($('#jumlah_jual').val()) * data['jumlah_konversi_1']);
                            } else if (data['id_satuan_konversi_2'] == satuanObat) {
                                realStok = (parseInt($('#jumlah_jual').val()) * data['jumlah_konversi_2']);
                            } else {
                                realStok = parseInt($('#jumlah_jual').val());
                            }
                            console.log(realStok)
                        }
                    })
                })
            }
            $.ajax({
                url: '<?= base_url() ?>obat/obat_selected',
                data: {
                    id_obat: obat[0]
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    if (data['id_satuan_konversi_1'] == satuanObat) {
                        realStok = (parseInt($('#jumlah_jual').val()) * data['jumlah_konversi_1']);
                    } else if (data['id_satuan_konversi_2'] == satuanObat) {
                        realStok = (parseInt($('#jumlah_jual').val()) * data['jumlah_konversi_2']);
                    } else {
                        realStok = parseInt($('#jumlah_jual').val());
                    }
                    console.log(realStok)
                    // Tambahkan sama yg dikeranjang

                    if ($('#harga_jual').val() == '') {
                        swalError('Penjualan', 'Harga tidak boleh kosong')
                    } else if ($('#jumlah_jual').val() == '') {
                        swalError('Penjualan', 'Jumlah jual tidak boleh kosong')

                    } else if (parseInt(realStok) > parseInt($('#current_stok').val())) {
                        swalError('Penjualan', 'Stok tidak cukup')
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
                            tipe_obat:obat[4],
                            id_satuan: splitSatuan[0],
                            satuan_obat: splitSatuan[1],
                            stok: obat[3],
                            harga_jual: $('#harga_jual').val(),
                            jumlah_jual: $('#jumlah_jual').val(),
                            ppn: $('#ppn').val(),
                            diskon: $('#diskon').val(),
                        }
                        var a;
                        var newData = [];
                        a = JSON.parse(localStorage.getItem('keranjang_penjualan'));
                        if (a) {
                            a.forEach(itm => {
                                newData.push(itm)
                            });
                        }
                        newData.push(data)
                        window.localStorage.setItem('keranjang_penjualan', JSON.stringify(newData));
                        getListPenjualan()

                        // var current_obat = $("#id_obat option:selected").remove();
                        // $('.selectpicker').selectpicker('refresh')
                    }
                }
            })


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
            const id_satuan = $(this).data('id_satuan');
            const stok = $(this).data('stok');
            const harga_jual = $(this).data('harga_jual');
            const jumlah_jual = $(this).data('jumlah_jual');
            const diskon = $(this).data('diskon');
            const ppn = $(this).data('ppn');
            Swal.fire({
                title: "Are you sure?",
                text: 'Obat akan dihapus dari penjualan apabila anda menekan tombol konfirmasi.',
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
                    var keranjang_penjualan = JSON.parse(localStorage.getItem('keranjang_penjualan'));
                    if (keranjang_penjualan) {
                        keranjang_penjualan.forEach(item => {
                            if (item['id_obat'] != id_obat || item['jumlah_jual'] != jumlah_jual || item['diskon'] != diskon || item['ppn'] != ppn || item['id_satuan'] != id_satuan) {
                                newData.push(item)
                            }
                        })
                    }
                    window.localStorage.setItem('keranjang_penjualan', JSON.stringify(newData));
                    $('.loading').hide()
                    getListPenjualan()
                }
            })
        })

        $(document).on('click', "#simpanPenjualan", function() {
            if ($('#nama_pembeli').val() == '') {
                swalError('Penjualan', 'Nama pembeli tidak boleh kosong');
            } else {
                var nama_pembeli = $('#nama_pembeli').val()
                var tanggal_penjualan = $('#tanggal_penjualan').val()
                var jam_penjualan = $('#jam_penjualan').val()
                var keranjang_penjualan = JSON.parse(localStorage.getItem('keranjang_penjualan'));
                grandTotal = 0;
                if (keranjang_penjualan.length > 0) {
                    keranjang_penjualan.forEach(item => {
                        grandTotal += parseInt(item['ppn']) + parseInt(item['harga_jual'] * item['jumlah_jual']) - parseInt(item['diskon']);
                    });
                } else {
                    swalError('Penjualan', 'Keranjang kosong, masukkan item obat untuk melakukan penjualan ');

                }
                Swal.fire({
                    title: "Apakah anda yakin menambah penjualan ini?",
                    html: 'Penjualan akan memperbaharui stok barang anda, Tekan confirm jika data sudah benar.',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirm!"
                }).then((result) => {
                    if (result.value) {
                        $('.loading').show()
                        $.ajax({
                            url: '<?= base_url() ?>penjualan/add_penjualan_action',
                            data: {
                                nama_pembeli: nama_pembeli,
                                tanggal_penjualan: tanggal_penjualan,
                                jam_penjualan: jam_penjualan,
                                keranjang_penjualan: keranjang_penjualan,
                                total_penjualan: grandTotal
                            },
                            method: 'POST',
                            dataType: 'json',
                            success: function(data) {
                                $('.loading').hide()
                                message = data.split("|");
                                if (message[0].trim() == 'Success') {
                                    swalSuccess('Success', message[1])
                                    window.localStorage.removeItem('keranjang_penjualan');
                                    setTimeout(function() {
                                        window.open("<?= base_url() ?>penjualan/cetak_invoice_penjualan/" + message[2], '_blank');

                                    }, 2000);
                                    $('#id_obat').val('')
                                    $('#satuan_obat').val('')
                                    $('#current_stok').val('')
                                    $('#stok').val('')
                                    $('.selectpicker').selectpicker('refresh')

                                    getListPenjualan()
                                } else {
                                    swalError('Error', message[1])

                                }

                            },
                            error(e) {
                                console.log(e)
                                $('.loading').hide()
                            }
                        })
                    }
                })
            }

        })
        $(document).on('change', '#id_obat', function(){  
            var split_data = $(this).val().split('|');
            changeColorTipe(split_data[4])
        })
        function changeColorTipe($tipe){
            if($tipe=='Obat Bebas'){
                $('#color_obat').css('background','blue')
            }else if($tipe=='Obat Bebas Terbatas'){
                $('#color_obat').css('background','green')
            }else if($tipe=='Obat Keras'){
                $('#color_obat').css('background','red')
            }
        }
    })
</script>