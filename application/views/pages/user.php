<!-- Begin Page Content -->
<div class="container-fluid" id="adminUser">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">User</h1>
        <a href="#" data-toggle="modal" data-target="#UserModal" id="buttonAddNew" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white "></i> Add New User</a>
    </div>
    <?php
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    }
    ?>
    <p class="mb-4">Manage user</a>.</p>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTableUser">

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<!-- Modal Add -->
<div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="UserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="formUser" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="user_id" id="user_id" class="form-control">
                        <label for="menu">Username</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
                    </div>
                    <div class="form-group" id="passwordUser">
                        <label for="menu">Default Password</label>
                        <input type="text" name="password" class="form-control" id="password" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                        <label for="role_id">User Role</label>
                        <select name="role_id" id="role_id" class="form-control selectpicker" data-live-search="true">
                            <?php
                            foreach ($roles as $role) {
                                ?>
                                <option value="<?= $role['role_id'] ?>"><?= $role['role_name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="is_active" type="checkbox" id="is_active">
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                            <p class="text-primary">* If you check the active field, the User will be active</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="addUser">Add User</button>
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
        var quill = new Quill('#quillEditor', {
            theme: 'snow'
        });

        getListUser();

        function getListUser() {
            $('.loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>user/user_fetch",
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
        // Add User
        $(document).on('click', ".addUserSubmit", function() {
            $('.loading').show()
            var form_data = new FormData($('#formUser')[0])
            console.log(form_data)
            $.ajax({
                url: '<?= base_url() ?>user/user_add',
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
                        $('#formUser').trigger("reset");
                        $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
                        $('#is_active').prop('checked', true);
                        getListUser();
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
            const user_id = $(this).data('user_id');
            const info = $(this).data('info');
            if (info == 'Active') {
                active = 1;
            } else {
                active = 0;
            }
            Swal.fire({
                title: "Are you sure?",
                text: 'This User will be set as "' + info + '" if you press confirm button.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {
                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>user/user_setactive',
                        data: {
                            user_id: user_id,
                            is_active: active
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            $('.loading').hide()
                            swalSuccess('Success', 'Success set User as "' + info + '"')
                            getListUser();
                        },
                        err(e) {
                            console.log(e)
                            $('.loading').hide()
                        }
                    })

                }
            })
        });
        $(document).on('click', ".resetPasswordButton", function() {
            const user_id = $(this).data('user_id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            Swal.fire({
                title: "Are you sure?",
                text: 'Reset password will be sent to "' + name + '" with email "' + email + '" if you press confirm button.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm!"
            }).then((result) => {

                if (result.value) {
                    $('.loading').show()
                    $.ajax({
                        url: '<?= base_url() ?>user/reset_password',
                        data: {
                            user_id: user_id,
                            name: name,
                            email: email
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            $('.loading').hide()
                            swalSuccess('Success', 'Success send email reset password to "' + email + '"')
                            getListUser();
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
            $('#formUser').trigger("reset");
            $('.custom-file-input').next('.custom-file-label').addClass('selected').html('')
            $('#is_active').prop('checked', true);
            $('#passwordUser').show();
            $('#role_id').val('')

            $('#UserModal #UserModalLabel').html('Add New User')
            $('#UserModal #addUser').html('Add New User')
            $('#addUser').addClass('addUserSubmit')
            $('#addUser').removeClass('editUserSubmit')
            $('#UserModal').modal('show');
        })
        $(document).on('click', ".editUserButton", function() {
            const user_id = $(this).data('user_id');
            $.ajax({
                url: '<?= base_url() ?>user/user_selected',
                data: {
                    user_id: user_id
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $('#passwordUser').hide();

                    $('#user_id').val(data['user_id'])
                    $('#role_id').val(data['role_id'])
                    $('#role_name').val(data['role_name'])
                    $('select[name=role_id]').val(data['role_id']);
                    $('.selectpicker').selectpicker('refresh')
                    $('#username').val(data['username'])
                    $('#email').val(data['email'])
                    $('#no_handphone').val(data['no_handphone'])
                    if (data['is_active'] == '1') {
                        $("#is_active").prop("checked", true);
                    } else {
                        $("#is_active").prop("checked", false);
                    }
                    $('#UserModal #UserModalLabel').html('Edit User')
                    $('#UserModal #addUser').html('Edit User')
                    $('#addUser').removeClass('addUserSubmit')
                    $('#addUser').addClass('editUserSubmit')
                    $('#UserModal').modal('show');
                },
                err(e) {
                    console.log(e)
                }
            })
        })
        // Edit Submit
        $(document).on('click', ".editUserSubmit", function() {
            $('.loading').show()
            var form_data = new FormData($('#formUser')[0])
            $.ajax({
                url: '<?= base_url() ?>user/user_update',
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
                        $('#formUser').trigger("reset");

                        $('#is_active').prop('checked', true);
                        getListUser();
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