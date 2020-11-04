<h4><?= $title; ?></h4>
<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<?php echo form_open('sinvoice/insert'); ?>
	<div class="row">
		<div class="form-group col-lg-4">
			<label>Customer Name</label>
			<select class="form-control" name="con_id" id="con_id">
				<option></option>
				<?php foreach ($contacts as $contact): ?>
				<?php 
					$select="";
					if($contact['name']==set_value('con_id')){
						$select="selected";
					}
				?>
					<option value="<?php echo $contact['con_id']; ?>" <?php echo $select; ?> ><?php echo $contact['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group col-lg-2">
			<label>Date</label>
                        <input class="form-control" type="date" name="inv_date" value="<?php echo set_value('inv_date');?>" />
		</div>
		<div class="form-group col-lg-2">
			<label>Invoice No</label>
			<input class="form-control" id="inv_no" name="inv_no" value="<?php echo set_value('inv_no', $nextInvNo); ?>">
		</div>
		<div class="col-2"></div>
		<div class="form-group col-lg-2">
			<label>Invoice Type</label>
			<select class="form-control" name="tax_id" id="tax_id">
				<?php foreach($invoiceTypes as $invoiceType):?>
					<option value="<?php echo $invoiceType['tax_id']; ?>"><?php echo $invoiceType['tax_name']; ?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered table-sm" id="invMeta">
				<thead>
					<tr>
						<th align="center">Product</th>
                                                <th colspan="2">Quantity</th>
						<th>Rate</th>
						<th>Net Amount</th>
                                                <th>GST % </th>
                                                <th>Total Amount</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
                                            	<td >
                                                    <?php
                                                        $prod_id=set_value('product[]');
                                                        $prod_name=set_value('prod_name[]');
                                                        $qty=set_value('qty[]');
                                                        $unit_price=set_value('unit_price[]');
                                                        $net_price=set_value('net_price[]');
                                                    ?>
                                                    <input type="hidden" name="product[]" class="prod_val" value="<?php echo $prod_id; ?>"/>
                                                    <input type="text" name="prod_name[]" class="form-control prod_name product no-border" autocomplete="off" value="<?php echo $prod_name;?>">
							<!-- <select class="form-control product" name="product[]">
								
								
							</select> -->
						</td>
						<td><input class="form-control qty no-border" name="qty[]" value="<?php echo $qty; ?>" type="text"></td>
                                                <td align="right"><i class="text-primary qtydisp" id="qtydisp"></i></td>
						<td><input class="form-control unit_price no-border" name="unit_price[]" value="<?php echo $unit_price; ?>"></td>
						<td><input class="form-control net_price no-border" name="net_price[]" value="<?php echo $net_price; ?>"></td>
						<td align="center">18</td>
                                                <td></td>
                                                <td></td>
					</tr>
					<?php 
						while($prod_id=set_value('product[]')):
							$dataR['prod_id']=$prod_id;
                                                        $dataR['prod_name']= set_value('prod_name[]');
							$dataR['qty']=set_value('qty[]');
							$dataR['unit_price']=set_value('unit_price[]');
							$dataR['net_price']=set_value('net_price[]');
							$this->load->view('customControls/sinvoice_Row',$dataR);
					 	endwhile; 
					 ?>
				</tbody>
			</table>
			<input type="button" class="btn btn-link" value="+ Add Row" id="addRow">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 form-group">
			<label>Narration</label>
			<textarea class="form-control" name="narration" id="narration"></textarea>
		</div>
		<div class="col-lg-4 form-group dropdown show">
			<label>Transport Details</label>
                        <input type="text" id="trans_details" class="form-control" autocomplete="off" name="trans_details"/>
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
	</div>
<?php echo form_close(); ?>