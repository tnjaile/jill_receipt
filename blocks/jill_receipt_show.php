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
use XoopsModules\Tadtools\Utility;

//區塊主函式 (jill_receipt_show)
function jill_receipt_show()
{
    global $xoopsDB;

    $myts = \MyTextSanitizer::getInstance();
    $sql  = "select * from `" . $xoopsDB->prefix("jill_receipt") . "`
          where `status`='1' order by `create_date`";
    //die($sql);
    $result           = $xoopsDB->query($sql) or Utility::web_error($sql);
    $block['content'] = array();
    $i                = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： rsn,create_date,account,usn,title,amount,uid,in_date,tax_id,status,note
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        $uid_name = XoopsUser::getUnameFromId($uid, 1);
        if (empty($uid_name)) {
            $uid_name = XoopsUser::getUnameFromId($uid, 0);
        }
        //過濾讀出的變數值
        $title                            = $myts->htmlSpecialChars($title);
        $block['content'][$i]['rsn']      = $rsn;
        $block['content'][$i]['title']    = $title;
        $block['content'][$i]['uid_name'] = $uid_name;
        $i++;
    }
    return $block;
}
