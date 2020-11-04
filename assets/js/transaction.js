/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
    init();
    chng();
    
    jQuery("#addRow").click(function(){
        var dVal=jQuery('#vType').val();
        //alert(dVal);
        jQuery.ajax({
            url:base_url+'transaction/getRow',
            type:'POST',
            data:'dType='+dVal,
            success:function(data){
		jQuery("#vMeta").append(data);
                chng();
            }
	});
    });
   
});
function init(){
     var dVal=jQuery('#vType').val();
        //alert(dVal);
        jQuery.ajax({
            url:base_url+'transaction/getRow',
            type:'POST',
            data:'dType='+dVal,
            success:function(data){
		jQuery("#vMeta").append(data);
                chng();
            }
	});
}
function chng(){
    jQuery("#vType").change(function(){
        
        if(this.value==0){
            jQuery('.vType').html('Cr');
            jQuery('.dType').html('Dr');
        }
        else {
            jQuery('.vType').html('Dr');
            jQuery('.dType').html('Cr');
        }

    });  
    jQuery('.acno').change(function(){
        var acNo=this.value;
        var abc=jQuery(this).parent().find('.acBal');
        jQuery.ajax({
            url:base_url+'transaction/getBal',
            type:'POST',
            data:'acNo='+acNo,
            success:function(data){
               //alert(abc);
               abc.html(data);
            }
        });
    });
    jQuery('.remove').click(function(){
	event.preventDefault();
	jQuery(this).closest('tr').remove();
    });
}

