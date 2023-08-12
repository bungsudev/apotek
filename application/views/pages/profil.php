<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Profile</h1>
    <?php
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    }
    ?>
    <div class="col-lg-6 col-12 " style="max-width: 540px;">
        <form method="post" id="formProfil" enctype="multipart/form-data">

            <div class="form-group row">
                <label for="nama_apotek" class="col-sm-3 col-form-label">Nama Apotek</label>
                <input type="hidden" value="<?= $profil['id_apotek'] ?>" name="id_apotek">
                <div class="col-sm-9">
                    <input type="text" name="nama_apotek" class="form-control" id="nama_apotek" value="<?= $profil['nama_apotek'] ?>">

                </div>
            </div>
            <div class="form-group row">
                <label for="nama" class="col-sm-3 col-form-label">Alamat Apotek</label>
                <div class="col-sm-9">
                    <textarea name="alamat_apotek" class="form-control" id="alamat_apotek" cols="30" rows="10" value=""> <?= $profil['alamat_apotek'] ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_apotek" class="col-sm-3 col-form-label">No Telp Apotek (Optional)</label>
                <div class="col-sm-9">
                    <input type="text" name="no_hp" class="form-control" id="no_hp" value="<?= $profil['no_hp'] ?>">

                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    Logo Apotek
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="hidden" name="old_image" id="old_image" class="form-control" value="<?= $profil['image'] ?>">

                            <img src="<?= base_url() ?>assets/profil/<?= $profil['image'] ?>" class="img-thumbnail">
                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9 text-right">
                    <button type="submit" class="btn btn-primary btn-submit">Update Profile</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).on('click', ".btn-submit", function(e) {
        e.preventDefault()
        $('.loading').show()
        var file_data = $('#image').prop('files')[0];
        var form_data = new FormData($('#formProfil')[0])
        $.ajax({
            url: '<?= base_url() ?>profil/profil_update',
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
                    Swal.fire({
                        type: "success",
                        title: message[0],
                        text: message[1]
                    }).then(result => {
                        location.reload();
                    });

                }
            },
            error: function(err) {
                $('.loading').hide()
                console.log(err)
                swalError('Error ' + err.status, err.statusText);
            }
        });
    })
</script>