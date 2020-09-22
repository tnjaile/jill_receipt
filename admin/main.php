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
use Xmf\Request;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$isAdmin                      = true;
$xoopsOption['template_main'] = 'jill_receipt_adm_main.tpl';
include_once "header.php";
include_once "../function.php";

/*-----------功能函數區--------------*/

//jill_unit編輯表單
function jill_unit_form($usn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser, $isAdmin;
    if (!$isAdmin) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    //抓取預設值
    if (!empty($usn)) {
        $DBV = get_jill_unit($usn);
    } else {
        $DBV = array();
    }

    //預設值設定

    //設定 usn 欄位的預設值
    $usn = !isset($DBV['usn']) ? $usn : $DBV['usn'];
    $xoopsTpl->assign('usn', $usn);
    //設定 unit 欄位的預設值
    $unit = !isset($DBV['unit']) ? '' : $DBV['unit'];
    $xoopsTpl->assign('unit', $unit);
    //設定 unit_code 欄位的預設值
    $unit_code = !isset($DBV['unit_code']) ? '' : $DBV['unit_code'];
    $xoopsTpl->assign('unit_code', $unit_code);
    //設定 sort 欄位的預設值
    $sort = !isset($DBV['sort']) ? jill_unit_max_sort() : $DBV['sort'];
    $xoopsTpl->assign('sort', $sort);

    $op = empty($usn) ? "insert_jill_unit" : "update_jill_unit";
    //$op = "replace_jill_unit";

    //套用formValidator驗證機制
    $formValidator      = new FormValidator("#myForm", true);
    $formValidator_code = $formValidator->render();

    //加入Token安全機制
    include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
    $token      = new \XoopsFormHiddenToken();
    $token_form = $token->render();
    $xoopsTpl->assign("token_form", $token_form);
    $xoopsTpl->assign('action', $_SERVER["PHP_SELF"]);
    $xoopsTpl->assign('formValidator_code', $formValidator_code);
    $xoopsTpl->assign('now_op', 'jill_unit_form');
    $xoopsTpl->assign('next_op', $op);
}

//自動取得jill_unit的最新排序
function jill_unit_max_sort()
{
    global $xoopsDB;
    $sql        = "select max(`sort`) from `" . $xoopsDB->prefix("jill_unit") . "`";
    $result     = $xoopsDB->query($sql) or Utility::web_error($sql);
    list($sort) = $xoopsDB->fetchRow($result);
    return ++$sort;
}

//以流水號取得某筆jill_unit資料
function get_jill_unit($usn = '')
{
    global $xoopsDB;

    if (empty($usn)) {
        return;
    }

    $sql = "select * from `" . $xoopsDB->prefix("jill_unit") . "`
    where `usn` = '{$usn}'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $data   = $xoopsDB->fetchArray($result);
    return $data;
}

//新增資料到jill_unit中
function insert_jill_unit()
{
    global $xoopsDB, $xoopsUser, $isAdmin;
    if (!$isAdmin) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    //XOOPS表單安全檢查
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header($_SERVER['PHP_SELF'], 3, $error);
    }

    $myts = \MyTextSanitizer::getInstance();

    $usn       = intval($_POST['usn']);
    $unit      = $myts->addSlashes($_POST['unit']);
    $unit_code = $myts->addSlashes($_POST['unit_code']);
    $sort      = intval($_POST['sort']);

    $sql = "insert into `" . $xoopsDB->prefix("jill_unit") . "` (
        `unit`,
        `unit_code`,
        `sort`
    ) values(
        '{$unit}',
        '{$unit_code}',
        '{$sort}'
    )";
    $xoopsDB->query($sql) or Utility::web_error($sql);

    //取得最後新增資料的流水編號
    $usn = $xoopsDB->getInsertId();

    return $usn;
}

//更新jill_unit某一筆資料
function update_jill_unit($usn = '')
{
    global $xoopsDB, $isAdmin, $xoopsUser;
    if (!$isAdmin) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    //XOOPS表單安全檢查
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header($_SERVER['PHP_SELF'], 3, $error);
    }

    $myts = \MyTextSanitizer::getInstance();

    $usn       = intval($_POST['usn']);
    $unit      = $myts->addSlashes($_POST['unit']);
    $unit_code = $myts->addSlashes($_POST['unit_code']);
    $sort      = intval($_POST['sort']);

    $sql = "update `" . $xoopsDB->prefix("jill_unit") . "` set
       `unit` = '{$unit}',
       `unit_code` = '{$unit_code}',
       `sort` = '{$sort}'
    where `usn` = '$usn'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);

    return $usn;
}

