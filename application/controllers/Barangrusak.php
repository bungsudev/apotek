<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barangrusak extends CI_Controller
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
        $header['title'] = "Admin Obat Rusak";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'barangrusak';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $this->load->view('pages/barangrusak', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function add_barangrusak()
    {

        $header['title'] = "Admin Penjualan";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'barangrusak';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['listSupplier'] = $this->Supplier_model->getActiveSupplier();
        $data['listCategory'] = $this->Kategoriobat_model->getActiveCategory();
        $data['listSatuan'] = $this->Satuanobat_model->getActiveSatuan();
        $data['listObat'] = $this->Obat_model->getActiveobat();
        $this->load->view('pages/add_barangrusak', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    function add_barangrusak_action()
    {
        // header("Content-Type: application/json", true);
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        $jam_transaksi = $_POST['jam_transaksi'];
        $keranjang_obat_rusak = $_POST['keranjang_obat_rusak'];
        $total_barangrusak = $_POST['total_barangrusak'];

        $barangrusakHeader = [
            'id_barang_rusak' => $this->Barangrusak_model->getBarangrusakId(),
            'tanggal_transaksi' => $tanggal_transaksi,
            'jam_transaksi' => $jam_transaksi,
            'total_barangrusak' => $total_barangrusak,
            'kasir' => $_SESSION['apotek_username'],
            'created_datetime' => time(),
            'modified_datetime' => time()
        ];

        $this->Barangrusak_model->createNewbarangrusak($barangrusakHeader);
        foreach ($keranjang_obat_rusak as $cart) {
            $barangrusakDetail = [
                'id_barang_rusak' => $barangrusakHeader['id_barang_rusak'],
                'id_obat' => $cart['id_obat'],
                'jumlah_rusak' => $cart['jumlah_obat'],
                'created_datetime' => time(),
                'modified_datetime' => time()
            ];
            $this->Barangrusak_model->createNewbarangrusakDetail($barangrusakDetail);

            // Update Stok Obat
            $query = "UPDATE obat set stok = stok - " . $cart['jumlah_obat'] . " WHERE id_obat = '" . $cart['id_obat'] . "'";
            $query = $this->db->query($query);
        }
        echo json_encode($barangrusakHeader['id_barang_rusak']);
    }
    function barangrusak_fetch()
    {
        $data = $this->Barangrusak_model->getAllBarangrusak()->result_array();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Tanggal Transaksi</th>
                            <th>Jumlah Obat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data as $row) {
            $output .= '
			<tr>
				<td>' . $row['nama_obat'] . '</td>
				<td>' . date("d-F-Y", strtotime($row['tanggal_transaksi'])) . '</td>
				<td>' . $row['jumlah_rusak'] . '</td>
                <td>
                    <a href="' . base_url() . 'barangrusak/detail_barangrusak/' . $row['id_barang_rusak'] . '"><button class="btn btn-success btn-sm mr-2 mt-2 mb-2 btn-block">Detail Transaksi</button></a>
                </td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }
    function detail_barangrusak($id_barang_rusak)
    {

        $header['title'] = "Admin Penjualan";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'barangrusak';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['barangrusak'] = $this->Barangrusak_model->getOneData($id_barang_rusak);
        $data['barangrusak_detail'] = $this->Barangrusak_model->getBarangrusakDetail($id_barang_rusak);
        $this->load->view('pages/detail_barangrusak', $data);
        $this->load->view('shared/admin_footer', $data);
    }

    public function cetak_invoice_barangrusak($id_barang_rusak)
    {
        $data['barangrusak'] = $this->Barangrusak_model->getOneData($id_barang_rusak);
        $data['barangrusak_detail'] = $this->Barangrusak_model->getBarangrusakDetail($id_barang_rusak);
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('invoice/invoice_barangrusak', $data);
    }
    
}