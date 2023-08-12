<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
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
        $header['title'] = "Admin Profil Apotek";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'profil';
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $this->load->view('pages/profil', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function profil_update()
    {
        $this->form_validation->set_rules('nama_apotek', 'nama apotek', 'required|trim');
        $this->form_validation->set_rules('alamat_apotek', 'alamat apotek', 'required|trim');
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
                $data = [
                    'nama_apotek' => $this->input->post('nama_apotek'),
                    'alamat_apotek' => $this->input->post('alamat_apotek'),
                    'no_hp' => $this->input->post('no_hp')
                ];
                $id_apotek = $this->input->post('id_apotek');
                $this->db->where('id_apotek', $id_apotek);
                $this->db->update('apotek_profile', $data);
                echo 'Success|Successfully update profil|' . $id_apotek;
            } else {
                // Check file
                $newFileName = time() . str_replace(' ', '', $uploadimg['name']);
                $config['allowed_types']  = '*';
                $config['max_size'] = '2000000';
                $config['upload_path'] = './assets/profil/';
                $config['file_name'] = $newFileName;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    if (file_exists('./assets/profil/' . $this->input->post('old_image')) && $this->input->post('old_image') != 'default_image.png') {
                        unlink('./assets/profil/' . $this->input->post('old_image'));
                    }
                    $data = [
                        'nama_apotek' => $this->input->post('nama_apotek'),
                        'alamat_apotek' => $this->input->post('alamat_apotek'),
                        'no_hp' => $this->input->post('no_hp'),
                        'image' => $newFileName
                    ];
                    $id_apotek = $this->input->post('id_apotek');
                    $this->db->where('id_apotek', $id_apotek);
                    $this->db->update('apotek_profile', $data);
                    echo 'Success|Successfully update profil';
                } else {
                    echo 'Error|' . $this->upload->display_errors('', '');
                }
            }
        }
    }
}