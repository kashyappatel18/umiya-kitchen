<?php
class SInvoice_Model extends CI_Model{
	/*function getNextInv(){
		$this->db->select_max('inv_no');
		$this->db->from('cld_invoices');
		$this->db->where('user_id',$this->session->userdata['logged_in']['id']);
		$query=$this->db->get();
		return $query->result()[0]->inv_no+1;
	} */
       function getNextInv($prefix=""){
		$this->db->select_max('inv_no');
		$this->db->from('cld_invoices');
		$this->db->where('user_id',$this->session->userdata['logged_in']['id']);
                $this->db->where('f_year',$this->session->userdata['logged_in']['f_year']);
                $this->db->where('prefix',$prefix);
                $this->db->where('inv_type',0);
                
		$query=$this->db->get();
                
                if($prefix!="")
                    return $prefix." ".sprintf("%03d",$query->result()[0]->inv_no+1);
                else
                    return $query->result()[0]->inv_no+1;
	}
	function insertInvoice($arr){
		$this->db->insert('cld_invoices',$arr);
		return $this->db->insert_id();
	}
	function insertInvMeta($arr){
		$this->db->insert_batch('cld_invoice_meta',$arr);
	}
	function getRInvMeta($invId){
		$this->db->select('im.inv_meta_id,p.prod_name,p.unit_code,im.qty,im.unit_price,im.net_price,p.sgst,p.cgst,p.igst,p.prod_code,p.prod_id');
		$this->db->from('cld_invoice_meta im');
		$this->db->join('cld_products p','im.prod_id=p.prod_id');
		$this->db->where('im.user_id',$this->session->userdata['logged_in']['id']);
		$this->db->where('inv_id',$invId);

		$query=$this->db->get();

		return $query->result_array();
	}
	function getRInvNo($invId){
		$this->db->select('*');
		$this->db->from('cld_invoices');
		$this->db->where('inv_id',$invId);
		$this->db->where('user_id',$this->session->userdata['logged_in']['id']);
		$this->db->limit(1);

		$query=$this->db->get();

                $prefix= isset($query->row()->prefix)?$query->row()->prefix." ":"";
		if($query->num_rows()==1)
			return $prefix.sprintf("%03d",$query->row()->inv_no);
		else
			return 0;
	}
	function getRInvData($invId){
		$this->db->select('*');
		$this->db->from('cld_invoices i');
		$this->db->join('cld_contacts c','i.cust_id=c.con_id');
		$this->db->where('i.inv_id',$invId);
		$this->db->where('i.user_id',$this->session->userdata['logged_in']['id']);
		$this->db->limit(1);

		$query=$this->db->get();

		if($query->num_rows()==1)
			return $query->row();
		else
			return 0;
	}
	function getInvoiceTotal($invId){
		$this->db->select_sum('net_price');
		$this->db->from('cld_invoice_meta');
		$this->db->where('inv_id',$invId);

		$query=$this->db->get();

		return $query->row()->net_price;
	}
        function trans_search($keyword){
            $this->db->select('trans_details,inv_id');
            $this->db->distinct();
            $this->db->from('cld_invoices');
            $this->db->like('trans_details',$keyword,'after');
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            $this->db->group_by('trans_details');
            
            $query=$this->db->get();
            
            return $query->result_array();
        }
        function deleteInvMetasNotIn($inv_id,$meta_ids){
            
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            $this->db->where('inv_id',$inv_id);
            $this->db->where_not_in('inv_meta_id',$meta_ids);
            $this->db->delete('cld_invoice_meta');
        }
        function replaceInvMetas($metas){
            $this->db->replace('cld_invoice_meta',$metas);
        }
        function convertInvIdToVId($inv_id){
            $this->db->select('v_id');
            $this->db->from('cld_voucher_ref');
            $this->db->where('inv_id',$inv_id);
            
            $query=$this->db->get();
            
            return $query->row()->v_id;
        }
        function updateDetails($v_id,$ac_code,$amount,$narration){
            
            $this->db->where(array('v_id'=>$v_id,'ac_code'=>$ac_code));
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            $this->db->update('cld_details',array('amount'=>$amount,'naration'=>$narration));
        }
        function updateInvoice($inv_id,$inv_date,$inv_no,$prefix,$narration,$trans_details){
            $this->db->where(array('inv_id'=>$inv_id,'user_id'=>$this->session->userdata['logged_in']['id']));
            $this->db->update('cld_invoices',array('inv_date'=>$inv_date,'prefix'=>$prefix,'inv_no'=>$inv_no,'narration'=>$narration,'trans_details'=>$trans_details));
        }
        function updateSupport($v_id,$narration){
            $this->db->where(array('v_id'=>$v_id,'user_id'=>$this->session->userdata['logged_in']['id']));
            $this->db->update('cld_support',array('dname'=>$narration));
        }
	
}