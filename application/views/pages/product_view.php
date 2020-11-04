<h4><?= $title; ?></h4>
<?php echo validation_errors('<div class="alert alert-danger" role="alert">','</div>'); ?>
<?php echo form_open('product/insert'); ?>
	<div class="form-group row">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">Product Name</label>
		<input type="text" class="form-control col-lg-6 col-sm-9" name="prod_name" value="<?php echo set_value('prod_name'); ?>">
	</div>
	<div class="form-group row">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">HSN Code</label>
		<input type="text" class="form-control col-sm-3 col-lg-2" name="prod_code" value="<?php echo set_value('prod_code'); ?>">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">Unit Price</label>
		<input type="text" class="form-control col-sm-3 col-lg-2" name="unit_prise" value="<?php echo set_value('unit_prise'); ?>">
	</div>
        <div class="form-group row">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">Product Code</label>
		<input type="text" class="form-control col-sm-3 col-lg-2" name="unit_code" value="<?php echo set_value('unit_code'); ?>">
		<label for="" class="col-sm-3 col-lg-2 col-form-label">MRP Price</label>
		<input type="text" class="form-control col-sm-3 col-lg-2" name="prod_mrp" value="<?php echo set_value('prod_mrp'); ?>">
	</div>
        <div class="form-group row">
            <label class="col-lg-2 ">Product for </label>
            <select class="form-control col-lg-2" name="supplier">
                <optgroup label="Sale">
                    <option value="0">Self Manufacture</option>
                </optgroup>
                <optgroup label="Purchase">
                    <?php foreach($con_list as $con):?>
                    <option value="<?php echo $con['con_id'];?>"><?php echo $con['name'];?></option>
                    <?php endforeach;?>
                </optgroup>        
            </select>

            <label class="col-lg-2 col-form-label">Tax Slab</label>
            <div class="input-group col-lg-2">
                <input type="text" class="form-control" name="taxSlab" value="<?php echo set_value('taxSlab'); ?>">        
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
<table class="table table-hover table-sm">
	<thead>
		<tr>
			<th>Product Name</th>
                        <th>Product Code</th>
			<th>HSN Code</th>
                        <th>MRP</th>
			<th>Price</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($posts as $post) : ?>
			<tr>
				<td><?php echo stripcslashes($post['prod_name']); ?></td>
                                <td><?php echo $post['unit_code']; ?></td>
				<td><?php echo $post['prod_code']; ?></td>
                                <td><?php echo $post['prod_mrp']; ?></td>
				<td><?php echo $post['unit_price']; ?></td>
				<td><a href="<?php echo base_url(); ?>product/edit/<?php echo $post['prod_id'];?>">Edit</a> | <a href="#">Delete</a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>