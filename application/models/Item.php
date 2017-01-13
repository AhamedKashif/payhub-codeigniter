<?php
/**
 * Created by PhpStorm.
 * User: Amjad
 * Date: 1/11/2017
 * Time: 3:35 PM
 */
Class Item extends CI_Model{

    var $itm_id = '';
    var $itm_code  = '';
    var $itm_name  = '';
    var $itm_serial  = '';
    var $itm_base_price  = '';
    var $itm_tax  = '';
    var $tk_key  = '';
    var $booking_id  = '';
    var $pnr = '';
    var $gds  = '';
    var $qty = '';
    var $desc = '';


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

    function insert_itme()
    {

        $this->db->insert('ph_items', $this);
    }

    function update_item()
    {
        $this->db->update('ph_items', $this, array('itm_id' => $this->itm_id));
    }
    
    function get_no_of_pax($tk_key){

        $quantity = $this->db->query("(SELECT SUM(qty) FROM ph_items WHERE tk_key = '$tk_key' and itm_code='FL')", FALSE);

        return ($quantity->result_array());
    }

}
