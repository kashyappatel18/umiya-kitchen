<?php 
class Account_Model extends CI_Model {
    function nextAcNo($prefix){
        $this->db->select_max('ac_code');
        $this->db->from('cld_accounts');
        $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
        $this->db->like('ac_code',$prefix,"after");
        
        $query=$this->db->get();
        
        if($query->row()->ac_code>$prefix*1000)
            return $query->row()->ac_code+1;
        else
            return $prefix.sprintf("%03d",$query->row()->ac_code+1);
        
    }
    function createConAc($arr){// create new account using contact_id for customer or supplier account
        $this->db->insert('cld_accounts',$arr);
        return $this->db->insert_id();
    }
    function createAcRef($arr){
        $this->db->insert('cld_account_ref',$arr);
    }
    function getConAcNo($con_id){ // this function is used for getting account number from contact_id while createing invoice.
        $this->db->select('ac_code');
        $this->db->from('cld_accounts');
        $this->db->join('cld_account_ref','cld_account_ref.ac_id=cld_accounts.ac_id');
        //$this->db->where('cld_accounts.user_id',$this->session->userdata['logged_in']['id']);
        $this->db->where('cld_account_ref.con_id',$con_id);
        
        $query=$this->db->get();
        
        return $query->row()->ac_code;
    }
    function getAcList(){
        $this->db->select('*');
        $this->db->from('cld_accounts');
        $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
        $this->db->order_by('ac_name','ASC');
        
        $query=$this->db->get();
        
        return $query->result_array();
    }
    function getAcBalCrDr($acNo){
        $this->db->select('sum(Amount) as Balance');
        $this->db->from('ACBal');
        $this->db->where('User_id',$this->session->userdata['logged_in']['id']);
        $this->db->where('F_Year',$this->session->userdata['logged_in']['f_year']);
        $this->db->where('Ac_Code',$acNo);
        
        $query=$this->db->get();
        
        //return $query->result_array();
        //return $query->row()->Amount;
        return $this->convertNumToCrDr($query->row()->Balance);
    }
    function convertNumToCrDr($amount){
        if($amount<0){
            return abs($amount).' &nbsp;&nbsp;Dr';
        }else{
            return $amount.' &nbsp;&nbsp;Cr';
        }
    }
    function getAcBalance($ac_code,$date=NULL){
        $this->db->select('sum(Amount) as Balance');
        $this->db->from('VoucherListNAmnt');
        $this->db->where('ac_code',$ac_code);
        $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
        //$this->db->group_by('vType');
        
        if(isset($date))
            $this->db->where('Date <',$date);
        
        $query=$this->db->get();
        /*if($query->num_rows()>1)
            return $query->row(1)->Balance-$query->row(0)->Balance;
        else if($query->num_rows()==1*/
            return $query->row()->Balance;
      /*  else 
            return 0;*/
    }
    function getFromDate($ac_code,$date=NULL){
        $this->db->select('min(Date) as MinDate');
        $this->db->from('VoucherList');
        $this->db->where('Ac_Code',$ac_code);
        $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
        
        $query=$this->db->get();
        $mDate=$query->row()->MinDate;
        return ($mDate>=$date)?$mDate:$date;
    }// transfer this to Voucher_model
    function getAcName($acno){
        $this->db->select('*');
        $this->db->from('cld_accounts');
        $this->db->where('ac_code',$acno);
        $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
        
        
        $query=$this->db->get();
            
        return $query->row()->ac_name;
    }
}
