<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPenjualanId()
    {
        // Example penjualan201912130001;
        $date = date("Ymd");
        $querypenjualanLength = "SELECT id_penjualan FROM penjualan WHERE MID(id_penjualan,5,8) = '$date'";
        $curLength = ($this->db->query($querypenjualanLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "INVO" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "INVO" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "INVO" . $date . "0" . $curLength;
        } else {
            $returnId = "INVO" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewpenjualan($data)
    {
        $this->db->insert('penjualan', $data);
    }
    public function getPenjualanDetailId()
    {
        // Example penjualan201912130001;
        $date = date("Ymd");
        $querypenjualan_detailLength = "SELECT id_penjualan_detail FROM penjualan_detail WHERE MID(id_penjualan_detail,5,8) = '$date'";
        $curLength = ($this->db->query($querypenjualan_detailLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "INVD" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "INVD" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "INVD" . $date . "0" . $curLength;
        } else {
            $returnId = "INVD" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewpenjualanDetail($data)
    {
        $data['id_penjualan_detail'] = $this->getPenjualanDetailId();
        $this->db->insert('penjualan_detail', $data);
    }
    public function getAllPenjualan()
    {
        $query = "SELECT p.* FROM penjualan p  ORDER BY tanggal_penjualan DESC";
        return $this->db->query($query);
    }
    public function getOneData($id_penjualan)
    {
        $query = "SELECT p.* FROM penjualan p  WHERE id_penjualan = '$id_penjualan' ORDER BY tanggal_penjualan DESC";
        return $this->db->query($query)->row_array();
    }
    public function getPenjualanDetail($id_penjualan)
    {
        $query = "SELECT pd.*,o.*,s.nama_satuan_obat FROM penjualan_detail pd inner join obat o on o.id_obat = pd.id_obat inner join satuan_obat s On s.id_satuan = pd.id_satuan WHERE id_penjualan = '$id_penjualan' ORDER BY id_penjualan_detail";
        return $this->db->query($query)->result_array();
    }
    public function getOneDataDetail($id_penjualan_detail)
    {
        $query = "SELECT pd.*,o.nama_obat,o.stok,s.nama_satuan_obat FROM penjualan_detail pd inner join obat o on o.id_obat = pd.id_obat inner join satuan_obat s on pd.id_satuan = s.id_satuan WHERE id_penjualan_detail = '$id_penjualan_detail'";
        $data =  $this->db->query($query)->row_array();
        $query2 = "SELECT * FROM obat o inner join satuan_obat s on o.id_satuan = s.id_satuan WHERE id_obat = '" . $data['id_obat'] . "'";
        $currentObat = $this->db->query($query2)->row_array();
        if ($currentObat['id_satuan_konversi_1'] == $data['id_satuan']) {
            $data['jumlah_jual'] = ($data['jumlah_jual'] * $currentObat['jumlah_konversi_1']);
            // $stokSebelum -= ($data['jumlah_jual'] * $currentObat['jumlah_konversi_2']);

        } else if ($currentObat['id_satuan_konversi_2'] == $data['id_satuan']) {
            // $stokSebelum -= ($data['jumlah_jual'] * $currentObat['jumlah_konversi_2']);
        } else {
            // $stokSebelum -= $data['jumlah_jual'];
        }
        $data['satuan_terkecil'] = $currentObat['nama_satuan_obat'];
        return $data;
    }
    public function getDataByDate($date1, $date2)
    {
        if ($date1 == '')
            $date1 = date('Y-m-d');
        if ($date2 == '')
            $date2 = date('Y-m-d');

        $queryCheck = "SELECT * FROM penjualan WHERE DATE(tanggal_penjualan) >= '$date1' AND DATE(tanggal_penjualan) <='$date2'";
        $returnData = $this->db->query($queryCheck)->result_array();
        return $returnData;
    }
    public function getPenjualanDetailBeforeDate($id_obat, $date)
    {
        $query = "SELECT pd.*,p.tanggal_penjualan,p.jam_penjualan FROM penjualan p inner join penjualan_detail pd on pd.id_penjualan = p.id_penjualan WHERE p.tanggal_penjualan < '$date' AND pd.id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    public function getPenjualanDetailRange($id_obat, $date1, $date2)
    {
        $query = "SELECT pd.*,p.tanggal_penjualan,p.jam_penjualan,p.nama_pembeli FROM penjualan p inner join penjualan_detail pd on pd.id_penjualan = p.id_penjualan WHERE p.tanggal_penjualan >= '$date1'AND p.tanggal_penjualan <= '$date2' AND pd.id_obat = '$id_obat'";
        return $this->db->query($query)->result_array();
    }
    // Database Server Side
    var $table = 'penjualan';
    var $column_order = array('id_penjualan', 'nama_pembeli','tanggal_penjualan','jam_penjualan', 'total_penjualan'); 
    var $column_search = array('id_penjualan', 'nama_pembeli','tanggal_penjualan','jam_penjualan', 'total_penjualan');
    var $order = array('id_penjualan' => 'desc');
    
    private function _get_datatables_query()
    {
        $this->db->from('penjualan');  
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
        $this->db->from('penjualan');
        return $this->db->count_all_results();
    }
}
