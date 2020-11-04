<h2><?= $title ?></h2>
<table class="table table-hover table-sm">
	<thead>
	<tr>
		<th>No</th>
		<th>Buyer Name</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach ($posts as $post) : ?>
			<tr>
				<td><?php echo $post['inv_no']." ".$post['prefix']; ?></td>
				<td><?php echo $post['name']; ?></td>
				<td><?php echo nice_date($post['inv_date'],'d-m-Y'); ?></td>
				<td><a href="<?php echo base_url().'reports/sells_invoice/'.$post['inv_id']; ?>">Print</a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
