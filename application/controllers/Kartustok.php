<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kartustok extends CI_Controller
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
        $header['title'] = "Admin Kartu Stok";
        $this->load->view('shared/admin_header', $header);

        $data['currentPage'] = 'kartustok';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $this->load->view('pages/kartustok', $data);
        $this->load->view('shared/admin_footer', $data);
    }
    function kartustok_fetch()
    {

        $data = $this->Obat_model->getAllobat();
        $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Sisa Stok</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        foreach ($data->result() as $row) {
            $output .= '
			<tr>
				<td>' . $row->nama_obat . '</td>
				<td>' . $row->stok . ' ' . $row->nama_satuan_obat . '</td>
				<td><img src="' . base_url() . 'assets/images/admin/obat/' . $row->image . '" class="img-responsive img-thumbnail" width="100" height="100" alt=""></td>
				
				<td>' . ' <button class="btn btn-success btn-sm mr-2 mb-2 btn-block cetakKartuStok" data-id_obat="' . $row->id_obat . '" data-nama_obat="' . $row->nama_obat . '"><i class="fa fa-print"></i> Cetak Kartu Stok</button></td>
			</tr>
			';
        }
        $output .= '</tbody></table>';
        echo $output;
    }
    function kartustok_fetch_serverside(){
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
            $no++;
            $row = array();
            $row[] = $field->nama_obat;
            $row[] = $field->stok . ' ' . $field->nama_satuan_obat;
            $row[] = '<img src="' . base_url() . 'assets/images/admin/obat/' . $field->image . '" class="img-responsive img-thumbnail" width="100" height="100" alt="">';
            $row[]='<button class="btn btn-success btn-sm mr-2 mb-2 btn-block cetakKartuStok" data-id_obat="' . $field->id_obat . '" data-nama_obat="' . $field->nama_obat . '"><i class="fa fa-print"></i> Cetak Kartu Stok</button>';
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
    public function cetakkartustok($id_obat = '', $date1 = '', $date2 = '')
    {
        ob_start();
        if (!empty($date1) && !empty($date2)) {
            if ($date1 == '' && $date1 == null && $date2 == '' && $date2 == null) {
                $dateR1 = date('Y-m-01');
                $dateR2 = date('Y-m-t');
            } else {
                if ($date1) {
                    $dateR1 = $date1;
                } else {
                    $dateR1 = date('Y-m-01');
                }

                if ($date2) {
                    $dateR2 = $date2;
                } else {
                    $dateR2 = date('Y-m-t');
                }
            }
        } else {
            $dateR1 = date('Y-m-01');
            $dateR2 = date('Y-m-t');
        }
        // echo $id_obat.$dateR1.$dateR2;
        $currentObat = $this->Obat_model->getOneData($id_obat);

        // Get Stok Sebelum Tanggal Mulai
        $stokSebelum = 0;
        $dataPembelianSebelum = $this->Pembelian_model->getPembelianDetailBeforeDate($id_obat, $dateR1);
        if ($dataPembelianSebelum) {
            foreach ($dataPembelianSebelum as $pembelian) {
                $stokSebelum += $pembelian['jumlah_beli'];
            }
        }
        $dataPenjualanSebelum = $this->Penjualan_model->getPenjualanDetailBeforeDate($id_obat, $dateR1);
        if ($dataPenjualanSebelum) {
            foreach ($dataPenjualanSebelum as $penjualan) {
                if ($currentObat['id_satuan_konversi_1'] == $penjualan['id_satuan']) {
                    $stokSebelum -= ($penjualan['jumlah_jual'] * $currentObat['jumlah_konversi_1']);
                } else if ($currentObat['id_satuan_konversi_2'] == $penjualan['id_satuan']) {
                    $stokSebelum -= ($penjualan['jumlah_jual'] * $currentObat['jumlah_konversi_2']);
                } else {
                    $stokSebelum -= $penjualan['jumlah_jual'];
                }
            }
        }
        // Retur pembelian
        $returSebelum = $this->Returobat_model->getReturBeforeDate($id_obat, $dateR1);
        if ($returSebelum) {
            foreach ($returSebelum as $retur) {
                $stokSebelum -= $retur['jumlah_retur'];
            }
        }

        // Retur penjualan
        $returSebelum = $this->Returpenjualan_model->getReturBeforeDate($id_obat, $dateR1);
        if ($returSebelum) {
            foreach ($returSebelum as $retur) {
                $stokSebelum += $retur['jumlah_retur'];
            }
        }

        $rusakSebelum = $this->Barangrusak_model->getBarangRusakBeforeDare($id_obat, $dateR1);
        if ($rusakSebelum) {
            foreach ($rusakSebelum as $rusak) {
                $stokSebelum -= $rusak['jumlah_rusak'];
            }
        }
        $dataReport = [];
        $data = [
            'tanggal' => $dateR1." 00:00:00",
            'keterangan' => 'Stok awal obat sebelum tanggal ' . date_format(date_create($dateR1), "d-F-Y"),
            'masuk' => $stokSebelum,
            'keluar' => 0,
            'kasir' => 'Sistem'
        ];
        array_push($dataReport, $data);

        // Get Report By Selected Date
        $stokRange = 0;
        $dataPembelianRange = $this->Pembelian_model->getPembelianDetailRange($id_obat, $dateR1, $dateR2);
        if ($dataPembelianRange) {
            foreach ($dataPembelianRange as $pembelian) {
                $data = [
                    'tanggal' => $pembelian['tanggal_pembelian'] . ' ' . $pembelian['jam_pembelian'],
                    'keterangan' => 'Transaksi Pembelian dari ' . $pembelian['nama_supplier'],
                    'masuk' => $pembelian['jumlah_beli'],
                    'keluar' => 0,
                    'kasir' => $pembelian['nama_pembeli']
                ];
                array_push($dataReport, $data);
            }
        }
        $dataPenjualanRange = $this->Penjualan_model->getPenjualanDetailRange($id_obat, $dateR1, $dateR2);
        if ($dataPenjualanRange) {
            foreach ($dataPenjualanRange as $penjualan) {
                if ($currentObat['id_satuan_konversi_1'] == $penjualan['id_satuan']) {
                    $jumlahJual = ($penjualan['jumlah_jual'] * $currentObat['jumlah_konversi_1']);
                } else if ($currentObat['id_satuan_konversi_2'] == $penjualan['id_satuan']) {
                    $jumlahJual = ($penjualan['jumlah_jual'] * $currentObat['jumlah_konversi_2']);
                } else {
                    $jumlahJual = $penjualan['jumlah_jual'];
                }

                $data = [
                    'tanggal' => $penjualan['tanggal_penjualan'] . ' ' . $penjualan['jam_penjualan'],
                    'keterangan' => 'Transaksi Penjualan oleh ' . $penjualan['nama_pembeli'],
                    'masuk' => 0,
                    'keluar' => $jumlahJual,
                    'kasir' => $penjualan['nama_pembeli']

                ];
                array_push($dataReport, $data);
            }
        }
        $returRange = $this->Returobat_model->getReturRange($id_obat, $dateR1, $dateR2);
        if ($returRange) {
            foreach ($returRange as $retur) {
                $data = [
                    'tanggal' => $retur['tanggal_retur'] . ' ' . $retur['jam_retur'],
                    'keterangan' => 'Transaksi Retur Pembelian Obat dari ' . $retur['nama_supplier'],
                    'masuk' => 0,
                    'keluar' => $retur['jumlah_retur'],
                    'kasir' => $retur['kasir']

                ];
                array_push($dataReport, $data);
            }
        }

        $returRange = $this->Returpenjualan_model->getReturRange($id_obat, $dateR1, $dateR2);
        if ($returRange) {
            foreach ($returRange as $retur) {
                $data = [
                    'tanggal' => $retur['tanggal_retur'] . ' ' . $retur['jam_retur'],
                    'keterangan' => 'Transaksi Retur Penjualan Obat oleh ' . $retur['nama_pembeli'],
                    'keluar' => 0,
                    'masuk' => $retur['jumlah_retur'],
                    'kasir' => $retur['kasir']

                ];
                array_push($dataReport, $data);
            }
        }
        $rusakRange = $this->Barangrusak_model->getBarangRusakRange($id_obat, $dateR1, $dateR2);
        if ($rusakRange) {
            foreach ($rusakRange as $rusak) {
                $data = [
                    'tanggal' => $rusak['tanggal_transaksi'] . ' ' . $rusak['jam_transaksi'],
                    'keterangan' => 'Transaksi Obat Rusak / Dimusnahkan',
                    'masuk' => 0,
                    'keluar' => $rusak['jumlah_rusak'],
                    'kasir' => $rusak['kasir']

                ];
                array_push($dataReport, $data);
            }
        }
        // echo var_dump($dataReport);
        // echo "<br>";
        $tanggal = array_column($dataReport, 'tanggal');
        array_multisort($tanggal, SORT_ASC, $dataReport);
        // echo var_dump($dataReport);
        $data['report'] =  $dataReport;
        $data['obat'] = $currentObat;
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('pages/downloadkartustok', $data);

        $html = ob_get_contents();
        require_once('./vendor/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('L', 'A4', 'en');
        $pdf->WriteHTML($html);

        ob_end_clean();
        // $result = $pdf->Output('Laporan Pendapatan.pdf', 'F');
        $result = $pdf->Output('Kartu Stok ' . $currentObat['nama_obat'] . '.pdf', 'F');
        header("Content-type:application/pdf");
        echo file_get_contents('Kartu Stok ' . $currentObat['nama_obat'] . '.pdf');
    }

    public function lihatkartustok($id_obat = '', $date1 = '', $date2 = '')
    {
        if (!empty($date1) && !empty($date2)) {
            if ($date1 == '' && $date1 == null && $date2 == '' && $date2 == null) {
                $dateR1 = date('Y-m-01');
                $dateR2 = date('Y-m-t');
            } else {
                if ($date1) {
                    $dateR1 = $date1;
                } else {
                    $dateR1 = date('Y-m-01');
                }

                if ($date2) {
                    $dateR2 = $date2;
                } else {
                    $dateR2 = date('Y-m-t');
                }
            }
        } else {
            $dateR1 = date('Y-m-01');
            $dateR2 = date('Y-m-t');
        }
        $dateR1 = $dateR1;
        $dateR2 = $dateR2;
        // echo $id_obat.$dateR1.$dateR2;
        $currentObat = $this->Obat_model->getOneData($id_obat);

        // Get Stok Sebelum Tanggal Mulai
        $stokSebelum = 0;
        $dataPembelianSebelum = $this->Pembelian_model->getPembelianDetailBeforeDate($id_obat, $dateR1." 00:00:00");
        if ($dataPembelianSebelum) {
            foreach ($dataPembelianSebelum as $pembelian) {
                $stokSebelum += $pembelian['jumlah_beli'];
            }
        }
        $dataPenjualanSebelum = $this->Penjualan_model->getPenjualanDetailBeforeDate($id_obat, $dateR1." 00:00:00");
        if ($dataPenjualanSebelum) {
            foreach ($dataPenjualanSebelum as $penjualan) {
                if ($currentObat['id_satuan_konversi_1'] == $penjualan['id_satuan']) {
                    $stokSebelum -= ($penjualan['jumlah_jual'] * $currentObat['jumlah_konversi_1']);
                } else if ($currentObat['id_satuan_konversi_2'] == $penjualan['id_satuan']) {
                    $stokSebelum -= ($penjualan['jumlah_jual'] * $currentObat['jumlah_konversi_2']);
                } else {
                    $stokSebelum -= $penjualan['jumlah_jual'];
                }
            }
        }
        // Retur pembelian
        $returSebelum = $this->Returobat_model->getReturBeforeDate($id_obat, $dateR1);
        if ($returSebelum) {
            foreach ($returSebelum as $retur) {
                $stokSebelum -= $retur['jumlah_retur'];
            }
        }

        // Retur penjualan
        $returSebelum = $this->Returpenjualan_model->getReturBeforeDate($id_obat, $dateR1);
        if ($returSebelum) {
            foreach ($returSebelum as $retur) {
                $stokSebelum += $retur['jumlah_retur'];
            }
        }
        $rusakSebelum = $this->Barangrusak_model->getBarangRusakBeforeDare($id_obat, $dateR1);
        if ($rusakSebelum) {
            foreach ($rusakSebelum as $rusak) {
                $stokSebelum -= $rusak['jumlah_rusak'];
            }
        }
        $dataReport = [];
        $data = [
            'tanggal' => $dateR1." 00:00:00",
            'keterangan' => 'Stok awal obat sebelum tanggal ' . date_format(date_create($dateR1), "d-F-Y"),
            'masuk' => $stokSebelum,
            'keluar' => 0,
            'kasir' => 'Sistem',
        ];
        array_push($dataReport, $data);

        // Get Report By Selected Date
        $stokRange = 0;
        $dataPembelianRange = $this->Pembelian_model->getPembelianDetailRange($id_obat, $dateR1, $dateR2);
        if ($dataPembelianRange) {
            foreach ($dataPembelianRange as $pembelian) {
                $data = [
                    'tanggal' => $pembelian['tanggal_pembelian'] . ' ' . $pembelian['jam_pembelian'],
                    'keterangan' => 'Transaksi Pembelian dari ' . $pembelian['nama_supplier'],
                    'masuk' => $pembelian['jumlah_beli'],
                    'keluar' => 0,
                    'kasir' => $pembelian['nama_pembeli']
                ];
                array_push($dataReport, $data);
            }
        }
        $dataPenjualanRange = $this->Penjualan_model->getPenjualanDetailRange($id_obat, $dateR1, $dateR2);
        if ($dataPenjualanRange) {
            foreach ($dataPenjualanRange as $penjualan) {
                if ($currentObat['id_satuan_konversi_1'] == $penjualan['id_satuan']) {
                    $jumlahJual = ($penjualan['jumlah_jual'] * $currentObat['jumlah_konversi_1']);
                } else if ($currentObat['id_satuan_konversi_2'] == $penjualan['id_satuan']) {
                    $jumlahJual = ($penjualan['jumlah_jual'] * $currentObat['jumlah_konversi_2']);
                } else {
                    $jumlahJual = $penjualan['jumlah_jual'];
                }

                $data = [
                    'tanggal' => $penjualan['tanggal_penjualan'] . ' ' . $penjualan['jam_penjualan'],
                    'keterangan' => 'Transaksi Penjualan oleh ' . $penjualan['nama_pembeli'],
                    'masuk' => 0,
                    'keluar' => $jumlahJual,
                    'kasir' => $penjualan['nama_pembeli']

                ];
                array_push($dataReport, $data);
            }
        }
        $returRange = $this->Returobat_model->getReturRange($id_obat, $dateR1, $dateR2);
        if ($returRange) {
            foreach ($returRange as $retur) {
                $data = [
                    'tanggal' => $retur['tanggal_retur'] . ' ' . $retur['jam_retur'],
                    'keterangan' => 'Transaksi Retur Obat dari ' . $retur['nama_supplier'],
                    'masuk' => 0,
                    'keluar' => $retur['jumlah_retur'],
                    'kasir' => $retur['kasir']

                ];
                array_push($dataReport, $data);
            }
        }
        $returRange = $this->Returpenjualan_model->getReturRange($id_obat, $dateR1, $dateR2);
        if ($returRange) {
            foreach ($returRange as $retur) {
                $data = [
                    'tanggal' => $retur['tanggal_retur'] . ' ' . $retur['jam_retur'],
                    'keterangan' => 'Transaksi Retur Penjualan Obat oleh ' . $retur['nama_pembeli'],
                    'keluar' => 0,
                    'masuk' => $retur['jumlah_retur'],
                    'kasir' => $retur['kasir']

                ];
                array_push($dataReport, $data);
            }
        }
        $rusakRange = $this->Barangrusak_model->getBarangRusakRange($id_obat, $dateR1, $dateR2);
        if ($rusakRange) {
            foreach ($rusakRange as $rusak) {
                $data = [
                    'tanggal' => $rusak['tanggal_transaksi'] . ' ' . $rusak['jam_transaksi'],
                    'keterangan' => 'Transaksi Obat Rusak / Dimusnahkan',
                    'masuk' => 0,
                    'keluar' => $rusak['jumlah_rusak'],
                    'kasir' => $rusak['kasir']

                ];
                array_push($dataReport, $data);
            }
        }

        // echo var_dump($rusakRange);
        // echo "<br>";
        $tanggal = array_column($dataReport, 'tanggal');
        array_multisort($tanggal, SORT_ASC, $dataReport);
        // usort($dataReport, function ($item1, $item2) {
        //     return $item1['tanggal'] <=> $item2['tanggal'];
        // });
        // echo var_dump(($dataReport));
        $data['report'] =  $dataReport;
        $data['obat'] = $currentObat;
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $header['title'] = "Lihat Kartu Stok";

        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'kartustok';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');

        $this->load->view('pages/lihatkartustok');
        $this->load->view('shared/admin_footer', $data);
    }
}