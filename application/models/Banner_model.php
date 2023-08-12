<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getBannerId()
    {
        // Example category201912130001;
        $date = date("Ymd");
        $querycategoryLength = "SELECT banner_id FROM banner WHERE MID(banner_id,5,8) = '$date'";
        $curLength = ($this->db->query($querycategoryLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "SLID" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "SLID" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "SLID" . $date . "0" . $curLength;
        } else {
            $returnId = "SLID" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewBanner($data)
    {
        $this->db->insert('banner', $data);
    }
    public function getAllBanner()
    {
        return $this->db->get('banner');
    }
    public function getCurrentcategory($banner_id)
    {
        return $this->db->get_where('category_product', ['banner_id' => $banner_id])->row_array();
    }
    public function getActiveCategory()
    {
        return $this->db->get_where('category_product', ['is_active' => '1'])->result_array();
    }
    public function setActiveNotActive($banner_id, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('banner_id', $banner_id);
        $this->db->update('category_product');
    }
    public function getOneData($banner_id)
    {
        $query = $this->db->get_where('category_product', array('banner_id' => $banner_id));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updateCategory($data, $banner_id)
    {

        $this->db->where('banner_id', $banner_id);
        $this->db->update('category_product', $data);
    }
}
