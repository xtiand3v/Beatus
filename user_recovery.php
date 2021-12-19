<?php 
session_start();
include('./db_connect.php');
ob_start();
// if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
// }
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['username'])){
        $qry = $conn->query("SELECT * FROM users where username = '{$_POST['username']}'");
        if($qry->num_rows > 0){
            $res = $qry->fetch_assoc();
        header("location:user_recovery.php?uid=".md5($res['id']));
        }else{
            $errmsg = "Unkown Username";
        }
    }
    if(isset($_POST['recovery_answer'])){
        $qry = $conn->query("SELECT * FROM users where id = '{$_POST['id']}' and recovery_answer = '{$_POST['recovery_answer']}' ");
        if($qry->num_rows > 0){
            $res = $qry->fetch_assoc();
            foreach($res as $k => $v){
                $$k=$v;
            }
            header('location:user_recovery.php?rid='.md5($id));
        }else{
            $errmsg = "Wrong Answer";
        }
    }
    if(isset($_POST['password'])){
        if($_POST['password'] != $_POST['retypePass']){
            $errmsg = "Password do not match.";
        }else{
            $update = $conn->query("UPDATE users set `password` = md5('{$_POST['password']}') where md5(id) = '{$_GET['rid']}' ");
            if($update){
                $sucmsg ="Password successfully changed.";
            }else{
                $errmsg = "Please try again";
            }
        }
        
    }
}
if(isset($_GET['uid'])){
    $qry = $conn->query("SELECT * FROM users where md5(id) = '{$_GET['uid']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_assoc();
        foreach($res as $k => $v){
            $$k=$v;
        }
    }
}
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

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}

</style>

<body class="bg-dark">


  <main id="main" >
  	<?php  if(!isset($_GET['uid']) && !isset($_GET['rid'])): ?>
  		<div class="align-self-center w-100">
            <h4 class="text-white text-center"><b>User Recovery</b></h4>
            <div id="login-center" class="bg-dark row justify-content-center">
                <div class="card col-md-4">
                    <div class="card-body">
                    
                        <form method="POST" action="" id="recovery-user-form" >
                            <?php if(isset($errmsg) && !empty($errmsg)): ?>
                            <div class="alert alert-danger"><?php echo $errmsg ?></div>
  	                        <?php endif; ?>
                            <div class="form-group">
                                <label for="username" class="control-label">Please Enter Username</label>
                                <input type="text" id="username" name="username"  value="<?php echo isset($_POST['username']) ? $_POST['username'] :'' ?>" class="form-control" required>
                            </div>
                            <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Recover</button></center>
                        </form>
                    </div>
                </div>
            </div>
  		</div>
  	<?php elseif(isset($_GET['uid'])): ?>
        <div class="align-self-center w-100">
            <h4 class="text-white text-center"><b>User Recovery</b></h4>
            <div id="login-center" class="bg-dark row justify-content-center">
                <div class="card col-md-4">
                    <div class="card-body">
                    
                        <form method="POST" action="" id="recovery-question-form" >
                            <?php if(isset($errmsg) && !empty($errmsg)): ?>
                            <div class="alert alert-danger"><?php echo $errmsg ?></div>
  	                        <?php endif; ?>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <p>Please Answer the question below.</p>
                            <p><?php echo $recovery_question ?>?</p>
                            <div class="form-group">
                                <label for="recovery_answer" class="control-label">Answer</label>
                                <textarea type="text" id="recovery_answer" name="recovery_answer" class="form-control" required></textarea>
                            </div>
                            <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Submit</button></center>
                        </form>
                    </div>
                </div>
            </div>
  		</div>
          <?php elseif(isset($_GET['rid']) && !isset($sucmsg)): ?>
        <div class="align-self-center w-100">
            <h4 class="text-white text-center"><b>Change Password</b></h4>
            <div id="login-center" class="bg-dark row justify-content-center">
                <div class="card col-md-4">
                    <div class="card-body">
                    
                        <form method="POST" action="" id="recovery-question-form" >
                            <?php if(isset($errmsg) && !empty($errmsg)): ?>
                            <div class="alert alert-danger"><?php echo $errmsg ?></div>
  	                        <?php endif; ?>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <div class="form-group">
                                <label for="password" class="control-label">New Password</label>
                                <input type="password" id="password" name="password"  value="<?php echo isset($_POST['password']) ? $_POST['password'] :'' ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="retypePass" class="control-label">Please Enter retypePass</label>
                                <input type="password" id="retypePass" name="retypePass"  value="<?php echo isset($_POST['retypePass']) ? $_POST['retypePass'] :'' ?>" class="form-control" required>
                            </div>
                            <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Update</button></center>
                        </form>
                    </div>
                </div>
            </div>
  		</div>
          <?php elseif(isset($_GET['rid']) && isset($sucmsg)): ?>
            <div class="align-self-center w-100 justify-content-center d-flex">
                <div class="card col-md-4">
                    <div class="card-body">
                    <?php if(isset($sucmsg) && !empty($sucmsg)): ?>
                        <div class="alert alert-success"><?php echo $sucmsg ?></div>
                        <?php endif; ?>
                        <center><a href="login.php" class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login Now</a></center>
                    </div>
                </div>
  		    </div>


  	<?php endif; ?>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	
	$('.number').on('input',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        $(this).val(val)
    })
</script>	
</html>