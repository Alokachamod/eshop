<?php

    session_start();

    require "connection.php";

    if (isset($_SESSION["p"])) {

        $pid = $_SESSION["p"]["id"];

        $title = $_POST["t"];
        $qty = $_POST["q"];
        $dwc = $_POST["dwc"];
        $doc = $_POST["doc"];
        $desciption = $_POST["d"];

        if (empty($title)) {
            echo("Please Add A Title To Your Product");
        } elseif (strlen($title)>=100) {
            echo("Title Should Have Less Than 100 Characters");
        } elseif (empty($qty)) {
            echo("Please Select The Quantity");
        } elseif ($qty == 0 | $qty == "e" | $qty < 0) {
            echo("Invalid Input For Quantity");
        } elseif (empty($dwc)) {
            echo("Please Enter The Delivery Fee For Colombo");
        } elseif (!is_numeric($dwc)){
            echo("Invalid Input For Delivery Cost Inside Colombo");
        } elseif (empty($doc)) {
            echo("Please Enter The Delivery Fee Outside Colombo");
        } elseif (!is_numeric($doc)){
            echo("Invalid Input For Delivery Cost Outside Colombo");
        } elseif (empty($desciption)) {
            echo("Please Enter A Product Description");
        } else {

            Database::iud("UPDATE `product` SET `title` = '".$title."', `qty` = '".$qty."', `delivery_fee_colombo` = '".$dwc."', 
            `delivery_fee_other` = '".$doc."', `description` = '".$desciption."' WHERE `id` = '".$pid."' ");
    
            echo("Product Has Been Updated...");


            $length = sizeof($_FILES);
            $allowed_img_extensions = array("image/jpg","image/jpeg","image/png","image/svg+xml");

            
            if ($length <= 3 && $length > 0) {
                
                Database::iud("DELETE FROM `images` WHERE `product_id` = '".$pid."' ");

                for ($x=0; $x < $length; $x++) { 
                    
                    if (isset($_FILES["i".$x])) {
                        
                        $img_file = $_FILES["i".$x];
                        $file_extension = $img_file["type"];

                        if (in_array($file_extension, $allowed_img_extensions)) {
                            

                            $new_file_extension;

                            if ( $file_extension == "image/jpg") {
                                $new_file_extension = ".jpg";
                            } elseif ( $file_extension == "image/jpeg") {
                                $new_file_extension = ".jpeg";
                            } elseif ( $file_extension == "image/png") {
                                $new_file_extension = ".png";
                            } elseif ( $file_extension == "image/svg+xml") {
                                $new_file_extension = ".svg";
                            }

                            $file_name = "resource/mobile_images/". $title ."_".$x."_".uniqid().$new_file_extension;
                            move_uploaded_file($img_file["tmp_name"],$file_name);


                            Database::iud("INSERT INTO `images` (`code`, `product_id`) VALUES ('".$file_name."','".$pid."') ");


                        } else {
                            
                            echo("Image Type Are Not Allowed");

                        }

                    }
                    
                }
                
            } else {
                
                echo(" Product Images Have Not Been Updated");

            }

        
        }

        

    } else {
        
        echo("Something Went Wrong. Please Try Again Later");

    }
