<tr>
    
	<td >
            <?php //if(isset($inv_meta_id)){?>
            <input type="hidden" name="meta_id[]" class="meta_id" value="<?php if(isset($inv_meta_id))echo $inv_meta_id; ?>"/>
            <?php //}?>
            <input type="hidden" name="product[]" class="prod_val" value="<?php if(isset($prod_id))echo $prod_id; ?>"/>
            <input type="text" name="prod_name[]" class="form-control prod_name product no-border" autocomplete="off" value="<?php if(isset($prod_name))echo $prod_name;?>">
	</td>
        <td ><input class="form-control qty no-border" name="qty[]" value="<?php if(isset($qty))echo $qty; ?>"></td>
        <td align="right"><i class="text-primary qtydisp" id="qtydisp"></i></td>
	<td><input class="form-control unit_price no-border" name="unit_price[]" value="<?php if(isset($unit_price))echo $unit_price; ?>"></td>
	<td><input class="form-control net_price no-border" name="net_price[]" value="<?php if(isset($net_price))echo $net_price; ?>"></td>
        <td></td>
        <td></td>
	<td align="center" style="vertical-align:middle"><p class="text-secondary remove"><i class="fa fa-trash-o"></i></p></td>
</tr> 