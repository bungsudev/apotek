<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
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
        $header['title'] = "Admin Supplier";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'supplier';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['roles'] = $this->Role_model->getRoles();
        $this->load->view('pages/supplier', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function supplier_fetch()
    {

        $data = $this->Supplier_model->getAllSupplier();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Id Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Kota</th>
                            <th>Email</th>
                            <th>No Handphone</th>
                            <th>Alamat Lengkap</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {
            if ($row->is_active == '1') {
                $active = 'Active';
                $deleteBtn = '<button class="btn btn-danger btn-sm  mr-2 mb-2 btn-block activeUserButton" data-info="Not Active" data-id_supplier = ' . $row->id_supplier . '>Not Active</button>';
            } else {
                $active = 'Not Active';
                $deleteBtn = '<button class="btn btn-secondary btn-sm mr-2 mb-2 btn-block activeUserButton"  data-info="Active" data-id_supplier = ' . $row->id_supplier . '>Set Active</button>';
            }
            $output .= '
			<tr>
				<td>' . $row->id_supplier . '</td>
				<td>' . $row->nama_supplier . '</td>
				<td>' . $row->kota_supplier . '</td>
				<td>' . $row->email_supplier . '</td>
				<td>' . $row->telp_supplier . '</td>
				<td>' . $row->alamat_supplier . '</td>
				<td>' . $active . '</td>
				<td>' . $deleteBtn . '<button class="btn btn-warning btn-sm  mr-2 mb-2 btn-block editsupplier" data-id_supplier = ' . $row->id_supplier . '>Edit</button>' . '</td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }

    public function supplier_add()
    {

        $this->form_validation->set_rules('nama_supplier', 'nama supplier', 'required|trim|is_unique[supplier.nama_supplier]');
        $this->form_validation->set_rules('kota_supplier', 'kota', 'required|trim');
        $this->form_validation->set_rules('alamat_supplier', 'alamat', 'required|trim');
        $this->form_validation->set_rules('telp_supplier', 'nomor handphone supplier', 'trim');
        $this->form_validation->set_rules('email_supplier', 'email supplier', 'trim');
        if ($this->form_validation->run() == false) {
            echo  "Error|" . str_replace('</p>', '', str_replace('<p>', '', validation_errors()));
            die();
        } else {
            $active = 0;
            if (isset($_POST['is_active'])) {
                $active = 1;
            }
            $data = [
                'id_supplier' => $this->Supplier_model->getSupplierId(),
                'nama_supplier' => $this->input->post('nama_supplier'),
                'telp_supplier' => $this->input->post('telp_supplier'),
                'alamat_supplier' => $this->input->post('alamat_supplier'),
                'email_supplier' => $this->input->post('email_supplier'),
                'kota_supplier' => $this->input->post('kota_supplier'),
                'is_active' => $active,
                'created_datetime' => time(),
                'modified_datetime' => time()
            ];
            $this->Supplier_model->createNewsupplier($data);
            echo 'Success|Berhasil menambah supplier';
        }
    }
    public function supplier_setactive()
    {

        // header("Content-Type: application/json", true);
        $id_supplier = $_POST['id_supplier'];
        $is_active = $_POST['is_active'];
        $this->Supplier_model->setActiveNotActive($id_supplier, $is_active);
        echo json_encode($is_active . "success");
    }

    public function supplier_selected()
    {

        // header("Content-Type: application/json", true);
        $id_supplier = $_POST['id_supplier'];
        echo  json_encode($this->Supplier_model->getOneData($id_supplier));
    }
    public function supplier_update()
    {

        $id_supplier = $this->input->post('id_supplier');
        $original_value = $this->db->query("SELECT * FROM supplier WHERE id_supplier = '" . $id_supplier . "'")->row_array();
        if ($this->input->post('nama_supplier') != $original_value['nama_supplier']) {
            $is_unique1 =  '|is_unique[supplier.nama_supplier]';
        } else {
            $is_unique1 =  '';
        }
        $this->form_validation->set_rules('nama_supplier', 'nama satuan obat', 'required|trim' . $is_unique1);
        $this->form_validation->set_rules('kota_supplier', 'kota', 'required|trim');
        $this->form_validation->set_rules('alamat_supplier', 'alamat', 'required|trim');
        $this->form_validation->set_rules('telp_supplier', 'nomor handphone supplier', 'trim');
        $this->form_validation->set_rules('email_supplier', 'email supplier', 'trim');
        // $this->form_validation->set_error_delimiters('-', '-');
        if ($this->form_validation->run() == false) {
            echo  "Error|" . str_replace('</p>', '', str_replace('<p>', '', validation_errors()));
            die();
        } else {
            $active = 0;
            if (isset($_POST['is_active'])) {
                $active = 1;
            }
            $data = [
                'nama_supplier' => $this->input->post('nama_supplier'),
                'telp_supplier' => $this->input->post('telp_supplier'),
                'alamat_supplier' => $this->input->post('alamat_supplier'),
                'email_supplier' => $this->input->post('email_supplier'),
                'kota_supplier' => $this->input->post('kota_supplier'),
                'is_active' => $active,
                'modified_datetime' => time()
            ];
            $this->Supplier_model->updatesupplier($data, $id_supplier);
            echo 'Success|Berhasil mengubah supplier';
        }
    }
}