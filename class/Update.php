<?php

namespace XoopsModules\Jill_receipt;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{

    public static function del_interface()
    {
        if (file_exists(XOOPS_ROOT_PATH . '/modules/jill_receipt/interface_menu.php')) {
            unlink(XOOPS_ROOT_PATH . '/modules/jill_receipt/interface_menu.php');
        }
    }
    //檢查某欄位是否存在
    public static function chk_chk1()
    {
        global $xoopsDB;
        $sql    = "show columns from " . $xoopsDB->prefix("jill_receipt") . " where Field='status' && Type='enum('0','1','2','3')' ";
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }
        return false;
    }

    //執行更新
    public static function go_update1()
    {
        global $xoopsDB;

        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_receipt") . " CHANGE `status` `status` enum('0','1','2','3') COLLATE 'utf8_general_ci' NOT NULL COMMENT '是否製單' AFTER `tax_id` ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

        return true;
    }
}
