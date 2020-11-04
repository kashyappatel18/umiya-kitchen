<div class="container">
    <table>
        <tr>
            <td width="30%"></td>
            <td width="60%" align="left"> 
                <h2>To : <?= $contact->city;?></h2><br>
                <h4 align="center"><?= $contact->name; ?></h4>
                <p><?= nl2br($contact->address); ?></p>
                <p>GST No. : <?= $contact->gst_no; ?></p>
                <p>Contact No. : <?= $contact->contact_no; ?></p>
            </td>
            <td width="10%" align="right"></td>
        </tr>
    </table>
</div>