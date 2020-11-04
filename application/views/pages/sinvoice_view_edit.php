<h4><?= $title; ?></h4>

<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<?php echo form_open('sinvoice/update'); ?>
	<div class="row">
		<div class="form-group col-lg-4">
			<label>Customer Name</label>
                        <h5><?= $invData->name;?></h5>
		</div>
		<div class="form-group col-lg-2">
			<label>Date</label>
                        <input class="form-control" type="date" name="inv_date" value="<?php echo set_value('inv_date',$invData->inv_date);?>" />
		</div>
		<div class="form-group col-lg-2">
			<label>Invoice No</label>
                        <input type="text" class="form-control" name="inv_no" value="<?php echo set_value('inv_no',$invNo);?>" />
                        <input type="hidden" name="inv_id" value="<?= $inv_id;?>"/>
		</div>
            <div class="form-group col-lg-2">
			<label>Invoice Type</label>
                        <select class="form-control" name="tax_id" id="tax_id">
				<?php foreach($invoiceTypes as $invoiceType):?>
                                    <?php if($invoiceType['tax_name']==$inv_tax_type){ ?>
                                        <option value="<?php echo $invoiceType['tax_id']; ?>" selected="selected"><?php echo $invoiceType['tax_name']; ?></option>
                                    <?php }else{ ?>
                                    <option value="<?php echo $invoiceType['tax_id']; ?>"><?php echo $invoiceType['tax_name']; ?></option>
                                    <?php } ?>
				<?php endforeach;?>
			</select>
		</div>
		<div class="col-2"></div>
		<div class="form-group col-lg-2">
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered table-sm" id="invMeta">
				<thead>
					<tr>
						<th>Product</th>
						<th>Quantity</th>
						<th>Rate</th>
						<th>Net Amount</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
                                    <?php
                                    foreach ($inv_metas as $inv_meta) {
                                        $dataR['inv_meta_id']=$inv_meta['inv_meta_id'];
                                        $dataR['prod_id']=$inv_meta['prod_id'];
                                        $dataR['prod_name']= $inv_meta['prod_name'];
                                        $dataR['qty']=$inv_meta['qty'];
                                        $dataR['unit_price']=$inv_meta['unit_price'];
                                        $dataR['net_price']=$inv_meta['net_price'];
                                        $this->load->view('customControls/sinvoice_Row',$dataR);
                                    }
                                    ?>
					
					<?php 
						/*while($prod_id=set_value('product[]')):
							$dataR['prod_id']=$prod_id;
							$dataR['qty']=set_value('qty[]');
							$dataR['unit_price']=set_value('unit_price[]');
							$dataR['net_price']=set_value('net_price[]');
							$this->load->view('customControls/sinvoice_Row',$dataR);
					 	endwhile; */
					 ?>
				</tbody>
			</table>
			<input type="button" class="btn btn-link" value="+ Add Row" id="addRow">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 form-group">
			<label>Narration</label>
			<textarea class="form-control" name="narration"><?php echo set_value('narration',$invData->narration);?></textarea>
		</div>
		<div class="col-lg-4 form-group">
			<label>Transport Details</label>
                        <input type="text" id="trans_details" class="form-control" autocomplete="off" name="trans_details" value="<?php echo set_value('trans_details',$invData->trans_details);?>"/>
		</div>
		<div class="col-lg-4"></div>
	</div>
	<div class="row">
		<div class="col-lg-6 form-group">
			
			<div class="btn-group dropup">
			  <input type="submit" class="btn btn-primary" name="btnsave" value="Save">
			  <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <span class="sr-only">Toggle Dropdown</span>
			  </button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
			    <input type="submit" class="dropdown-item" value="Save & Print" name="btnsave">
			  </div>
			</div>
			<input type="reset" class="btn btn-default" value="Cancel">                        
		</div>
            <div class="col-lg-4 form-group">
                <input type="password" class="form-control" name="delPass"/>
            </div>
            <div class="col-lg-2 form-group">
                <input type="submit" class="btn btn-danger" value="Delete" name="btnsave"/>
            </div>
	</div>
<?php echo form_close(); ?>