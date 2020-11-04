<?php
class sales_reg_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    function getInvoiceListByDate($user_id=false,$prefix=null,$from_date=null,$to_date=null){
        $this->db->select('i.inv_id,i.inv_no as Inv_no,i.inv_type,i.prefix as Prefix,i.inv_date as Date,c.name as Name,sum(im.net_price+(im.net_price*p.igst/100)) as Amount');
        $this->db->from('cld_invoices i');
        $this->db->join('cld_contacts c','c.con_id=i.cust_id');
        $this->db->join('cld_invoice_meta im','im.inv_id=i.inv_id');
        $this->db->join('cld_products p','p.prod_id=im.prod_id');
        $this->db->group_by('i.inv_id');
        if($user_id===False){		
                $query=$this->db->get();
                return $query->result_array();
        }

        $this->db->where('i.user_id',$user_id);
        if($prefix!=null){
            $this->db->where('prefix',$prefix);
        }
        if($from_date!=null){
            $this->db->where('i.inv_date >=',$from_date);
        }
        if($to_date!=null){
            $this->db->where('i.inv_date <=',$to_date);
        }
        $this->db->where('i.inv_type',0);
        $this->db->order_by('inv_date','ASC');
        $this->db->order_by('inv_no','ASC');
        $query=$this->db->get();
        return $query->result_array();
    }
}