<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	function __construct()
	{
		parent::__construct();
		//$this->load->model('test');
		$this->load->model('Item');
		$this->load->model('payment_details');
	}

	/*public function index()
	{
		$this->load->view('welcome_message');

		$test = new test();
		$test = $test->get_one('2');
		var_dump($test);
	}*/

	public function add()
	{
		$this->load->view('welcome_message');
	}

	public function Items(){
		$item = new Item();
		$payment = new payment_details();

		$x = $payment->get_count('383068');
		//$x = $item->get_all();
		echo json_encode($x);

	}
}
