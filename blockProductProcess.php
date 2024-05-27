<?php

require "connection.php";

if (isset($_GET["id"])) {

    $product_id = $_GET["id"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '".$product_id."' ");
    $product_num = $product_rs->num_rows;

    if ($product_num == 1) {
        
        $product_data = $product_rs->fetch_assoc();

        if ($product_data["status_id"] == 1) {
            
            Database::iud("UPDATE `product` set `status_id` = '2' WHERE `id` = '".$product_id."' ");
            echo("Blocked");

        } else {
            
            Database::iud("UPDATE `product` set `status_id` = '1' WHERE `id` = '".$product_id."' ");
            echo("Unblocked");

        }
        
        
    }else {
        echo("Cannot Find The product. Please Try Again Later...");
    }
    



} else {

    echo("Something Went Wrong...");

}
