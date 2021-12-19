<?php include 'db_connect.php' ?>
<script src="./assets/js/chart.min.js" ></script>
<!-- <script src="./assets/js/Chart.bundle.min.js" ></script> -->
<script src="./assets/js/Chart.PieceLabel.js" ></script>
<div class="conntainer-fluid">
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <?php 
                    $items=array();
                    $sales=array();
                    $sales_stock_arr = array();
                    $sales_stock = $conn->query("SELECT inventory_ids FROM sales ");
                    while($row = $sales_stock->fetch_assoc()){
                        $ex = explode(',',$row['inventory_ids']);
                        foreach($ex as $v){
                            $sales_stock_arr[] = $v;
                        }
                    }
                    $swhere = count($sales_stock_arr) > 0 ? " and id in (". implode(',',$sales_stock_arr).") ":'';
                    $qry = $conn->query("SELECT * FROM items order by name asc");
                    while($row=$qry->fetch_assoc()){
                        $out = $conn->query("SELECT sum(qty) as stock FROM stocks where type = 2 and item_id =".$row['id'].$swhere);
                        $out = $out->num_rows > 0 ? $out->fetch_array()['stock'] : 0 ;
                        if($out > 0){
                            $items[$row['id']] = $row;
                            $sales[$row['id']] = $out;
                        }
                    }
                    ?>
                    <canvas id="myChart" ></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var taken_color = [];
var items = $.parseJSON('<?php echo json_encode($items) ?>');
var sales = $.parseJSON('<?php echo json_encode($sales) ?>');

function random_color(){
    var color = Math.floor(Math.random()*16777215).toString(16);
    if(taken_color.length > 0 && $.inArray(color,taken_color) >= 0){
        random_color()
        return false;
    }else{
        taken_color.push(color)
        return '#'+color;
    }
}
var labels = []
var values = []
var ovalues = []
var bg_arr = []
var total = 0
        Object.keys(sales).map(k=>{
            total += parseInt(sales[k])
        })
        Object.keys(sales).map(k=>{
            labels.push(items[k].name)
            val = (sales[k] / total) * 100;
            values.push(val)
            ovalues.push(sales[k])
            bg_arr.push(random_color())
        })
$(function(){
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [
            {
                data:values,
                odata:ovalues,
                backgroundColor:bg_arr
            }
            ]
    },
    options: {
        responsive:true,
        pieceLabel:{
            display: true,
            render:function(context){
                var label = context.label || '';
                var oval = context.dataset.odata[context.index] || 0;
                return label + ": "+oval;

            },
            position:'inside',
            fontColor:"#000",
            fontSize:"0",
            segment:true
        },
        plugins: {
            legend: {
                display: true,
                position:'left',
                padding:'20px',
                labels: {
                    color: 'rgb(255, 99, 132)'
                }
            },
            title:{
                display:true,
                text:"Analytics",
                position:'top',
                align:"center",
               
            },
            tooltip:{
                callbacks:{
                    label:function(context){
                        var label = context.label || '';
                        var oval = context.dataset.odata[context.dataIndex] || '';
                            oval = parseFloat(oval).toLocaleString('en-US') 
                        var value = context.dataset.data[context.dataIndex] || 0;
                            value = parseFloat(value).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2}) 
                            return label + ": "+oval+" ("+value+"%)";
                    }
                }
            }
        }
    }
});
})
</script>