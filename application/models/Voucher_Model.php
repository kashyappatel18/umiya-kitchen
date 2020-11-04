<?php
class Voucher_Model extends CI_Model{
    function getVouchersOfAc($ac_code,$from_date=NULL,$to_date=NULL){
        $this->db->select('*');
        $this->db->from('VoucherListNAmnt');
        $this->db->where('ac_code',$ac_code);
        $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
        $this->db->order_by('Date','ASC');
        
        if(isset($from_date)&&isset($to_date)){
            $this->db->where('Date >=',$from_date);
            $this->db->where('Date <=',$to_date);
        }
        
        $query=$this->db->get();
        
        return $query->result_array();
    }
    function nextVNo(){
        $this->db->select_max('vno');
        $this->db->from('cld_vouchers');
        $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
        $this->db->where('f_year',$this->session->userdata['logged_in']['f_year']);
        
        $query=$this->db->get();
        
        if($query->num_rows()>0)
            return $query->row()->vno+1;
        else
            return 1;
    }
    function insertVoucher($arr){
        $this->db->insert('cld_vouchers',$arr);
        return $this->db->insert_id();
    }
    function insertDetail($arr){
        $this->db->insert('cld_details',$arr);
    }
    function insertSupport($arr){
        $this->db->insert('cld_support',$arr);
    }
    function insertVoucherRef($arr){
        $this->db->insert('cld_voucher_ref',$arr);
    }
}