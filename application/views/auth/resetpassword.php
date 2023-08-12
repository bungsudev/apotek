<div class="limiter" id="registrationSection">
    <div class="container-login100  pb-mobile">
        <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
            <form class="login100-form validate-form flex-sb flex-w" action="<?= base_url() ?>auth/resetpassword/<?= $token['token'] ?>" method="POST">
                <span class="login100-form-title p-b-32 text-center">
                    Reset Password
                </span>
                <?php if ($this->session->flashdata('message')) {
                    echo $this->session->flashdata('message');
                } ?>
                <span class="txt1 p-b-11">
                    Password <?= form_error('pass', '<span class="text-danger" style="text-transform:initial !important">*', '</span>') ?>
                </span>
                <div class="wrap-input100 validate-input m-b-12">
                    <span class="btn-show-pass btn-show-password">
                        <i class="fa fa-eye"></i>
                    </span>
                    <input type="hidden" name="user_id" value="<?= $token['user_id'] ?>">
                    <input class="input100 inputPassword" type="password" name="pass">
                    <span class="focus-input100"></span>
                </div>

                <span class="txt1 p-b-11">
                    Konfirmasi Password
                </span>
                <div class="wrap-input100 validate-input m-b-12">
                    <span class="btn-show-pass btn-show-confim-pass">
                        <i class="fa fa-eye"></i>
                    </span>
                    <input class="input100 inputConfirmPass" type="password" name="confirm_pass">
                    <span class="focus-input100"></span>
                </div>

                <div class="container-login100-form-btn p-l-10 p-r-10">
                    <button class="login100-form-btn btnStella1 btn-block submit-btn">
                        Reset Password
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
        $('form').submit();
    });
</script>