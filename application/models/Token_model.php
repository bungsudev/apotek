<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Token_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTokenId()
    {
        // Example USER201912130001;
        $date = date("Ymd");
        $queryUserLength = "SELECT token_id FROM token WHERE MID(token_id,5,8) = '$date'";
        $curLength = ($this->db->query($queryUserLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "TOKN" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "TOKN" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "TOKN" . $date . "0" . $curLength;
        } else {
            $returnId = "TOKN" . $date . $curLength;
        }
        return $returnId;
    }
    public function createToken($data)
    {
        $this->db->insert('token', $data);
    }
    public function getTokenDetail($token)
    {
        $query = "SELECT * from token where token = '" . $token . "'";
        return $this->db->query($query)->row_array();
    }
    public function getTokenbyUserId($user_id)
    {
        $query = "SELECT * from token where user_id = '" . $user_id . "'";
        return $this->db->query($query)->result_array();
    }
}
