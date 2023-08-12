<!-- Begin Page Content -->
<div class="container-fluid" id="adminUser">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">Harga Obat "<?= $obat['nama_obat'] ?>"</h1>
        <a href="#" data-toggle="modal" data-target="#kategoriObatModal" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white "></i> Tambah Harga Obat</a>
    </div>
    <?php
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    }
    ?>
    <!-- <a class="mb-4">Manage user</a>.</p> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Harga Obat "<?= $obat['nama_obat'] ?>"</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTableObat">

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<!-- Modal Add -->
<div class="modal fade" id="kategoriObatModal" tabindex="-1" role="dialog" aria-labelledby="kategoriObatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriObatModalLabel">Tambah Harga Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formHargaObat" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_obat" id="id_obat" value="<?= $obat['id_obat'] ?>">
                    <div class="form-group">
                        <label for="id_satuan">Satuan Obat </label>
                        <select name="id_satuan" id="id_satuan" class="form-control selectpicker" data-live-search="true">
                            <option value="">--Pilih Satuan--</option>

                            <?php
                            foreach ($satuan_available as $satuan) {
                            ?>
                                <option value="<?= $satuan['id_satuan'] ?>"><?= $satuan['nama_satuan_obat'] . " (" . $satuan['kode_satuan_obat'] . ")" ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="menu">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" id="jumlah">
                    </div>
                    <div class="form-group">
                        <label for="menu">Harga</label>
                        <input type="number" name="harga" class="form-control" id="harga">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="tambahkategori">Tambah Harga Obat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#is_active').prop('checked', true);
        // var quill = new Quill('#quillEditor', {
        //     theme: 'snow'
        // });

        getkategoriObat();

        function getkategoriObat() {
            $('.loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>obat/harga_obat_fetch/<?= $id_obat ?>",
                method: "POST",
                success: function(data) {
                    $('#dataTableObat').html(data);
                    $("#dataTable").DataTable();
                    $('.loading').hide();
                },
                error: function(err) {
                    $('.loading').hide()
                    console.log(err)
                    swalError('Error ' + err.status, err.statusText);
                }
            })
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#previewImageCategory').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        // Tambah kategori Obat
        $(document).on('click', ".tambahHargaObat", function() {
            $('.loading').show()
            var form_data = new FormData($('#formHargaObat')[0])
            console.log(form_data)
            $.ajax({
                url: '<?= base_url() ?>obat/harga_obat_add',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response) {
                    $('.loading').hide()
                    message = response.split("|")
                    if (message[0].trim() == 'Error') {
                        swalError(message[0], message[1])
                    } else {
                        swalSuccess(message[0], message[1])
                        $('#formHargaObat').trigger("reset");
                        $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
                        $('#is_active').prop('checked', true);
                        getkategoriObat();
                    }
                },
                error: function(err) {
                    $('.loading').hide()
                    console.log(err)
                    swalError('Error ' + err.status, err.statusText);
                }
            });
        })

        // Set Active not Active User
        $(document).on('click', ".deleteHargaButton", function() {
            const id_satuan = $(this).data('id_satuan');
            const id_obat = $(this).data('id_obat');
            const jumlah = $(this).data('jumlah');
            Swal.fire({
                title: "Are you sure?",
                text: 'Harga obat yang dipilih akan dihapus jika kamu mengklik tombol konfirm.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>obat/harga_obat_delete',
                        data: {
                            id_satuan: id_satuan,
                            id_obat: id_obat,
                            jumlah: jumlah,

                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            swalSuccess('Success', 'Berhasil  menghapus harga obat')
                            getkategoriObat();
                        },
                        err(e) {
                            console.log(e)
                            $('.loading').hide()
                        }
                    })

                }
            })
        });
        // Get Edit Data
        $('#buttonAddNew').click(function() {
            $('#formHargaObat').trigger("reset");
            $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
            $('#is_active').prop('checked', true);
            $('#passwordUser').show();
            $('#role_id').val('')
            $('.selectpicker').selectpicker('refresh')

            $('#kategoriObatModal #kategoriObatModalLabel').html("Tambah Harga Obat  <?= $obat['nama_obat'] ?>")
            $('#kategoriObatModal #tambahkategori').html('Tambah Harga Obat')
            $('#tambahkategori').addClass('tambahHargaObat')
            $('#tambahkategori').removeClass('editkategoriObatSubmit')
            $('#kategoriObatModal').modal('show');
        })
        $(document).on('click', ".editHargaButton", function() {
            const id_obat = $(this).data('id_obat');
            const id_satuan = $(this).data('id_satuan');
            $.ajax({
                url: '<?= base_url() ?>obat/harga_obat_selected',
                data: {
                    id_obat: id_obat,
                    id_satuan: id_satuan,
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {

                    $('#id_kategori').val(data['id_kategori'])
                    $('#id_satuan').val(data['id_satuan'])
                    $('#harga').val(data['harga'])
                    $('#jumlah').val(data['jumlah'])
                    $('.selectpicker').selectpicker('refresh')

                    $('#kategoriObatModal #kategoriObatModalLabel').html('Edit Harga Obat')
                    $('#kategoriObatModal #tambahkategori').html('Edit Harga Obat')
                    $('#tambahkategori').removeClass('tambahHargaObat')
                    $('#tambahkategori').addClass('editkategoriObatSubmit')

                    $('#kategoriObatModal').modal('show');
                },
                err(e) {
                    console.log(e)
                }
            })
        })
        // Edit Submit
        $(document).on('click', ".editkategoriObatSubmit", function() {
            $('.loading').show()
            var form_data = new FormData($('#formHargaObat')[0])
            $.ajax({
                url: '<?= base_url() ?>obat/harga_obat_update',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response) {
                    $('.loading').hide()
                    message = response.split("|")
                    if (message[0].trim() == 'Error') {
                        swalError(message[0], message[1])
                    } else {
                        swalSuccess(message[0], message[1])
                        $('#formHargaObat').trigger("reset");

                        $('#is_active').prop('checked', true);
                        getkategoriObat();
                    }
                },
                error: function(err) {
                    $('.loading').hide()
                    console.log(err)
                    swalError('Error ' + err.status, err.statusText);
                }
            });
        })
    })
</script>