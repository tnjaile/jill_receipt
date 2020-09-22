<?php
include "../../../include/cp_header.php";

$sort = 1;
foreach ($_POST['tr'] as $rsn) {
    $sql = "update " . $xoopsDB->prefix("jill_receipt") . " set ``='{$sort}' where `rsn`='{$rsn}'";
    $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")");
    $sort++;
}
echo "Sort saved! (" . date("Y-m-d H:i:s") . ")";
