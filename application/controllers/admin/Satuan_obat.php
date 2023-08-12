<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Satuan_obat extends CI_Controller
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
        $header['title'] = "Admin Satuan Obat";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'satuan_obat';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['roles'] = $this->Role_model->getRoles();
        $this->load->view('pages/satuan_obat', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function satuan_obat_fetch()
    {

        $data = $this->Satuanobat_model->getAllSatuanObat();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Id Satuan</th>
                            <th>Nama Satuan Obat</th>
                            <th>Kode Satuan Obat</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {
            if ($row->is_active == '1') {
                $active = 'Active';
                $deleteBtn = '<button class="btn btn-danger btn-sm  mr-2 mb-2 btn-block activeUserButton" data-info="Not Active" data-id_satuan = ' . $row->id_satuan . '>Not Active</button>';
            } else {
                $active = 'Not Active';
                $deleteBtn = '<button class="btn btn-secondary btn-sm mr-2 mb-2 btn-block activeUserButton"  data-info="Active" data-id_satuan = ' . $row->id_satuan . '>Set Active</button>';
            }
            $output .= '
			<tr>
				<td>' . $row->id_satuan . '</td>
				<td>' . $row->nama_satuan_obat . '</td>
				<td>' . $row->kode_satuan_obat . '</td>
				<td>' . $active . '</td>
				<td>' . $deleteBtn . '<button class="btn btn-warning btn-sm  mr-2 mb-2 btn-block editSatuanObat" data-id_satuan = ' . $row->id_satuan . '>Edit</button>' . '</td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }

    public function satuan_obat_add()
    {

        $this->form_validation->set_rules('nama_satuan_obat', 'nama satuan obat', 'required|trim|is_unique[satuan_obat.nama_satuan_obat]');
        $this->form_validation->set_rules('kode_satuan_obat', 'kode satuan obat', 'required|trim|is_unique[satuan_obat.kode_satuan_obat]');
        if ($this->form_validation->run() == false) {
            echo  "Error|" . str_replace('</p>', '', str_replace('<p>', '', validation_errors()));
            die();
        } else {
            $active = 0;
            if (isset($_POST['is_active'])) {
                $active = 1;
            }
            $data = [
                'id_satuan' => $this->Satuanobat_model->getSatuanId(),
                'nama_satuan_obat' => $this->input->post('nama_satuan_obat'),
                'kode_satuan_obat' => $this->input->post('kode_satuan_obat'),
                'is_active' => $active,
                'created_datetime' => time(),
                'modified_datetime' => time()
            ];
            $this->Satuanobat_model->createNewsatuan_obat($data);
            echo 'Success|Berhasil menambah satuan obat';
        }
    }
    public function satuan_obat_setactive()
    {

        // header("Content-Type: application/json", true);
        $id_satuan = $_POST['id_satuan'];
        $is_active = $_POST['is_active'];
        $this->Satuanobat_model->setActiveNotActive($id_satuan, $is_active);
        echo json_encode($is_active . "success");
    }

    public function satuan_obat_selected()
    {

        // header("Content-Type: application/json", true);
        $id_satuan = $_POST['id_satuan'];
        echo  json_encode($this->Satuanobat_model->getOneData($id_satuan));
    }
    public function satuan_obat_update()
    {

        $id_satuan = $this->input->post('id_satuan');
        $original_value = $this->db->query("SELECT * FROM satuan_obat WHERE id_satuan = '" . $id_satuan . "'")->row_array();
        if ($this->input->post('nama_satuan_obat') != $original_value['nama_satuan_obat']) {
            $is_unique1 =  '|is_unique[satuan_obat.nama_satuan_obat]';
        } else {
            $is_unique1 =  '';
        }
        if ($this->input->post('kode_satuan_obat') != $original_value['kode_satuan_obat']) {
            $is_unique2 =  '|is_unique[satuan_obat.kode_satuan_obat]';
        } else {
            $is_unique2 =  '';
        }
        $this->form_validation->set_rules('nama_satuan_obat', 'nama satuan obat', 'required|trim' . $is_unique1);
        $this->form_validation->set_rules('kode_satuan_obat', 'kode satuan obat', 'required|trim' . $is_unique2);
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
                'nama_satuan_obat' => $this->input->post('nama_satuan_obat'),
                'kode_satuan_obat' => $this->input->post('kode_satuan_obat'),
                'is_active' => $active,
                'modified_datetime' => time()
            ];
            $this->Satuanobat_model->updatesatuan_obat($data, $id_satuan);
            echo 'Success|Berhasil mengubah satuan obat';
        }
    }
}