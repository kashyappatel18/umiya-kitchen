<?php
class Product_Model extends CI_Model{
	function insert($arr){
		$this->db->insert('cld_products',$arr);
                return $this->db->insert_id();
	}
        function update($arr,$prod_id){
            print_r($arr);
            echo $prod_id;
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            $this->db->where('prod_id',$prod_id);
            $this->db->update('cld_products',$arr);
        }
        function insertProdSupplier($arr){
            $this->db->insert('cld_productSupplier',$arr);
        }
	function getList(){
		$this->db->select('*');
		$this->db->from('cld_products');
		$this->db->where('user_id',$this->session->userdata['logged_in']['id']);

		$query=$this->db->get();

		return $query->result_array();
	}
        function getRate($prod_id,$con_id,$inv_type=0){
            $this->db->select('*');
            $this->db->from('cld_invoice_meta im');
            $this->db->join('cld_invoices i','im.inv_id=i.inv_id');
            $this->db->where('i.cust_id',$con_id);
            $this->db->where('im.prod_id',$prod_id);
            $this->db->where('i.inv_type',$inv_type);
            $this->db->order_by('i.inv_no','DESC');
            $this->db->limit(1);
            
            $query=$this->db->get();
            
            //$unit_price=$query->row()->unit_price;
            //return $query->num_rows();
            if($query->num_rows()==1)
                return $query->row()->unit_price;
            else{
               $this->db->select('unit_price');
            $this->db->from('cld_products');
            $this->db->where('prod_id',$prod_id);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            
            $query=$this->db->get();
            
            return $query->row()->unit_price;
            }
        }
        function getProductFromSupplier($con_id=NULL){
            $this->db->select('*');
            $this->db->from('cld_products p');
            $this->db->join('cld_productSupplier ps','ps.prod_id=p.prod_id');
            $this->db->where('p.user_id',$this->session->userdata['logged_in']['id']);
            if(isset($con_id)){
                $this->db->where('ps.con_id',$con_id);
            }
            
            $query=$this->db->get();
            
            return $query->result_array();
        }
        function getTaxRate($prod_id){
            $this->db->select('sgst,cgst,igst');
            $this->db->from('cld_products');
            $this->db->where('prod_id',$prod_id);
            
            
        }
        function searchProductByName($keyword){
            //$new_str= str_replace(" ", "+", $keyword);
            //$regex="^(?=.*?(std|8))(?=.*?(std|8)).*$";
            //$where='MATCH(prod_name) AGAINST("'.$keyword.'" IN BOOLEAN MODE)';
            $this->db->select('*');
            $this->db->from('cld_products');
            $this->db->like('prod_name',$keyword);
            //$this->db->where($where);
            //$this->db->like('prod_name',$regex);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            //$this->db->order_by($where,'DESc');
            
            $query=$this->db->get();
            
            return $query->result_array();
        }
        function getProductById($prod_id){
            $this->db->select('*');
            $this->db->from('cld_products');
            $this->db->where('prod_id',$prod_id);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            
            $query=$this->db->get();
            
            return $query->row();
        }
        function getQty($prod_id){
            $this->db->select('sum(qty) as qty');
            $this->db->from('stock_register');
            $this->db->where('prod_id',$prod_id);
            
            $query=$this->db->get();
            
            return $query->row()->qty;
        }
}