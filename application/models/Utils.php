<?php
/**
 * Created by PhpStorm.
 * User: FMF-IT-LAP-00
 * Date: 1/11/2017
 * Time: 5:08 PM
 */

class Utils extends CI_Model{

    public static function pennna($smsMeg) {
        $smsnumber = "0094772772779";

        //for database updates
        $smsnumber_ori = $smsnumber;
        //for sending sms
        //$smsnumber = substr($smsnumber, 1);


        $durl = 'https://ipg.findmyfare.com/smssender.php';

        $fields = array(
            'no' => ("$smsnumber"),
            'message' => ($smsMeg)
        );


        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $durl);
            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_VERBOSE, 0);

            $data = curl_exec($ch);

            //convert the XML result into array
            if ($data === false) {
                Log::info("Error in sending SMS, to : " . $smsnumber);
            } else {
                //$data = json_decode(json_encode(simplexml_load_string($data)), true);
                // return data comes in the $data field , if not working modify and see
                Log::info("Sent SMS, to : " . $smsnumber);
            }
            curl_close($ch);
        } catch (Exception $e) {
            Log::info($e);
        }
    }

    }