<?php include 'db_connect.php' ?>
<script src="./assets/js/chart.min.js"></script>
<script src="./assets/js/Chart.PieceLabel.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&family=Roboto+Slab&display=swap" rel="stylesheet">


<style>
    span.float-right.summary_icon {
        font-size: 3rem;
        position: absolute;
        right: 1rem;
        top: 0;
    }


    .imgs {
        margin: .5em;
        max-width: calc(100%);
        max-height: calc(100%);
    }

    .imgs img {
        max-width: calc(100%);
        max-height: calc(100%);
        cursor: pointer;
    }

    #imagesCarousel,
    #imagesCarousel .carousel-inner,
    #imagesCarousel .carousel-item {
        height: 60vh !important;
        background: black;
    }

    #imagesCarousel .carousel-item.active {
        display: flex !important;
    }

    #imagesCarousel .carousel-item-next {
        display: flex !important;
    }

    #imagesCarousel .carousel-item img {
        margin: auto;
    }

    #imagesCarousel img {
        width: auto !important;
        height: auto !important;
        max-height: calc(100%) !important;
        max-width: calc(100%) !important;
    }

    table tbody td {
        vertical-align: middle !important;
    }

    thead {
        font-size: 16px;
        font-family: 'Raleway', sans-serif;
        font-family: 'Roboto Slab', serif;

    }

    tbody {
        font-size: 20px;
        font-family: 'Raleway', sans-serif;
        font-family: 'Roboto Slab', serif;
    }

    tr {
        border-color: black;
    }

    hr {
        border-color: #ee959e;
    }

    .card-body {
        font-size: 20px;
        font-family: 'Raleway', sans-serif;
        font-family: 'Roboto Slab', serif;
    }

    .badge {
        font-size: 16px;
        padding-top: 5px;
        padding-bottom: 5px;
        letter-spacing: 2px;
    }

    /*chart style*/
    #legend ul {
        list-style: none;
    }

    #legend ul li {
        display: inline;
        padding-left: 30px;
        position: relative;
        margin-bottom: 4px;
        /* border-radius: 5px;*/
        padding: 2px 8px 2px 28px;
        font-size: 14px;
        cursor: default;
        -webkit-transition: background-color 200ms ease-in-out;
        -moz-transition: background-color 200ms ease-in-out;
        -o-transition: background-color 200ms ease-in-out;
        transition: background-color 200ms ease-in-out;
    }

    #legend li span {
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 100%;
        /* border-radius: 5px;*/
    }
</style>

