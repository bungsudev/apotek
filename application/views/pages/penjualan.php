<!-- Begin Page Content -->
<div class="container-fluid" id="adminObat">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">Penjualan Obat</h1>
        <a href="<?= base_url() ?>penjualan/add_penjualan" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white "></i> Buat Penjualan Obat </a>
    </div>
    <?php
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    }
    ?>
    <!-- <p class="mb-4">Manage Obat that Home Care Sells</a>.</p> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTablePenjualan">
                <table class="table  table-bordered" id="data-table" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Id Penjualan</th>
                            <th>Nama Penjual / Kasir</th>
                            <th>Tanggal Penjualan</th>
                            <th>Total Penjualan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-penjualan">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
    $(document).ready(function() {
        var table = $('#data-table').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?php echo site_url('penjualan/penjualan_fetch_serverside')?>",
                "type": "POST",
                error(e){
                    console.log(e)
                }
            },


            "columnDefs": [{
                "targets": [0],
                "orderable": true,
            }, ],

        });
        $('#is_active').prop('checked', true);
        $('.custom-file-input').on('change', function() {
            let filename = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(filename)
        })
        $('#image').change(function() {
            readURL(this);
        })

        function getListPenjualan() {
            $('.loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>penjualan/penjualan_fetch",
                method: "POST",
                success: function(data) {
                    $('#dataTablePenjualan').html(data);
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
                    $('#previewImageObat').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        // Add Obat 
        $(document).on('click', ".addObatSubmit", function() {
            $('.loading').show()
            var file_data = $('#image').prop('files')[0];
            var form_data = new FormData($('#formObat')[0])
            $.ajax({
                url: '<?= base_url() ?>penjualan/obat_add',
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
                        $('#formObat').trigger("reset");
                        $('#previewImageObat').attr('src', '<?= base_url() ?>assets/images/admin/obat/defaultObat.jpg');
                        $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
                        $('#is_active').prop('checked', true);
                        getListPenjualan();
                    }
                },
                error: function(err) {
                    $('.loading').hide()
                    console.log(err)
                    swalError('Error ' + err.status, err.statusText);
                }
            });
        })

        $(document).on('click', ".activeObatButton", function() {
            const id_obat = $(this).data('id_obat');
            const info = $(this).data('info');
            if (info == 'Active') {
                active = 1;
            } else {
                active = 0;
            }
            Swal.fire({
                title: "Are you sure?",
                text: 'Obat akan diset menjadi ' + info + ' apabila anda menekan tombol konfirmasi.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>penjualan/obat_setactive',
                        data: {
                            id_obat: id_obat,
                            is_active: active
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            swalSuccess('Success', 'Success set obat as "' + info + '"')
                            getListPenjualan();

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
            $('#formObat').trigger("reset");
            $('#previewImageObat').attr('src', '<?= base_url() ?>assets/images/admin/penjualan/obat/defaultObat.jpg');
            $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
            $('#is_active').prop('checked', true);
            $('#penjualanObat #penjualanObatLabel').html('Add New Obat ')
            $('#penjualanObat #addObat').html('Add New Obat ')
            $('#addObat').addClass('addObatSubmit')
            $('#addObat').removeClass('editObatSubmit')
            $('#stok').attr('readonly', false)
            $('#penjualanObat').modal('show');
        })
        $(document).on('click', ".editObatButton", function() {
            const id_obat = $(this).data('id_obat');
            $.ajax({
                url: '<?= base_url() ?>penjualan/obat_selected',
                data: {
                    id_obat: id_obat
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    $('#id_obat').val(data['id_obat'])
                    $('#nama_obat').val(data['nama_obat'])
                    $('select[name=id_kategori]').val(data['id_kategori']);
                    $('select[name=id_satuan]').val(data['id_satuan']);
                    $('.selectpicker').selectpicker('refresh')
                    $('#stok').val(data['stok'])
                    $('#old_image').val(data['image'])
                    $('#previewImageObat').attr('src', '<?= base_url() ?>assets/images/admin/penjualan/obat/' + data['image']);
                    if (data['is_active'] == '1') {
                        $("#is_active").prop("checked", true);
                    } else {
                        $("#is_active").prop("checked", false);
                    }
                    $('#penjualanObat #penjualanObatLabel').html('Edit Obat ')
                    $('#penjualanObat #addObat').html('Edit Obat ')
                    $('#addObat').removeClass('addObatSubmit')
                    $('#addObat').addClass('editObatSubmit')
                    $('#stok').attr('readonly', true)

                    $('#penjualanObat').modal('show');
                },
                err(e) {
                    console.log(e)
                }
            })
        })
        // Edit Submit
        $(document).on('click', ".editObatSubmit", function() {
            $('.loading').show()
            var file_data = $('#image').prop('files')[0];
            var form_data = new FormData($('#formObat')[0])
            $.ajax({
                url: '<?= base_url() ?>penjualan/obat_update',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response) {
                    console.log(response)
                    $('.loading').hide()
                    message = response.split("|")
                    if (message[0].trim() == 'Error') {
                        swalError(message[0], message[1])
                    } else {
                        swalSuccess(message[0], message[1])
                        $('#formObat').trigger("reset");
                        $('#previewImageObat').attr('src', '<?= base_url() ?>assets/images/admin/penjualan/obat/defaultObat.jpg');
                        $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
                        $('#is_active').prop('checked', true);
                        getListPenjualan();

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