<?php
/**
 * Created by PhpStorm.
 * User: Amjad
 * Date: 1/11/2017
 * Time: 3:35 PM
 */
class Tokenization extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Item');
        $this->load->model('SiteItem');
    }
    public function saveItem($item) {
        log_message('info', 'Save item in TKN');
        log_message('info', $item);
        $bookingID = 0;
        if(isset($item['bookingID'])){
            $bookingID = $item['bookingID'];
        }else{
            log_message('info', 'BI not set in save item');
            $bookingID = "BI  not set";
        }

        try {
            $itemData = new Item();
            $itemData->itm_code = $item['itm_code'];
            $itemData->itm_name = $item['itm_name'];
            $itemData->itm_serial = $item['itm_serial'];
            $itemData->itm_base_price = $item['itm_base_price'];
            $itemData->itm_tax = $item['itm_tax'];
            $itemData->tk_key = $item['tk_key'];
            $itemData->booking_id = $item['bookingID'];
            if (isset($item['pnr'])) {
                $itemData->pnr = $item['pnr'];
            }if (isset($item['gds'])) {
                $itemData->gds = $item['gds'];
            }
            $itemData->qty = $item['qty'];
            $itemData->desc = $item['desc'];
            $itemData->insert_itme();
        } catch (Exception $e) {
            $error_code = "HUB_TKN-70029";
            $statusMessage = "HUB_TKN-70029-cannot save item :" . $bookingID;
            Utils::pennna($statusMessage);
            log_message('info', $statusMessage);
            log_message('info', $e);

        }
    }

    function getaddonItem($code) {
        $item = new SiteItem();
        $item = $item->get_items_by_code($code);
        $price = $item->item_price;
        $name = $item->item_name;
        $desc = $item->item_description;

        $attribute = array($price, $name, $desc);
        return $attribute;
    }

    function genTokenInDB($order) {

        $newToken = null;
        try {
            $checkEx = self::getToken($order['tk_key']);
            if (sizeof($checkEx) < 1) {

                $token = new TokenEloquent;
                $token->tk_value = $order['tk_value'];
                $token->pay_value = $order['pay_value'];
                $token->tk_status = $order['tk_status'];
                $token->tk_paid_amount = $order['tk_paid_amount'];
                $token->tk_isexpire = $order['tk_isexpire'];
                $token->tk_expire_datetime = $order['tk_expire_datetime'];
                $token->tk_order_id = $order['tk_order_id'];
                $token->ref = $order['ref'];
                $token->tk_customer_id = $order['tk_customer_id'];
                $token->item_type = $order['item_type'];
                $token->tk_key = $order['tk_key'];
                $token->callback = $order['callback'];
                $token->agent = $order['agent'];
                $token->json_uid = $order['uid'];
                $token->save();
            }

            $newToken = TokenEloquent::where('tk_key', '=', $order['tk_key'])->get();
        } catch (Exception $e) {
            $error_code = "HUB_TKN-70040";
            //$newToken = 0;//$error_code;
            $statusMessage = "HUB_TKN-70040-unable to gen new token :" . $order['tk_order_id'];
            Utils::pennna($statusMessage);
            Log::info($statusMessage);
            Log::info($e);
            $statusAccpet = 0;
        }

        return $newToken;
    }

    public static function getToken($key) {
        $token = null;
        try {
            $newTokenS = TokenEloquent::where('tk_key', '=', $key)->get();

            foreach ($newTokenS as $newToken) {
                $tk_id = $newToken->tk_id;
                $tk_value = $newToken->tk_value;
                $pay_value = $newToken->pay_value;
                $tk_status = $newToken->tk_status;
                $tk_paid_amount = $newToken->tk_paid_amount;
                $tk_isexpire = $newToken->tk_isexpire;
                $tk_expire_datetime = $newToken->tk_expire_datetime;
                $tk_order_id = $newToken->tk_order_id;
                $ref = $newToken->ref;
                $tk_customer_id = $newToken->tk_customer_id;
                $item_type = $newToken->item_type;
                $tk_key = $newToken->tk_key;
                $callback = $newToken->callback;
                $created_date = $newToken->created_date;
                $created_time = $newToken->created_time;

                $token = array(
                    'tk_id' => $tk_id,
                    'tk_value' => $tk_value,
                    'pay_value' => $pay_value,
                    'tk_status' => $tk_status,
                    'tk_paid_amount' => $tk_paid_amount,
                    'tk_isexpire' => $tk_isexpire,
                    'tk_expire_datetime' => $tk_expire_datetime,
                    'tk_order_id' => $tk_order_id,
                    'ref' => $ref,
                    'tk_customer_id' => $tk_customer_id,
                    'item_type' => $item_type,
                    'tk_key' => $tk_key,
                    'callback' => $callback,
                    'created_date' => $created_date,
                    'created_time' => $created_time
                );
            }
        } catch (Exception $e) {
            Log::info($e);
        }
        return $token;
    }
}