<div class="containe-fluid">
    <div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Welcome back " . $_SESSION['login_name'] . "!"  ?>

                    <?php if ($_SESSION['login_type'] == 1) : ?>
                        <hr>
                        <h3>Summary</h3>
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box p-3 text-white" style="background: #c38888;">
                                    <div class="inner">
                                        <?php
                                        $stmt = $conn->query("SELECT SUM(amount_tendered) as total FROM sales");
                                        $srow =  $stmt->fetch_assoc();

                                        $total = $srow['total'];

                                        echo "<h3>Php " . number_format($total, 2) . "</h3>";
                                        ?>
                                        <p>Total Sales</p>
                                    </div>
                                    <a href="index.php?page=sales_report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box p-3 text-white" style="background: #c38888;">
                                    <div class="inner">
                                        <?php
                                        $stmt = $conn->query("SELECT *, COUNT(*) AS numrows FROM items");
                                        $prow =  $stmt->fetch_assoc();

                                        echo "<h3>" . $prow['numrows'] . "</h3>";
                                        ?>

                                        <p>Number of Items</p>
                                    </div>
                                    <a href="index.php?page=products" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box p-3 text-white" style="background: #c38888;">
                                    <div class="inner">
                                        <?php
                                        $stmt = $conn->query("SELECT *, COUNT(*) AS numrows FROM users WHERE type != '1'");
                                        $urow =  $stmt->fetch_assoc();

                                        echo "<h3>" . $urow['numrows'] . "</h3>";
                                        ?>

                                        <p>Number of Users</p>
                                    </div>
                                    <a href="index.php?page=users" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box p-3 text-white" style="background: #c38888;">
                                    <div class="inner">
                                        <?php
                                        $today = date('Y-m-d');
                                        $stmt = $conn->query("SELECT SUM(total_amount) as total FROM sales WHERE date_created = '$today'");
                                        $ssales =  $stmt->fetch_assoc();

                                        $total = $ssales['total'];

                                        echo "<h3>Php " . number_format($total, 2) . "</h3>";

                                        ?>

                                        <p>Sales Today</p>
                                    </div>
                                    <a href="index.php?page=sales_report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                    <?php endif; ?>
                    <hr>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="myChart"></canvas>
                                <canvas id="myChart1"></canvas>
                                <canvas id="myChart2"></canvas>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered" id="inventorList">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center" style="border-color:#ee959e; font-size:22px;">Notifications</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Item Code</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $items = array();
                                        $sales = array();
                                        $sales_stock_arr = array();

                                        $sales_stock = $conn->query("SELECT inventory_ids FROM sales ");
                                        while ($row = $sales_stock->fetch_assoc()) {
                                            $ex = explode(',', $row['inventory_ids']);
                                            foreach ($ex as $v) {
                                                $sales_stock_arr[] = $v;
                                            }
                                        }
                                        $swhere = count($sales_stock_arr) > 0 ? " and id in (" . implode(',', $sales_stock_arr) . ") " : '';
                                        $qry = $conn->query("SELECT * FROM items order by name asc");
                                        while ($row = $qry->fetch_assoc()) :
                                            $inn = $conn->query("SELECT sum(qty) as stock FROM stocks where type = 1 and item_id =" . $row['id']);
                                            $inn = $inn->num_rows > 0 ? $inn->fetch_array()['stock'] : 0;
                                            $out = $conn->query("SELECT sum(qty) as stock FROM stocks where type = 2 and item_id =" . $row['id'] . $swhere);
                                            $out = $out->num_rows > 0 ? $out->fetch_array()['stock'] : 0;
                                            $available = $inn - $out;
                                            $items_id = $row['id'];
                                            $supplier_id = $row['supplier_id'];
                                            $price = $row['price'];
                                            $total = $row['price'] * 10;
                                            if ($out) {
                                                $items[$row['id']] = $row;
                                                $sales[$row['id']] = $out;
                                            }
                                            if ($available > $row['alert_min'] && $available < $row['alert_max'])
                                                continue;
                                        ?>
                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td>
                                                    <p class="m-0"><small>Code: <b><?php echo $row['item_code'] ?></b></small></p>
                                                    <p class="m-0"><small>Name: <b><?php echo $row['name'] . '-' . $row['size'] ?></b></small></p>
                                                </td>
                                                <td class="text-center"><?php echo number_format($available) ?></td>
                                                <td class="text-center">
                                                    <?php if ($available == 0) : ?>
                                                        <span class="badge badge-danger">Critical!</span>
                                                        <?php
                                                        $checkpo = $conn->query("SELECT * FROM po_items where item_id ='" . $row['id'] . "'");
                                                        if ($checkpo->num_rows > 1) :
                                                        ?>
                                                            <button type="button" class="btn btn-sm btn-info">Sent to PO</button>
                                                        <?php
                                                        else :
                                                        ?>
                                                            <a href="index.php?page=send_po&id=<?php echo $items_id; ?>&supplier=<?php echo $supplier_id; ?>&price=<?php echo $price; ?>&total=<?php echo $total; ?>" tooltip="Send to Product Order" class="btn btn-sm btn-success">Send to PO</a>

                                                        <?php

                                                        endif;
                                                        ?>
                                                    <?php elseif ($available <= $row['alert_min']) : ?>
                                                        <span class="badge badge-danger">Stock is Running Low</span>
                                                        <?php
                                                        $checkpo = $conn->query("SELECT * FROM po_items where item_id ='" . $row['id'] . "'");
                                                        if ($checkpo->num_rows > 1) :
                                                        ?>
                                                            <button type="button" class="btn btn-sm btn-info">Sent to PO</button>
                                                        <?php
                                                        else :
                                                        ?>
                                                            <a href="index.php?page=send_po&id=<?php echo $items_id; ?>&supplier=<?php echo $supplier_id; ?>&price=<?php echo $price; ?>&total=<?php echo $total; ?>" tooltip="Send to Product Order" class="btn btn-sm btn-success">Send to PO</a>

                                                        <?php

                                                        endif;
                                                        ?>
                                                    <?php elseif ($available >= $row['alert_max']) : ?>
                                                        <span class="badge badge-danger">Over Stock</span>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile;
                                        if ($qry->num_rows <= 0) :
                                        ?>
                                            <td colspan="4" class="text-center">No Alert</td>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
