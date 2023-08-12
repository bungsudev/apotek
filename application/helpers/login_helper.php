<?php
function is_admin()
{
    // $this = Untuk memanggil object CI
    $ci = get_instance();
    if ($ci->session->userdata('apotek_role_id') != null) {
        if ($ci->session->userdata('apotek_role_id') != '1') {
            redirect('auth/blocked');
        }
    } else {
        redirect('auth');
    }
}
function is_user()
{
    // $this = Untuk memanggil object CI
    $ci = get_instance();
    if ($ci->session->userdata('apotek_role_id') != null) {
        if ($ci->session->userdata('apotek_role_id') == '3') {
            redirect('nurse');
        }
    } else {
        redirect('auth');
    }
}
function is_logged_in()
{
    // $this = Untuk memanggil object CI
    $ci = get_instance();
    if ($ci->session->userdata('apotek_role_id') == null) {
        // $ci->session->set_flashdata('message', '
        //     <div class="alert alert-warning alert-dismissible fade show" role="alert">
        //        Silahkan login terlebih dahulu sebelum melakukan pemesanan.
        //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //             <span aria-hidden="true">&times;</span>
        //         </button>
        //     </div>');
        redirect('auth/index');
    }
}
