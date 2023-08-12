<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProductId()
    {
        // Example Product201912130001;
        $date = date("Ymd");
        $queryProductLength = "SELECT product_id FROM product WHERE MID(product_id,4,8) = '$date'";
        $curLength = ($this->db->query($queryProductLength)->num_rows()) + 1;
        if ($curLength <= 9) {
            $returnId = "PRO" . $date . "000" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "PRO" . $date . "00" . $curLength;
        } else if ($curLength <= 99) {
            $returnId = "PRO" . $date . "0" . $curLength;
        } else {
            $returnId = "PRO" . $date . $curLength;
        }
        return $returnId;
    }
    public function createNewProduct($data)
    {
        $this->db->insert('product', $data);
    }
    public function getAllProduct()
    {
        $queryMenu = "SELECT p.*,cp.category_name FROM category_product cp INNER JOIN product p ON p.category_id = cp.category_id";
        return $this->db->query($queryMenu);
    }
    public function getCurrentProduct($product_id)
    {
        return $this->db->get_where('product', ['product_id' => $product_id])->row_array();
    }
    public function getActiveProduct()
    {
        return $this->db->get_where('product', ['is_active' => '1'])->result_array();
    }
    public function setActiveNotActive($product_id, $active)
    {
        $this->db->set('modified_datetime', time());
        $this->db->set('is_active', $active);
        $this->db->where('product_id', $product_id);
        $this->db->update('product');
    }
    public function getOneData($product_id)
    {
        $query = $this->db->get_where('product', array('product_id' => $product_id));
        $dataTobeReturn =  $query->row_array();
        return $dataTobeReturn;
    }
    public function updateProduct($data, $product_id)
    {

        $this->db->where('product_id', $product_id);
        $this->db->update('product', $data);
    }
    public function getActiveProductbyCategory($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->where('is_active', '1');
        return $this->db->get('product')->result_array();
    }
    public function getProductbyId($product_id)
    {
        return $this->db->get_where('product', ['product_id' => $product_id])->result_array();
    }
}