arsort($sales);
$osales = $sales;
$sales = array();
foreach ($osales as $k => $v) {
    $sales[] = array("id" => $k, "value" => $v);
}
?>
<script>
    $(function() {
        var taken_color = [];
        var items = $.parseJSON('<?php echo json_encode($items) ?>');
        var sales = $.parseJSON('<?php echo json_encode($sales) ?>');
        sales = sales.slice(0, 5)

        function random_color() {
            var color = Math.floor(Math.random() * 16777215).toString(16);
            if (taken_color.length > 0 && $.inArray(color, taken_color) >= 0) {
                random_color()
                return false;
            } else {
                taken_color.push(color)
                return '#' + color;
            }
        }
        var labels = []
        var values = []
        var ovalues = []
        var bg_arr = []
        var total = 0
        Object.keys(sales).map(k => {
            total += parseInt(sales[k].value)
        })
        Object.keys(sales).map(k => {
            labels.push(items[sales[k].id].name)
            val = (sales[k].value / total) * 100;
            values.push(val)
            ovalues.push(sales[k].value)
            bg_arr.push(random_color())
        })
        // console.log(JSON.stringify(values))
        // console.log(random_color())
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    odata: ovalues,
                    backgroundColor: bg_arr
                }]
            },
            options: {
                responsive: true,
                pieceLabel: {
                    render: function(context) {
                        // console.log(context)
                        var label = context.label || '';
                        var oval = context.dataset.odata[context.index] || 0;
                        return label + ": " + oval;

                    },
                    position: 'inside',
                    fontColor: "#000",
                    fontSize: "0",
                    segment: true
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    },
                    title: {
                        display: true,
                        text: "Top Five(5) Fast Moving Items",
                        position: 'top',
                        align: "center"
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var oval = context.dataset.odata[context.dataIndex] || '';
                                oval = parseFloat(oval).toLocaleString('en-US')
                                console.log(context)
                                var value = context.dataset.data[context.dataIndex] || 0;
                                value = parseFloat(value).toLocaleString('en-US', {
                                    style: 'decimal',
                                    maximumFractionDigits: 2
                                })
                                return label + ": " + oval + " (" + value + "%)";
                            }
                        }
                    }
                }
            }
        });
    })




    $(function() {
        var taken_color = [];
        var items = $.parseJSON('<?php echo json_encode($items) ?>');
        var sales = $.parseJSON('<?php echo json_encode($sales) ?>');
        sales = sales.slice(0, 10)

        function random_color() {
            var color = Math.floor(Math.random() * 16777215).toString(16);
            if (taken_color.length > 0 && $.inArray(color, taken_color) >= 0) {
                random_color()
                return false;
            } else {
                taken_color.push(color)
                return '#' + color;
            }
        }
        var labels = []
        var values = []
        var ovalues = []
        var bg_arr = []
        var total = 0
        Object.keys(sales).map(k => {
            total += parseInt(sales[k].value)
        })
        Object.keys(sales).map(k => {
            labels.push(items[sales[k].id].name)
            val = (sales[k].value / total) * 100;
            values.push(val)
            ovalues.push(sales[k].value)
            bg_arr.push(random_color())
        })
        // console.log(JSON.stringify(values))
        // console.log(random_color())
        var ctx = document.getElementById('myChart1').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    odata: ovalues,
                    backgroundColor: bg_arr
                }]
            },
            options: {
                responsive: true,
                pieceLabel: {
                    render: function(context) {
                        // console.log(context)
                        var label = context.label || '';
                        var oval = context.dataset.odata[context.index] || 0;
                        return label + ": " + oval;

                    },
                    position: 'inside',
                    fontColor: "#000",
                    fontSize: "0",
                    segment: true
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    },
                    title: {
                        display: true,
                        text: "Top Ten(10) Fast Moving Items",
                        position: 'top',
                        align: "center"
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var oval = context.dataset.odata[context.dataIndex] || '';
                                oval = parseFloat(oval).toLocaleString('en-US')
                                console.log(context)
                                var value = context.dataset.data[context.dataIndex] || 0;
                                value = parseFloat(value).toLocaleString('en-US', {
                                    style: 'decimal',
                                    maximumFractionDigits: 2
                                })
                                return label + ": " + oval + " (" + value + "%)";
                            }
                        }
                    }
                }
            }
        });
    })

    $(function() {

        var taken_color = [];
        var items = $.parseJSON('<?php echo json_encode($items) ?>');
        var sales = $.parseJSON('<?php echo json_encode($sales) ?>');
        sales = sales.slice(0, 15)

        function random_color() {
            var color = Math.floor(Math.random() * 16777215).toString(16);
            if (taken_color.length > 0 && $.inArray(color, taken_color) >= 0) {
                random_color()
                return false;
            } else {
                taken_color.push(color)
                return '#' + color;
            }
        }
        var labels = []
        var values = []
        var ovalues = []
        var bg_arr = []
        var total = 0
        Object.keys(sales).map(k => {
            total += parseInt(sales[k].value)
        })
        Object.keys(sales).map(k => {
            labels.push(items[sales[k].id].name)
            val = (sales[k].value / total) * 100;
            values.push(val)
            ovalues.push(sales[k].value)
            bg_arr.push(random_color())
        })
        // console.log(JSON.stringify(values))

        // console.log(random_color())
        var ctx = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    odata: ovalues,
                    backgroundColor: bg_arr
                }]
            },
            options: {
                responsive: true,
                pieceLabel: {
                    render: function(context) {
                        // console.log(context)
                        var label = context.label || '';
                        var oval = context.dataset.odata[context.index] || 0;
                        return label + ": " + oval;

                    },
                    position: 'inside',
                    fontColor: "#000",
                    fontSize: "0",
                    segment: true
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    },
                    title: {
                        display: true,
                        text: "Top Fifteen(15) Fast Moving Items",
                        position: 'top',
                        align: "center"
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var oval = context.dataset.odata[context.dataIndex] || '';
                                oval = parseFloat(oval).toLocaleString('en-US')
                                console.log(context)
                                var value = context.dataset.data[context.dataIndex] || 0;
                                value = parseFloat(value).toLocaleString('en-US', {
                                    style: 'decimal',
                                    maximumFractionDigits: 2
                                })
                                return label + ": " + oval + " (" + value + "%)";
                            }
                        }
                    }
                }
            }
        });
    })
</script>

<!-- <script>
$(function(){
  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChart = new Chart(barChartCanvas)
  var barChartData = {
    labels  : ["January", "February", "March", "April", "May", "June"],
    datasets: [
      {
        label               : 'SALES',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [10, 20, 30, 40, 50, 60]
      }
    ]
  }
  //barChartData.datasets[1].fillColor   = '#00a65a'
  //barChartData.datasets[1].strokeColor = '#00a65a'
  //barChartData.datasets[1].pointColor  = '#00a65a'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  var myChart = barChart.Bar(barChartData, barChartOptions)
  document.getElementById('legend').innerHTML = myChart.generateLegend();
});
</script> -->