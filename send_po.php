<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $code = 1;
    $item_id = $_GET['id'];
    $supplier = $_GET['supplier'];
    $total = $_GET['total'];
    $price = $_GET['price'];
    $remarks = "Critical Stock";
    $status = 0;
    $quantity = 10;
    $po = mysqli_query($conn,"SELECT * FROM purchase_order order by po_code desc limit 1");
    if (mysqli_num_rows($po) > 0) {
        $code = str_replace('PO-', '', $po->fetch_array()['po_code']);
        $code += 1;
    }
    $po_code = 'PO-' . (sprintf("%'04d", $code));

    $query = mysqli_query($conn,"INSERT INTO purchase_order (po_code,supplier_id,total_cost,remarks,status,date_created) VALUES ('$po_code','$supplier','$total','$remarks','$status',NOW())");

    if($query){
        $getPO = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM purchase_order order by id desc limit 1"));
        $po_id = $getPO['id'];
        mysqli_query($conn,"INSERT INTO po_items (po_id,item_id,qty,price,date_created) VALUES ('$item_id','$item_id','$quantity','$price',NOW())");
        ?>
        <script>
            alert("Critical Item sent to PO");
            window.location.href = "index.php?page=purchase_order";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Failed to send critical item");
        </script>
        <?php

    }


}
