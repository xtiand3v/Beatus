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
						<form method="GET" class="form-inline">
							<div class="input-group">
								<div class="input-group-addon">
									<small>From</small> &nbsp
								</div>
								<input type="date" class="form-control pull-right col-sm-12" placeholder="yyyy-MM-dd" name="from" max="<?php echo date("Y-m-d"); ?>" required id="from">
							</div>
							<Br>
							<Br>
							<div class="input-group">
								<div class="input-group-addon">&nbsp
									<small>To</small> &nbsp
								</div>
								&nbsp&nbsp<input type="date" placeholder="yyyy-MM-dd" class="form-control pull-right col-sm-12" name="to" max="<?php echo date("Y-m-d"); ?>" id="to">
								<input type="hidden" name="page" value="purchase_order">
							</div>
							<input class="btn btn-sm btn-success ml-5" style="width:120px; background-color:#bc5449; color:white; border-color:#bc5449;height:30px; font-size:15px; letter-spacing:2px;" name="submit" type="submit" value="Submit">
						</form>
					</div>
					<div class="card-header">
						<b>Purchase List</b>
						 <span class="float:right"><a class="btn btn-primary btn-sm col-sm-3 float-right" style="border-radius:5px; background-color:#ee959e; color:white; border-color:#ee959e; height:30px; padding-top:5px; font-size:15px;" href="index.php?page=manage_po" id="">
		                    <i class="fa fa-plus"></i> New Entry 
		                </a></span>
					</div>
					<div class="card-body">
                <?php 
                if(isset($_GET['from']) && $_GET['to'] != ""):
                ?>
                <div class="text-center">
                    <h3>Purchase Order Report</h3>
                    <h4>From <?php echo date("F d, Y",strtotime($_GET['from'])); ?> to <?php echo date("F d, Y",strtotime($_GET['to'])); ?></h4>
                </div>
                <?php 
			elseif(isset($_GET['from']) && $_GET['to'] == ""):
				echo "<div class='text-center'>
						<h3>Purchase Order Report</h3>
						<h4>For ".date("F d, Y",strtotime($_GET['from']))."</h4>
					</div>";
			endif; ?>
						<table class="table table-bordered table-hover" id="table">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Date/Time</th>
									<th class="text-center">P.O. Code</th>
									<th class="text-center">Supplier</th>
									<th class="text-center">Total Amount</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
							if(isset($_GET['from']) && $_GET['to'] == ""){
									$from = $_GET['from'];
									$po = $conn->query("SELECT p.*,s.name as sname FROM purchase_order p inner join suppliers s on s.id = p.supplier_id WHERE DATE(p.date_created) = '$from' order by unix_timestamp(p.date_created)  desc");

								} elseif(isset($_GET['from']) && $_GET['to'] != "") {
									$from = $_GET['from'];
									$to = $_GET['to'];
									$po = $conn->query("SELECT p.*,s.name as sname FROM purchase_order p inner join suppliers s on s.id = p.supplier_id where p.date_created BETWEEN '$from' AND '$to' order by p.date_created desc");
								} else {
									$po = $conn->query("SELECT p.*,s.name as sname FROM purchase_order p inner join suppliers s on s.id = p.supplier_id order by p.status asc,unix_timestamp(p.date_created) desc");
								}
								while($row=$po->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><?php echo date("M d, Y H:i A",strtotime($row['date_created'])) ?></p>
									</td>
									<td class="">
										<p><?php echo $row['po_code'] ?></p>
									</td>
									<td class="">
										<p><?php echo ucwords($row['sname']) ?></p>
									</td>
									<td class="text-right">
										<b><?php echo number_format($row['total_cost'],2) ?></b>
									</td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 1): ?>
                                            <span class="badge badge-success rounded-pills">Received</span>
										<?php elseif($row['status'] == 2): ?>
                                            <span class="badge badge-warning rounded-pills">Partially Received</span>
                                        <?php else: ?>
                                            <span class="badge badge-primary rounded-pills">Pending</span>
                                        <?php endif; ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_po" style="width:80px; border-radius:5px; background-color:#c38888; color:white; border-color:#c38888; height:25px; font-size:15px;" type="button" onclick="location.href='index.php?page=manage_po&id=<?php echo $row['id'] ?>'" data-json='<?php echo json_encode($row) ?>'>Edit</button>
										<button class="btn btn-sm btn-danger delete_po" style="width:80px; border-radius:5px; background-color:#990f02; color:white; border-color:#990f02; height:25px; font-size:15px;" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
							<div class="text-center">
						<form method="POST" action="print/po_print.php">
							
						<?php 
                if(isset($_GET['from'] )):
                ?>
				<input type="date" hidden value="<?php echo $_GET['from']; ?>" class="form-control pull-right col-sm-12" name="min" required id="min">
				<input type="date" hidden value="<?php if($_GET['to'] != ''): echo $_GET['to']; else: echo $_GET['from']; endif; ?>" class="form-control pull-right col-sm-12" name="max" id="max">
							<input class="btn btn-sm btn-success ml-5" style="width:150px; background-color:#bc5449; color:white; border-color:#bc5449;height:32px; font-size:18px; letter-spacing:2px;" name="print" type="submit" formtarget="_blank" value="Print">
                <?php endif; ?>
						</form>
							</div>
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
	$('#manage-po').on('reset',function(){
		$('input:hidden').val('')
		$('.select2').val('').trigger('change')
	})
	
	$('#manage-po').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_po',
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
	$('.delete_po').click(function(){
		_conf("Are you sure to delete this po?","delete_po",[$(this).attr('data-id')])
	})
	function delete_po($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_po',
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

	// $(document).ready(function(){
    //     $.fn.dataTable.ext.search.push(
    //     function (settings, data, dataIndex) {
    //         var min = $('#from').datepicker("getDate");
    //         var max = $('#to').datepicker("getDate");
    //         var startDate = new Date(data[4]);
    //         if (min == null && max == null) { return true; }
    //         if (min == null && startDate <= max) { return true;}
    //         if(max == null && startDate >= min) {return true;}
    //         if (startDate <= max && startDate >= min) { return true; }
    //         return false;
    //     }
    //     );

    //         var table = $('#table').dataTable();
       
    //         $("#from").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true,dateFormat: 'yyyy-MM-dd' });
    //         $("#to").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true ,dateFormat: 'yyyy-MM-dd' });

    //         // Event listener to the two range filtering inputs to redraw on input
    //         $('#from, #to').change(function () {
    //             table.draw();
    //         });
    //     });

	
</script>