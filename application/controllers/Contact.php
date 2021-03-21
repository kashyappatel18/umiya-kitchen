<?php if(!defined('BASEPATH')) exit('No direct script access allowed.');
class contact extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model(array('Contact_Model','Account_Model','User'));
                $this->load->library('m_pdf');
                $this->User->check_database('umiya','admin@123');
	}
	function index(){
            //$this->User->check_database('umiya','admin@123');
		if($this->session->userdata('logged_in')){
			$data['title']='Contact';
                        $data['js']='contact';

			$data['posts']=$this->Contact_Model->contactList();
                        $data['cTypes']=$this->Contact_Model->contactTypeList();
			//$data['js']="jQuery_test";

			$this->load->view('templates/header',$data);
			$this->load->view('pages/contact_view',$data);
			$this->load->view('templates/footer');
		}
		else{
			redirect('/login','refresh');
		}
	}
        function edit($con_id){
            if($this->session->userdata('logged_in')){
			$data['title']='Edit Contact';
                        //$data['con_id']=$con_id;

			$data['contact']=$this->Contact_Model->getContact($con_id);
                        $data['cTypes']=$this->Contact_Model->contactTypeList();
			//$data['js']="jQuery_test";

			$this->load->view('templates/header',$data);
			$this->load->view('pages/contact_view_edit',$data);
			$this->load->view('templates/footer');
		}
		else{
			redirect('/login','refresh');
		}
        }
	function insert(){
		$this->form_validation->set_rules('cust_name','Customer Name','trim|required|callback_is_available');
		$this->form_validation->set_rules('cust_contact','Contact','trim|numeric');
                $this->form_validation->set_rules('cust_gst','GST No','trim');
		$this->form_validation->set_rules('cust_add','Address','trim');
                $this->form_validation->set_rules('cust_city','City','trim|required');
		$this->form_validation->set_rules('cust_details','Details','trim');

		if($this->form_validation->run()==FALSE){
			$this->index();
		}
		else{
			$arr=array(
				'name'=>$this->input->post('cust_name'),
				'contact_no'=>$this->input->post('cust_contact'),
                                'gst_no'=>$this->input->post('cust_gst'),
				'address'=>$this->input->post('cust_add'),
                                'city'=>$this->input->post('cust_city'),
				'details'=>$this->input->post('cust_details'),
                                'con_typ_id'=>$this->input->post('conType'),
				'user_id'=>$this->session->userdata['logged_in']['id']
				);

			$con_id=$this->Contact_Model->insert($arr);
                        $prefix=$this->Contact_Model->conPrefix($this->input->post('conType'));
                        
                        $arr=array(
                            'ac_ref'=>$con_id,
                            'ac_name'=>$this->input->post('cust_name'),
                            'ac_type'=>$this->input->post('conType'),
                            'ac_code'=>$this->Account_Model->nextAcNo($prefix),
                            'user_id'=>$this->session->userdata['logged_in']['id']
                        );
                        $ac_id=$this->Account_Model->createConAc($arr);
                        $arr=array(
                            'ac_id'=>$ac_id,
                            'con_id'=>$con_id
                        );
                        $this->Account_Model->createAcRef($arr);
			redirect('/contact','refresh');
		}
	}
        function update(){
		$this->form_validation->set_rules('cust_name','Customer Name','trim|required');
		$this->form_validation->set_rules('cust_contact','Contact','trim|numeric');
                $this->form_validation->set_rules('cust_gst','GST TIN','trim');
		$this->form_validation->set_rules('cust_add','Address','trim');
                $this->form_validation->set_rules('cust_city','City','trim|required');
		$this->form_validation->set_rules('cust_details','Details','trim');

		if($this->form_validation->run()==FALSE){
			$this->index();
		}
		else{
                    $arr=array(
                            'name'=>$this->input->post('cust_name'),
                            'contact_no'=>$this->input->post('cust_contact'),
                            'gst_no'=>$this->input->post('cust_gst'),
                            'address'=>$this->input->post('cust_add'),
                            'city'=>$this->input->post('cust_city'),
                            'details'=>$this->input->post('cust_details')
                            );

                    $this->Contact_Model->update($arr,$this->input->post('con_id'));

                    redirect('/contact','refresh');
		}
	}
	function is_available($name){
		if(!$this->Contact_Model->is_available($name,$this->session->userdata['logged_in']['id']))
			return TRUE;
		else{
			$this->form_validation->set_message('is_available','Customer with same name already exists.');
			return FALSE;
		}
	}
        function envelop_print($con_id){
            if($this->session->userdata('logged_in')){
                $data['contact']=$this->Contact_Model->getContact($con_id);
                
                $html=$this->load->view('templates/pdf_header',NULL,true);
                $html.=$this->load->view('reports/envelop_front',$data,true);
                
                $filename='Addr-'.$con_id.'.pdf';

                $pdf=$this->m_pdf->load();
                $this->m_pdf->_setPageSize('UMIYAENV','',$pdf);
                $this->m_pdf->SetMargins(10,20,50,$pdf);
                $this->m_pdf->SetFont($pdf,'ctimes');
                $pdf->WriteHTML($html,0);
                $pdf->Output($filename,'I');
            }
            
        }
}