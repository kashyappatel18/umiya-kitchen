<?php
class Gstinv extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model(array('Voucher_Model','User'));
        $this->load->library('m_pdf');
        $this->User->check_database('umiya','admin@123');
    }
    function index(){
        //$this->User->check_database('umiya','admin@123');
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
    function genInv($inv_id){
        if($this->session->userdata('logged_in')){
            if(is_null($invId) or $this->SInvoice_Model->getRInvNo($invId)==""){
                    show_404();

            }
            $taxs=$this->Tax_Model->getFTaxType($invId);


            //$data['title']=ucfirst($page); $invId
            $data['address']=$this->session->userdata['logged_in']['address'];
            $data['memoType']=$this->User->getDefaultMemoType($this->session->userdata['logged_in']['id']);
            $data['invNo']=$this->SInvoice_Model->getRInvNo($invId);
            $data['invData']=$this->SInvoice_Model->getRInvData($invId);
            $data['inv_tax_type']=$this->Tax_Model->getRInvoiceType($invId);
            $data['inv_metas']=$this->SInvoice_Model->getRInvMeta($invId);
            $data['display_name']=$this->User->getDisplayName();
            $data['invTot']=$this->SInvoice_Model->getInvoiceTotal($invId);
            $data['taxType']=$this->textFTaxType($taxs);
            $data['taxVal']=$this->fTaxType($data['invTot'],$taxs);
            $gtot=$this->grandTot($data['invTot'],$taxs);
            $data['gtot']=number_format(round($gtot,0),2);
            $data['roundOff']=number_format($this->roundOff($data['gtot'],$gtot),2);
            $data['amtinword']=$this->Reports_model->amtToWord(round($gtot,0));
            
            $html1= $this->load->view('reports/gst_inv_header',$data,true);
            $html=$this->load->view('templates/pdf_header',NULL,true);
            $html.=$this->load->view('reports/gst_invoice',$data,true);     

            $filename=$data['ac_name'].'-INV-'.date('invNo').'.pdf';

            $pdf=$this->m_pdf->load();
            
            $pdf->WriteHTML($html,0);
            $pdf->Output($filename,'I');
        }
        else
            redirect('/login','refresh');
        
        
        
        
        
        
        
        
        
    }
}
