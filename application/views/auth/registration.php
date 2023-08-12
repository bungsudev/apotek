<div class="limiter" id="registrationSection">
    <div class="container-login100  pb-mobile">
        <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
            <form class="login100-form validate-form flex-sb flex-w" id="regisForm" method="POST">
                <span class="login100-form-title p-b-32 text-center">
                    Buat Akun
                </span>
                <?php if ($this->session->flashdata('message')) {
                    echo $this->session->flashdata('message');
                } ?>
                <span class="txt1 p-b-11">
                    Nama <?= form_error('nama', '<span class="text-danger" style="text-transform:initial !important">*', '</span>') ?>

                </span>
                <div class="wrap-input100 validate-input m-b-36">
                    <input class="input100" type="text" name="nama" value="<?php echo set_value('nama'); ?>">
                    <span class="focus-input100"></span>
                </div>


                <span class="txt1 p-b-11">
                    Email <?= form_error('email', '<span class="text-danger" style="text-transform:initial !important">*', '</span>') ?>
                </span>
                <div class="wrap-input100 validate-input m-b-36">
                    <input class="input100" type="text" name="email" value="<?php echo set_value('email'); ?>">
                    <span class="focus-input100"></span>
                </div>

                <span class="txt1 p-b-11">
                    Nomor Handphone <?= form_error('no_handphone', '<span class="text-danger" style="text-transform:initial !important">*', '</span>') ?>
                </span>
                <div class="wrap-input100 validate-input m-b-36">
                    <input class="input100 " type="text" name="no_handphone" value="<?php echo set_value('no_handphone'); ?>">
                    <span class="focus-input100"></span>
                </div>

                <span class="txt1 p-b-11">
                    Password <?= form_error('pass', '<span class="text-danger" style="text-transform:initial !important">*', '</span>') ?>
                </span>
                <div class="wrap-input100 validate-input m-b-12">
                    <span class="btn-show-pass btn-show-password">
                        <i class="fa fa-eye"></i>
                    </span>
                    <input class="input100 inputPassword" type="password" name="pass">
                    <span class="focus-input100"></span>
                </div>

                <span class="txt1 p-b-11">
                    Konfirmasi Password <?= form_error('confirm_pass', '<span class="text-danger" style="text-transform:initial !important">*', '</span>') ?>
                </span>
                <div class="wrap-input100 validate-input m-b-12">
                    <span class="btn-show-pass btn-show-confim-pass">
                        <i class="fa fa-eye"></i>
                    </span>
                    <input class="input100 inputConfirmPass" type="password" name="confirm_pass">
                    <span class="focus-input100"></span>
                </div>

                <div class="flex-sb-m w-full p-b-48">
                    <div class="contact100-form-checkbox">
                        <a href="<?= base_url() ?>auth/" class="txt3 border-bottom-stella">
                            Login
                        </a>
                    </div>

                    <div>
                        <a href="<?= base_url() ?>auth/forgetpassword" class="txt3 border-bottom-stella">
                            Lupa Password?
                        </a>
                    </div>
                </div>

                <div class="container-login100-form-btn p-l-10 p-r-10">
                    <button class="login100-form-btn btnStella1 btn-block submit-btn">
                        Buat Akun
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    $('.btn-show-password').click(function() {
        if ($(this).html().trim() == '<i class="fa fa-eye"></i>') {
            $(this).html('<i class="fa fa-eye-slash"></i>')
            $('.inputPassword').attr('type', 'text');
        } else {
            $(this).html('<i class="fa fa-eye"></i>')
            $('.inputPassword').attr('type', 'password');
        }
    })
    $('.btn-show-confim-pass').click(function() {
        if ($(this).html().trim() == '<i class="fa fa-eye"></i>') {
            $(this).html('<i class="fa fa-eye-slash"></i>')
            $('.inputConfirmPass').attr('type', 'text');
        } else {
            $(this).html('<i class="fa fa-eye"></i>')
            $('.inputConfirmPass').attr('type', 'password');
        }
    })
    $('.submit-btn').on('click', function(e) {
        e.preventDefault();
        $('.loading').show();
        // $('form').submit();
        var form_data = new FormData($('#regisForm')[0])
        $.ajax({
            url: '<?= base_url() ?>auth/registration',
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
                } else if (message[0].trim() == 'Success') {
                    swalSuccess(message[0], message[1])

                    setTimeout(() => {

                        window.location.href = "<?= base_url() ?>auth";

                    }, 4000);
                } else {
                    swalError("Error", "Form tidak valid")
                    // setTimeout(() => {
                    // window.location.href = "<?= base_url() ?>/user";

                    // }, 2000);
                }
            },
            error: function(err) {
                $('.loading').hide()
                console.log(err)
                swalError('Error ' + err.status, err.statusText);
            }
        })
    });
</script>