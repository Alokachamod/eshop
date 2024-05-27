<?php

require "connection.php";

if ($_GET["b"] != 0) {

    $brand_id = $_GET["b"];

    $bhm_rs = Database::search("SELECT * FROM `brand_has_model`  WHERE `brand_id` = '" . $brand_id . "' ");
    $bhm_num = $bhm_rs->num_rows;

?>

    <option value="0">Select Model</option>

    <?php

    if ($bhm_num > 0) {
        for ($x = 0; $x < $bhm_num; $x++) {

            $bhm_data = $bhm_rs->fetch_assoc();

            $m_id = $bhm_data["model_id"];

            $model_rs = Database::search("SELECT * FROM `model` WHERE `id` = '" . $m_id . "'");
            $model_num = $model_rs->num_rows;

            if ($model_num > 0) {

                $model_data = $model_rs->fetch_assoc();

    ?>

                <option value="<?php echo ($model_data["id"]); ?>"><?php echo ($model_data["name"]); ?></option>

    <?php

            }
        }
    }
} else if ($_GET["b"] == 0) {

    ?>

    <option value="0">Select Model</option>

    <?php

    $all_brand_rs = Database::search("SELECT * FROM `brand` ORDER BY `name` ASC ");
    $all_brand_num = $all_brand_rs->num_rows;

    for ($y = 0; $y < $all_brand_num; $y++) {
        $all_brand_data = $all_brand_rs->fetch_assoc();

    ?>

        <option value="<?php echo ($all_brand_data["id"]); ?>"><?php echo ($all_brand_data["name"]); ?></option>

<?php
    }
}

?>