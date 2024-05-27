<?php

require "connection.php";

if (isset($_POST["txt"])) {
    if (isset($_POST["email"])) {
        if (isset($_POST["name"])) {
            
            $vcode = $_POST["txt"];
            $umail = $_POST["email"];
            $cname = $_POST["name"];

            $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email` = '".$umail."' ");
            $admin_num = $admin_rs->num_rows;

            if ($admin_num > 0) {

                $admin_data = $admin_rs->fetch_assoc();

                if ($admin_data["verification_code"] == $vcode) {

                    Database::iud("INSERT INTO `category` (`name`) VALUES ('".$cname."') ");
                    echo("Success");

                } else {

                    echo("Invalid Verification Code...");

                }
                

            } else {
                
                echo("Invalid User...");

            }
            

        }
    }
}

?>