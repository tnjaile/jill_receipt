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
xoops_loadLanguage('main', 'tadtools');
define('_TAD_NEED_TADTOOLS','You need tadtools module, go to <a href="http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank" >XOOPS easy frame</a> download.');

//jill_receipt-list
define('_MD_JILLRECEIP_NODATA','No data');
define('_MD_JILLRECEIP_ILLEGAL','illegal invasion');
define('_MD_JILLRECEIP_ACCOUNT_DEF', '94438=Special account for collection of funds');
define('_MD_JILLRECEIP_RSN','Serial number');
define('_MD_JILLRECEIP_CREATE_DATE','Establishment time');
define('_MD_JILLRECEIP_ACCOUNT','Payment account');
define('_MD_JILLRECEIP_UNIT','Subsidy unit');
define('_MD_JILLRECEIP_TITLE','Subsidy reasons');
define('_MD_JILLRECEIP_AMOUNT','Amount');
define('_MD_JILLRECEIP_UID','Applicant');
define('_MD_JILLRECEIP_IN_DATE','Income Date');
define('_MD_JILLRECEIP_TAX_ID','Unified ID');
define('_MD_JILLRECEIP_STATUS','Whether to make orders');
define('_MD_JILLRECEIP_STATUS0','Order not yet prepared');
define('_MD_JILLRECEIP_STATUS1','Order has been prepared');
define('_MD_JILLRECEIP_STATUS2','Already received');
define('_MD_JILLRECEIP_STATUS3','Voided');
define('_MD_JILLRECEIP_NOTE','Note');
define('_MA_JILLRECEIP_CREATE_DATE','Establishment time');
define('_MA_JILLRECEIP_ACCOUNT','Payment account');
define('_MA_JILLRECEIP_USN','Subsidy Unit Number');
define('_MA_JILLRECEIP_UNIT','Subsidy unit');
define('_MA_JILLRECEIP_TITLE','Subsidy reasons');
define('_MA_JILLRECEIP_AMOUNT','Amount');
define('_MA_JILLRECEIP_UID','Applicant');
define('_MA_JILLRECEIP_IN_DATE','Income Date');
define('_MA_JILLRECEIP_TAX_ID','Unified ID');
define('_MD_JILLRECEIP_UNITOPT','Please select a subsidy unit');
define('_MD_JILLRECEIP_SMNAME1','Receipt and fill in home page');
define('_MD_JILLRECEIP_GROUPERROR','Please contact the administrator to add you to the receipt reporting group');
define('_MD_JILLRECEIP_LOGION','Please log in to fill in the receipt');
define('_MD_JILLRECEIP_CHECK','Review list');
