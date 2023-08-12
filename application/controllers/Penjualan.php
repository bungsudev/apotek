<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
        $header['title'] = "Admin Penjualan";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'penjualan';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['listCategory'] = $this->Kategoriobat_model->getActiveCategory();
        $data['listSatuan'] = $this->Satuanobat_model->getActiveSatuan();
        $this->load->view('pages/penjualan', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function add_penjualan()
    {


        $header['title'] = "Admin Penjualan";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'penjualan';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['listSupplier'] = $this->Supplier_model->getActiveSupplier();
        $data['listCategory'] = $this->Kategoriobat_model->getActiveCategory();
        $data['listSatuan'] = $this->Satuanobat_model->getActiveSatuan();
        $data['listObat'] = $this->Obat_model->getObatToSell();
        $this->load->view('pages/add_penjualan', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    function add_penjualan_action()
    {
        // header("Content-Type: application/json", true);
        $nama_pembeli = $_POST['nama_pembeli'];
        $tanggal_penjualan = $_POST['tanggal_penjualan'];
        $jam_penjualan = $_POST['jam_penjualan'];
        $keranjang_penjualan = $_POST['keranjang_penjualan'];
        $total_penjualan = $_POST['total_penjualan'];

        $penjualanHeader = [
            'id_penjualan' => $this->Penjualan_model->getPenjualanId(),
            'nama_pembeli' => $nama_pembeli,
            'total_penjualan' => $total_penjualan,
            'tanggal_penjualan' => $tanggal_penjualan,
            'jam_penjualan' => $jam_penjualan,
            'created_datetime' => time(),
            'modified_datetime' => time()
        ];

        $this->Penjualan_model->createNewpenjualan($penjualanHeader);

        $teks = '';
        foreach ($keranjang_penjualan as $cart) {
            $penjualanDetail = [
                'id_penjualan' => $penjualanHeader['id_penjualan'],
                'id_obat' => $cart['id_obat'],
                'id_satuan' => $cart['id_satuan'],
                'jumlah_jual' => $cart['jumlah_jual'],
                'harga_jual' => $cart['harga_jual'],
                'diskon' => $cart['diskon'],
                'ppn' => $cart['ppn'],
                'created_datetime' => time(),
                'modified_datetime' => time()
            ];
            $errorStok = false;
            $this->Penjualan_model->createNewpenjualanDetail($penjualanDetail);
            $currentObat = $this->Obat_model->getCurrentobat($cart['id_obat']);
            if ($currentObat['id_satuan_konversi_1'] == $cart['id_satuan']) {
                $query = "UPDATE obat set stok = stok - " . ($cart['jumlah_jual'] * $currentObat['jumlah_konversi_1']) . " WHERE id_obat = '" . $cart['id_obat'] . "'";
                if (($cart['jumlah_jual'] *  $currentObat['jumlah_konversi_1']) >   $currentObat['stok']) {
                    $errorStok = true;
                }
                $teks .= ($cart['jumlah_jual'] *  $currentObat['jumlah_konversi_1']) . "|" .  $currentObat['stok'] . "|error di pertama";
            } else if ($currentObat['id_satuan_konversi_2'] == $cart['id_satuan']) {
                $query = "UPDATE obat set stok = stok - " . ($cart['jumlah_jual'] *  $currentObat['jumlah_konversi_2']) . " WHERE id_obat = '" . $cart['id_obat'] . "'";
                if (($cart['jumlah_jual'] *  $currentObat['jumlah_konversi_2']) >   $currentObat['stok']) {
                    $errorStok = true;
                }
                $teks .= ($cart['jumlah_jual'] *  $currentObat['jumlah_konversi_2']) . "|" .  $currentObat['stok'] . "|error di kedua";
            } else {
                $query = "UPDATE obat set stok = stok - " .  $cart['jumlah_jual'] . " WHERE id_obat = '" . $cart['id_obat'] . "'";
                if (($cart['jumlah_jual']) >   $currentObat['stok']) {
                    $errorStok = true;
                }
                $teks .=  ($cart['jumlah_jual']) . "|" .   $currentObat['stok'] . "|error di ketiga";
            }
            // Update Stok Obat
            $this->db->query($query);
        }
        if ($errorStok == false) {
            echo json_encode('Success|Penjualan berhasil dibuat|' . $penjualanHeader['id_penjualan']);
        } else {
            // Delete All Detail and Get Back the Stok
            $id_header = $penjualanHeader['id_penjualan'];
            $query = "SELECT * from penjualan_detail where id_penjualan = '$id_header'";
            $dataDetail = $this->db->query($query)->result_array();
            foreach ($dataDetail as $detail) {
                $currentObat = $this->Obat_model->getCurrentobat($detail['id_obat']);
                if ($currentObat['id_satuan_konversi_1'] == $detail['id_satuan']) {
                    $query2 = "UPDATE obat set stok = stok + " . ($detail['jumlah_jual'] * $currentObat['jumlah_konversi_1']) . " WHERE id_obat = '" . $detail['id_obat'] . "'";
                } else if ($currentObat['id_satuan_konversi_2'] == $detail['id_satuan']) {
                    $query2 = "UPDATE obat set stok = stok + " . ($detail['jumlah_jual'] * $currentObat['jumlah_konversi_2']) . " WHERE id_obat = '" . $detail['id_obat'] . "'";
                } else {
                    $query2 = "UPDATE obat set stok = stok + " . $detail['jumlah_jual'] . " WHERE id_obat = '" . $detail['id_obat'] . "'";
                }
                $this->db->query($query2);
            }
            $queryDeleteDetail = "DELETE FROM penjualan_detail WHERE id_penjualan = '$id_header'";
            $this->db->query($queryDeleteDetail);
            $queryDeleteHeader = "DELETE FROM penjualan WHERE id_penjualan = '$id_header'";
            $this->db->query($queryDeleteHeader);
            echo json_encode('Error|Stok tidak cukup untuk melakukan penjualan|' . $penjualanHeader['id_penjualan']);
        }
    }
    function penjualan_fetch()
    {
        $data = $this->Penjualan_model->getAllPenjualan();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Id Penjualan</th>
                            <th>Nama Penjual / Kasir</th>
                            <th>Tanggal Penjualan</th>
                            <th>Total Penjualan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {
            if ($_SESSION['apotek_role_id'] == 3) {
                if ($row->nama_pembeli == $_SESSION['apotek_username']) {
                    $output .= '
                    <tr>
                        <td>' . $row->id_penjualan . '</td>
                        <td>' . $row->nama_pembeli . '</td>
                        <td>' . date("d-F-Y", strtotime($row->tanggal_penjualan)) . ' ' . $row->jam_penjualan . '</td>
                        <td> Rp.' . number_format($row->total_penjualan, 0, ",", ".") . '</td>
                        <td>
                            <a href="' . base_url() . 'detail_penjualan/' . $row->id_penjualan . '"<button class="btn btn-success btn-sm mr-2 mt-2 mb-2 btn-block">Detail Penjualan</button> </a> 
                            <a href="' . base_url() . 'retur_penjualan/' . $row->id_penjualan . '"<button class="btn btn-warning btn-sm mr-2 mt-2 mb-2 btn-block">Retur Obat</button></a>
                        </td>
                    </tr>
                    ';
                }
            } else {
                $output .= '
			<tr>
				<td>' . $row->id_penjualan . '</td>
				<td>' . $row->nama_pembeli . '</td>
				<td>' . date("d-F-Y", strtotime($row->tanggal_penjualan)) . ' ' . $row->jam_penjualan . '</td>
				<td> Rp.' . number_format($row->total_penjualan, 0, ",", ".") . '</td>
                <td>
                    <a href="' . base_url() . 'detail_penjualan/' . $row->id_penjualan . '"<button class="btn btn-success btn-sm mr-2 mt-2 mb-2 btn-block">Detail Penjualan</button> </a> 
                    <a href="' . base_url() . 'retur_penjualan/' . $row->id_penjualan . '"<button class="btn btn-warning btn-sm mr-2 mt-2 mb-2 btn-block">Retur Obat</button></a>
                </td>
			</tr>
			';
            }
        }
        $output .= '</tbody></table>';
        echo $output;
    }
    function penjualan_fetch_serverside(){
        $list = $this->Penjualan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            
            $no++;
            $row = array();
            $row[] = $field->id_penjualan;
            $row[] = $field->nama_pembeli;
            $row[] = date("d-m-Y",strtotime($field->tanggal_penjualan))." ".$field->jam_penjualan;
            $row[] = "Rp.".number_format($field->total_penjualan,0,",",".");
            $row[] = '<a href="' . base_url() . 'penjualan/detail_penjualan/' . $field->id_penjualan . '"<button class="btn btn-success btn-sm mr-2 mt-2 mb-2 btn-block">Detail Penjualan</button> </a> 
            <a href="' . base_url() . 'penjualan/retur_penjualan/' . $field->id_penjualan . '"<button class="btn btn-warning btn-sm mr-2 mt-2 mb-2 btn-block">Retur Obat</button></a>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Penjualan_model->count_all(),
            "recordsFiltered" => $this->Penjualan_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    function detail_penjualan($id_penjualan)
    {


        $header['title'] = "Admin Penjualan";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'penjualan';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['penjualan'] = $this->Penjualan_model->getOneData($id_penjualan);
        $data['penjualan_detail'] = $this->Penjualan_model->getPenjualanDetail($id_penjualan);
        $this->load->view('pages/detail_penjualan', $data);
        $this->load->view('shared/admin_footer', $data);
    }

    public function cetak_invoice_penjualan($id_penjualan)
    {
        $data['penjualan'] = $this->Penjualan_model->getOneData($id_penjualan);
        $data['penjualan_detail'] = $this->Penjualan_model->getPenjualanDetail($id_penjualan);
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('invoice/invoice_penjualan', $data);
    }
    
    function penjualan_detail_selected()
    {

        // header("Content-Type: application/json", true);
        $id_penjualan_detail = $_POST['id_penjualan_detail'];
        echo  json_encode($this->Penjualan_model->getOneDataDetail($id_penjualan_detail));
    }
    function get_satuan_by_obat()
    {

        // header("Content-Type: application/json", true);
        $id_obat = $_POST['id_obat'];
        $currentObat = $this->Obat_model->getCurrentobat($id_obat);
        $dataReturn = [];
        if ($currentObat['id_satuan'] != '') {
            $satuanAwal = $this->Satuanobat_model->getOneData($currentObat['id_satuan']);
            array_push($dataReturn, $satuanAwal);
        }
        if ($currentObat['id_satuan_konversi_1'] != '') {
            $satuanAwal1 = $this->Satuanobat_model->getOneData($currentObat['id_satuan_konversi_1']);
            array_push($dataReturn, $satuanAwal1);
        }
        if ($currentObat['id_satuan_konversi_2'] != '') {
            $satuanAwal2 = $this->Satuanobat_model->getOneData($currentObat['id_satuan_konversi_2']);
            array_push($dataReturn, $satuanAwal2);
        }
        if ($currentObat['id_satuan_konversi_3'] != '') {
            $satuanAwal3 = $this->Satuanobat_model->getOneData($currentObat['id_satuan_konversi_3']);
            array_push($dataReturn, $satuanAwal3);
        }
        $text = '<option value="">-- Pilih Satuan --</option>';
        foreach ($dataReturn as $data) {
            $text .= '<option value="' . $data['id_satuan'] . '|' . $data['nama_satuan_obat'] . '">' . $data['nama_satuan_obat'] . '</option>';
        }
        echo  json_encode($text);
    }
    public function getHargaObat()
    {
        $id_obat = $_POST['id_obat'];
        $id_satuan = $_POST['id_satuan'];
        $jumlah = $_POST['jumlah'];

        $dataReturn = $this->Hargaobat_model->getHarga($id_obat, $id_satuan, $jumlah);
        echo json_encode($dataReturn);
    }
    function retur_penjualan($id_penjualan)
    {
        $header['title'] = "Admin Retur Penjualan";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'penjualan';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $data['penjualan'] = $this->Penjualan_model->getOneData($id_penjualan);
        $data['penjualan_detail'] = $this->Penjualan_model->getPenjualanDetail($id_penjualan);
        $this->load->view('pages/retur_penjualan', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    public function retur_penjualan_action()
    {

        $id_penjualan = $_POST['id_penjualan'];
        $id_penjualan_detail = $_POST['id_penjualan_detail'];
        $id_obat = $_POST['id_obat'];
        $jumlah_retur = $_POST['jumlah_retur'];
        $tanggal_retur = $_POST['tanggal_retur'];
        $jam_retur = $_POST['jam_retur'];
        $keterangan = $_POST['keterangan'];
        $kasir = $_SESSION['apotek_username'];

        // Insert Retur
        $dataInsert = [
            'id_retur' => $this->Returpenjualan_model->getReturId(),
            'id_penjualan' => $id_penjualan,
            'id_penjualan_detail' => $id_penjualan_detail,
            'id_obat' => $id_obat,
            'jumlah_retur' => $jumlah_retur,
            'tanggal_retur' => $tanggal_retur,
            'jam_retur' => $jam_retur,
            'keterangan' => $keterangan,
            'kasir' => $kasir
        ];
        $this->Returpenjualan_model->createNewretur_penjualan($dataInsert);
        // Update Stok Obat
        $queryObat = "UPDATE obat set stok = stok + '$jumlah_retur' where id_obat ='$id_obat'";
        $this->db->query($queryObat);

        echo json_encode("Success");
    }
    function obat_selected()
    {

        // header("Content-Type: application/json", true);
        $id_obat = $_POST['id_obat'];
        echo  json_encode($this->Obat_model->getOneData($id_obat));
    }
}