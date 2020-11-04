<?php
    if($contact==null){
        echo 'Sorry ! You made some mistake.';
        exit;
    }
?>
<a href="<?php echo base_url(); ?>contact"> <i class="fa fa-angle-left"></i> Go Back</a><br /><br />
<h4><?= $title ?></h4>
<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<div class="row">
	<div class="col-lg-4">
		<div class="container">
			<?php echo form_open('contact/update'); ?>
                        <input type="hidden" name="con_id" value="<?php echo set_value('con_id',$contact->con_id); ?>" >
                                <div class="form-group row">
					<label>Name</label>
					<input class="form-control" type="text" name="cust_name" value="<?php echo set_value('cust_name',$contact->name); ?>">
				</div>
				<div class="form-group row">
					<label>Contact</label>
					<input class="form-control" type="text" name="cust_contact" value="<?php echo set_value('cust_contact',$contact->contact_no); ?>">
				</div>
                                <div class="form-group row">
					<label>GST No</label>
					<input class="form-control" type="text" name="cust_gst" value="<?php echo set_value('cust_gst',$contact->gst_no); ?>">
				</div>
				<div class="form-group row">
					<label>Address</label>
					<textarea class="form-control" name="cust_add"><?php echo set_value('cust_add',$contact->address); ?></textarea>
				</div>
                                <div class="form-group row">
					<label>City</label>
					<input class="form-control" type="text" name="cust_city" value="<?php echo set_value('cust_city',$contact->city); ?>">
				</div>
				<div class="form-group row">
					<label>Details</label>
					<textarea class="form-control" name="cust_details"><?php echo set_value('cust_details',$contact->details); ?></textarea>
				</div>
				<div class="form-group row">
					<input class="btn btn-primary" value="Update" type="submit">
                                        <a href="<?php echo base_url(); ?>contact" class="btn btn-default">Cancel</a>
				</div>
			</form>
		</div>
	</div>
	
</div>