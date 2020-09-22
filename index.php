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
use XoopsModules\Tadtools\Jeditable;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = 'jill_receipt_index.tpl';
include_once XOOPS_ROOT_PATH . "/header.php";

/*-----------功能函數區--------------*/

//jill_receipt編輯表單
function jill_receipt_form($rsn = '', $usn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser, $isAdmin, $xoopsModuleConfig, $can_receipt;
    if (!$can_receipt) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    //抓取預設值
    if (!empty($rsn)) {
        $DBV = get_jill_receipt($rsn);
    } else {
        $DBV = array();
    }

    //預設值設定

    //設定 rsn 欄位的預設值
    $rsn = !isset($DBV['rsn']) ? $rsn : $DBV['rsn'];
    $xoopsTpl->assign('rsn', $rsn);
    //設定 create_date 欄位的預設值
    $create_date = !isset($DBV['create_date']) ? date("Y-m-d H:i:s") : $DBV['create_date'];
    $xoopsTpl->assign('create_date', $create_date);
    //設定 account 欄位的預設值
    $accountArr  = get_jill_account_all();
    $def_account = (!isset($DBV['account'])) ? '94438 ' : $DBV['account'];
    $xoopsTpl->assign('accountArr', $accountArr);
    $xoopsTpl->assign('def_account', $def_account);
    //die(var_dump($accounts));
    //設定 usn 欄位的預設值
    $def_usn = !isset($DBV['usn']) ? '' : $DBV['usn'];
    $xoopsTpl->assign('usn', $usn);

    //補助單位編號
    $sql    = "select `usn`, `unit` from `" . $xoopsDB->prefix("jill_unit") . "` order by sort";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $i      = 0;
    if ($def_usn == "") {
        $usn_options_array[$i]['usn']  = '';
        $usn_options_array[$i]['unit'] = _MD_JILLRECEIP_UNITOPT;
        $i++;
    }
    while (list($usn, $unit) = $xoopsDB->fetchRow($result)) {
        $usn_options_array[$i]['usn']  = $usn;
        $usn_options_array[$i]['unit'] = $unit;
        $i++;
    }

    $xoopsTpl->assign("usn_options", $usn_options_array);
    //設定 title 欄位的預設值
    $title = !isset($DBV['title']) ? '' : $DBV['title'];
    $xoopsTpl->assign('title', $title);
    //設定 amount 欄位的預設值
    $amount = !isset($DBV['amount']) ? '' : $DBV['amount'];
    $xoopsTpl->assign('amount', $amount);
    //設定 uid 欄位的預設值
    $user_uid = $xoopsUser ? $xoopsUser->uid() : "";
    $uid      = !isset($DBV['uid']) ? $user_uid : $DBV['uid'];
    $xoopsTpl->assign('uid', $uid);

    $op = empty($rsn) ? "insert_jill_receipt" : "update_jill_receipt";
    //$op = "replace_jill_receipt";

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
    $xoopsTpl->assign('now_op', 'jill_receipt_form');
    $xoopsTpl->assign('next_op', $op);
}

//以流水號取得某筆jill_receipt資料
function get_jill_receipt($rsn = '')
{
    global $xoopsDB, $isAdmin, $xoopsUser;

    if (empty($rsn)) {
        return;
    }
    $uid   = $xoopsUser->uid();
    $where = ($isAdmin) ? "where `rsn` = '{$rsn}'" : " where `rsn` = '{$rsn}' && `uid`='{$uid}'";
    $sql   = "select * from `" . $xoopsDB->prefix("jill_receipt") . "`
    $where";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $data   = $xoopsDB->fetchArray($result);
    return $data;
}

//新增資料到jill_receipt中
function insert_jill_receipt()
{
    global $xoopsDB, $xoopsUser, $isAdmin, $can_receipt;
    if (!$can_receipt) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    //XOOPS表單安全檢查
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header($_SERVER['PHP_SELF'], 3, $error);
    }

    $myts = \MyTextSanitizer::getInstance();

    $rsn         = intval($_POST['rsn']);
    $create_date = date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));
    $account     = $_POST['account'];
    $usn         = $_POST['usn'];
    $title       = $myts->addSlashes($_POST['title']);
    $amount      = $myts->addSlashes($_POST['amount']);
    //取得使用者編號
    $uid = $xoopsUser->uid();

    $sql = "insert into `" . $xoopsDB->prefix("jill_receipt") . "` (
        `create_date`,
        `account`,
        `usn`,
        `title`,
        `amount`,
        `uid`
    ) values(
        '{$create_date}',
        '{$account}',
        '{$usn}',
        '{$title}',
        '{$amount}',
        '{$uid}'
    )";
    $xoopsDB->query($sql) or Utility::web_error($sql);

    //取得最後新增資料的流水編號
    $rsn = $xoopsDB->getInsertId();

    return $rsn;
}

