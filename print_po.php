<?php include "header.php" ?>
<style>body{background:unset !important}</style>
<?php include "db_connect.php" ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM purchase_order where id = ".$_GET['id']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
	// echo "SELECT s.*,i.name as iname,i.item_code as code,i.id as iid FROM stocks s inner join items i on i.id = s.item_id ".(isset($inventory_ids) ? "where s.id in ($inventory_ids)":"");
	$stock = $conn->query("SELECT p.*,i.item_code,i.name FROM po_items p inner join items i on p.item_id = i.id  where p.po_id = '{$id}' ");
}
?>
<h2 class="text-center">Purchase Order</h2>
<hr>
<div class="col-lg-12">
    <form id="manage-purchase_order">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
            <div class="form-group col-sm-6">
                <label class="control-label">P.O. Code</label>
                <div><?php echo isset($po_code) ? $po_code : '' ?></div>

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
        <div id="p-form">
        <small class="text-muted">Add Product</small>
        <?php 
        $items_arr = array();
        $total = 0;
            $items = $conn->query("SELECT * FROM items order by name asc");
            while($row = $items->fetch_assoc()):
                $items_arr[$row['supplier_id']][]=$row;
            endwhile; 
        ?>
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
                        if(isset($stock)):
                        while($row=$stock->fetch_assoc()):
                            $total += $row['price']*$row['qty'];
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
                            <?php echo number_format($row['price']*$row['qty'],2) ?>
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
                            <b class="tamount" id="total_amount">                                        <?php echo number_format($total,2) ?>
                            </b>
                        </th>
                    </tr>
                </tfoot>
            </table>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="control-label">Remarks</label>
                    <div><?php echo isset($remarks) ? $remarks : '' ?></div>
                </div>
                <div class="form-group col-sm-6">
                <label for="" class="control-label">Status</label>
                <br>
                <?php if($status == 1): ?>
                    <span class="badge badge-success rounded-pill">Received</span>
                <?php elseif($status == 2): ?>
                    <span class="badge badge-warning rounded-pill">Partially Received</span>
                <?php else: ?>
                    <span class="badge badge-primary rounded-pill px-4">Pending</span>
                <?php endif; ?>
            </div>
            </div>
        <hr>
    </form>
</div>
<script>
	
</script>