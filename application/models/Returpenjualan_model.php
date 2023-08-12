<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Returpenjualan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getReturId()
    {
        $date = date("Ymd");
        $queryretur_penjualanLength = "SELECT id_retur FROM retur_penjualan WHERE MID(id_retur,5,8) = '$date'";
        $curLength = ($this->db->query($queryretur_penjualanLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "RETR" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "RETR" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "RETR" . $date . "0" . $curLength;
        } else {
            $returnId = "RETR" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewretur_penjualan($data)
    {
        $this->db->insert('retur_penjualan', $data);
    }
    public function getAllReturObat()
    {
        $queryMenu = "SELECT * FROM retur_penjualan";
        return $this->db->query($queryMenu);
    }
    public function setActiveNotActive($id_retur, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('id_retur', $id_retur);
        $this->db->update('retur_penjualan');
    }
    public function getOneData($id_retur)
    {
        $query = $this->db->get_where('retur_penjualan', array('id_retur' => $id_retur));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updateretur_penjualan($data, $id_retur)
    {
        $this->db->where('id_retur', $id_retur);
        $this->db->update('retur_penjualan', $data);
    }
    public function getActiveCategory()
    {
        return $this->db->get_where('retur_penjualan', ['is_active' => '1'])->result_array();
    }
    public function getReturBeforeDate($id_obat, $date)
    {
        $query = "SELECT * FROM retur_penjualan WHERE tanggal_retur < '$date' AND id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    public function getReturRange($id_obat, $date1, $date2)
    {
        $query = "SELECT * FROM retur_penjualan r inner join penjualan p on p.id_penjualan = r.id_penjualan WHERE tanggal_retur >= '$date1' AND tanggal_retur <= '$date2' AND id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    public function getDataByDateReport($date1, $date2)
    {
        if ($date1 == '')
            $date1 = date('Y-m-d');
        if ($date2 == '')
            $date2 = date('Y-m-d');

        $queryCheck = "SELECT * FROM retur_penjualan r inner join obat o on o.id_obat = r.id_obat inner join penjualan p on p.id_penjualan = r.id_penjualan inner join satuan_obat s on o.id_satuan = s.id_satuan  WHERE tanggal_retur >= '$date1' AND tanggal_retur <= '$date2'";
        $returnData = $this->db->query($queryCheck)->result_array();
        return $returnData;
    }
}
