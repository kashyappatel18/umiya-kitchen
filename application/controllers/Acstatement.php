<?php
class Acstatement extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model(array('Voucher_Model'));
        $this->load->library('m_pdf');
    }
    function index(){
        if($this->session->userdata('logged_in')){
            //initialize default data for the view
            $data['title']='Account Statement';
            
            //initiate dynamic data using model for view
            $data['acs']=$this->Account_Model->getAcList();
            
            //load the view to display form
            $this->load->view('templates/header',$data);
            $this->load->view('pages/ac_stat_form',$data);
            $this->load->view('templates/footer');            
        }
    }
    function genAcStatement(){
        $from_date=$this->Account_Model->getFromDate($this->input->post('ac_code'),$this->input->post('from_date'));
        
        $data['ac_name']=$this->Account_Model->getAcName($this->input->post('ac_code'));
        $data['from_date']=$from_date;
        $data['display_name']=$this->User->getDisplayName();
        $data['to_date']=$this->input->post('to_date');
        $data['op_bal']=$this->Account_Model->getAcBalance($this->input->post('ac_code'),$from_date);
        $data['trans']=$this->Voucher_Model->getVouchersOfAc($this->input->post('ac_code'),$this->input->post('from_date'),$this->input->post('to_date'));
        
        
        $html=$this->load->view('templates/pdf_header',NULL,true);
        $html.=$this->load->view('reports/ac_statement',$data,true);     
        
        $filename=$data['ac_name'].'-STMT-'.date('Ymd').'.pdf';
        
        $pdf=$this->m_pdf->load();
        $pdf->WriteHTML($html,0);
        $pdf->Output($filename,'I');
        
        
        
        
        
        
    }
}
