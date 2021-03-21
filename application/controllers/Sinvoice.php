<?php if(!defined('BASEPATH')) exit('No direct script access allowed.');
class sinvoice extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form','date'));
		$this->load->model(array('Contact_Model','Product_Model','Tax_Model','SInvoice_Model','Voucher_Model','User'));
                $this->User->check_database('umiya','admin@123');
	}
	function index(){
            //$this->User->check_database('umiya','admin@123');
		if($this->session->userdata('logged_in')){
			$data['title']="Sales Invoice";
			$data['js']="sales_invoice";

			$data['contacts']=$this->Contact_Model->getContactByType("Customer");
			$data['invoiceTypes']=$this->Tax_Model->getInvoiceTypes();
			$data['products']=$this->Product_Model->getList();
			$data['nextInvNo']=$this->SInvoice_Model->getNextInv("GT");
			$data['blankRow']=$this->load->view('customControls/sinvoice_Row','',TRUE);

			
			$this->load->view('templates/header',$data);
			$this->load->view('pages/sinvoice_view',$data);
			$this->load->view('templates/footer');
		}
		else{
			redirect('/login','refresh');
		}
	}
        function edit($invId){
            if($this->session->userdata('logged_in')){
                $data['title']="Edit Sales Invoice";
                $data['js']="sales_invoice";
                
                $data['inv_id']=$invId;
                $data['invNo']=$this->SInvoice_Model->getRInvNo($invId);
                $data['invData']=$this->SInvoice_Model->getRInvData($invId);
                $data['invoiceTypes']=$this->Tax_Model->getInvoiceTypes();
                $data['inv_tax_type']=$this->Tax_Model->getRInvoiceType($invId);
                $data['inv_metas']=$this->SInvoice_Model->getRInvMeta($invId);
                $data['products']=$this->Product_Model->getList();
                $data['blankRow']=$this->load->view('customControls/sinvoice_Row','',TRUE);
                        
                //load view
                $this->load->view('templates/header',$data);
                $this->load->view('pages/sinvoice_view_edit',$data);
                $this->load->view('templates/footer');
            }
            else{
                redirect('/login','refresh');
            }
        }
        function delete($invId){
            if($this->session->userdata('logged_in')){
                $data['title']="Confirm Delete";
                $data['js']="sales_invoice";
                $data['v_id']=$this->SInvoice_Model->convertInvIdToVId($invId);
                echo 'Invoice No '.$invId.' and Voucher No '.$data['v_id'].' are Selected.';
                
            }else
                redirect ('/login','refresh');
        }
        function nextInvNo(){
            $tax_id=$this->input->post('tax_id');
            
            $prefix=$this->Tax_Model->getInvPrefix($tax_id);
            $inv_no=$this->SInvoice_Model->getNextInv($prefix);
            
            echo $inv_no;
        }
	function getRow(){
		$data['products']=$this->Product_Model->getList();
		$this->load->view('customControls/sinvoice_Row',$data);
		//echo 'test';
	}
	function insert(){
		$this->form_validation->set_rules('con_id','Customer','required');
		$this->form_validation->set_rules('inv_date','Invoice Date','required');
		$this->form_validation->set_rules('inv_no','Invoice No','required');
		$this->form_validation->set_rules('product[]','Product','required');
		$this->form_validation->set_rules('qty[]','Quantity','required|numeric');
		$this->form_validation->set_rules('unit_price[]','Unit Price','required|numeric');
		$this->form_validation->set_rules('net_price[]','Net Amount','required|numeric');
                $this->form_validation->set_rules('prod_name[]','Product Name','required');

		if($this->form_validation->run()==FALSE){
			$this->index();
		}
		else{
                        $invNo= explode(" ",$this->input->post('inv_no'));//seprate string and no of inv no
			$data['inv_data']=array(
				'inv_no'=>(isset($invNo[1])?$invNo[1]:$invNo[0]),// check inv no and get only numeric value
                                'prefix'=>(isset($invNo[1])?$invNo[0]:""),
				'cust_id'=>$this->input->post('con_id'),
				'inv_date'=>nice_date($this->input->post('inv_date'),'Y-m-d'),
				'trans_details'=>$this->input->post('trans_details'),
				'narration'=>$this->input->post('narration'),
                                'inv_type'=>0,
				'user_id' =>$this->session->userdata['logged_in']['id'],
                                'f_year'=>$this->session->userdata['logged_in']['f_year']
				);
			$inv_id=$this->SInvoice_Model->insertInvoice($data['inv_data']);// insert above data to cld_invoice
			$data['inv_meta'] = array();
			for ($i=0; $i < count($this->input->post('product')); $i++) { 
				$tmp['prod_id']=$this->input->post('product')[$i];
				$tmp['qty']=$this->input->post('qty')[$i];
				$tmp['unit_price']=$this->input->post('unit_price')[$i];
				$tmp['net_price']=$this->input->post('net_price')[$i];
				$tmp['user_id'] =$this->session->userdata['logged_in']['id'];
				$tmp['inv_id']=$inv_id;
				$data['inv_meta'][]=$tmp;
			}			
			$this->SInvoice_Model->insertInvMeta($data['inv_meta']);//insert above data to cld_invoice_meta
			$data['tax']=array('inv_id'=>$inv_id,'tax_id'=>$this->input->post('tax_id'),'user_id'=>$this->session->userdata['logged_in']['id']);
			$this->Tax_Model->insert($data['tax']);//insert above data to cld_tax_meta
                        $vno=$this->Voucher_Model->nextVNo();//get next voucher no from cld_vouchers 
                        //for credit vno,date,sales ac no,vtype,user id in vouchers
                        $arr=array(
                            'vno'=>$vno,
                            'vdate'=>nice_date($this->input->post('inv_date'),'Y-m-d'),
                            'vtype'=>1,
                            'ac_code'=>$this->Account_Model->getConAcNo($this->input->post('con_id')),//get Dr. account no of customer to debit invoice
                            'f_year'=>$this->session->userdata['logged_in']['f_year'],
                            'user_id'=>$this->session->userdata['logged_in']['id']
                        );
                        $v_id=$this->Voucher_Model->insertVoucher($arr);//insert data to cld_vouchers
                        $v_ref=array(
                            'v_id'=>$v_id,
                            'inv_id'=>$inv_id
                            );
                        $this->Voucher_Model->insertVoucherRef($v_ref);
                        $taxs=$this->Tax_Model->getGSTTaxValSum($inv_id);
                        $tot=$this->SInvoice_Model->getInvoiceTotal($inv_id);
                        $gtot=round($tot)+$taxs;
                        $name=$this->SInvoice_Model->getRInvData($inv_id)->name;
                        $support=array(
                            'vno'=>$vno,
                            'sno'=>1,
                            'dname'=>'Invoice No:'.$this->input->post('inv_no').' issued to '.$name,
                            'f_year'=>$this->session->userdata['logged_in']['f_year'],
                            'v_id'=>$v_id,
                            'user_id'=>$this->session->userdata['logged_in']['id']
                        );
                        $this->Voucher_Model->insertSupport($support);
                        //print_r($taxs);
                        // for debit vno,sno,party ac no, amount, narration, user id in details$details
                        $details=array();
                        $details=array(
                                    'vno'=>$vno,
                                    'sno'=>1,
                                    'ac_code'=>$this->Tax_Model->getCrAcNo($this->input->post('tax_id')),
                                    'amount'=>$this->SInvoice_Model->getInvoiceTotal($inv_id),
                                    'naration'=>'Invoice No:'.$this->input->post('inv_no').' issued to '.$name,
                                    'v_id'=>$v_id,
                                    'f_year'=>$this->session->userdata['logged_in']['f_year'],
                                    'user_id'=>$this->session->userdata['logged_in']['id']
                            );
                        $this->Voucher_Model->insertDetail($details);
                        $details=array(
                                    'vno'=>$vno,
                                    'sno'=>2,
                                    'ac_code'=>227001,
                                    'amount'=>($gtot-$tot),
                                    'naration'=>'Tax on Sales Invoice No:'.$data['inv_data']['inv_no'].' issued to '.$name,
                                    'f_year'=>$this->session->userdata['logged_in']['f_year'],
                                    'v_id'=>$v_id,
                                    'user_id'=>$this->session->userdata['logged_in']['id']
                                );
                        //print_r($details);
                        if($gtot!=$tot)
                            $this->Voucher_Model->insertDetail($details);
                        
			if($this->input->post('btnsave')!="Save")
				redirect('/reports/gst_invoice/'.$inv_id,'refresh');
			else
				redirect('/sinvoice','refresh');
		}
	}
        function update(){
            if($this->input->post('btnsave')=="Delete"){
                if($this->input->post('delPass')==$this->input->post('inv_id'))
                $this->delete($this->input->post('inv_id'));
                else
                    echo 'You are not authorised to delete record.';
            }
            else{
            $this->form_validation->set_rules('con_id','Customer','required');
            $this->form_validation->set_rules('inv_date','Invoice Date','required');
            $this->form_validation->set_rules('inv_no','Invoice No','required');
            $this->form_validation->set_rules('inv_id','Invoice Unique Id','required');
            $this->form_validation->set_rules('product[]','Product','required');
            $this->form_validation->set_rules('qty[]','Quantity','required|numeric');
            $this->form_validation->set_rules('unit_price[]','Unit Price','required|numeric');
            $this->form_validation->set_rules('net_price[]','Net Amount','required|numeric');
            $this->form_validation->set_rules('prod_name[]','Product Name','required');
            $this->form_validation->set_rules('met_id[]','Invoice Item','required');
            $this->form_validation->set_rules('tax_id','Invoice Type','required');
            
            $inv_id=$this->input->post('inv_id');
            $invNo= explode(" ",$this->input->post('inv_no'));//seprate string and no of inv no
            $inv_No=(isset($invNo[1])?$invNo[1]:$invNo[0]);// check inv no and get only numeric value
            $prefix=(isset($invNo[1])?$invNo[0]:"");
            $name=$this->SInvoice_Model->getRInvData($inv_id)->name;
            $narration='Invoice No:'.$this->input->post('inv_no').' issued to '.$name;
            $taxNarration='Tax on Sales Invoice No:'.$this->input->post('inv_no').' issued to '.$name;
            
            
            
            $this->SInvoice_Model->deleteInvMetasNotIn($inv_id,$this->input->post('meta_id[]'));
            //$data['inv_metas']=array();
            for($i=0;$i<count($this->input->post('meta_id'));$i++){
                $tmp['inv_meta_id']=$this->input->post('meta_id')[$i];
                $tmp['prod_id']=$this->input->post('product')[$i];
                $tmp['qty']=$this->input->post('qty')[$i];
                $tmp['unit_price']=$this->input->post('unit_price')[$i];
                $tmp['net_price']=$this->input->post('net_price')[$i];
                $tmp['user_id']=$this->session->userdata['logged_in']['id'];
                $tmp['inv_id']=$inv_id;
                //$data['inv_metas'][]=$tmp;
                $this->SInvoice_Model->replaceInvMetas($tmp);
            }
            
            
            $taxs=$this->Tax_Model->getGSTTaxValSum($inv_id);
            $tot=$this->SInvoice_Model->getInvoiceTotal($inv_id);
            $gtot=round($tot)+$taxs;
            
            $v_id=$this->SInvoice_Model->convertInvIdToVId($inv_id);
            $this->SInvoice_Model->updateDetails($v_id,311001,$tot,$narration);
            $this->SInvoice_Model->updateDetails($v_id,227001,($gtot-$tot),$taxNarration);
            $this->SInvoice_Model->updateSupport($v_id,$narration);
            $this->Tax_Model->updateTaxMeta($inv_id,$this->input->post('tax_id'));
            $this->SInvoice_Model->updateInvoice($inv_id,$this->input->post('inv_date'),$inv_No,$prefix,$this->input->post('narration'),$this->input->post('trans_details'));
            echo "Total :".$tot." Tax :".$taxs." Grand Total :".$gtot." of Voucher :".$v_id." Invoice No : ".$narration;
            //$this->SInvoice_Model->replaceInvMetas($this->input->post('inv_id'),$data['inv_metas']);
            //print_r($this->input->post('meta_id[]'));
            if($this->input->post('btnsave')!="Save")
                    redirect('/reports/gst_invoice/'.$inv_id,'refresh');
            else
                    redirect('/sinvoice','refresh');
            }
        }
        function textCTaxType($tot,$arr){
            $str=array();
            foreach ($arr as $row) :
            	$str[]=($tot*$row['tax_val']/100);
            endforeach;
            return $str;
	}
        function grandTot($tot,$arr){
            $tax=$this->textCTaxType($tot,$arr);
            return $tot+array_sum($tax);
	}
        function transSearch(){
            //$keyword=$this->input->post('query');
            $keyword=$_GET['term'];
            $arr=$this->SInvoice_Model->trans_search($keyword);
            $res=array();
            foreach($arr as $a1){
                $json_row['id']=$a1['inv_id'];
                $json_row['name']=$a1['trans_details'];
                array_push($res, $json_row);
                
            }
            //print_r($res);
            //$arr=array('kashyap','parsaniya','anand');
            echo json_encode($res);
        }
}