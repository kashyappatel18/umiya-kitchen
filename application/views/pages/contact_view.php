<h4><?= $title ?></h4>
<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<div class="row">
	<div class="col-lg-4">
		<div class="container">
			<?php echo form_open('contact/insert'); ?>
                                <div class="form-group row">
					<label>Contact Type</label>
                                        <select class="form-control" name="conType">
                                            <?php foreach ($cTypes as $cType): ?>
                                            <option value="<?php echo $cType['con_typ_id']; ?>"><?php echo $cType['con_type']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
				</div>
				<div class="form-group row">
					<label>Name</label>
                                        <input class="form-control" type="text" id="cust_name" name="cust_name" value="<?php echo set_value('cust_name'); ?>" autocomplete="off">
				</div>
				<div class="form-group row">
					<label>Contact</label>
					<input class="form-control" type="text" name="cust_contact" value="<?php echo set_value('cust_contact'); ?>">
				</div>
                                <div class="form-group row">
					<label>GST No</label>
					<input class="form-control" type="text" name="cust_gst" value="<?php echo set_value('cust_gst'); ?>">
				</div>
				<div class="form-group row">
					<label>Address</label>
					<textarea class="form-control" name="cust_add"><?php echo set_value('cust_add'); ?></textarea>
				</div>
                                <div class="form-group row">
					<label>City</label>
					<input class="form-control" type="text" name="cust_city" value="<?php echo set_value('cust_city'); ?>">
				</div>
				<div class="form-group row">
					<label>Details</label>
					<textarea class="form-control" name="cust_details"><?php echo set_value('cust_details'); ?></textarea>
				</div>
				<div class="form-group row">
					<input class="btn btn-primary" value="Save" type="submit">
				</div>
			</form>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="container">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Customers</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Suppliers</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">All</a></li>
                    </ul>

                    <div class="tab-content">
                      <div id="home" class="tab-pane active">
                        <table class="table table-hover">
                                <thead>
                                        <tr>
                                                <th>Details</th>
                                                <th>Action</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <?php foreach($posts as $post):?>
                                        <?php if($post['con_typ_id']!=1) continue;?>
                                                <tr>
                                                        <td><?php echo $post['name']; ?> --- <span class="text-muted"> <?php echo $post['contact_no']; ?></span><br><small class="text-muted"><?php echo nl2br($post['address']); ?></small></td>
                                                        <td><div class="hide"><a href="<?php echo base_url(); ?>contact/edit/<?php echo $post['con_id'];?>">Edit</a> | <a href="<?php echo base_url(); ?>contact/envelop_print/<?php echo $post['con_id'];?>">Print</a> | <a href="#">Delete</a></div></td>
                                                </tr>
                                        <?php endforeach; ?>
                                </tbody>
                        </table>    
                      </div>
                      <div id="menu1" class="tab-pane fade">
                        <table class="table table-hover">
                                <thead>
                                        <tr>
                                                <th>Details</th>
                                                <th>Action</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <?php foreach($posts as $post):?>
                                        <?php if($post['con_typ_id']!=2) continue;?>
                                                <tr>
                                                        <td><?php echo $post['name']; ?> --- <span class="text-muted"> <?php echo $post['contact_no']; ?></span><br><small class="text-muted"><?php echo nl2br($post['address']); ?></small></td>
                                                        <td><div class="hide"><a href="<?php echo base_url(); ?>contact/edit/<?php echo $post['con_id'];?>">Edit</a> | <a href="#">Delete</a></div></td>
                                                </tr>
                                        <?php endforeach; ?>
                                </tbody>
                        </table> 
                      </div>
                      <div id="menu2" class="tab-pane fade">
                        <table class="table table-hover">
                                <thead>
                                        <tr>
                                                <th>Details</th>
                                                <th>Action</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <?php foreach($posts as $post):?>
                                                <tr>
                                                        <td><?php echo $post['name']; ?> --- <span class="text-muted"> <?php echo $post['contact_no']; ?></span><br><small class="text-muted"><?php echo nl2br($post['address']); ?></small></td>
                                                        <td><div class="hide"><a href="<?php echo base_url(); ?>contact/edit/<?php echo $post['con_id'];?>">Edit</a> | <a href="#">Delete</a></div></td>
                                                </tr>
                                        <?php endforeach; ?>
                                </tbody>
                        </table>
                      </div>
                    </div>

		</div>
	</div>
</div>