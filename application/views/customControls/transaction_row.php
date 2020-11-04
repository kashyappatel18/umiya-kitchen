<tr>
    <td>
        <b class="form-text text-muted text-center dType"><?php echo ($dType==0)?'Dr':'Cr';?></b>
        <input type="hidden" name="dType[]" value="<?php if(isset($dType))echo $dType;;?>"/>
    </td>
    <td>
        <select class="form-control acno" name="dAcNo[]" >
            <?php foreach($ACs as $ac): ?>
            <?php
                $aSelect=NULL;
                if($acNo==$ac['ac_code'] and isset($acNo))
                    $aSelect='selected';
            ?>
            <option value="<?php echo $ac['ac_code'];?>" <?php echo $aSelect; ?>><?php echo $ac['ac_name'];?></option>
            <?php endforeach; ?>
        </select>
        <i class="form-text text-muted text-right text-primary acBal" id="acBal">0 Cr</i>
    </td>
    <td>
        <input type="text" name="dAmount[]" class="form-control" value="<?php if(isset($dAmount))echo $dAmount;?>" />
    </td>
    <td>
        <input type="text" name="dNaration[]" class="form-control" value="<?php if(isset($dNaration)) echo $dNaration;?>"/>
    </td>
    <td align="center" style="vertical-align:middle"><a href="#" class="text-danger remove"><i class="fa fa-times-circle fa-2x"></i></a></td>
</tr>