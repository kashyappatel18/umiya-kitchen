<?php
	class User extends CI_Model{
		function login($username,$password){
			$this->db->select('*');
			$this->db->from('wp_users');
			$this->db->where('user_login',$username);
			$this->db->where('user_pass',md5($password));
			$this->db->limit(1);

			$query=$this->db->get();

			if($query->num_rows()==1){
				return $query->result();
			}
			else{
				return false;
			}
		}
                function getAddress($user_id){
                    $this->db->select('*');
                    $this->db->from('wp_usermeta');
                    $this->db->where('user_id',$user_id);
                    $this->db->where('meta_key','address');
                    
                    $query=$this->db->get();
                    
                    return $query->row()->meta_value;
                }
                public function getDisplayName(){
			$this->db->select('display_name');
			$this->db->from('wp_users');
			$this->db->where('ID',$this->session->userdata['logged_in']['id']);
			$query=$this->db->get();
			return $query->row()->display_name;
		}
                public function getUserMetaValue($key){
                    $this->db->select('*');
                    $this->db->from('wp_usermeta');
                    $this->db->where('user_id',$this->session->userdata['logged_in']['id']);
                    $this->db->where('meta_key',$key);
                    
                    $query=$this->db->get();
                    
                    return $query->row()->meta_value;
                }
                public function getDefaultMemoType($user_id){
                    $this->db->select('*');
                    $this->db->from('wp_usermeta');
                    $this->db->where('user_id',$user_id);
                    $this->db->where('meta_key','default_memo_type');
                    
                    $query=$this->db->get();
                    
                    return $query->row()->meta_value;
                }
	}