<?php if(!defined('BASEPATH')) exit('No direct script access allowed.');
class Transaction extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model(array('Voucher_Model'));
    }
    function index(){
        $data['title']="Transactions";
        $data['js']='transaction';
        
        $data['ACs']=$this->Account_Model->getAcList();
        $data['nextVNo']=$this->Voucher_Model->nextVNo();
        $this->load->view('templates/header',$data);
        $this->load->view('pages/transaction_view',$data);
        $this->load->view('templates/footer');
    }
    function getRow(){
        $data['ACs']=$this->Account_Model->getAcList();
        $data['dType']=$this->input->post('dType');
        $this->load->view('customControls/transaction_row',$data);
    }
    function getBal(){
        echo $this->Account_Model->getAcBalCrDr($this->input->post('acNo'));
    }
    function insert(){
        $this->form_validation->set_rules('vDate','Date','required|date');
        $this->form_validation->set_rules('vNo','Voucher No','required|numeric');
        $this->form_validation->set_rules('vAmount','Voucher Amount','required|numeric|callback_verify_VoucherAmnt');
        $this->form_validation->set_rules('dAmount[]','Amount','required|numeric');
        $this->form_validation->set_rules('vNaration','Voucher Naration','required');
        $this->form_validation->set_rules('dNaration[]','Naration','required');
        $this->form_validation->set_rules('vAcNo','Voucher Account','required|callback_verify_duplication');
        $this->form_validation->set_rules('dAcNo[]','Account','required');
        
        if($this->form_validation->run()==FALSE){
            $this->index();
        }
        else {
            //write a code here to save data into database
            $vno=$this->input->post('vNo');
            $f_year=$this->session->userdata['logged_in']['f_year'];
            $user_id=$this->session->userdata['logged_in']['id'];
            $data=array(
                'vno'=>$vno,
                'vdate'=>nice_date($this->input->post('vDate'),'Y-m-d'),
                'vtype'=>$this->input->post('vType'),
                'ac_code'=>$this->input->post('vAcNo'),
                'f_year'=>$f_year,
                'user_id'=>$user_id
            );//data for cld_vouchers
            //write a method to insert $data to cld_vouchers
            $v_id=$this->Voucher_Model->insertVoucher($data);
            $data=array(
                'vno'=>$vno,
                'sno'=>1,
                'dname'=>$this->input->post('vNaration'),
                'f_year'=>$f_year,
                'v_id'=>$v_id,
                'user_id'=>$user_id
            );//data for cld_support
            //write a method to insert $data to cld_support
            $this->Voucher_Model->insertSupport($data);
            //$data=array();//data for cld_details
            for($i=0;$i<count($this->input->post('dAcNo'));$i++){
                $tmp['vno']=$vno;
                $tmp['sno']=$i+1;
                $tmp['ac_code']=$this->input->post('dAcNo')[$i];
                $tmp['amount']=$this->input->post('dAmount')[$i];
                $tmp['naration']=$this->input->post('dNaration')[$i];
                $tmp['f_year']=$f_year;
                $tmp['user_id']=$user_id;
                $tmp['v_id']=$v_id;
                //write a method to insert $data to cld_details
                $this->Voucher_Model->insertDetail($tmp);
                //$data[]=$tmp;                        
            }
            if($this->input->post('btnsave')!="Save")
		redirect('/transaction','refresh');
            else
		redirect('/transaction','refresh');
            //write a method to insert $data to cld_details
            /*echo '<pre>';
            echo nice_date($this->input->post('vDate'),'Y-m-d');
            echo '</pre>';*/
        }
    }
    function verify_VoucherAmnt($vAmount){
        $dAmountTot= array_sum($this->input->post('dAmount[]'));
        //Search array has "0" value if has than return an error.
        if(in_array(0, $this->input->post('dAmount[]'))){
            $this->form_validation->set_message('verify_VoucherAmnt','Amount can not be zero.');
            return FALSE;
        }
        
        if($dAmountTot==$vAmount && $vAmount>0){
            return TRUE;
        }
        else{
            $this->form_validation->set_message('verify_VoucherAmnt','Invalid voucher amount. Please check acording to double entry system.');
            return FALSE;
        }
    }
    function verify_duplication($vAcNo){
        //Verify details account dose not contain voucher account accourding to double entry system
        if(in_array($vAcNo, $this->input->post('dAcNo[]'))){
            $this->form_validation->set_message('verify_duplication','Can not Credit and Debit same account.');
            return FALSE;
        }else
            return TRUE;
    }
}
