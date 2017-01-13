<?php

Class payment_details extends CI_Model{

    var $pay_id = '';
    var $tk_key = '';
    var $tk_order_id = '';
    var $pay_option_code = '';
    var $pay_type = '';
    var $pay_value = '';
    var $create_date = '';
    var $agent = '';
    var $ipgTxn = '';
    var $status = '';
    var  $pgErrorDetail = '';
    var $pgErrorMsg = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_count($booking_id){
        $quantity = $this->db->query("(SELECT count(pay_id) FROM ph_payment_details WHERE tk_order_id = '$booking_id')", FALSE);

        return ($quantity->result_array());
    }
}