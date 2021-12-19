<?php include "db_connect.php" ?>
<?php
if((!isset($_GET['id']) && !isset($_GET['po']))){
	echo "<script>alert('Purchase Order is required to receive.');location.replace('./index.php?page=receiving');</script>";
}
if(isset($_GET['id']) || isset($_GET['po'])){
	if(isset($_GET['id']))
	$qry = $conn->query("SELECT r.*,p.po_code FROM receiving r inner join purchase_order p on r.po_id = p.id where r.id = ".$_GET['id']);
	if(isset($_GET['po']))
	$qry = $conn->query("SELECT * FROM purchase_order where id = ".$_GET['po']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
	// echo "SELECT s.*,i.name as iname,i.item_code as code,i.id as iid FROM stocks s inner join items i on i.id = s.item_id ".(isset($inventory_ids) ? "where s.id in ($inventory_ids)":"");
	if(isset($_GET['id'])){
		$stock = $conn->query("SELECT s.*,i.name as iname,i.item_code as code,i.id as iid FROM stocks s inner join items i on i.id = s.item_id ".(isset($inventory_ids) ? "where s.id in ($inventory_ids)":"")." ");
		$po_stock = $conn->query("SELECT p.*,i.item_code,i.name FROM po_items p inner join items i on p.item_id = i.id  where p.po_id = '{$po_id}' ");
		while($row = $po_stock->fetch_assoc()){
			$oqty[$row['item_id']] = $row['qty'];
		}
	}
	
	if(isset($_GET['po']))
		$stock = $conn->query("SELECT p.*,i.item_code,i.name FROM po_items p inner join items i on p.item_id = i.id  where p.po_id = '{$id}' ");

}
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&family=Roboto+Slab&display=swap" rel="stylesheet">

<style>

	hr{
		border-color:#ee959e;
	}
	.card{
	
	border-color:#ee959e;
	font-family: 'Raleway', sans-serif;
	font-family: 'Roboto Slab', serif;
	border-radius:10px;
	font-size:15px;
}
</style>

<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<div class="col-md-12">
				<form id="manage-receiving">
					<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
					<input type="hidden" name="po_id" value="<?php echo isset($_GET['po']) ? $_GET['po'] : (isset($po_id) ? $po_id : '') ?>">
						<div class="row">
						<div class="form-group col-sm-6">
							<label class="control-label">P.O. Code</label>
							<input type="text" min='1' class="form-control form-control-sm " id="po_code" name="po_code" value="<?php echo isset($po_code) ? $po_code : '' ?>"  readonly required>

						</div>
						<div class="form-group col-sm-6">
							<label class="control-label">Supplier</label>
							<input type="hidden" name="supplier_id" value="<?php echo isset($supplier_id) ? $supplier_id : '' ?>">
							<?php 
								$supplier = $conn->query("SELECT * FROM suppliers where id = '{$supplier_id}' ")->fetch_array()['name'];
								?>
							<input type="text" min='1' class="form-control form-control-sm " value="<?php echo isset($supplier) ? $supplier : '' ?>"  readonly required>
						</div>
					</div>
					<hr>
					<?php 
					$items_arr = array();
						$items = $conn->query("SELECT * FROM items order by name asc");
						while($row = $items->fetch_assoc()):
							$items_arr[$row['supplier_id']][]=$row;
						endwhile; 
					?>
					<div class="row">
						
						<table class="table table-bordered" id="prod-list">
							<thead>
								<tr>
									<th class="text-center" width="5%"></th>
									<th class="text-center" width="15%">Item Code</th>
									<th class="text-center" width="20%">Product</th>
									<th class="text-center" width="10%">QTY</th>
									<th class="text-center" width="10%">Mark Up %</th>
									<th class="text-center" width="15%">Unit Cost</th>
									<th class="text-center" width="25%">Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(isset($stock)):
									while($row=$stock->fetch_assoc()):
								?>
								<tr data-id="<?php echo $row['item_id'] ?>">
									<td class="text-center">
										<button class="btn btn-sm btn-outline-danger rem_list" type="button"><i class="fa fa-times"></i></button>
									</td>
									<td class="text-center">
										<b class="item_code"><?php echo isset($_GET['id'])? ucwords($row['code']) : $row['item_code'] ?></b>
										<input type="hidden" name="item_id[]" value="<?php echo $row['item_id'] ?>">
										<input type="hidden" name="inv_id[]" value="<?php echo isset($_GET['id'])? $row['id'] : '' ?>">
									</td>
									<td class="">
										<b class="pname"><?php echo isset($_GET['id'])? ucwords($row['iname']) : ucwords($row['name']) ?></b>
									</td>
									<td class="text-center">
									<input type="hidden" name="oqty[]" value="<?php echo isset($oqty[$row['item_id']]) ? $oqty[$row['item_id']] : $row['qty'] ?>">
										<input type="number" class="form-control-sm text-right" max="<?php echo isset($oqty[$row['item_id']]) ? $oqty[$row['item_id']] : $row['qty'] ?>" name="qty[]" value="<?php echo $row['qty'] ?>">
									</td>
									<td class="text-center">
										<input type="number" class="form-control-sm text-right" name="profit_perc[]" value="<?php echo isset($row['profit_perc']) ? $row['profit_perc'] : 0 ?>">
									</td>
									<td class="text-center">
										<input type="text" class="form-control-sm number text-right" name="cost[]" value="<?php echo number_format($row['price']) ?>">
									</td>
									<td class="text-right">
										<b class="amount text-right"></b>
									</td>
								</tr>
								<script>
									$(document).ready(function(){
										calc()
										$('.rem_list').click(function(){
											$(this).closest('tr').remove()
											calc()
										})
									})
								</script>
								<?php endwhile; ?>
								<?php endif; ?>
							</tbody>
							<tfoot>
								<tr>
									<th class="text-center" colspan="6"><b>Total</b></th>
									<th class="text-right">
										<input type="hidden" name="total_amount" value="0">
										<b class="tamount" id="total_amount">0.00</b>
									</th>
								</tr>
							</tfoot>
						</table>
					<hr>
					<div class="col-md-12 text-center">
						<button class="btn btn-sm btn-primary col-sm-4" style="width:300px; border-radius:5px; background-color:#D291BC; border-color:#d291bc; color:white; height:25px; font-size:15px;">Save</button>
						<?php if(isset($id) && !empty($id)): ?>
						<button class="btn btn-sm btn-success col-sm-4" style="width:300px; border-radius:5px; background-color:#bc5449; border-color:#bc5449; color:white; height:25px; font-size:15px;"  type="button" id="print">Print</button>
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<style>
	input[name="qty[]"]{
		width: 75px
	}
</style>
<div id="item" style="display:none">
	<table>
		<tr>
			<td class="text-center">
				<button class="btn btn-sm btn-outline-danger rem_list" type="button"><i class="fa fa-times"></i></button>
			</td>
			<td class="text-center">
				<b class="item_code"></b>
				<input type="hidden" name="item_id[]">
				<input type="hidden" name="inv_id[]">
			</td>
			<td class="">
				<b class="pname"></b>
			</td>
			<td class="text-center">
				<input type="number" class="form-control-sm text-right" name="qty[]">
			</td>
			<td class="text-center">
				<input type="number" class="form-control-sm text-right" name="profit_perc[]">
			</td>
			<td class="text-center">
				<input type="text" class="form-control-sm number text-right" name="cost[]">
			</td>
			<td class="text-right">
				<b class="amount text-right"></b>
			</td>
		</tr>
	</table>
</div>
<script>
	$(function(){
		$('#print').click(function(){
			start_load();
			var nw = window.open("print_receiving.php?id=<?php echo isset($id) ? $id : '' ?>","","height=900,width=1200,left=75,top=25")
			
			setTimeout(() => {
				nw.print()
				setTimeout(() => {
					nw.close()
					end_load()
				}, 500);
			}, 700);
		})
		$('[name="qty[]"],[name="cost[]"]').on('keyup keydown keypress change',function(){
			calc()
		})
		$('.rem_list').click(function(){
			$(this).closest('tr').remove()
			calc()
		})
		var items = $.parseJSON('<?php echo json_encode($items_arr) ?>');
		$('#supplier_id').change(function(){
			var sid = $(this).val()
			var opt = $('<option>')
			opt.attr('disabled',true)
			opt.attr('selected',true)
			$('#item_id').html('')
			$('#item_id').append(opt)
			$('#item_id').val('').trigger('change')
			if(!!items[sid]){
				Object.keys(items[sid]).map(k=>{
					data = items[sid][k];
					var opt = $('<option>')
						opt.attr('value',data.id)
						opt.attr('data-code',data.item_code)
						opt.text(data.name)
						$('#item_id').append(opt)
						$('#item_id').val('').trigger('change')
				})
			}
		})
		if('<?php echo isset($supplier_id) ?>' == 1){
			$('#supplier_id').trigger('change')

		}

	})
	
	$('#add_to_list').click(function(){
		var tr = $('#item').clone()
		var pid = $('#item_id').val();
		var qty = $('#qty').val();
		var profitPerc = $('#profitPerc').val();
		var cost = $('#cost').val();

		if(pid=='' ||qty==''||cost==''){
			alert_toast("Please complete the fields first.",'danger')
			return false;
		}
		var pname = $('#item_id option[value="'+pid+'"]').text();
		var code = $('#item_id option[value="'+pid+'"]').attr('data-code');
		tr.attr('data-id',pid)
		tr.find('.item_code').text(code)
		tr.find('[name="item_id[]"]').val(pid)
		tr.find('.pname').text(pname)
		tr.find('[name="qty[]"]').attr('value',qty)
		tr.find('[name="profit_perc[]"]').attr('value',profitPerc)
		tr.find('[name="cost[]"]').attr('value',cost)
		$('#prod-list tbody').append(tr.find('table tbody').html())
		$('#item_id').val('').trigger('change')
		$('#qty').val('')
		$('#cost').val('')
		calc()
		$('[name="qty[]"],[name="cost[]"]').on('keyup keydown keypress change',function(){
			calc()
		})
		$('.rem_list').click(function(){
			$(this).closest('tr').remove()
			calc()
		})
		$('.number').on('input',function(){
		    var val = $(this).val()
		     	val = val.replace(/,/g, '');
		     	val = val.replace(/[^0-9 \,]/g, '');
		     	val = val > 0 ? parseFloat(val).toLocaleString('en-US') : '';
		      	$(this).val(val)
	    })
	})
	function calc(){
		var total = 0;
		$('[name="qty[]"]').each(function(){
			var tr = $(this).closest('tr')
			var qty = $(this).val()
			var cost = tr.find('[name="cost[]"]').val()
			cost = cost.replace(/,/g,'')
			var amount = parseFloat(qty) * parseFloat(cost)
				amount = amount > 0 ? amount : 0;
			tr.find('.amount').text(parseFloat(amount).toLocaleString('en-US',{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))
		})
		$('.amount').each(function(){
			var amount = $(this).text()
				amount = amount.replace(/,/g,'')
				total += parseFloat(amount)
		})
		$('[name="total_amount"]').val(total)
		$('#total_amount').text(parseFloat(total).toLocaleString('en-US',{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))
	}
	$('.number').on('input',function(){
	    var val = $(this).val()
	     	val = val.replace(/,/g, '');
	     	val = val.replace(/[^0-9 \,]/g, '');
	     	val = val > 0 ? parseFloat(val).toLocaleString('en-US') : '';
	      	$(this).val(val)
 	})
 	$('#manage-receiving').submit(function(e){
 		e.preventDefault()
 		start_load()
 		$.ajax({
 			url:'ajax.php?action=save_receiving',
 			method:'POST',
 			data:$(this).serialize(),
 			success:function(resp){
 				if(resp == 1){
 					alert_toast("Data successfully saved.","success")
 					setTimeout(function(){
 						if('<?php echo isset($_GET['id']) ?>' == 1)
 							location.reload()
 						else
 							location.replace('index.php?page=receiving')
 					},500)
 				}
 			}
 		})
 	})
</script>