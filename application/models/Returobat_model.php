<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Returobat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getReturId()
    {
        $date = date("Ymd");
        $queryretur_pembelianLength = "SELECT id_retur FROM retur_pembelian WHERE MID(id_retur,5,8) = '$date'";
        $curLength = ($this->db->query($queryretur_pembelianLength)->num_rows()) + 1;
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
    public function createNewretur_pembelian($data)
    {
        $this->db->insert('retur_pembelian', $data);
    }
    public function getAllReturObat()
    {
        $queryMenu = "SELECT * FROM retur_pembelian";
        return $this->db->query($queryMenu);
    }
    public function setActiveNotActive($id_retur, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('id_retur', $id_retur);
        $this->db->update('retur_pembelian');
    }
    public function getOneData($id_retur)
    {
        $query = $this->db->get_where('retur_pembelian', array('id_retur' => $id_retur));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updateretur_pembelian($data, $id_retur)
    {
        $this->db->where('id_retur', $id_retur);
        $this->db->update('retur_pembelian', $data);
    }
    public function getActiveCategory()
    {
        return $this->db->get_where('retur_pembelian', ['is_active' => '1'])->result_array();
    }
    public function getReturBeforeDate($id_obat, $date)
    {
        $query = "SELECT * FROM retur_pembelian WHERE tanggal_retur < '$date' AND id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    public function getReturRange($id_obat, $date1, $date2)
    {
        $query = "SELECT * FROM retur_pembelian r inner join pembelian p on p.id_pembelian = r.id_pembelian inner join supplier sp on p.id_supplier = sp.id_supplier WHERE tanggal_retur >= '$date1' AND tanggal_retur <= '$date2' AND id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    public function getDataByDateReport($date1, $date2)
    {
        if ($date1 == '')
            $date1 = date('Y-m-d');
        if ($date2 == '')
            $date2 = date('Y-m-d');

        $queryCheck = "SELECT * FROM retur_pembelian r inner join obat o on o.id_obat = r.id_obat inner join pembelian p on p.id_pembelian = r.id_pembelian inner join satuan_obat s on o.id_satuan = s.id_satuan inner join supplier sp on p.id_supplier = sp.id_supplier  WHERE tanggal_retur >= '$date1' AND tanggal_retur <= '$date2'";
        $returnData = $this->db->query($queryCheck)->result_array();
        return $returnData;
    }
}
