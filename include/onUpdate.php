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
use XoopsModules\Jill_receipt\Update;
use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Jill_receipt\Update')) {
    include dirname(__DIR__) . '/preloads/autoloader.php';
}
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}
function xoops_module_update_jill_receipt(&$module, $old_version)
{
    global $xoopsDB;
    Update::del_interface();
    if (Update::chk_chk1()) {
        Update::go_update1();
    }

    return true;
}
