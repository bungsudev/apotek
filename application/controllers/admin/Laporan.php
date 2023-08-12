<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
    public function laporanlabarugi($date1 = '', $date2 = '')
    {
        if(!isset($_SESSION['apotek_username'])){
            redirect('auth');
        }
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
        $dataReport = [];
        $dataPembelianRange = $this->Pembelian_model->getDataByDate($dateR1, $dateR2);
        if ($dataPembelianRange) {
            foreach ($dataPembelianRange as $pembelian) {
                $data = [
                    'jenis_transaksi' => 'Pembelian',
                    'tanggal' => $pembelian['tanggal_pembelian'],
                    'keterangan' => 'Transaksi Pembelian dari ' . $pembelian['nama_supplier'],
                    'debit' => 0,
                    'kredit' => $pembelian['total_pembelian'],
                    'sub_total' => $pembelian['total_pembelian']
                ];
                array_push($dataReport, $data);
            }
        }
        $dataPenjualanRange = $this->Penjualan_model->getDataByDate($dateR1, $dateR2);
        if ($dataPenjualanRange) {
            foreach ($dataPenjualanRange as $penjualan) {
                $data = [
                    'jenis_transaksi' => 'Penjualan',
                    'tanggal' => $penjualan['tanggal_penjualan'],
                    'keterangan' => 'Transaksi Penjualan oleh ' . $penjualan['nama_pembeli'],
                    'debit' => $penjualan['total_penjualan'],
                    'kredit' => 0,
                    'sub_total' => $penjualan['total_penjualan'],

                ];
                array_push($dataReport, $data);
            }
        }
        // Load Page
        $data['report'] = $dataReport;
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $header['title'] = "Laporan Penjualan";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'laporanlabarugi';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');

        $this->load->view('pages/laporanlabarugi');
        $this->load->view('shared/admin_footer', $data);
    }
    public function cetaklaporanlabarugi($date1 = '', $date2 = '')
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
        $dataReport = [];
        $dataPembelianRange = $this->Pembelian_model->getDataByDate($dateR1, $dateR2);
        if ($dataPembelianRange) {
            foreach ($dataPembelianRange as $pembelian) {
                $data = [
                    'jenis_transaksi' => 'Pembelian',
                    'tanggal' => $pembelian['tanggal_pembelian'],
                    'keterangan' => 'Transaksi Pembelian dari ' . $pembelian['nama_supplier'],
                    'debit' => 0,
                    'kredit' => $pembelian['total_pembelian'],
                    'sub_total' => $pembelian['total_pembelian']
                ];
                array_push($dataReport, $data);
            }
        }
        $dataPenjualanRange = $this->Penjualan_model->getDataByDate($dateR1, $dateR2);
        if ($dataPenjualanRange) {
            foreach ($dataPenjualanRange as $penjualan) {
                $data = [
                    'jenis_transaksi' => 'Penjualan',
                    'tanggal' => $penjualan['tanggal_penjualan'],
                    'keterangan' => 'Transaksi Penjualan oleh ' . $penjualan['nama_pembeli'],
                    'debit' => $penjualan['total_penjualan'],
                    'kredit' => 0,
                    'sub_total' => $penjualan['total_penjualan'],

                ];
                array_push($dataReport, $data);
            }
        }
        // Load Page
        $data['report'] = $dataReport;
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('pages/downloadlaporanlabarugi', $data);

        $html = ob_get_contents();
        ob_end_clean();

        require_once('./vendor/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('L', 'A4', 'en');
        $pdf->WriteHTML($html);
        // $pdf->Output('Laporan Laba Rugi.pdf', 'FI');
        $result = $pdf->Output('Laporan Laba Rugi.pdf', 'F');
        header("Content-type:application/pdf");
        echo file_get_contents('Laporan Laba Rugi.pdf');
    }
    // Report
    public function laporanpenjualan($date1 = '', $date2 = '')
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
        // Load Page
        $data['report'] = $this->Penjualan_model->getDataByDate($dateR1, $dateR2);
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $header['title'] = "Laporan Penjualan";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'laporanpenjualan';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');

        $this->load->view('pages/laporanpenjualan');
        $this->load->view('shared/admin_footer', $data);
    }
    public function cetaklaporanpenjualan($date1 = '', $date2 = '')
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
        $data['report'] =  $this->Penjualan_model->getDataByDate($dateR1, $dateR2);
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('pages/downloadlaporanpenjualan', $data);

        $html = ob_get_contents();
        ob_end_clean();

        require_once('./vendor/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('L', 'A4', 'en');
        $pdf->WriteHTML($html);
        // $pdf->Output('Laporan Penjualan.pdf', 'FI');
        $result = $pdf->Output('Laporan Penjualan.pdf', 'F');
        header("Content-type:application/pdf");
        echo file_get_contents('Laporan Penjualan.pdf');
    }

    public function laporanpembelian($date1 = '', $date2 = '')
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
        // Load Page
        $data['report'] = $this->Pembelian_model->getDataByDate($dateR1, $dateR2);
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $header['title'] = "Laporan Pembelian";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'laporanpembelian';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');

        $this->load->view('pages/laporanpembelian');
        $this->load->view('shared/admin_footer', $data);
    }
    public function cetaklaporanpembelian($date1 = '', $date2 = '')
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
        $data['report'] =  $this->Pembelian_model->getDataByDate($dateR1, $dateR2);
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('pages/downloadlaporanpembelian', $data);

        $html = ob_get_contents();
        ob_end_clean();

        require_once('./vendor/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('L', 'A4', 'en');
        $pdf->WriteHTML($html);
        // $pdf->Output('Laporan Pembelian.pdf', 'FI');
        $result = $pdf->Output('Laporan Pembelian.pdf', 'F');
        header("Content-type:application/pdf");
        echo file_get_contents('Laporan Pembelian.pdf');
    }

    public function laporanbarangrusak($date1 = '', $date2 = '')
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
        // Load Page
        $data['report'] = $this->Barangrusak_model->getDataByDateReport($dateR1, $dateR2);
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $header['title'] = "Laporan Obat Rusak";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'laporanbarangrusak';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');

        $this->load->view('pages/laporanbarangrusak');
        $this->load->view('shared/admin_footer', $data);
    }
    public function cetaklaporanbarangrusak($date1 = '', $date2 = '')
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
        $data['report'] =  $this->Barangrusak_model->getDataByDateReport($dateR1, $dateR2);
        // echo var_dump($data['report']);
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('pages/downloadlaporanbarangrusak', $data);

        $html = ob_get_contents();
        ob_end_clean();

        require_once('./vendor/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('L', 'A4', 'en');
        $pdf->WriteHTML($html);
        // $pdf->Output('Laporan Obat Rusak.pdf', 'FI');
        $result = $pdf->Output('Laporan Obat Rusak.pdf', 'F');
        header("Content-type:application/pdf");
        echo file_get_contents('Laporan Obat Rusak.pdf');
    }
    public function laporanretur($date1 = '', $date2 = '')
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
        // Load Page
        // $data['report'] 
        $dataReport = [];
        $retur_pembelian = $this->Returobat_model->getDataByDateReport($dateR1, $dateR2);
        foreach ($retur_pembelian as $returbeli) {
            $returbeli['jenis'] = 'Retur Pembelian dari ' . $returbeli['nama_supplier'];
            array_push($dataReport, $returbeli);
        }
        $retur_penjualan = $this->Returpenjualan_model->getDataByDateReport($dateR1, $dateR2);
        foreach ($retur_penjualan as $returjual) {
            $returjual['jenis'] = 'Retur Penjualan oleh ' . $returjual['nama_pembeli'];
            array_push($dataReport, $returjual);
        }
        $tanggal = array_column($dataReport, 'tanggal_retur');
        array_multisort($tanggal, SORT_ASC, $dataReport);
        $data['report'] = $dataReport;
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $header['title'] = "Laporan Retur Obat";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'laporanretur';
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');

        $this->load->view('pages/laporanreturobat');
        $this->load->view('shared/admin_footer', $data);
    }
    public function cetaklaporanreturobat($date1 = '', $date2 = '')
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
        $dataReport = [];
        $retur_pembelian = $this->Returobat_model->getDataByDateReport($dateR1, $dateR2);
        foreach ($retur_pembelian as $returbeli) {
            $returbeli['jenis'] = 'Retur Pembelian dari ' . $returbeli['nama_supplier'];
            array_push($dataReport, $returbeli);
        }
        $retur_penjualan = $this->Returpenjualan_model->getDataByDateReport($dateR1, $dateR2);
        foreach ($retur_penjualan as $returjual) {
            $returjual['jenis'] = 'Retur Penjualan oleh ' . $returjual['nama_pembeli'];
            array_push($dataReport, $returjual);
        }
        $tanggal = array_column($dataReport, 'tanggal_retur');
        array_multisort($tanggal, SORT_ASC, $dataReport);
        $data['report'] = $dataReport;
        // echo var_dump($data['report']);
        $data['date1'] = $dateR1;
        $data['date2'] = $dateR2;
        $query = $this->db->get_where('apotek_profile', array('id_apotek' => '1'));
        $data['profil'] = $query->row_array();
        $this->load->view('pages/downloadlaporanretur', $data);

        $html = ob_get_contents();
        ob_end_clean();

        require_once('./vendor/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('L', 'A4', 'en');
        $pdf->WriteHTML($html);
        // $pdf->Output('Laporan Retur Obat.pdf', 'FI');
        $result = $pdf->Output('Laporan Retur Obat.pdf', 'F');
        header("Content-type:application/pdf");
        echo file_get_contents('Laporan Retur Obat.pdf');
    }
    

}