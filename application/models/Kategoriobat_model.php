<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kategoriobat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getKategoriId()
    {
        $date = date("Ymd");
        $querykategori_obatLength = "SELECT id_kategori FROM kategori_obat WHERE left(id_kategori,4) = 'CATE' AND MID(id_kategori,5,8) = '$date' ORDER by id_kategori desc limit 1";
        $currentData = $this->db->query($querykategori_obatLength)->row_array();
        if ($currentData) {
            $curLength = ((int) substr($currentData['id_kategori'], -4)) + 1;
        } else {
            $curLength = 1;
        }
        if ($curLength <= 9) {
            $returnId = "CATE" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "CATE" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "CATE" . $date . "0" . $curLength;
        } else {
            $returnId = "CATE" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewkategori_obat($data)
    {
        $this->db->insert('kategori_obat', $data);
    }
    public function getAllKategoriObat()
    {
        $queryMenu = "SELECT * FROM kategori_obat GROUP BY id_kategori";
        return $this->db->query($queryMenu);
    }
    public function setActiveNotActive($id_kategori, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('id_kategori', $id_kategori);
        $this->db->update('kategori_obat');
    }
    public function getOneData($id_kategori)
    {
        $query = $this->db->get_where('kategori_obat', array('id_kategori' => $id_kategori));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updatekategori_obat($data, $id_kategori)
    {
        $this->db->where('id_kategori', $id_kategori);
        $this->db->update('kategori_obat', $data);
    }
    public function getActiveCategory()
    {
        return $this->db->get_where('kategori_obat', ['is_active' => '1'])->result_array();
    }
}
