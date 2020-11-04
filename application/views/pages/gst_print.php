<h2><?= $title ?></h2>
<div class="row">
    <div class="col-lg-12">
        <div class="container">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Sales</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Purchase</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">Credit Note</a></li>
                    </ul>

                    <div class="tab-content">
                      <div id="home" class="tab-pane active">
                        <table class="table table-hover table-bordered table-sm">
                                <thead>
                                <tr>
                                        <th>Invoice No</th>
                                        <th>Buyer Name</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <?php foreach ($posts as $post) : 
                                            if($post['inv_type']!=0)continue;
                                            ?>
                                        
                                    <tr>
                                        <td><a href="<?php echo base_url().'reports/gst_invoice/'.$post['inv_id'];?>" target="_blank"><?php echo $post['prefix']." ".$post['inv_no']; ?></a></td>
                                        <td><?php echo $post['name']; ?></td>
                                        <td><?php echo nice_date($post['inv_date'],'d-m-Y'); ?></td>
                                        <td align="right"><a href="<?php echo base_url().'sinvoice/edit/'.$post['inv_id'];?>" target="_blank"><?php echo number_format(round($post['amount']),2); ?></a></td>
                                        <td align="right"><a href="<?php echo base_url().'sinvoice/delete/'.$post['inv_id'];?>">Delete</a></td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                        </table>
                      </div>
                        <div id="menu1" class="tab-pane fade">
                        <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Buyer Name</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php foreach ($posts as $post) : 
                                            if($post['inv_type']!=1) continue;                                                
                                            ?>

                                    <tr>
                                        <td><a href="<?php echo base_url().'reports/gst_invoice/'.$post['inv_id'];?>" target="_blank"><?php echo $post['prefix']." ".$post['inv_no']; ?></a></td>
                                        <td><?php echo $post['name']; ?></td>
                                        <td><?php echo nice_date($post['inv_date'],'d-m-Y'); ?></td>
                                        <td align="right"><a href="<?php echo base_url().'pinvoice/edit/'.$post['inv_id'];?>" target="_blank"><?php echo number_format(round($post['amount']),2); ?></a></td>
                                        <td align="right"><a href="<?php echo base_url().'pinvoice/delete/'.$post['inv_id'];?>">Delete</a></td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                        </table>
                      </div>
                        <div id="menu2" class="tab-pane fade">
                        <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Buyer Name</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php foreach ($posts as $post) : 
                                            if($post['inv_type']!=2) continue;                                                
                                            ?>

                                    <tr>
                                        <td><a href="<?php echo base_url().'reports/gst_invoice/'.$post['inv_id'];?>" target="_blank"><?php echo $post['prefix']." ".$post['inv_no']; ?></a></td>
                                        <td><?php echo $post['name']; ?></td>
                                        <td><?php echo nice_date($post['inv_date'],'d-m-Y'); ?></td>
                                        <td align="right"><a href="<?php echo base_url().'pinvoice/edit/'.$post['inv_id'];?>" target="_blank"><?php echo number_format(round($post['amount']),2); ?></a></td>
                                        <td align="right"><a href="#">Delete</a></td>
                                    </tr>
                                        <?php endforeach; ?>
                                </tbody>
                        </table>
                      </div>
                    </div>
        </div>
    </div>
</div>
