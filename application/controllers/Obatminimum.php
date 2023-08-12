<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Obatminimum extends CI_Controller
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
        $header['title'] = "Admin Obat Minim";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'obatminimum';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $this->load->view('pages/obatminimum', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    function obatminimum_fetch()
    {
        $query = "SELECT o.*,k.nama_kategori_obat,s.nama_satuan_obat FROM obat o inner join kategori_obat k on k.id_kategori = o.id_kategori inner join satuan_obat s on s.id_satuan = o.id_satuan Where o.stok > 0 AND o.stok < min_stok";
        $data =  $this->db->query($query);
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Kategori Obat</th>
                            <th>Satuan Obat</th>
                            <th>Stok Sekarang</th>
                            <th>Stok Minimum</th>
                            <th>Gambar</th>
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
				<td>' . $row->min_stok . ' ' . $row->nama_satuan_obat . '</td>
				<td><img src="' . base_url() . 'assets/images/admin/obat/' . $row->image . '" class="img-responsive img-thumbnail" width="100" height="100" alt=""></td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }
}