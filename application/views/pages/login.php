<div class="container">
    <div class="col-xl-10 col-lg-12 col-md-7 mx-auto">
        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col">
                        <div class="p-4">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                            </div>
                            <?php if ($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            } ?>
                            <form class="user" method="post" id="formLogin" action="<?= base_url() ?>admin">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-user" id="username" value="<?php echo set_value('username'); ?>" aria-describedby="usernameHelp" placeholder="Enter username...">
                                    <?= form_error('username', '<small class="text-danger">', '</small>') ?>

                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" id="password" value="<?php echo set_value('password'); ?>" placeholder="Password">
                                    <?= form_error('password', '<small class="text-danger">', '</small>') ?>

                                </div>
                                <button type="button" class="btn btn-primary btn-user btn-block submit-btn">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<script>
 $(document).ready(function() {
    $('form input').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    $('.submit-btn').on('click', function(e) {
        e.preventDefault();
        $('.loading').show();
        var form_data = new FormData($('#formLogin')[0])
        $.ajax({
            url: '<?= base_url() ?>admin',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(response) {
                $('.loading').hide()
                console.log(response)

                message = response.trim().split("|")
                if (message[0].trim() == 'Error') {
                    if (message[1]) {
                        swalError(message[0], message[1])
                    } else {
                        window.location.href = "<?= base_url() ?>admin"
                    }
                } else if (message[0].trim() == 'Success') {
                    swalSuccess(message[0], message[1])

                        setTimeout(() => {
                            window.location.href = "<?= base_url() ?>/admin/dashboard";
                        }, 2000);
                    
                } else {
                    swalError("Error", "Form tidak valid")
                }
            },
            error: function(err) {
                $('.loading').hide()
                console.log(err)
                swalError('Error ', 'Silahkan login kembali');
                setTimeout(() => {
                    window.location.href = "<?= base_url() ?>admin"
                }, 2000);
            }
        })
    });
});
</script>