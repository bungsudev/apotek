<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        $header['title'] = "Admin Dashboard";
        $this->load->view('shared/admin_header', $header);
        $data['currentPage'] = 'dashboard';
        $date1 = date('Y-m-01');
        $date2 = date('Y-m-t');
        $data['earningMonth'] = 0;
        $dataPenjualanRange = $this->Penjualan_model->getDataByDate($date1, $date2);
        if ($dataPenjualanRange) {
            foreach ($dataPenjualanRange as $penjualan) {
                $data['earningMonth'] += $penjualan['total_penjualan'];
            }
        }
        $data['earningYear'] = 0;
        $yearEarn = $this->Penjualan_model->getDataByDate(date("Y-01-01"), date("Y-12-31"));
        if ($yearEarn) {
            foreach ($yearEarn as $penjualan) {
                $data['earningYear'] += $penjualan['total_penjualan'];
            }
        }
        $this->load->view('shared/admin_sidebar', $data);
        $this->load->view('shared/admin_topbar');
        $this->load->view('pages/dashboard', $data);
        $this->load->view('shared/admin_footer', $data);
    }
}