//更新jill_receipt某一筆資料
function update_jill_receipt($rsn = '')
{
    global $xoopsDB, $isAdmin, $xoopsUser, $can_receipt;
    if (!$can_receipt) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    //XOOPS表單安全檢查
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header($_SERVER['PHP_SELF'], 3, $error);
    }

    $myts = \MyTextSanitizer::getInstance();

    $rsn     = intval($_POST['rsn']);
    $account = $_POST['account'];
    $usn     = $_POST['usn'];
    $title   = $myts->addSlashes($_POST['title']);
    $amount  = $myts->addSlashes($_POST['amount']);
    //取得使用者編號
    $uid = $xoopsUser->uid();

    $sql = "update `" . $xoopsDB->prefix("jill_receipt") . "` set
       `account` = '{$account}',
       `usn` = '{$usn}',
       `title` = '{$title}',
       `amount` = '{$amount}',
       `uid` = '{$uid}'
    where `rsn` = '$rsn' && `uid`='{$uid}' ";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);

    return $rsn;
}

//刪除jill_receipt某筆資料資料
function delete_jill_receipt($rsn = '')
{
    global $xoopsDB, $isAdmin, $xoopsUser, $can_receipt;
    if (!$can_receipt) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    if (empty($rsn)) {
        return;
    }
    //取得使用者編號
    $uid = $xoopsUser->uid();
    $sql = "delete from `" . $xoopsDB->prefix("jill_receipt") . "`
    where `rsn` = '{$rsn}' && `uid`='{$uid}' ";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);

}

//以流水號秀出某筆jill_receipt資料內容
function show_one_jill_receipt($rsn = '')
{
    global $xoopsDB, $xoopsTpl, $isAdmin, $xoopsUser, $can_receipt;

    if (empty($rsn)) {
        return;
    } else {
        $rsn = intval($rsn);
    }
    if (!$can_receipt) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }
    $uid  = $xoopsUser->uid();
    $myts = \MyTextSanitizer::getInstance();

    $where = ($isAdmin) ? "where `rsn` = '{$rsn}'" : " where `rsn` = '{$rsn}' && `uid`='{$uid}'";
    $sql   = "select * from `" . $xoopsDB->prefix("jill_receipt") . "` $where
          ";
    //die($sql);
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $all    = $xoopsDB->fetchArray($result);

    //以下會產生這些變數： $rsn, $create_date, $account, $usn, $title, $amount, $uid, $in_date, $tax_id, $status, $note
    foreach ($all as $k => $v) {
        $$k = $v;
    }

    //取得分類資料(jill_unit)
    $jill_unit_arr = get_jill_unit($usn);
    $accountArr    = get_jill_account_all();
    //將 uid 編號轉換成使用者姓名（或帳號）
    $uid_name = XoopsUser::getUnameFromId($uid, 1);
    if (empty($uid_name)) {
        $uid_name = XoopsUser::getUnameFromId($uid, 0);
    }

    //將製單是/否選項轉換為圖示
    $status_name = get_status_name($status);

    //過濾讀出的變數值
    $title   = $myts->displayTarea($title, 0, 1, 0, 1, 1);
    $amount  = $myts->htmlSpecialChars($amount);
    $in_date = $myts->htmlSpecialChars($in_date);
    $tax_id  = $myts->htmlSpecialChars($tax_id);

    $xoopsTpl->assign('rsn', $rsn);
    $xoopsTpl->assign('create_date', $create_date);
    $xoopsTpl->assign('account', $accountArr[$account]);
    $xoopsTpl->assign('usn_title', $jill_unit_arr['unit']);
    $xoopsTpl->assign('title', nl2br($title));
    $xoopsTpl->assign('amount', $amount);
    $xoopsTpl->assign('uid_name', $uid_name);
    $xoopsTpl->assign('in_date', $in_date);
    $xoopsTpl->assign('tax_id', $tax_id);
    $xoopsTpl->assign('status', $status);
    $xoopsTpl->assign('status_name', $status_name);
    $xoopsTpl->assign('note', $note);

    $sweet_alert_obj          = new SweetAlert();
    $delete_jill_receipt_func = $sweet_alert_obj->render('delete_jill_receipt_func', "{$_SERVER['PHP_SELF']}?op=delete_jill_receipt&rsn=", "rsn");
    $xoopsTpl->assign('delete_jill_receipt_func', $delete_jill_receipt_func);

    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('now_op', 'show_one_jill_receipt');
}

