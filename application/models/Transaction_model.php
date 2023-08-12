<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTransactionId()
    {
        // Example Product201912130001;
        $date = date("Ymd");
        $queryProductLength = "SELECT transaction_id FROM transaction WHERE MID(transaction_id,4,8) = '$date'";
        $curLength = ($this->db->query($queryProductLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "INV" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "INV" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "INV" . $date . "0" . $curLength;
        } else {
            $returnId = "INV" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewTransaction($data)
    {
        $this->db->insert('transaction', $data);
    }
    public function getTransactionById($transaction_id)
    {
        $query = "SELECT t.*,p.product_name,p.product_description,u.email,u.name,u.no_handphone From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id where transaction_id = '$transaction_id'";
        return $this->db->query($query)->row_array();
    }
    public function updateTransaction($data, $transaction_id)
    {
        $this->db->where('transaction_id', $transaction_id);
        $this->db->update('transaction', $data);
    }
    public function getAllTransaction()
    {
        $query = "SELECT t.*,p.product_name,u.email,u.name,u.no_handphone From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id order by transaction_id desc";
        return $this->db->query($query)->result_array();
    }
    public function getCountTransactionByStatus($status = '')
    {
        $query = "SELECT * From transaction where status = '$status'";
        return $this->db->query($query)->num_rows();
    }
    public function getTransactionByStatus($status = '')
    {
        $query = "SELECT t.*,p.product_name,u.email,u.name,u.no_handphone From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id where status = '$status'";
        return $this->db->query($query)->result_array();
    }
    public function getListConfirmTransaction()
    {
        $query = "SELECT t.*,p.product_name,u.email,u.name,u.no_handphone From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id where status = 'confirm' OR status = 'pending'";
        return $this->db->query($query)->result_array();
    }
    public function getCountConfirm()
    {
        $query = "SELECT t.*,p.product_name,u.email,u.name,u.no_handphone From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id where status = 'confirm' OR status = 'pending'";
        return $this->db->query($query)->num_rows();
    }
    public function statusUpdate($transaction_id, $status)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('status', $status);
        $this->db->where('transaction_id', $transaction_id);
        $this->db->update('transaction');
    }
    public function getCountNurse()
    {
        $query = "SELECT t.*,p.product_name,u.email,u.name,u.no_handphone From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id where status = 'approve' AND nurse_id = ''";
        return $this->db->query($query)->num_rows();
    }
    public function getSignNurseTransaction()
    {
        $query = "SELECT t.*,p.product_name,u.email,u.name,u.no_handphone From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id where t.status = 'approve' AND t.nurse_id = ''";
        return $this->db->query($query)->result_array();
    }
    public function getEarningByDate($date1 = '', $date2 = '')
    {
        $query = "SELECT * FROM transaction where status ='done' AND service_date between '$date1' and '$date2'";
        return $this->db->query($query)->result_array();
    }
    public function getOnGoingService()
    {
        $today = date('Y-m-d');
        $query = "SELECT t.*,p.product_name,u.email,u.name,u.no_handphone From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id where t.status ='approve' AND DATE(service_date) = '$today' AND t.nurse_id <> ''";
        return $this->db->query($query);
    }
    public function getDataByDate($date1, $date2)
    {
        if ($date1 == '')
            $date1 = date('Y-m-d');
        if ($date2 == '')
            $date2 = date('Y-m-d');

        $queryCheck = "SELECT t.*,p.product_name,p.product_price,u.email,u.name,u.no_handphone,n.no_handphone as nurse_phone, n.name as nurse_name From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id inner join user n on t.nurse_id = n.user_id WHERE DATE(t.service_date) >= '$date1' AND DATE(t.service_date) <='$date2'";
        $returnData = $this->db->query($queryCheck)->result_array();
        return $returnData;
    }
    public function getDataByDateDone($date1, $date2)
    {
        if ($date1 == '')
            $date1 = date('Y-m-d');
        if ($date2 == '')
            $date2 = date('Y-m-d');

        $queryCheck = "SELECT t.*,p.product_name,p.product_price,u.email,u.name,u.no_handphone,n.no_handphone as nurse_phone, n.name as nurse_name From transaction t Inner join product p on t.product_id = p.product_id inner join user u on t.user_id = u.user_id inner join user n on t.nurse_id = n.user_id WHERE t.status = 'done' AND DATE(t.service_date) >= '$date1' AND DATE(t.service_date) <='$date2'";
        $returnData = $this->db->query($queryCheck)->result_array();
        return $returnData;
    }
}
