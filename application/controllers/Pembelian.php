<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
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
        $header['title'] = "Admin Pembelian";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'pembelian';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['listCategory'] = $this->Kategoriobat_model->getActiveCategory();
        $data['listSatuan'] = $this->Satuanobat_model->getActiveSatuan();
        $this->load->view('pages/pembelian', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function add_pembelian()
    {

        $header['title'] = "Admin Pembelian";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'pembelian';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['listSupplier'] = $this->Supplier_model->getActiveSupplier();
        $data['listCategory'] = $this->Kategoriobat_model->getActiveCategory();
        $data['listSatuan'] = $this->Satuanobat_model->getActiveSatuan();
        $data['listObat'] = $this->Obat_model->getActiveobat();
        $this->load->view('pages/add_pembelian', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    function add_pembelian_action()
    {

        // header("Content-Type: application/json", true);

        $supplier = $_POST['supplier'];
        $tanggal_pembelian = $_POST['tanggal_pembelian'];
        $jam_pembelian = $_POST['jam_pembelian'];
        $nama_pembeli = $_POST['nama_pembeli'];
        $keranjang_pembelian = $_POST['keranjang_pembelian'];
        $total_pembelian = $_POST['total_pembelian'];
        $pembelianHeader = [
            'id_pembelian' => $this->Pembelian_model->getPembelianId(),
            'id_supplier' => $supplier[0],
            'total_pembelian' => $total_pembelian,
            'tanggal_pembelian' => $tanggal_pembelian,
            'jam_pembelian' => $jam_pembelian,
            'nama_pembeli' => $nama_pembeli,
            'created_datetime' => time(),
            'modified_datetime' => time()
        ];

        $this->Pembelian_model->createNewpembelian($pembelianHeader);
        foreach ($keranjang_pembelian as $cart) {
            $pembelianDetail = [
                'id_pembelian' => $pembelianHeader['id_pembelian'],
                'id_obat' => $cart['id_obat'],
                'jumlah_beli' => $cart['jumlah_beli'],
                'harga_beli' => $cart['harga_beli'],
                'diskon' => $cart['diskon'],
                'nomor_batch' => $cart['nomor_batch'],
                'expired_date' => $cart['expired_date'],
                'ppn' => $cart['ppn'],
                'created_datetime' => time(),
                'modified_datetime' => time()
            ];
            $this->Pembelian_model->createNewpembelianDetail($pembelianDetail);

            // Update Stok Obat
            $query = "UPDATE obat set stok = stok + " . $cart['jumlah_beli'] . " WHERE id_obat = '" . $cart['id_obat'] . "'";
            $query = $this->db->query($query);
        }
        echo json_encode($pembelianHeader['id_pembelian']);
    }
    function pembelian_fetch()
    {
        $data = $this->Pembelian_model->getAllPembelian();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Id Pembelian</th>
                            <th>Nama Supplier</th>
                            <th>Nama Kasir</th>
                            <th>Tanggal Pembelian</th>
                            <th>Total Pembelian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {
            $output .= '
			<tr>
				<td>' . $row->id_pembelian . '</td>
				<td>' . $row->nama_supplier . '</td>
				<td>' . $row->nama_pembeli . '</td>
				<td>' . date("d-F-Y", strtotime($row->tanggal_pembelian)) . ' ' . $row->jam_pembelian . '</td>
				<td> Rp.' . number_format($row->total_pembelian, 0, ",", ".") . '</td>
                <td><a href="' . base_url() . 'pembelian/detail_pembelian/' . $row->id_pembelian . '"<button class="btn btn-success btn-sm mr-2 mb-2 btn-block">Detail Pembelian</button></a>
                <a href="' . base_url() . 'pembelian/retur_pembelian/' . $row->id_pembelian . '"<button class="btn btn-warning btn-sm mr-2 mt-2 mb-2 btn-block">Retur Obat</button></a></td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }
    function pembelian_fetch_serverside(){
        $list = $this->Pembelian_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            
            $no++;
            $row = array();
            $row[] = $field->id_pembelian;
            $row[] = $field->nama_supplier;
            $row[] = $field->nama_pembeli;
            $row[] = date("d-m-Y",strtotime($field->tanggal_pembelian))." ".$field->jam_pembelian;
            $row[] = "Rp.".number_format($field->total_pembelian,0,",",".");
            $row[] = '<a href="' . base_url() . 'pembelian/detail_pembelian/' . $field->id_pembelian . '"<button class="btn btn-success btn-sm mr-2 mb-2 btn-block">Detail Pembelian</button></a>
            <a href="' . base_url() . 'pembelian/retur_pembelian/' . $field->id_pembelian . '"<button class="btn btn-warning btn-sm mr-2 mt-2 mb-2 btn-block">Retur Obat</button></a>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Pembelian_model->count_all(),
            "recordsFiltered" => $this->Pembelian_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    function detail_pembelian($id_pembelian)
    {

        $header['title'] = "Admin Pembelian";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'pembelian';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['pembelian'] = $this->Pembelian_model->getOneData($id_pembelian);
        $data['pembelian_detail'] = $this->Pembelian_model->getPembelianDetail($id_pembelian);
        $this->load->view('pages/detail_pembelian', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    function retur_pembelian($id_pembelian)
    {

        $header['title'] = "Admin Retur Pembelian";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'pembelian';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['pembelian'] = $this->Pembelian_model->getOneData($id_pembelian);
        $data['pembelian_detail'] = $this->Pembelian_model->getPembelianDetail($id_pembelian);
        $this->load->view('pages/retur_pembelian', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    function pembelian_detail_selected()
    {

        // header("Content-Type: application/json", true);
        $id_pembelian_detail = $_POST['id_pembelian_detail'];
        echo  json_encode($this->Pembelian_model->getOneDataDetail($id_pembelian_detail));
    }
    public function cetak_invoice_pembelian($id_pembelian)
    {

        $data['pembelian'] = $this->Pembelian_model->getOneData($id_pembelian);
        $data['pembelian_detail'] = $this->Pembelian_model->getPembelianDetail($id_pembelian);
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('invoice/invoice_pembelian', $data);
    }
    public function retur_action()
    {

        $id_pembelian = $_POST['id_pembelian'];
        $id_pembelian_detail = $_POST['id_pembelian_detail'];
        $id_obat = $_POST['id_obat'];
        $jumlah_retur = $_POST['jumlah_retur'];
        $tanggal_retur = $_POST['tanggal_retur'];
        $jam_retur = $_POST['jam_retur'];
        $keterangan = $_POST['keterangan'];
        $kasir = $_SESSION['apotek_username'];
        // Check barang yang diretur lebih gede ga dari yg dibeli
        // Insert Retur
        $dataInsert = [
            'id_retur' => $this->Returobat_model->getReturId(),
            'id_pembelian' => $id_pembelian,
            'id_pembelian_detail' => $id_pembelian_detail,
            'id_obat' => $id_obat,
            'jumlah_retur' => $jumlah_retur,
            'tanggal_retur' => $tanggal_retur,
            'jam_retur' => $jam_retur,
            'keterangan' => $keterangan,
            'kasir' => $kasir,
        ];
        $this->Returobat_model->createNewretur_pembelian($dataInsert);
        // Update Stok Obat
        $queryObat = "UPDATE obat set stok = stok - '$jumlah_retur' where id_obat ='$id_obat'";
        $this->db->query($queryObat);

        echo json_encode("Success");
    }
}