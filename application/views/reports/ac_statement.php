<div class="container">
<br><h2 align="center"><u>STATEMENT OF ACCOUNT</u></h2>
<table>
    <tbody>
        <tr>
            <td></td>
            <td align="right"><h3><?= $display_name; ?></h3></td>
        </tr>
        <tr>            
            <td><h3>M/S <?= $ac_name; ?></h3></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td align="right">Statement Date</td>
        </tr>
        <tr>
            <td></td>
            <td align="right">From : <?= nice_date($from_date,'d-m-Y'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td align="right">To : <?= nice_date($to_date,'d-m-Y'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<table border="1">
    <thead>
        <tr style="background: #ddd;">
            <th>Date</th>
            <th width="50%">Narration</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Balance</th>
        </tr>
    </thead>
    <?php $tot_bal=0; ?>
    <tbody>
        <tr>
            <td></td>
            <td align="right">Opening Balance :</td>
            <td align="right"><?= ($op_bal>0)?number_format($op_bal,2):""; ?></td>
            <td align="right"><?= ($op_bal<0)?number_format($op_bal,2):""; ?></td>
            <td align="right"><?= number_format($op_bal,2); ?></td>
        </tr>
        
        <?php
            $tot_bal+=$op_bal;
            foreach($trans as $tran):
            $tot_bal+=$tran['Amount'];
        ?>
        <tr>
            <td align="center"><?php echo nice_date($tran['Date'],'d-m-Y'); ?></td>
            <td><?php echo $tran['Naration']; ?></td>
            <td align="right"><?php echo ($tran['Amount']>0)?number_format($tran['Amount'],2):""; ?></td>
            <td align="right"><?php echo ($tran['Amount']<0)?number_format($tran['Amount'],2):""; ?></td>
            <td align="right"><?php echo number_format($tot_bal,2); ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<table>
    <tbody>
         <tr>
            <td></td>
            <td>&nbsp;</td>
        </tr> <tr>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td align="right">For <?= $display_name; ?><br><br><br><br><br><p class="light">[ Authorised Signature ]</p></td>
        </tr>
    </tbody>
</table>
</div>