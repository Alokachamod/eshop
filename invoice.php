<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice | eShop</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="resource/logo.svg">
</head>

<body>

    <div class="container-fluid">

        <div class="row">

            <?php include "header.php";

            

            if (isset($_SESSION["u"])) {
                $umail = $_SESSION["u"]["email"];
                $oid = $_GET["id"];

            ?>

                <div class="col-12">
                    <hr />
                </div>

                <div class="col-12 btn btn-toolbar justify-content-end">
                    <button class="btn btn-dark me-2" onclick="printInvoice();"><i class="bi bi-printer-fill"></i> Print</button>
                    <button class="btn btn-danger me-2"><i class="bi bi-filetype-pdf"></i> Export as PDF</button>

                </div>

                <div class="col-12">
                    <hr />
                </div>

                <div class="col-12" id="page">
                    <div class="row">

                        <div class="col-6">
                            <div class="ms-5 invoiceHeaderImage"></div>
                        </div>

                        <div class="col-6">
                            <div class="row">
                                <div class="col-12 text-primary text-decoration-underline text-end">
                                    <h2>eShop</h2>
                                </div>
                                <div class="col-12 fw-bold text-end">
                                    <span>Maradana, Colombo 10, Sri Lanka</span><br>
                                    <span>+94 112 215684</span><br>
                                    <span>eshop@gmail.com</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-1 border-primary" />
                        </div>

                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="fw-bold">Invoice to :</h5>
                                    <?php

                                    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $umail . "' ");
                                    $address_data = $address_rs->fetch_assoc();
                                    $city_rs = Database::search("SELECT * FROM `city` WHERE `id` = '" . $address_data["city_id"] . "' ");
                                    $city_data = $city_rs->fetch_assoc();

                                    ?>
                                    <h2><?php echo ($_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]); ?></h2>
                                    <span><?php echo ($address_data["line1"] . ", " . $address_data["line2"] . ", " . $city_data["name"]."."); ?></span><br>
                                    <span><?php echo ($umail); ?></span>
                                </div>

                                <?php

                                $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id` = '" . $oid . "' ");
                                $invoice_data = $invoice_rs->fetch_assoc();

                                ?>

                                <div class="col-6 text-end mt-4">
                                    <h1 class="text-primary">Invoice #0<?php echo($invoice_data["order_id"]); ?></h1>
                                    <span class="fw-bold">Date & Time of Invoice : </span><br>
                                    <span><?php echo($invoice_data["date"]); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr class="border border-1 border-secondary">
                                        <th>#</th>
                                        <th>Order ID & Product</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="height: 72px;">
                                        <td class="bg-primary text-white fs-3"><?php echo("1"); ?></td>
                                        <td>

                                            <?php
                                            
                                            $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '".$invoice_data["product_id"]."' ");
                                            $product_data = $product_rs->fetch_assoc();

                                            ?>

                                            <span class="fw-bold text-primary text-decoration-underline p-2"><?php echo($oid); ?></span><br>
                                            <span class="fw-bold text-primary fs-3 p-2"><?php echo($product_data["title"]); ?></span>
                                        </td>
                                        <td class="fw-bold fs-6 text-end pt-4 bg-secondary text-white">Rs. <?php echo($product_data["price"]); ?> .00</td>
                                        <td class="fw-bold fs-6 text-end pt-4"><?php echo($invoice_data["qty"]); ?></td>
                                        <td class="fw-bold fs-6 text-end pt-4 bg-secondary text-white">Rs. <?php echo($invoice_data["total"]); ?> .00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>

                                        <?php
                                        
                                        $delivery = "0";
                                        if ($city_data["district_id"] == 1) {

                                            $delivery = $product_data["delivery_fee_colombo"];

                                        } else {
                                            
                                            $delivery = $product_data["delivery_fee_other"];

                                        }

                                        $t = $invoice_data["total"];
                                        $g = $t - $delivery;

                                        ?>

                                        <td colspan="3" class="border-0 fs-5 text-end"></td>
                                        <td class="fs-5 fw-bold text-end">SUBTOTAL</td>
                                        <td class="text-end"><?php echo($g); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-0 fs-5 text-end"></td>
                                        <td class="fs-5 fw-bold text-end">Delivery Fee</td>
                                        <td class="text-end"><?php echo($delivery); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-0 fs-5 text-end"></td>
                                        <td class="fs-5 fw-bold text-end">GRAND TOTAL</td>
                                        <td class="text-end"><?php echo($g + $delivery ); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-4 text-center" style="margin-top: -100px;">
                            <span class="fs-1 fw-bold text-success">Thank You</span>
                        </div>

                        <div class="col-12 border-start border-5 border-primary mt-3 mb-3 rounded" style="background-color: #e7f2ff;">
                            <div class="row">
                                <div class="col-12 mt-3 mb-3">
                                    <label class="form-label fw-bold fs-5">NOTICE : </label><br>
                                    <label class="form-label fs-6">Purchase Item Can Return Before 7 Days Of Delivery</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-1 border-primary">
                        </div>

                        <div class="col-12 text-center mb-3">
                            <label class="form-label fs-5 text-black-50 fw-bold">
                                Invoice Was created on a computer and is valid without the signature and seal.
                            </label>
                        </div>

                    </div>
                </div>

            <?php
            }

            include "footer.php"; ?>

        </div>

    </div>



    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
</body>

</html>