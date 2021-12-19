<?php include('db_connect.php');?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&family=Roboto+Slab&display=swap" rel="stylesheet">

<style>

.card-header{
	font-family:'Merriweather', serif;
	background-color:white;
	font-size:20px;
	padding-left:700px;
	letter-spacing:2px;
	border-color:#ee959e;
}
.text-center{
	font-size:16px;
}
.card{
	border-color:#ee959e;
	font-family: 'Raleway', sans-serif;
	font-family: 'Roboto Slab', serif;
	border-radius:10px;
	font-size:15px;
}
td{
	font-size:20px;
}
.badge{
	font-size:13px;
	padding-top:5px;
	padding-bottom:5px;
	letter-spacing:2px;
}

</style>


<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
				
				<div class="card-header text-center">
						<form method="POST" class="form-inline" action="print/receive_print.php">
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
						<b>Receiving List</b>
						 <span class="float:right"><a class="btn btn-primary btn-sm col-sm-3 float-right" href="javascript:void(0)"  style="border-radius:5px; background-color:#ee959e; color:white; border-color:#ee959e; height:30px; padding-top:5px; font-size:15px;" id="receive-po">
		                    <i class="fa fa-plus"></i> New Entry 
		                </a></span>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Date/Time</th>
									<th class="text-center">PO Code</th>
									<th class="text-center">Supplier</th>
									<th class="text-center">Total Amount</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$receiving = $conn->query("SELECT r.*,s.name as sname,p.po_code FROM receiving r inner join suppliers s on s.id = r.supplier_id inner join purchase_order p on r.po_id = p.id order by unix_timestamp(r.date_created) desc");
								while($row=$receiving->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo date("M d, Y H:i A",strtotime($row['date_created'])) ?></b></p>
									</td>
									<td class="">
										<p><b><?php echo ($row['po_code']) ?></b></p>
									</td>
									<td class="">
										<p><b><?php echo ucwords($row['sname']) ?></b></p>
									</td>
									<td class="text-right">
										<b><?php echo number_format($row['total_cost'],2) ?></b>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_receiving" style="width:80px; border-radius:5px; background-color:#c38888; color:white; border-color:#c38888; height:25px; font-size:15px;" type="button" onclick="location.href='index.php?page=manage_receiving&id=<?php echo $row['id'] ?>'" data-json='<?php echo json_encode($row) ?>'>Edit</button>
										<button class="btn btn-sm btn-danger delete_receiving" style="width:80px; border-radius:5px; background-color:#990f02; color:white; border-color:#990f02; height:25px; font-size:15px;" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										<button class="btn btn-sm btn-warning edit_receiving" style="width:80px; border-radius:5px;  color:white;  height:25px; font-size:15px;" type="button" onclick="location.href='index.php?page=manage_reorder&id=<?php echo $row['id'] ?>'" data-json='<?php echo json_encode($row) ?>'>Re-order</button>
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
	
	td{
		vertical-align: middle !important;
	}
	td p {
		margin:unset;
	}
	.custom-switch{
		cursor: pointer;
	}
	.custom-switch *{
		cursor: pointer;
	}
</style>
<script>
	$(function(){
		$('#receive-po').click(function(){
			uni_modal('Select PO to Receive',"choose_po.php")
		})
	})
	$('#manage-receiving').on('reset',function(){
		$('input:hidden').val('')
		$('.select2').val('').trigger('change')
	})
	
	$('#manage-receiving').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_receiving',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.delete_receiving').click(function(){
		_conf("Are you sure to delete this receiving?","delete_receiving",[$(this).attr('data-id')])
	})
	function delete_receiving($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_receiving',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable();


	
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