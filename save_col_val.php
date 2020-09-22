<?php
use Xmf\Request;
include "header.php";

if (!$can_manager) {
    die(_MD_JILLRECEIP_ILLEGAL);
}

$value           = Request::getString('value');
$id              = Request::getString('id');
list($col, $rsn) = explode(':', $id);
$sql             = "update " . $xoopsDB->prefix("jill_receipt") . " set $col='{$value}' where rsn='{$rsn}'";
$xoopsDB->queryF($sql);
if ($col == 'status') {
    $value = get_status_name($value);
}

echo $value;
