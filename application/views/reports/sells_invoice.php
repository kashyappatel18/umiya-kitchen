
<page size="A4">
	<table border="1" style="width:100%;border:1px solid black;height:100%;">
					<tr style="border-bottom:1px doted black;">
						<td colspan="5" align="center">
							<h1><?= $display_name; ?></h1>	
						</td>
					</tr>
					<tr><td colspan="5" align="center"><p><?= $address; ?></p></td></tr>
					<tr>
						<td colspan="5">
						<table style="width:100%">
							<tr>
								<td style="width:33.33%">Debit Memo</td><td align="center" style="width:33.33%"><?= $inv_tax_type ?></td><td align="right" style="width:33.33%"><?= $copy; ?></td>
							</tr>
						</table>
					</td>
					</tr>
                                        <tr><td rowspan="3" colspan="3"><h4>M/S : <?= $invData->name ?></h4><?= $invData->address ?> <small><br>Mobile : <?= $invData->contact_no ?><br><br><?= $invData->details ?></small></td><td colspan="2">Invoice # <?= $invNo ?></td></tr>
					<tr><td colspan="2">Invoice Date # <?= nice_date($invData->inv_date,'F d, Y') ?></td></tr>
					<tr><td colspan="2" style="height:70px;"><?= $invData->trans_details ?></td></tr>

				
					<tr>
						<th align="center" style="width:5%">Sr No</th>
						<th align="center" style="width:40%">Description</th>
						<th align="right" style="width:10%">Quantity</th>
						<th align="right" style="width:15%">Unit Price</th>
						<th align="right" style="width:20%">Net Price</th>
					</tr>

					<?php
						$i=0;$count=0; // counter for number of rows and Sr No.
						foreach ($inv_metas as $inv_meta) ://this foreach loop display invoice meta
							$i++;
                                                        $count++;
					?>
						<tr class="details"><td class="details" align="center"><?= $i ?></td><td class="details"><?= stripcslashes($inv_meta['prod_name']) ?></td><td class="details" align="center"><?= $inv_meta['qty'] ?></td><td class="details" align="right"><?= number_format($inv_meta['unit_price'],2) ?></td><td class="details" align="right"><?= number_format($inv_meta['net_price'],2) ?></td></tr>
					<?php
                                            if(strlen(stripcslashes($inv_meta['prod_name']))>37){
                                                $count++;
                                            }
						endforeach;// end of foreach loop
						while ($count<17) : // this while loop displyas blank rows
							$count++;						
					?>
					<tr class="details"><td class="details"><?= $count; ?></td><td class="details">&nbsp;</td><td class="details">&nbsp;</td><td class="details">&nbsp;</td><td class="details">&nbsp;</td></tr>					
					<?php
						endwhile; // end of while loop that display blank rows
					?>
					
					<tr style="height:1px;"><td colspan="5"></td></tr>
                                        <tr><td rowspan="2" colspan="3">Rs (in words): <?= ucfirst($amtinword) ?> only.</td><td>Sub Total</td><td align="right"><?= number_format($invTot,2) ?></td></tr>
                                        <tr><td rowspan="3"><small><?= $taxType ?><br>Rounding Off<small></td><td rowspan="3" align="right"> <small><?= $taxVal ?><br><?= $roundOff ?></small></td></tr>
					<tr><td colspan="3"><small>TIN No : 24092503896 DT: 24-11-2016 <br>CST NO : 24592503896 DT: 24-11-2016</small></td></tr>
                                        <tr><td colspan="3"><small>HDFC Bank.<br>IFSC Code : HDFC0002149 &nbsp;&nbsp;&nbsp; A/C No: 50200005093111</small></td></tr>
					
					<tr>
						<td colspan="3"><small>Note: <?= $invData->narration ?></small></td>
						
						<td > Grand Total  </td>
						<td align="right"><b><?= $gtot ?></b></td>
					</tr>
				<!--	<tr>
						<td colspan="5">(Rupees  only.)</td>
					</tr>-->
					<tr>
						<td colspan="5">
							<table style="width:100%;">
								<tr>
                                                                    <td colspan="3" valign="top"><i>*Terms & Conditions:<br><small>1. Goods Once Sold Will Not Be Accepted.<br>2. Subject To Rajkot Jurisdiction Only.  E. & O.E.</small></i></td>
									<td colspan="2" align="right">For <?= $display_name; ?><br><br><br><br><br><p class="light">[ Authorised Signature ]</p></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
</page>
<br><br><br><br>