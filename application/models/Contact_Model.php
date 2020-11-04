<?php
class Contact_Model extends CI_Model{
	function contactList(){
		$this->db->select('*');
		$this->db->from('cld_contacts');
		$this->db->where('user_id',$this->session->userdata['logged_in']['id']);

		$query=$this->db->get();

		return $query->result_array();
	}
	function insert($arr){
		$this->db->insert('cld_contacts',$arr);
                return $this->db->insert_id();
	}
        function update($arr,$con_id){
            $this->db->where('con_id',$con_id);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            $this->db->update('cld_contacts',$arr);
        }
	function is_available($name,$user_id){
		$this->db->select('*');
		$this->db->from('cld_contacts');
		$this->db->where('user_id',$user_id);
		$this->db->where('name',$name);
		$this->db->limit(1);

		$query=$this->db->get();

		if($query->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
        function contactTypeList(){
            $this->db->select('*');
            $this->db->from('cld_contact_type');
            $this->db->where('ac_prefix is not null');
            
            $query=$this->db->get();
            
            return $query->result_array();
        }
        function getContact($con_id){
            $this->db->select('*');
            $this->db->from('cld_contacts');
            $this->db->where('con_id',$con_id);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            
            $query=$this->db->get();
            
            return $query->row();
        }
        function conPrefix($con_typ_id){
            $this->db->select('ac_prefix');
            $this->db->from('cld_contact_type');
            $this->db->where('con_typ_id',$con_typ_id);
            
            $query=$this->db->get();
            
            return $query->row()->ac_prefix;
        }
        function getConAddress($con_id){
            $this->db->select('*');
            $this->db->from('cld_contacts');
            $this->db->where('con_id',$con_id);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            
            $query=$this->db->get();
            
            return $query->row()->address;
        }
        function getConName($con_id){
            $this->db->select('*');
            $this->db->from('cld_contacts');
            $this->db->where('con_id',$con_id);
            $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
            
            $query=$this->db->get();
            
            return $query->row()->name;
        }
        function getContactByType($type){
            $this->db->select('*');
            $this->db->from('cld_contacts');
            $this->db->join('cld_contact_type','cld_contacts.con_typ_id=cld_contact_type.con_typ_id');
            $this->db->where('cld_contact_type.con_type',$type);
            $this->db->where('cld_contacts.user_id',$this->session->userdata['logged_in']['id']);
            $this->db->order_by('name','ASC');
            
            $query=$this->db->get();
            
            return $query->result_array();
        }
}	