<?php
header("Content-type: application/json");
include 'db_connect.php';

$query = mysqli_query($conn, "SELECT date_format(date_created,'%M') as month,sum(total_amount) as total FROM sales GROUP BY year(date_created),month(date_created) ORDER BY year(date_created),month(date_created)");
$data = array();
foreach ($query as $row) {
    $data[] = $row;
}

print json_encode($data);
?>