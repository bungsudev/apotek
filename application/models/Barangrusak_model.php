<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangrusak_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getBarangrusakId()
    {
        // Example barangrusak201912130001;
        $date = date("Ymd");
        $querybarangrusakLength = "SELECT id_barang_rusak FROM barang_rusak WHERE MID(id_barang_rusak,5,8) = '$date'";
        $curLength = ($this->db->query($querybarangrusakLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "BROK" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "BROK" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "BROK" . $date . "0" . $curLength;
        } else {
            $returnId = "BROK" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewbarangrusak($data)
    {
        $this->db->insert('barang_rusak', $data);
    }
    public function getBarangrusakDetailId()
    {
        // Example barangrusak201912130001;
        $date = date("Ymd");
        $querybarang_rusak_detailLength = "SELECT id_barang_rusak_detail FROM barang_rusak_detail WHERE MID(id_barang_rusak_detail,5,8) = '$date'";
        $curLength = ($this->db->query($querybarang_rusak_detailLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "BROD" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "BROD" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "BROD" . $date . "0" . $curLength;
        } else {
            $returnId = "BROD" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewbarangrusakDetail($data)
    {
        $data['id_barang_rusak_detail'] = $this->getBarangrusakDetailId();
        $this->db->insert('barang_rusak_detail', $data);
    }
    public function getAllBarangrusak()
    {
        $query = "SELECT bt.*,b.tanggal_transaksi,ob.*,b.id_barang_rusak FROM barang_rusak_detail bt inner join barang_rusak b inner join obat ob on ob.id_obat = bt.id_obat    GROUP BY bt.id_barang_rusak ORDER BY tanggal_transaksi DESC";
        return $this->db->query($query);
    }
    public function getOneData($id_barang_rusak)
    {
        $query = "SELECT p.* FROM barang_rusak p  WHERE id_barang_rusak = '$id_barang_rusak' ORDER BY tanggal_transaksi DESC";
        return $this->db->query($query)->row_array();
    }
    public function getBarangrusakDetail($id_barang_rusak)
    {
        $query = "SELECT pd.*,o.*,s.nama_satuan_obat FROM barang_rusak_detail pd inner join obat o on o.id_obat = pd.id_obat inner join satuan_obat s On s.id_satuan = o.id_satuan WHERE id_barang_rusak = '$id_barang_rusak' ORDER BY id_barang_rusak_detail";
        return $this->db->query($query)->result_array();
    }
    public function getDataByDate($date1, $date2)
    {
        if ($date1 == '')
            $date1 = date('Y-m-d');
        if ($date2 == '')
            $date2 = date('Y-m-d');

        $queryCheck = "SELECT * FROM barang_rusak WHERE DATE(tanggal_transaksi) >= '$date1' AND DATE(tanggal_transaksi) <='$date2'";
        $returnData = $this->db->query($queryCheck)->result_array();
        return $returnData;
    }

    public function getDataByDateReport($date1, $date2)
    {
        if ($date1 == '')
            $date1 = date('Y-m-d');
        if ($date2 == '')
            $date2 = date('Y-m-d');

        $queryCheck = "SELECT bt.*,b.tanggal_transaksi,ob.* FROM barang_rusak_detail bt inner join barang_rusak b inner join obat ob on ob.id_obat = bt.id_obat WHERE DATE(b.tanggal_transaksi) >= '$date1' AND DATE(tanggal_transaksi) <='$date2'";
        $returnData = $this->db->query($queryCheck)->result_array();
        return $returnData;
    }
    public function getBarangRusakBeforeDare($id_obat, $date)
    {
        $query = "SELECT brd.*,br.tanggal_transaksi FROM barang_rusak br inner join barang_rusak_detail brd on brd.id_barang_rusak = br.id_barang_rusak WHERE br.tanggal_transaksi < '$date' AND brd.id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    public function getBarangRusakRange($id_obat, $date1, $date2)
    {
        $query = "SELECT brd.*,br.* FROM barang_rusak br inner join barang_rusak_detail brd on brd.id_barang_rusak = br.id_barang_rusak WHERE br.tanggal_transaksi >= '$date1' AND br.tanggal_transaksi <= '$date2' AND brd.id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
}
