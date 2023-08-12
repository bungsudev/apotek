<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        if(!isset($_SESSION['apotek_username'])){
            redirect('auth');
        }
        $header['title'] = "Admin User";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'user';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['roles'] = $this->Role_model->getRoles();
        $this->load->view('pages/user', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function user_fetch()
    {

        $data = $this->User_model->getAllUser();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {
            if ($row->is_active == '1') {
                $active = 'Active';
                $deleteBtn = '<button class="btn btn-danger btn-sm  mr-2 mb-2 btn-block activeUserButton" data-info="Not Active" data-user_id = ' . $row->user_id . '>Not Active</button>';
            } else {
                $active = 'Not Active';
                $deleteBtn = '<button class="btn btn-secondary btn-sm mr-2 mb-2 btn-block activeUserButton"  data-info="Active" data-user_id = ' . $row->user_id . '>Set Active</button>';
            }
            $output .= '
			<tr>
				<td>' . $row->user_id . '</td>
				<td>' . $row->username . '</td>
				<td>' . $row->role_name . '</td>
				<td>' . $active . '</td>
				<td>' . $deleteBtn . '<button class="btn btn-warning btn-sm  mr-2 mb-2 btn-block editUserButton" data-user_id = ' . $row->user_id . '>Edit</button>' . '</td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }

    public function user_add()
    {

        $this->form_validation->set_rules('username', 'username', 'required|trim');
        $this->form_validation->set_rules('role_id', 'role', 'required|trim');
        $this->form_validation->set_rules('password', 'password', 'required|trim');
        // $this->form_validation->set_error_delimiters('-', '-');
        if ($this->form_validation->run() == false) {
            echo  "Error|Oopss..Please fill all require field with valid value";
            die();
        } else {
            $active = 0;
            if (isset($_POST['is_active'])) {
                $active = 1;
            }
            $data = [
                'user_id' => $this->User_model->getUserId(),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id'),
                'image' => 'defaultimage.png',
                'is_active' => $active,
                'created_datetime' => time(),
                'modified_datetime' => time()
            ];
            $this->User_model->createNewUser($data);
            echo 'Success|Successfully add user';
        }
    }
    public function user_setactive()
    {

        // header("Content-Type: application/json", true);
        $user_id = $_POST['user_id'];
        $is_active = $_POST['is_active'];
        $this->User_model->setActiveNotActive($user_id, $is_active);
        echo json_encode($is_active . "success");
    }

    public function user_selected()
    {

        // header("Content-Type: application/json", true);
        $user_id = $_POST['user_id'];
        echo  json_encode($this->User_model->getOneData($user_id));
    }
    public function user_update()
    {

        $this->form_validation->set_rules('username', 'username', 'required|trim');
        $this->form_validation->set_rules('role_id', 'role', 'required|trim');
        // $this->form_validation->set_error_delimiters('-', '-');
        if ($this->form_validation->run() == false) {
            echo  "Error|Oopss..Please fill all require field with valid value";
            die();
        } else {
            $active = 0;
            if (isset($_POST['is_active'])) {
                $active = 1;
            }
            $data = [
                'username' => $this->input->post('username'),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $active,
                'modified_datetime' => time()
            ];
            $user_id = $this->input->post('user_id');
            $this->User_model->updateUser($data, $user_id);
            echo 'Success|Successfully update user';
        }
    }

   
}