//列出所有jill_receipt資料
function list_jill_receipt()
{
    global $xoopsDB, $xoopsTpl, $xoopsUser, $can_receipt;
    if ($can_receipt) {
        $status = Request::getInt('status');
        $uid    = $xoopsUser->uid();
        $myts   = \MyTextSanitizer::getInstance();
        $sql    = "select * from `" . $xoopsDB->prefix("jill_receipt") . "` where `uid`='{$uid}' order by `status`, `create_date` desc  ";
        //die($sql);
        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql);
        //取得分類所有資料陣列
        $jill_unit_arr = get_jill_unit_all();
        $accountArr    = get_jill_account_all();
        $all_content   = array();
        $i             = 0;
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $rsn, $create_date, $account, $usn, $title, $amount, $uid, $in_date, $tax_id, $status, $note
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            //將 uid 編號轉換成使用者姓名（或帳號）
            $uid_name = XoopsUser::getUnameFromId($uid, 1);
            if (empty($uid_name)) {
                $uid_name = XoopsUser::getUnameFromId($uid, 0);
            }

            //將是/否選項轉換為圖示
            $status_name = get_status_name($status);
            //die($status_name);
            //過濾讀出的變數值
            $title   = $myts->displayTarea($title, 0, 1, 0, 1, 1);
            $amount  = $myts->htmlSpecialChars($amount);
            $in_date = $myts->htmlSpecialChars($in_date);
            $tax_id  = $myts->htmlSpecialChars($tax_id);
            $note    = $myts->htmlSpecialChars($note);

            $all_content[$i]['rsn']         = $rsn;
            $all_content[$i]['create_date'] = $create_date;
            $all_content[$i]['account']     = $accountArr[$account];
            $all_content[$i]['usn']         = $jill_unit_arr[$usn]['unit'];
            $all_content[$i]['title']       = $title;
            $all_content[$i]['amount']      = $amount;
            $all_content[$i]['uid']         = $uid;
            $all_content[$i]['uid_name']    = $uid_name;
            $all_content[$i]['in_date']     = str_replace("0000-00-00", "", $in_date);
            $all_content[$i]['tax_id']      = $tax_id;
            $all_content[$i]['status']      = $status;
            $all_content[$i]['status_name'] = $status_name;
            $all_content[$i]['note']        = $note;
            $i++;
        }

        //刪除確認的JS
        $sweet_alert_obj          = new SweetAlert();
        $delete_jill_receipt_func = $sweet_alert_obj->render('delete_jill_receipt_func',
            "{$_SERVER['PHP_SELF']}?op=delete_jill_receipt&rsn=", "rsn");
        $xoopsTpl->assign('delete_jill_receipt_func', $delete_jill_receipt_func);
    }

    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_jill_receipt');
}
//審核
function check()
{
    global $xoopsDB, $xoopsTpl, $can_manager, $xoopsUser;
    if ($can_manager) {
        $status = Request::getInt('status');
        $myts   = \MyTextSanitizer::getInstance();
        $sql    = "select * from `" . $xoopsDB->prefix("jill_receipt") . "` where `status`='{$status}' order by `status`, `create_date` desc  ";

        $result = $xoopsDB->query($sql) or Utility::web_error($sql);
        $total  = $xoopsDB->getRowsNum($result);

        //取得分類所有資料陣列
        $jill_unit_arr = get_jill_unit_all();
        $accountArr    = get_jill_account_all();
        $all_content   = array();
        $i             = 0;
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $rsn, $create_date, $account, $usn, $title, $amount, $uid, $in_date, $tax_id, $status, $note
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            //將 uid 編號轉換成使用者姓名（或帳號）
            $uid_name = XoopsUser::getUnameFromId($uid, 1);
            if (empty($uid_name)) {
                $uid_name = XoopsUser::getUnameFromId($uid, 0);
            }

            //將是/否選項轉換為圖示
            $status_name = get_status_name($status);
            //die($status_name);
            //過濾讀出的變數值
            $title   = $myts->displayTarea($title, 0, 1, 0, 1, 1);
            $amount  = $myts->htmlSpecialChars($amount);
            $in_date = $myts->htmlSpecialChars($in_date);
            $tax_id  = $myts->htmlSpecialChars($tax_id);
            $note    = $myts->htmlSpecialChars($note);

            $all_content[$i]['rsn']         = $rsn;
            $all_content[$i]['create_date'] = $create_date;
            $all_content[$i]['account']     = $accountArr[$account];
            $all_content[$i]['usn']         = $jill_unit_arr[$usn]['unit'];
            $all_content[$i]['title']       = $title;
            $all_content[$i]['amount']      = $amount;
            $all_content[$i]['uid']         = $uid;
            $all_content[$i]['uid_name']    = $uid_name;
            $all_content[$i]['in_date']     = str_replace("0000-00-00", "", $in_date);
            $all_content[$i]['tax_id']      = $tax_id;
            $all_content[$i]['status']      = $status;
            $all_content[$i]['status_name'] = $status_name;
            $all_content[$i]['note']        = $note;
            $i++;
        }
        $file      = "save_col_val.php";
        $jeditable = new Jeditable();
        $jeditable->setTextCol(".jq_date", $file, '80%', '1.2rem', '', '<span class="placeholder">0000-00-00</span>');
        $jeditable->setTextCol(".jq_tax", $file, '80%', '1.2rem', '', '<span class="placeholder">例A123135465</span>');
        $jeditable->setTextCol(".jq_note", $file, '80%', '1.2rem', '');
        $jeditable->setSelectCol(".jq_select", $file, "{0:'" . _MD_JILLRECEIP_STATUS0 . "' , 1:'" . _MD_JILLRECEIP_STATUS1 . "',2:'" . _MD_JILLRECEIP_STATUS2 . "',3:'" . _MD_JILLRECEIP_STATUS3 . "'}");

        $jeditable->render();
        $statusArr = array(0 => _MD_JILLRECEIP_STATUS0, 1 => _MD_JILLRECEIP_STATUS1, 2 => _MD_JILLRECEIP_STATUS2, 3 => _MD_JILLRECEIP_STATUS3);
        $xoopsTpl->assign('statusArr', $statusArr);
        $xoopsTpl->assign('all_content', $all_content);
        //die(var_dump($all_content));
    }

    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('now_op', 'check');
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

