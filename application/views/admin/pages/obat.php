<!-- Begin Page Content -->
<div class="container-fluid" id="adminObat">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">Obat</h1>
        <a href="#" data-toggle="modal" data-target="#ObatModal" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white "></i> Add New Obat </a>
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
            <h6 class="m-0 font-weight-bold text-primary">List Obat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTableObat">
                <table class="table  table-bordered" id="data-table" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Kategori Obat</th>
                            <th>Satuan Obat</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-obat">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<!-- Modal Add -->
<div class="modal fade" id="ObatModal" tabindex="-1" role="dialog" aria-labelledby="ObatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ObatModalLabel">Tambah Obat Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formObat" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="hidden" name="id_obat" id="id_obat" class="form-control">
                            <label for="menu">Nama Obat</label>
                            <input type="text" name="nama_obat" class="form-control" id="nama_obat" placeholder="Cth : Konimex" required>
                        </div>
                        <div class="form-group col-md-1 pt-3">
                            <span id="color_obat" class="p-3 float-right mt-3" style="margin-top:auto;background:blue;width:40px;height:40px;border-radius:50%" >&nbsp;</span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="menu">Tipe Obat </label>
                            <select name="tipe_obat" id="tipe_obat" class="form-control">
                                <option>Obat Bebas</option>
                                <option>Obat Bebas Terbatas</option>
                                <option>Obat Keras</option>
                            </select>
                        </div>
                    </div>
                    <script>
                        $(document).on('change', '#tipe_obat', function(){  
                            changeColorTipe()
                        })
                        function changeColorTipe(){
                            if($('#tipe_obat').val()=='Obat Bebas'){
                                $('#color_obat').css('background','blue')
                            }else if($('#tipe_obat').val()=='Obat Bebas Terbatas'){
                                $('#color_obat').css('background','green')
                            }else if($('#tipe_obat').val()=='Obat Keras'){
                                $('#color_obat').css('background','red')
                            }
                        }
                    </script>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="id_kategori">Kategori Obat</label>
                            <select name="id_kategori" id="id_kategori" class="form-control selectpicker" data-live-search="true">
                                <?php
                                foreach ($listCategory as $category) {
                                    ?>
                                    <option value="<?= $category['id_kategori'] ?>"><?= $category['nama_kategori_obat'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_satuan">Satuan Utama Obat (*gunakan satuan terkecil obat)</label>
                            <select name="id_satuan" id="id_satuan" class="form-control selectpicker" data-live-search="true">
                                <option value="">--Pilih Satuan Utama--</option>

                                <?php
                                foreach ($listSatuan as $satuan) {
                                    ?>
                                    <option value="<?= $satuan['id_satuan'] ?>"><?= $satuan['nama_satuan_obat'] . " (" . $satuan['kode_satuan_obat'] . ")" ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="id_satuan_konversi_1">Satuan Konversi 1</label>
                            <select name="id_satuan_konversi_1" id="id_satuan_konversi_1" class="form-control selectpicker" data-live-search="true">
                                <option value="">--Pilih Satuan Konversi 1--</option>
                                <?php
                                foreach ($listSatuan as $satuan) {

                                    ?>
                                    <option value="<?= $satuan['id_satuan'] ?>"><?= $satuan['nama_satuan_obat'] . " (" . $satuan['kode_satuan_obat'] . ")" ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="menu">Jumlah Konversi Obat 1</label>
                            <input type="number" name="jumlah_konversi_1" class="form-control" id="jumlah_konversi_1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="id_satuan_konversi_2">Satuan Konversi 2</label>
                            <select name="id_satuan_konversi_2" id="id_satuan_konversi_2" class="form-control selectpicker" data-live-search="true">
                                <option value="">--Pilih Satuan Konversi 2--</option>
                                <?php
                                foreach ($listSatuan as $satuan) {

                                    ?>
                                    <option value="<?= $satuan['id_satuan'] ?>"><?= $satuan['nama_satuan_obat'] . " (" . $satuan['kode_satuan_obat'] . ")" ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="menu">Jumlah Konversi Obat 2</label>
                            <input type="number" name="jumlah_konversi_2" class="form-control" id="jumlah_konversi_2">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="id_satuan_konversi_3">Satuan Konversi 3</label>
                            <select name="id_satuan_konversi_3" id="id_satuan_konversi_3" class="form-control selectpicker" data-live-search="true">
                                <option value="">--Pilih Satuan Konversi 3--</option>
                                <?php
                                foreach ($listSatuan as $satuan) {

                                    ?>
                                    <option value="<?= $satuan['id_satuan'] ?>"><?= $satuan['nama_satuan_obat'] . " (" . $satuan['kode_satuan_obat'] . ")" ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="menu">Jumlah Konversi Obat 3</label>
                            <input type="number" name="jumlah_konversi_3" class="form-control" id="jumlah_konversi_3">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="menu">Minimum Stok</label>
                            <input type="number" name="min_stok" class="form-control" id="min_stok">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="menu">Maksimum Stok</label>
                            <input type="number" name="max_stok" class="form-control" id="max_stok">
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="menu">Stok Obat</label>
                        <input type="number" name="stok" class="form-control" id="stok" placeholder="Cth : 10" required>
                    </div> -->
                    <div class="form-group">
                        <label>
                            Obat Image (will be used in front of page)
                        </label>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="hidden" name="old_image" id="old_image" class="form-control">
                                    <img src="<?= base_url() ?>assets/images/admin/obat/obat/defaultObat.jpg" class="img-thumbnail imageForm" id="previewImageObat">
                                </div>
                                <div class="col-sm-8">
                                    <div class="custom-file">
                                        <input required type="file" accept=".jpg,.png,.jpeg" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <span class="text-primary">* Only .jpg or .png that can be upload. Maximum file size is 500kb.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="is_active" type="checkbox" id="is_active">
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                            <p class="text-primary">* Obat akan dapat dijual apabila anda mencentang tombol</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addObat">Add Obat </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#is_active').prop('checked', true);
        $('.custom-file-input').on('change', function() {
            let filename = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(filename)
        })
        $('#image').change(function() {
            readURL(this);
        })
            // $('#data-table').DataTable().clear();
            // $('#data-table').DataTable().destroy();
        var table = $('#data-table').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?php echo site_url('obat/obat_fetch_serverside')?>",
                "type": "POST",
                error(e){
                    console.log(e)
                }
            },


            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],

        });
        
        // function getListObat() 
        //     $('.loading').show();
        //     $.ajax({
        //         url: "<?php echo base_url(); ?>obat/obat_fetch",
        //         method: "POST",
        //         success: function(data) {
        //             $('#data-tableObat').html(data);
        //             $("#data-table").DataTable();
        //             $('.loading').hide();
        //         },
        //         error: function(err) {
        //             $('.loading').hide()
        //             console.log(err)
        //             swalError('Error ' + err.status, err.statusText);
        //         }
        //     })
        // }

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
        $(document).on('click', ".addObatSubmit", function(e) {
            $('.loading').show()
            var file_data = $('#image').prop('files')[0];
            var form_data = new FormData($('#formObat')[0])
            $.ajax({
                url: '<?= base_url() ?>obat/obat_add',
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
                        $('#ObatModal').modal('toggle');
                        
                        // getListObat();
                        table
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
                        url: '<?= base_url() ?>obat/obat_setactive',
                        data: {
                            id_obat: id_obat,
                            is_active: active
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            swalSuccess('Success', 'Success set obat as "' + info + '"')
                            // getListObat();
                            table.ajax.reload();

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
            $('#previewImageObat').attr('src', '<?= base_url() ?>assets/images/admin/obat/obat/defaultObat.jpg');
            $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
            $('#is_active').prop('checked', true);
            $('#ObatModal #ObatModalLabel').html('Add New Obat ')
            $('#ObatModal #addObat').html('Add New Obat ')
            $('#addObat').addClass('addObatSubmit')
            $('#addObat').removeClass('editObatSubmit')
            $('#stok').attr('readonly', false)
            $('#ObatModal').modal('show');
        })
        $(document).on('click', ".editObatButton", function() {
            const id_obat = $(this).data('id_obat');
            $.ajax({
                url: '<?= base_url() ?>obat/obat_selected',
                data: {
                    id_obat: id_obat
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $('#id_obat').val(data['id_obat'])
                    $('#nama_obat').val(data['nama_obat'])
                    $('select[name=tipe_obat]').val(data['tipe_obat']);
                    $('select[name=id_kategori]').val(data['id_kategori']);
                    $('select[name=id_satuan]').val(data['id_satuan']);
                    $('select[name=id_satuan_konversi_1]').val(data['id_satuan_konversi_1']);
                    $('select[name=id_satuan_konversi_2]').val(data['id_satuan_konversi_2']);
                    $('select[name=id_satuan_konversi_3]').val(data['id_satuan_konversi_3']);
                    $('.selectpicker').selectpicker('refresh')
                    $('#jumlah_konversi_1').val(data['jumlah_konversi_1'])
                    $('#jumlah_konversi_2').val(data['jumlah_konversi_2'])
                    $('#jumlah_konversi_3').val(data['jumlah_konversi_3'])
                    $('#min_stok').val(data['min_stok'])
                    $('#max_stok').val(data['max_stok'])
                    $('#old_image').val(data['image'])
                    $('#previewImageObat').attr('src', '<?= base_url() ?>assets/images/admin/obat/obat/' + data['image']);
                    if (data['is_active'] == '1') {
                        $("#is_active").prop("checked", true);
                    } else {
                        $("#is_active").prop("checked", false);
                    }
                    $('#ObatModal #ObatModalLabel').html('Edit Obat ')
                    $('#ObatModal #addObat').html('Edit Obat ')
                    $('#addObat').removeClass('addObatSubmit')
                    $('#addObat').addClass('editObatSubmit')
                    $('#stok').attr('readonly', true)
                    changeColorTipe()
                    $('#ObatModal').modal('toggle');
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
                url: '<?= base_url() ?>obat/obat_update',
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
                        $('#previewImageObat').attr('src', '<?= base_url() ?>assets/images/admin/obat/obat/defaultObat.jpg');
                        $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
                        $('#is_active').prop('checked', true);
                        $('#ObatModal').modal('toggle');
                        
                        // getListObat();
                        table.ajax.reload();

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