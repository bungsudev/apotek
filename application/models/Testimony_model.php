<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testimony_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTestimonyId()
    {
        // Example USER201912130001;
        $date = date("Ymd");
        $queryUserLength = "SELECT id_testimony FROM testimony WHERE MID(id_testimony,5,8) = '$date'";
        $curLength = ($this->db->query($queryUserLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "REVW" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "REVW" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "REVW" . $date . "0" . $curLength;
        } else {
            $returnId = "REVW" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewTestimony($data)
    {
        $this->db->insert('testimony', $data);
    }
    public function getAllTestimony()
    {
        $query = "SELECT t.*,u.* From testimony t Inner join transaction tr on t.transaction_id = tr.transaction_id inner join user u on tr.user_id = u.user_id order by id_testimony desc";
        return $this->db->query($query)->result_array();
    }
    public function statusUpdate($id_testimony, $status)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('status', $status);
        $this->db->where('id_testimony', $id_testimony);
        $this->db->update('testimony');
    }
    public function getPendingTestimony()
    {
        $query = "SELECT * from testimony where  status='pending'";
        return $this->db->query($query)->num_rows();
    }
}
