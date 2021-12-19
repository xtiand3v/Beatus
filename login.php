<?php 
ob_start();
session_start();
include('./db_connect.php');
// if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
// }
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Lobster&display=swap" rel="stylesheet">




</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
		letter-spacing:2px;
		font-size:18px;
		font-family: 'Roboto Slab', serif;
		
	}
	main{
		background-image: url('beatusbground.JPG');
		background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
	}
	.text-center{
		font-size:110px;
		font-family: 'Birthstone', cursive; font-family: 'Lobster', cursive;
		color:white;
	}
</style>

<body>
  <main id="main">
  	
  		<div class="align-self-center w-100 ;">
		<h1 class="text-center"> Beatus </b></h1>
  		<div id="login-center" style="opacity:0.6;" class="row justify-content-center">
  			<div class="card col-md-4" style="background-color:white;">
  				<div class="card-body">
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label"> <b> Username</label> </b>
  							<input type="text" style="border-color:black; border-radius:10px;" id="username" name="username" class="form-control">
  						</div>
						  
  						<div class="form-group">
					
  							<label for="password" control-label> <b> Password </b> </label>
							  
  							<input type="password" style="border-color:black; border-radius:10px; id="password name="password" class="form-control">
					
							<a href="user_recovery.php" style="font-size:15px;"> <b> Forgot Password? </b> </a>
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary" style="color:black; background-color:#ee959e; border-color:#ee959e; font-size:23px; height:40px; border-radius:10px;" required>  <b> Login </b> </button></center>
  					</form>
  				</div>
  			</div>
  		</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>

<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
	$('.number').on('input',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        $(this).val(val)
    })
</script>	
</html>