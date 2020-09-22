<div class="container-fluid">

<!--顯示表單-->
<{if $now_op=="jill_unit_form"}>
  <{includeq file="$xoops_rootpath/modules/jill_receipt/templates/jill_unit_edit_form.tpl"}>
<{/if}>

<!--顯示某一筆資料-->
<{if $now_op=="show_one_jill_unit"}>
  <{if $isAdmin}>
    <{$delete_jill_unit_func}>
  <{/if}>
  <h2 class="text-center"><{$unit}></h2>


  <!--單位代碼-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_JILLRECEIP_UNIT_CODE}>
    </label>
    <div class="col-sm-9">
      <{$unit_code}>
    </div>
  </div>

  <div class="text-right">
    <{if $isAdmin}>
      <a href="javascript:delete_jill_unit_func(<{$usn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
      <a href="<{$xoops_url}>/modules/jill_receipt/admin/main.php?op=jill_unit_form&usn=<{$usn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
      <a href="<{$xoops_url}>/modules/jill_receipt/admin/main.php?op=jill_unit_form" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$action}>" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
  </div>
<{/if}>

<!--列出所有資料-->
<{if $now_op=="list_jill_unit"}>
  <{includeq file="$xoops_rootpath/modules/jill_receipt/templates/jill_unit_list.tpl"}>
<{/if}>

</div>