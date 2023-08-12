<div class="limiter" id="loginSection">
    <div class="container-login100  pb-mobile">
        <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
            <form class="login100-form validate-form flex-sb flex-w" id="formLogin" action="<?= base_url() ?>auth/index" method="POST">
                <span class="login100-form-title p-b-32 text-center">
                    Login
                </span>
                <?php if ($this->session->flashdata('message')) {
                    echo $this->session->flashdata('message');
                } ?>
                <span class="txt1 p-b-11">
                    Email
                </span>
                <div class="wrap-input100 validate-input m-b-15" data-validate="Email is required">
                    <input class="input100 inputPass" type="text" name="email">
                    <span class="focus-input100"></span>
                </div>

                <span class="txt1 p-b-11">
                    Password
                </span>
                <div class="wrap-input100 validate-input m-b-15" data-validate="Password is required">
                    <span class="btn-show-pass">
                        <i class="fa fa-eye"></i>
                    </span>
                    <input class="input100 inputPass" type="password" name="pass">
                    <span class="focus-input100"></span>
                </div>
                <div class="flex-sb-m w-full p-b-48">
                    <div class="contact100-form-checkbox">
                        <a href="<?= base_url() ?>auth/registration" class="txt3 border-bottom-stella">
                            Buat Akun
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
                        Masuk
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    $('.btn-show-pass').click(function() {
        if ($(this).html().trim() == '<i class="fa fa-eye"></i>') {
            $(this).html('<i class="fa fa-eye-slash"></i>')
            $('.inputPass').attr('type', 'text');
        } else {
            $(this).html('<i class="fa fa-eye"></i>')
            $('.inputPass').attr('type', 'password');
        }
    })
    $('.submit-btn').on('click', function(e) {
        e.preventDefault();
        $('.loading').show();
        // $('form').submit();
        var form_data = new FormData($('#formLogin')[0])
        $.ajax({
            url: '<?= base_url() ?>auth/index',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(response) {
                $('.loading').hide()
                message = response.split("|")
                if (message[0].trim() == 'Error') {
                    if (message[1]) {
                        swalError(message[0], message[1])
                    } else {
                        window.location.href = "<?= base_url() ?>auth/index"
                    }
                } else if (message[0].trim() == 'Success') {
                    swalSuccess(message[0], message[1])

                    // setTimeout(() => {
                    if (message[2] == 3) {
                        setTimeout(() => {
                            window.location.href = "<?= base_url() ?>/nurse";

                        }, 2000);
                    } else {
                        setTimeout(() => {
                            window.location.href = "<?= base_url() ?>/user";

                        }, 2000);
                    }

                    // }, 2000);
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
                swalError('Error ', 'Silahkan login kembali');
                setTimeout(() => {
                    window.location.href = "<?= base_url() ?>auth/index"
                }, 2000);
            }
        })
    });
</script>