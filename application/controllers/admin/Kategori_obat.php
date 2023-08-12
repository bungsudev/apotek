<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_obat extends CI_Controller
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
        $header['title'] = "Admin Kategori Obat";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'kategori_obat';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['roles'] = $this->Role_model->getRoles();
        $this->load->view('pages/kategori_obat', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function kategori_obat_fetch()
    {

        $data = $this->Kategoriobat_model->getAllKategoriObat();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Id Kategori</th>
                            <th>Nama Kategori Obat</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {
            if ($row->is_active == '1') {
                $active = 'Active';
                $deleteBtn = '<button class="btn btn-danger btn-sm  mr-2 mb-2 btn-block activeUserButton" data-info="Not Active" data-id_kategori = ' . $row->id_kategori . '>Not Active</button>';
            } else {
                $active = 'Not Active';
                $deleteBtn = '<button class="btn btn-secondary btn-sm mr-2 mb-2 btn-block activeUserButton"  data-info="Active" data-id_kategori = ' . $row->id_kategori . '>Set Active</button>';
            }
            $output .= '
			<tr>
				<td>' . $row->id_kategori . '</td>
				<td>' . $row->nama_kategori_obat . '</td>
				<td>' . $active . '</td>
				<td>' . $deleteBtn . '<button class="btn btn-warning btn-sm  mr-2 mb-2 btn-block editkategoriObat" data-id_kategori = ' . $row->id_kategori . '>Edit</button>' . '</td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }

    public function kategori_obat_add()
    {

        $this->form_validation->set_rules('nama_kategori_obat', 'nama satuan obat', 'required|trim|is_unique[kategori_obat.nama_kategori_obat]');
        if ($this->form_validation->run() == false) {
            echo  "Error|" . str_replace('</p>', '', str_replace('<p>', '', validation_errors()));
            die();
        } else {
            $active = 0;
            if (isset($_POST['is_active'])) {
                $active = 1;
            }
            $data = [
                'id_kategori' => $this->Kategoriobat_model->getKategoriId(),
                'nama_kategori_obat' => $this->input->post('nama_kategori_obat'),
                'is_active' => $active,
                'created_datetime' => time(),
                'modified_datetime' => time()
            ];
            $this->Kategoriobat_model->createNewkategori_obat($data);
            echo 'Success|Berhasil menambah kategori obat';
        }
    }
    public function kategori_obat_setactive()
    {

        // header("Content-Type: application/json", true);
        $id_kategori = $_POST['id_kategori'];
        $is_active = $_POST['is_active'];
        $this->Kategoriobat_model->setActiveNotActive($id_kategori, $is_active);
        echo json_encode($is_active . "success");
    }

    public function kategori_obat_selected()
    {

        // header("Content-Type: application/json", true);
        $id_kategori = $_POST['id_kategori'];
        echo  json_encode($this->Kategoriobat_model->getOneData($id_kategori));
    }
    public function kategori_obat_update()
    {

        $id_kategori = $this->input->post('id_kategori');
        $original_value = $this->db->query("SELECT * FROM kategori_obat WHERE id_kategori = '" . $id_kategori . "'")->row_array();
        if ($this->input->post('nama_kategori_obat') != $original_value['nama_kategori_obat']) {
            $is_unique1 =  '|is_unique[kategori_obat.nama_kategori_obat]';
        } else {
            $is_unique1 =  '';
        }
        $this->form_validation->set_rules('nama_kategori_obat', 'nama satuan obat', 'required|trim' . $is_unique1);
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
                'nama_kategori_obat' => $this->input->post('nama_kategori_obat'),
                'is_active' => $active,
                'modified_datetime' => time()
            ];
            $this->Kategoriobat_model->updatekategori_obat($data, $id_kategori);
            echo 'Success|Berhasil mengubah satuan obat';
        }
    }
}