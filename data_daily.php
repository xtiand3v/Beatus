<?php
header("Content-type: application/json");
include 'db_connect.php';

$query = mysqli_query($conn, "SELECT date_format(date_created,'%b %d, %Y') as day,sum(total_amount) as total FROM sales GROUP BY day(date_created) ORDER BY date_created");
$data = array();
foreach ($query as $row) {
    $data[] = $row;
}

print json_encode($data);
?>