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

xoops_loadLanguage('modinfo_common', 'tadtools');

define('_MI_JILLRECEIP_NAME','Fill in receipt of receipt');
define('_MI_JILLRECEIP_AUTHOR','jill Lee');
define('_MI_JILLRECEIP_CREDITS','');
define('_MI_JILLRECEIP_DESC','The purpose of this module is to provide the cashier group to make a payment and delay platform to receive receipts');
define('_MI_JILLRECEIP_AUTHOR_WEB','Jill Development Website');
define('_MI_JILLRECEIP_ADMENU1','Main Management Interface');
define('_MI_JILLRECEIP_ADMENU1_DESC','Main Management Interface');

define('_MI_JILL_RECEIPT_SHOW_BLOCK_NAME','Bill preparation has been completed');
define('_MI_JILL_RECEIPT_SHOW_BLOCK_DESC','The billing block has been completed (jill_receipt_show)');

define('_MI_JILLRECEIP_ACCOUNT_SET','Set account');
define('_MI_JILLRECEIP_ACCOUNT_SET_DESC','Set account: 94438=Special account for collection; 94756=Special lunch account');

define('_MI_JILLRECEIP_RECEIPT_GROUP','Set up receipt reporting group');
define('_MI_JILLRECEIP_RECEIPT_GROUP_DESC','Set up receipt reporting group');

define('_MI_JILLRECEIP_RECEIPT_MANAGER','Set manager EMAIL');
define('_MI_JILLRECEIP_RECEIPT_MANAGER_DESC','Set receipt manager EMAIL (separated by semicolons): xx@xx.xx;xx@xx.xx');
