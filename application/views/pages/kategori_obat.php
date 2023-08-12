<!-- Begin Page Content -->
<div class="container-fluid" id="adminUser">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">Kategori Obat</h1>
        <a href="#" data-toggle="modal" data-target="#kategoriObatModal" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white "></i> Tambah Kategori Obat</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Kategori Obat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTableKategoriObat">

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
                <h5 class="modal-title" id="kategoriObatModalLabel">Tambah Kategori Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formkategoriObat" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_kategori" id="id_kategori" class="form-control">
                        <label for="menu">Nama Kategori Obat</label>
                        <input type="text" name="nama_kategori_obat" class="form-control" id="nama_kategori_obat" placeholder="Cth : Piece" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="is_active" type="checkbox" id="is_active">
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                            <p class="text-primary">* Kode kategori obat akan aktif apabila anda mencentang aktif</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="tambahkategori">Tambah Kategori Obat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#is_active').prop('checked', true);

        getkategoriObat();

        function getkategoriObat() {
            $('.loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>kategori_obat/kategori_obat_fetch",
                method: "POST",
                success: function(data) {
                    $('#dataTableKategoriObat').html(data);
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
        $(document).on('click', ".tambahkategoriSubmit", function() {
            $('.loading').show()
            var form_data = new FormData($('#formkategoriObat')[0])
            console.log(form_data)
            $.ajax({
                url: '<?= base_url() ?>kategori_obat/kategori_obat_add',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response) {
                    $('.loading').hide()
                    message = response.split("|")
                    console.log(response)
                    if (message[0].trim() == 'Error') {
                        swalError(message[0], message[1])
                    } else {
                        swalSuccess(message[0], message[1])
                        $('#formkategoriObat').trigger("reset");
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
        $(document).on('click', ".activeUserButton", function() {
            const id_kategori = $(this).data('id_kategori');
            const info = $(this).data('info');
            if (info == 'Active') {
                active = 1;
            } else {
                active = 0;
            }
            Swal.fire({
                title: "Are you sure?",
                text: 'kategori obat akan di set menjadi "' + info + '" jika kamu mengklik tombol konfirm.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>kategori_obat/kategori_obat_setactive',
                        data: {
                            id_kategori: id_kategori,
                            is_active: active
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            swalSuccess('Success', 'Berhasil  meng-"' + info + '" kategori obat')
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
            $('#formkategoriObat').trigger("reset");
            $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
            $('#is_active').prop('checked', true);
            $('#passwordUser').show();
            $('#role_id').val('')

            $('#kategoriObatModal #kategoriObatModalLabel').html('Tambah Kategori Obat')
            $('#kategoriObatModal #tambahkategori').html('Tambah Kategori Obat')
            $('#tambahkategori').addClass('tambahkategoriSubmit')
            $('#tambahkategori').removeClass('editkategoriObatSubmit')
            $('#kategoriObatModal').modal('show');
        })
        $(document).on('click', ".editkategoriObat", function() {
            const id_kategori = $(this).data('id_kategori');
            $.ajax({
                url: '<?= base_url() ?>kategori_obat/kategori_obat_selected',
                data: {
                    id_kategori: id_kategori
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {

                    $('#id_kategori').val(data['id_kategori'])
                    $('#nama_kategori_obat').val(data['nama_kategori_obat'])
                    if (data['is_active'] == '1') {
                        $("#is_active").prop("checked", true);
                    } else {
                        $("#is_active").prop("checked", false);
                    }
                    $('#kategoriObatModal #kategoriObatModalLabel').html('Edit kategori Obat')
                    $('#kategoriObatModal #tambahkategori').html('Edit kategori Obat')
                    $('#tambahkategori').removeClass('tambahkategoriSubmit')
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
            var form_data = new FormData($('#formkategoriObat')[0])
            $.ajax({
                url: '<?= base_url() ?>kategori_obat/kategori_obat_update',
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
                        $('#formkategoriObat').trigger("reset");

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