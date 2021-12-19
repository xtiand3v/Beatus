<?php include "db_connect.php" ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&family=Roboto+Slab&display=swap" rel="stylesheet">


<style>
.card-header{
	font-size:20px;
	padding-left:700px;
	font-family:'Merriweather', serif;
	letter-spacing:2px;
	background-color:white;
	border-radius:10px;
	border-color:#ee959e;	
}	
.card{
	border-color:#ee959e;
	font-family: 'Raleway', sans-serif;
	font-family: 'Roboto Slab', serif;
	border-radius:10px;
	font-size:15px;
}
tr{
	font-size:16px;
}
tbody{
	font-size:13px;
}

</style>

<div class="col-lg-12">
	<div class="card">
		<div class="card-header"><b>Inventory</b></div>
		<div class="card-body">
				<div class="card-header text-center">
						<form method="POST" class="form-inline" action="print/inventory_print.php">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i> &nbsp
								</div>
								<input type="text" class="form-control pull-right col-sm-12" id="reservation" name="date_range">
							</div>
							<input class="btn btn-sm btn-success ml-5" style="width:150px; background-color:#bc5449; color:white; border-color:#bc5449;height:32px; font-size:18px; letter-spacing:2px;" name="print" type="submit" formtarget="_blank" value="Print">
						</form>
					</div>
		<!-- <div class="w-100 d-flex justify-content-end pb-2" >
			<button class="btn btn-sm btn-success" style="width:300px; border-radius:5px; background-color:#bc5449; color:white; border-color:#bc5449;height:32px; font-size:18px; letter-spacing:2px;" id="print" type="button"><i class="fa fa-print"></i> Print</button>
		</div> -->
			<table class="table table-bordered" id="inventorList" >
				<thead > 
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Item Code</th>
						<th class="text-center">Item Name</th>
						<th class="text-center">Item Size</th>
						<th class="text-center">Stock Available</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i = 1;
						$qry = $conn->query("SELECT * FROM items order by name asc");
						while($row=$qry->fetch_assoc()):
							$inn = $conn->query("SELECT sum(qty) as stock FROM stocks where type = 1 and item_id =".$row['id']);
							$inn = $inn->num_rows > 0 ? $inn->fetch_array()['stock'] :0 ;
							$out = $conn->query("SELECT sum(qty) as stock FROM stocks where type = 2 and item_id =".$row['id']);
							$out = $out->num_rows > 0 ? $out->fetch_array()['stock'] :0 ;
							$available = $inn - $out;
					?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo $row['item_code'] ?></td>
						<td><?php echo ucwords($row['name']) ?></td>
						<td><?php echo $row['size'] ?></td>
						<td class="text-center"><?php echo number_format($available) ?></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<noscript>
	<style>
		table#inventorList{
			width:100%;
			border-collapse:collapse
		}
		table#inventorList td,table#inventorList th{
			border:1px solid
		}
        p{
            margin:unset;
        }
		.text-center{
			text-align:center
		}
        .text-right{
            text-align:right
        }
	</style>
</noscript>
<script>
$(function(){
	$('#print').click(function(){
		// $('#inventorList').dataTable().fnDestroy()
		var _c = $('#inventorList').clone();
		var ns = $('noscript').clone();
            ns.append(_c)
		var nw = window.open('','_blank','width=900,height=600')
		nw.document.write('<p class="text-center"><b>Inventory Records as of <?php echo date("F, Y") ?></b></p>')
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(() => {
			nw.close()
            // $('#inventorList').dataTable()
		}, 500);
	})
})


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