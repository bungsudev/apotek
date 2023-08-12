<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUserId()
    {
        // Example USER201912130001;
        $date = date("Ymd");
        $queryUserLength = "SELECT user_id FROM user WHERE MID(user_id,5,8) = '$date'";
        $curLength = ($this->db->query($queryUserLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "USER" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "USER" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "USER" . $date . "0" . $curLength;
        } else {
            $returnId = "USER" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewUser($data)
    {
        $this->db->insert('user', $data);
    }
    public function getCurrentUser()
    {
        return $this->db->get_where('user', ['username' => $this->session->userdata('apotek_username')])->row_array();
    }
    public function getAllUser()
    {
        $queryMenu = "SELECT u.*,ur.role_name FROM user u inner join user_role ur on ur.role_id = u.role_id";
        return $this->db->query($queryMenu);
    }
    public function setActiveNotActive($user_id, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('user_id', $user_id);
        $this->db->update('user');
    }
    public function getOneData($user_id)
    {
        $query = $this->db->get_where('user', array('user_id' => $user_id));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function getUserByEmail($email)
    {
        $query = $this->db->get_where('user', array('email' => $email));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function getNurseActive()
    {
        $query = "SELECT * from user where role_id = '3' AND is_active = '1'";
        return $this->db->query($query)->result_array();
    }
    public function updateUser($data, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('user', $data);
    }
}
