<?php
	class Page_model extends CI_Model{
		public function __construct(){
			$this->load->database();
		}
		public function getInvoices($slug= False,$prefix=null){
			$this->db->select('i.inv_id,i.inv_no,i.inv_type,i.prefix,i.inv_date,c.name,sum(im.net_price+(im.net_price*p.igst/100)) as amount');
			$this->db->from('cld_invoices i');
			$this->db->join('cld_contacts c','c.con_id=i.cust_id');
                        $this->db->join('cld_invoice_meta im','im.inv_id=i.inv_id');
                        $this->db->join('cld_products p','p.prod_id=im.prod_id');
                        $this->db->group_by('i.inv_id');
			if($slug===False){		
				$query=$this->db->get();
				return $query->result_array();
			}

			$this->db->where('i.user_id',$slug);
                        if($prefix!=null){
                            $this->db->where('prefix',$prefix);
                        }else
                            $this->db->where_in('prefix',array("GT","CN"));
			$this->db->order_by('inv_date','DESC');
                        $this->db->order_by('inv_no','DESC');
			$query=$this->db->get();
			return $query->result_array();
		}
                public function getBillsREceivable(){
                    $this->db->select('sum(Amount) as Amount');
                    $this->db->from('VoucherListNAmnt');
                    $this->db->like('Ac_Code','121','after');
                    $this->db->where('User_id',$this->session->userdata['logged_in']['id']);
                    
                    $query=$this->db->get();
                    
                    return $query->row()->Amount;
                }
	}