<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Under_const extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('under_const_page');
	}
}