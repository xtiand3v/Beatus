<?php include "header.php" ?>
<style>body{background:unset !important}</style>
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
    $stock = $conn->query("SELECT s.*,i.name as iname,i.item_code as code,i.id as iid FROM stocks s inner join items i on i.id = s.item_id ".(isset($inventory_ids) ? "where s.id in ($inventory_ids)":"")." ");

}
?>
<h2 class="text-center">Receiving</h2>
<hr>
<div class="col-lg-12">
    <form id="manage-receiving">
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
        <?php 
        $items_arr = array();
        $total = 0;
            $items = $conn->query("SELECT * FROM items order by name asc");
            while($row = $items->fetch_assoc()):
                $items_arr[$row['supplier_id']][]=$row;
            endwhile; 
        ?>
        <div class="row">
            
            <table class="table table-bordered" id="prod-list">
                <thead>
                    <tr>
                        <th class="text-center" width="15%">Item Code</th>
                        <th class="text-center" width="25%">Product</th>
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
                            $total += $row['qty'] * $row['price'];
                    ?>
                    <tr data-id="<?php echo $row['item_id'] ?>">
                        <td class="text-center">
                            <b class="item_code"><?php echo isset($_GET['id'])? ucwords($row['code']) : $row['item_code'] ?></b>
                        </td>
                        <td class="">
                            <b class="pname"><?php echo isset($_GET['id'])? ucwords($row['iname']) : ucwords($row['name']) ?></b>
                        </td>
                        <td class="text-center">
                        <?php echo $row['qty'] ?>
                        </td>
                        <td class="text-center">
                        <?php echo isset($row['profit_perc']) ? $row['profit_perc'] : 0 ?>
                        </td>
                        <td class="text-center">
                        <?php echo number_format($row['price']) ?>
                        </td>
                        <td class="text-right">
                            <b class="amount text-right">
                                <?php echo number_format($row['price']*$row['qty']) ?>
                            </b>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" colspan="5"><b>Total</b></th>
                        <th class="text-right">
                            <input type="hidden" name="total_amount" value="0">
                            <b class="tamount" id="total_amount">                                            <?php echo number_format($total,2) ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        <hr>
    </form>
</div>
