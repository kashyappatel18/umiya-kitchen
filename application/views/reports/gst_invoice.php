<?php 
$total_rec= count($inv_metas);
$table_row_count=0;
$skip_rec=0;
$a=1;

while($table_row_count<$total_rec):
    
?>
<div class="container">
    <table>
        <tr>
            <td width="30%"><?= $memoType; ?> Memo</td>
            <td width="40%" align="center">Tax Invoice</td>
            <td width="30%" align="right"><?= $inv_type ?></td>
        </tr>
    </table>
    <table border="1">
        <tr>
            <td align="center"><h1><?= $display_name; ?></h1><p><?= $address; ?><br></p></td>
        </tr>
    </table>
    <table border="1">
        <tr>
            <td width="60%" rowspan="2">
                <h3><?= $invData->name ?></h3>
                <?= nl2br($invData->address) ?><br>
                Contact No: <?= $invData->contact_no ?><br>
                GST No: <b><?= $invData->gst_no ?></b><br>
                State               : <?= $invData->state ?> [<?= $invData->state_code ?>]
            </td>
            <td width="40%">
                Reverse Charge      : No<br>
                Invoice No          : <b><?= $invNo ?></b><br>
                Invoice Date        : <b><?= nice_date($invData->inv_date,'F d, Y') ?></b><br>
                State               : Gujarat [24] 
            </td>
        </tr>
        <tr>
            <td>
                Transportation Mode : <?= $invData->trans_details ?><br><br><br><br>
            </td>
            
        </tr>
    </table>  
	<table border="1">

					<tr>
						<th align="center" width="5%">Sr No</th>
                                                <th align="center" width="10%">Product Code</th>
						<th align="center" width="40%">Name of Product / Service</th>
						<th align="center" width="10%">HSN Code</th>
						<th align="center" width="5%">GST%</th>
						<th align="center" width="5%">Qty</th>
                                                <th align="center" width="10%">Rate</th>
                                                <th align="center" width="15%">Amount</th>
                                               
					</tr>
					<?php
						$i=0;$count=0; // counter for number of rows and Sr No.
                                                $gAmount=0;
                                                $gDiscount=0;
                                                $gTaxableValue=0;
                                                $gSGST=0;
                                                $gCGST=0;
                                                $gIGST=0;
                                                $gTot=0;
                                                $gQty=0;
						foreach ($inv_metas as $inv_meta) ://this foreach loop display invoice meta
                                                    if($skip_rec>$i)
                                                    {
                                                        $i++;
                                                        continue;
                                                    }
							$i++;
                                                        $count++;
                                                $gAmount+=$inv_meta['net_price'];
                                                $gTaxableValue+=$inv_meta['net_price'];
                                                $sgst=$inv_meta['net_price']*$inv_meta['sgst']/100;
                                                $gSGST+=$sgst;
                                                $cgst=$inv_meta['net_price']*$inv_meta['cgst']/100;
                                                $gCGST+=$cgst;
                                                $igst=$inv_meta['net_price']*$inv_meta['igst']/100;
                                                $gIGST+=$igst;
                                                $totGstTax=$sgst+$cgst;
                                                $tot=$totGstTax+$inv_meta['net_price'];
                                                $gTot+=$tot;
                                                $gQty+=$inv_meta['qty'];
                                                $table_row_count++;
                                                
                                                
					?>
                                        <tr class="details">
                                            <td class="details" align="center"><?= $i ?></td>
                                            <td class="details" align="center"><?= $inv_meta['unit_code'] ?></td>
                                            <td class="details"><?= stripcslashes($inv_meta['prod_name']) ?></td>
                                            <td class="details"><?= $inv_meta['prod_code'] ?></td>
                                            <td class="details"><?php echo $inv_meta['sgst']+$inv_meta['sgst']."%"; ?></td>
                                            <td class="details" align="center"><?= $inv_meta['qty'] ?></td>
                                            <td class="details" align="right"><?= number_format($inv_meta['unit_price'],2) ?></td>
                                            <td class="details" align="right"><?= number_format($inv_meta['net_price'],2) ?></td>
                                        </tr>
					<?php
                                        if($count==24){
                                                    $skip_rec=$i;
                                                break;
                                                }
                                        if(strlen(stripcslashes($inv_meta['prod_name']))>39){$count++;}
						endforeach;// end of foreach loop
						while ($count<25) : // this while loop displyas blank rows
							$count++;						
					?>
					<tr class="details"><td class="details">&nbsp;</td><td class="details">&nbsp;</td><td class="details">&nbsp;</td><td class="details">&nbsp;</td><td class="details">&nbsp;</td><td class="details">&nbsp;</td><td class="details">&nbsp;</td><td class="details">&nbsp;</td></tr>					
					<?php
						endwhile; // end of while loop that display blank rows
					?>
                               
                                        <tr>
                                            <td colspan="5" align="right">Total :</td>
                                            <td align="center"><?php echo $gQty; ?></td>
                                            <td></td>
                                            <td align="right"><?= number_format($gAmount,2) ?></td>   
                                        </tr>					
        </table>
    <table border="1">
        <tr><td rowspan="2" >Rs (in words): <?= ucfirst($amtinword) ?> only.</td><td>Sub Total</td><td align="right"><?= number_format($invTot,2) ?></td></tr>
        <tr><td rowspan="3" ><small><?= $taxType ?><br>Rounding Off<small></td><td rowspan="3" align="right"> <small><?= $taxVal ?><br><?= $roundOff ?></small></td></tr>
        <tr><td ><small><b>GST TIN :</b> <?= $gst_no; ?> &nbsp;&nbsp;&nbsp;<b>PAN:</b> <?= $pan_no; ?></small></td></tr>
        <tr><td ><small><?= $bank_name; ?> &nbsp;&nbsp;&nbsp;<b>IFSC Code :</b> <?= $bank_ifsc; ?> &nbsp;&nbsp;&nbsp; <b>A/C No:</b> <?= $bank_acno; ?></small></td></tr>

        <tr>
            <td ><small>Note: <?= $invData->narration ?></small></td>

            <td style="background:#ddd;"> Grand Total  </td>
            <td style="background:#ddd;" align="right"><b><?= $gtot ?></b></td>
        </tr>
        </table>
    <div style="border:1px solid #000;" class="footer">
        <table>
            <tr>
                <td valign="top"><i>*Terms & Conditions:<br><small><?= nl2br($terms_conditions); ?></small></i></td>
                <td align="right">For <?= $display_name; ?><br><br><br><br><br><p class="light">[ Authorised Signature ]</p></td>
            </tr>
        </table>
    </div>
   
</div>
<?php

$a++;
                                    endwhile;

?>