<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	class VerifyLogin extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('user','',TRUE);
			$this->load->library('form_validation');
		}
		function index(){

			$this->form_validation->set_rules('username','Username','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required|callback_check_database');

			if($this->form_validation->run()==FALSE){
				$this->load->view('templates/guest_header');
				$this->load->view('pages/login_form');
				$this->load->view('templates/footer');
			}
			else{
				redirect('/home','refresh');
			}
		}
		function check_database($password){
			$username=$this->input->post('username');

			$result=$this->user->login($username,$password);

			if($result){
				$sess_array= array();
				foreach ($result as $row) {
					$sess_array=array(
						'id'=>$row->ID,
						'username'=>$row->user_login,
                                                'display_name'=>$row->display_name,
                                                'address'=>$this->user->getAddress($row->ID),
                                                'f_year'=>'2019'
					);
					$this->session->set_userdata('logged_in', $sess_array);
				}
				return TRUE;
			}
			else{
				$this->form_validation->set_message('check_database','Invalid username or password.');
				return FALSE;
			}
		}
	}