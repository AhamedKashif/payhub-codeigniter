<?php

/**
 * Created by PhpStorm.
 * User: FMF-IT-LAP-00
 * Date: 1/12/2017
 * Time: 12:02 PM
 */
class SiteItem extends CI_Model
{
    var $id = '';
    var $item_code = '';
    var $item_name  = '';
    var $item_price  = '';
    var $item_description  = '';



    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all()
    {
        $query = $this->db->get('ph_items');
        return $query->result();
    }

    function get_items_by_code($code)
    {
        $this->db->select('*');
        $this->db->from('site_items');
        $this->db->where('item_code' , $code);
        $query = $this->db->get()->result_array();

        $this->id = $query[0]['id'];
        $this->item_code = $query[0]['item_code'];
        $this->item_name = $query[0]['item_name'];
        $this->item_price= $query[0]['item_price'];
        $this->item_description = $query[0]['item_description'];

        return $this;
    }

    function insert_itme()
    {

        $this->db->insert('site_items', $this);
    }

    function update_item()
    {
        $this->db->update('site_items', $this, array('id' => $this->id));
    }

}