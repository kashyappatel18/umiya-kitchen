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