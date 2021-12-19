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
			<form action="" id="manage-supplier">
				<div class="card">
					<div class="card-header" style=" font-size:20px; font-family:'Merriweather', serif; letter-spacing:2px; background-color:white; border-color:#ee959e; padding-left:190px;">
						   <b>  Supplier Form </b>
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Name</label>
								<input type="text" style="border-color:black;" class="form-control" name="name" required>
							</div>
							<div class="form-group">
								<label class="control-label">Contact</label>
								<input type="text" style="border-color:black;" class="form-control" name="contact" required>
							</div>
							<div class="form-group">
								<label class="control-label">Contact Person</label>
								<input type="text" style="border-color:black;" class="form-control" name="contact_person" required>
							</div>
							<div class="form-group">
								<label class="control-label">Address</label>
								<textarea name="address" style="border-color:black;"id="address" cols="30" rows="4" class="form-control" required></textarea>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3" style="width:80px; border-radius:5px; background-color:#ee959e; color:white; border-color:#ee959e; height:25px; font-size:15px;"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-supplier').get(0).reset()"> Cancel</button>
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
					<div class="card-header" style=" font-size:20px; font-family:'Merriweather', serif; padding-left:500Px; letter-spacing:2px; background-color:white; border-color:#ee959e;">
						<b>Supplier List</b>
					</div>
					<div class="card-body" style="font-size:17px;">
						<table class="table table-bordered table-hover" style="border-color:black;">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Supplier Info.</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$supplier = $conn->query("SELECT * FROM suppliers order by id asc");
								while($row=$supplier->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p>Name: <b><?php echo $row['name'] ?></b></p>
										<p><small>Contact: <b><?php echo $row['contact'] ?></b></small></p>
										<p><small>Contact Person: <b><?php echo $row['contact_person'] ?></b></small></p>
										<p><small>Address: <b><?php echo $row['address'] ?></b></small></p>
										
									
								
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_supplier"  style="width:80px; border-radius:5px; background-color:#c38888; color:white; border-color:#c38888; height:25px; font-size:15px;"  type="button" data-id="<?php echo $row['id'] ?>" data-address="<?php echo $row['address'] ?>" data-name="<?php echo $row['name'] ?>"  data-contact="<?php echo $row['contact'] ?>"  data-contact_person="<?php echo $row['contact_person'] ?>" >Edit</button>
										<button class="btn btn-sm btn-danger delete_supplier" style="width:80px; border-radius:5px; background-color:#990f02; color:white; border-color:#990f02; height:25px; font-size:15px;" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
</style>
<script>
	$('#manage-supplier').on('reset',function(){
		$('input:hidden').val('')
	})
	
	$('#manage-supplier').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_supplier',
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
	$('.edit_supplier').click(function(){
		start_load()
		var cat = $('#manage-supplier')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='address']").val($(this).attr('data-address'))
		cat.find("[name='contact']").val($(this).attr('data-contact'))
		cat.find("[name='contact_person']").val($(this).attr('data-contact_person'))

		end_load()
	})
	$('.delete_supplier').click(function(){
		_conf("Are you sure to delete this supplier?","delete_supplier",[$(this).attr('data-id')])
	})
	function delete_supplier($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_supplier',
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