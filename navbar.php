<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">

<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
	.sidebar-list{
	font-family:'Merriweather', serif;
	font-size: 17px;
	background-color:#ee959e;
	margin-top:0px;
	}
	.cc{
	margin-left:38px;	
	padding-top:7px;
	padding-bottom:7px;
	}
	.dd{
		background-color:#ee959e;
	}
	.mx-2{
		font-size:21px;
	}
</style>

<nav id="sidebar" style="overflow:auto">
<div class="dd">
	<div class="cc">
	<img src="d3.PNG" style="height:110px;">
</div>

</div>
	
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
				<a href="index.php?page=sales" class="nav-item nav-sales"><span class='icon-field'><i class="fa fa-clipboard-list "></i></span> Sales</a>
				<a href="pos/index.php" class="nav-item nav-pos"><span class='icon-field'><i class="fa fa-file-invoice "></i></span> Point of Sales</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<div class="mx-2 text-white">Inventory</div>
				<a href="index.php?page=purchase_order" class="nav-item nav-purchase_order"><span class='icon-field'><i class="fa fa-th-list "></i></span>PurchaseOrder</a>
				<a href="index.php?page=receiving" class="nav-item nav-receiving"><span class='icon-field'><i class="fa fa-list-alt "></i></span> Receiving</a>
				<a href="index.php?page=inventory" class="nav-item nav-inventory"><span class='icon-field'><i class="fa fa-list "></i></span> Inventory</a>
				<a href="index.php?page=back_order" class="nav-item nav-back_order"><span class='icon-field'><i class="fa fa-th-list "></i></span> Back Order</a>
				<a href="index.php?page=return_order" class="nav-item nav-return_order"><span class='icon-field'><i class="fa fa-list "></i></span> Return Order</a>
				<div class="mx-2 text-white">Master List</div>
				<a href="index.php?page=suppliers" class="nav-item nav-suppliers"><span class='icon-field'><i class="fa fa-list-alt "></i></span> Suppliers</a>
				<a href="index.php?page=products" class="nav-item nav-products"><span class='icon-field'><i class="fa fa-tshirt "></i></span> Products</a>
				<?php endif; ?>
				<div class="mx-2 text-white">Report</div>
				<a href="index.php?page=sales_report" class="nav-item nav-sales_report"><span class='icon-field'><i class="fa fa-th-list"></i></span> Sales Report</a>
				<a href="index.php?page=sales_statistic" class="nav-item nav-sales_statistic"><span class='icon-field'><i class="fa fa-th-list"></i></span> Analytics</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<div class="mx-2 text-white">Systems</div>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users "></i></span> Users</a>
				<!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> System Settings</a> -->
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
