<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bankaccount_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getBank()
    {
        return $this->db->get('bank_account', 1)->row_array();
    }
    public function getAllBank()
    {
        return $this->db->get('bank_account');
    }
    public function getOneData($id)
    {
        $query = $this->db->get_where('bank_account', array('id' => $id));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updateBank($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('bank_account', $data);
    }
}
