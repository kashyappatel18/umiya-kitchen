jQuery(document).ready(function(e){
	//alert(base_url+'sinvoice/getRow');
        jQuery("#trans_details").autocomplete({
            //source:base_url+'sinvoice/transSearch',
            source:function(request,response){
                jQuery.ajax({
                    url:base_url+'sinvoice/transSearch',
                    data:{term:request.term},
                    dataType:"json",
                    success:function(data){
                        response(jQuery.map(data,function(item){
                            return{id:item.id,value:item.name};
                        }))
                    }
                });
            },
            minLength:0,
            select:function(event,ui){
                //jQuery("#narration").val(ui.item.id);
            }
        });
        
        
        
        
        init();
	calc();
	jQuery("#addRow").click(function(){
		jQuery.ajax({
			url:base_url+'pinvoice/getRow',
			type:'POST',
			success:function(data){
				jQuery("#invMeta").append(data);
                                init();
				calc();
			}
		});
	});
	
	
});
function init(){
    jQuery('.product').change(function(){
            var objpd=this;
            var prod_id=jQuery(this).parent().parent().find('.prod_val').val();//this.value;
            var cust_id=jQuery("#con_id").val();
            if(prod_id!=""){
            jQuery.ajax({
                url:base_url+'product/getRate',
                type:'POST',
                data:'prod_id='+prod_id+"&cust_id="+cust_id+"&inv_type=1",
                success:function(data){
                    jQuery(objpd).parent().parent().find('.unit_price').val(data);
                    jQuery('.unit_price').change();
                    //alert(cust_id);
                }
            });}
        
        });
    jQuery(".prod_name").autocomplete({
            source:function(request,response){
                jQuery.ajax({
                   url:base_url+'product/prod_search',
                   data:{term:request.term},
                   dataType:"json",
                   success:function(data){
                       response(jQuery.map(data,function(item){
                           return{id:item.id,value:item.name};
                       }))
                   }
                });
            },
            minLength:0,
            select:function(event,ui){
                jQuery(this).parent().parent().find('.prod_val').val(ui.item.id);
                jQuery('.unit_price').change(); 
            },
            change:function(event,ui){
                if(!ui.item){
                    jQuery(this).parent().parent().find('.prod_val').val("");
                }
            }
        });    
}
function calc(){
	jQuery('.qty,.unit_price').change(function(){
		event.preventDefault();
		var net_price=jQuery(this).parent().parent().find('.qty').val()*jQuery(this).parent().parent().find('.unit_price').val();
        jQuery(this).parent().parent().find('.net_price').val(net_price);
        //alert(jQuery(this).parent().parent().find('.qty').val());
	});
	jQuery('.remove').click(function(){
		event.preventDefault();
		jQuery(this).closest('tr').remove();
	});
       
}
function lastrow(){
	jQuery("#invMeta tr:last").click(function(){
		alert("last row click");
	});
}