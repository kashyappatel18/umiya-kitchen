<?php
class Sales_reg extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model(array('Sales_reg_Model','User'));
        $this->load->library('m_pdf');
        $this->load->helper('date');
        $this->load->helper('form');
        $this->User->check_database('umiya','admin@123');
    }
    function index(){
        //$this->User->check_database('umiya','admin@123');
        if($this->session->userdata('logged_in')){
            //initialize default data for the view
            $data['title']='Sales Register';
            
            //initiate dynamic data using model for view
            //$data['acs']=$this->Account_Model->getAcList();
            
            //load the view to display form
            $this->load->view('templates/header',$data);
            $this->load->view('pages/sales_reg_form',$data);
            $this->load->view('templates/footer');            
        }
    }
    function genSalesReg(){
        $from_date=$this->input->post('from_date');
        $to_date=$this->input->post('to_date');
        if(date($from_date) < date('2017-07-01')){
            $from_date='2017-07-01';
        }
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['display_name']=$this->User->getDisplayName();
        $data['recs']=$this->Sales_reg_Model->getInvoiceListByDate($this->session->userdata['logged_in']['id'],"GT",$from_date,$to_date);
        
        $html=$this->load->view('templates/pdf_header',NULL,true);
        $html.=$this->load->view('reports/sales_register',$data,true);     
        
        $filename=$data['ac_name'].'-STMT-'.date('Ymd').'.pdf';
        
        $pdf=$this->m_pdf->load();
        $pdf->WriteHTML($html,0);
        $pdf->Output($filename,'I');
    }
}