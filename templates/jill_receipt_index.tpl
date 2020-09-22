<{$toolbar}>


<!--顯示表單-->
<{if $now_op=="jill_receipt_form"}>
  <{includeq file="$xoops_rootpath/modules/jill_receipt/templates/jill_receipt_edit_form.tpl"}>
<{/if}>

<!--顯示某一筆資料-->
<{if $now_op=="show_one_jill_receipt"}>
  <{if $isAdmin}>
    <{$delete_jill_receipt_func}>
  <{/if}>

  <!--入款帳戶-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_JILLRECEIP_ACCOUNT}>
    </label>
    <div class="col-sm-9">
      <{$account}>
    </div>
  </div>

  <!--補助單位-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_JILLRECEIP_UNIT}>
    </label>
    <div class="col-sm-9">
      <{$usn_title}>
    </div>
  </div>

  <!--補助事由-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_JILLRECEIP_TITLE}>
    </label>
    <div class="col-sm-9">

      <div class="well">
        <{$title}>
      </div>
    </div>
  </div>

  <!--金額-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_JILLRECEIP_AMOUNT}>
    </label>
    <div class="col-sm-9">
      <{$amount}>
    </div>
  </div>

  <!--申請人員-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_JILLRECEIP_UID}>
    </label>
    <div class="col-sm-9">
      <{$uid_name}>
    </div>
  </div>
  <{if $isAdmin}>
    <!--收入日期-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLRECEIP_IN_DATE}>
      </label>
      <div class="col-sm-9">
        <{$in_date}>
      </div>
    </div>

    <!--統一編號-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLRECEIP_TAX_ID}>
      </label>
      <div class="col-sm-9">
        <{$tax_id}>
      </div>
    </div>
  <{/if}>

  <div class="text-right">
    <{if $xoops_isuser}>
      <{if $status=='0' ||$status==''}>
        <a href="javascript:delete_jill_receipt_func(<{$rsn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/jill_receipt/index.php?op=jill_receipt_form&rsn=<{$rsn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
      <{/if}>
      <a href="<{$xoops_url}>/modules/jill_receipt/index.php?op=jill_receipt_form" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$action}>" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
  </div>
<{/if}>

<!--列出所有資料-->
<{if $now_op=="list_jill_receipt"}>
  <{if $can_manager}>
    <div class="text-right" style="margin:10px 0px;">
      <a href="<{$xoops_url}>/modules/jill_receipt/index.php?op=check" class="btn btn-success btn-sm"><i class="fa fa-check-square-o" aria-hidden="true"></i> <{$smarty.const._MD_JILLRECEIP_CHECK}></a>
    </div>
  <{/if}>
  <{includeq file="$xoops_rootpath/modules/jill_receipt/templates/jill_receipt_list.tpl"}>
<{/if}>

<!--列出所有審核資料-->
<{if $now_op=="check"}>
  <div class="text-right" style="margin:10px 0px;">
    <a href="<{$xoops_url}>/modules/jill_receipt/index.php" class="btn btn-info btn-sm"><i class="fa fa-reply" aria-hidden="true"></i> <{$smarty.const._TAD_HOME}>
    </a>
  </div>
  <{if $can_manager}>
    <div id="jill_receipt_save_msg"></div>
    <{$jeditable_set}>
    <script type='text/javascript'>

      $('[data-toggle="tabajax"]').click(function(e) {
        var $this = $(this),
            loadurl = $this.attr('href'),
            targ = $this.attr('data-target');
        $.get(loadurl, function(data) {
            $(targ).html(data);
        });

        $this.tab('show');

        return false;
      });

    </script>
    <style type="text/css" media="screen">
      .placeholder { color: gray }
      .jq_select,.jq_date,.jq_tax,.jq_show{background-color:rgba(241, 204, 155,0.5)}
    </style>

    <ul class="nav nav-tabs" id="my_status">
      <{foreach from=$statusArr key=k item=status}>
        <{if $k==0}>
          <li class="active"><a href="<{$xoops_url}>/modules/jill_receipt/index.php?op=check" data-target="#show_status_<{$k}>" data-toggle="tabajax"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <{$status}></a></li>
        <{else}>
          <li><a href="<{$xoops_url}>/modules/jill_receipt/index.php?op=check&status=<{$k}>" data-target="#show_status_<{$k}>" data-toggle="tabajax"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <{$status}></a></li>
        <{/if}>
      <{/foreach}>
    </ul>

    <{if $k==0}>
      <{if $total=='0'}>
        <div class="jumbotron text-center">
          <h3><{$smarty.const._MD_JILLRECEIP_NODATA}></h3>
        </div>
      <{else}>
        <div id="show_status_<{$k}>"  class="tab-pane active">
            <{includeq file="$xoops_rootpath/modules/jill_receipt/templates/jill_receipt_table.tpl"}>
        </div>
      <{/if}>
    <{else}>
      <div id="show_status_<{$k}>"  class="tab-pane"  >
        <{includeq file="$xoops_rootpath/modules/jill_receipt/templates/jill_receipt_table.tpl"}>
      </div>
    <{/if}>
  <{/if}>
<{/if}>