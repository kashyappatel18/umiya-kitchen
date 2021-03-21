<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
//session_start();
	class Page extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->helper('date');
			$this->load->helper('form');
                        $this->load->library('session');
                        $this->load->model(array('User'));
                        $this->User->check_database('umiya','admin@123');
		}
		public function view($page='home'){
                    //$this->User->check_database('umiya','admin@123');
			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
				show_404();
			}

			if($this->session->userdata('logged_in')){
				$session_data=$this->session->userdata('logged_in');
                                $data=$this->$page();
				$data['username']=$session_data['username'];
			
				
                                
                                
				
				//print_r($data['posts']);
				$this->load->view('templates/header',$data);
				$this->load->view('pages/'.$page,$data);
				$this->load->view('templates/footer');
			}
			else if($page=="default")
                        {
                                $this->load->view('templates/guest_header');
				$this->load->view('pages/'.$page);
				$this->load->view('templates/footer');
                        }
                        else
                        {
                           // echo $page;
				//redirect('/login','refresh');
			}
		}
            function home(){
                $rs['title']="Dashboard";
                $rs['bills_receivable']=$this->Page_model->getBillsREceivable();
                $rs['bank_bal']= $this->Account_Model->getAcBalance(151001);
                $rs['cash_on_hand']= $this->Account_Model->getAcBalance(111001);
                return $rs;
            }
            function inv_print()
            {
                $rs['title']="Print";
                $rs['posts']=$this->Page_model->getInvoices($this->session->userdata['logged_in']['id']);
                return $rs;
            }
            function gst_print()
            {
                $rs['title']="Print Invoice";
                $rs['js']="print";
                $rs['posts']=$this->Page_model->getInvoices($this->session->userdata['logged_in']['id']);
                return $rs;
            }
	}
        