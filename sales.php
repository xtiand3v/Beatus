<?php include('db_connect.php'); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&family=Roboto+Slab&display=swap" rel="stylesheet">
<style>
	input[type=checkbox] {
		/* Double-sized Checkboxes */
		-ms-transform: scale(1.3);
		/* IE */
		-moz-transform: scale(1.3);
		/* FF */
		-webkit-transform: scale(1.3);
		/* Safari and Chrome */
		-o-transform: scale(1.3);
		/* Opera */
		transform: scale(1.3);
		padding: 10px;
		cursor: pointer;
	}

	.card-header {
		font-size: 20px;
		padding-left: 700px;
		font-family: 'Merriweather', serif;
		letter-spacing: 2px;
		background-color: white;
		border-radius: 10px;
		border-color: #ee959e;

	}

	.card {
		border-color: #ee959e;
		font-family: 'Raleway', sans-serif;
		font-family: 'Roboto Slab', serif;
		border-radius: 10px;
		font-size: 17px;
	}

	tr {
		font-size: 16px;
	}

	tbody {
		font-size: 22px;
	}
</style>
</style>
<div class="container-fluid">

	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">

			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header text-center">
						<form method="POST" class="form-inline" action="print/sales_print.php">
							<div class="input-group">
								<div class="input-group-addon">
									<small>From</small> &nbsp
								</div>
								<input type="date" class="form-control pull-right col-sm-12" name="from" max="<?php echo date("Y-m-d"); ?>" required>
							</div>
							<Br>
							<Br>
							<div class="input-group">
								<div class="input-group-addon">&nbsp
									<small>To</small> &nbsp
								</div>
								&nbsp&nbsp<input type="date" class="form-control pull-right col-sm-12" name="to" max="<?php echo date("Y-m-d"); ?>" required>
							</div>
							<input class="btn btn-sm btn-success ml-5" style="width:150px; background-color:#bc5449; color:white; border-color:#bc5449;height:32px; font-size:18px; letter-spacing:2px;" name="print" type="submit" formtarget="_blank" value="Print">
						</form>
					</div>
					<div class="card-header">
						<b>Sales List</b>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover" id="salesList">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Date</th>
									<th class="">Amount</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$order = $conn->query("SELECT * FROM sales order by unix_timestamp(date_created) desc ");
								while ($row = $order->fetch_assoc()) :
									$id = $row['id'];
									$void = $conn->query("SELECT * FROM voided WHERE sales_id = '" . $row['id'] . "' ");
									

								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td>
											<p> <?php echo date("M d,Y", strtotime($row['date_created'])) ?></p>
										</td>
										<td>
											<p class="text-right"> <?php echo number_format($row['total_amount'], 2) ?></p>
										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-outline-primary " style="width:80px; border-radius:5px; background-color:#c38888; color:white; border-color:#c38888; height:25px; font-size:15px;" type="button" onclick="location.href='pos/index.php?id=<?php echo $row['id'] ?>'" data-id="<?php echo $row['id'] ?>">Edit</button>
											<button class="btn btn-sm btn-outline-danger delete_order" style="width:80px; border-radius:5px; background-color:#990f02; color:white; border-color:#990f02; height:25px; font-size:15px;" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
											<?php 
											if($void->num_rows < 1):
											?>
											<a href="index.php?page=void&id=<?php echo $id; ?>" class="btn btn-sm btn-success">Void</a>
											<?php else :
												?>
												<a href="" class="btn btn-sm btn-danger disabled">Voided</a>
												<?php
											 endif; ?>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>

<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset
	}

	img {
		max-width: 100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function() {
		$('table').dataTable()
	})
	$('#new_order').click(function() {
		uni_modal("New order ", "manage_order.php", "mid-large")

	})
	$('.view_order').click(function() {
		uni_modal("Order  Details", "view_order.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_order').click(function() {
		_conf("Are you sure to delete this order ?", "delete_order", [$(this).attr('data-id')])
	})

	function delete_order($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_order',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}


	$(function() {
		//Date range picker
		$('#reservation').daterangepicker()
		$('#daterange-btn').daterangepicker({
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				startDate: moment().subtract(29, 'days'),
				endDate: moment()
			},
			function(start, end) {
				$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
			}
		)

	});
</script>