<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuanobat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getSatuanId()
    {
        // Example satuan_obat201912130001;
        $date = date("Ymd");
        $querysatuan_obatLength = "SELECT id_satuan FROM satuan_obat WHERE MID(id_satuan,5,8) = '$date'";
        $curLength = ($this->db->query($querysatuan_obatLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "TYPE" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "TYPE" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "TYPE" . $date . "0" . $curLength;
        } else {
            $returnId = "TYPE" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewsatuan_obat($data)
    {
        $this->db->insert('satuan_obat', $data);
    }
    public function getAllSatuanObat()
    {
        $queryMenu = "SELECT * FROM satuan_obat";
        return $this->db->query($queryMenu);
    }
    public function setActiveNotActive($id_satuan, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('id_satuan', $id_satuan);
        $this->db->update('satuan_obat');
    }
    public function getOneData($id_satuan)
    {
        $query = $this->db->get_where('satuan_obat', array('id_satuan' => $id_satuan));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updatesatuan_obat($data, $id_satuan)
    {
        $this->db->where('id_satuan', $id_satuan);
        $this->db->update('satuan_obat', $data);
    }
    public function getActiveSatuan()
    {
        return $this->db->get_where('satuan_obat', ['is_active' => '1'])->result_array();
    }
}
