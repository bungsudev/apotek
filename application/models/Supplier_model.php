<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getSupplierId()
    {
        // Example supplier201912130001;
        $date = date("Ymd");
        $querysupplierLength = "SELECT id_supplier FROM supplier WHERE MID(id_supplier,5,8) = '$date'";
        $curLength = ($this->db->query($querysupplierLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "SUPL" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "SUPL" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "SUPL" . $date . "0" . $curLength;
        } else {
            $returnId = "SUPL" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewsupplier($data)
    {
        $this->db->insert('supplier', $data);
    }
    public function getAllSupplier()
    {
        $queryMenu = "SELECT * FROM supplier";
        return $this->db->query($queryMenu);
    }
    public function setActiveNotActive($id_supplier, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('id_supplier', $id_supplier);
        $this->db->update('supplier');
    }
    public function getOneData($id_supplier)
    {
        $query = $this->db->get_where('supplier', array('id_supplier' => $id_supplier));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updatesupplier($data, $id_supplier)
    {
        $this->db->where('id_supplier', $id_supplier);
        $this->db->update('supplier', $data);
    }
    public function getActiveSupplier()
    {
        return $this->db->get_where('supplier', ['is_active' => '1'])->result_array();
    }
}
