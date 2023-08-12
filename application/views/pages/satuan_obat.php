<!-- Begin Page Content -->
<div class="container-fluid" id="adminUser">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">Satuan Obat</h1>
        <a href="#" data-toggle="modal" data-target="#satuanObatModal" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white "></i> Tambah Satuan Obat</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Satuan Obat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTableUser">

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<!-- Modal Add -->
<div class="modal fade" id="satuanObatModal" tabindex="-1" role="dialog" aria-labelledby="satuanObatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="satuanObatModalLabel">Tambah Satuan Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formSatuanObat" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_satuan" id="id_satuan" class="form-control">
                        <label for="menu">Nama Satuan Obat</label>
                        <input type="text" name="nama_satuan_obat" class="form-control" id="nama_satuan_obat" placeholder="Cth : Piece" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Kode Satuan Obat</label>
                        <input type="text" name="kode_satuan_obat" class="form-control" id="kode_satuan_obat" placeholder="Cth : Pcs" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="is_active" type="checkbox" id="is_active">
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                            <p class="text-primary">* Kode satuan obat akan aktif apabila anda mencentang aktif</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="tambahSatuan">Tambah Satuan Obat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#is_active').prop('checked', true);
        var quill = new Quill('#quillEditor', {
            theme: 'snow'
        });

        getSatuanObat();

        function getSatuanObat() {
            $('.loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>satuan_obat/satuan_obat_fetch",
                method: "POST",
                success: function(data) {
                    $('#dataTableUser').html(data);
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
        // Tambah Satuan Obat
        $(document).on('click', ".tambahSatuanSubmit", function() {
            $('.loading').show()
            var form_data = new FormData($('#formSatuanObat')[0])
            console.log(form_data)
            $.ajax({
                url: '<?= base_url() ?>satuan_obat/satuan_obat_add',
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
                        $('#formSatuanObat').trigger("reset");
                        $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
                        $('#is_active').prop('checked', true);
                        getSatuanObat();
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
            const id_satuan = $(this).data('id_satuan');
            const info = $(this).data('info');
            if (info == 'Active') {
                active = 1;
            } else {
                active = 0;
            }
            Swal.fire({
                title: "Are you sure?",
                text: 'Satuan obat akan di set menjadi "' + info + '" jika kamu mengklik tombol konfirm.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>satuan_obat/satuan_obat_setactive',
                        data: {
                            id_satuan: id_satuan,
                            is_active: active
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            swalSuccess('Success', 'Berhasil  meng-"' + info + '" satuan obat')
                            getSatuanObat();
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
            $('#formSatuanObat').trigger("reset");
            $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
            $('#is_active').prop('checked', true);
            $('#passwordUser').show();
            $('#role_id').val('')

            $('#satuanObatModal #satuanObatModalLabel').html('Tambah Satuan Obat')
            $('#satuanObatModal #tambahSatuan').html('Tambah Satuan Obat')
            $('#tambahSatuan').addClass('tambahSatuanSubmit')
            $('#tambahSatuan').removeClass('editSatuanObatSubmit')
            $('#satuanObatModal').modal('show');
        })
        $(document).on('click', ".editSatuanObat", function() {
            const id_satuan = $(this).data('id_satuan');
            $.ajax({
                url: '<?= base_url() ?>satuan_obat/satuan_obat_selected',
                data: {
                    id_satuan: id_satuan
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {

                    $('#id_satuan').val(data['id_satuan'])
                    $('#nama_satuan_obat').val(data['nama_satuan_obat'])
                    $('#kode_satuan_obat').val(data['kode_satuan_obat'])
                    if (data['is_active'] == '1') {
                        $("#is_active").prop("checked", true);
                    } else {
                        $("#is_active").prop("checked", false);
                    }
                    $('#satuanObatModal #satuanObatModalLabel').html('Edit Satuan Obat')
                    $('#satuanObatModal #tambahSatuan').html('Edit Satuan Obat')
                    $('#tambahSatuan').removeClass('tambahSatuanSubmit')
                    $('#tambahSatuan').addClass('editSatuanObatSubmit')
                    $('#satuanObatModal').modal('show');
                },
                err(e) {
                    console.log(e)
                }
            })
        })
        // Edit Submit
        $(document).on('click', ".editSatuanObatSubmit", function() {
            $('.loading').show()
            var form_data = new FormData($('#formSatuanObat')[0])
            $.ajax({
                url: '<?= base_url() ?>satuan_obat/satuan_obat_update',
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
                        $('#formSatuanObat').trigger("reset");

                        $('#is_active').prop('checked', true);
                        getSatuanObat();
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