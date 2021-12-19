<?php include "db_connect.php" ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT b.*,p.po_code FROM back_order b inner join purchase_order p on b.po_id = p.id where b.id = ".$_GET['id']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
    $stock = $conn->query("SELECT b.*,i.item_code,i.name FROM bo_items b inner join items i on b.item_id = i.id  where b.bo_id = '{$id}' ");

}
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&family=Roboto+Slab&display=swap" rel="stylesheet">


<style>
	hr{
		border-color:#ee959e;
	}
	.card{
	
	border-color:#ee959e;
	font-family: 'Raleway', sans-serif;
	font-family: 'Roboto Slab', serif;
	border-radius:10px;
	font-size:15px;
}
.badge{
	font-size:13px;
	padding-top:5px;
	padding-bottom:5px;
	letter-spacing:2px;
}


</style>

<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<div class="col-md-12">
				<form id="outprint">
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="control-label">B.O. Code</label>
							<div><?php echo $bo_code ?></div> <br>
                            <label class="control-label">P.O. Code</label>
							<div><?php echo $po_code ?></div>

						</div>
						<div class="form-group col-sm-6">
							<label class="control-label">Supplier</label>
                            <?php 
								$supplier = $conn->query("SELECT * FROM suppliers where id = '{$supplier_id}'")->fetch_array()['name'];
                            
                            ?>
							<div><?php echo $supplier ?></div>
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
										<b class="amount text-right"><?php echo number_format($row['price'] * $row['qty']) ?></b>
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
										<b class="tamount" id="total_amount"><?php echo number_format($total,2) ?></b>
									</th>
								</tr>
							</tfoot>
						</table>
                        <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="" class="control-label">Remarks</label>
							<p><?php echo isset($remarks) ? $remarks : '' ?></p>
						</div>
                        <div class="form-group col-sm-6">
                            <label for="" class="control-label">Status</label>
                            <br>
                            <?php if($status == 1): ?>
                                <span class="badge badge-success rounded-pill">Received</span>
                            <?php else: ?>
                                <span class="badge badge-primary rounded-pill px-4">Pending</span>
                            <?php endif; ?>
						</div>
                        </div>
					<hr>
					
				</form>
                <div class="col-md-12 text-center">
                        <?php if($status != 1): ?>
						<button class="btn btn-sm btn-warning col-sm-3" style="width:300px; border-radius:5px; background-color:#D291BC; border-color:#d291bc; color:white; height:25px; font-size:15px;" type="button" id="receive">Receive</button>
                        <?php endif; ?>
						<button class="btn btn-sm btn-success col-sm-3" style="width:300px; border-radius:5px; background-color:#bc5449; border-color:#bc5449; color:white; height:25px; font-size:15px;" type="button" id="print">Print</button>
					</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(function(){
    $('#receive').click(function(){
        var _conf =confirm('Are you sure to receive this Back Order? This process cannot be undone.')
        if(_conf == true){
            start_load();
            $.ajax({
                url:'ajax.php?action=receive_bo',
                data:{id:'<?php echo $id ?>'},
                method:'POST',
                dataType:'json',
                error:function(err){
                   alert_toast('An error occured','danger')
                    end_load();
                },
                success:function(resp){
                    if(resp.status == 'success'){
                     alert_toast('B.O. Successfully Received','success')
                     setTimeout(() => {
                         location.reload()
                     }, 1500);
                        
                    }else{
                        alert_toast('An error occured','danger')
                        end_load(); 
                    }
                }
            })
        }
        
    })
    $('#print').click(function(){
            start_load();
            var h = $('head').clone()
            var p = $('#outprint').clone()
            var el = $('<div>')
            h.find('title').text('Back Order Print View')
            el.append(h)
            el.append('<h2 class="text-center">Back Order</h2><hr/>')
            p.find('.col-md-6').addClass('.col-6')
            el.append(p)
            el.prepend('<style>body{background:unset !important}</style>')
            var nw = window.open("","","height=900,width=1200,left=75,top=25")
                nw.document.write(el.html())
                nw.document.close()
                
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                        end_load()
                    }, 200);
                }, 500);
        })
    })
</script>