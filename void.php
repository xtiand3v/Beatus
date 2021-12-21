<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = "Voided";

    $query = mysqli_query($conn,"INSERT INTO voided (sales_id,status,date_created) VALUES ('$id','$status',NOW())");

    if($query){
        ?>
        <script>
            alert("Sale voided");
            window.location.href = "index.php?page=sales";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Failed to void sales");
            window.location.href = "index.php?page=sales";
        </script>
        <?php

    }


}
