<h4><?= $title; ?></h4>
<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<?php echo form_open('transaction/insert'); ?>
	<div class="row">
            <div class="form-group col-lg-3">
		<label>Date</label>
                <input type="date" name="vDate" class="form-control" value="<?php echo set_value('vDate');?>" />
            </div>
            <div class="form-group col-lg-2">
		<label>Voucher No</label>
                <input class="form-control" name="vNo" value="<?php echo set_value('vNo',$nextVNo);?>">
            </div>
            <div class="form-group col-lg-2">
                <label>Voucher Type</label>
                <?php 
                    $vType=set_value('vType');
                    $tSelected=NULL;
                    if($vType==1)
                        $tSelected='selected';
                ?>
                <select name="vType" class="form-control" id="vType">
                    <option value="0">Credit</option>
                    <option value="1" <?php echo $tSelected;?>>Debit</option>
                </select>
            </div>
		
	</div>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered table-sm" id="vMeta">
				<thead>
					<tr>
						<th>Cr/Dr</th>
						<th>Account</th>
						<th>Amount</th>
						<th>Naration</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
                                    <tr style="background-color: #ddd;">
						<td >
                                                    <b class="form-text text-muted text-center vType">Cr</b>
                                                    <small class="form-text text-center">Voucher</small>
						</td>
						<td>
                                                    <select class="form-control acno" name="vAcNo" area-desctibedby="acBal">
                                                        <?php foreach($ACs as $ac): ?>
                                                        <?php 
                                                            $vSelected=NULL;
                                                            $vAcNo= set_value('vAcNo');
                                                            if($ac['ac_code']==$vAcNo)
                                                                $vSelected='selected';
                                                        ?>
                                                        <option value="<?php echo $ac['ac_code'];?>" <?php echo $vSelected;?>><?php echo $ac['ac_name'];?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <i class="form-text text-right text-primary acBal" id="acBal">0 Dr</i>
                                                </td>
                                                <td><input class="form-control unit_price" name="vAmount" value="<?php echo set_value('vAmount');?>"></td>
                                                <td><input class="form-control net_price" name="vNaration" value="<?php echo set_value('vNaration');?>"></td>
						<td></td>
					</tr>
                                      
					<?php 
						while($acNo=set_value('dAcNo[]')):
							$dataR['acNo']=$acNo;
							$dataR['dAmount']=set_value('dAmount[]');
							$dataR['dNaration']=set_value('dNaration[]');
                                                        $dataR['dType']=$vType;
                                                       /* echo '<pre>';
                                                        print_r($dataR);
                                                        echo '</pre>';*/
							$this->load->view('customControls/transaction_row',$dataR);
					 	endwhile; 
					 ?>
				</tbody>
			</table>
			<input type="button" class="btn btn-link" value="+ Add Row" id="addRow">
		</div>
	</div>
	<div class="row">
            <div class="col-6"></div>
            <div class="col-2 form-group">
                <h6 class="form-control-static text-danger">Total</h6>
            </div>
		<div class="col-2 form-group">
                        <h6 class="form-control-static text-danger">50000 Dr</h6>
		</div>
		<div class="col-2 form-group">
			<h6 class="form-control-static text-danger">50000 Cr</h6>
		</div>
		
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
</form>