<?php
    include 'db_connect.php';
    $day = isset($_GET['day']) ? $_GET['day'] : date('Y-m-d');
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
				<div class="card-header text-center">
						<form method="GET" class="form-inline">
							<div class="input-group">
								<div class="input-group-addon">
									<small>From</small> &nbsp
								</div>
								<input type="date" class="form-control pull-right col-sm-12" placeholder="yyyy-MM-dd" name="from" max="<?php echo date("Y-m-d"); ?>" required id="from">
							</div>
							<Br>
							<Br>
							<div class="input-group">
								<div class="input-group-addon">&nbsp
									<small>To</small> &nbsp
								</div>
								&nbsp&nbsp<input type="date" placeholder="yyyy-MM-dd" class="form-control pull-right col-sm-12" name="to" max="<?php echo date("Y-m-d"); ?>" id="to">
								<input type="hidden" name="page" value="sales_report">
							</div>
							<input class="btn btn-sm btn-success ml-5" style="width:120px; background-color:#bc5449; color:white; border-color:#bc5449;height:30px; font-size:15px; letter-spacing:2px;" name="submit" type="submit" value="Submit">
						</form>
					</div>
            <div class="card_body">
                <?php 
                if(isset($_GET['from'])):
                ?>
                <div class="text-center">
                    <h3>Sales Report</h3>
                    <h4>From <?php echo date("F d, Y",strtotime($_GET['from'])); ?> to <?php echo date("F d, Y",strtotime($_GET['to'])); ?></h4>
                </div>
                <?php endif; ?>
            <div class="row justify-content-center pt-4">
                <label for="" class="mt-2">Daily</label>
                <div class="col-sm-3">
                    <input type="date" name="day" id="day" value="<?php echo $day ?>" max="<?php echo date('Y-m-d'); ?>" class="form-control">
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <table class="table table-bordered" id='report-list'>
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="">Date</th>
                            <th class="">Item Code</th>
                            <th class="">Item Name</th>
                            <th class="">Size</th>
                            <th class="">Price</th>
                            <th class="">QTY</th>
                            <th class="">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
			          <?php
                      $i = 1;
                      $total = 0;
                      if(isset($_GET['day'])){
                        $sales = $conn->query("SELECT * FROM sales s where s.amount_tendered > 0 and date(s.date_created) = '$day' order by unix_timestamp(s.date_created) asc ");
                    } elseif(isset($_GET['from'])) {
                        $from = $_GET['from'];
                        $to = $_GET['to'];
                        $sales = $conn->query("SELECT * FROM sales s where s.amount_tendered > 0 and s.date_created BETWEEN '$from' AND '$to' order by s.date_created desc");
                    } else {
                        $sales = $conn->query("SELECT * FROM sales s where s.amount_tendered > 0 and date(s.date_created) = '$day' order by unix_timestamp(s.date_created) asc ");
                    }
                      if($sales->num_rows > 0):
                      while($row = $sales->fetch_array()):
                        $items = $conn->query("SELECT s.*,i.name,i.item_code as code,i.size  FROM stocks s inner join items i on i.id=s.item_id where s.id in ({$row['inventory_ids']})");
                      while($roww = $items->fetch_array()):
                        $total += $roww['price']*$roww['qty'];
			          ?>
			          <tr>
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td>
                            <p> <b><?php echo date("M d,Y",strtotime($row['date_created'])) ?></b></p>
                        </td>
                        <td>
                            <p class="text-right"> <b><?php echo $roww['code'] ?></b></p>
                        </td>
                        <td>
                            <p class="text-right"> <b><?php echo $roww['name'] ?></b></p>
                        </td>
                        <td>
                            <p class="text-right"> <b><?php echo $roww['size'] ?></b></p>
                        </td>
                        <td>
                            <p class="text-right"> <b><?php echo number_format($roww['price'],2) ?></b></p>
                        </td>
                        <td>
                            <p class="text-right"> <b><?php echo $roww['qty'] ?></b></p>
                        </td>
                        <td>
                            <p class="text-right"> <b><?php echo number_format($roww['price']*$roww['qty'],2) ?></b></p>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    endwhile;
                        else:
                    ?>
                    <tr>
                            <th class="text-center" colspan="8">No Data.</th>
                    </tr>
                    <?php 
                        endif;
                    ?>
			        </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7" class="text-right">Total</th>
                            <th class="text-right"><?php echo number_format($total,2) ?></th>
                        </tr>
                    </tfoot>
                </table>
                <hr>
                <div class="col-md-12 mb-4">
						<?php 
                if(isset($_GET['from'] )):
                ?>
                <div class="text-center">
						<form method="POST" action="print/sales_print.php">
                        <input type="date" hidden value="<?php echo $_GET['from']; ?>" class="form-control pull-right col-sm-12" name="min" required id="min">
				<input type="date" hidden value="<?php if($_GET['to'] != ''): echo $_GET['to']; else: echo $_GET['from']; endif; ?>" class="form-control pull-right col-sm-12" name="max" id="max">
							<input class="btn btn-sm btn-success ml-5" style="width:150px; background-color:#bc5449; color:white; border-color:#bc5449;height:32px; font-size:18px; letter-spacing:2px;" name="print" type="submit" formtarget="_blank" value="Print">
                        </form>
                <?php else: 
                ?>
                <center>
                    <button class="btn btn-success btn-sm col-sm-3" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                </center>
                <?php endif; ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<noscript>
	<style>
		table#report-list{
			width:100%;
			border-collapse:collapse
		}
		table#report-list td,table#report-list th{
			border:1px solid
		}
        p{
            margin:unset;
        }
		.text-center{
			text-align:center
		}
        .text-right{
            text-align:right
        }
	</style>
</noscript>
<script>
$('#day').change(function(){
    location.replace('index.php?page=sales_report&day='+$(this).val())
})
$('#report-list').dataTable()
$('#print').click(function(){
            $('#report-list').dataTable().fnDestroy()
		var _c = $('#report-list').clone();
		var ns = $('noscript').clone();
            ns.append(_c)
		var nw = window.open('','_blank','width=900,height=600')
        nw.document.write('<p class="text-center"><b>Beatus')
		nw.document.write('<p class="text-center"><b>Sales Report as of <?php echo date("F d, Y",strtotime($day)) ?></b></p>')
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(() => {
			nw.close()
            $('#report-list').dataTable()
		}, 500);
	})
</script>