<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPembelianId()
    {
        // Example pembelian201912130001;
        $date = date("Ymd");
        $querypembelianLength = "SELECT id_pembelian FROM pembelian WHERE MID(id_pembelian,5,8) = '$date'";
        $curLength = ($this->db->query($querypembelianLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "PURC" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "PURC" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "PURC" . $date . "0" . $curLength;
        } else {
            $returnId = "PURC" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewpembelian($data)
    {
        $this->db->insert('pembelian', $data);
    }
    public function getPembelianDetailId()
    {
        // Example pembelian201912130001;
        $date = date("Ymd");
        $querypembelian_detailLength = "SELECT id_pembelian_detail FROM pembelian_detail WHERE MID(id_pembelian_detail,5,8) = '$date'";
        $curLength = ($this->db->query($querypembelian_detailLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "PDET" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "PDET" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "PDET" . $date . "0" . $curLength;
        } else {
            $returnId = "PDET" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewpembelianDetail($data)
    {
        $data['id_pembelian_detail'] = $this->getPembelianDetailId();
        $this->db->insert('pembelian_detail', $data);
    }
    public function getAllPembelian()
    {
        $query = "SELECT p.*,s.nama_supplier FROM pembelian p inner join supplier s on p.id_supplier = s.id_supplier ORDER BY tanggal_pembelian DESC";
        return $this->db->query($query);
    }
    public function getOneData($id_pembelian)
    {
        $query = "SELECT p.*,s.* FROM pembelian p inner join supplier s on p.id_supplier = s.id_supplier WHERE id_pembelian = '$id_pembelian' ORDER BY tanggal_pembelian DESC";
        return $this->db->query($query)->row_array();
    }
    public function getOneDataDetail($id_pembelian_detail)
    {
        $query = "SELECT * FROM pembelian_detail pd inner join obat o on o.id_obat = pd.id_obat inner join satuan_obat s on o.id_satuan = s.id_satuan WHERE id_pembelian_detail = '$id_pembelian_detail'";
        return $this->db->query($query)->row_array();
    }
    public function getPembelianDetail($id_pembelian)
    {
        $query = "SELECT pd.*,o.*,s.nama_satuan_obat FROM pembelian_detail pd inner join obat o on o.id_obat = pd.id_obat inner join satuan_obat s On s.id_satuan = o.id_satuan WHERE id_pembelian = '$id_pembelian' ORDER BY id_pembelian_detail";
        return $this->db->query($query)->result_array();
    }
    public function getDataByDate($date1, $date2)
    {
        if ($date1 == '')
            $date1 = date('Y-m-d');
        if ($date2 == '')
            $date2 = date('Y-m-d');

        $queryCheck = "SELECT p.*,s.* FROM pembelian p inner join supplier s on p.id_supplier = s.id_supplier WHERE DATE(p.tanggal_pembelian) >= '$date1' AND DATE(p.tanggal_pembelian) <='$date2'";
        $returnData = $this->db->query($queryCheck)->result_array();
        return $returnData;
    }
    public function getPembelianDetailBeforeDate($id_obat, $date)
    {
        $query = "SELECT pd.*,p.tanggal_pembelian,p.jam_pembelian FROM pembelian p inner join pembelian_detail pd on pd.id_pembelian = p.id_pembelian WHERE p.tanggal_pembelian < '$date' AND pd.id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    public function getPembelianDetailRange($id_obat, $date1, $date2)
    {
        $query = "SELECT pd.*,p.tanggal_pembelian,p.jam_pembelian,p.nama_pembeli,sp.* FROM pembelian p inner join pembelian_detail pd on pd.id_pembelian = p.id_pembelian inner join supplier sp on sp.id_supplier = p.id_supplier WHERE p.tanggal_pembelian >= '$date1' AND p.tanggal_pembelian <= '$date2' AND pd.id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    var $table = 'pembelian';
    var $column_order = array('id_pembelian', 'nama_supplier','nama_pembeli','tanggal_pembelian','jam_pembelian', 'total_pembelian'); 
    var $column_search = array('id_pembelian', 'nama_supplier','nama_pembeli','tanggal_pembelian','jam_pembelian', 'total_pembelian');
    var $order = array('id_pembelian' => 'desc');
    
    private function _get_datatables_query()
    {
        $this->db->from('pembelian');  
        $this->db->join('supplier','supplier.id_supplier = pembelian.id_supplier');  
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
        $this->db->from('pembelian');
        return $this->db->count_all_results();
    }
}
