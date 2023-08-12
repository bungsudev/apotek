<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getfaqId()
    {
        $date = date("Ymd");
        $queryUserLength = "SELECT faq_id FROM faq WHERE MID(faq_id,5,8) = '$date'";
        $curLength = ($this->db->query($queryUserLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "FAQS" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "FAQS" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "FAQS" . $date . "0" . $curLength;
        } else {
            $returnId = "FAQS" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewfaq($data)
    {
        $this->db->insert('faq', $data);
    }
    public function getAllfaq()
    {
        $query = "SELECT * FROM faq";
        return $this->db->query($query);
    }
    public function getOneData($faq_id)
    {
        $query = $this->db->get_where('faq', array('faq_id' => $faq_id));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updateFaq($data, $faq_id)
    {
        $this->db->where('faq_id', $faq_id);
        $this->db->update('faq', $data);
    }
}
