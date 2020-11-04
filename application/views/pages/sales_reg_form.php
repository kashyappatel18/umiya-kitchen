<h4><?= $title ?></h4>
<div class="row">
    <div class="col-lg-4">
        <div class="container">
            <?php echo form_open('sales_reg/genSalesReg'); ?>
            <div class="form-group">
                <label>From Date</label>
                <input type="date" name="from_date" class="form-control"/>
            </div>
            <div class="form-group">
                <label>To Date</label>
                <input type="date" name="to_date" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="submit" name="btn_gen_stat" value="Generate" class="btn btn-primary"/>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
