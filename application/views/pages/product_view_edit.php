<?php
    if($product==null){
        echo 'Sorry ! You made some mistake.';
        exit;
    }
    $product->prod_name= stripcslashes($product->prod_name);
?>
<a href="<?php echo base_url(); ?>product"> <i class="fa fa-angle-left"></i> Go Back</a><br /><br />
<h4><?= $title;?></h4>
<?php echo validation_errors('<div class="alert alert-danger" role="alert">','</div>'); ?>
<?php echo form_open('product/update'); ?>
<input type="hidden" name="prod_id" value="<?php echo set_value('prod_id',$product->prod_id); ?>" >
	<div class="form-group row">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">Product Name</label>
                <input type="text" class="form-control col-lg-6 col-sm-9" name="prod_name" value="<?php echo set_value('prod_name', $product->prod_name); ?>">
	</div>
	<div class="form-group row">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">HSN Code</label>
		<input type="text" class="form-control col-sm-3 col-lg-2" name="prod_code" value="<?php echo set_value('prod_code',$product->prod_code); ?>">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">Unit Price</label>
		<input type="text" class="form-control col-sm-3 col-lg-2" name="unit_prise" value="<?php echo set_value('unit_prise',$product->unit_price); ?>">
	</div>
        <div class="form-group row">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">Product Code</label>
		<input type="text" class="form-control col-sm-3 col-lg-2" name="unit_code" value="<?php echo set_value('unit_code',$product->unit_code); ?>">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">MRP Price</label>
		<input type="text" class="form-control col-sm-3 col-lg-2" name="prod_mrp" value="<?php echo set_value('prod_mrp',$product->prod_mrp); ?>">
	</div>
        <div class="form-group row">
            <label class="col-lg-2 ">Product for </label>
            <select class="form-control col-lg-2" name="supplier">
                <optgroup label="Sale">
                    <option value="0">Self Manufacture</option>
                </optgroup>
                <optgroup label="Purchase">
                    <?php foreach($con_list as $con):?>
                    <option value="<?php echo $con['con_id'];?>" selected><?php echo $con['name'];?></option>
                    <?php endforeach;?>
                </optgroup>        
            </select>

            <label class="col-lg-2 col-form-label">Tax Slab</label>
            <div class="input-group col-lg-2">
                <input type="text" class="form-control" name="taxSlab" value="<?php echo set_value('taxSlab',$product->igst); ?>">        
                <div class="input-group-addon">%</div>
            </div>

        </div>
        <div class="form-group row">

        </div>
        <div class="form-group row">
                <div class="offset-sm-2">
                        <input type="submit" class="btn btn-primary" value="Save">
                </div>
        </div>
</form>
