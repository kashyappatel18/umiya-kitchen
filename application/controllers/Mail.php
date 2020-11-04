<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mail
 *
 * @author Kashyap
 */
class Mail {
    function index(){
        $mbox=imap_open("{sg2plcpnl0142.prod.sin2.secureserver.net:993/imap/ssl}","info@cloud8in.com","Dg41rq@2010");
	$folders=imap_list($mbox,"{sg2plcpnl0142.prod.sin2.secureserver.net:993/imap/ssl}","*");	
	foreach ($folders as $value) {
            echo imap_num_msg($mbox);
		echo str_replace("{sg2plcpnl0142.prod.sin2.secureserver.net:993/imap/ssl}", "", $value).'<br />';
	}
    }
}
