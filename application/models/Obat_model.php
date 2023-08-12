<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Obat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getObatId()
    {
        // Example obat201912130001;
        $date = date("Ymd");
        $queryobatLength = "SELECT id_obat FROM obat WHERE MID(id_obat,5,8) = '$date'";
        $curLength = ($this->db->query($queryobatLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "OBAT" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "OBAT" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "OBAT" . $date . "0" . $curLength;
        } else {
            $returnId = "OBAT" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewobat($data)
    {
        $this->db->insert('obat', $data);
    }
    public function getAllobat()
    {
        $query = "SELECT o.*,k.nama_kategori_obat,s.nama_satuan_obat FROM obat o inner join kategori_obat k on k.id_kategori = o.id_kategori inner join satuan_obat s on s.id_satuan = o.id_satuan";
        return $this->db->query($query);
    }
    public function getCurrentobat($id_obat)
    {
        return $this->db->get_where('obat', ['id_obat' => $id_obat])->row_array();
    }
    public function getActiveobat()
    {
        $query = "SELECT o.*,k.nama_kategori_obat,s.nama_satuan_obat FROM obat o inner join kategori_obat k on k.id_kategori = o.id_kategori inner join satuan_obat s on s.id_satuan = o.id_satuan WHERE o.is_active = '1' ORDER BY o.nama_obat";
        return $this->db->query($query)->result_array();
        // return $this->db->get_where('obat', ['is_active' => '1'])->result_array();
    }
    public function setActiveNotActive($id_obat, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('id_obat', $id_obat);
        $this->db->update('obat');
    }
    public function getOneData($id_obat)
    {
        $query = "SELECT o.*,k.nama_kategori_obat,s.nama_satuan_obat FROM obat o inner join kategori_obat k on k.id_kategori = o.id_kategori inner join satuan_obat s on s.id_satuan = o.id_satuan where o.id_obat = '$id_obat'";
        $query = $this->db->query($query);
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updateobat($data, $id_obat)
    {

        $this->db->where('id_obat', $id_obat);
        $this->db->update('obat', $data);
    }
    public function getObatToSell()
    {
        $query = "SELECT o.*,k.nama_kategori_obat,s.nama_satuan_obat FROM obat o inner join kategori_obat k on k.id_kategori = o.id_kategori inner join satuan_obat s on s.id_satuan = o.id_satuan WHERE o.stok >= 1 AND o.is_active = '1' ORDER BY o.nama_obat";
        return $this->db->query($query)->result_array();
        // return $this->db->get_where('obat', ['is_active' => '1'])->result_array();
    }

    // Database Server Side
    var $table = 'obat';
    var $column_order = array('nama_obat', 'nama_kategori_obat', 'nama_satuan_obat', 'stok','obat.is_active'); 
    var $column_search = array('nama_obat', 'nama_kategori_obat', 'nama_satuan_obat', 'stok','obat.is_active');
    var $order = array('nama_obat' => 'asc');
    
    private function _get_datatables_query()
    {
        $this->db->from('obat');  
        $this->db->join('kategori_obat', 'kategori_obat.id_kategori = obat.id_kategori', 'left');
        $this->db->join('satuan_obat', 'satuan_obat.id_satuan = obat.id_satuan', 'left');
        $this->db->group_by("obat.id_obat,obat.id_kategori,obat.id_satuan");
        $i = 0; 
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from('obat');
        return $this->db->count_all_results();
    }
}
