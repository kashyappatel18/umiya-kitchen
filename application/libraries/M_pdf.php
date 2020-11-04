<?php if(!defined('BASEPATH'))exit ("No direct script access allowd.");
class m_pdf{
    function __construct(){ 
        $CI=&get_instance();
    }
    function load($param=null){
        include_once APPPATH.'third_party/mpdf/mpdf.php';
        if($param==NULL){
            $param='"en-GB-x","A4","","",10,10,10,10,6,3';
        }
        return new mPDF();
    }
    function _setPageSize($format, $orientation,$mpdf){
        $mpdf->_setPageSize($format, $orientation);
    }
    function SetMargins($left,$right,$top,$mpdf){
        $mpdf->SetMargins($left,$right,$top);
    }
    function SetFont($mpdf,$family,$style='',$size=0, $write=true, $forcewrite=false){
        $mpdf->SetFont($family,$style='',$size=0, $write=true, $forcewrite=false);
    }
}
