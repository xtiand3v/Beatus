<?php include "header.php" ?>
<style>body{background:unset !important}</style>
<?php include "db_connect.php" ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM return_order where id = ".$_GET['id']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
    $stock = $conn->query("SELECT s.*,i.name,i.item_code,i.id as iid FROM stocks s inner join items i on i.id = s.item_id ".(isset($inventory_ids) ? "where s.id in ($inventory_ids)":"")." ");

}
?>
<h2 class="text-center">Return Order</h2>
<hr>
<div class="col-lg-12">
	<form id="manage-purchase_order">
		<div class="row">
			<div class="form-group col-sm-6">
				<label class="control-label">R.O. Code</label>
				<div><?php echo isset($ro_code) ? $ro_code : '' ?></div>

			</div>
			<div class="form-group col-sm-6">
                <label class="control-label">Supplier</label>
                <?php 
                    $supplier = $conn->query("SELECT * FROM suppliers where id = '{$supplier_id}'")->fetch_array()['name'];
                
                ?>
                <div><?php echo isset($supplier) ? $supplier : '' ?></div>
            </div>
		</div>
			<hr>
			<table class="table table-bordered" id="prod-list">
				<thead>
					<tr>
						<th class="text-center" width="15%">Item Code</th>
						<th class="text-center" width="25%">Product</th>
						<th class="text-center" width="10%">QTY</th>
						<th class="text-center" width="15%">Unit Cost</th>
						<th class="text-center" width="25%">Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$total = 0;
						if(isset($stock)):
						while($row=$stock->fetch_assoc()):
						$total += $row['qty'] * $row['price'];
					?>
					<tr data-id="<?php echo $row['item_id'] ?>">
						<td class="text-center">
							<b class="item_code"><?php echo $row['item_code'] ?></b>
						</td>
						<td class="">
							<b class="pname"><?php echo ucwords($row['name']) ?></b>
						</td>
						<td class="text-center">
							<?php echo $row['qty'] ?>
						</td>
						<td class="text-center">
							<?php echo number_format($row['price']) ?>
						</td>
						<td class="text-right">
							<b class="amount text-right">
							<?php echo number_format($row['price'] * $row['qty']) ?>
							</b>
						</td>
					</tr>
					<?php endwhile; ?>
					<?php endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="text-center" colspan="4"><b>Total</b></th>
						<th class="text-right">
							<input type="hidden" name="total_amount" value="0">
							<b class="tamount" id="total_amount">
							<?php echo number_format($total,2) ?>
							</b>
						</th>
					</tr>
				</tfoot>
			</table>
			<div class="form-group col-sm-6">
				<label class="control-label">Remarks</label>
				<textarea rows="4" class="form-control form-control-sm " id="remarks" name="remarks" required style="resize:none"><?php echo isset($remarks) ? $remarks : '' ?></textarea>

			</div>
		<hr>
	</form>
			
</div>