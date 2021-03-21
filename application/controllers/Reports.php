<?php
	class Reports extends CI_Controller	{
		function __construct(){
			parent::__construct();
			$this->load->helper(array('date'));
			$this->load->model(array('Contact_Model','Product_Model','Tax_Model','SInvoice_Model','User'));
                        $this->load->library('m_pdf');
                        $this->User->check_database('umiya','admin@123');
		}
		public function view($invId=NULL){
			if($this->session->userdata('logged_in')){
				if(is_null($invId) or $this->SInvoice_Model->getRInvNo($invId)==""){
					show_404();
					
				}
				$taxs=$this->Tax_Model->getFTaxType($invId);
				

				//$data['title']=ucfirst($page); $invId
                                $data['address']=$this->session->userdata['logged_in']['address'];
				$data['invNo']=$this->SInvoice_Model->getRInvNo($invId);
				$data['invData']=$this->SInvoice_Model->getRInvData($invId);
				$data['inv_tax_type']=$this->Tax_Model->getRInvoiceType($invId);
				$data['inv_metas']=$this->SInvoice_Model->getRInvMeta($invId);
				$data['display_name']=$this->User->getDisplayName();
				$data['invTot']=$this->SInvoice_Model->getInvoiceTotal($invId);
				$data['taxType']=$this->textFTaxType($taxs);
				$data['taxVal']=$this->fTaxType($data['invTot'],$taxs);
				$gtot=$this->grandTot($data['invTot'],$taxs);
				$data['gtot']=number_format(round($gtot,0),2);
				$data['roundOff']=number_format($this->roundOff($data['gtot'],$gtot),2);
				$data['amtinword']=$this->Reports_model->amtToWord(round($gtot,0));
				//print_r($data);





				$this->load->view('templates/report_header');
				$data['copy']='Original';
				$this->load->view('reports/sells_invoice',$data);
				$data['copy']='Duplicate';
				$this->load->view('reports/sells_invoice',$data);
				$data['copy']='Triplicate';
				$this->load->view('reports/sells_invoice',$data);
				$data['copy']='Transport';
				$this->load->view('reports/sells_invoice',$data);
			}
			else{
				redirect('/login','refresh');
			}
		}
                public function gst_view($invId=NULL){
			if($this->session->userdata('logged_in')){
				if(is_null($invId) or $this->SInvoice_Model->getRInvNo($invId)==""){
					show_404();
					
				}
				$taxs=$this->Tax_Model->getFTaxType($invId);
				

				//$data['title']=ucfirst($page); $invId
                                $data['address']=$this->session->userdata['logged_in']['address'];
                                $data['memoType']=$this->User->getDefaultMemoType($this->session->userdata['logged_in']['id']);
                                $data['gst_no']= $this->User->getUserMetaValue('gst_no');
                                $data['pan_no']= $this->User->getUserMetaValue('pan_no');
                                $data['bank_name']= $this->User->getUserMetaValue('bank_name');
                                $data['bank_ifsc']= $this->User->getUserMetaValue('bank_ifsc');
                                $data['bank_acno']= $this->User->getUserMetaValue('bank_acno');
                                $data['terms_conditions']= $this->User->getUserMetaValue('terms_conditions');
				$data['invNo']=$this->SInvoice_Model->getRInvNo($invId);
				$data['invData']=$this->SInvoice_Model->getRInvData($invId);
				$data['inv_tax_type']=$this->Tax_Model->getRInvoiceType($invId);
				$data['inv_metas']=$this->SInvoice_Model->getRInvMeta($invId);
				$data['display_name']=$this->User->getDisplayName();
				$data['invTot']=$this->SInvoice_Model->getInvoiceTotal($invId);
				$data['taxType']=$this->textFTaxType($taxs);
				$data['taxVal']=$this->getGSTTaxValF($invId);
				$gtot=($data['invTot']+$this->Tax_Model->getGSTTaxValSum($invId));
				$data['gtot']=number_format(round($gtot,0),2);
				$data['roundOff']=number_format($this->roundOff($data['gtot'],$gtot),2);
				$data['amtinword']=$this->Reports_model->amtToWord(round($gtot,0));
                                
				//print_r($data);



                                $html=$this->load->view('templates/pdf_header',NULL,true);
                                $data['inv_type']="Original";
                                $html1= $this->load->view('reports/gst_inv_header',$data,true);
                                $html.=$this->load->view('reports/gst_invoice',$data,true);     
                                $data['inv_type']="Duplicate";
                                $html.=$this->load->view('reports/gst_invoice',$data,true);
                                $data['inv_type']="Triplicate";
                                $html.=$this->load->view('reports/gst_invoice',$data,true);
                                $data['inv_type']="Transport";
                                $html.=$this->load->view('reports/gst_invoice',$data,true);
                                

            $filename='INV-'.$data['invNo'].'.pdf';

            $pdf=$this->m_pdf->load();
            $pdf->SetHTMLFooter($html1);
            $pdf->WriteHTML($html,0);
            $pdf->Output($filename,'I');

				/*$this->load->view('templates/report_header');
				$data['copy']='Original';
				$this->load->view('reports/gst_invoice',$data);
				$data['copy']='Duplicate';
				$this->load->view('reports/gst_invoice',$data);
				$data['copy']='Triplicate';
				$this->load->view('reports/gst_invoice',$data);
				$data['copy']='Transport';
				$this->load->view('reports/gst_invoice',$data);*/
			}
			else{
				redirect('/login','refresh');
			}
		}
                function acStateView($acNo=NULL){
                    if($this->session->userdata('logged_in')){
                        if(is_null($acNo)){
                            show_404();
                        }
                        $this->load->view('templates/report_header');
                        $this->load->view('reports/ac_statement');
                    }
                }
                
                
                
                
                function textFTaxType($arr){
			$str="";
			foreach($arr as $row):
				$str.=$row['tax_type']."  <br>";
			endforeach;
			return $str;
		}
		function textCTaxType($tot,$arr){
			$str=array();
			foreach ($arr as $row) :
				$str[]=($tot*$row['tax_val']/100);
			endforeach;
			return $str;
		}
		function fTaxType($tot,$arr){
			$tax=$this->textCTaxType($tot,$arr);
			$str="";
			foreach ($tax as $key => $value) {
				$str.=$value."<br>";
			}
			return $str;
		}
		function grandTot($tot,$arr){
			$tax=$this->textCTaxType($tot,$arr);
			return $tot+array_sum($tax);
		}
		function roundOff($rgtot,$gtot){
			return round($gtot,0)-$gtot;
		}
                function getGSTTaxValF($invId){
                    $arr=$this->Tax_Model->getGSTTaxVal($invId);
                    $arr2=$this->Tax_Model->getGSTTaxType($invId);
                    $res="";
                    foreach($arr2 as $sarr){
                        $res.=round($arr->$sarr['tax_type'],2).'<br>'; //$arr->$sarr['tax_type']
                    }
                    return $res;
                }
	}