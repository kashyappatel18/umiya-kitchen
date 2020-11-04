<div class="container">
<br><h2 align="center"><u>SALES REGISTER</u></h2>
<table>
    <tbody>
        <tr>
            <td></td>
            <td align="right">Register Date</td>
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
            <th width="2cm">Date</th>
            <th width="2cm">Invoice No</th>
            <th>Customer Name</th>
            <th width="2cm">Amount</th>
        </tr>
    </thead>
    <?php $tot_bal=0; ?>
    <tbody>
                
        <?php
            foreach($recs as $rec):          
        ?>
        <tr>
            <td align="center"><?php echo nice_date($rec['Date'],'d-m-Y'); ?></td>
            <td align="center"><?php echo $rec['Prefix'].' '.$rec['Inv_no']; ?></td>
            <td><?php echo $rec['Name']; ?></td>
            <td align="right"><?php echo round($rec['Amount'],0); ?></td>
            
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
