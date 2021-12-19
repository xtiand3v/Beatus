<?php 
session_start();
ob_start();
include 'db_connect.php';
$order = $conn->query("SELECT * FROM sales where id = {$_GET['id']}");
foreach($order->fetch_array() as $k => $v){
	$$k= $v;
}
$user = $conn->query("SELECT * FROM users where id = {$_SESSION['login_id']}");
$data = $user->fetch_array();
$items = $conn->query("SELECT s.*,i.name FROM stocks s inner join items i on i.id=s.item_id where s.id in ($inventory_ids)");
?>

<style type="text/css" media="print">
	.flex{
		display: inline-flex;
		width: 100%;
	}
	.w-50{
		width: 50%;
	}
	.text-center{
		text-align:center;
	}
	.text-right{
		text-align:right;
	}
	table.wborder{
		width: 100%;
		border-collapse: collapse;
	}
	table.wborder>tbody>tr, table.wborder>tbody>tr>td{
		border:1px solid;
	}
	p{
		margin:unset;
	}

	@media print
      {
         @page {
           margin-top: 0;
           margin-bottom: 0;
         }
         body  {
           padding-top: 72px;
           padding-bottom: 72px ;
         }
      } 
</style>
<div class="container-fluid">
	<h3 class="text-center"><b>Receipt</b></h3>
	<hr>
	<div class="flex mt-5">
		<div class="w-100">
			Customer: <b><?php echo $data['name']; ?></b>
			<p>Date: <b><?php echo date("M d, Y h:i A",strtotime($date_created)) ?></b></p>
		</div>
	</div>
	<hr>
	<p><b>Purchased List</b></p>
	<table width="100%">
		<thead>
			<tr>
				<td><b>QTY</b></td>
				<td><b>Order</b></td>
				<td class="text-right"><b>Amount</b></td>
			</tr>
		</thead>
		<tbody>
			<?php 
			while($row = $items->fetch_assoc()):
			?>
			<tr>
				<td><?php echo $row['qty'] ?></td>
				<td><p><?php echo $row['name'] ?></p><?php if($row['qty'] > 0): ?><small>(<?php echo number_format($row['price'],2) ?>)</small> <?php endif; ?></td>
				<td class="text-right"><?php echo number_format($row['price'] * $row['qty'],2) ?></td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
	<hr>
	<table width="100%">
		<tbody>
			<tr>
				<td><b>Sub Total</b></td>
				<td class="text-right"><b><?php echo number_format($total_amount,2) ?></b></td>
			</tr>
			<tr>
				<td><b>Tax (12%)</b></td>
				<td class="text-right"><b><?php echo number_format($total_amount * 0.12,2) ?></b></td>
			</tr>
		<tr>
				<td><b>Grand Total</b></td>
				<td class="text-right"><b><?php echo number_format($total_amount + ($total_amount * 0.12),2) ?></b></td>
			</tr>

			<?php if($amount_tendered > 0): ?>

			<tr>
				<td><b>Amount Tendered</b></td>
				<td class="text-right"><b><?php echo number_format($amount_tendered,2) ?></b></td>
			</tr>
			<tr>
				<td><b>Change</b></td>
				<td class="text-right"><b><?php echo number_format($amount_tendered - ($total_amount + ($total_amount * 0.12)),2) ?></b></td>
			</tr>
		<?php endif; ?>
		
			
		</tbody>
	</table>
</div>