<?php
/**
 * Jill Receipt module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Receipt
 * @since      2.5
 * @author     jaile
 * @version    $Id $
 **/

/********************* 自訂函數 *********************/
//檢查是否具有預約權限
function receipt_perm()
{
    global $xoopsUser, $xoopsModuleConfig, $isAdmin;
    $can_receipt = false;
    if ($xoopsUser) {
        if ($isAdmin) {
            return true;
            exit;
        }
        $needle_groups   = $xoopsUser->groups();
        $haystack_groups = $xoopsModuleConfig['receipt_group'];
        //die(var_export($needle_groups) . "==" . var_export($haystack_groups));
        foreach ($needle_groups as $key => $group) {
            if (in_array($group, $haystack_groups)) {
                return true;
            }
        }
    }
    return false;
}
//檢查是否具有管理權限
function receipt_manager()
{
    global $xoopsUser, $xoopsModuleConfig, $isAdmin;
    if ($xoopsUser) {
        $uemail = $xoopsUser->email();
        //避免填入空白
        $editorEmail = str_replace(" ", "", $xoopsModuleConfig['receipt_manager']);
        $editor_arr  = explode(";", $editorEmail);
        if (in_array($uemail, $editor_arr) or $isAdmin) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}
if (!function_exists("get_status_name")) {
    //以$status取得是否製單資料
    function get_status_name($status = 0)
    {
        switch ($status) {
            case '1':
                $status_name = _MD_JILLRECEIP_STATUS1;
                break;
            case '2':
                $status_name = _MD_JILLRECEIP_STATUS2;
                break;
            case '3':
                $status_name = _MD_JILLRECEIP_STATUS3;
                break;
            default:
                $status_name = _MD_JILLRECEIP_STATUS0;
                break;
        }
        return $status_name;
    }
}
