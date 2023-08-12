<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Obat extends CI_Controller
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
        $header['title'] = "Admin Obat";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'obat';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['listCategory'] = $this->Kategoriobat_model->getActiveCategory();
        $data['listSatuan'] = $this->Satuanobat_model->getActiveSatuan();
        $this->load->view('pages/obat', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function obat_add()
    {

        $this->form_validation->set_rules('nama_obat', 'nama obat', 'required|trim');
        $this->form_validation->set_rules('id_kategori', 'kategori obat', 'required|trim');
        $this->form_validation->set_rules('id_satuan', 'satuan obat', 'required|trim');
        // $this->form_validation->set_error_delimiters('-', '-');
        if ($this->form_validation->run() == false) {
            echo  "Error|Oopss..Please fill all require field";
            die();
        } else {

            $uploadimg = $_FILES['image'];
            if (!$uploadimg['name']) {
                $active = 0;
                if (isset($_POST['is_active'])) {
                    $active = 1;
                }
                $jumlah_konversi_1 = 0;
                if ($this->input->post('jumlah_konversi_1') != null) {
                    $jumlah_konversi_1 = $this->input->post('jumlah_konversi_1');
                }
                $jumlah_konversi_2 = 0;
                if ($this->input->post('jumlah_konversi_2') != null) {
                    $jumlah_konversi_2 = $this->input->post('jumlah_konversi_2');
                }
                $jumlah_konversi_3 = 0;
                if ($this->input->post('jumlah_konversi_3') != null) {
                    $jumlah_konversi_3 = $this->input->post('jumlah_konversi_3');
                }
                $data = [
                    'id_obat' => $this->Obat_model->getObatId(),
                    'nama_obat' => $this->input->post('nama_obat'),
                    'id_kategori' => $this->input->post('id_kategori'),
                    'id_satuan' => $this->input->post('id_satuan'),
                    'tipe_obat' => $this->input->post('tipe_obat'),

                    'id_satuan_konversi_1' => $this->input->post('id_satuan_konversi_1'),
                    'id_satuan_konversi_2' => $this->input->post('id_satuan_konversi_2'),
                    'id_satuan_konversi_3' => $this->input->post('id_satuan_konversi_3'),
                    'jumlah_konversi_1' => $jumlah_konversi_1,
                    'jumlah_konversi_2' => $jumlah_konversi_2,
                    'jumlah_konversi_3' => $jumlah_konversi_3,
                    'is_active' => $active,
                    'image' => 'defaultObat.jpg',
                    'created_datetime' => time(),
                    'modified_datetime' => time()
                ];
                $this->Obat_model->createNewobat($data);
                echo 'Success|Successfully add new obat';
            } else {
                // Check file
                $newFileName = time() . str_replace(' ', '', $uploadimg['name']);;
                $config['allowed_types']  = '*';
                $config['max_size'] = '500';
                $config['upload_path'] = './assets/images/admin/obat/';
                $config['file_name'] = $newFileName;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $active = 0;
                    if (isset($_POST['is_active'])) {
                        $active = 1;
                    }
                    $jumlah_konversi_1 = 0;
                    if ($this->input->post('jumlah_konversi_1') != null) {
                        $jumlah_konversi_1 = $this->input->post('jumlah_konversi_1');
                    }
                    $jumlah_konversi_2 = 0;
                    if ($this->input->post('jumlah_konversi_2') != null) {
                        $jumlah_konversi_2 = $this->input->post('jumlah_konversi_2');
                    }
                    $jumlah_konversi_3 = 0;
                    if ($this->input->post('jumlah_konversi_3') != null) {
                        $jumlah_konversi_3 = $this->input->post('jumlah_konversi_3');
                    }
                    $data = [
                        'id_obat' => $this->Obat_model->getObatId(),
                        'nama_obat' => $this->input->post('nama_obat'),
                        'id_kategori' => $this->input->post('id_kategori'),
                        'id_satuan' => $this->input->post('id_satuan'),
                    'tipe_obat' => $this->input->post('tipe_obat'),

                        'min_stok' => $this->input->post('min_stok'),
                        'max_stok' => $this->input->post('max_stok'),
                        'id_satuan_konversi_1' => $this->input->post('id_satuan_konversi_1'),
                        'id_satuan_konversi_2' => $this->input->post('id_satuan_konversi_2'),
                        'id_satuan_konversi_3' => $this->input->post('id_satuan_konversi_3'),
                        'jumlah_konversi_1' => $jumlah_konversi_1,
                        'jumlah_konversi_2' => $jumlah_konversi_2,
                        'jumlah_konversi_3' => $jumlah_konversi_3,
                        'is_active' => $active,
                        'image' => $newFileName,
                        'created_datetime' => time(),
                        'modified_datetime' => time()
                    ];
                    $this->Obat_model->createNewobat($data);
                    echo 'Success|Successfully add new obat';
                } else {
                    echo 'Error|' . $this->upload->display_errors('', '');
                }
            }
        }
    }

    function obat_fetch()
    {

        $data = $this->Obat_model->getAllobat();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Kategori Obat</th>
                            <th>Satuan Obat</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {
            if ($row->is_active == '1') {
                $active = 'Active';
                $deleteBtn = '<button class="btn btn-danger btn-sm  mr-2 mb-2 btn-block activeObatButton" data-info="Not Active" data-id_obat = ' . $row->id_obat . '>Not Active</button>';
            } else {
                $active = 'Not Active';
                $deleteBtn = '<button class="btn btn-secondary btn-sm mr-2 mb-2 btn-block activeObatButton"  data-info="Active" data-id_obat = ' . $row->id_obat . '>Set Active</button>';
            }
            $additional = "";
            $output .= '
			<tr>
				<td>' . $row->nama_obat . '</td>
				<td>' . $row->nama_kategori_obat . '</td>
				<td>' . $row->nama_satuan_obat . '</td>
				<td>' . $row->stok . ' ' . $row->nama_satuan_obat . '</td>
				<td><img src="' . base_url() . 'assets/images/admin/obat/' . $row->image . '" class="img-responsive img-thumbnail" width="100" height="100" alt=""></td>
				<td>' . $active . '</td>
				<td>' . $deleteBtn . ' <button class="btn btn-info btn-sm editObatButton mr-2 mb-2 btn-block" data-id_obat = ' . $row->id_obat . '>Edit</button><a href="' . base_url() . 'obat/harga_obat/' . $row->id_obat . '"><button class="btn btn-success btn-sm mr-2 mb-2 btn-block">Kelola Harga</button></a></td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }
    function obat_fetch_serverside(){
        $list = $this->Obat_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $msg = '';
            $call = '';
            if ($field->is_active == '1') {
                $active = 'Active';
                $deleteBtn = '<button class="btn btn-danger btn-sm  mr-2 mb-2 btn-block activeObatButton" data-info="Not Active" data-id_obat = ' . $field->id_obat . '>Not Active</button>';
            } else {
                $active = 'Not Active';
                $deleteBtn = '<button class="btn btn-secondary btn-sm mr-2 mb-2 btn-block activeObatButton"  data-info="Active" data-id_obat = ' . $field->id_obat . '>Set Active</button>';
            }
            $tipe = ' <span  style="margin-top:auto;color:blue;font-weight:bold" >'.$field->nama_obat.'</span>';
            if($field->tipe_obat == 'Obat Bebas Terbatas'){
                $tipe = ' <span  style="margin-top:auto;color:green;font-weight:bold" >'.$field->nama_obat.'</span>';
            }else if($field->tipe_obat == 'Obat Keras'){
                $tipe = ' <span  style="margin-top:auto;color:red;font-weight:bold" >'.$field->nama_obat.'</span>';
            }
            $no++;
            $row = array();
            $row[] = $tipe;
            $row[] = $field->nama_kategori_obat;
            $row[] = $field->nama_satuan_obat;
            $row[] = $field->stok . ' ' . $field->nama_satuan_obat;
            $row[] = '<img src="' . base_url() . 'assets/images/admin/obat/' . $field->image . '" class="img-responsive img-thumbnail" width="100" height="100" alt="">';
            $row[]=$active;
            $row[]=$deleteBtn . ' <button class="btn btn-info btn-sm editObatButton mr-2 mb-2 btn-block" data-id_obat = ' . $field->id_obat . '>Edit</button><a href="' . base_url() . 'obat/harga_obat/' . $field->id_obat . '"><button class="btn btn-success btn-sm mr-2 mb-2 btn-block">Kelola Harga</button></a>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Obat_model->count_all(),
            "recordsFiltered" => $this->Obat_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    function obat_setactive()
    {

        // header("Content-Type: application/json", true);
        $id_obat = $_POST['id_obat'];
        $is_active = $_POST['is_active'];
        $this->Obat_model->setActiveNotActive($id_obat, $is_active);
        echo json_encode($is_active . "success");
    }

    function obat_selected()
    {

        // header("Content-Type: application/json", true);
        $id_obat = $_POST['id_obat'];
        echo  json_encode($this->Obat_model->getOneData($id_obat));
    }
    public function obat_update()
    {

        $this->form_validation->set_rules('nama_obat', 'nama obat', 'required|trim');
        $this->form_validation->set_rules('id_kategori', 'kategori obat', 'required|trim');
        $this->form_validation->set_rules('id_satuan', 'satuan obat', 'required|trim');
        // $this->form_validation->set_error_delimiters('-', '-');
        if ($this->form_validation->run() == false) {
            echo  "Error|Oopss..Please fill all require field";
            die();
        } else {

            $uploadimg = $_FILES['image'];
            if (!$uploadimg['name']) {
                $active = 0;
                if (isset($_POST['is_active'])) {
                    $active = 1;
                }
                $jumlah_konversi_1 = 0;
                if ($this->input->post('jumlah_konversi_1') != null) {
                    $jumlah_konversi_1 = $this->input->post('jumlah_konversi_1');
                }
                $jumlah_konversi_2 = 0;
                if ($this->input->post('jumlah_konversi_2') != null) {
                    $jumlah_konversi_2 = $this->input->post('jumlah_konversi_2');
                }
                $jumlah_konversi_3 = 0;
                if ($this->input->post('jumlah_konversi_3') != null) {
                    $jumlah_konversi_3 = $this->input->post('jumlah_konversi_3');
                }
                $data = [
                    'nama_obat' => $this->input->post('nama_obat'),
                    'id_kategori' => $this->input->post('id_kategori'),
                    'id_satuan' => $this->input->post('id_satuan'),
                    'tipe_obat' => $this->input->post('tipe_obat'),

                    'min_stok' => $this->input->post('min_stok'),
                    'max_stok' => $this->input->post('max_stok'),
                    'id_satuan_konversi_1' => $this->input->post('id_satuan_konversi_1'),
                    'id_satuan_konversi_2' => $this->input->post('id_satuan_konversi_2'),
                    'id_satuan_konversi_3' => $this->input->post('id_satuan_konversi_3'),
                    'jumlah_konversi_1' => $jumlah_konversi_1,
                    'jumlah_konversi_2' => $jumlah_konversi_2,
                    'jumlah_konversi_3' => $jumlah_konversi_3,
                    'is_active' => $active,
                    'image' => 'defaultObat.jpg',
                    'created_datetime' => time(),
                    'modified_datetime' => time()
                ];
                $id_obat = $this->input->post('id_obat');
                $this->Obat_model->updateobat($data, $id_obat);
                echo 'Success|Successfully edit obat';
            } else {
                // Check file
                $newFileName = time() . str_replace(' ', '', $uploadimg['name']);;
                $config['allowed_types']  = '*';
                $config['max_size'] = '500';
                $config['upload_path'] = './assets/images/admin/obat/';
                $config['file_name'] = $newFileName;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $active = 0;
                    if (isset($_POST['is_active'])) {
                        $active = 1;
                    }
                    $jumlah_konversi_1 = 0;
                    if ($this->input->post('jumlah_konversi_1') != null) {
                        $jumlah_konversi_1 = $this->input->post('jumlah_konversi_1');
                    }
                    $jumlah_konversi_2 = 0;
                    if ($this->input->post('jumlah_konversi_2') != null) {
                        $jumlah_konversi_2 = $this->input->post('jumlah_konversi_2');
                    }
                    $jumlah_konversi_3 = 0;
                    if ($this->input->post('jumlah_konversi_3') != null) {
                        $jumlah_konversi_3 = $this->input->post('jumlah_konversi_3');
                    }
                    $data = [
                        'nama_obat' => $this->input->post('nama_obat'),
                        'id_kategori' => $this->input->post('id_kategori'),
                        'id_satuan' => $this->input->post('id_satuan'),
                    'tipe_obat' => $this->input->post('tipe_obat'),

                        'id_satuan_konversi_1' => $this->input->post('id_satuan_konversi_1'),
                        'id_satuan_konversi_2' => $this->input->post('id_satuan_konversi_2'),
                        'id_satuan_konversi_3' => $this->input->post('id_satuan_konversi_3'),
                        'jumlah_konversi_1' => $jumlah_konversi_1,
                        'jumlah_konversi_2' => $jumlah_konversi_2,
                        'jumlah_konversi_3' => $jumlah_konversi_3,
                        'is_active' => $active,
                        'image' => $newFileName,
                        'created_datetime' => time(),
                        'modified_datetime' => time()
                    ];
                    $id_obat = $this->input->post('id_obat');
                    $this->Obat_model->updateobat($data, $id_obat);
                    echo 'Success|Successfully edit obat';
                } else {
                    echo 'Error|' . $this->upload->display_errors('', '');
                }
            }
        }
    }
    public function harga_obat($id_obat)
    {

        $header['title'] = "Admin Satuan Obat";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'harga_obat';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['id_obat'] = $id_obat;
        $currentObat = $this->Obat_model->getCurrentobat($id_obat);
        $data['satuan_available'] = [];
        if ($currentObat['id_satuan'] != '') {
            $satuanAwal = $this->Satuanobat_model->getOneData($currentObat['id_satuan']);
            array_push($data['satuan_available'], $satuanAwal);
        }
        if ($currentObat['id_satuan_konversi_1'] != '') {
            $satuanAwal1 = $this->Satuanobat_model->getOneData($currentObat['id_satuan_konversi_1']);
            array_push($data['satuan_available'], $satuanAwal1);
        }
        if ($currentObat['id_satuan_konversi_2'] != '') {
            $satuanAwal2 = $this->Satuanobat_model->getOneData($currentObat['id_satuan_konversi_2']);
            array_push($data['satuan_available'], $satuanAwal2);
        }
        if ($currentObat['id_satuan_konversi_3'] != '') {
            $satuanAwal3 = $this->Satuanobat_model->getOneData($currentObat['id_satuan_konversi_3']);
            array_push($data['satuan_available'], $satuanAwal3);
        }
        $data['obat'] = $currentObat;
        $this->load->view('pages/harga_obat', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function harga_obat_fetch($id_obat)
    {

        $data = $this->Hargaobat_model->getHargaObat($id_obat);
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Nama Satuan Obat</th>
                            <th>Jumlah Obat</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {

            $output .= '
			<tr>
				<td>' . $row->nama_satuan_obat . '</td>
				<td>' . $row->jumlah . '</td>
				<td>' . $row->harga . '</td>
                <td>' .
                '<button class="btn btn-danger btn-sm  mr-2 mb-2 btn-block deleteHargaButton " data-id_satuan = ' . $row->id_satuan . ' data-id_obat = ' . $row->id_obat . ' data-jumlah = ' . $row->jumlah . '>Delete</button>' .
                '</td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }

    public function harga_obat_add()
    {

        $this->form_validation->set_rules('id_satuan', 'satuan obat', 'required|trim');
        $this->form_validation->set_rules('harga', 'harga obat', 'required|trim');
        $this->form_validation->set_rules('jumlah', 'jumlah obat', 'required|trim');
        if ($this->form_validation->run() == false) {
            echo  "Error|" . str_replace('</p>', '', str_replace('<p>', '', validation_errors()));
            die();
        } else {
            $data = [
                'id_obat' => $this->input->post('id_obat'),
                'id_satuan' => $this->input->post('id_satuan'),
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
            ];
            if ($this->Hargaobat_model->cekAvailableRow($data['id_obat'], $data['id_satuan'], $data['jumlah']) == 0) {
                $this->Hargaobat_model->createNewharga_obat($data);
                echo 'Success|Berhasil menambah satuan obat';
            } else {
                echo 'Error|Maaf harga obat dengan kuantiti dan jumlah tersebut sudah tersedia, silahkan gunakan parameter lain';
            }
        }
    }
    public function harga_obat_delete()
    {

        // header("Content-Type: application/json", true);
        $id_satuan = $_POST['id_satuan'];
        $id_obat = $_POST['id_obat'];
        $jumlah = $_POST['jumlah'];
        $this->db->query("DELETE FROM harga_obat where id_satuan = '$id_satuan' AND id_obat='$id_obat'  AND jumlah='$jumlah'");
        echo json_encode("success");
    }

    public function harga_obat_selected()
    {

        // header("Content-Type: application/json", true);
        $id_satuan = $_POST['id_satuan'];
        $id_obat = $_POST['id_obat'];
        $jumlah = $_POST['jumlah'];
        echo  json_encode($this->db->query("SELECT * FROM harga_obat h inner join satuan_obat s on h.id_satuan = s.id_satuan where h.id_satuan = '$id_satuan' AND id_obat = '$id_obat' AND jumlah = '$jumlah'")->row_array());
    }
    public function harga_obat_update()
    {

        $this->form_validation->set_rules('id_satuan', 'satuan obat', 'required|trim');
        $this->form_validation->set_rules('harga', 'harga obat', 'required|trim');
        $this->form_validation->set_rules('jumlah', 'jumlah obat', 'required|trim');
        if ($this->form_validation->run() == false) {
            echo  "Error|" . str_replace('</p>', '', str_replace('<p>', '', validation_errors()));
            die();
        } else {
            $id_satuan = $_POST['id_satuan'];
            $id_obat = $_POST['id_obat'];
            $harga = $_POST['harga'];
            $jumlah = $_POST['jumlah'];
            $data = [
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
            ];
            if ($this->Hargaobat_model->cekAvailableRow($data['id_obat'], $data['id_satuan'], $data['jumlah']) == 0) {
                $this->db->query("UPDATE harga_obat set jumlah = '$jumlah', harga='$harga' where id_satuan = '$id_satuan' AND id_obat = '$id_obat'");
                echo 'Success|Berhasil mengubah satuan obat';
            } else {
                echo 'Error|Maaf harga obat dengan kuantiti dan jumlah tersebut sudah tersedia, silahkan gunakan parameter lain';
            }
        }
    }
}