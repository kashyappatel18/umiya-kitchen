<?php
class Tax_Model extends CI_Model{
	function getInvoiceTypes(){
		$this->db->select('*');
		$this->db->from('cld_tax');
		$this->db->where('user_id',$this->session->userdata['logged_in']['id']);
                $this->db->where('status',1);

		$query=$this->db->get();

		return $query->result_array();
	}
	function insert($arr){
		$this->db->insert('cld_tax_meta',$arr);
	}

	function getRInvoiceType($invId){
		$this->db->select('*');
		$this->db->from('cld_tax_meta tm');
		$this->db->join('cld_tax t','tm.tax_id=t.tax_id');
		$this->db->where('tm.user_id',$this->session->userdata['logged_in']['id']);
		$this->db->where('tm.inv_id',$invId);
		$this->db->limit(1);

		$query=$this->db->get();

		return $query->row()->tax_name;
	}
	function getFTaxType($invId){
		$this->db->select('*');
		$this->db->from('cld_tax_meta tm');
		$this->db->join('cld_tax_type tt','tm.tax_id=tt.tax_id');
		$this->db->where('tm.user_id',$this->session->userdata['logged_in']['id']);
		$this->db->where('tm.inv_id',$invId);

		$query=$this->db->get();

		return $query->result_array();
	}
        function getGSTTaxVal($invId){
            $this->db->select('sum(sgst*net_price/100) as SGST,sum(cgst*net_price/100) as CGST,sum(igst*net_price/100) as IGST');
            $this->db->from('cld_invoice_meta im');
            $this->db->join('cld_products p','im.prod_id=p.prod_id');
            $this->db->where('im.user_id', $this->session->userdata['logged_in']['id']);
            $this->db->where('im.inv_id',$invId);
            
            $query= $this->db->get();
            
            return $query->row();
        }
        function getGSTTaxType($invId){
            $this->db->select('tt.tax_type');
            $this->db->from('cld_tax_type tt');
            $this->db->join('cld_tax_meta tm','tt.tax_id=tm.tax_id');
            $this->db->where('tm.inv_id',$invId);
            $this->db->where('tm.user_id',$this->session->userdata['logged_in']['id']);
            
            $query=$this->db->get();
            
            return $query->result_array();
        }
        function getGSTTaxValSum($invId){
                    $arr=$this->Tax_Model->getGSTTaxVal($invId);
                    $arr2=$this->Tax_Model->getGSTTaxType($invId);
                    $res=0;
                    foreach($arr2 as $sarr){
                        $res+=$arr->$sarr['tax_type']; //$arr->$sarr['tax_type']
                    }
                    return $res;
                }
        function getInvPrefix($tax_id){
            $this->db->select('prefix');
            $this->db->from('cld_tax');
            $this->db->where('tax_id',$tax_id);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            
            $query=$this->db->get();
            
            return $query->row()->prefix;
        }
        function getCrAcNo($tax_id){
            $this->db->select('cr_ac_no');
            $this->db->from('cld_tax');
            $this->db->where('tax_id',$tax_id);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            
            $query=$this->db->get();
            
            return $query->row()->cr_ac_no;
        }
        function updateTaxMeta($invId,$taxId){
            $this->db->where('inv_id',$invId);
            $this->db->update('cld_tax_meta',array('tax_id'=>$taxId));
        }
}