//刪除jill_unit某筆資料資料
function delete_jill_unit($usn = '')
{
    global $xoopsDB, $isAdmin;
    if (!$isAdmin) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    if (empty($usn)) {
        return;
    }

    $sql = "delete from `" . $xoopsDB->prefix("jill_unit") . "`
    where `usn` = '{$usn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);

}

//以流水號秀出某筆jill_unit資料內容
function show_one_jill_unit($usn = '')
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    if (empty($usn)) {
        return;
    } else {
        $usn = intval($usn);
    }

    $myts = \MyTextSanitizer::getInstance();

    $sql = "select * from `" . $xoopsDB->prefix("jill_unit") . "`
    where `usn` = '{$usn}' ";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $all    = $xoopsDB->fetchArray($result);

    //以下會產生這些變數： $usn, $unit, $unit_code, $sort
    foreach ($all as $k => $v) {
        $$k = $v;
    }

    //過濾讀出的變數值
    $unit      = $myts->htmlSpecialChars($unit);
    $unit_code = $myts->htmlSpecialChars($unit_code);

    $xoopsTpl->assign('usn', $usn);
    $xoopsTpl->assign('unit', $unit);
    $xoopsTpl->assign('unit_code', $unit_code);
    $xoopsTpl->assign('sort', $sort);

    $sweet_alert_obj       = new SweetAlert();
    $delete_jill_unit_func = $sweet_alert_obj->render('delete_jill_unit_func', "{$_SERVER['PHP_SELF']}?op=delete_jill_unit&usn=", "usn");
    $xoopsTpl->assign('delete_jill_unit_func', $delete_jill_unit_func);

    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('now_op', 'show_one_jill_unit');
}

//列出所有jill_unit資料
function list_jill_unit()
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    $myts = \MyTextSanitizer::getInstance();

    $sql = "select * from `" . $xoopsDB->prefix("jill_unit") . "` order by `sort`";

    //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = Utility::getPageBar($sql, 20, 10);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];

    $result = $xoopsDB->query($sql) or Utility::web_error($sql);

    $all_content = array();
    $i           = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： $usn, $unit, $unit_code, $sort
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        //過濾讀出的變數值
        $unit      = $myts->htmlSpecialChars($unit);
        $unit_code = $myts->htmlSpecialChars($unit_code);

        $all_content[$i]['usn']       = $usn;
        $all_content[$i]['unit']      = $unit;
        $all_content[$i]['unit_code'] = $unit_code;
        $all_content[$i]['sort']      = $sort;
        $i++;
    }

    //刪除確認的JS
    $sweet_alert_obj       = new SweetAlert();
    $delete_jill_unit_func = $sweet_alert_obj->render('delete_jill_unit_func',
        "{$_SERVER['PHP_SELF']}?op=delete_jill_unit&usn=", "usn");
    $xoopsTpl->assign('delete_jill_unit_func', $delete_jill_unit_func);

    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('isAdmin', $isAdmin);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_jill_unit');
}

/*-----------執行動作判斷區----------*/
$op  = Request::getString('op');
$rsn = Request::getInt('rsn');
$usn = Request::getInt('usn');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    //替換資料
    //case "replace_jill_unit":
    //    replace_jill_unit();
    //    header("location: {$_SERVER['PHP_SELF']}?usn=$usn");
    //    exit;
    //break;

    //新增資料
    case "insert_jill_unit":
        $usn = insert_jill_unit();
        header("location: {$_SERVER['PHP_SELF']}?usn=$usn");
        exit;

    //更新資料
    case "update_jill_unit":
        update_jill_unit($usn);
        header("location: {$_SERVER['PHP_SELF']}?usn=$usn");
        exit;

    case "jill_unit_form":
        jill_unit_form($usn);
        break;

    case "delete_jill_unit":
        delete_jill_unit($usn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //更新排序
    case "update_jill_unit_sort":
        $msg = update_jill_unit_sort();
        die($msg);
        break;

    default:
        if (empty($usn)) {
            list_jill_unit();
            //$main .= jill_unit_form($usn);
        } else {
            show_one_jill_unit($usn);
        }
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin", true);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
include_once 'footer.php';
