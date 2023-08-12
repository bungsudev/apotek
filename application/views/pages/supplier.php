<!-- Begin Page Content -->
<div class="container-fluid" id="adminUser">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">Supplier</h1>
        <a href="#" data-toggle="modal" data-target="#supplierModal" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white "></i> Tambah Supplier</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Supplier </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTableSupplier">

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<!-- Modal Add -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalLabel">Tambah Supplier </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formsupplier" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_supplier" id="id_supplier" class="form-control">
                        <label for="menu">Nama Supplier </label>
                        <input type="text" name="nama_supplier" class="form-control" id="nama_supplier" placeholder="Cth : PT Konimex" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Nomor Handphone Suppiler (Opsional) </label>
                        <input type="text" name="telp_supplier" class="form-control" id="telp_supplier" placeholder="Cth : 081234567890" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Email Suppiler (Opsional) </label>
                        <input type="email" name="email_supplier" class="form-control" id="email_supplier" placeholder="Cth : konimex@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Kota Suppiler</label>
                        <input type="text" name="kota_supplier" class="form-control" id="kota_supplier" placeholder="Cth : Medan" required>
                    </div>
                    <div class="form-group">
                        <label for="menu">Alamat Lengkap Suppiler</label>
                        <textarea name="alamat_supplier" class="form-control" id="alamat_supplier" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="is_active" type="checkbox" id="is_active">
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                            <p class="text-primary">* Supplier akan aktif apabila anda mencentang aktif</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="tambahsupplier">Tambah Supplier </button>
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

        getSuppliers();

        function getSuppliers() {
            $('.loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>supplier/supplier_fetch",
                method: "POST",
                success: function(data) {
                    $('#dataTableSupplier').html(data);
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
        // Tambah Supplier 
        $(document).on('click', ".tambahsupplierSubmit", function() {
            $('.loading').show()
            var form_data = new FormData($('#formsupplier')[0])
            console.log(form_data)
            $.ajax({
                url: '<?= base_url() ?>supplier/supplier_add',
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
                        $('#formsupplier').trigger("reset");
                        $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
                        $('#is_active').prop('checked', true);
                        getSuppliers();
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
            const id_supplier = $(this).data('id_supplier');
            const info = $(this).data('info');
            if (info == 'Active') {
                active = 1;
            } else {
                active = 0;
            }
            Swal.fire({
                title: "Are you sure?",
                text: 'Supplier  akan di set menjadi "' + info + '" jika kamu mengklik tombol konfirm.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>supplier/supplier_setactive',
                        data: {
                            id_supplier: id_supplier,
                            is_active: active
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            swalSuccess('Success', 'Berhasil  meng-"' + info + '" supplier ')
                            getSuppliers();
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
            $('#formsupplier').trigger("reset");
            $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
            $('#is_active').prop('checked', true);
            $('#passwordUser').show();
            $('#role_id').val('')

            $('#supplierModal #supplierModalLabel').html('Tambah Supplier ')
            $('#supplierModal #tambahsupplier').html('Tambah Supplier ')
            $('#tambahsupplier').addClass('tambahsupplierSubmit')
            $('#tambahsupplier').removeClass('editsupplierSubmit')
            $('#supplierModal').modal('show');
        })
        $(document).on('click', ".editsupplier", function() {
            const id_supplier = $(this).data('id_supplier');
            $.ajax({
                url: '<?= base_url() ?>supplier/supplier_selected',
                data: {
                    id_supplier: id_supplier
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {

                    $('#id_supplier').val(data['id_supplier'])
                    $('#nama_supplier').val(data['nama_supplier'])
                    $('#email_supplier').val(data['email_supplier'])
                    $('#kota_supplier').val(data['kota_supplier'])
                    $('#telp_supplier').val(data['telp_supplier'])
                    $('#alamat_supplier').val(data['alamat_supplier'])
                    if (data['is_active'] == '1') {
                        $("#is_active").prop("checked", true);
                    } else {
                        $("#is_active").prop("checked", false);
                    }
                    $('#supplierModal #supplierModalLabel').html('Edit supplier ')
                    $('#supplierModal #tambahsupplier').html('Edit supplier ')
                    $('#tambahsupplier').removeClass('tambahsupplierSubmit')
                    $('#tambahsupplier').addClass('editsupplierSubmit')
                    $('#supplierModal').modal('show');
                },
                err(e) {
                    console.log(e)
                }
            })
        })
        // Edit Submit
        $(document).on('click', ".editsupplierSubmit", function() {
            $('.loading').show()
            var form_data = new FormData($('#formsupplier')[0])
            $.ajax({
                url: '<?= base_url() ?>supplier/supplier_update',
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
                        $('#formsupplier').trigger("reset");

                        $('#is_active').prop('checked', true);
                        getSuppliers();
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