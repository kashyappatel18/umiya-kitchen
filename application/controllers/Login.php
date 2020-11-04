<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	class Login extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->helper('form');
		}
		public function index(){
			$this->load->view('templates/guest_header');
			$this->load->view('pages/login_form');
			$this->load->view('templates/footer');
		}
		function logout(){
			$this->session->unset_userdata('logged_in');
			session_destroy();
			redirect('home','refresh');
		}
	}