<?php include('db_connect.php');?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&family=Roboto+Slab&display=swap" rel="stylesheet">


<style>
.card{
	
	border-color:#ee959e;
	font-family: 'Raleway', sans-serif;
	font-family: 'Roboto Slab', serif;
	border-radius:10px;
	font-size:15px;
}

</style>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-product">
				<div class="card">
					<div class="card-header" style=" font-size:20px; font-family:'Merriweather', serif; letter-spacing:2px; background-color:white; border-color:#ee959e; padding-left:180px;">
						  <b>  Product Form </b>
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Item Code</label>
								<input type="text" class="form-control form-control-sm" name="item_code" id ="item_code">
								<small><i>Leave this blank it will auto-generate a code.</i></small>
							</div>
							<div class="form-group">
								<label class="control-label">Name</label>
								<input type="text" style="border-color:black;" class="form-control form-control-sm" name="name">
							</div>
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea name="description" style="border-color:black;" id="description" cols="30" rows="4" class="form-control form-control-sm"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Size</label>
								<select name="size" id="size" style="border-color:black;" class="custom-select custom-select-sm">
									<option>XS</option>
									<option>S</option>
									<option>M</option>
									<option>L</option>
									<option>XL</option>
									<option>XXL</option>
									<option>XXXL</option>
									<option>None</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Flooring</label>
								<input type="number" style="border-color:black;" min="1" value="20" class="form-control form-control-sm text-right" name="alert_min">
							</div>
							<div class="form-group">
								<label class="control-label">Ceiling</label>
								<input type="number" style="border-color:black;" min="1" value="100" class="form-control form-control-sm text-right" name="alert_max">
							</div>
							<div class="form-group">
								<label class="control-label">Price</label>
								<input type="number" style="border-color:black;" class="form-control form-control-sm text-right" name="price">
							</div>
							<div class="form-group">
								<label class="control-label">Supplier</label>
								<select name="supplier_id"  id="supplier_id" class="form-control form-control-sm select2" required>
									<option value="" disabled selected></option>
									<?php 
									$supplier_arr=array();
									$supplier = $conn->query("SELECT * FROM suppliers order by `name` asc");
									while($row = $supplier->fetch_assoc()):
										$supplier_arr[$row['id']] = $row['name'];
									?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3" style="width:80px; border-radius:5px; background-color:#ee959e; color:white; border-color:#ee959e; height:25px; font-size:15px;"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-product').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header" style=" font-size:20px; font-family:'Merriweather', serif; padding-left:500px; letter-spacing:2px; background-color:white; border-color:#ee959e;">
						<b>Product List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover" style="border-color:black;">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Item Code</th>
									<th class="text-center">Product Info.</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$product = $conn->query("SELECT * FROM items order by id asc");
								while($row=$product->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo $row['item_code'] ?></b></p>
									</td>
									<td class="">
										<p class="m-0">Name: <b><?php echo $row['name'] ?></b></p>
										<p class="m-0"><small>Price: <b><?php echo number_format($row['price'],2) ?></b></small></p>
										<p class="m-0"><small>Size: <b><?php echo $row['size'] ?></b></small></p>
										<p class="m-0"><small>Description: <b><?php echo $row['description'] ?></b></small></p>
										<p class="m-0"><small>Alert(flooring/ceiling): <b><?php echo $row['alert_min'].'/'.$row['alert_max'] ?></b></small></p>
										<p class="m-0"><small>Supplier: <b><?php echo isset($supplier_arr[$row['supplier_id']]) ? $supplier_arr[$row['supplier_id']] : "" ?></b></small></p>

									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_product" style="width:80px; border-radius:5px; background-color:#c38888; color:white; border-color:#c38888; height:25px; font-size:15px;"  type="button" data-json='<?php echo json_encode($row) ?>'>Edit</button>
										<button class="btn btn-sm btn-danger delete_product" style="width:80px; border-radius:5px; background-color:#990f02; color:white; border-color:#990f02; height:25px; font-size:15px;"  type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
		$('.select2').select2()
	})
	$('#manage-product').on('reset',function(){
		$('input:hidden').val('')
		$('.select2').val('').trigger('change')
	})
	
	$('#manage-product').submit(function(e){
		e.preventDefault()
		$('.err').remove()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_product',
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

				}else if(resp==3){
					$('#item_code').addClass('border-danger').trigger('focus')
                    $('#item_code').after('<span class="err text-danger"><small>Item Code Already exists.</small><br/></span>')
                	end_load();
                }else{
                    alert_toast('An error occured','error')
                	end_load();
                }
			}
		})
	})
	$('.edit_product').click(function(){
		start_load()
		var data = $(this).attr('data-json');
			data = JSON.parse(data)
		var cat = $('#manage-product')
		cat.get(0).reset()
		cat.find("[name='id']").val(data.id)
		cat.find("[name='item_code']").val(data.item_code)
		cat.find("[name='name']").val(data.name)
		cat.find("[name='description']").val(data.description)
		cat.find("[name='price']").val(data.price)
		cat.find("[name='size']").val(data.size)
		cat.find("[name='alert_min']").val(data.alert_min)
		cat.find("[name='alert_max']").val(data.alert_max)
		cat.find("[name='supplier_id']").val(data.supplier_id).trigger('change')

		end_load()
	})
	$('.delete_product').click(function(){
		_conf("Are you sure to delete this product?","delete_product",[$(this).attr('data-id')])
	})
	function delete_product($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_product',
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
	$('table').dataTable()
</script>