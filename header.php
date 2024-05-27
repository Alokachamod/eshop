<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div class="col-12">
        <div class="row mt-1 mb-1">

            <div class="offset-lg-1 col-12 col-lg-4 align-self-start mt-2">

                <?php

                session_start();

                if (isset($_SESSION["u"])) {
                    $data = $_SESSION["u"];

                ?>

                    <span class="text-lg-start"><b>Welcome </b><?php echo $data["fname"]; ?></span> |
                    <span class="text-lg-start fw-bold signout" onclick="signout();">Sign Out</span> |

                <?php

                } else {

                ?>

                    <a href="index.php" class="text-decoration-none fw-bold">Sign In or Register</a> |

                <?php

                }

                ?>


                <span class="text-lg-start fw-bold">Help and Contact</span>

            </div>

            <div class="offset-lg-4 col-12 col-lg-3 align-self-end">
                <div class="row">

                    <div class="col-1 col-lg-3 mt-2">
                        <span class="text-start fw-bold">Sell</span>
                    </div>

                    <div class="col-2 col-lg-6 dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            My eShop
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="userProfile.php">My Profile</a></li>
                            <li><a class="dropdown-item" href="#">My Settings</a></li>
                            <li><a class="dropdown-item" href="myProducts.php">My Products</a></li>
                            <li><a class="dropdown-item" href="watchlist.php">Watchlist</a></li>
                            <li><a class="dropdown-item" href="purchasingHistory.php">Purchase History</a></li>
                            <li><a class="dropdown-item" href="message.php">Massege</a></li>
                            <li><a class="dropdown-item" href="#" onclick="contactAdmin('<?php echo ($_SESSION['u']['email']); ?>');">Contact Admin</a></li>
                        </ul>
                    </div>

                    <div class="col-1 col-lg-3 ms-5 ms-lg-0 mt-1 cart-icon" onclick="window.location='cart.php';"></div>

                    <!-- Msg Modal -->
                    <div class="modal" tabindex="-1" id="contactAdmin">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body overflow-scroll">

                                    <?php
                                    require "connection.php";

                                    $chat_rs = Database::search("SELECT * FROM `chat` WHERE `from` = '" . $_SESSION["u"]["email"] . "' OR `to` = '" . $_SESSION["u"]["email"] . "'");
                                    $chat_num = $chat_rs->num_rows;

                                    for ($x = 0; $x < $chat_num; $x++) {
                                        $chat_data = $chat_rs->fetch_assoc();

                                        if ($chat_data["to"] == $_SESSION["u"]["email"]) {
                                    ?>

                                            <!-- Recieved -->
                                            <div class="col-12 mt-2">
                                                <div class="row">
                                                    <div class="col-8 rounded bg-success">
                                                        <div class="row">
                                                            <div class="col-12 pt-2">
                                                                <span><?php echo $chat_data ["content"] ?></span>
                                                            </div>
                                                            <div class="col-12 text-end pb-2">
                                                                <span class="text-white fs-6"><?php echo $chat_data ["date_time"] ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Recieved -->

                                        <?php
                                        } else if ($chat_data["from"] == $_SESSION["u"]["email"]) {
                                        ?>

                                            <!-- Sent -->
                                            <div class="col-12 mt-2">
                                                <div class="row">
                                                    <div class="offset-4 col-8 rounded bg-primary">
                                                        <div class="row">
                                                            <div class="col-12 pt-2">
                                                                <span><?php echo $chat_data ["content"] ?></span>
                                                            </div>
                                                            <div class="col-12 text-end pb-2">
                                                                <span class="text-white fs-6"><?php echo $chat_data ["date_time"] ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Sent -->
                                            
                                    <?php

                                        }
                                    }

                                    ?>

                                </div>
                                <div class="modal-footer ">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="msgTxt">
                                            </div>
                                            <div class="col-3">
                                                <button class="btn btn-primary" onclick="sendAdminMsg('<?php echo $_SESSION['u']['email'] ?>');">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Msg Modal -->

                </div>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>