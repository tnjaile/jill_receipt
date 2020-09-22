<?php
include "../../../include/cp_header.php";

$sort = 1;
foreach ($_POST['tr'] as $usn) {
    $sql = "update " . $xoopsDB->prefix("jill_unit") . " set `sort`='{$sort}' where `usn`='{$usn}'";
    $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")");
    $sort++;
}
echo "Sort saved! (" . date("Y-m-d H:i:s") . ")";
