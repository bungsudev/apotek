<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tips_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTIpsId()
    {
        // Example category201912130001;
        $date = date("Ymd");
        $querycategoryLength = "SELECT tips_id FROM tips WHERE MID(tips_id,5,8) = '$date'";
        $curLength = ($this->db->query($querycategoryLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "TIPS" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "TIPS" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "TIPS" . $date . "0" . $curLength;
        } else {
            $returnId = "TIPS" . $date . $curLength;
        }
        return $returnId;
    }
    public function createTips($data)
    {
        $this->db->insert('tips', $data);
    }
    public function getAllTips()
    {
        return $this->db->get('tips');
    }
    public function getCurrentTips($tips_id)
    {
        return $this->db->get_where('tips', ['tips_id' => $tips_id])->row_array();
    }
    public function getOneData($tips_id)
    {
        $query = $this->db->get_where('tips', array('tips_id' => $tips_id));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updateTips($data, $tips_id)
    {

        $this->db->where('tips_id', $tips_id);
        $this->db->update('tips', $data);
    }
}
