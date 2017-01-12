<?php
/**
 * Created by PhpStorm.
 * User: FMF-IT-LAP-00
 * Date: 1/11/2017
 * Time: 5:27 PM
 */

class test extends CI_Model{

 var $id = '';
 var $title = '';
 var $content = '';
 var $user_id = '';
 var $image = '';

 function __construct()
 {
  // Call the Model constructor
  parent::__construct();
 }

 function  get_one($id){
  $this->db->select('*, news.id as id');
  $this->db->from('news');
  $this->db->where('news.id' , $id);
  $query = $this->db->get()->result_array();;

  $this->id = $query[0]['id'];
  $this->title = $query[0]['title'];
  $this->content = $query[0]['content'];
  $this->user_id = $query[0]['user_id'];
  $this->image = $query[0]['image'];

  return $this;
 }

 function insert_itme()
 {

  $this->db->insert('news', $this);
 }


}