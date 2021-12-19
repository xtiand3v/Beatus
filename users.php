<?php 

?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&family=Roboto+Slab&display=swap" rel="stylesheet">


<style>

.card-header{
	font-size:20px;
	padding-left:750px;
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
<div class="container-fluid">
	
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm"  style="border-radius:5px; width:150px; background-color:#ee959e; color:white; border-color:#ee959e; height:40px; padding-top:5px; font-size:17px; margin-right:20px; padding-top:2px;"  id="new_user"><i class="fa fa-plus"></i> New user</button>
	</div>
	</div>
	<br>
	<div class="col-lg-12">
		<div class="card ">
			<div class="card-header"><b>User List</b></div>
			<div class="card-body">
				<table class="table-striped table-bordered" style="border-color:black;">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Name</th>
					<th class="text-center">Username</th>
					<th class="text-center">Type</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$type = array("","Admin","Staff","Alumnus/Alumna");
 					$users = $conn->query("SELECT * FROM users order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td>
				 		<?php echo ucwords($row['name']) ?>
				 	</td>
				 	
				 	<td>
				 		<?php echo $row['username'] ?>
				 	</td>
				 	<td>
				 		<?php echo $type[$row['type']] ?>
				 	</td>
				 	<td>
				 		<center>
							<div class="btn-group" >
							  <button type="button"  class="btn btn-primary btn-sm">Action</button>
							  <button type="button"  class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <span class="sr-only">Toggle Dropdown</span>
							  </button>
							  <div class="dropdown-menu">
							    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
							    <div class="dropdown-divider"></div>
							    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
							  </div>
							</div>
						</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	$('table').dataTable();
$('#new_user').click(function(){
	uni_modal('New User','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
		_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
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
</script>