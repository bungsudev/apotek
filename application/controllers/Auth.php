<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->model('Role_model');
        $this->load->model('Satuanobat_model');
        $this->load->model('Kategoriobat_model');
        $this->load->model('Supplier_model');
        $this->load->model('Obat_model');
        $this->load->model('Pembelian_model');
        $this->load->model('Penjualan_model');
        $this->load->model('Barangrusak_model');
        $this->load->model('Hargaobat_model');
        $this->load->model('Returobat_model');
        $this->load->model('Returpenjualan_model');
    }
    public function index()
    {
        if(isset($_SESSION['apotek_username'])){
            redirect('dashboard');
        }
        $this->form_validation->set_rules('username', 'username', 'required|trim', array('required' => 'Username must be required'));
        $this->form_validation->set_rules('password', 'password', 'required|trim', array('required' => 'Password must be required'));
        if ($this->form_validation->run() == false) {
            $data['title'] = "Login Page";
            $data['currentPage'] = 'login';

            $this->load->view('shared/admin_header', $data);
            $this->load->view('pages/login');
            $this->load->view('shared/admin_footer', $data);
            if (form_error('username')) {
                echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('username'))) . "|";
                die();
            }
            if (form_error('password')) {
                echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('password'))) . "|";
                die();
            }
            if (validation_errors()) {
                echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", validation_errors())) . "|";
                die();
            }
        } else {
            // Check login data
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['username' => $username])->row_array();
        if ($user) {
            if ($user['is_active'] == '1') {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'apotek_role_id' => $user['role_id'],
                        'apotek_username' => $user['username'],
                        'apotek_user_id' => $user['user_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id']) {
                        echo "Success|Success Login";
                        die();
                    } else {
                        echo "Error| You are not registred as admin yet";
                        die();
                    }
                } else {
                    echo "Error|Wrong password";
                    die();
                }
            } else {
                echo "Error|Username has not been acivated";
                die();
            }
        } else {
            echo "Error|Username is not registered";
            die();
        }
    }
    public function logout()
    {
        // $this->session->sess_destroy();
        $this->session->unset_userdata('apotek_username');
        $this->session->unset_userdata('apotek_role_id');
        $this->session->unset_userdata('apotek_user_id');
        session_destroy();
        $this->session->set_flashdata('message', '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            You have been logout
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('admin');
    }
    public function blocked()
    {
        $this->load->view('blocked');
    }
}