//取得jill_unit所有資料陣列
function get_jill_unit_all()
{
    global $xoopsDB;
    $sql      = "select * from `" . $xoopsDB->prefix("jill_unit") . "`";
    $result   = $xoopsDB->query($sql) or Utility::web_error($sql);
    $data_arr = array();
    while ($data = $xoopsDB->fetchArray($result)) {
        $usn            = $data['usn'];
        $data_arr[$usn] = $data;
    }
    return $data_arr;
}

//取得jill_accpunt所有資料陣列
function get_jill_account_all()
{
    global $xoopsModuleConfig;
    $accountArr = explode(";", $xoopsModuleConfig['account_set']);

    foreach ($accountArr as $k => $account) {
        list($k, $v)  = explode("=", $account);
        $accounts[$k] = $v;
    }
    return $accounts;
}

/*-----------執行動作判斷區----------*/
$op  = Request::getString('op');
$rsn = Request::getInt('rsn');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    //新增資料
    case "insert_jill_receipt":
        $rsn = insert_jill_receipt();
        header("location: {$_SERVER['PHP_SELF']}?rsn=$rsn");
        exit;

    //更新資料
    case "update_jill_receipt":
        update_jill_receipt($rsn);
        header("location: {$_SERVER['PHP_SELF']}?rsn=$rsn");
        exit;

    case "jill_receipt_form":
        jill_receipt_form($rsn);
        break;

    case "delete_jill_receipt":
        delete_jill_receipt($rsn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;
    case "check":
        check();
        break;

    default:
        if (empty($rsn)) {
            list_jill_receipt();
            //$main .= jill_receipt_form($rsn);
        } else {
            show_one_jill_receipt($rsn);
        }
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("toolbar", Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign("isAdmin", $isAdmin);
$xoopsTpl->assign("can_receipt", $can_receipt);
$xoopsTpl->assign("can_manager", $can_manager);
include_once XOOPS_ROOT_PATH . '/footer.php';
