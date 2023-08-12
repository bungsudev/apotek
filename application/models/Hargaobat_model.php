<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hargaobat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function createNewharga_obat($data)
    {
        $this->db->insert('harga_obat', $data);
    }
    public function getHargaObat($id_obat)
    {
        $queryMenu = "SELECT * FROM harga_obat h inner join obat o on o.id_obat = h.id_obat inner join satuan_obat s on s.id_satuan = h.id_satuan where h.id_obat = '$id_obat'";
        return $this->db->query($queryMenu);
    }
    public function cekAvailableRow($id_obat, $id_satuan, $jumlah)
    {
        $queryMenu = "SELECT * FROM harga_obat where id_obat = '$id_obat' AND id_satuan = '$id_satuan' AND jumlah = '$jumlah'";
        return $this->db->query($queryMenu)->num_rows();
    }
    public function getAllHargaObat()
    {
        $queryMenu = "SELECT * FROM harga_obat h inner join obat o on o.id_obat = h.id_obat inner join satuan_obat s on s.id_satuan = h.id_satuan";
        return $this->db->query($queryMenu);
    }
    public function deleteHarga($id_obat, $id_satuan)
    {
        $queryMenu = "DELETE FROM harga_obat where id_obat = '$id_obat' AND id_satuan = '$id_satuan'";
        return $this->db->query($queryMenu);
    }
    public function updateharga_obat($data, $id_obat, $id_satuan)
    {
        $this->db->where('id_obat', $id_obat);
        $this->db->where('id_satuan', $id_satuan);
        $this->db->update('harga_obat', $data);
    }
    public function getHarga($id_obat, $id_satuan, $jumlah)
    {
        $queryMenu = "SELECT * FROM harga_obat where id_obat = '$id_obat' AND id_satuan = '$id_satuan' AND jumlah <= '$jumlah' order by jumlah desc limit 1";
        return $this->db->query($queryMenu)->row_array();
    }
}
