<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model(array('Product_Model','Contact_Model'));
	}
	function index(){
		if($this->session->userdata('logged_in')){
                        $data['title']='Products';
			$data['posts']=$this->Product_Model->getList();
                        $data['con_list']=$this->Contact_Model->getContactByType("Supplier");

			$this->load->view('templates/header',$data);
			$this->load->view('pages/product_view',$data);
			$this->load->view('templates/footer');
		}
		else{
			redirect('/login','refresh');
		}
	}
	function insert(){
		$this->form_validation->set_rules('prod_name','Product Name','required|is_unique[cld_products.prod_name]');
		$this->form_validation->set_rules('prod_code','Product Code','required');
		$this->form_validation->set_rules('unit_prise','Unit Prise','required|numeric');
                $this->form_validation->set_rules('taxSlab','Tax Slab','required|numeric|callback_is_gst');

		if($this->form_validation->run()==FALSE){
			$this->index();
		}
		else{
			$arr= array(
					'prod_name' =>$this->input->post('prod_name') , 
					'prod_code' =>$this->input->post('prod_code') , 
					'unit_price' =>$this->input->post('unit_prise') , 
                                        'sgst'=> $this->input->post('taxSlab')/2,
                                        'cgst'=> $this->input->post('taxSlab')/2,
                                        'igst'=> $this->input->post('taxSlab'),
					'user_id' =>$this->session->userdata['logged_in']['id']
				);
			$prod_id=$this->Product_Model->insert($arr);
                        
                        $arr=array(
                            'con_id' =>$this->input->post('supplier') ,
                            'prod_id'=>$prod_id
                        );
                        if($arr['con_id'] !=0){
                            $this->Product_Model->insertProdSupplier($arr);
                        }

			redirect('/product','refresh');
		}
	}
        function update(){
                $this->form_validation->set_rules('prod_name','Product Name','required');
		$this->form_validation->set_rules('prod_code','Product Code','required');
		$this->form_validation->set_rules('unit_prise','Unit Prise','required|numeric');
                $this->form_validation->set_rules('taxSlab','Tax Slab','required|numeric|callback_is_gst');

		if($this->form_validation->run()==FALSE){
			$this->edit($this->input->post('prod_id'));
		}
		else{
			$arr= array(
                            'prod_name' =>$this->input->post('prod_name') , 
                            'prod_code' =>$this->input->post('prod_code') , 
                            'unit_price' =>$this->input->post('unit_prise') , 
                            'unit_code' =>$this->input->post('unit_code') ,
                            'prod_mrp' =>$this->input->post('prod_mrp') ,
                            'sgst'=> $this->input->post('taxSlab')/2,
                            'cgst'=> $this->input->post('taxSlab')/2,
                            'igst'=> $this->input->post('taxSlab'),
                            'user_id' =>$this->session->userdata['logged_in']['id']
                        );
			$this->Product_Model->update($arr,$this->input->post('prod_id'));
                        
			redirect('/product','refresh');
		}
        }
        function edit($prod_id){
            if($this->session->userdata('logged_in')){
                    $data['title']='Edit Product';
                    //$data['con_id']=$con_id;

                    $data['product']=$this->Product_Model->getProductById($prod_id);
                    //$data['js']="jQuery_test";

                    $this->load->view('templates/header',$data);
                    $this->load->view('pages/product_view_edit',$data);
                    $this->load->view('templates/footer');
            }
            else{
                    redirect('/login','refresh');
            }
        }
        function getRate(){
            $prod_id=$this->input->post('prod_id');
            $con_id=$this->input->post('cust_id');
            $inv_type=$this->input->post('inv_type');
            //echo $con_id;
            echo $this->Product_Model->getRate($prod_id,$con_id,$inv_type);
        }
        function getQty(){
            $prod_id=$this->input->post('prod_id');
            echo $this->Product_Model->getQty($prod_id);
        }
        function is_gst($val){
            $taxSlab=array(0,5,12,18,28);
            if(in_array($val, $taxSlab)){
                return TRUE;
            }
            else{
                $this->form_validation->set_message('is_gst','Invalid Tax Slab You Selectd.Valid tax slab is 0, 5, 12, 18, 28');
                return FALSE;
            }
        }
        function prod_search(){
            $keyword=$_GET['term'];
            $arr=$this->Product_Model->searchProductByName($keyword);
            $res=array();
            foreach ($arr as $row){
                $json_row['id']=$row['prod_id'];
                $json_row['name']=stripcslashes($row['prod_name']);
                array_push($res,$json_row);
            }
            
            echo json_encode($res);
        }
}